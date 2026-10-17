<?php
/**
 * Dark / light mode for the whole site: a round button in the corner of every page.
 * The choice is kept in the visitor's browser (localStorage "myzt_theme"); the default is light.
 * GeneratePress colours everything through its global colour variables, so dark mode only
 * redefines those, plus the calculators' own variables. The wirasat frame follows the same
 * setting (it reads the key and listens for changes).
 *
 * @package MyZakatTool
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MYZT_Theme_Mode {

	public static function init() {
		add_action( 'wp_head', array( __CLASS__, 'head' ), 1 );
		add_action( 'wp_footer', array( __CLASS__, 'button' ), 20 );
	}

	/** Set the mode before the page paints, so a dark visitor never sees a white flash. */
	public static function head() {
		echo "<script>try{if(localStorage.getItem('myzt_theme')==='dark')document.documentElement.setAttribute('data-theme','dark')}catch(e){}</script>\n";
		echo '<style id="myzt-theme">' . self::css() . "</style>\n";
	}

	public static function css() {
		$d = 'html[data-theme="dark"]';
		return $d . '{color-scheme:dark;--contrast:#e6ebed;--contrast-2:#b9c3c7;--contrast-3:#6f7c81;--base:#2c3437;--base-2:#121719;--base-3:#1a2124;--accent:#7cb8ef}'
			. $d . ' .myzt{--z-bg:#162022;--z-card:#1c2629;--z-ink:#e3ece9;--z-mute:#a8b8b3;--z-line:#34443f;--z-teal:#13867a;--z-teal2:#173a35;--z-acc:#7fdccf;--z-warn:#2d2717;--z-ok:#6bd394;--z-okbg:#183324}'
			. $d . ' .myzt-link{color:#6fd6c8}'
			. $d . ' .main-navigation .main-nav ul li[class*="current-menu-"]>a,' . $d . ' .main-navigation .main-nav ul li:hover>a,' . $d . ' .main-navigation .main-nav ul li:focus>a{color:#9ccbf5}'
			. $d . ' .myzt-reviewed,' . $d . ' .myzt-crumb,' . $d . ' .myzt-footer-links span,' . $d . ' .myzt-ad-label{color:#a8b8b3!important}'
			. $d . ' img:not([src$=".svg"]){filter:brightness(.92)}'
			. '.myzt-mode{position:fixed;left:16px;bottom:16px;z-index:9998;width:44px;height:44px;padding:0;border-radius:50%;border:1px solid var(--base,#ddd);background:var(--base-3,#fff);color:var(--contrast,#222);display:grid;place-items:center;cursor:pointer;box-shadow:0 2px 10px rgba(0,0,0,.18)}'
			. '.myzt-mode:hover,.myzt-mode:focus{background:var(--base-3,#fff);color:var(--contrast,#222)}'
			. '.myzt-mode:focus-visible{outline:2px solid var(--accent,#1e73be);outline-offset:2px}'
			. '.myzt-mode svg{width:22px;height:22px}.myzt-mode .sun,' . $d . ' .myzt-mode .moon{display:none}' . $d . ' .myzt-mode .sun{display:block}'
			. '@media (max-width:768px){body.myzt-has-sticky .myzt-mode{bottom:76px}}'
			. '@media print{.myzt-mode{display:none}}';
	}

	public static function button() {
		$ur    = class_exists( 'MYZT_SEO' ) && MYZT_SEO::is_ur();
		$label = $ur ? 'ڈارک یا لائٹ موڈ' : 'Dark or light mode';
		$moon  = '<svg class="moon" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M21 14.5A9 9 0 0 1 9.5 3a9 9 0 1 0 11.5 11.5z"/></svg>';
		$sun   = '<svg class="sun" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="4.5" fill="currentColor"/><path stroke="currentColor" stroke-width="2" stroke-linecap="round" d="M12 2v2.5M12 19.5V22M2 12h2.5M19.5 12H22M4.9 4.9l1.8 1.8M17.3 17.3l1.8 1.8M4.9 19.1l1.8-1.8M17.3 6.7l1.8-1.8"/></svg>';
		echo '<button type="button" class="myzt-mode" id="myzt-mode" aria-label="' . esc_attr( $label ) . '" title="' . esc_attr( $label ) . '" aria-pressed="false">' . $moon . $sun . '</button>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- fixed SVG markup.
		echo "<script>(function(){var b=document.getElementById('myzt-mode'),h=document.documentElement;function set(d){if(d)h.setAttribute('data-theme','dark');else h.removeAttribute('data-theme');b.setAttribute('aria-pressed',d?'true':'false');}set(h.getAttribute('data-theme')==='dark');b.addEventListener('click',function(){var d=h.getAttribute('data-theme')!=='dark';set(d);try{localStorage.setItem('myzt_theme',d?'dark':'light')}catch(e){}});addEventListener('storage',function(e){if(e.key==='myzt_theme')set(e.newValue==='dark');});})();</script>\n";
	}
}
