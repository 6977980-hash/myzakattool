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
		add_filter( 'the_content', array( __CLASS__, 'breadcrumb' ), 5 );
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

	/* ---------- titles and descriptions ---------- */

	private static function fill( $s ) {
		return str_replace( '{year}', (string) MYZT_Installer::season_year(), (string) $s );
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
		if ( is_front_page() ) {
			foreach ( array( 'gsc_verify' => 'google-site-verification', 'bing_verify' => 'msvalidate.01' ) as $k => $name ) {
				$code = MYZT_Settings::get( $k );
				if ( $code ) {
					echo '<meta name="' . esc_attr( $name ) . '" content="' . esc_attr( $code ) . '">' . "\n";
				}
			}
		}
		$post_id = is_singular() ? get_queried_object_id() : 0;
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
				'og:locale'       => str_replace( '-', '_', get_bloginfo( 'language' ) ),
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
			$person = array(
				'@type' => 'Person',
				'@id'   => $per_id,
				'name'  => $s['author_name'],
				'email' => $s['contact_email'],
			);
			if ( $s['author_url'] ) {
				$person['url']    = $s['author_url'];
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
					'inLanguage'    => get_bloginfo( 'language' ),
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

			if ( $post && preg_match( '/\[(zakat_calculator|zakat_fitrana|zakat_fidya|zakat_khums|zakat_hawl|zakat_ushr)/', $post->post_content ) ) {
				$graph[] = array(
					'@type'               => 'WebApplication',
					'@id'                 => $url . '#app',
					'name'                => get_the_title( $post ),
					'url'                 => $url,
					'description'         => $desc,
					'applicationCategory' => 'FinanceApplication',
					'operatingSystem'     => 'Any',
					'browserRequirements' => 'Requires JavaScript',
					'isAccessibleForFree' => true,
					'inLanguage'          => array( 'en', 'ur' ),
					'offers'              => array(
						'@type'         => 'Offer',
						'price'         => '0',
						'priceCurrency' => 'USD',
					),
					'author'              => $full ? array( '@id' => $per_id ) : array( '@type' => 'Person', 'name' => $s['author_name'] ),
				);
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
		$home  = array( array( 'Home', home_url( '/' ) ) );
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
		$lines[] = 'Disallow: /?s=';
		$lines[] = 'Disallow: /search/';
		$lines[] = 'Disallow: /tag/';
		$lines[] = 'Disallow: /author/';
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

	private static function llms() {
		$out   = '# ' . get_bloginfo( 'name' ) . "\n\n> " . get_bloginfo( 'description' ) . "\n\n";
		$out  .= "Free zakat calculator that calculates zakat according to each school of thought (Hanafi, Shafi'i, Maliki, Hanbali, Ahl-e-Hadith, Shia Ja'fari) with live international gold and silver rates in 50 currencies. Rules are cited from published fatwas. Not a fatwa.\n\n## Main pages\n\n";
		foreach ( MYZT_Installer::pages() as $slug => $p ) {
			if ( empty( $p['llms'] ) ) {
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
