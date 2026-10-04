<?php
/**
 * Admin and login hardening that needs no extra plugin.
 *
 * - Optional secret login address: wp-login.php and wp-admin return 404 to visitors who are not logged in.
 * - Login attempt limit per IP (5 failures, then a 15 minute lock).
 * - Generic login errors, no user enumeration (?author=N and the public users REST route).
 * - XML-RPC off, security headers, no version leaks.
 *
 * If the login address is ever forgotten, add define( 'MYZT_NO_LOGIN_SLUG', true ); to wp-config.php.
 *
 * @package MyZakatTool
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MYZT_Security {

	const MAX_FAILS = 5;
	const LOCK_MIN  = 15;

	private static $is_login = false;

	public static function init() {
		add_filter( 'xmlrpc_enabled', '__return_false' );
		add_filter( 'xmlrpc_methods', '__return_empty_array' );
		add_filter( 'wp_headers', array( __CLASS__, 'headers' ) );
		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'wlwmanifest_link' );
		add_filter( 'the_generator', '__return_empty_string' );
		add_filter( 'login_errors', array( __CLASS__, 'login_error' ) );
		add_action( 'template_redirect', array( __CLASS__, 'block_author_scan' ), 0 );
		add_filter( 'rest_endpoints', array( __CLASS__, 'rest_users' ) );
		add_filter( 'authenticate', array( __CLASS__, 'check_lock' ), 30, 1 );
		add_action( 'wp_login_failed', array( __CLASS__, 'login_failed' ) );
		add_action( 'wp_login', array( __CLASS__, 'login_ok' ) );

		if ( self::slug() ) {
			add_action( 'plugins_loaded', array( __CLASS__, 'route' ), 1 );
			add_action( 'wp_loaded', array( __CLASS__, 'serve' ), 1 );
			add_filter( 'site_url', array( __CLASS__, 'filter_url' ), 10, 1 );
			add_filter( 'network_site_url', array( __CLASS__, 'filter_url' ), 10, 1 );
			add_filter( 'wp_redirect', array( __CLASS__, 'filter_url' ), 10, 1 );
			add_filter( 'login_url', array( __CLASS__, 'filter_url' ), 10, 1 );
			add_filter( 'logout_url', array( __CLASS__, 'filter_url' ), 10, 1 );
			add_filter( 'lostpassword_url', array( __CLASS__, 'filter_url' ), 10, 1 );
			add_filter( 'register_url', array( __CLASS__, 'filter_url' ), 10, 1 );
			remove_action( 'template_redirect', 'wp_redirect_admin_locations', 1000 );
		}
	}

	/** The secret login slug, or '' when the feature is off. */
	public static function slug() {
		if ( defined( 'MYZT_NO_LOGIN_SLUG' ) && MYZT_NO_LOGIN_SLUG ) {
			return '';
		}
		return (string) MYZT_Settings::get( 'login_slug' );
	}

	public static function login_address() {
		$slug = self::slug();
		return $slug ? home_url( '/' . $slug . '/' ) : wp_login_url();
	}

	private static function path() {
		$p = wp_parse_url( isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '/', PHP_URL_PATH ); // phpcs:ignore
		$home = (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH );
		$p    = '/' . ltrim( substr( (string) $p, strlen( rtrim( $home, '/' ) ) ), '/' );
		return untrailingslashit( $p );
	}

	/** Decide early whether this request is the secret login page, or a blocked default one. */
	public static function route() {
		$path = self::path();
		if ( '/' . self::slug() === $path ) {
			self::$is_login = true;
			return;
		}
		if ( '/wp-login.php' === $path || ( '/wp-signup.php' === $path ) ) {
			$action = isset( $_GET['action'] ) ? sanitize_key( $_GET['action'] ) : ''; // phpcs:ignore
			if ( 'postpass' === $action ) {
				return;
			}
			self::not_found();
		}
	}

	public static function serve() {
		global $pagenow;
		$path = self::path();
		// wp-admin for logged-out visitors: 404 instead of a redirect that reveals the login page.
		if ( is_admin() && ! is_user_logged_in() && ! wp_doing_ajax() && ! wp_doing_cron() && 0 === strpos( $path, '/wp-admin' ) && '/wp-admin/admin-post.php' !== $path ) {
			self::not_found();
		}
		if ( self::$is_login ) {
			$pagenow = 'wp-login.php'; // phpcs:ignore
			$_SERVER['SCRIPT_NAME'] = '/wp-login.php';
			global $error, $interim_login, $action, $user_login, $user, $redirect_to; // phpcs:ignore
			require_once ABSPATH . 'wp-login.php';
			exit;
		}
	}

	private static function not_found() {
		status_header( 404 );
		nocache_headers();
		header( 'Content-Type: text/html; charset=utf-8' );
		echo '<!doctype html><meta name="robots" content="noindex"><title>Page not found</title><p style="font:16px sans-serif;margin:40px">Page not found. <a href="' . esc_url( home_url( '/' ) ) . '">Go to the zakat calculator</a></p>';
		exit;
	}

	public static function filter_url( $url ) {
		if ( is_string( $url ) && false !== strpos( $url, 'wp-login.php' ) && false === strpos( $url, 'action=postpass' ) ) {
			$parts = explode( '?', $url, 2 );
			$url   = home_url( '/' . self::slug() . '/' ) . ( isset( $parts[1] ) ? '?' . $parts[1] : '' );
		}
		return $url;
	}

	/* ---------- login attempt limit ---------- */

	private static function ip_key() {
		$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '0';
		return 'myzt_fail_' . md5( $ip );
	}

	public static function check_lock( $user ) {
		$n = (int) get_transient( self::ip_key() );
		if ( $n >= self::MAX_FAILS ) {
			return new WP_Error( 'myzt_locked', sprintf( 'Too many failed logins. Try again in %d minutes.', self::LOCK_MIN ) );
		}
		return $user;
	}

	public static function login_failed() {
		$k = self::ip_key();
		set_transient( $k, (int) get_transient( $k ) + 1, self::LOCK_MIN * MINUTE_IN_SECONDS );
	}

	public static function login_ok() {
		delete_transient( self::ip_key() );
	}

	public static function login_error( $msg ) {
		if ( false !== strpos( (string) $msg, 'Too many failed logins' ) ) {
			return $msg;
		}
		return '<strong>Error:</strong> Wrong username or password.';
	}

	/* ---------- enumeration, headers ---------- */

	public static function block_author_scan() {
		if ( ! is_user_logged_in() && ( isset( $_GET['author'] ) || is_author() ) ) { // phpcs:ignore
			wp_safe_redirect( home_url( '/' ), 301 );
			exit;
		}
	}

	public static function rest_users( $endpoints ) {
		if ( ! is_user_logged_in() ) {
			unset( $endpoints['/wp/v2/users'], $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
		}
		return $endpoints;
	}

	public static function headers( $h ) {
		unset( $h['X-Pingback'] );
		$h['X-Content-Type-Options'] = 'nosniff';
		$h['X-Frame-Options']        = 'SAMEORIGIN';
		$h['Referrer-Policy']        = 'strict-origin-when-cross-origin';
		$h['Permissions-Policy']     = 'camera=(), microphone=(), geolocation=(), payment=()';
		if ( is_ssl() ) {
			$h['Strict-Transport-Security'] = 'max-age=31536000';
		}
		return $h;
	}
}
