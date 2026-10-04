<?php
/**
 * Shortcodes, assets and small content blocks.
 *
 * @package MyZakatTool
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MYZT_Frontend {

	private static $needs_assets = false;

	public static function init() {
		add_shortcode( 'zakat_calculator', array( __CLASS__, 'calculator' ) );
		add_shortcode( 'zakat_gold_rate', array( __CLASS__, 'gold_rate' ) );
		add_shortcode( 'zakat_nisab', array( __CLASS__, 'nisab' ) );
		add_shortcode( 'zakat_fitrana', array( __CLASS__, 'fitrana' ) );
		add_shortcode( 'zakat_fidya', array( __CLASS__, 'fidya' ) );
		add_shortcode( 'zakat_khums', array( __CLASS__, 'khums' ) );
		add_shortcode( 'myzt_faq', array( __CLASS__, 'faq' ) );
		add_shortcode( 'myzt_author', array( __CLASS__, 'author' ) );
		add_shortcode( 'myzt_answer', array( __CLASS__, 'answer' ) );
		add_shortcode( 'myzt_related', array( __CLASS__, 'related' ) );
		add_shortcode( 'myzt_trust', array( __CLASS__, 'trust' ) );
		add_shortcode( 'myzt_year', array( __CLASS__, 'year' ) );
		add_shortcode( 'myzt_rate', array( __CLASS__, 'rate_inline' ) );
		add_shortcode( 'myzt_reviewed', array( __CLASS__, 'reviewed' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'register_assets' ) );
		add_action( 'wp_footer', array( __CLASS__, 'late_enqueue' ), 1 );
	}

	public static function register_assets() {
		$v   = MYZAKATTOOL_VERSION;
		$url = MYZAKATTOOL_URL . 'assets/';
		wp_register_style( 'myzt', $url . 'css/app.css', array(), $v );
		wp_register_script( 'myzt-engine', $url . 'js/engine.js', array(), $v, true );
		wp_register_script( 'myzt-pdf', $url . 'js/pdf.js', array(), $v, true );
		wp_register_script( 'myzt-app', $url . 'js/app.js', array( 'myzt-engine', 'myzt-pdf' ), $v, true );

		// Load the stylesheet in <head> on our pages to avoid a flash of unstyled content.
		if ( is_singular() ) {
			$post = get_post();
			if ( $post && preg_match( '/\[(zakat_|myzt_)/', $post->post_content ) ) {
				wp_enqueue_style( 'myzt' );
			}
		}
	}

	private static function enqueue() {
		self::$needs_assets = true;
		wp_enqueue_style( 'myzt' );
	}

	public static function late_enqueue() {
		if ( ! self::$needs_assets ) {
			return;
		}
		wp_enqueue_script( 'myzt-app' );
		wp_add_inline_script( 'myzt-engine', 'window.MYZT=' . wp_json_encode( self::config() ) . ';', 'before' );
	}

	/** Data handed to the browser: rates, currency list, links. No user data. */
	public static function config() {
		$s     = MYZT_Settings::get();
		$rates = MYZT_Rates::payload();
		if ( (float) $s['gold_override'] > 0 ) {
			$rates['goldUsdOz'] = (float) $s['gold_override'];
			$rates['source']    = 'manual';
			$rates['updated']   = time();
		}
		if ( (float) $s['silver_override'] > 0 ) {
			$rates['silverUsdOz'] = (float) $s['silver_override'];
		}
		$country = '';
		if ( ! empty( $_SERVER['HTTP_CF_IPCOUNTRY'] ) ) {
			$country = strtoupper( substr( sanitize_text_field( wp_unslash( $_SERVER['HTTP_CF_IPCOUNTRY'] ) ), 0, 2 ) );
		}
		return array(
			'rates'      => $rates,
			'country'    => $country,
			'currencies' => MYZT_Rates::currencies(),
			'restUrl'    => esc_url_raw( rest_url( 'myzakattool/v1/rates' ) ),
			'jspdfUrl'   => MYZAKATTOOL_URL . 'assets/vendor/jspdf.umd.min.js?ver=4.2.1',
			'siteUrl'    => home_url( '/' ),
			'email'      => $s['contact_email'],
			'urls'       => array(
				'disclaimer'  => self::page_url( 'disclaimer' ),
				'methodology' => self::page_url( 'methodology' ),
				'khums'       => self::page_url( 'khums-calculator' ),
			),
			'fitrana'    => array(
				'currency' => $s['fitrana_currency'],
				'wheat'    => $s['fitrana_wheat'],
				'barley'   => $s['fitrana_barley'],
				'dates'    => $s['fitrana_dates'],
				'raisins'  => $s['fitrana_raisins'],
				'note'     => $s['fitrana_note'],
			),
		);
	}

	public static function page_url( $slug ) {
		$p = get_page_by_path( $slug );
		return $p ? get_permalink( $p ) : home_url( '/' . $slug . '/' );
	}

	private static function widget( $name, $atts, $inner = '' ) {
		self::enqueue();
		$data = '';
		foreach ( $atts as $k => $v ) {
			if ( '' !== $v && null !== $v ) {
				$data .= ' data-' . esc_attr( $k ) . '="' . esc_attr( $v ) . '"';
			}
		}
		$wide = 'calculator' === $name ? ' alignwide' : '';
		return '<div class="myzt myzt-' . esc_attr( $name ) . $wide . '" data-widget="' . esc_attr( $name ) . '"' . $data . '>' . $inner .
			'<noscript><p>' . esc_html__( 'Please enable JavaScript to use the calculator.', 'myzakattool' ) . '</p></noscript></div>';
	}

	public static function calculator( $atts ) {
		$a = shortcode_atts( array( 'madhab' => '', 'compare' => '' ), $atts, 'zakat_calculator' );
		$a['madhab'] = sanitize_key( $a['madhab'] );
		return self::widget( 'calculator', array( 'madhab' => $a['madhab'], 'compare' => sanitize_key( $a['compare'] ) ) ) . self::ad_after_calculator();
	}

	private static function ad_after_calculator() {
		return MYZT_Ads::slot( 'calc' );
	}

	/** Server-rendered table so the numbers are in the HTML for search engines; JS adds currency switching. */
	private static function prices_for( $currency ) {
		$r  = self::config()['rates'];
		$fx = 'USD' === $currency ? 1 : ( isset( $r['fx'][ strtolower( $currency ) ] ) ? (float) $r['fx'][ strtolower( $currency ) ] : 0 );
		if ( empty( $r['goldUsdOz'] ) || ! $fx ) {
			return null;
		}
		return array(
			'gold'    => $r['goldUsdOz'] * $fx / 31.1034768,
			'silver'  => $r['silverUsdOz'] * $fx / 31.1034768,
			'updated' => $r['updated'],
		);
	}

	private static function money( $v, $cur ) {
		return $cur . ' ' . number_format( round( $v ) );
	}

	public static function gold_rate( $atts ) {
		$a   = shortcode_atts( array( 'currency' => 'PKR' ), $atts, 'zakat_gold_rate' );
		$cur = strtoupper( preg_replace( '/[^A-Za-z]/', '', $a['currency'] ) );
		$p   = self::prices_for( $cur );
		$in  = '';
		if ( $p ) {
			$rows = '';
			foreach ( array( 24, 22, 21, 18 ) as $k ) {
				$g     = $p['gold'] * $k / 24;
				$rows .= '<tr><td>' . $k . 'K</td><td>' . esc_html( self::money( $g, $cur ) ) . '</td><td>' . esc_html( self::money( $g * 11.6638038, $cur ) ) . '</td><td>' . esc_html( self::money( $g * 31.1034768, $cur ) ) . '</td></tr>';
			}
			$rows .= '<tr><td>Silver</td><td>' . esc_html( self::money( $p['silver'], $cur ) ) . '</td><td>' . esc_html( self::money( $p['silver'] * 11.6638038, $cur ) ) . '</td><td>' . esc_html( self::money( $p['silver'] * 31.1034768, $cur ) ) . '</td></tr>';
			$in = '<div class="myzt-card"><div class="myzt-scroll"><table class="myzt-table"><thead><tr><th>Purity</th><th>per gram</th><th>per tola</th><th>per ounce</th></tr></thead><tbody>' . $rows . '</tbody></table></div><p class="myzt-small">Updated ' . esc_html( wp_date( 'j M Y, H:i', $p['updated'] ) ) . ' · international spot rate</p></div>';
		}
		return self::widget( 'goldrate', array( 'currency' => $cur ), $in );
	}

	public static function nisab( $atts ) {
		$a   = shortcode_atts( array( 'currency' => 'PKR' ), $atts, 'zakat_nisab' );
		$cur = strtoupper( preg_replace( '/[^A-Za-z]/', '', $a['currency'] ) );
		$p   = self::prices_for( $cur );
		$in  = '';
		if ( $p ) {
			$in = '<div class="myzt-card"><table class="myzt-table"><thead><tr><th>Nisab</th><th>Weight</th><th>Value</th></tr></thead><tbody>' .
				'<tr><td>Silver</td><td>612.36 g · 52.5 tola</td><td class="z">' . esc_html( self::money( $p['silver'] * 612.36, $cur ) ) . '</td></tr>' .
				'<tr><td>Gold</td><td>87.48 g · 7.5 tola</td><td class="z">' . esc_html( self::money( $p['gold'] * 87.48, $cur ) ) . '</td></tr>' .
				'</tbody></table><p class="myzt-small">Updated ' . esc_html( wp_date( 'j M Y, H:i', $p['updated'] ) ) . ' · international spot rate</p></div>';
		}
		return self::widget( 'nisab', array( 'currency' => $cur ), $in );
	}

	/** [myzt_rate type="gold-tola" currency="PKR"]: one live number inside text. */
	public static function rate_inline( $atts ) {
		$a   = shortcode_atts( array( 'type' => 'gold-tola', 'currency' => 'PKR' ), $atts, 'myzt_rate' );
		$cur = strtoupper( preg_replace( '/[^A-Za-z]/', '', $a['currency'] ) );
		$p   = self::prices_for( $cur );
		if ( ! $p ) {
			return '—';
		}
		$map = array(
			'gold-tola'    => $p['gold'] * 11.6638038,
			'gold-gram'    => $p['gold'],
			'gold22-tola'  => $p['gold'] * 22 / 24 * 11.6638038,
			'silver-tola'  => $p['silver'] * 11.6638038,
			'silver-gram'  => $p['silver'],
			'nisab-silver' => $p['silver'] * 612.36,
			'nisab-gold'   => $p['gold'] * 87.48,
			'gold-tola-zakat'   => $p['gold'] * 11.6638038 * 0.025,
			'gold22-tola-zakat' => $p['gold'] * 22 / 24 * 11.6638038 * 0.025,
		);
		$v = isset( $map[ $a['type'] ] ) ? $map[ $a['type'] ] : 0;
		return esc_html( self::money( $v, $cur ) );
	}

	public static function fitrana() {
		return self::widget( 'fitrana', array() );
	}

	/** [myzt_reviewed rates="1"]: "Rules last reviewed" date and, optionally, a dated snapshot of the rates used. */
	public static function reviewed( $atts ) {
		$a    = shortcode_atts( array( 'rates' => '0' ), $atts, 'myzt_reviewed' );
		$s    = MYZT_Settings::get();
		$date = strtotime( $s['rules_reviewed'] . ' 12:00:00' );
		$who  = $s['author_name'] . ( $s['reviewer'] ? ' and ' . $s['reviewer'] : '' );
		$h    = '<p class="myzt-reviewed" style="font-size:13px;color:#5d736e;border-top:1px solid #dfe9e6;padding-top:8px">';
		if ( $date ) {
			$h .= 'Rules last reviewed: <time datetime="' . esc_attr( gmdate( 'Y-m-d', $date ) ) . '">' . esc_html( wp_date( 'j F Y', $date ) ) . '</time> by ' . esc_html( $who ) . '. ';
		}
		$r = MYZT_Rates::payload();
		if ( '1' === $a['rates'] && $r['goldUsdOz'] && $r['updated'] ) {
			$pkr = isset( $r['fx']['pkr'] ) ? (float) $r['fx']['pkr'] : 0;
			$h  .= 'Rates on this page: gold $' . esc_html( number_format( $r['goldUsdOz'], 2 ) ) . '/oz, silver $' . esc_html( number_format( $r['silverUsdOz'], 2 ) ) . '/oz' .
				( $pkr ? ', 1 USD = ' . esc_html( number_format( $pkr, 2 ) ) . ' PKR' : '' ) .
				', updated <time datetime="' . esc_attr( gmdate( 'c', $r['updated'] ) ) . '">' . esc_html( wp_date( 'j M Y, H:i T', $r['updated'] ) ) . '</time>' .
				( $r['source'] ? ' (' . esc_html( $r['source'] ) . ')' : '' ) . '.';
		}
		return $h . '</p>';
	}

	public static function fidya() {
		return self::widget( 'fidya', array() );
	}

	public static function khums() {
		return self::widget( 'khums', array() );
	}

	public static function year() {
		return esc_html( (string) MYZT_Installer::season_year() );
	}

	/** FAQ from the page's _myzt_faq meta; the same data feeds the FAQPage schema. */
	public static function faq() {
		$faq = self::faq_items( get_the_ID() );
		if ( ! $faq ) {
			return '';
		}
		self::enqueue();
		$h = '<div class="myzt myzt-faq">';
		foreach ( $faq as $item ) {
			$h .= '<details><summary>' . esc_html( $item['q'] ) . '</summary><p>' . wp_kses_post( $item['a'] ) . '</p></details>';
		}
		return $h . '</div>';
	}

	public static function faq_items( $post_id ) {
		$raw = get_post_meta( $post_id, '_myzt_faq', true );
		$faq = is_string( $raw ) ? json_decode( $raw, true ) : $raw;
		return is_array( $faq ) ? array_values(
			array_filter(
				$faq,
				function ( $i ) {
					return ! empty( $i['q'] ) && ! empty( $i['a'] );
				}
			)
		) : array();
	}

	public static function author() {
		self::enqueue();
		$s        = MYZT_Settings::get();
		$post     = get_post();
		$modified = $post ? get_the_modified_date( 'j F Y', $post ) : '';
		$initials = strtoupper( substr( $s['author_name'], 0, 1 ) );
		$name     = $s['author_url'] ? '<a href="' . esc_url( $s['author_url'] ) . '" rel="author noopener" target="_blank">' . esc_html( $s['author_name'] ) . '</a>' : esc_html( $s['author_name'] );
		$review   = $s['reviewer'] ? ' · <b>Reviewed by</b> ' . esc_html( $s['reviewer'] ) : '';
		return '<div class="myzt myzt-author"><span class="av" aria-hidden="true">' . esc_html( $initials ) . '</span><div><b>Written by</b> ' . $name . $review .
			' · Updated ' . esc_html( $modified ) . ' · <a href="' . esc_url( self::page_url( 'methodology' ) ) . '">How we calculate</a> · <a href="mailto:' . esc_attr( $s['contact_email'] ) . '">' . esc_html( $s['contact_email'] ) . '</a></div></div>';
	}

	public static function answer( $atts, $content = '' ) {
		self::enqueue();
		$a = shortcode_atts( array( 'q' => '' ), $atts, 'myzt_answer' );
		return '<div class="myzt myzt-answer"><div class="k">Quick answer</div><p><b>' . esc_html( $a['q'] ) . '</b> ' . wp_kses_post( do_shortcode( $content ) ) . '</p></div>';
	}

	public static function trust() {
		self::enqueue();
		$s     = MYZT_Settings::get();
		$items = array( '✓ Sources cited for every madhab', '✓ Your data stays on your device', '✓ Live gold &amp; silver rates' );
		if ( $s['reviewer'] ) {
			$items[] = '✓ Reviewed by ' . esc_html( $s['reviewer'] );
		}
		return '<ul class="myzt myzt-trust"><li>' . implode( '</li><li>', $items ) . '</li></ul>';
	}

	/** [myzt_related slugs="a,b,c,d"]: internal links to related pages. */
	public static function related( $atts ) {
		self::enqueue();
		$a     = shortcode_atts( array( 'slugs' => '' ), $atts, 'myzt_related' );
		$pages = MYZT_Installer::pages();
		$out   = '';
		foreach ( array_filter( array_map( 'trim', explode( ',', $a['slugs'] ) ) ) as $slug ) {
			if ( empty( $pages[ $slug ] ) ) {
				continue;
			}
			$url = self::page_url( $slug );
			if ( get_queried_object_id() && untrailingslashit( get_permalink( get_queried_object_id() ) ) === untrailingslashit( $url ) ) {
				continue;
			}
			$out .= '<a href="' . esc_url( $url ) . '">' . esc_html( $pages[ $slug ]['nav'] ) . '<small>' . esc_html( $pages[ $slug ]['blurb'] ) . '</small></a>';
		}
		return $out ? '<nav class="myzt myzt-related" aria-label="Related">' . $out . '</nav>' : '';
	}
}
