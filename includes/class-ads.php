<?php
/**
 * AdSense slots that never move the page.
 *
 * Off: nothing is printed, so no space is reserved.
 * On:  each slot is a box with a fixed min-height and no border or colour; if Google has no ad,
 *      the space simply stays empty, so content below never jumps (CLS stays 0).
 *
 * @package MyZakatTool
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MYZT_Ads {

	private static $script_added = false;

	public static function init() {
		add_shortcode( 'myzt_ad', array( __CLASS__, 'shortcode' ) );
		add_filter( 'the_content', array( __CLASS__, 'in_article' ), 20 );
	}

	public static function enabled() {
		$s = MYZT_Settings::get();
		return ! empty( $s['ads_enabled'] ) && ! empty( $s['ads_client'] );
	}

	public static function shortcode( $atts ) {
		$a = shortcode_atts( array( 'slot' => 'article' ), $atts, 'myzt_ad' );
		return self::slot( sanitize_key( $a['slot'] ) );
	}

	/** $where: calc | article | sidebar */
	public static function slot( $where ) {
		if ( ! self::enabled() || is_admin() || is_feed() ) {
			return '';
		}
		$s  = MYZT_Settings::get();
		$id = isset( $s[ 'ad_slot_' . $where ] ) ? $s[ 'ad_slot_' . $where ] : '';
		if ( ! $id ) {
			return '';
		}
		self::add_script();
		$label = ! empty( $s['ads_label'] ) ? '<span class="myzt-ad-label">Advertisement</span>' : '';
		$fmt   = 'sidebar' === $where ? 'data-ad-format="vertical"' : 'data-ad-format="auto" data-full-width-responsive="true"';
		return '<div class="myzt-ad myzt-ad-' . esc_attr( $where ) . '">' . $label .
			'<ins class="adsbygoogle" style="display:block" data-ad-client="' . esc_attr( $s['ads_client'] ) . '" data-ad-slot="' . esc_attr( $id ) . '" ' . $fmt . '></ins>' .
			'<script>(adsbygoogle=window.adsbygoogle||[]).push({});</script></div>';
	}

	private static function add_script() {
		if ( self::$script_added ) {
			return;
		}
		self::$script_added = true;
		$client = MYZT_Settings::get( 'ads_client' );
		add_action(
			'wp_footer',
			function () use ( $client ) {
				echo '<script async src="' . esc_url( 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=' . rawurlencode( $client ) ) . '" crossorigin="anonymous"></script>' . "\n";
			},
			5
		);
	}

	/** One ad after the 3rd heading of long posts and guides (never on calculator pages). */
	public static function in_article( $content ) {
		if ( ! self::enabled() || ! is_singular( 'post' ) || ! in_the_loop() || ! is_main_query() ) {
			return $content;
		}
		if ( false !== strpos( $content, 'data-widget="calculator"' ) ) {
			return $content;
		}
		$parts = preg_split( '/(<h2[^>]*>)/i', $content, -1, PREG_SPLIT_DELIM_CAPTURE );
		if ( count( $parts ) < 7 ) {
			return $content;
		}
		$out = '';
		$h   = 0;
		foreach ( $parts as $part ) {
			if ( preg_match( '/^<h2/i', $part ) ) {
				++$h;
				if ( 3 === $h ) {
					$out .= self::slot( 'article' );
				}
			}
			$out .= $part;
		}
		return $out;
	}
}
