<?php
/**
 * Turns plain-text citations in page content into links to the source (audit FIX-130):
 * hadith numbers to sunnah.com, Quran verses to quran.com, and the named fatwas,
 * books and laws the rules rely on. Each source is linked once per page, at its
 * first mention. Text inside links, headings, attributes and shortcodes is left alone.
 * Pure PHP so tests/pages.test.php can run it without WordPress.
 *
 * @package MyZakatTool
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MYZT_Cite {

	const SISTANI = 'https://www.sistani.org/english/book/48/';

	/** Hadith collection names as written in our text => sunnah.com collection. */
	const HADITH = array(
		'Bukhari'   => 'bukhari',
		'Muslim'    => 'muslim',
		'Abu Dawud' => 'abudawud',
		'Tirmidhi'  => 'tirmidhi',
		"Nasa'i"    => 'nasai',
		'Ibn Majah' => 'ibnmajah',
	);

	/** Exact phrases => source URL. */
	public static function phrases() {
		return array(
			'Fatwa 2310/H=713/th=1431'          => 'https://islamqa.org/hanafi/darulifta-deoband/27455/is-zakat-applicable-for-the-jewellery-my-wife-is-using-daily/',
			'Fatwa 702/702=M/1429'              => 'https://islamqa.org/hanafi/darulifta-deoband/27148/how-much-zakat-should-be-paid-if-a-man-has-15-grams-of-gold-and-50-grams-of-silver/',
			'IslamQA 19901'                     => 'https://islamqa.info/en/answers/19901',
			'IslamQA 201807'                    => 'https://islamqa.info/en/answers/201807',
			'IslamQA 22426'                     => 'https://islamqa.info/en/answers/22426',
			'Irsyad Fatwa 38'                   => 'https://muftiwp.gov.my/en/artikel/irsyad-fatwa/irsyad-fatwa-umum-cat/1980-irsyad-fatwa-series-38-zakah-for-women-s-adornments',
			'MUIS Office of the Mufti'          => 'https://www.muis.gov.sg/officeofthemufti/Fatwa/Zakat-On-Gold-Jewellery',
			'MUIS'                              => 'https://www.muis.gov.sg/officeofthemufti/Fatwa/Zakat-On-Gold-Jewellery',
			'SeekersGuidance, "Which debts affect zakat"' => 'https://seekersguidance.org/answers/hanafi-fiqh/which-debts-affect-zakat-for-both-debtor-and-creditor/',
			'SeekersGuidance (debts by madhab)' => 'https://seekersguidance.org/answers/hanafi-fiqh/which-debts-affect-zakat-for-both-debtor-and-creditor/',
			'Akhsar al-Mukhtasarat'             => 'https://inkoffaith.com/post/akhsar-al-mukhtasarat-book-of-zakat-gold-silver-and-trade-goods',
			'rulings 1912-1916'                 => self::SISTANI . '2317/',
			'ruling 1912'                       => self::SISTANI . '2317/',
			'ruling 1913'                       => self::SISTANI . '2318/',
			'ruling 1914'                       => self::SISTANI . '2318/',
			'ruling 1915'                       => self::SISTANI . '2318/',
			'ruling 1916'                       => self::SISTANI . '2318/',
			'Islamic Laws'                      => self::SISTANI,
			'Muslim Family Laws Ordinance 1961' => 'https://pakistancode.gov.pk/english/UY2FqaJw1-apaUY2Fqa-cJyX-sg-jjjjjjjjjjjjj',
			'MFLO 1961'                         => 'https://pakistancode.gov.pk/english/UY2FqaJw1-apaUY2Fqa-cJyX-sg-jjjjjjjjjjjjj',
			'MFLO'                              => 'https://pakistancode.gov.pk/english/UY2FqaJw1-apaUY2Fqa-cJyX-sg-jjjjjjjjjjjjj',
			'Finance Division'                  => 'https://finance.gov.pk/circulars/circular_27072026.pdf',
		);
	}

	public static function init() {
		// Before wpautop (10), wptexturize (10) and do_shortcode (11), so the text still has plain quotes and raw shortcodes.
		add_filter( 'the_content', array( __CLASS__, 'link' ), 8 );
	}

	public static function link( $html ) {
		if ( ! is_string( $html ) || '' === $html ) {
			return $html;
		}
		$seen = array();
		preg_match_all( '#href="(https?://[^"]+)"#', $html, $m );
		foreach ( $m[1] as $u ) {
			$seen[ $u ] = true;
		}
		// Split into protected runs (enclosing quick-answer shortcodes, other shortcodes, tags) and text.
		$parts = preg_split( '#(\[myzt_answer\b.*?\[/myzt_answer\]|\[[^\]]*\]|<[^>]*>)#s', $html, -1, PREG_SPLIT_DELIM_CAPTURE );
		$skip  = 0;
		$out   = '';
		foreach ( $parts as $i => $part ) {
			if ( 1 === $i % 2 ) {
				if ( preg_match( '#^<(/?)(a|h[1-6]|summary|script|style|button|label|option|textarea|title)\b#i', $part, $t ) ) {
					$skip += '/' === $t[1] ? -1 : 1;
					$skip  = max( 0, $skip );
				}
				$out .= $part;
				continue;
			}
			$out .= $skip ? $part : self::text( $part, $seen );
		}
		return $out;
	}

	private static function a( $url, $label ) {
		return '<a href="' . htmlspecialchars( $url, ENT_QUOTES ) . '" rel="noopener" target="_blank">' . $label . '</a>';
	}

	private static function text( $s, &$seen ) {
		if ( '' === trim( $s ) ) {
			return $s;
		}
		static $re = null, $phr = null;
		if ( null === $re ) {
			$names = implode( '|', array_map( 'preg_quote', array_keys( self::HADITH ) ) );
			$phr   = self::phrases();
			uksort(
				$phr,
				function ( $a, $b ) {
					return strlen( $b ) - strlen( $a );
				}
			);
			$alts  = implode( '|', array_map( 'preg_quote', array_keys( $phr ), array_fill( 0, count( $phr ), '#' ) ) );
			$re    = '#(?<hadith>\b(?:Sahih )?(?<coll>' . $names . ') (?:\((?<pnum>[1-9]\d{0,4})\)|(?<num>[1-9]\d{0,4})))'
				. '|(?<!\d)(?<!:)(?<sura>[1-9]\d{0,2}):(?<aya>[1-9]\d{0,2})(?:-(?<to>[1-9]\d{0,2}))?(?![\d:])'
				. '|(?<phrase>(?<!\w)(?:' . $alts . ')(?!\w))#u';
		}
		return preg_replace_callback(
			$re,
			function ( $m ) use ( &$seen, $phr ) {
				$all = $m[0];
				if ( ! empty( $m['hadith'] ) ) {
					$url = 'https://sunnah.com/' . self::HADITH[ $m['coll'] ] . ':' . ( ! empty( $m['num'] ) ? $m['num'] : $m['pnum'] );
				} elseif ( isset( $m['sura'] ) && '' !== $m['sura'] ) {
					if ( (int) $m['sura'] > 114 || (int) $m['aya'] > 286 ) {
						return $all;
					}
					$url = 'https://quran.com/' . $m['sura'] . '/' . $m['aya'] . ( ! empty( $m['to'] ) ? '-' . $m['to'] : '' );
				} else {
					$url = $phr[ $m['phrase'] ];
				}
				if ( isset( $seen[ $url ] ) ) {
					return $all;
				}
				$seen[ $url ] = true;
				return self::a( $url, $all );
			},
			$s
		);
	}

	/** Distinct external citation links in rendered content (used by tests). */
	public static function count( $html ) {
		preg_match_all( '#href="(https?://(?!myzakattool\.com)[^"]+)"#', $html, $m );
		$u = array_unique( $m[1] );
		return count(
			array_filter(
				$u,
				function ( $x ) {
					return false === strpos( $x, 'mailto:' ) && false === strpos( $x, 'linkedin.com' ) && false === strpos( $x, 'google.com' );
				}
			)
		);
	}
}
