<?php
/**
 * Live gold, silver and currency rates.
 *
 * Fetched on the server (WP-Cron, hourly) and cached in an option, so visitors never call
 * the APIs and free limits are never reached. Fallback chain:
 *   metals: gold-api.com -> fawazahmed0 currency-api (xau/xag) -> last saved
 *   fx:     fawazahmed0 currency-api (jsDelivr) -> Cloudflare Pages mirror -> last saved
 *
 * @package MyZakatTool
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MYZT_Rates {

	const OPTION = 'myzt_rates';
	const CRON   = 'myzt_refresh_rates';

	public static function init() {
		add_action( self::CRON, array( __CLASS__, 'refresh' ) );
		add_action( 'rest_api_init', array( __CLASS__, 'register_route' ) );
		add_action( 'init', array( __CLASS__, 'ensure_schedule' ) );
	}

	public static function ensure_schedule() {
		if ( ! wp_next_scheduled( self::CRON ) ) {
			wp_schedule_event( time() + 60, 'hourly', self::CRON );
		}
		// Stale after 6 hours (cron did not run): queue a one-off refresh without blocking the page.
		$rates = self::get();
		if ( empty( $rates['updated'] ) || ( time() - (int) $rates['updated'] ) > 6 * HOUR_IN_SECONDS ) {
			if ( ! wp_next_scheduled( self::CRON . '_once' ) && ! get_transient( 'myzt_refresh_lock' ) ) {
				wp_schedule_single_event( time(), self::CRON . '_once' );
			}
		}
	}

	public static function unschedule() {
		wp_clear_scheduled_hook( self::CRON );
		wp_clear_scheduled_hook( self::CRON . '_once' );
	}

	/** Saved rates: goldUsdOz, silverUsdOz, fx (map lowercase code => per USD), updated, sources. */
	public static function get() {
		$rates = get_option( self::OPTION );
		return is_array( $rates ) ? $rates : array();
	}

	/** Small public payload for the calculator (only common currencies to keep pages light). */
	public static function payload() {
		$r  = self::get();
		$fx = isset( $r['fx'] ) && is_array( $r['fx'] ) ? $r['fx'] : array();
		return array(
			'goldUsdOz'   => isset( $r['goldUsdOz'] ) ? (float) $r['goldUsdOz'] : 0,
			'silverUsdOz' => isset( $r['silverUsdOz'] ) ? (float) $r['silverUsdOz'] : 0,
			'fx'          => $fx,
			'updated'     => isset( $r['updated'] ) ? (int) $r['updated'] : 0,
			'source'      => isset( $r['metalSource'] ) ? $r['metalSource'] : '',
		);
	}

	public static function refresh() {
		if ( get_transient( 'myzt_refresh_lock' ) ) {
			return self::get();
		}
		set_transient( 'myzt_refresh_lock', 1, 5 * MINUTE_IN_SECONDS );

		$old    = self::get();
		$new    = $old;
		$fxdata = self::fetch_fx();

		$metals = self::fetch_gold_api();
		if ( ! $metals && $fxdata ) {
			$metals = self::metals_from_fx( $fxdata );
		}
		if ( $metals ) {
			$new['goldUsdOz']   = $metals['gold'];
			$new['silverUsdOz'] = $metals['silver'];
			$new['metalSource'] = $metals['source'];
			$new['updated']     = time();
		}
		if ( $fxdata ) {
			$fx = array( 'usd' => 1.0 );
			foreach ( self::currencies() as $code ) {
				$k = strtolower( $code );
				if ( isset( $fxdata[ $k ] ) && is_numeric( $fxdata[ $k ] ) && $fxdata[ $k ] > 0 ) {
					$fx[ $k ] = (float) $fxdata[ $k ];
				}
			}
			$new['fx']        = $fx;
			$new['fxUpdated'] = time();
		}
		$new['lastAttempt'] = time();
		$new['lastOk']      = ( $metals && $fxdata ) ? 1 : 0;
		update_option( self::OPTION, $new, false );
		delete_transient( 'myzt_refresh_lock' );
		return $new;
	}

	private static function get_json( $url ) {
		$res = wp_remote_get(
			$url,
			array(
				'timeout'    => 10,
				'user-agent' => 'MyZakatTool/' . MYZAKATTOOL_VERSION . '; ' . home_url( '/' ),
			)
		);
		if ( is_wp_error( $res ) || 200 !== (int) wp_remote_retrieve_response_code( $res ) ) {
			return null;
		}
		$data = json_decode( wp_remote_retrieve_body( $res ), true );
		return is_array( $data ) ? $data : null;
	}

	/** gold-api.com: { "price": 2650.1, "symbol": "XAU", ... } in USD per troy ounce. */
	private static function fetch_gold_api() {
		$g = self::get_json( 'https://api.gold-api.com/price/XAU' );
		$s = self::get_json( 'https://api.gold-api.com/price/XAG' );
		$gold   = isset( $g['price'] ) ? (float) $g['price'] : 0;
		$silver = isset( $s['price'] ) ? (float) $s['price'] : 0;
		if ( self::sane( $gold, $silver ) ) {
			return array( 'gold' => $gold, 'silver' => $silver, 'source' => 'gold-api.com' );
		}
		return null;
	}

	/** fawazahmed0 currency-api: { "date": "...", "usd": { "pkr": 280.1, "xau": 0.00037, ... } }. */
	private static function fetch_fx() {
		$urls = array(
			'https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@latest/v1/currencies/usd.min.json',
			'https://latest.currency-api.pages.dev/v1/currencies/usd.min.json',
		);
		foreach ( $urls as $url ) {
			$d = self::get_json( $url );
			if ( isset( $d['usd'] ) && is_array( $d['usd'] ) && ! empty( $d['usd']['pkr'] ) ) {
				return $d['usd'];
			}
		}
		return null;
	}

	private static function metals_from_fx( $fx ) {
		$gold   = ! empty( $fx['xau'] ) ? 1 / (float) $fx['xau'] : 0;
		$silver = ! empty( $fx['xag'] ) ? 1 / (float) $fx['xag'] : 0;
		if ( self::sane( $gold, $silver ) ) {
			return array( 'gold' => $gold, 'silver' => $silver, 'source' => 'currency-api (daily)' );
		}
		return null;
	}

	/** Reject obviously broken data instead of showing it to users. */
	private static function sane( $gold, $silver ) {
		return $gold > 300 && $gold < 50000 && $silver > 3 && $silver < 1000;
	}

	/** Currencies offered in the calculator (ISO codes). */
	public static function currencies() {
		return array(
			'PKR', 'INR', 'BDT', 'USD', 'GBP', 'EUR', 'CAD', 'AUD', 'NZD', 'SAR', 'AED', 'QAR', 'KWD', 'BHD', 'OMR',
			'JOD', 'EGP', 'TRY', 'IDR', 'MYR', 'SGD', 'BND', 'ZAR', 'NGN', 'KES', 'TZS', 'MAD', 'DZD', 'TND', 'LYD',
			'IQD', 'IRR', 'AFN', 'LKR', 'NPR', 'MVR', 'UZS', 'AZN', 'LBP', 'SDG', 'SOS', 'YER', 'XOF', 'MRU', 'CHF',
			'SEK', 'NOK', 'DKK', 'JPY', 'CNY', 'HKD',
		);
	}

	public static function register_route() {
		register_rest_route(
			'myzakattool/v1',
			'/rates',
			array(
				'methods'             => 'GET',
				'permission_callback' => '__return_true',
				'callback'            => function () {
					$res = rest_ensure_response( self::payload() );
					$res->header( 'Cache-Control', 'public, max-age=900' );
					return $res;
				},
			)
		);
	}
}

add_action( 'myzt_refresh_rates_once', array( 'MYZT_Rates', 'refresh' ) );
