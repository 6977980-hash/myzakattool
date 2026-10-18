<?php
/**
 * Live gold, silver and currency rates.
 *
 * Fetched on the server (WP-Cron, hourly) and cached in an option, so visitors never call
 * the APIs and free limits are never reached. After each refresh the LiteSpeed page cache is
 * purged so server-rendered numbers match, and the REST route is never page-cached. Fallback chain:
 *   metals: gold-api.com -> fawazahmed0 currency-api (xau/xag) -> last saved
 *   fx:     fawazahmed0 currency-api (jsDelivr) -> Cloudflare Pages mirror -> last saved
 *
 * @package MyZakatTool
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MYZT_Rates {

	const OPTION  = 'myzt_rates';
	const CRON    = 'myzt_refresh_rates';
	const HISTORY = 'myzt_rate_history';

	/** Currencies kept in the daily history (FIX-151 30-day chart). */
	const HISTORY_FX = array( 'pkr', 'inr', 'gbp', 'aed', 'sar', 'eur' );

	/** Metal rates older than this are reported as stale (admin notice and email). */
	const STALE_AFTER = 3 * HOUR_IN_SECONDS;
	/** The FX source publishes daily, so FX is only stale after a missed day. */
	const FX_STALE_AFTER = 26 * HOUR_IN_SECONDS;

	public static function init() {
		add_action( self::CRON, array( __CLASS__, 'refresh' ) );
		add_action( 'rest_api_init', array( __CLASS__, 'register_route' ) );
		add_action( 'init', array( __CLASS__, 'ensure_schedule' ) );
		add_filter( 'rest_pre_serve_request', array( __CLASS__, 'cors' ), 20, 3 );
		add_action( 'admin_notices', array( __CLASS__, 'admin_notice' ) );
	}

	public static function ensure_schedule() {
		if ( ! wp_next_scheduled( self::CRON ) ) {
			wp_schedule_event( time() + 60, 'hourly', self::CRON );
		}
		// Stale after 2 hours (cron did not run): queue a one-off refresh without blocking the page.
		// The uncached REST route reaches this on calculator visits, so cron gets a chance to run.
		$rates = self::get();
		if ( empty( $rates['updated'] ) || ( time() - (int) $rates['updated'] ) > 2 * HOUR_IN_SECONDS ) {
			if ( ! wp_next_scheduled( self::CRON . '_once' ) && ! get_transient( 'myzt_refresh_lock' ) ) {
				wp_schedule_single_event( time(), self::CRON . '_once' );
			}
			self::maybe_alert();
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

	/**
	 * Small public payload for the calculator (only common currencies to keep pages light).
	 * The admin's emergency override is applied here, so pages, REST and the embed agree.
	 */
	public static function payload() {
		$r  = self::get();
		$fx = isset( $r['fx'] ) && is_array( $r['fx'] ) ? $r['fx'] : array();
		$p  = array(
			'goldUsdOz'   => isset( $r['goldUsdOz'] ) ? (float) $r['goldUsdOz'] : 0,
			'silverUsdOz' => isset( $r['silverUsdOz'] ) ? (float) $r['silverUsdOz'] : 0,
			'fx'          => $fx,
			'updated'     => isset( $r['updated'] ) ? (int) $r['updated'] : 0,
			'fxUpdated'   => isset( $r['fxUpdated'] ) ? (int) $r['fxUpdated'] : 0,
			'source'      => isset( $r['metalSource'] ) ? $r['metalSource'] : '',
		);
		$s = MYZT_Settings::get();
		$g = (float) $s['gold_override'];
		$v = (float) $s['silver_override'];
		if ( $g > 0 || $v > 0 ) {
			if ( $g > 0 ) {
				$p['goldUsdOz'] = $g;
			}
			if ( $v > 0 ) {
				$p['silverUsdOz'] = $v;
			}
			// Keep the real time the override was saved, so the site never claims it is fresh.
			$p['source']  = 'manual';
			$p['updated'] = (int) $s['override_at'] ? (int) $s['override_at'] : $p['updated'];
		}
		return $p;
	}

	/** Freshness of the saved rates, for the admin notice and alert email. */
	public static function health() {
		$r      = self::get();
		$age    = empty( $r['updated'] ) ? PHP_INT_MAX : time() - (int) $r['updated'];
		$fx_age = empty( $r['fxUpdated'] ) ? PHP_INT_MAX : time() - (int) $r['fxUpdated'];
		return array(
			'age'    => $age,
			'fxAge'  => $fx_age,
			'stale'  => $age > self::STALE_AFTER || $fx_age > self::FX_STALE_AFTER,
			'failed' => isset( $r['lastOk'] ) && ! $r['lastOk'],
		);
	}

	/** Email the site owner (at most every 12 hours) while rates are stale. */
	private static function maybe_alert() {
		$h = self::health();
		if ( ! $h['stale'] || get_transient( 'myzt_rates_alerted' ) ) {
			return;
		}
		set_transient( 'myzt_rates_alerted', 1, 12 * HOUR_IN_SECONDS );
		$to = MYZT_Settings::get( 'security_email' );
		$to = $to ? $to : get_option( 'admin_email' );
		$hours = PHP_INT_MAX === $h['age'] ? 'never' : round( $h['age'] / HOUR_IN_SECONDS, 1 ) . ' hours ago';
		wp_mail(
			$to,
			'[My Zakat Tool] Gold and silver rates are not updating',
			"The live rates on " . home_url( '/' ) . " were last updated: {$hours}.\n\n" .
			"Visitors may see an old nisab. Open Settings > My Zakat Tool and press \"Refresh rates now\". " .
			"If it keeps happening, check the Hostinger cron job that calls wp-cron.php.\n\n" .
			admin_url( 'options-general.php?page=myzakattool' )
		);
	}

	public static function admin_notice() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$h = self::health();
		if ( ! $h['stale'] && ! $h['failed'] ) {
			return;
		}
		$msg = $h['stale']
			? __( 'My Zakat Tool: gold, silver or currency rates have not updated for over 3 hours, so visitors may see an old nisab.', 'myzakattool' )
			: __( 'My Zakat Tool: the last rate refresh partly failed; the previous rates are still shown.', 'myzakattool' );
		echo '<div class="notice notice-' . ( $h['stale'] ? 'error' : 'warning' ) . '"><p>' . esc_html( $msg ) . ' <a href="' . esc_url( admin_url( 'options-general.php?page=myzakattool' ) ) . '">' . esc_html__( 'Check rates', 'myzakattool' ) . '</a></p></div>';
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
		if ( $metals && $fxdata ) {
			self::record_history( $new );
		}
		delete_transient( 'myzt_refresh_lock' );
		if ( $metals || $fxdata ) {
			// Pages print rates in their HTML; drop cached copies so every page shows this snapshot.
			do_action( 'litespeed_purge_all' );
			delete_transient( 'myzt_rates_alerted' );
		} else {
			self::maybe_alert();
		}
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

	/**
	 * Daily rates for the last 30 days: date (Y-m-d, UTC) => gold and silver in USD per ounce and a few FX rates.
	 * Today's entry follows the live rate; missing earlier days are back-filled, three per refresh, from
	 * the dated files of the same currency API, so the chart fills within a few hours of install.
	 */
	public static function history() {
		$h = get_option( self::HISTORY );
		if ( ! is_array( $h ) ) {
			return array();
		}
		ksort( $h );
		return $h;
	}

	private static function history_row( $gold, $silver, $fx ) {
		$row = array( 'g' => round( (float) $gold, 2 ), 's' => round( (float) $silver, 3 ) );
		foreach ( self::HISTORY_FX as $k ) {
			if ( isset( $fx[ $k ] ) && $fx[ $k ] > 0 ) {
				$row[ $k ] = round( (float) $fx[ $k ], 4 );
			}
		}
		return $row;
	}

	private static function record_history( $rates ) {
		$h = self::history();
		$h[ gmdate( 'Y-m-d' ) ] = self::history_row( $rates['goldUsdOz'], $rates['silverUsdOz'], $rates['fx'] );
		$fetched = 0;
		for ( $i = 30; $i >= 1 && $fetched < 3; $i-- ) {
			$day = gmdate( 'Y-m-d', time() - $i * DAY_IN_SECONDS );
			if ( isset( $h[ $day ] ) ) {
				continue;
			}
			++$fetched;
			$d = self::get_json( 'https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@' . $day . '/v1/currencies/usd.min.json' );
			$m = isset( $d['usd'] ) && is_array( $d['usd'] ) ? self::metals_from_fx( $d['usd'] ) : null;
			if ( $m ) {
				$h[ $day ] = self::history_row( $m['gold'], $m['silver'], $d['usd'] );
			}
		}
		$cut = gmdate( 'Y-m-d', time() - 40 * DAY_IN_SECONDS );
		foreach ( array_keys( $h ) as $day ) {
			if ( $day < $cut ) {
				unset( $h[ $day ] );
			}
		}
		ksort( $h );
		update_option( self::HISTORY, $h, false );
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
					// Never keep this in the LiteSpeed page cache: cached copies went days old and lost CORS.
					$res->header( 'X-LiteSpeed-Cache-Control', 'no-cache' );
					$res->header( 'Cache-Control', 'public, max-age=300' );
					return $res;
				},
			)
		);
	}

	/** Public, credential-free data: allow any site (the embed widget) with one fixed header. */
	public static function cors( $served, $result, $request ) {
		if ( '/myzakattool/v1/rates' === $request->get_route() && ! headers_sent() ) {
			header( 'Access-Control-Allow-Origin: *' );
			header_remove( 'Access-Control-Allow-Credentials' );
		}
		return $served;
	}
}

add_action( 'myzt_refresh_rates_once', array( 'MYZT_Rates', 'refresh' ) );
