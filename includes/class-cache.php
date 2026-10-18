<?php
/**
 * Page cache and search-engine pings (audit FIX-120, FIX-102).
 *
 * The hourly rate refresh used to purge the whole LiteSpeed cache, so half the visits were cache
 * misses (home LCP 3.5 s cold vs 1 s warm). Now it purges only the pages that print rates in their
 * HTML; every other page keeps its cached copy, and the calculators still pull fresh rates over REST.
 * After a purge the same pages are fetched once in the background, so the first visitor gets a hit.
 *
 * IndexNow (Bing, Yandex, Seznam; Bing feeds ChatGPT search and Copilot) is told about pages a
 * release created or rewrote, and once a day about the live-rate pages.
 *
 * @package MyZakatTool
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MYZT_Cache {

	const WARM      = 'myzt_warm_cache';
	const KEY       = 'myzt_indexnow_key';
	const RATE_TAGS = '/\[(zakat_gold_rate|zakat_nisab|zakat_mehr|zakat_diyat|myzt_rate|myzt_mehr|myzt_diyat|myzt_reviewed[^\]]*rates|myzt_karat_table|myzt_tola_table)/';

	public static function init() {
		add_action( self::WARM, array( __CLASS__, 'warm' ) );
		add_action( 'init', array( __CLASS__, 'key_file' ), 0 );
	}

	/** Published pages and guides whose HTML, title or description shows a live rate. */
	public static function rate_pages() {
		$ids = array();
		foreach ( get_posts( array( 'post_type' => array( 'page', 'post' ), 'post_status' => 'publish', 'numberposts' => -1 ) ) as $p ) {
			$meta = get_post_meta( $p->ID, '_myzt_title', true ) . get_post_meta( $p->ID, '_myzt_desc', true );
			if ( preg_match( self::RATE_TAGS, $p->post_content ) || false !== strpos( $meta, '{rate:' ) ) {
				$ids[] = $p->ID;
			}
		}
		return $ids;
	}

	/** After new rates: purge and re-warm only the rate pages; ping IndexNow for them once a day. */
	public static function rates_changed() {
		$ids = self::rate_pages();
		foreach ( $ids as $id ) {
			do_action( 'litespeed_purge_post', $id );
		}
		$urls = array_map( 'get_permalink', $ids );
		self::schedule_warm( $urls );
		if ( ! get_transient( 'myzt_indexnow_rates' ) ) {
			set_transient( 'myzt_indexnow_rates', 1, DAY_IN_SECONDS );
			self::indexnow( $urls );
		}
	}

	/** After a release (the whole cache was purged): re-warm every page and ping the ones that changed. */
	public static function released( $changed_ids ) {
		$all = get_posts( array( 'post_type' => array( 'page', 'post' ), 'post_status' => 'publish', 'numberposts' => -1, 'fields' => 'ids' ) );
		$urls = array_map( 'get_permalink', $all );
		array_unshift( $urls, home_url( '/' ) );
		self::schedule_warm( array_unique( $urls ) );
		$changed = array();
		foreach ( $changed_ids as $id ) {
			if ( 'publish' === get_post_status( $id ) ) {
				$changed[] = get_permalink( $id );
			}
		}
		self::indexnow( $changed );
	}

	/**
	 * Batches of 8 pages a minute apart, starting after this request ends (LiteSpeed applies a purge
	 * when the response finishes, so fetching now would only get the old copy).
	 */
	private static function schedule_warm( $urls ) {
		$urls = array_values( array_filter( $urls ) );
		foreach ( array_chunk( $urls, 8 ) as $i => $batch ) {
			wp_schedule_single_event( time() + 90 + 60 * $i, self::WARM, array( $batch ) );
		}
	}

	public static function warm( $urls ) {
		foreach ( (array) $urls as $url ) {
			wp_remote_get(
				$url,
				array(
					'timeout'    => 15,
					'user-agent' => 'Mozilla/5.0 (compatible; MyZakatTool-warmup/' . MYZAKATTOOL_VERSION . ')',
					'headers'    => array( 'Accept' => 'text/html' ),
				)
			);
		}
	}

	/** The IndexNow key (made once), proven by /{key}.txt. */
	public static function key() {
		$k = get_option( self::KEY );
		if ( ! $k || ! preg_match( '/^[a-f0-9]{32}$/', $k ) ) {
			$k = md5( wp_generate_password( 32, true, true ) );
			update_option( self::KEY, $k, true );
		}
		return $k;
	}

	public static function key_file() {
		$k = get_option( self::KEY );
		if ( ! $k || empty( $_SERVER['REQUEST_URI'] ) ) {
			return;
		}
		$path = wp_parse_url( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ), PHP_URL_PATH );
		if ( '/' . $k . '.txt' === $path ) {
			status_header( 200 );
			header( 'Content-Type: text/plain; charset=utf-8' );
			header( 'X-Robots-Tag: noindex' );
			echo esc_html( $k );
			exit;
		}
	}

	/** One non-blocking POST to api.indexnow.org (shared by Bing, Yandex, Seznam, Naver). Live, public site only. */
	public static function indexnow( $urls ) {
		$urls = array_values( array_unique( array_filter( $urls ) ) );
		if ( ! $urls || ! get_option( 'blog_public' ) || 'production' !== wp_get_environment_type() ) {
			return;
		}
		$host = wp_parse_url( home_url( '/' ), PHP_URL_HOST );
		if ( ! $host || 'localhost' === $host ) {
			return;
		}
		$key = self::key();
		wp_remote_post(
			'https://api.indexnow.org/indexnow',
			array(
				'timeout'  => 5,
				'blocking' => false,
				'headers'  => array( 'Content-Type' => 'application/json; charset=utf-8' ),
				'body'     => wp_json_encode(
					array(
						'host'        => $host,
						'key'         => $key,
						'keyLocation' => home_url( '/' . $key . '.txt' ),
						'urlList'     => array_slice( $urls, 0, 1000 ),
					),
					JSON_UNESCAPED_SLASHES
				),
			)
		);
	}
}
