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

	public static function init() {
		add_action( 'admin_init', array( __CLASS__, 'maybe_upgrade' ) );
		add_shortcode( 'myzt_guides', array( __CLASS__, 'guides_list' ) );
		add_action( 'wp_footer', array( __CLASS__, 'footer_links' ), 50 );
		add_action( 'after_switch_theme', array( __CLASS__, 'menu' ) );
	}

	/** Zakat season year: the year of the coming Ramadan (Ramadan falls in Feb-Mar in 2026-2030). */
	public static function season_year() {
		$y = (int) gmdate( 'Y' );
		return (int) gmdate( 'n' ) >= 5 ? $y + 1 : $y;
	}

	/** All page and post definitions keyed by slug (posts included for links and breadcrumbs). */
	public static function pages() {
		if ( null === self::$pages ) {
			require_once MYZAKATTOOL_DIR . 'includes/content.php';
			self::$pages = myzt_content_pages();
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
		self::install();
	}

	public static function install() {
		$first = ! get_option( 'myzt_installed' );
		if ( $first ) {
			self::site_basics();
		}
		self::create_pages();
		self::menu();
		if ( $first ) {
			update_option( 'myzt_installed', time() );
		}
		update_option( 'myzt_version', MYZAKATTOOL_VERSION );
		MYZT_Rates::ensure_schedule();
		if ( ! MYZT_Rates::get() ) {
			MYZT_Rates::refresh();
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
				$ids[ $slug ] = $existing->ID;
				++$created;
				continue;
			}
			if ( $existing ) {
				$ids[ $slug ] = $existing->ID;
				continue;
			}
			$postarr = array(
				'post_type'      => $type,
				'post_status'    => 'publish',
				'post_title'     => $def['title'],
				'post_name'      => $slug,
				'post_content'   => $def['content'],
				'post_excerpt'   => isset( $def['desc'] ) ? str_replace( '{year}', (string) self::season_year(), $def['desc'] ) : '',
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

	private static function meta( $id, $def ) {
		update_post_meta( $id, '_myzt_managed', 1 );
		update_post_meta( $id, '_myzt_title', $def['seo'] );
		update_post_meta( $id, '_myzt_desc', $def['desc'] );
		if ( ! empty( $def['faq'] ) ) {
			update_post_meta( $id, '_myzt_faq', wp_slash( wp_json_encode( $def['faq'], JSON_UNESCAPED_UNICODE ) ) );
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

	/** [myzt_guides]: list of guide posts. */
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
		if ( $out ) {
			echo '<nav class="myzt-footer-links" aria-label="Site information" style="text-align:center;font-size:13px;padding:14px 16px;line-height:2">' . implode( ' · ', $out ) . '<br><span style="color:#6b7f7a">Estimates only, not a fatwa. © ' . esc_html( gmdate( 'Y' ) ) . ' My Zakat Tool</span></nav>'; // phpcs:ignore
		}
	}
}
