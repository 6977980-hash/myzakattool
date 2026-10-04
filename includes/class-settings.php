<?php
/**
 * Settings and admin page (Settings → My Zakat Tool).
 *
 * @package MyZakatTool
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MYZT_Settings {

	const OPTION = 'myzt_settings';

	public static function defaults() {
		return array(
			'author_name'     => 'Ali Ahmad',
			'author_url'      => 'https://www.linkedin.com/in/ali-ahmad-chaudhry-12777486/',
			'contact_email'   => 'contact@myzakattool.com',
			'reviewer'        => '',
			'seo_enabled'     => 1,
			'ads_enabled'     => 0,
			'ads_client'      => '',
			'ad_slot_calc'    => '',
			'ad_slot_article' => '',
			'ad_slot_sidebar' => '',
			'ads_label'       => 1,
			'fitrana_currency' => 'PKR',
			'fitrana_wheat'   => '',
			'fitrana_barley'  => '',
			'fitrana_dates'   => '',
			'fitrana_raisins' => '',
			'fitrana_note'    => '',
			'gold_override'   => '',
			'silver_override' => '',
			'security_email'  => '',
			'login_slug'      => '',
			'rules_reviewed'  => '2026-10-04',
			'gsc_verify'      => '',
			'bing_verify'     => '',
		);
	}

	public static function get( $key = null ) {
		$s = wp_parse_args( (array) get_option( self::OPTION, array() ), self::defaults() );
		if ( null === $key ) {
			return $s;
		}
		return isset( $s[ $key ] ) ? $s[ $key ] : null;
	}

	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'menu' ) );
		add_action( 'admin_init', array( __CLASS__, 'register' ) );
		add_action( 'admin_post_myzt_refresh', array( __CLASS__, 'handle_refresh' ) );
		add_action( 'admin_post_myzt_pages', array( __CLASS__, 'handle_pages' ) );
		add_action( 'admin_post_myzt_theme', array( __CLASS__, 'handle_theme' ) );
		add_filter( 'plugin_action_links_' . plugin_basename( MYZAKATTOOL_FILE ), array( __CLASS__, 'action_link' ) );
	}

	public static function action_link( $links ) {
		array_unshift( $links, '<a href="' . esc_url( admin_url( 'options-general.php?page=myzakattool' ) ) . '">' . esc_html__( 'Settings', 'myzakattool' ) . '</a>' );
		return $links;
	}

	public static function menu() {
		add_options_page( 'My Zakat Tool', 'My Zakat Tool', 'manage_options', 'myzakattool', array( __CLASS__, 'page' ) );
	}

	public static function register() {
		register_setting( 'myzt', self::OPTION, array( 'sanitize_callback' => array( __CLASS__, 'sanitize' ) ) );
	}

	public static function sanitize( $in ) {
		$d   = self::defaults();
		$out = array();
		$in  = is_array( $in ) ? $in : array();
		foreach ( $d as $k => $v ) {
			$val = isset( $in[ $k ] ) ? $in[ $k ] : '';
			switch ( $k ) {
				case 'seo_enabled':
				case 'ads_enabled':
				case 'ads_label':
					$out[ $k ] = empty( $val ) ? 0 : 1;
					break;
				case 'author_url':
					$out[ $k ] = esc_url_raw( $val );
					break;
				case 'contact_email':
				case 'security_email':
					$out[ $k ] = sanitize_email( $val );
					break;
				case 'ads_client':
					$val       = strtolower( trim( $val ) );
					$out[ $k ] = preg_match( '/^ca-pub-\d{10,20}$/', $val ) ? $val : '';
					break;
				case 'ad_slot_calc':
				case 'ad_slot_article':
				case 'ad_slot_sidebar':
					$out[ $k ] = preg_replace( '/\D/', '', $val );
					break;
				case 'fitrana_currency':
					$val       = strtoupper( preg_replace( '/[^A-Za-z]/', '', $val ) );
					$out[ $k ] = strlen( $val ) === 3 ? $val : 'PKR';
					break;
				case 'fitrana_wheat':
				case 'fitrana_barley':
				case 'fitrana_dates':
				case 'fitrana_raisins':
				case 'gold_override':
				case 'silver_override':
					$out[ $k ] = '' === trim( (string) $val ) ? '' : (string) max( 0, (float) $val );
					break;
				case 'login_slug':
					$val       = sanitize_title( $val );
					$reserved  = array( 'login', 'admin', 'wp-admin', 'wp-login', 'dashboard', 'wp-login-php' );
					$out[ $k ] = ( strlen( $val ) >= 6 && ! in_array( $val, $reserved, true ) && ! get_page_by_path( $val ) ) ? $val : '';
					if ( '' !== trim( (string) $val ) && '' === $out[ $k ] ) {
						add_settings_error( self::OPTION, 'login_slug', __( 'Login address not saved: use at least 6 letters/numbers that are not a page name or "admin"/"login".', 'myzakattool' ) );
					}
					break;
				case 'rules_reviewed':
					$out[ $k ] = preg_match( '/^\d{4}-\d{2}-\d{2}$/', (string) $val ) ? $val : $d[ $k ];
					break;
				case 'gsc_verify':
				case 'bing_verify':
					// Accept either the bare code or the whole <meta> tag pasted from the console.
					if ( preg_match( '/content=["\']([^"\']+)["\']/', (string) $val, $m ) ) {
						$val = $m[1];
					}
					$out[ $k ] = preg_replace( '/[^A-Za-z0-9_\-]/', '', (string) $val );
					break;
				default:
					$out[ $k ] = sanitize_text_field( $val );
			}
		}
		return $out;
	}

	public static function handle_refresh() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Not allowed.', 'myzakattool' ), 403 );
		}
		check_admin_referer( 'myzt_refresh' );
		delete_transient( 'myzt_refresh_lock' );
		MYZT_Rates::refresh();
		wp_safe_redirect( admin_url( 'options-general.php?page=myzakattool&refreshed=1' ) );
		exit;
	}

	/** One click: install GeneratePress from WordPress.org (if missing) and activate it. */
	public static function handle_theme() {
		if ( ! current_user_can( 'install_themes' ) || ! current_user_can( 'switch_themes' ) ) {
			wp_die( esc_html__( 'Not allowed.', 'myzakattool' ), 403 );
		}
		check_admin_referer( 'myzt_theme' );
		$ok = 'generatepress' === get_stylesheet();
		if ( ! $ok ) {
			if ( ! wp_get_theme( 'generatepress' )->exists() ) {
				require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
				require_once ABSPATH . 'wp-admin/includes/theme.php';
				$api = themes_api( 'theme_information', array( 'slug' => 'generatepress', 'fields' => array( 'sections' => false ) ) );
				if ( ! is_wp_error( $api ) && ! empty( $api->download_link ) ) {
					$up = new Theme_Upgrader( new Automatic_Upgrader_Skin() );
					$up->install( $api->download_link );
				}
			}
			if ( wp_get_theme( 'generatepress' )->exists() ) {
				switch_theme( 'generatepress' );
				$ok = true;
			}
		}
		wp_safe_redirect( admin_url( 'options-general.php?page=myzakattool&theme=' . ( $ok ? 1 : 0 ) ) );
		exit;
	}

	public static function handle_pages() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Not allowed.', 'myzakattool' ), 403 );
		}
		check_admin_referer( 'myzt_pages' );
		$n = MYZT_Installer::create_pages();
		wp_safe_redirect( admin_url( 'options-general.php?page=myzakattool&pages=' . (int) $n ) );
		exit;
	}

	private static function input( $key, $label, $type = 'text', $help = '' ) {
		$s    = self::get();
		$name = self::OPTION . '[' . $key . ']';
		echo '<tr><th scope="row"><label for="myzt-' . esc_attr( $key ) . '">' . esc_html( $label ) . '</label></th><td>';
		if ( 'checkbox' === $type ) {
			echo '<input type="checkbox" id="myzt-' . esc_attr( $key ) . '" name="' . esc_attr( $name ) . '" value="1" ' . checked( 1, (int) $s[ $key ], false ) . '>';
		} else {
			echo '<input class="regular-text" type="' . esc_attr( $type ) . '" id="myzt-' . esc_attr( $key ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $s[ $key ] ) . '">';
		}
		if ( $help ) {
			echo '<p class="description">' . wp_kses_post( $help ) . '</p>';
		}
		echo '</td></tr>';
	}

	public static function page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$r = MYZT_Rates::get();
		?>
		<div class="wrap">
			<h1>My Zakat Tool</h1>
			<?php if ( isset( $_GET['refreshed'] ) ) : // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>
				<div class="notice notice-success"><p><?php esc_html_e( 'Rates refreshed.', 'myzakattool' ); ?></p></div>
			<?php endif; ?>
			<?php if ( isset( $_GET['pages'] ) ) : // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>
				<div class="notice notice-success"><p><?php echo esc_html( sprintf( __( '%d missing pages created.', 'myzakattool' ), absint( $_GET['pages'] ) ) ); // phpcs:ignore ?></p></div>
			<?php endif; ?>

			<h2><?php esc_html_e( 'Live rates', 'myzakattool' ); ?></h2>
			<table class="widefat striped" style="max-width:720px">
				<tr><td><?php esc_html_e( 'Gold (USD / troy oz)', 'myzakattool' ); ?></td><td><?php echo esc_html( isset( $r['goldUsdOz'] ) ? number_format( $r['goldUsdOz'], 2 ) : '—' ); ?></td></tr>
				<tr><td><?php esc_html_e( 'Silver (USD / troy oz)', 'myzakattool' ); ?></td><td><?php echo esc_html( isset( $r['silverUsdOz'] ) ? number_format( $r['silverUsdOz'], 2 ) : '—' ); ?></td></tr>
				<tr><td><?php esc_html_e( 'USD → PKR', 'myzakattool' ); ?></td><td><?php echo esc_html( isset( $r['fx']['pkr'] ) ? number_format( $r['fx']['pkr'], 2 ) : '—' ); ?></td></tr>
				<tr><td><?php esc_html_e( 'Metal source', 'myzakattool' ); ?></td><td><?php echo esc_html( isset( $r['metalSource'] ) ? $r['metalSource'] : '—' ); ?></td></tr>
				<tr><td><?php esc_html_e( 'Last updated', 'myzakattool' ); ?></td><td><?php echo esc_html( ! empty( $r['updated'] ) ? wp_date( 'j M Y, H:i', $r['updated'] ) : '—' ); ?></td></tr>
				<tr><td><?php esc_html_e( 'Last attempt', 'myzakattool' ); ?></td><td><?php echo esc_html( ! empty( $r['lastAttempt'] ) ? wp_date( 'j M Y, H:i', $r['lastAttempt'] ) . ( empty( $r['lastOk'] ) ? ' (partly failed)' : ' (ok)' ) : '—' ); ?></td></tr>
			</table>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="margin:10px 0 0">
				<?php wp_nonce_field( 'myzt_refresh' ); ?>
				<input type="hidden" name="action" value="myzt_refresh">
				<?php submit_button( __( 'Refresh rates now', 'myzakattool' ), 'secondary', 'submit', false ); ?>
			</form>
			<p class="description"><?php echo esc_html__( 'Rates refresh every hour through WP-Cron. For reliable updates on a low-traffic site, add a Hostinger cron job (every 15 minutes):', 'myzakattool' ) . ' <code>wget -q -O - ' . esc_html( site_url( 'wp-cron.php?doing_wp_cron' ) ) . ' &gt;/dev/null 2&gt;&amp;1</code>'; ?></p>

			<h2><?php esc_html_e( 'Theme', 'myzakattool' ); ?></h2>
			<?php if ( isset( $_GET['theme'] ) ) : // phpcs:ignore ?>
				<div class="notice <?php echo $_GET['theme'] ? 'notice-success' : 'notice-error'; // phpcs:ignore ?>"><p><?php echo $_GET['theme'] ? esc_html__( 'GeneratePress is active and the main menu is in place.', 'myzakattool' ) : esc_html__( 'Could not install GeneratePress automatically. Install it from Appearance → Themes → Add New.', 'myzakattool' ); // phpcs:ignore ?></p></div>
			<?php endif; ?>
			<?php if ( 'generatepress' === get_stylesheet() ) : ?>
				<p><?php esc_html_e( 'GeneratePress is active.', 'myzakattool' ); ?></p>
			<?php else : ?>
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<?php wp_nonce_field( 'myzt_theme' ); ?>
					<input type="hidden" name="action" value="myzt_theme">
					<p class="description"><?php esc_html_e( 'GeneratePress is a free, fast theme that suits the calculator. One click installs it from WordPress.org, activates it and sets the menu.', 'myzakattool' ); ?></p>
					<?php submit_button( __( 'Install and activate GeneratePress', 'myzakattool' ), 'primary', 'submit', false ); ?>
				</form>
			<?php endif; ?>

			<h2><?php esc_html_e( 'Pages', 'myzakattool' ); ?></h2>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<?php wp_nonce_field( 'myzt_pages' ); ?>
				<input type="hidden" name="action" value="myzt_pages">
				<p class="description"><?php esc_html_e( 'Creates any of the site pages (calculator, madhab pages, guides, legal pages) that do not exist yet. Existing pages are never changed.', 'myzakattool' ); ?></p>
				<?php submit_button( __( 'Create missing pages', 'myzakattool' ), 'secondary', 'submit', false ); ?>
			</form>

			<form method="post" action="options.php">
				<?php settings_fields( 'myzt' ); ?>
				<h2><?php esc_html_e( 'Author and trust (E-E-A-T)', 'myzakattool' ); ?></h2>
				<table class="form-table" role="presentation">
					<?php
					self::input( 'author_name', __( 'Author name', 'myzakattool' ) );
					self::input( 'author_url', __( 'Author profile (LinkedIn)', 'myzakattool' ), 'url' );
					self::input( 'contact_email', __( 'Contact email', 'myzakattool' ), 'email' );
					self::input( 'reviewer', __( 'Scholar reviewer (name, title)', 'myzakattool' ), 'text', __( 'Leave empty until a scholar has actually reviewed the rules. When filled, pages show "Reviewed by" and the schema adds reviewedBy.', 'myzakattool' ) );
					self::input( 'security_email', __( 'security.txt email', 'myzakattool' ), 'email', __( 'Defaults to the contact email.', 'myzakattool' ) );
					self::input( 'rules_reviewed', __( 'Rules last reviewed on', 'myzakattool' ), 'date', __( 'Shown as "Rules last reviewed" on the nisab, gold rate and methodology pages. Update it whenever you or a scholar check the rules again.', 'myzakattool' ) );
					self::input( 'seo_enabled', __( 'Built-in SEO (meta, Open Graph, schema)', 'myzakattool' ), 'checkbox', __( 'Switches itself off automatically when Rank Math, Yoast or All in One SEO is active (the schema for calculators stays).', 'myzakattool' ) );
					?>
				</table>

				<h2><?php esc_html_e( 'Security and Search Console', 'myzakattool' ); ?></h2>
				<p><?php echo esc_html__( 'Your login address:', 'myzakattool' ) . ' <code>' . esc_html( MYZT_Security::login_address() ) . '</code>'; ?> <strong><?php esc_html_e( 'Bookmark it.', 'myzakattool' ); ?></strong></p>
				<table class="form-table" role="presentation">
					<?php
					self::input( 'login_slug', __( 'Secret login address', 'myzakattool' ), 'text', sprintf( /* translators: %s: site URL */ __( 'Example: zakat-team-77 makes the login page %s/zakat-team-77/. The old wp-login.php and wp-admin then show "not found" to visitors. Leave empty to keep the normal login. Forgot it? Add define( \'MYZT_NO_LOGIN_SLUG\', true ); to wp-config.php.', 'myzakattool' ), untrailingslashit( home_url() ) ) );
					self::input( 'gsc_verify', __( 'Google Search Console code', 'myzakattool' ), 'text', __( 'Search Console → Add property → URL prefix → HTML tag. Paste the tag or just its content code here, save, then press Verify there.', 'myzakattool' ) );
					self::input( 'bing_verify', __( 'Bing Webmaster code', 'myzakattool' ), 'text', __( 'Optional. Bing can also import the site straight from Search Console.', 'myzakattool' ) );
					?>
				</table>
				<p class="description"><?php esc_html_e( 'Always on: 5 failed logins lock that IP for 15 minutes, generic login errors, no username discovery, XML-RPC off, security headers.', 'myzakattool' ); ?></p>

				<h2><?php esc_html_e( 'Google AdSense', 'myzakattool' ); ?></h2>
				<table class="form-table" role="presentation">
					<?php
					self::input( 'ads_enabled', __( 'Show ads', 'myzakattool' ), 'checkbox', __( 'While off, no ad space exists on any page. When on, each slot keeps a fixed height so the page never jumps; an unfilled slot stays as plain empty space.', 'myzakattool' ) );
					self::input( 'ads_client', __( 'Publisher ID', 'myzakattool' ), 'text', __( 'Format: ca-pub-1234567890123456. Also used for ads.txt.', 'myzakattool' ) );
					self::input( 'ad_slot_calc', __( 'Slot ID: below calculator', 'myzakattool' ) );
					self::input( 'ad_slot_article', __( 'Slot ID: inside articles', 'myzakattool' ) );
					self::input( 'ad_slot_sidebar', __( 'Slot ID: sidebar (desktop)', 'myzakattool' ), 'text', __( 'Place the shortcode [myzt_ad slot="sidebar"] in a sidebar widget.', 'myzakattool' ) );
					self::input( 'ads_label', __( 'Show small "Advertisement" label', 'myzakattool' ), 'checkbox' );
					?>
				</table>
				<p class="description"><?php esc_html_e( 'In AdSense, keep Auto ads and anchor ads off: the calculator already has a sticky result bar at the bottom on mobile.', 'myzakattool' ); ?></p>

				<h2><?php esc_html_e( 'Fitrana', 'myzakattool' ); ?></h2>
				<table class="form-table" role="presentation">
					<?php
					self::input( 'fitrana_currency', __( 'Currency for these amounts', 'myzakattool' ) );
					self::input( 'fitrana_wheat', __( 'Per person: wheat / flour', 'myzakattool' ), 'number' );
					self::input( 'fitrana_barley', __( 'Per person: barley', 'myzakattool' ), 'number' );
					self::input( 'fitrana_dates', __( 'Per person: dates', 'myzakattool' ), 'number' );
					self::input( 'fitrana_raisins', __( 'Per person: raisins', 'myzakattool' ), 'number' );
					self::input( 'fitrana_note', __( 'Note under the calculator', 'myzakattool' ), 'text', __( 'For example who announced the amounts and when.', 'myzakattool' ) );
					?>
				</table>

				<h2><?php esc_html_e( 'Emergency rate override', 'myzakattool' ); ?></h2>
				<table class="form-table" role="presentation">
					<?php
					self::input( 'gold_override', __( 'Gold USD / troy oz', 'myzakattool' ), 'number', __( 'Only if every rate source fails. Leave empty normally.', 'myzakattool' ) );
					self::input( 'silver_override', __( 'Silver USD / troy oz', 'myzakattool' ), 'number' );
					?>
				</table>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}
}
