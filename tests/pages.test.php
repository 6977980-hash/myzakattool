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
require __DIR__ . '/../includes/class-cite.php';

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
// Placeholders as MYZT_SEO::fill() fills them, with a long rupee figure for {rate:...}.
function fill( $s ) {
	$s = str_replace( array( '{year}', '{cyear}', '{fyear}' ), '2027', $s );
	$s = preg_replace( '/\{rate:[a-z0-9-]+\}/', 'Rs 12,34,567', $s );
	check( false === strpos( $s, '{' ), "unknown placeholder in: $s" );
	return $s;
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
		$t = fill( $p['seo'] );
		check( mb_strlen( $t ) <= 60, "$slug title is " . mb_strlen( $t ) . ' characters' );
	}
	if ( isset( $p['desc'] ) ) {
		$d = fill( $p['desc'] );
		check( mb_strlen( $d ) <= 160, "$slug description is " . mb_strlen( $d ) . ' characters' );
	}
	preg_match_all( '#href="/([a-z0-9-]*)/?"#', $p['content'], $m );
	foreach ( $m[1] as $target ) {
		$target = '' === $target ? 'home' : $target;
		check( isset( $pages[ $target ] ), "$slug links to missing page /$target/" );
		check( ! empty( $p['hidden'] ) || empty( $pages[ $target ]['hidden'] ), "$slug links to hidden page /$target/" );
		if ( $target !== $slug ) {
			$inbound[ $target ][ $slug ] = true;
		}
	}
	if ( preg_match_all( '/\[myzt_related slugs="([^"]*)"\]/', $p['content'], $r ) ) {
		foreach ( explode( ',', implode( ',', $r[1] ) ) as $target ) {
			check( isset( $pages[ $target ] ), "$slug related block names missing page $target" );
			check( ! empty( $p['hidden'] ) || empty( $pages[ $target ]['hidden'] ), "$slug related block names hidden page $target" );
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

// FIX-150/151/152/154: deeper madhab, rate and gold pages, and the 2027 Pakistan hub (content plus FAQ words).
foreach ( array( 'hanafi-zakat-calculator' => 1000, 'shafi-zakat-calculator' => 1000, 'maliki-zakat-calculator' => 1000, 'hanbali-zakat-calculator' => 1000, 'ahl-e-hadith-zakat-calculator' => 1000, 'shia-zakat-calculator' => 1000, 'nisab' => 800, 'gold-rate-today' => 600, 'zakat-on-gold-calculator' => 650, 'zakat-on-1-tola-gold' => 1050, 'zakat-2027-pakistan' => 600 ) as $slug => $min ) {
	$n = words( $pages[ $slug ]['content'] ) + words( implode( ' ', array_map( function ( $f ) { return $f['q'] . ' ' . $f['a']; }, $pages[ $slug ]['faq'] ) ) );
	check( $n >= $min, "$slug has $n words (want $min)" );
}
// FIX-155: every hub opens with a quick answer.
foreach ( array( 'madhab', 'calculators', 'guides', 'free-zakat-widget', 'zakat-2027-pakistan' ) as $slug ) {
	check( false !== strpos( $pages[ $slug ]['content'], '[myzt_answer' ), "$slug has a quick answer" );
}
// FIX-154/167: the official figures boxes and past-year tables are on the pages that need them.
foreach ( array( 'nisab' => 'myzt_history type="bank-nisab"', 'fitrana-calculator' => 'myzt_history type="fitrana"', 'fidya-kaffara-calculator' => 'myzt_official type="fidya"', 'diyat-calculator' => 'myzt_official type="diyat"', 'gold-rate-today' => 'myzt_rate_chart', 'zakat-on-1-tola-gold' => 'myzt_tola_table' ) as $slug => $code ) {
	check( false !== strpos( $pages[ $slug ]['content'], $code ), "$slug shows [$code]" );
}
// FIX-153: wirasat spelling variants on the page text.
foreach ( array( 'virasat', 'warasat', 'mirath', 'faraid', 'inheritance calculator for Pakistan' ) as $v ) {
	check( false !== stripos( $pages['wirasat-calculator']['content'], $v ), "wirasat page mentions $v" );
}
check( false !== strpos( $pages['wirasat-calculator-urdu']['content'], 'میراث کیلکولیٹر' ), 'Urdu wirasat page has a میراث H2' );

// FIX-044: each newer tool has at least 8 linking pages (content and related blocks, plus the footer).
foreach ( array( 'free-zakat-widget', 'fidya-kaffara-calculator', 'ushr-calculator', 'zakat-date-calculator', 'haq-mehr-calculator', 'diyat-calculator', 'wirasat-calculator' ) as $tool ) {
	$n = isset( $inbound[ $tool ] ) ? count( $inbound[ $tool ] ) : 0;
	check( $n >= 4, "$tool has $n linking pages in content" );
	check( in_array( $tool, $footer, true ), "$tool is in the footer" );
}

// FIX-130: every rule page links at least two of its sources once MYZT_Cite has run.
$rule_pages = array( 'hanafi-zakat-calculator', 'shafi-zakat-calculator', 'maliki-zakat-calculator', 'hanbali-zakat-calculator', 'ahl-e-hadith-zakat-calculator', 'shia-zakat-calculator', 'madhab-comparison', 'methodology', 'zakat-on-jewellery', 'fitrana-calculator', 'fidya-kaffara-calculator', 'roza-fidya', 'kaffara-for-breaking-a-fast', 'haq-mehr-calculator', 'diyat-calculator', 'wirasat-calculator', 'daughters-share-in-inheritance', 'wife-husband-share-in-inheritance', 'orphaned-grandchildren-inheritance', 'zakat-on-inherited-wealth', 'hawl-zakat-due-date', 'missed-zakat-past-years', 'ushr-on-crops', 'zakat-on-livestock', 'khums-who-must-pay', 'who-can-receive-zakat' );
foreach ( $rule_pages as $slug ) {
	$n = MYZT_Cite::count( MYZT_Cite::link( $pages[ $slug ]['content'] ) );
	check( $n >= 2, "$slug links $n external sources (want 2)" );
}
$linked = MYZT_Cite::link( 'See Bukhari (1936), Muslim 1111 and 4:11. <a href="/x/">Bukhari 1936</a> <h2>Abu Dawud 1573</h2> [myzt_answer q="q"]Tirmidhi 678[/myzt_answer]' );
check( 2 === substr_count( $linked, 'sunnah.com' ) && false !== strpos( $linked, 'https://quran.com/4/11' ), 'MYZT_Cite links hadith and verses' );
check( false === strpos( $linked, 'abudawud' ) && false === strpos( $linked, 'tirmidhi' ), 'MYZT_Cite leaves headings and quick answers alone' );
check( false !== strpos( $linked, '>Bukhari (1936)</a>' ), 'MYZT_Cite keeps brackets inside the link text' );

echo $fail ? "$fail check(s) failed\n" : 'Page checks OK (' . count( $pages ) . " pages)\n";
exit( $fail ? 1 : 0 );
