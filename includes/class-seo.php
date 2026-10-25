<?php
/**
 * Built-in SEO: titles, meta description, Open Graph / X cards, JSON-LD schema, icons,
 * robots.txt, sitemap tweaks and the small root files (ads.txt, llms.txt, security.txt, manifest).
 *
 * Meta and Open Graph output steps aside when Rank Math, Yoast or AIOSEO is active, so nothing is
 * printed twice. Root files, icons and calculator schema stay on.
 *
 * @package MyZakatTool
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MYZT_SEO {

	// Google Search Console HTML-tag code for https://myzakattool.com/ (given by the owner 2026-10-13).
	const GSC_CODE = 'G3VYSygi1lX3a2fm-xfAx6C-ifdkTHCCnTHvt0W6KtE';

	public static function init() {
		add_action( 'init', array( __CLASS__, 'virtual_files' ), 0 );
		add_filter( 'robots_txt', array( __CLASS__, 'robots_txt' ), 20, 2 );
		add_action( 'do_favicon', array( __CLASS__, 'favicon' ), 0 );
		add_action( 'wp_head', array( __CLASS__, 'icons' ), 2 );
		add_filter( 'wp_sitemaps_add_provider', array( __CLASS__, 'sitemap_providers' ), 10, 2 );
		add_filter( 'wp_sitemaps_taxonomies', array( __CLASS__, 'sitemap_taxonomies' ) );
		add_filter( 'wp_sitemaps_posts_query_args', array( __CLASS__, 'sitemap_exclude_noindex' ), 10, 2 );
		add_filter( 'wp_robots', array( __CLASS__, 'robots_meta' ) );
		add_action( 'template_redirect', array( __CLASS__, 'redirects' ), 1 );
		add_filter( 'term_link', array( __CLASS__, 'guides_term_link' ), 10, 3 );
		add_filter( 'oembed_response_data', array( __CLASS__, 'oembed_author' ), 10, 2 );
		add_filter( 'the_content', array( __CLASS__, 'breadcrumb' ), 5 );
		add_filter( 'the_content', array( __CLASS__, 'lang_switch' ), 4 );
		add_filter( 'language_attributes', array( __CLASS__, 'html_lang' ), 20 );
		remove_action( 'wp_head', 'wp_generator' );
		remove_action( 'wp_head', 'wp_shortlink_wp_head' );

		add_filter( 'pre_get_document_title', array( __CLASS__, 'title' ), 20 );
		add_action( 'wp_head', array( __CLASS__, 'head' ), 1 );
	}

	public static function other_seo_plugin() {
		return defined( 'RANK_MATH_VERSION' ) || defined( 'WPSEO_VERSION' ) || defined( 'AIOSEO_VERSION' ) || defined( 'SEOPRESS_VERSION' );
	}

	private static function meta_on() {
		return MYZT_Settings::get( 'seo_enabled' ) && ! self::other_seo_plugin();
	}

	/* ---------- languages (audit FIX-046) ---------- */

	/** 'ur' for our Urdu pages, otherwise 'en'. */
	public static function lang_of( $post_id ) {
		if ( ! $post_id ) {
			return 'en';
		}
		$pages = MYZT_Installer::pages();
		$slug  = get_post_field( 'post_name', $post_id );
		return isset( $pages[ $slug ]['lang'] ) && get_post_meta( $post_id, '_myzt_managed', true ) ? $pages[ $slug ]['lang'] : 'en';
	}

	/** True while rendering one of our Urdu pages. */
	public static function is_ur() {
		return is_singular() && 'ur' === self::lang_of( get_queried_object_id() );
	}

	/**
	 * English and Urdu URLs of a page that exists in both languages: array( 'en' => url, 'ur' => url ),
	 * or an empty array. Both pages must be published, so no hreflang points at a missing page.
	 */
	public static function alternates( $post_id ) {
		static $cache = array();
		if ( ! $post_id ) {
			return array();
		}
		if ( isset( $cache[ $post_id ] ) ) {
			return $cache[ $post_id ];
		}
		$pages = MYZT_Installer::pages();
		$slug  = get_post_field( 'post_name', $post_id );
		$en    = '';
		$ur    = '';
		if ( isset( $pages[ $slug ]['alt'] ) && 'ur' === self::lang_of( $post_id ) ) {
			$en = $pages[ $slug ]['alt'];
			$ur = $slug;
		} elseif ( isset( $pages[ $slug ] ) && empty( $pages[ $slug ]['lang'] ) ) {
			foreach ( $pages as $s => $def ) {
				if ( isset( $def['alt'] ) && $def['alt'] === $slug ) {
					$en = $slug;
					$ur = $s;
					break;
				}
			}
		}
		$out = array();
		if ( $en && $ur ) {
			// An Urdu page may pair with an English guide post (FIX-157), so look the English one up by its type.
			$en_post = get_page_by_path( $en, OBJECT, empty( $pages[ $en ]['is_post'] ) ? 'page' : 'post' );
			$ur_post = get_page_by_path( $ur );
			if ( $en_post && $ur_post && 'publish' === $en_post->post_status && 'publish' === $ur_post->post_status ) {
				$out = array(
					'en' => (int) get_option( 'page_on_front' ) === (int) $en_post->ID ? home_url( '/' ) : get_permalink( $en_post ),
					'ur' => get_permalink( $ur_post ),
				);
			}
		}
		$cache[ $post_id ] = $out;
		return $out;
	}

	/**
	 * <html lang="ur"> on the Urdu pages. Not dir="rtl": the theme has no RTL stylesheet, so the header, menu and
	 * sidebar would flip and the sidebar ran into the calculator. app.css turns the article itself right to left (FIX-113).
	 */
	public static function html_lang( $output ) {
		if ( self::is_ur() ) {
			$output = preg_replace( '/lang="[^"]*"/', 'lang="ur"', $output );
		}
		return $output;
	}

	/** A link to the same page in the other language, above the content. */
	public static function lang_switch( $content ) {
		if ( ! is_singular() || ! in_the_loop() || ! is_main_query() ) {
			return $content;
		}
		$alt = self::alternates( get_the_ID() );
		if ( ! $alt ) {
			return $content;
		}
		$link = self::is_ur()
			? '<a href="' . esc_url( $alt['en'] ) . '" hreflang="en" lang="en">Read this page in English</a>'
			: '<a href="' . esc_url( $alt['ur'] ) . '" hreflang="ur" lang="ur" dir="rtl">یہ صفحہ اردو میں پڑھیں</a>';
		return '<p class="myzt-lang" style="font-size:14px;margin:0 0 12px">' . $link . '</p>' . $content;
	}

	/* ---------- titles and descriptions ---------- */

	/**
	 * Placeholders in titles and descriptions: {year} the coming zakat season, {cyear} this calendar
	 * year (live-rate pages, FIX-142), {fyear} the year of the fitrana amounts in use, and
	 * {t2027} the 2027 page title with the 1448 figures once announced (FIX-215), and
	 * {rate:TYPE} today's figure from [myzt_rate] (FIX-164). $live false (stored excerpts) writes
	 * "today's rate" instead of a number that would go stale.
	 */
	public static function fill( $s, $live = true ) {
		$s = strtr(
			(string) $s,
			array(
				'{year}'  => (string) MYZT_Installer::season_year(),
				'{cyear}' => gmdate( 'Y' ),
				'{fyear}' => (string) MYZT_Frontend::fitrana_year(),
				'{t2027}' => MYZT_Frontend::title_2027(),
			)
		);
		return preg_replace_callback(
			'/\{rate:([a-z0-9-]+)\}/',
			function ( $m ) use ( $live ) {
				$v = $live ? MYZT_Frontend::rate_inline( array( 'type' => $m[1] ) ) : '—';
				return '—' === $v ? "today's rate" : html_entity_decode( $v, ENT_QUOTES, 'UTF-8' );
			},
			$s
		);
	}

	public static function page_title( $post_id ) {
		$t = get_post_meta( $post_id, '_myzt_title', true );
		return $t ? self::fill( $t ) : '';
	}

	public static function page_desc( $post_id ) {
		$d = get_post_meta( $post_id, '_myzt_desc', true );
		if ( $d ) {
			return self::fill( $d );
		}
		$p = get_post( $post_id );
		if ( ! $p ) {
			return '';
		}
		$text = $p->post_excerpt ? $p->post_excerpt : wp_strip_all_tags( strip_shortcodes( $p->post_content ) );
		return wp_trim_words( preg_replace( '/\s+/', ' ', $text ), 26, '…' );
	}

	public static function title( $title ) {
		if ( ! self::meta_on() ) {
			return $title;
		}
		if ( is_singular() ) {
			$t = self::page_title( get_queried_object_id() );
			if ( $t ) {
				return $t;
			}
		}
		return $title;
	}

	private static function current_desc() {
		if ( is_singular() ) {
			return self::page_desc( get_queried_object_id() );
		}
		if ( is_front_page() || is_home() ) {
			return get_bloginfo( 'description' );
		}
		if ( is_category() || is_tag() ) {
			return wp_strip_all_tags( term_description() );
		}
		return get_bloginfo( 'description' );
	}

	private static function og_image( $post_id ) {
		$slug = $post_id ? get_post_field( 'post_name', $post_id ) : '';
		if ( $post_id && (int) get_option( 'page_on_front' ) === (int) $post_id ) {
			$slug = 'home';
		}
		$pages = MYZT_Installer::pages();
		if ( $slug && isset( $pages[ $slug ]['alt'] ) ) {
			$slug = $pages[ $slug ]['alt']; // Urdu pages share the English page's image.
		}
		if ( $slug && file_exists( MYZAKATTOOL_DIR . 'assets/img/og/' . $slug . '.jpg' ) ) {
			return MYZAKATTOOL_URL . 'assets/img/og/' . $slug . '.jpg';
		}
		if ( $post_id && has_post_thumbnail( $post_id ) ) {
			$img = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );
			if ( $img ) {
				return $img[0];
			}
		}
		return MYZAKATTOOL_URL . 'assets/img/og/default.jpg';
	}

	public static function head() {
		// Verification tags go on every front-end page; the GSC code falls back to the owner's property code
		// so verification works even before the settings field is filled in.
		$fallback = array( 'gsc_verify' => self::GSC_CODE, 'bing_verify' => '' );
		foreach ( array( 'gsc_verify' => 'google-site-verification', 'bing_verify' => 'msvalidate.01' ) as $k => $name ) {
			$code = MYZT_Settings::get( $k );
			if ( ! $code ) {
				$code = $fallback[ $k ];
			}
			if ( $code ) {
				echo '<meta name="' . esc_attr( $name ) . '" content="' . esc_attr( $code ) . '">' . "\n";
			}
		}
		$post_id = is_singular() ? get_queried_object_id() : 0;
		$alt     = self::alternates( $post_id );
		if ( $alt ) {
			echo '<link rel="alternate" hreflang="en" href="' . esc_url( $alt['en'] ) . '">' . "\n";
			echo '<link rel="alternate" hreflang="ur" href="' . esc_url( $alt['ur'] ) . '">' . "\n";
			echo '<link rel="alternate" hreflang="x-default" href="' . esc_url( $alt['en'] ) . '">' . "\n";
		}
		if ( self::meta_on() ) {
			$desc  = self::current_desc();
			$title = wp_get_document_title();
			$url   = $post_id ? get_permalink( $post_id ) : home_url( add_query_arg( array() ) );
			if ( is_front_page() ) {
				$url = home_url( '/' );
			}
			$img = self::og_image( $post_id );
			echo "\n<!-- My Zakat Tool SEO -->\n";
			if ( $desc ) {
				echo '<meta name="description" content="' . esc_attr( $desc ) . '">' . "\n";
			}
			$og = array(
				'og:locale'       => self::is_ur() ? 'ur_PK' : str_replace( '-', '_', get_bloginfo( 'language' ) ),
				'og:type'         => is_singular( 'post' ) ? 'article' : 'website',
				'og:title'        => $title,
				'og:description'  => $desc,
				'og:url'          => $url,
				'og:site_name'    => get_bloginfo( 'name' ),
				'og:image'        => $img,
				'og:image:width'  => '1200',
				'og:image:height' => '630',
				'og:image:alt'    => $title,
			);
			if ( is_singular( 'post' ) ) {
				$og['article:published_time'] = get_the_date( 'c', $post_id );
				$og['article:modified_time']  = get_the_modified_date( 'c', $post_id );
			}
			foreach ( $og as $k => $v ) {
				if ( '' !== $v ) {
					echo '<meta property="' . esc_attr( $k ) . '" content="' . esc_attr( $v ) . '">' . "\n";
				}
			}
			$tw = array(
				'twitter:card'        => 'summary_large_image',
				'twitter:title'       => $title,
				'twitter:description' => $desc,
				'twitter:image'       => $img,
			);
			foreach ( $tw as $k => $v ) {
				echo '<meta name="' . esc_attr( $k ) . '" content="' . esc_attr( $v ) . '">' . "\n";
			}
			if ( ! is_singular() && ! is_front_page() && ! is_404() ) {
				// Core prints canonical only for singular views.
				$canon = is_home() ? get_permalink( get_option( 'page_for_posts' ) ) : '';
				if ( is_category() || is_tag() ) {
					$canon = get_term_link( get_queried_object() );
				}
				if ( $canon && ! is_wp_error( $canon ) ) {
					echo '<link rel="canonical" href="' . esc_url( $canon ) . '">' . "\n";
				}
			}
		}
		if ( MYZT_Ads::enabled() ) {
			echo '<link rel="preconnect" href="https://pagead2.googlesyndication.com" crossorigin>' . "\n";
		}
		self::schema( $post_id );
	}

	/* ---------- JSON-LD ---------- */

	private static function schema( $post_id ) {
		$s       = MYZT_Settings::get();
		$home    = home_url( '/' );
		$org_id  = $home . '#organization';
		$site_id = $home . '#website';
		$per_id  = $home . '#author';
		$graph   = array();
		$full    = self::meta_on();

		if ( $full ) {
			$graph[] = array(
				'@type' => 'Organization',
				'@id'   => $org_id,
				'name'  => get_bloginfo( 'name' ),
				'url'   => $home,
				'email' => $s['contact_email'],
				'logo'  => array(
					'@type'  => 'ImageObject',
					'url'    => MYZAKATTOOL_URL . 'assets/img/logo-512.png',
					'width'  => 512,
					'height' => 512,
				),
				'founder' => array( '@id' => $per_id ),
				'contactPoint' => array(
					'@type'             => 'ContactPoint',
					'contactType'       => 'customer support',
					'email'             => $s['contact_email'],
					'url'               => MYZT_Frontend::page_url( 'contact' ),
					'availableLanguage' => array( 'English', 'Urdu' ),
				),
			);
			$graph[] = array(
				'@type'      => 'WebSite',
				'@id'        => $site_id,
				'url'        => $home,
				'name'       => get_bloginfo( 'name' ),
				'description' => get_bloginfo( 'description' ),
				'inLanguage' => get_bloginfo( 'language' ),
				'publisher'  => array( '@id' => $org_id ),
			);
			// FIX-132: url is the bio on /about/; the LinkedIn profile stays in sameAs.
			$person = array(
				'@type'       => 'Person',
				'@id'         => $per_id,
				'name'        => $s['author_name'],
				'url'         => MYZT_Frontend::author_page(),
				'email'       => $s['contact_email'],
				'jobTitle'    => 'Founder and editor, My Zakat Tool',
				'description' => 'Builds and maintains My Zakat Tool and writes its guides from published fatwas and texts. Not a scholar or mufti; the rules are sourced and open to correction.',
				'knowsAbout'  => array( 'Zakat calculation', 'Nisab', 'Islamic inheritance (wirasat)', 'Fitrana and fidya' ),
				'worksFor'    => array( '@id' => $org_id ),
			);
			if ( $s['author_url'] ) {
				$person['sameAs'] = array( $s['author_url'] );
			}
			$graph[] = $person;
		}

		if ( $post_id ) {
			$post  = get_post( $post_id );
			$url   = is_front_page() ? $home : get_permalink( $post_id );
			$title = wp_get_document_title();
			$desc  = self::page_desc( $post_id );
			if ( $full ) {
				$crumbs = self::crumbs( $post_id );
				$items  = array();
				foreach ( $crumbs as $i => $c ) {
					$items[] = array(
						'@type'    => 'ListItem',
						'position' => $i + 1,
						'name'     => $c[0],
						'item'     => $c[1],
					);
				}
				$graph[] = array(
					'@type'           => 'BreadcrumbList',
					'@id'             => $url . '#breadcrumb',
					'itemListElement' => $items,
				);
				$page = array(
					'@type'         => is_singular( 'post' ) ? 'WebPage' : ( 'about' === $post->post_name ? 'AboutPage' : ( 'contact' === $post->post_name ? 'ContactPage' : 'WebPage' ) ),
					'@id'           => $url . '#webpage',
					'url'           => $url,
					'name'          => $title,
					'description'   => $desc,
					'isPartOf'      => array( '@id' => $site_id ),
					'breadcrumb'    => array( '@id' => $url . '#breadcrumb' ),
					'inLanguage'    => 'ur' === self::lang_of( $post_id ) ? 'ur' : get_bloginfo( 'language' ),
					'datePublished' => get_the_date( 'c', $post ),
					'dateModified'  => get_the_modified_date( 'c', $post ),
					'author'        => array( '@id' => $per_id ),
					'primaryImageOfPage' => array(
						'@type' => 'ImageObject',
						'url'   => self::og_image( $post_id ),
					),
				);
				if ( $s['reviewer'] ) {
					$page['reviewedBy']   = array(
						'@type' => 'Person',
						'name'  => $s['reviewer'],
					);
					$page['lastReviewed'] = get_the_modified_date( 'Y-m-d', $post );
				}
				$graph[] = $page;

				if ( is_singular( 'post' ) ) {
					$graph[] = array(
						'@type'            => 'Article',
						'@id'              => $url . '#article',
						'headline'         => get_the_title( $post ),
						'description'      => $desc,
						'mainEntityOfPage' => array( '@id' => $url . '#webpage' ),
						'author'           => array( '@id' => $per_id ),
						'publisher'        => array( '@id' => $org_id ),
						'datePublished'    => get_the_date( 'c', $post ),
						'dateModified'     => get_the_modified_date( 'c', $post ),
						'image'            => self::og_image( $post_id ),
						'inLanguage'       => get_bloginfo( 'language' ),
					);
				}

				$faq = MYZT_Frontend::faq_items( $post_id );
				if ( $faq ) {
					$q = array();
					foreach ( $faq as $item ) {
						$q[] = array(
							'@type'          => 'Question',
							'name'           => wp_strip_all_tags( $item['q'] ),
							'acceptedAnswer' => array(
								'@type' => 'Answer',
								'text'  => wp_strip_all_tags( $item['a'] ),
							),
						);
					}
					$graph[] = array(
						'@type'      => 'FAQPage',
						'@id'        => $url . '#faq',
						'mainEntity' => $q,
					);
				}
			}

			if ( $post && preg_match( '/\[(zakat_calculator|zakat_fitrana|zakat_fidya|zakat_khums|zakat_hawl|zakat_ushr|zakat_mehr|zakat_diyat|zakat_wirasat|zakat_iddat|zakat_qurbani)/', $post->post_content, $tool ) ) {
				$app = array(
					'@type'               => 'WebApplication',
					'@id'                 => $url . '#app',
					'name'                => get_the_title( $post ),
					'url'                 => $url,
					'description'         => $desc,
					'applicationCategory' => 'zakat_iddat' === $tool[1] ? 'ReferenceApplication' : 'FinanceApplication',
					'operatingSystem'     => 'Any',
					'browserRequirements' => 'Requires JavaScript',
					'isAccessibleForFree' => true,
					'inLanguage'          => 'zakat_wirasat' === $tool[1] ? ( self::is_ur() ? 'ur' : 'en' ) : array( 'en', 'ur' ), // The inheritance calculator is English on /wirasat-calculator/ and Urdu on the Urdu page (FIX-205).
					'offers'              => array(
						'@type'         => 'Offer',
						'price'         => '0',
						'priceCurrency' => 'USD',
					),
					'author'              => $full ? array( '@id' => $per_id ) : array( '@type' => 'Person', 'name' => $s['author_name'] ),
				);
				$defs = MYZT_Installer::pages();
				if ( ! empty( $defs[ $post->post_name ]['features'] ) ) {
					$app['featureList'] = $defs[ $post->post_name ]['features'];
				}
				$graph[] = $app;
			}
		}

		if ( ! $graph ) {
			return;
		}
		echo '<script type="application/ld+json">' . wp_json_encode(
			array(
				'@context' => 'https://schema.org',
				'@graph'   => $graph,
			),
			JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG
		) . "</script>\n";
	}

	/** Breadcrumb trail: Home > hub > page. Returns [[name, url], ...]. */
	public static function crumbs( $post_id ) {
		$home  = array( array( 'ur' === self::lang_of( $post_id ) ? 'ہوم' : 'Home', home_url( '/' ) ) );
		if ( (int) get_option( 'page_on_front' ) === (int) $post_id ) {
			return $home;
		}
		$slug  = get_post_field( 'post_name', $post_id );
		$pages = MYZT_Installer::pages();
		$trail = $home;
		$hub   = '';
		if ( isset( $pages[ $slug ]['hub'] ) ) {
			$hub = $pages[ $slug ]['hub'];
		} elseif ( 'post' === get_post_type( $post_id ) ) {
			$hub = 'guides';
		}
		if ( $hub && isset( $pages[ $hub ] ) && $hub !== $slug ) {
			$trail[] = array( $pages[ $hub ]['nav'], MYZT_Frontend::page_url( $hub ) );
		}
		$trail[] = array( isset( $pages[ $slug ]['nav'] ) ? $pages[ $slug ]['nav'] : get_the_title( $post_id ), get_permalink( $post_id ) );
		return $trail;
	}

	/** Visible breadcrumb at the top of our pages (most lightweight themes show none). */
	public static function breadcrumb( $content ) {
		if ( ! is_singular() || is_front_page() || ! in_the_loop() || ! is_main_query() ) {
			return $content;
		}
		$id = get_the_ID();
		if ( ! get_post_meta( $id, '_myzt_managed', true ) && 'post' !== get_post_type( $id ) ) {
			return $content;
		}
		$c    = self::crumbs( $id );
		$html = '<nav class="myzt-crumb" aria-label="Breadcrumb" style="font-size:13px;margin:0 0 12px;color:#5d736e">';
		$last = count( $c ) - 1;
		foreach ( $c as $i => $item ) {
			$html .= $i === $last ? '<span aria-current="page">' . esc_html( $item[0] ) . '</span>' : '<a href="' . esc_url( $item[1] ) . '">' . esc_html( $item[0] ) . '</a> › ';
		}
		return $html . '</nav>' . $content;
	}

	/* ---------- redirects ---------- */

	/** /page/N/ on the front page and the Guides category archive duplicate real pages: send them there. */
	public static function redirects() {
		if ( is_front_page() && max( (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) ) > 1 ) {
			wp_safe_redirect( home_url( '/' ), 301 );
			exit;
		}
		if ( is_category( 'guides' ) && ! is_paged() ) {
			wp_safe_redirect( MYZT_Frontend::page_url( 'guides' ), 301 );
			exit;
		}
		// An empty category (for example the default "Blog") would show a "Nothing Found" page.
		if ( is_category() && ! is_paged() && ! have_posts() ) {
			wp_safe_redirect( MYZT_Frontend::page_url( 'guides' ), 301 );
			exit;
		}
	}

	/** Theme post meta links to /category/guides/, which redirects: link straight to the Guides page. */
	public static function guides_term_link( $url, $term, $taxonomy ) {
		if ( 'category' === $taxonomy && 'guides' === $term->slug ) {
			return MYZT_Frontend::page_url( 'guides' );
		}
		return $url;
	}

	/** oEmbed takes the WordPress user's display name; use the site author instead. */
	public static function oembed_author( $data, $post ) {
		$n = (string) MYZT_Settings::get( 'author_name' );
		if ( '' !== $n ) {
			$data['author_name'] = $n;
			$data['author_url']  = MYZT_Frontend::author_page();
		}
		return $data;
	}

	/* ---------- robots ---------- */

	public static function robots_meta( $robots ) {
		$flagged = is_singular() && get_post_meta( get_queried_object_id(), '_myzt_noindex', true );
		$paged   = is_paged() || ( is_front_page() && max( (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) ) > 1 );
		if ( $flagged || is_search() || is_404() || is_attachment() || is_author() || is_date() || is_tag() || is_category() || $paged ) {
			$robots['noindex'] = true;
			$robots['follow']  = true;
			unset( $robots['max-image-preview'] );
		} elseif ( get_option( 'blog_public' ) ) {
			$robots['max-image-preview'] = 'large';
			$robots['max-snippet']       = '-1';
			$robots['max-video-preview'] = '-1';
		}
		return $robots;
	}

	public static function robots_txt( $output, $public ) {
		if ( ! $public ) {
			return $output;
		}
		$lines   = array();
		$lines[] = 'User-agent: *';
		$lines[] = 'Disallow: /wp-admin/';
		$lines[] = 'Allow: /wp-admin/admin-ajax.php';
		// Search, tag and author pages are not blocked here: they carry noindex, which crawlers must be able to read.
		$lines[] = 'Disallow: /*?replytocom=';
		$lines[] = '';
		$lines[] = '# AI search and answer engines (GPTBot, PerplexityBot, ClaudeBot, Google-Extended) are allowed by the rules above.';
		$lines[] = '';
		$lines[] = 'Sitemap: ' . home_url( '/wp-sitemap.xml' );
		return implode( "\n", $lines ) . "\n";
	}

	/* ---------- sitemap ---------- */

	public static function sitemap_providers( $provider, $name ) {
		return 'users' === $name ? false : $provider;
	}

	public static function sitemap_taxonomies( $tax ) {
		unset( $tax['post_tag'], $tax['post_format'], $tax['category'] );
		return $tax;
	}

	public static function sitemap_exclude_noindex( $args, $post_type ) {
		$args['meta_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery
			'relation' => 'OR',
			array(
				'key'     => '_myzt_noindex',
				'compare' => 'NOT EXISTS',
			),
			array(
				'key'   => '_myzt_noindex',
				'value' => '0',
			),
		);
		return $args;
	}

	/* ---------- icons ---------- */

	public static function icons() {
		$u = MYZAKATTOOL_URL . 'assets/img/';
		echo '<meta name="theme-color" content="#0f766e">' . "\n";
		echo '<link rel="manifest" href="' . esc_url( home_url( '/site.webmanifest' ) ) . '">' . "\n";
		if ( has_site_icon() ) {
			return;
		}
		echo '<link rel="icon" href="' . esc_url( $u . 'favicon.ico' ) . '" sizes="48x48">' . "\n";
		echo '<link rel="icon" href="' . esc_url( $u . 'favicon.svg' ) . '" type="image/svg+xml">' . "\n";
		echo '<link rel="apple-touch-icon" href="' . esc_url( $u . 'apple-touch-icon.png' ) . '">' . "\n";
	}

	public static function favicon() {
		if ( has_site_icon() ) {
			return;
		}
		header( 'Content-Type: image/x-icon' );
		header( 'Cache-Control: public, max-age=604800' );
		readfile( MYZAKATTOOL_DIR . 'assets/img/favicon.ico' ); // phpcs:ignore WordPress.WP.AlternativeFunctions
		exit;
	}

	/* ---------- root files ---------- */

	public static function virtual_files() {
		if ( empty( $_SERVER['REQUEST_URI'] ) ) {
			return;
		}
		$path = wp_parse_url( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ), PHP_URL_PATH );
		$base = wp_parse_url( home_url( '/' ), PHP_URL_PATH );
		$base = $base ? rtrim( $base, '/' ) : '';
		$file = ltrim( substr( (string) $path, strlen( $base ) ), '/' );
		$s    = MYZT_Settings::get();

		switch ( $file ) {
			case 'favicon.ico':
				if ( has_site_icon() ) {
					wp_redirect( get_site_icon_url( 48 ), 302 ); // phpcs:ignore WordPress.Security.SafeRedirect
					exit;
				}
				status_header( 200 );
				header( 'Content-Type: image/x-icon' );
				header( 'Cache-Control: public, max-age=604800' );
				readfile( MYZAKATTOOL_DIR . 'assets/img/favicon.ico' ); // phpcs:ignore WordPress.WP.AlternativeFunctions
				exit;
			case 'apple-touch-icon.png':
			case 'apple-touch-icon-precomposed.png':
				status_header( 200 );
				header( 'Content-Type: image/png' );
				header( 'Cache-Control: public, max-age=604800' );
				readfile( MYZAKATTOOL_DIR . 'assets/img/apple-touch-icon.png' ); // phpcs:ignore WordPress.WP.AlternativeFunctions
				exit;
			case 'ads.txt':
				if ( empty( $s['ads_client'] ) ) {
					return;
				}
				self::send( 'text/plain', 'google.com, ' . str_replace( 'ca-', '', $s['ads_client'] ) . ", DIRECT, f08c47fec0942fa0\n" );
				break;
			case 'llms.txt':
				self::send( 'text/plain', self::llms() );
				break;
			case '.well-known/security.txt':
			case 'security.txt':
				$mail = $s['security_email'] ? $s['security_email'] : $s['contact_email'];
				self::send(
					'text/plain',
					'Contact: mailto:' . $mail . "\n" .
					'Expires: ' . gmdate( 'Y-m-d\TH:i:s\Z', time() + YEAR_IN_SECONDS ) . "\n" .
					"Preferred-Languages: en, ur\n" .
					'Canonical: ' . home_url( '/.well-known/security.txt' ) . "\n"
				);
				break;
			case 'site.webmanifest':
				$u = MYZAKATTOOL_URL . 'assets/img/';
				self::send(
					'application/manifest+json',
					wp_json_encode(
						array(
							'name'             => get_bloginfo( 'name' ),
							'short_name'       => 'Zakat Tool',
							'description'      => get_bloginfo( 'description' ),
							'start_url'        => '/',
							'display'          => 'standalone',
							'background_color' => '#ffffff',
							'theme_color'      => '#0f766e',
							'icons'            => array(
								array( 'src' => $u . 'icon-192.png', 'sizes' => '192x192', 'type' => 'image/png' ),
								array( 'src' => $u . 'icon-512.png', 'sizes' => '512x512', 'type' => 'image/png' ),
								array( 'src' => $u . 'icon-maskable-512.png', 'sizes' => '512x512', 'type' => 'image/png', 'purpose' => 'maskable' ),
							),
						),
						JSON_UNESCAPED_SLASHES
					)
				);
				break;
		}
	}

	private static function send( $type, $body ) {
		status_header( 200 );
		header( 'Content-Type: ' . $type . '; charset=utf-8' );
		header( 'Cache-Control: public, max-age=3600' );
		header( 'X-Robots-Tag: noindex' );
		echo $body; // phpcs:ignore WordPress.Security.EscapeOutput
		exit;
	}

	/** FIX-108: the figures an AI answer most often needs, stated once. */
	private static function llms_facts() {
		return "## Key facts\n\n"
			. "- Zakat: 2.5% of zakatable wealth held for one lunar year (354 days) at or above the nisab.\n"
			. "- Nisab: gold 87.48 g (7.5 tola), silver 612.35 g (52.5 tola); 1 tola = 11.6638 g. Shia (Sistani) coin nisab: gold 69.12 g, silver 483.84 g.\n"
			. "- Jewellery: zakatable when worn in Hanafi and Ahl-e-Hadith (Saudi Permanent Committee) fiqh; permissible worn jewellery exempt in Shafi'i, Maliki and Hanbali fiqh; not zakatable for Shia (Sistani) while gold is not used as currency.\n"
			. "- Debts due now: deducted in Hanafi, Maliki and Hanbali fiqh; not deducted in Shafi'i fiqh and in the Ahl-e-Hadith setting.\n"
			. "- Cash nisab: silver by default in Hanafi, Maliki, Hanbali and Ahl-e-Hadith settings; gold by default in Shafi'i (user may switch).\n"
			. "- Fitrana and fidya (Hanafi): half a sa' of wheat (about 1.75 to 2 kg) or one sa' of barley, dates or raisins per person or per fast; CII Pakistan 1447 minimum Rs 300 (wheat), Rs 1,600 (dates).\n"
			. "- Haq mehr: 1 dirham = 3.0618 g silver; Hanafi minimum 10 dirham (30.62 g); Mehr-e-Fatimi 500 dirham (1,530.9 g, 131.25 tola).\n"
			. "- Diyat (Pakistan Penal Code s.323): value of 30,630 g of silver; notified Rs 19,352,390 for fiscal year 2026-27.\n"
			. "- Iddat: widow 4 lunar months and 10 days (130 days unless the death fell on the 1st of an Islamic month, Hanafi); divorce 3 quru' (3 periods in Hanafi, Hanbali and Ahl-e-Hadith fiqh, 3 purity intervals in Shafi'i, Maliki and Ja'fari fiqh), 3 months without periods; pregnant: until birth (Sistani: later of birth and 4 months 10 days for a widow); no divorce iddat before consummation. Pakistan: talaq takes effect 90 days after notice to the Union Council chairman (MFLO 1961 s.7).\n"
			. "- Qurbani: wajib in Hanafi fiqh on an adult resident Muslim owning the nisab (612.35 g silver value) beyond basic needs on 10-12 Dhul Hijjah, no hawl, non-zakatable spare items count; sunnah mu'akkadah in Shafi'i, Maliki, Hanbali and most Ahl-e-Hadith fiqh; mustahabb for Shia (Sistani) except on Hajj.\n"
			. "- Rates: international gold and silver spot prices and exchange rates, refreshed every hour on our server.\n\n";
	}

	private static function llms() {
		$out   = '# ' . get_bloginfo( 'name' ) . "\n\n> " . get_bloginfo( 'description' ) . "\n\n";
		$out  .= "Free zakat calculator that calculates zakat according to each school of thought (Hanafi, Shafi'i, Maliki, Hanbali, Ahl-e-Hadith, Shia Ja'fari) with live international gold and silver rates in 50 currencies. Rules are based on published fatwas and texts; some points are our reading (see " . MYZT_Frontend::page_url( 'methodology' ) . "). Not a fatwa. Made by " . MYZT_Settings::get( 'author_name' ) . ' (' . MYZT_Frontend::author_page() . "), who is not a scholar.\n\n" . self::llms_facts() . "## Main pages\n\n";
		foreach ( MYZT_Installer::pages() as $slug => $p ) {
			if ( empty( $p['llms'] ) || ! empty( $p['hidden'] ) ) {
				continue;
			}
			$url  = 'home' === $slug ? home_url( '/' ) : MYZT_Frontend::page_url( $slug );
			$out .= '- [' . $p['nav'] . '](' . $url . '): ' . self::fill( $p['desc'] ) . "\n";
		}
		$out .= "\n## Guides\n\n";
		foreach ( MYZT_Installer::pages() as $slug => $p ) {
			if ( ! empty( $p['is_post'] ) ) {
				$out .= '- [' . $p['title'] . '](' . MYZT_Frontend::page_url( $slug ) . '): ' . self::fill( $p['desc'] ) . "\n";
			}
		}
		$out .= "\n## About\n\n- [About](" . MYZT_Frontend::page_url( 'about' ) . "): who runs the site and how to contact us.\n- [Disclaimer](" . MYZT_Frontend::page_url( 'disclaimer' ) . "): the results are estimates, not a fatwa.\n";
		return $out;
	}
}
