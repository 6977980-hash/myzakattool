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

	private static $needs_js = false;

	// 52.5 and 7.5 tola of 11.6638038 g, exactly as engine.js computes them (shown as 612.35 g and 87.48 g).
	const NISAB_SILVER_G = 612.34969950;
	const NISAB_GOLD_G   = 87.47852850;

	public static function init() {
		add_shortcode( 'zakat_calculator', array( __CLASS__, 'calculator' ) );
		add_shortcode( 'zakat_gold_rate', array( __CLASS__, 'gold_rate' ) );
		add_shortcode( 'zakat_nisab', array( __CLASS__, 'nisab' ) );
		add_shortcode( 'zakat_fitrana', array( __CLASS__, 'fitrana' ) );
		add_shortcode( 'zakat_fidya', array( __CLASS__, 'fidya' ) );
		add_shortcode( 'zakat_hawl', array( __CLASS__, 'hawl' ) );
		add_shortcode( 'zakat_ushr', array( __CLASS__, 'ushr' ) );
		add_shortcode( 'myzt_embed_code', array( __CLASS__, 'embed_code' ) );
		add_shortcode( 'zakat_khums', array( __CLASS__, 'khums' ) );
		add_shortcode( 'zakat_mehr', array( __CLASS__, 'mehr' ) );
		add_shortcode( 'zakat_diyat', array( __CLASS__, 'diyat' ) );
		add_shortcode( 'zakat_wirasat', array( __CLASS__, 'wirasat' ) );
		add_shortcode( 'myzt_faq', array( __CLASS__, 'faq' ) );
		add_shortcode( 'myzt_author', array( __CLASS__, 'author' ) );
		add_shortcode( 'myzt_answer', array( __CLASS__, 'answer' ) );
		add_shortcode( 'myzt_related', array( __CLASS__, 'related' ) );
		add_shortcode( 'myzt_trust', array( __CLASS__, 'trust' ) );
		add_shortcode( 'myzt_year', array( __CLASS__, 'year' ) );
		add_shortcode( 'myzt_rate', array( __CLASS__, 'rate_inline' ) );
		add_shortcode( 'myzt_mehr', array( __CLASS__, 'mehr_inline' ) );
		add_shortcode( 'myzt_diyat', array( __CLASS__, 'diyat_inline' ) );
		add_shortcode( 'myzt_reviewed', array( __CLASS__, 'reviewed' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'register_assets' ) );
		add_action( 'wp_footer', array( __CLASS__, 'late_enqueue' ), 1 );
		add_action( 'init', array( __CLASS__, 'no_emoji' ) );
		add_action( 'wp_head', array( __CLASS__, 'contrast_css' ), 99 );
	}

	/**
	 * Every modern browser draws emoji itself. The WordPress emoji script re-scanned the calculator
	 * after every re-render and swapped in hundreds of images on older systems (audit FIX-050).
	 */
	public static function no_emoji() {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'wp_enqueue_scripts', 'wp_enqueue_emoji_styles' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		add_filter( 'emoji_svg_url', '__return_false' );
	}

	/** The theme's active menu link (#1e73be on #f0f0f0) is 4.33:1; darken it to pass 4.5:1 (audit FIX-052). */
	public static function contrast_css() {
		echo '<style id="myzt-contrast">.main-navigation .main-nav ul li[class*="current-menu-"]>a,.main-navigation .main-nav ul li:hover>a,.main-navigation .main-nav ul li:focus>a{color:#1a65a8}</style>' . "\n";
	}

	public static function register_assets() {
		$v   = MYZAKATTOOL_VERSION;
		$url = MYZAKATTOOL_URL . 'assets/';
		wp_register_style( 'myzt', $url . 'css/app.css', array(), $v );
		$foot = array(
			'in_footer' => true,
			'strategy'  => 'defer',
		);
		wp_register_script( 'myzt-engine', $url . 'js/engine.js', array(), $v, $foot );
		// pdf.js is fetched by app.js only when a report is made, so it costs nothing on page load (audit FIX-049).
		wp_register_script( 'myzt-app', $url . 'js/app.js', array( 'myzt-engine' ), $v, $foot );

		// Load the stylesheet in <head> on our pages to avoid a flash of unstyled content.
		if ( is_singular() ) {
			$post = get_post();
			if ( $post && preg_match( '/\[(zakat_|myzt_)/', $post->post_content ) ) {
				wp_enqueue_style( 'myzt' );
			}
		}
	}

	private static function enqueue() {
		wp_enqueue_style( 'myzt' );
	}

	public static function late_enqueue() {
		// Content blocks (FAQ, author, answer box...) only need the stylesheet; the scripts are for widgets.
		if ( ! self::$needs_js ) {
			return;
		}
		wp_enqueue_script( 'myzt-app' );
		wp_add_inline_script( 'myzt-engine', 'window.MYZT=' . wp_json_encode( self::config() ) . ';', 'before' );
	}

	/** Data handed to the browser: rates, currency list, links. No user data. */
	public static function config() {
		$s     = MYZT_Settings::get();
		$rates = MYZT_Rates::payload();
		$country = '';
		if ( ! empty( $_SERVER['HTTP_CF_IPCOUNTRY'] ) ) {
			$country = strtoupper( substr( sanitize_text_field( wp_unslash( $_SERVER['HTTP_CF_IPCOUNTRY'] ) ), 0, 2 ) );
		}
		$out = array(
			'rates'      => $rates,
			'country'    => $country,
			'currencies' => MYZT_Rates::currencies(),
			'restUrl'    => esc_url_raw( rest_url( 'myzakattool/v1/rates' ) ),
			'jspdfUrl'   => MYZAKATTOOL_URL . 'assets/vendor/jspdf.umd.min.js?ver=4.2.1',
			'pdfUrl'     => MYZAKATTOOL_URL . 'assets/js/pdf.js?ver=' . MYZAKATTOOL_VERSION,
			'siteUrl'    => home_url( '/' ),
			'email'      => $s['contact_email'],
			'urls'       => array(
				'disclaimer'  => self::page_url( 'disclaimer' ),
				'methodology' => self::page_url( 'methodology' ),
				'khums'       => self::page_url( 'khums-calculator' ),
			),
			'fitrana'    => self::fitrana_config( $s ),
		);
		if ( MYZT_SEO::is_ur() ) {
			$out['lang'] = 'ur'; // Urdu pages always open the widgets in Urdu.
		}
		return $out;
	}

	/**
	 * Fitrana amounts for the fitrana and fidya tools. The owner's amounts from Settings win;
	 * while they are all empty, the last nationally announced Pakistani amounts are used and labelled
	 * as such, so the tools never start at 0 (audit FIX-013).
	 */
	public static function fitrana_config( $s ) {
		$items = array( 'wheat', 'barley', 'dates', 'raisins' );
		$own   = false;
		foreach ( $items as $i ) {
			if ( '' !== (string) $s[ 'fitrana_' . $i ] ) {
				$own = true;
			}
		}
		if ( $own ) {
			$out = array( 'currency' => $s['fitrana_currency'], 'note' => $s['fitrana_note'], 'fallback' => false );
			foreach ( $items as $i ) {
				$out[ $i ] = $s[ 'fitrana_' . $i ];
			}
			return $out;
		}
		return array(
			'currency' => 'PKR',
			'wheat'    => '300',
			'barley'   => '1100',
			'dates'    => '1600',
			'raisins'  => '3800',
			'note'     => 'Minimum amounts per person announced by the Council of Islamic Ideology, Pakistan, for Ramadan 1447 (February 2026). Amounts for Ramadan 2027 are added when announced. Pay according to prices in your area; those who can afford it may pay by dates or raisins.',
			'fallback' => true,
		);
	}

	/** Year of the fitrana amounts in use: the coming season once the owner enters them, else 2026 (CII 1447). */
	public static function fitrana_year() {
		$c = self::fitrana_config( MYZT_Settings::get() );
		return $c['fallback'] ? 2026 : MYZT_Installer::season_year();
	}

	public static function page_url( $slug ) {
		$p = get_page_by_path( $slug );
		return $p ? get_permalink( $p ) : home_url( '/' . $slug . '/' );
	}

	private static function widget( $name, $atts, $inner = '' ) {
		self::enqueue();
		self::$needs_js = true;
		$data = '';
		foreach ( $atts as $k => $v ) {
			if ( '' !== $v && null !== $v ) {
				$data .= ' data-' . esc_attr( $k ) . '="' . esc_attr( $v ) . '"';
			}
		}
		$wide = 'calculator' === $name ? ' alignwide' : '';
		return '<div class="myzt myzt-' . esc_attr( $name ) . $wide . '" data-widget="' . esc_attr( $name ) . '"' . $data . '>' . $inner .
			'<noscript><p>' . ( MYZT_SEO::is_ur() ? 'کیلکولیٹر استعمال کرنے کے لیے براؤزر میں JavaScript آن کریں۔' : esc_html__( 'Please enable JavaScript to use the calculator.', 'myzakattool' ) ) . '</p></noscript></div>';
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
			'label'   => 'manual' === $r['source'] ? 'manual rate set by the site owner' : 'international spot rate',
		);
	}

	/** Same look as money() in app.js: lakh grouping and Rs for South Asian currencies. */
	private static function money( $v, $cur ) {
		$n = number_format( round( $v ) );
		if ( in_array( $cur, array( 'PKR', 'INR', 'BDT', 'NPR', 'LKR' ), true ) ) {
			$d    = (string) abs( round( $v ) );
			$last = substr( $d, -3 );
			$rest = substr( $d, 0, -3 );
			$n    = ( '' !== $rest ? preg_replace( '/\B(?=(\d{2})+(?!\d))/', ',', $rest ) . ',' : '' ) . $last;
		}
		$sym = array(
			'PKR' => 'Rs ',
			'INR' => '₹',
			'USD' => '$',
			'GBP' => '£',
			'EUR' => '€',
		);
		return ( isset( $sym[ $cur ] ) ? $sym[ $cur ] : $cur . ' ' ) . $n;
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
			$in = '<div class="myzt-card"><div class="myzt-scroll"><table class="myzt-table"><thead><tr><th>Purity</th><th>per gram</th><th>per tola</th><th>per ounce</th></tr></thead><tbody>' . $rows . '</tbody></table></div><p class="myzt-small">Updated ' . esc_html( wp_date( 'j M Y, H:i', $p['updated'] ) ) . ' · ' . esc_html( $p['label'] ) . '</p></div>';
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
				'<tr><td>Silver</td><td>612.35 g · 52.5 tola</td><td class="z">' . esc_html( self::money( $p['silver'] * self::NISAB_SILVER_G, $cur ) ) . '</td></tr>' .
				'<tr><td>Gold</td><td>87.48 g · 7.5 tola</td><td class="z">' . esc_html( self::money( $p['gold'] * self::NISAB_GOLD_G, $cur ) ) . '</td></tr>' .
				'</tbody></table><p class="myzt-small">Updated ' . esc_html( wp_date( 'j M Y, H:i', $p['updated'] ) ) . ' · ' . esc_html( $p['label'] ) . '</p></div>';
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
			'nisab-silver' => $p['silver'] * self::NISAB_SILVER_G,
			'nisab-gold'   => $p['gold'] * self::NISAB_GOLD_G,
			'gold-tola-zakat'   => $p['gold'] * 11.6638038 * 0.025,
			'gold22-tola-zakat' => $p['gold'] * 22 / 24 * 11.6638038 * 0.025,
		);
		$v = isset( $map[ $a['type'] ] ) ? $map[ $a['type'] ] : 0;
		return esc_html( self::money( $v, $cur ) );
	}

	public static function fitrana() {
		return self::widget( 'fitrana', array() );
	}

	/** [myzt_reviewed rates="1"]: "Rules last checked" date and, optionally, a dated snapshot of the rates used. */
	public static function reviewed( $atts ) {
		$a    = shortcode_atts( array( 'rates' => '0' ), $atts, 'myzt_reviewed' );
		$s    = MYZT_Settings::get();
		$date = strtotime( $s['rules_reviewed'] . ' 12:00:00' );
		$who  = $s['author_name'] . ( $s['reviewer'] ? ', reviewed by ' . $s['reviewer'] : '' );
		$h    = '<p class="myzt-reviewed" lang="en" dir="ltr" style="font-size:13px;color:#5d736e;border-top:1px solid #dfe9e6;padding-top:8px">';
		if ( $date ) {
			// FIX-048: without a named scholar, make clear the check was the site owner's, not a scholar review.
			$h .= 'Rules last checked: <time datetime="' . esc_attr( gmdate( 'Y-m-d', $date ) ) . '">' . esc_html( wp_date( 'j F Y', $date ) ) . '</time> by ' . esc_html( $who ) .
				( $s['reviewer'] ? '. ' : ' (site owner; not a scholar review). ' );
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

	public static function hawl() {
		return self::widget( 'hawl', array() );
	}

	public static function ushr() {
		return self::widget( 'ushr', array() );
	}

	/** [myzt_embed_code currency="PKR"]: live preview of the embeddable widget plus the code to copy. */
	public static function embed_code( $atts ) {
		$a    = shortcode_atts( array( 'currency' => 'PKR' ), $atts, 'myzt_embed_code' );
		$cur  = strtoupper( preg_replace( '/[^A-Za-z]/', '', $a['currency'] ) );
		$src  = MYZAKATTOOL_URL . 'assets/js/embed.js?ver=' . MYZAKATTOOL_VERSION;
		$code = '<div data-myzt-embed data-currency="' . $cur . '"></div>' . "\n" .
			'<script src="' . $src . '" async></script>' . "\n" .
			'<p style="font-size:12px">Nisab by <a href="' . home_url( '/nisab/' ) . '">My Zakat Tool</a></p>';
		self::enqueue();
		return '<div class="myzt myzt-embed-demo">' . $code . '<p><label for="myzt-embed-code"><strong>Copy this code:</strong></label></p>' .
			'<textarea id="myzt-embed-code" readonly rows="4" style="width:100%;font:13px monospace;padding:10px;border:1px solid #dfe9e6;border-radius:8px" onclick="this.select()">' . esc_textarea( $code ) . '</textarea>' .
			'<p class="myzt-small">Change <code>data-currency="' . esc_html( $cur ) . '"</code> to USD, GBP, SAR, AED, INR, BDT or any of about 50 currencies.</p></div>';
	}

	public static function fidya() {
		return self::widget( 'fidya', array() );
	}

	public static function khums() {
		return self::widget( 'khums', array() );
	}

	// Same figures as engine.js: 1 dirham = 3.0618 g; diyat = 30,630 g of silver (PPC s. 323).
	const DIRHAM_G       = 3.0618;
	const DIYAT_SILVER_G = 30630;
	const DIYAT_FY       = '2026-27';
	const DIYAT_PKR      = 19352390;

	/** [zakat_mehr currency="PKR"]: minimum mehr and Mehr-e-Fatimi in today's money, server-rendered for search engines. */
	public static function mehr( $atts ) {
		$a   = shortcode_atts( array( 'currency' => 'PKR' ), $atts, 'zakat_mehr' );
		$cur = strtoupper( preg_replace( '/[^A-Za-z]/', '', $a['currency'] ) );
		$p   = self::prices_for( $cur );
		$in  = '';
		if ( $p ) {
			$rows = '';
			foreach ( array( 'Minimum mehr (Hanafi), 10 dirham' => 10, 'Mehr-e-Fatimi, 500 dirham' => 500 ) as $label => $d ) {
				$g     = $d * self::DIRHAM_G;
				$rows .= '<tr><td>' . esc_html( $label ) . '</td><td>' . esc_html( number_format( $g, 2 ) ) . ' g · ' . esc_html( number_format( $g / 11.6638038, 2 ) ) . ' tola</td><td class="z">' . esc_html( self::money( $g * $p['silver'], $cur ) ) . '</td></tr>';
			}
			$in = '<div class="myzt-card"><table class="myzt-table"><thead><tr><th>Mehr</th><th>Silver</th><th>Value today</th></tr></thead><tbody>' . $rows . '</tbody></table><p class="myzt-small">Updated ' . esc_html( wp_date( 'j M Y, H:i', $p['updated'] ) ) . ' · ' . esc_html( $p['label'] ) . '</p></div>';
		}
		return self::widget( 'mehr', array( 'currency' => $cur ), $in );
	}

	/** [zakat_diyat]: notified diyat and the live value of 30,630 g of silver, in rupees. */
	public static function diyat() {
		$p  = self::prices_for( 'PKR' );
		$in = '<div class="myzt-card"><p>Diyat notified for ' . esc_html( self::DIYAT_FY ) . ': <strong>' . esc_html( self::money( self::DIYAT_PKR, 'PKR' ) ) . '</strong></p>' .
			( $p ? '<p>30,630 g of silver at today\'s rate: <strong>' . esc_html( self::money( self::DIYAT_SILVER_G * $p['silver'], 'PKR' ) ) . '</strong> (updated ' . esc_html( wp_date( 'j M Y, H:i', $p['updated'] ) ) . ')</p>' : '' ) . '</div>';
		return self::widget( 'diyat', array(), $in );
	}

	/**
	 * [zakat_wirasat madhab=""]: the inheritance calculator with the shajra and PDF report, in Urdu on Urdu pages and in English elsewhere.
	 * It is a page of its own (assets/wirasat/app.html, built from src/wirasat/ by tools/build-wirasat.js)
	 * shown in a frame, so the theme's styles cannot change the shajra. The frame grows to the
	 * calculator's height, which the page reports with postMessage (assets/js/wirasat-frame.js).
	 */
	public static function wirasat( $atts ) {
		$a   = shortcode_atts( array( 'madhab' => '' ), $atts, 'zakat_wirasat' );
		// rates: the frame shows each heir's gold and silver at today's cached rate (same site only).
		$ur  = MYZT_SEO::is_ur();
		// The English page gets the English calculator (FIX-114); Urdu pages keep the Urdu one.
		$src = add_query_arg( array_filter( array( 'ver' => MYZAKATTOOL_VERSION, 'madhab' => sanitize_key( $a['madhab'] ), 'lang' => $ur ? '' : 'en', 'rates' => rawurlencode( rest_url( 'myzakattool/v1/rates' ) ) ) ), MYZAKATTOOL_URL . 'assets/wirasat/app.html' );
		self::enqueue();
		wp_enqueue_script( 'myzt-wirasat-frame', MYZAKATTOOL_URL . 'assets/js/wirasat-frame.js', array(), MYZAKATTOOL_VERSION, array( 'in_footer' => true ) );
		return '<div class="myzt myzt-wirasat alignwide"><iframe class="myzt-wirasat-frame" src="' . esc_url( $src ) . '" ' . ( $ur ? 'title="وراثت کیلکولیٹر اور شجرہ" lang="ur"' : 'title="Islamic inheritance calculator and family tree" lang="en"' ) . ' loading="lazy" scrolling="no"></iframe></div>';
	}

	/** [myzt_mehr type="fatimi|minimum" currency="PKR"] and [myzt_diyat type="notified|live"]: one number inside text. */
	public static function mehr_inline( $atts ) {
		$a   = shortcode_atts( array( 'type' => 'fatimi', 'currency' => 'PKR' ), $atts, 'myzt_mehr' );
		$cur = strtoupper( preg_replace( '/[^A-Za-z]/', '', $a['currency'] ) );
		$p   = self::prices_for( $cur );
		return $p ? esc_html( self::money( ( 'minimum' === $a['type'] ? 10 : 500 ) * self::DIRHAM_G * $p['silver'], $cur ) ) : '—';
	}

	public static function diyat_inline( $atts ) {
		$a = shortcode_atts( array( 'type' => 'notified' ), $atts, 'myzt_diyat' );
		if ( 'live' !== $a['type'] ) {
			return esc_html( self::money( self::DIYAT_PKR, 'PKR' ) );
		}
		$p = self::prices_for( 'PKR' );
		return $p ? esc_html( self::money( self::DIYAT_SILVER_G * $p['silver'], 'PKR' ) ) : '—';
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
		$h = '<h2 class="myzt-faq-h">' . ( MYZT_SEO::is_ur() ? 'اکثر پوچھے جانے والے سوالات' : 'Frequently asked questions' ) . '</h2><div class="myzt myzt-faq">';
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
		$ur       = MYZT_SEO::is_ur();
		$l        = $ur
			? array( 'by' => 'تحریر:', 'reviewed' => 'نظرِ ثانی:', 'updated' => 'تازہ ترین:', 'how' => 'ہم حساب کیسے کرتے ہیں' )
			: array( 'by' => 'By', 'reviewed' => 'Reviewed by', 'updated' => 'Updated', 'how' => 'How we calculate' );
		$review   = $s['reviewer'] ? ' · <b>' . $l['reviewed'] . '</b> ' . esc_html( $s['reviewer'] ) : '';
		return '<div class="myzt myzt-author"' . ( $ur ? ' dir="rtl"' : '' ) . '><span class="av" aria-hidden="true">' . esc_html( $initials ) . '</span><div><b>' . $l['by'] . '</b> ' . $name . $review .
			' · ' . $l['updated'] . ' <span dir="ltr">' . esc_html( $modified ) . '</span> · <a href="' . esc_url( self::page_url( 'methodology' ) ) . '">' . $l['how'] . '</a> · <a href="mailto:' . esc_attr( $s['contact_email'] ) . '">' . esc_html( $s['contact_email'] ) . '</a></div></div>';
	}

	public static function answer( $atts, $content = '' ) {
		self::enqueue();
		$a = shortcode_atts( array( 'q' => '' ), $atts, 'myzt_answer' );
		return '<div class="myzt myzt-answer"><div class="k">' . ( MYZT_SEO::is_ur() ? 'مختصر جواب' : 'Quick answer' ) . '</div><p><b>' . esc_html( $a['q'] ) . '</b> ' . wp_kses_post( do_shortcode( $content ) ) . self::as_of( $content ) . '</p></div>';
	}

	/** " (rate of 18 Oct 2026, 11:45 GMT)" after a quick answer that quotes a live figure, so a copied snippet keeps its date (FIX-144). */
	private static function as_of( $content ) {
		if ( ! preg_match( '/\[myzt_(rate|mehr)\b|\[myzt_diyat[^\]]*live/', $content ) ) {
			return '';
		}
		$t = (int) self::config()['rates']['updated'];
		if ( ! $t ) {
			return '';
		}
		$when = '<time datetime="' . esc_attr( gmdate( 'c', $t ) ) . '">' . esc_html( gmdate( 'j M Y, H:i', $t ) ) . ' GMT</time>';
		return MYZT_SEO::is_ur()
			? ' <span class="myzt-asof">(ریٹ: <span dir="ltr">' . $when . '</span>)</span>'
			: ' <span class="myzt-asof">(rate of ' . $when . ')</span>';
	}

	public static function trust() {
		self::enqueue();
		$s     = MYZT_Settings::get();
		$ur    = MYZT_SEO::is_ur();
		$items = $ur
			? array( '✓ ہر مسلک کے حوالے موجود', '✓ آپ کا ڈیٹا آپ کے آلے پر ہی رہتا ہے', '✓ سونے اور چاندی کے تازہ ریٹ' )
			: array( '✓ Sources listed for each madhab', '✓ Your data stays on your device', '✓ Live gold &amp; silver rates' );
		if ( $s['reviewer'] ) {
			$items[] = ( $ur ? '✓ نظرِ ثانی: ' : '✓ Reviewed by ' ) . esc_html( $s['reviewer'] );
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
