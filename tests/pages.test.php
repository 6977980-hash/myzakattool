<?php
/**
 * Checks the page definitions without WordPress (audit FIX-043, 044, 046):
 * required fields, title and description lengths, internal links that resolve,
 * Urdu pages paired with an English page, enough text on the formerly thin pages,
 * and enough inbound links to the newer tools. Run: php tests/pages.test.php
 */

define( 'ABSPATH', __DIR__ );
function esc_attr( $s ) {
	return htmlspecialchars( $s, ENT_QUOTES );
}
require __DIR__ . '/../includes/content.php';
require __DIR__ . '/../includes/content-urdu.php';

$pages = array_merge( myzt_content_pages(), myzt_content_urdu() );
foreach ( myzt_content_posts() as $slug => $post ) {
	$pages[ $slug ] = $post;
}
$fail = 0;
function check( $ok, $msg ) {
	global $fail;
	if ( ! $ok ) {
		echo "FAIL: $msg\n";
		++$fail;
	}
}
function words( $html ) {
	$text = preg_replace( '/\[[^\]]*\]/', ' ', $html );
	$text = html_entity_decode( strip_tags( $text ), ENT_QUOTES, 'UTF-8' );
	return count( preg_split( '/\s+/u', trim( $text ), -1, PREG_SPLIT_NO_EMPTY ) );
}

// Footer links every tool on every page (MYZT_Installer::footer_links).
$footer = array( 'calculators', 'fitrana-calculator', 'fidya-kaffara-calculator', 'zakat-date-calculator', 'ushr-calculator', 'khums-calculator', 'haq-mehr-calculator', 'diyat-calculator', 'wirasat-calculator', 'free-zakat-widget', 'zakat-calculator-urdu' );
$inbound = array();

foreach ( $pages as $slug => $p ) {
	foreach ( array( 'title', 'content' ) as $k ) {
		check( ! empty( $p[ $k ] ), "$slug has $k" );
	}
	if ( empty( $p['is_post'] ) && ! isset( $p['categories'] ) ) {
		foreach ( array( 'seo', 'desc', 'nav', 'blurb' ) as $k ) {
			check( isset( $p[ $k ] ) && '' !== $p[ $k ], "$slug has $k" );
		}
	}
	if ( isset( $p['seo'] ) ) {
		$t = str_replace( '{year}', '2027', $p['seo'] );
		check( mb_strlen( $t ) <= 70, "$slug title is " . mb_strlen( $t ) . ' characters' );
	}
	if ( isset( $p['desc'] ) ) {
		$d = str_replace( '{year}', '2027', $p['desc'] );
		check( mb_strlen( $d ) <= 165, "$slug description is " . mb_strlen( $d ) . ' characters' );
	}
	preg_match_all( '#href="/([a-z0-9-]*)/?"#', $p['content'], $m );
	foreach ( $m[1] as $target ) {
		$target = '' === $target ? 'home' : $target;
		check( isset( $pages[ $target ] ), "$slug links to missing page /$target/" );
		if ( $target !== $slug ) {
			$inbound[ $target ][ $slug ] = true;
		}
	}
	if ( preg_match_all( '/\[myzt_related slugs="([^"]*)"\]/', $p['content'], $r ) ) {
		foreach ( explode( ',', implode( ',', $r[1] ) ) as $target ) {
			check( isset( $pages[ $target ] ), "$slug related block names missing page $target" );
			if ( $target !== $slug ) {
				$inbound[ $target ][ $slug ] = true;
			}
		}
	}
	if ( ! empty( $p['lang'] ) ) {
		check( 'ur' === $p['lang'], "$slug language is ur" );
		check( ! empty( $p['alt'] ) && isset( $pages[ $p['alt'] ] ) && empty( $pages[ $p['alt'] ]['lang'] ), "$slug names an English counterpart" );
		check( false !== strpos( $p['content'], 'dir="rtl"' ), "$slug content is right-to-left" );
		check( words( $p['content'] ) >= 350, "$slug has " . words( $p['content'] ) . ' words' );
	}
}

// FIX-043: the eight thin pages now carry real content (words in our text, shortcodes excluded).
foreach ( array( 'contact' => 300, 'about' => 400, 'khums-calculator' => 450, 'business-zakat-calculator' => 600, 'free-zakat-widget' => 450, 'fitrana-calculator' => 600, 'maliki-zakat-calculator' => 500, 'hanbali-zakat-calculator' => 500 ) as $slug => $min ) {
	$n = words( $pages[ $slug ]['content'] ) + words( implode( ' ', array_map( function ( $f ) { return $f['q'] . ' ' . $f['a']; }, $pages[ $slug ]['faq'] ) ) );
	check( $n >= $min, "$slug has $n words (want $min)" );
}

// FIX-044: each newer tool has at least 8 linking pages (content and related blocks, plus the footer).
foreach ( array( 'free-zakat-widget', 'fidya-kaffara-calculator', 'ushr-calculator', 'zakat-date-calculator', 'haq-mehr-calculator', 'diyat-calculator', 'wirasat-calculator' ) as $tool ) {
	$n = isset( $inbound[ $tool ] ) ? count( $inbound[ $tool ] ) : 0;
	check( $n >= 4, "$tool has $n linking pages in content" );
	check( in_array( $tool, $footer, true ), "$tool is in the footer" );
}

echo $fail ? "$fail check(s) failed\n" : 'Page checks OK (' . count( $pages ) . " pages)\n";
exit( $fail ? 1 : 0 );
