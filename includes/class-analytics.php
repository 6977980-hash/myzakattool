<?php
/**
 * Google Analytics 4 (gtag.js) on every front-end page.
 *
 * The measurement ID lives in one place, MYZAKATTOOL_GA_ID (filter: myzt_ga_id; empty turns it off).
 * Logged-in editors and admins are not counted. To keep page speed, the head only gets a tiny
 * inline queue; Google's script itself is added async after the page has finished loading, so it
 * never competes with the page's own CSS, fonts or calculators (LCP and INP stay as they were).
 * Hits sent before the script arrives wait in dataLayer and are not lost.
 *
 * @package MyZakatTool
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MYZT_Analytics {

	public static function init() {
		add_action( 'wp_head', array( __CLASS__, 'tag' ), 3 );
	}

	public static function id() {
		$id = (string) apply_filters( 'myzt_ga_id', MYZAKATTOOL_GA_ID );
		return preg_match( '/^G-[A-Z0-9]+$/', $id ) ? $id : '';
	}

	public static function tag() {
		$id = self::id();
		if ( ! $id || is_admin() || is_feed() || is_preview() || current_user_can( 'edit_posts' ) ) {
			return;
		}
		$src = 'https://www.googletagmanager.com/gtag/js?id=' . rawurlencode( $id );
		echo "<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config'," . wp_json_encode( $id ) . ");" .
			"(function(){function l(){var s=document.createElement('script');s.async=true;s.src=" . wp_json_encode( $src ) . ";document.head.appendChild(s);}" .
			"if(document.readyState==='complete'){l();}else{addEventListener('load',l);}})();</script>\n";
	}
}
