<?php
/**
 * Creates the site's pages, guide posts, menu and basic settings.
 *
 * Runs on activation and whenever the plugin version changes (Git deploys do not fire the
 * activation hook). It only creates what is missing and never overwrites edited content.
 *
 * @package MyZakatTool
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MYZT_Installer {

	private static $pages = null;

	private static $changed = array();

	public static function init() {
		add_action( 'admin_init', array( __CLASS__, 'maybe_upgrade' ) );
		add_shortcode( 'myzt_guides', array( __CLASS__, 'guides_list' ) );
		add_action( 'wp_footer', array( __CLASS__, 'footer_links' ), 50 );
		add_action( 'after_switch_theme', array( __CLASS__, 'menu' ) );
		add_action( 'after_switch_theme', array( __CLASS__, 'logo' ) );
		add_action( 'wp_head', array( __CLASS__, 'logo_css' ), 20 );
		add_filter( 'generate_logo_output', array( __CLASS__, 'logo_small' ) );
		add_filter( 'generate_copyright', array( __CLASS__, 'copyright' ) );
		add_filter( 'widget_display_callback', array( __CLASS__, 'hide_default_widgets' ), 10, 2 );
		add_action( 'generate_before_right_sidebar_content', array( __CLASS__, 'sidebar_links' ) );
	}

	/** Zakat season year: the year of the coming Ramadan (Ramadan starts in February in 2026-2027 and in January in 2028-2030, always before May). */
	public static function season_year() {
		$y = (int) gmdate( 'Y' );
		return (int) gmdate( 'n' ) >= 5 ? $y + 1 : $y;
	}

	/** All page and post definitions keyed by slug (posts included for links and breadcrumbs). */
	public static function pages() {
		if ( null === self::$pages ) {
			require_once MYZAKATTOOL_DIR . 'includes/content.php';
			require_once MYZAKATTOOL_DIR . 'includes/content-urdu.php';
			self::$pages = array_merge( myzt_content_pages(), myzt_content_urdu() );
			foreach ( myzt_content_posts() as $slug => $post ) {
				$post['hub']           = 'guides';
				$post['is_post']       = true;
				self::$pages[ $slug ] = $post;
			}
		}
		return self::$pages;
	}

	public static function maybe_upgrade() {
		if ( get_option( 'myzt_version' ) === MYZAKATTOOL_VERSION ) {
			return;
		}
		// One run at a time: two admin requests at once (page + admin-ajax) used to create
		// every new page and menu item twice. add_option() fails if the row already exists.
		if ( ! add_option( 'myzt_upgrading', time(), '', false ) ) {
			if ( time() - (int) get_option( 'myzt_upgrading' ) < 300 ) {
				return;
			}
			update_option( 'myzt_upgrading', time(), false );
		}
		self::install();
		delete_option( 'myzt_upgrading' );
	}

	public static function install() {
		$first = ! get_option( 'myzt_installed' );
		if ( $first ) {
			self::site_basics();
		}
		self::create_pages();
		self::menu();
		self::menu_additions();
		self::logo();
		self::root_favicon();
		if ( $first ) {
			update_option( 'myzt_installed', time() );
		}
		update_option( 'myzt_version', MYZAKATTOOL_VERSION );
		// Menu and footer changes show on every page, so the page cache starts fresh.
		do_action( 'litespeed_purge_all' );
		MYZT_Cache::released( self::$changed );
		MYZT_Rates::ensure_schedule();
		if ( ! MYZT_Rates::get() ) {
			MYZT_Rates::refresh();
		}
	}

	/** Some hosts answer /favicon.ico with a static 404 before WordPress runs: place a real file at the root. */
	private static function root_favicon() {
		$dest = ABSPATH . 'favicon.ico';
		if ( ! file_exists( $dest ) && wp_is_writable( ABSPATH ) ) {
			@copy( MYZAKATTOOL_DIR . 'assets/img/favicon.ico', $dest ); // phpcs:ignore WordPress.PHP.NoSilencedErrors
		}
	}

	private static function site_basics() {
		update_option( 'blogname', 'My Zakat Tool' );
		update_option( 'blogdescription', 'Zakat Calculator for Every Madhab with Live Gold Rates' );
		if ( ! get_option( 'permalink_structure' ) ) {
			update_option( 'permalink_structure', '/%postname%/' );
		}
		update_option( 'default_comment_status', 'closed' );
		update_option( 'default_ping_status', 'closed' );
		// Remove thin default content that hurts SEO, only if untouched.
		foreach ( array( 'hello-world' => 'post', 'sample-page' => 'page' ) as $slug => $type ) {
			$p = get_page_by_path( $slug, OBJECT, $type );
			if ( $p && $p->post_modified_gmt === $p->post_date_gmt ) {
				wp_trash_post( $p->ID );
			}
		}
		flush_rewrite_rules( false );
	}

	/** Creates missing pages and guide posts. Returns how many were created. */
	public static function create_pages() {
		$created = 0;
		$ids     = array();
		$cat     = term_exists( 'guides', 'category' );
		if ( ! $cat ) {
			$cat = wp_insert_term( 'Guides', 'category', array( 'slug' => 'guides' ) );
		}
		$cat_id = is_array( $cat ) ? (int) $cat['term_id'] : 0;

		foreach ( self::pages() as $slug => $def ) {
			$type     = empty( $def['is_post'] ) ? 'page' : 'post';
			$existing = get_page_by_path( $slug, OBJECT, $type );
			// WordPress ships a draft "privacy-policy" page; replace it with ours if untouched.
			if ( $existing && 'privacy-policy' === $slug && 'draft' === $existing->post_status && $existing->post_modified_gmt === $existing->post_date_gmt ) {
				wp_update_post(
					array(
						'ID'           => $existing->ID,
						'post_content' => $def['content'],
						'post_title'   => $def['title'],
						'post_status'  => 'publish',
					)
				);
				self::meta( $existing->ID, $def );
				update_post_meta( $existing->ID, '_myzt_hash', md5( get_post_field( 'post_content', $existing->ID ) ) );
				update_post_meta( $existing->ID, '_myzt_src', md5( $def['content'] ) );
				self::$changed[] = $existing->ID;
				$ids[ $slug ] = $existing->ID;
				++$created;
				continue;
			}
			if ( $existing ) {
				$ids[ $slug ] = $existing->ID;
				self::refresh( $existing, $def );
				self::visibility( $existing, $def );
				continue;
			}
			$postarr = array(
				'post_type'      => $type,
				'post_status'    => empty( $def['hidden'] ) ? 'publish' : 'draft',
				'post_title'     => $def['title'],
				'post_name'      => $slug,
				'post_content'   => $def['content'],
				'post_excerpt'   => isset( $def['desc'] ) ? MYZT_SEO::fill( $def['desc'], false ) : '',
				'comment_status' => 'closed',
				'ping_status'    => 'closed',
			);
			if ( 'post' === $type && $cat_id ) {
				$postarr['post_category'] = array( $cat_id );
			}
			$id = wp_insert_post( $postarr, true );
			if ( is_wp_error( $id ) ) {
				continue;
			}
			self::meta( $id, $def );
			update_post_meta( $id, '_myzt_hash', md5( get_post_field( 'post_content', $id ) ) );
			update_post_meta( $id, '_myzt_src', md5( $def['content'] ) );
			self::$changed[] = $id;
			$ids[ $slug ] = $id;
			++$created;
		}

		if ( ! empty( $ids['home'] ) && ( 'posts' === get_option( 'show_on_front' ) || ! get_option( 'page_on_front' ) ) ) {
			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $ids['home'] );
		}
		if ( ! empty( $ids['privacy-policy'] ) ) {
			update_option( 'wp_page_for_privacy_policy', $ids['privacy-policy'] );
		}
		return $created;
	}

	/**
	 * A page marked 'hidden' is kept as a draft (off the site, the menu and the sitemap) until the
	 * flag is removed; then the draft the plugin made is published again. Drafts the owner made stay drafts.
	 */
	private static function visibility( $post, $def ) {
		if ( ! empty( $def['hidden'] ) && 'publish' === $post->post_status && get_post_meta( $post->ID, '_myzt_managed', true ) ) {
			wp_update_post( array( 'ID' => $post->ID, 'post_status' => 'draft' ) );
			update_post_meta( $post->ID, '_myzt_hidden', 1 );
		} elseif ( empty( $def['hidden'] ) && 'draft' === $post->post_status && get_post_meta( $post->ID, '_myzt_hidden', true ) ) {
			wp_update_post( array( 'ID' => $post->ID, 'post_status' => 'publish' ) );
			delete_post_meta( $post->ID, '_myzt_hidden' );
		}
	}

	/**
	 * Brings a page the plugin created up to date with the current text, but only if nobody has edited it
	 * since (its content still matches what the plugin last wrote, or it was never modified).
	 */
	private static function refresh( $post, $def ) {
		if ( ! get_post_meta( $post->ID, '_myzt_managed', true ) ) {
			return false;
		}
		$hash      = get_post_meta( $post->ID, '_myzt_hash', true );
		$current   = md5( $post->post_content );
		$untouched = $hash ? hash_equals( $hash, $current ) : $post->post_modified_gmt === $post->post_date_gmt;
		// Before 1.6.10 the replaced WordPress privacy draft got no hash, so it looked edited
		// forever. Treat it as untouched if it was last saved at the first install.
		if ( ! $hash && ! $untouched && 'privacy-policy' === $post->post_name ) {
			$installed = (int) get_option( 'myzt_installed' );
			$untouched = $installed && abs( strtotime( $post->post_modified_gmt . ' UTC' ) - $installed ) < 600;
		}
		if ( ! $untouched ) {
			return false;
		}
		// The page's date (dateModified, sitemap lastmod, "Updated") moves only when its text in the plugin
		// changes (FIX-104). Comparing the stored post_content is not enough: WordPress filters it on save,
		// so it never matched and every release re-saved and re-dated every page. _myzt_src remembers the
		// plugin text last written. Pages without it (first run of 1.14.1) just record it: 1.14.0 wrote them minutes before.
		$src     = md5( $def['content'] );
		$written = get_post_meta( $post->ID, '_myzt_src', true );
		$excerpt = isset( $def['desc'] ) ? MYZT_SEO::fill( $def['desc'], false ) : '';
		if ( $written && ! hash_equals( $written, $src ) ) {
			wp_update_post(
				array(
					'ID'           => $post->ID,
					'post_content' => $def['content'],
					'post_title'   => $def['title'],
					'post_excerpt' => $excerpt,
				)
			);
			self::$changed[] = $post->ID;
		} elseif ( $post->post_title !== $def['title'] || $post->post_excerpt !== $excerpt ) {
			// A new title or description is not a content change: write it without touching the date.
			global $wpdb;
			$wpdb->update( $wpdb->posts, array( 'post_title' => $def['title'], 'post_excerpt' => $excerpt ), array( 'ID' => $post->ID ) );
			clean_post_cache( $post->ID );
		}
		update_post_meta( $post->ID, '_myzt_src', $src );
		self::meta( $post->ID, $def );
		update_post_meta( $post->ID, '_myzt_hash', md5( get_post_field( 'post_content', $post->ID ) ) );
		return true;
	}

	/** IDs of pages created or rewritten by this run (for IndexNow). */
	public static function changed() {
		return self::$changed;
	}

	private static function meta( $id, $def ) {
		update_post_meta( $id, '_myzt_managed', 1 );
		update_post_meta( $id, '_myzt_title', $def['seo'] );
		update_post_meta( $id, '_myzt_desc', $def['desc'] );
		if ( ! empty( $def['faq'] ) ) {
			update_post_meta( $id, '_myzt_faq', wp_slash( wp_json_encode( $def['faq'], JSON_UNESCAPED_UNICODE ) ) );
		} else {
			delete_post_meta( $id, '_myzt_faq' );
		}
		if ( in_array( get_post_field( 'post_name', $id ), array( 'privacy-policy', 'terms' ), true ) ) {
			update_post_meta( $id, '_myzt_noindex', 1 );
		}
	}

	/** Puts the main menu in the theme's primary location (creating it once); runs on install and on theme switch. */
	public static function menu() {
		$locations = get_theme_mod( 'nav_menu_locations', array() );
		$registered = get_registered_nav_menus();
		if ( ! $registered ) {
			return;
		}
		$loc = isset( $registered['primary'] ) ? 'primary' : key( $registered );
		if ( ! empty( $locations[ $loc ] ) ) {
			return;
		}
		$menu = wp_get_nav_menu_object( 'Main Menu' );
		if ( $menu ) {
			// Already built earlier (e.g. for the previous theme): just assign it.
			$locations[ $loc ] = $menu->term_id;
			set_theme_mod( 'nav_menu_locations', $locations );
			return;
		}
		$menu_id = wp_create_nav_menu( 'Main Menu' );
		if ( is_wp_error( $menu_id ) ) {
			return;
		}
		$add = function ( $slug, $title, $parent = 0 ) use ( $menu_id ) {
			$p = get_page_by_path( $slug );
			if ( ! $p ) {
				return 0;
			}
			return wp_update_nav_menu_item(
				$menu_id,
				0,
				array(
					'menu-item-title'     => $title,
					'menu-item-object'    => 'page',
					'menu-item-object-id' => $p->ID,
					'menu-item-type'      => 'post_type',
					'menu-item-status'    => 'publish',
					'menu-item-parent-id' => $parent,
				)
			);
		};
		$add( 'home', 'Calculator' );
		$m = $add( 'madhab', 'Madhab' );
		foreach ( array( 'hanafi-zakat-calculator' => 'Hanafi', 'shafi-zakat-calculator' => "Shafi'i", 'maliki-zakat-calculator' => 'Maliki', 'hanbali-zakat-calculator' => 'Hanbali', 'ahl-e-hadith-zakat-calculator' => 'Ahl-e-Hadith', 'shia-zakat-calculator' => "Shia (Ja'fari)", 'madhab-comparison' => 'Comparison' ) as $s => $t ) {
			$add( $s, $t, $m );
		}
		$c = $add( 'calculators', 'Calculators' );
		foreach ( array( 'zakat-calculator-pakistan' => 'Pakistan', 'zakat-on-gold-calculator' => 'Zakat on Gold', 'business-zakat-calculator' => 'Business', 'fitrana-calculator' => 'Fitrana', 'khums-calculator' => 'Khums' ) as $s => $t ) {
			$add( $s, $t, $c );
		}
		$add( 'nisab', 'Nisab Today' );
		$add( 'gold-rate-today', 'Gold Rate' );
		$add( 'guides', 'Guides' );
		$add( 'about', 'About' );
		$locations[ $loc ] = $menu_id;
		set_theme_mod( 'nav_menu_locations', $locations );
	}

	/** Sets the plugin's logo as the theme logo (the favicon set comes from MYZT_SEO), unless the owner already chose their own. */
	public static function logo() {
		if ( get_theme_mod( 'custom_logo' ) ) {
			return;
		}
		$id = (int) get_option( 'myzt_logo_id' );
		if ( ! $id || ! get_post( $id ) ) {
			$src = MYZAKATTOOL_DIR . 'assets/img/icon-512.png';
			$up  = wp_upload_bits( 'my-zakat-tool-logo.png', null, file_get_contents( $src ) ); // phpcs:ignore
			if ( ! empty( $up['error'] ) ) {
				return;
			}
			$id = wp_insert_attachment(
				array(
					'post_title'     => 'My Zakat Tool logo',
					'post_mime_type' => 'image/png',
					'post_status'    => 'inherit',
				),
				$up['file']
			);
			if ( ! $id || is_wp_error( $id ) ) {
				return;
			}
			require_once ABSPATH . 'wp-admin/includes/image.php';
			wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $up['file'] ) );
			update_post_meta( $id, '_wp_attachment_image_alt', 'My Zakat Tool' );
			update_option( 'myzt_logo_id', $id );
		}
		set_theme_mod( 'custom_logo', $id );
		// GeneratePress shows the logo at full size unless a width is set.
		$gp = get_option( 'generate_settings' );
		if ( is_array( $gp ) || false === $gp ) {
			$gp = (array) $gp;
			if ( empty( $gp['logo_width'] ) ) {
				$gp['logo_width'] = 44;
				update_option( 'generate_settings', $gp );
			}
		}
	}

	/** Keeps the header logo small next to the site name in any theme. */
	public static function logo_css() {
		if ( (int) get_theme_mod( 'custom_logo' ) === (int) get_option( 'myzt_logo_id' ) ) {
			echo '<style id="myzt-logo">.site-logo img,.custom-logo{max-height:44px;width:auto}.site-branding-container{display:flex;align-items:center;gap:10px}</style>' . "\n";
		}
	}

	/** [myzt_guides]: list of guide posts. */
	/**
	 * Adds pages that came after the menu was first built (audit FIX-044) to the plugin's "Main Menu".
	 * Each one is added only once, so an item the owner removes stays removed.
	 */
	private static function menu_additions() {
		$menu = wp_get_nav_menu_object( 'Main Menu' );
		if ( ! $menu ) {
			return;
		}
		$done  = (array) get_option( 'myzt_menu_added', array() );
		$items = wp_get_nav_menu_items( $menu->term_id );
		$items = is_array( $items ) ? $items : array();
		$in    = array();
		$defs  = self::pages();
		foreach ( $items as $it ) {
			// Hidden pages come off the menu; they are added again once published.
			$slug = 'page' === $it->object ? get_post_field( 'post_name', (int) $it->object_id ) : '';
			if ( $slug && ! empty( $defs[ $slug ]['hidden'] ) ) {
				wp_delete_post( (int) $it->ID, true );
				$done = array_values( array_diff( $done, array( $slug ) ) );
				continue;
			}
			$in[ (int) $it->object_id ] = (int) $it->ID;
		}
		$calc   = get_page_by_path( 'calculators' );
		$parent = $calc && isset( $in[ $calc->ID ] ) ? $in[ $calc->ID ] : 0;
		$add    = array(
			'fidya-kaffara-calculator' => array( 'Fidya & Kaffara', $parent ),
			'zakat-date-calculator'    => array( 'Zakat Date', $parent ),
			'ushr-calculator'          => array( 'Ushr & Livestock', $parent ),
			'free-zakat-widget'        => array( 'Free Nisab Widget', $parent ),
			'haq-mehr-calculator'      => array( 'Haq Mehr', $parent ),
			'diyat-calculator'         => array( 'Diyat', $parent ),
			'wirasat-calculator'       => array( 'Wirasat', $parent ),
			'zakat-calculator-urdu'    => array( 'اردو', 0 ),
		);
		foreach ( $add as $slug => $item ) {
			if ( in_array( $slug, $done, true ) || ! empty( $defs[ $slug ]['hidden'] ) ) {
				continue;
			}
			$p = get_page_by_path( $slug );
			if ( ! $p ) {
				continue;
			}
			if ( ! isset( $in[ $p->ID ] ) ) {
				wp_update_nav_menu_item(
					$menu->term_id,
					0,
					array(
						'menu-item-title'     => $item[0],
						'menu-item-object'    => 'page',
						'menu-item-object-id' => $p->ID,
						'menu-item-type'      => 'post_type',
						'menu-item-status'    => 'publish',
						'menu-item-parent-id' => $item[1],
					)
				);
			}
			$done[] = $slug;
		}
		update_option( 'myzt_menu_added', $done, false );
	}

	public static function guides_list() {
		$q = new WP_Query(
			array(
				'post_type'      => 'post',
				'category_name'  => 'guides',
				'posts_per_page' => 50,
				'no_found_rows'  => true,
			)
		);
		if ( ! $q->have_posts() ) {
			return '';
		}
		$h = '<ul class="myzt-guides">';
		foreach ( $q->posts as $post ) {
			$h .= '<li><a href="' . esc_url( get_permalink( $post ) ) . '"><strong>' . esc_html( get_the_title( $post ) ) . '</strong></a><br><span style="color:#5d736e">' . esc_html( get_the_excerpt( $post ) ) . '</span></li>';
		}
		return $h . '</ul>';
	}

	/** Trust links in the footer of every page, unless the theme already has a footer menu. */
	public static function footer_links() {
		$locations = get_nav_menu_locations();
		foreach ( array( 'footer', 'footer-menu', 'secondary' ) as $l ) {
			if ( ! empty( $locations[ $l ] ) ) {
				return;
			}
		}
		$links = array( 'methodology' => 'How we calculate', 'about' => 'About', 'contact' => 'Contact', 'disclaimer' => 'Disclaimer', 'privacy-policy' => 'Privacy', 'terms' => 'Terms' );
		$out   = array();
		foreach ( $links as $slug => $label ) {
			if ( get_page_by_path( $slug ) ) {
				$out[] = '<a href="' . esc_url( MYZT_Frontend::page_url( $slug ) ) . '">' . esc_html( $label ) . '</a>';
			}
		}
		// Every tool linked from every page, so the newer ones are not orphaned (audit FIX-044).
		$tools = array( 'calculators' => 'All calculators', 'fitrana-calculator' => 'Fitrana', 'fidya-kaffara-calculator' => 'Fidya & kaffara', 'zakat-date-calculator' => 'Zakat date', 'ushr-calculator' => 'Ushr & livestock', 'khums-calculator' => 'Khums', 'haq-mehr-calculator' => 'Haq mehr', 'diyat-calculator' => 'Diyat', 'wirasat-calculator' => 'Wirasat (inheritance)', 'free-zakat-widget' => 'Free nisab widget' );
		$tl    = array();
		foreach ( $tools as $slug => $label ) {
			if ( get_page_by_path( $slug ) ) {
				$tl[] = '<a href="' . esc_url( MYZT_Frontend::page_url( $slug ) ) . '">' . esc_html( $label ) . '</a>';
			}
		}
		if ( get_page_by_path( 'zakat-calculator-urdu' ) ) {
			$tl[] = '<a href="' . esc_url( MYZT_Frontend::page_url( 'zakat-calculator-urdu' ) ) . '" lang="ur" hreflang="ur">اردو</a>';
		}
		if ( $out ) {
			echo '<nav class="myzt-footer-links" aria-label="Site information" style="text-align:center;font-size:13px;padding:14px 16px;line-height:2">' . ( $tl ? implode( ' · ', $tl ) . '<br>' : '' ) . implode( ' · ', $out ) . '<br><span style="color:#556a65">Estimates only, not a fatwa. © ' . esc_html( gmdate( 'Y' ) ) . ' My Zakat Tool</span></nav>'; // phpcs:ignore
		}
	}

	/** The header shows the logo at 44 px: serve a 96 px file (2x) instead of the 512 px upload (FIX-123). */
	public static function logo_small( $html ) {
		if ( (int) get_theme_mod( 'custom_logo' ) !== (int) get_option( 'myzt_logo_id' ) ) {
			return $html;
		}
		return '<div class="site-logo"><a href="' . esc_url( home_url( '/' ) ) . '" rel="home"><img class="header-image is-logo-image" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" src="' . esc_url( MYZAKATTOOL_URL . 'assets/img/logo-96.png?ver=' . MYZAKATTOOL_VERSION ) . '" width="44" height="44"></a></div>';
	}

	/** Our footer already carries the copyright; drop the theme's "Built with GeneratePress" link on every page (FIX-106). */
	public static function copyright() {
		return '';
	}

	/**
	 * WordPress's starter sidebar blocks (search, recent posts, "Recent Comments: No comments to show",
	 * archives, categories) are hidden; widgets the owner adds still show (FIX-107).
	 */
	public static function hide_default_widgets( $instance, $widget ) {
		if ( is_array( $instance ) && 'block' === $widget->id_base && ! empty( $instance['content'] )
			&& preg_match( '/<!-- wp:(search|latest-posts|latest-comments|archives|categories)[ \/]/', $instance['content'] ) ) {
			return false;
		}
		return $instance;
	}

	/** A fixed list of the main tools and guides at the top of the sidebar, in place of the rotating "Recent Posts" (FIX-107). */
	public static function sidebar_links() {
		$groups = array(
			'Calculators'    => array( 'home', 'zakat-calculator-pakistan', 'zakat-on-gold-calculator', 'business-zakat-calculator', 'fitrana-calculator', 'wirasat-calculator', 'nisab', 'gold-rate-today', 'calculators' ),
			'Popular guides' => array( 'zakat-2027-pakistan', 'who-can-receive-zakat', 'zakat-on-jewellery', 'bank-zakat-deduction-pakistan', 'zakat-on-1-tola-gold', 'missed-zakat-past-years', 'daughters-share-in-inheritance', 'guides' ),
		);
		$pages = self::pages();
		$here  = untrailingslashit( (string) get_permalink( get_queried_object_id() ) );
		$out   = '';
		foreach ( $groups as $label => $slugs ) {
			$li = '';
			foreach ( $slugs as $slug ) {
				if ( empty( $pages[ $slug ] ) || ! get_page_by_path( $slug, OBJECT, empty( $pages[ $slug ]['is_post'] ) ? 'page' : 'post' ) ) {
					continue;
				}
				$url  = 'home' === $slug ? home_url( '/' ) : MYZT_Frontend::page_url( $slug );
				$text = 'calculators' === $slug ? 'All calculators' : ( 'guides' === $slug ? 'All guides' : $pages[ $slug ]['nav'] );
				$cur  = untrailingslashit( $url ) === $here ? ' aria-current="page"' : '';
				$li  .= '<li><a href="' . esc_url( $url ) . '"' . $cur . '>' . esc_html( $text ) . '</a></li>';
			}
			if ( 'Calculators' === $label && get_page_by_path( 'zakat-calculator-urdu' ) ) {
				$li .= '<li><a href="' . esc_url( MYZT_Frontend::page_url( 'zakat-calculator-urdu' ) ) . '" lang="ur" hreflang="ur">زکوٰۃ کیلکولیٹر اردو</a></li>';
			}
			$out .= '<p style="font-weight:600;margin:0 0 6px">' . esc_html( $label ) . '</p><ul style="margin:0 0 18px 1.1em;line-height:1.9">' . $li . '</ul>';
		}
		echo '<aside class="widget inner-padding myzt-side"><nav aria-label="Calculators and guides">' . $out . '</nav></aside>'; // phpcs:ignore WordPress.Security.EscapeOutput
	}
}
