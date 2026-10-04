<?php
/**
 * Page definitions: slug => title, SEO title, meta description, content, FAQ.
 * {year} in titles and descriptions is replaced with the coming zakat season year at runtime.
 *
 * @package MyZakatTool
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function myzt_content_pages() {
	$author = '[myzt_author]';
	$p      = array();

	/* ------------------------------------------------------------------ */
	$p['home'] = array(
		'title' => 'Zakat Calculator for Every Madhab',
		'seo'   => 'Zakat Calculator {year} for Every Madhab | Live Gold Rate',
		'desc'  => "Free zakat calculator for Hanafi, Shafi'i, Maliki, Hanbali, Ahl-e-Hadith and Shia with today's gold and silver rate in your currency. Tola or gram, cited sources.",
		'nav'   => 'Zakat Calculator',
		'blurb' => 'every madhab',
		'llms'  => true,
		'content' => <<<'HTML'
<p>Calculate your zakat in seconds with today's gold and silver rate built in. Choose your madhab (Hanafi, Shafi'i, Maliki, Hanbali, Ahl-e-Hadith or Shia Ja'fari) and see exactly how it is worked out, with the source for every rule.</p>
[myzt_trust]
[zakat_calculator compare="open"]
[myzt_answer q="How much is zakat?"]Zakat is 2.5% (one fortieth) of your zakatable wealth once it has stayed at or above the nisab for one lunar year. The nisab is the value of 87.48 g of gold or 612.36 g of silver; today that is about [myzt_rate type="nisab-silver" currency="PKR"] (silver) or [myzt_rate type="nisab-gold" currency="PKR"] (gold).[/myzt_answer]
<h2>How to calculate zakat, step by step</h2>
<ol>
<li><strong>Add up what you own:</strong> cash at home, bank balances, gold and silver, business stock, shares, crypto, committee (BC) payments and money others owe you.</li>
<li><strong>Subtract debts</strong> that are due now, if your madhab allows it (Hanafi, Maliki, Hanbali and Ahl-e-Hadith do; the relied-upon Shafi'i view does not).</li>
<li><strong>Compare with the nisab.</strong> Hanafi scholars use the silver nisab for cash and mixed wealth; Hanbali and Ahl-e-Hadith use whichever is lower; Shafi'i scholars in Malaysia and Singapore usually use gold.</li>
<li><strong>Pay 2.5%</strong> of the total if it reaches the nisab and a lunar year (hawl) has passed.</li>
</ol>
<h2>Why the result changes from one madhab to another</h2>
<p>The biggest difference is <strong>jewellery that is worn</strong>. In the Hanafi madhab zakat is due on it (Darul Uloom Deoband, Fatwa 2310/H=713/th=1431). In the Shafi'i, Maliki and Hanbali madhabs permissible worn jewellery is exempt. Debts and the choice of gold or silver nisab also change the answer. Press <em>Compare all madhabs</em> above to see your own numbers side by side, or read the <a href="/madhab-comparison/">full comparison</a>.</p>
<h2>Worked example</h2>
<p>Ahmed has Rs 1,50,000 cash, Rs 3,50,000 in the bank, 3 tola of 22K gold jewellery that he owns and his wife wears, and Rs 1,00,000 of debt due now.</p>
<ul>
<li><strong>Hanafi and Ahl-e-Hadith:</strong> the jewellery is counted and the debt is subtracted, so zakat is 2.5% of Rs 4,00,000 plus the value of the gold.</li>
<li><strong>Maliki and Hanbali:</strong> worn jewellery is not counted, so zakat is 2.5% of Rs 4,00,000 = Rs 10,000.</li>
<li><strong>Shafi'i:</strong> the jewellery is exempt and the debt is not subtracted, so Rs 5,00,000 is compared with the gold nisab (about [myzt_rate type="nisab-gold" currency="PKR"] today). It is below it, so nothing is due unless he chooses the silver nisab.</li>
<li><strong>Shia (Sistani):</strong> no zakat on paper money or jewellery; khums applies instead.</li>
</ul>
<p>The calculator above does these steps for you with today's rate.</p>
<h2>Is my data safe?</h2>
<p>Yes. Everything is calculated inside your browser. Nothing you type is sent to our server or saved by us. You can download a PDF report or a data file for your own records.</p>
[myzt_faq]
HTML
		. $author . '[myzt_related slugs="hanafi-zakat-calculator,zakat-on-gold-calculator,nisab,fitrana-calculator"]',
		'faq'   => array(
			array( 'q' => 'How much is zakat on 1 lakh rupees?', 'a' => 'If your total zakatable wealth is above the nisab, zakat on Rs 1,00,000 is Rs 2,500 (2.5%).' ),
			array( 'q' => 'Is zakat due on gold jewellery that is worn?', 'a' => "In the Hanafi madhab and according to the Saudi Permanent Committee (followed by many Ahl-e-Hadith scholars), yes. In the Shafi'i, Maliki and Hanbali madhabs, permissible jewellery that is worn is exempt." ),
			array( 'q' => 'Which nisab should I use, gold or silver?', 'a' => 'Hanafi scholars such as Darul Uloom Deoband use the silver nisab for cash and mixed assets because it is better for the poor. If you own only gold, the gold nisab of 87.48 g (7.5 tola) applies.' ),
			array( 'q' => 'Kya bank ki 1 Ramazan wali katauti ke baad dobara zakat deni hogi?', 'a' => 'Apni poori zakat calculate karen aur jo raqam bank pehle kaat chuka hai use minus kar len. Calculator mein "Already paid" par tap kar ke bank ki katauti likhen, baqi raqam khud nikal aayegi. Tafseel ke liye apne aalim se poochen.' ),
			array( 'q' => 'Does this calculator give a fatwa?', 'a' => 'No. It gives an estimate based on published rulings of each school, with sources. Please confirm with a qualified scholar.' ),
		),
	);

	/* ------------------------------------------------------------------ */
	$p['madhab'] = array(
		'title' => 'Zakat Calculator by Madhab',
		'seo'   => 'Zakat Calculator by Madhab: Hanafi, Shafi\'i, Maliki, Hanbali, Shia',
		'desc'  => 'Pick your school of thought and calculate zakat by its rules: Hanafi, Shafi\'i, Maliki, Hanbali, Ahl-e-Hadith or Shia Ja\'fari, each with cited sources.',
		'nav'   => 'By Madhab',
		'blurb' => 'all schools',
		'llms'  => true,
		'content' => <<<'HTML'
<p>Every school of Islamic law agrees that zakat is 2.5% of wealth above the nisab, but they differ on a few questions that can change your amount a lot. Choose your madhab below for a calculator already set to its rules.</p>
<ul>
<li><a href="/hanafi-zakat-calculator/"><strong>Hanafi zakat calculator</strong></a>: jewellery counted, debts deducted, silver nisab. Followed by most Muslims in Pakistan, India, Bangladesh, Turkey and Central Asia (Deobandi and Barelvi).</li>
<li><a href="/shafi-zakat-calculator/"><strong>Shafi'i zakat calculator</strong></a>: worn jewellery exempt, debts not deducted, gold and silver separate. Malaysia, Indonesia, Egypt, East Africa.</li>
<li><a href="/maliki-zakat-calculator/"><strong>Maliki zakat calculator</strong></a>: worn jewellery exempt, debts deducted from cash and trade wealth. North and West Africa.</li>
<li><a href="/hanbali-zakat-calculator/"><strong>Hanbali zakat calculator</strong></a>: worn jewellery exempt, lower nisab. Saudi Arabia and Qatar.</li>
<li><a href="/ahl-e-hadith-zakat-calculator/"><strong>Ahl-e-Hadith zakat calculator</strong></a>: jewellery counted, lower nisab, following the Saudi Permanent Committee.</li>
<li><a href="/shia-zakat-calculator/"><strong>Shia (Ja'fari) zakat calculator</strong></a>: rulings of Ayatollah Sistani, with a link to khums.</li>
</ul>
<p>Not sure? Use the <a href="/madhab-comparison/">madhab comparison</a> to see all six results for the same numbers.</p>
<h2>How to choose your madhab</h2>
<p>Follow the school you already follow for prayer and fasting. If your family is Deobandi or Barelvi, that is Hanafi. If you pray with Ahl-e-Hadith scholars, use the Ahl-e-Hadith calculator. Followers of Fiqh-e-Jafaria should use the Shia calculator. If you are a convert or unsure, ask the imam of the mosque you attend and use that school, rather than picking whichever gives the lowest number.</p>
<h2>Why the results differ</h2>
<p>The four questions that change the amount are: is worn jewellery zakatable, do debts reduce zakat, which nisab (gold or silver) applies to cash, and are gold and silver added together. For a family with a lot of jewellery, the Hanafi and Ahl-e-Hadith results are usually the highest; for someone with large debts, the Shafi'i result can be higher because debts are not subtracted. Each calculator page lists its source fatwas, and our <a href="/methodology/">methodology</a> explains how we read them.</p>
<p>Whichever school you follow, the calculator gives an estimate. It is not a fatwa; see the <a href="/disclaimer/">disclaimer</a>.</p>
[myzt_faq]
HTML
		. $author,
		'faq'   => array(
			array( 'q' => 'Which madhab is followed in Pakistan?', 'a' => 'Most Sunni Muslims in Pakistan follow the Hanafi madhab (Deobandi and Barelvi). There are also large Ahl-e-Hadith and Shia (Ja\'fari) communities.' ),
			array( 'q' => 'Can I choose the madhab that gives less zakat?', 'a' => 'Scholars advise following the school you already follow, not choosing rulings for convenience. If unsure, ask a scholar.' ),
			array( 'q' => 'Main kaunsa maslak chunoon?', 'a' => 'Jis maslak par aap namaz aur roza mein amal karte hain, wahi chunain. Deobandi aur Barelvi dono Hanafi hain.' ),
		),
	);

	$madhab_pages = array(
		'hanafi-zakat-calculator' => array(
			'key'   => 'hanafi',
			'title' => 'Hanafi Zakat Calculator',
			'seo'   => 'Hanafi Zakat Calculator {year} (Deobandi & Barelvi) | Live Rate',
			'desc'  => 'Calculate zakat by Hanafi fiqh: jewellery included, debts deducted, silver nisab. Live gold and silver rate in tola or gram, with Darul Uloom Deoband references.',
			'nav'   => 'Hanafi',
			'blurb' => 'Deobandi & Barelvi',
			'intro' => '<p>This calculator follows the Hanafi madhab, the school followed by most Muslims in Pakistan, India, Bangladesh, Afghanistan and Turkey. Deobandi and Barelvi scholars agree on these zakat rules.</p>',
			'answer' => 'In Hanafi fiqh zakat is 2.5% of all cash, gold, silver and trade goods after subtracting debts due now, if the total reaches the silver nisab of 612.36 g (52.5 tola). Gold jewellery is counted even if it is worn daily.',
			'body'  => <<<'HTML'
<h2>Hanafi zakat rules used in this calculator</h2>
<ul>
<li><strong>Jewellery:</strong> zakat is wajib on gold and silver jewellery even if it is used every day (Darul Uloom Deoband, Fatwa 2310/H=713/th=1431).</li>
<li><strong>Nisab:</strong> when you own cash, trade goods or a mix of gold and silver, the values are added and compared with the silver nisab (Darul Uloom Deoband, Fatwa 702/702=M/1429). If you own only gold, the gold nisab of 7.5 tola (87.48 g) applies.</li>
<li><strong>Debts:</strong> debts that are due now are subtracted first. Only the instalments due in the coming year are subtracted for long loans, a view widely given by contemporary Hanafi scholars.</li>
<li><strong>Money owed to you:</strong> zakat is due every year on loans you expect to get back, but you may pay it when you receive the money.</li>
<li><strong>Rate:</strong> 2.5% after one lunar year (hawl).</li>
</ul>
<h2>Deobandi and Barelvi</h2>
<p>Both follow Hanafi fiqh. Standard Barelvi references such as <em>Bahar-e-Shariat</em> give the same rules for jewellery, debts and nisab, so one Hanafi calculator works for both.</p>
<h2>Bank deduction in Pakistan</h2>
<p>Banks deduct zakat from savings accounts on 1 Ramadan under Pakistan's zakat law. Calculate your full zakat here and subtract what the bank already deducted. See our <a href="/bank-zakat-deduction-pakistan/">bank deduction guide</a>.</p>
HTML,
			'faq'   => array(
				array( 'q' => 'Is zakat due on gold jewellery worn every day in Hanafi fiqh?', 'a' => 'Yes. Darul Uloom Deoband states that zakat is wajib on jewellery even if it is used daily (Fatwa 2310/H=713/th=1431).' ),
				array( 'q' => 'Hanafi nisab sona ya chandi?', 'a' => 'Agar sirf sona ho to 7.5 tola sone ka nisab. Agar naqd, maal-e-tijarat ya sona aur chandi dono hon to sab ki qeemat jor kar chandi ke nisab (52.5 tola) se dekha jata hai.' ),
				array( 'q' => 'Are debts subtracted in Hanafi zakat?', 'a' => 'Yes, debts due now are subtracted before checking the nisab.' ),
			),
			'related' => 'zakat-calculator-pakistan,zakat-on-gold-calculator,madhab-comparison,zakat-on-jewellery',
		),
		'shafi-zakat-calculator' => array(
			'key'   => 'shafii',
			'title' => "Shafi'i Zakat Calculator",
			'seo'   => "Shafi'i Zakat Calculator {year}: Gold, Jewellery & Cash",
			'desc'  => "Calculate zakat by Shafi'i fiqh: worn jewellery exempt, debts not deducted, gold and silver checked separately. Live rates, choice of gold or silver nisab.",
			'nav'   => "Shafi'i",
			'blurb' => 'Malaysia, Indonesia, Egypt',
			'intro' => "<p>This calculator follows the Shafi'i madhab, followed in Malaysia, Indonesia, Singapore, Brunei, Egypt, Yemen, Somalia, Kenya and Sri Lanka.</p>",
			'answer' => "In Shafi'i fiqh permissible jewellery that a woman wears is exempt, debts do not reduce zakat, and gold and silver are separate classes that are not added together to reach the nisab.",
			'body'  => <<<'HTML'
<h2>Shafi'i zakat rules used in this calculator</h2>
<ul>
<li><strong>Jewellery:</strong> no zakat on permissible jewellery that is worn. If it goes beyond the customary amount (about 860 g, 200 mithqal) it becomes zakatable, as do pieces kept for investment (MUIS Office of the Mufti, citing Imam al-Nawawi's <em>al-Majmu'</em>).</li>
<li><strong>Debts:</strong> in the relied-upon position, debts do not prevent or reduce zakat.</li>
<li><strong>Gold and silver:</strong> treated as two separate classes; each is checked against its own nisab.</li>
<li><strong>Cash and trade goods:</strong> valued against a nisab standard. Official bodies in Malaysia and Singapore use the gold standard; you can switch to silver in the calculator.</li>
<li><strong>Money owed to you:</strong> zakat is paid every year on loans you are sure to get back.</li>
</ul>
HTML,
			'faq'   => array(
				array( 'q' => "Is there zakat on worn jewellery in the Shafi'i madhab?", 'a' => 'No, as long as it is permissible and within the customary amount. Jewellery kept for investment or far beyond custom is zakatable.' ),
				array( 'q' => "Do debts reduce zakat for Shafi'is?", 'a' => "In the relied-upon Shafi'i position, no: debts do not prevent the obligation of zakat." ),
				array( 'q' => "Gold or silver nisab in Shafi'i fiqh?", 'a' => 'Gold and silver each have their own nisab. For cash, Malaysian and Singaporean authorities use the gold standard; the calculator lets you choose.' ),
			),
			'related' => 'madhab-comparison,zakat-on-jewellery,nisab,gold-rate-today',
		),
		'maliki-zakat-calculator' => array(
			'key'   => 'maliki',
			'title' => 'Maliki Zakat Calculator',
			'seo'   => 'Maliki Zakat Calculator {year}: Cash, Gold & Business',
			'desc'  => 'Calculate zakat by Maliki fiqh: worn jewellery exempt, debts deducted from cash, gold, silver and trade goods. Live rates, gold or silver nisab.',
			'nav'   => 'Maliki',
			'blurb' => 'North & West Africa',
			'intro' => '<p>This calculator follows the Maliki madhab, followed in Morocco, Algeria, Tunisia, Libya, Mauritania, Sudan and much of West Africa.</p>',
			'answer' => 'In Maliki fiqh permissible worn jewellery is exempt, and debts are subtracted from cash, gold, silver and trade goods (but not from crops or livestock) before checking the nisab.',
			'body'  => <<<'HTML'
<h2>Maliki zakat rules used in this calculator</h2>
<ul>
<li><strong>Jewellery:</strong> no zakat on permissible jewellery that is used and worn (Mufti of Wilayah Persekutuan, Irsyad Fatwa 38, summarising the Maliki, Shafi'i and Hanbali view).</li>
<li><strong>Debts:</strong> debts reduce zakat on "hidden" wealth: cash, gold, silver and trade goods. They do not reduce zakat on crops and livestock, which this calculator does not cover.</li>
<li><strong>Gold and silver:</strong> may be combined to reach the nisab.</li>
<li><strong>Money owed to you:</strong> a merchant pays yearly on trade debts; for a cash loan, zakat is paid when it is received.</li>
<li><strong>Nisab for cash:</strong> the calculator starts with silver and lets you switch to gold. Ask a local scholar which your community uses.</li>
</ul>
HTML,
			'faq'   => array(
				array( 'q' => 'Is worn jewellery zakatable in the Maliki madhab?', 'a' => 'No, permissible jewellery that is worn is exempt.' ),
				array( 'q' => 'Are debts deducted in Maliki zakat?', 'a' => 'Yes, from cash, gold, silver and trade goods, but not from crops or livestock.' ),
			),
			'related' => 'madhab-comparison,business-zakat-calculator,nisab,zakat-on-jewellery',
		),
		'hanbali-zakat-calculator' => array(
			'key'   => 'hanbali',
			'title' => 'Hanbali Zakat Calculator',
			'seo'   => 'Hanbali Zakat Calculator {year}: Gold, Cash & Jewellery',
			'desc'  => 'Calculate zakat by Hanbali fiqh: permissible worn jewellery exempt, debts deducted, gold and silver combined using the nisab that is best for the poor.',
			'nav'   => 'Hanbali',
			'blurb' => 'Saudi Arabia, Qatar',
			'intro' => '<p>This calculator follows the relied-upon position of the Hanbali madhab, followed in Saudi Arabia and Qatar.</p>',
			'answer' => 'In the Hanbali madhab permissible jewellery that is worn or lent is exempt, debts are deducted, and gold and silver are combined; cash and trade goods are measured by whichever nisab is better for the poor.',
			'body'  => <<<'HTML'
<h2>Hanbali zakat rules used in this calculator</h2>
<ul>
<li><strong>Jewellery:</strong> "Zakat is not required on permitted jewellery that is ready to be used or lent out" (<em>Akhsar al-Mukhtasarat</em>, Book of Zakat).</li>
<li><strong>Combining:</strong> gold and silver are added together to complete the nisab.</li>
<li><strong>Nisab for cash and trade goods:</strong> the standard that is best for the poor, which today is silver.</li>
<li><strong>Debts:</strong> subtracted before checking the nisab.</li>
</ul>
<p>Some well-known scholars in Saudi Arabia, such as the Permanent Committee, hold that jewellery is zakatable. If you follow that view, use the <a href="/ahl-e-hadith-zakat-calculator/">Ahl-e-Hadith calculator</a>, which applies it.</p>
HTML,
			'faq'   => array(
				array( 'q' => 'Is jewellery zakatable in the Hanbali madhab?', 'a' => 'In the relied-upon Hanbali position, no, if it is permissible and kept for use or lending. Some contemporary Saudi scholars hold that it is zakatable.' ),
				array( 'q' => 'Which nisab do Hanbalis use for cash?', 'a' => 'The one that is best for the poor, which today is the silver nisab.' ),
			),
			'related' => 'ahl-e-hadith-zakat-calculator,madhab-comparison,nisab,gold-rate-today',
		),
		'ahl-e-hadith-zakat-calculator' => array(
			'key'   => 'ahlehadith',
			'title' => 'Ahl-e-Hadith Zakat Calculator',
			'seo'   => 'Ahl-e-Hadith Zakat Calculator {year}: Zevar, Cash, Gold',
			'desc'  => 'Zakat calculator for Ahl-e-Hadith (Salafi): jewellery included, debts deducted, cash added to gold and silver, lower nisab. Live rates and cited sources.',
			'nav'   => 'Ahl-e-Hadith',
			'blurb' => 'Salafi view',
			'intro' => '<p>This calculator applies the rulings of the Saudi Permanent Committee for Research and Fatwa (al-Lajnah ad-Da\'imah) and Shaykh Ibn Uthaymeen, which Ahl-e-Hadith scholars in Pakistan and India commonly follow.</p>',
			'answer' => 'Following the Saudi Permanent Committee, zakat is due on gold and silver jewellery that reaches the nisab, even if worn, and cash is added to gold and silver and measured by the lower of the two nisabs.',
			'body'  => <<<'HTML'
<h2>Rules used in this calculator</h2>
<ul>
<li><strong>Jewellery:</strong> "The more correct view is that zakat on jewellery is obligatory if it reaches the nisab" (IslamQA 19901, citing the Permanent Committee).</li>
<li><strong>Cash with gold and silver:</strong> cash may be added to gold or silver to complete the nisab, and cash is zakatable when it reaches the lower of the two nisabs (IslamQA 201807, citing the Permanent Committee and Ibn Uthaymeen).</li>
<li><strong>Debts:</strong> deducted before checking the nisab.</li>
</ul>
<p>We have not found a published fatwa from a Pakistani Ahl-e-Hadith institution on every point above. If your scholar differs, the comparison table shows the other views.</p>
HTML,
			'faq'   => array(
				array( 'q' => 'Ahl-e-Hadith ke nazdeek zevar par zakat hai?', 'a' => 'Saudi Permanent Committee ke fatwe ke mutabiq, jise Ahl-e-Hadith ulama aam tor par maante hain, nisab tak pohanchne wale zevar par zakat wajib hai, chahe pehna jaye.' ),
				array( 'q' => 'Can cash be added to gold to complete the nisab?', 'a' => 'Yes, according to the Permanent Committee and Shaykh Ibn Uthaymeen.' ),
			),
			'related' => 'hanbali-zakat-calculator,zakat-on-jewellery,madhab-comparison,nisab',
		),
		'shia-zakat-calculator' => array(
			'key'   => 'jafari',
			'title' => "Shia (Ja'fari) Zakat Calculator",
			'seo'   => "Shia Zakat Calculator (Ja'fari, Sistani) & Khums Guide",
			'desc'  => "Shia Ja'fari zakat explained by Ayatollah Sistani's rulings: which assets carry zakat, the gold and silver nisab in mithqal, and when khums applies instead.",
			'nav'   => 'Shia (Ja\'fari)',
			'blurb' => 'Sistani rulings',
			'intro' => "<p>This calculator follows the rulings of Ayatollah Sistani in <em>Islamic Laws</em> (Taudhih al-Masa'il), the most widely followed marja'.</p>",
			'answer' => 'According to Ayatollah Sistani, zakat on gold and silver applies only to coins used as currency, so paper money, bank balances and jewellery carry no zakat today. Khums (20%) on the yearly surplus applies instead.',
			'body'  => <<<'HTML'
<h2>Zakat in Ja'fari fiqh (Sistani)</h2>
<ul>
<li><strong>Nine items only:</strong> zakat is due on wheat, barley, dates, raisins, camels, cows, sheep, and gold and silver coins.</li>
<li><strong>Gold nisab:</strong> 20 shar'i mithqal, about 69.12 g (ruling 1912). <strong>Silver nisab:</strong> 105 common mithqal, about 483.84 g (ruling 1913).</li>
<li><strong>Currency:</strong> zakat applies only when gold or silver is minted and used in transactions as money; modern paper money and coins of other metals do not qualify (ruling 1915).</li>
<li><strong>Jewellery:</strong> not zakatable while gold and silver are not used as currency (ruling 1916).</li>
</ul>
<p>Because of this, the calculator usually shows zero zakat for cash, bank money and jewellery in Ja'fari mode. Use the <a href="/khums-calculator/">khums calculator</a> for your yearly surplus.</p>
<p>Followers of other maraji' (for example Ayatollah Khamenei) should check their marja's rulings, which may differ in details.</p>
HTML,
			'faq'   => array(
				array( 'q' => 'Do Shia Muslims pay zakat on cash?', 'a' => 'According to Ayatollah Sistani, no: paper money is not zakatable, but khums (20%) is due on the surplus of the year.' ),
				array( 'q' => "What is the gold nisab in Ja'fari fiqh?", 'a' => "20 shar'i mithqal, about 69.12 g, according to Ayatollah Sistani (ruling 1912)." ),
			),
			'related' => 'khums-calculator,madhab-comparison,fitrana-calculator,nisab',
		),
	);

	foreach ( $madhab_pages as $slug => $m ) {
		$p[ $slug ] = array(
			'title'   => $m['title'],
			'seo'     => $m['seo'],
			'desc'    => $m['desc'],
			'nav'     => $m['nav'],
			'blurb'   => $m['blurb'],
			'hub'     => 'madhab',
			'llms'    => true,
			'content' => $m['intro'] . '[myzt_trust][zakat_calculator madhab="' . $m['key'] . '"][myzt_answer q="' . esc_attr( $m['title'] ) . ': the short answer"]' . $m['answer'] . '[/myzt_answer]' .
				$m['body'] . '<p>See how the same numbers come out in every school in the <a href="/madhab-comparison/">madhab comparison</a>. How we read each source is explained in our <a href="/methodology/">methodology</a>.</p>[myzt_faq]' . $author . '[myzt_related slugs="' . $m['related'] . '"]',
			'faq'     => $m['faq'],
		);
	}

	/* ------------------------------------------------------------------ */
	$p['madhab-comparison'] = array(
		'title' => 'Zakat in the 4 Madhabs and Shia: Comparison',
		'seo'   => 'Zakat According to 4 Madhabs & Shia: Comparison Table',
		'desc'  => "How Hanafi, Shafi'i, Maliki, Hanbali, Ahl-e-Hadith and Shia fiqh differ on zakat: jewellery, debts, nisab, combining gold and silver. With sources and calculator.",
		'nav'   => 'Madhab Comparison',
		'blurb' => 'side by side',
		'hub'   => 'madhab',
		'llms'  => true,
		'content' => <<<'HTML'
[myzt_answer q="Where do the madhabs differ on zakat?"]Mainly on four points: zakat on worn jewellery, whether debts are subtracted, which nisab (gold or silver) applies to cash, and whether gold and silver are added together.[/myzt_answer]
<figure class="wp-block-table"><table>
<thead><tr><th>Question</th><th>Hanafi</th><th>Shafi'i</th><th>Maliki</th><th>Hanbali</th><th>Ahl-e-Hadith</th><th>Shia (Sistani)</th></tr></thead>
<tbody>
<tr><td>Worn jewellery</td><td>Zakatable</td><td>Exempt</td><td>Exempt</td><td>Exempt</td><td>Zakatable</td><td>Exempt</td></tr>
<tr><td>Debts subtracted</td><td>Yes</td><td>No</td><td>Yes (cash, gold, trade)</td><td>Yes</td><td>Yes</td><td>n/a</td></tr>
<tr><td>Nisab for cash</td><td>Silver</td><td>Gold (local practice)</td><td>Silver or gold</td><td>Lower of the two</td><td>Lower of the two</td><td>No zakat on paper money</td></tr>
<tr><td>Gold + silver combined</td><td>Yes, by value</td><td>No</td><td>Yes</td><td>Yes</td><td>Yes</td><td>No</td></tr>
<tr><td>Gold nisab</td><td>87.48 g</td><td>87.48 g</td><td>87.48 g</td><td>87.48 g</td><td>87.48 g</td><td>69.12 g (coins)</td></tr>
<tr><td>Main source</td><td>Darul Uloom Deoband</td><td>al-Majmu', MUIS</td><td>Irsyad Fatwa 38</td><td>Akhsar al-Mukhtasarat</td><td>Permanent Committee</td><td>Sistani, rulings 1912-1916</td></tr>
</tbody></table></figure>
<h2>Try it with your own numbers</h2>
<p>The calculator below shows your zakat in all six schools at once.</p>
[zakat_calculator compare="open"]
<h2>Why there are differences</h2>
<p>The schools read the hadiths about jewellery differently. Hanafi scholars take the reports in which the Prophet ﷺ asked women whether they paid zakat on their bracelets as a general rule; the other three schools consider permissible jewellery like personal belongings, citing companions such as Aishah and Asma who did not pay zakat on the jewellery of the girls in their care. On debts, the Shafi'i school treats zakat as a right tied to the wealth itself, so a debt owed to someone else does not remove it.</p>
<p>All of these are legitimate scholarly positions. Follow the school you follow in your other worship, and ask your scholar when you are unsure.</p>
[myzt_faq]
HTML
		. $author . '[myzt_related slugs="hanafi-zakat-calculator,shafi-zakat-calculator,zakat-on-jewellery,methodology"]',
		'faq'   => array(
			array( 'q' => 'Which madhab gives the highest zakat?', 'a' => 'Usually the Hanafi madhab, because it counts worn jewellery and uses the lower silver nisab.' ),
			array( 'q' => 'Can I choose the madhab with the lowest zakat?', 'a' => 'Scholars advise following the school you normally follow, not picking the easiest view for each question.' ),
		),
	);

	/* ------------------------------------------------------------------ */
	$p['calculators'] = array(
		'title' => 'Zakat Calculators',
		'seo'   => 'Zakat Calculators: Gold, Business, Fitrana, Khums, Pakistan',
		'desc'  => 'All free zakat tools in one place: zakat on gold, business zakat, Pakistan calculator, fitrana, khums, nisab today and gold rate today.',
		'nav'   => 'Calculators',
		'blurb' => 'all tools',
		'content' => <<<'HTML'
<p>All tools use today's international gold and silver rates and work in 50 currencies.</p>
<ul>
<li><a href="/">Zakat calculator for every madhab</a></li>
<li><a href="/zakat-calculator-pakistan/">Zakat calculator Pakistan</a> (tola, rupees, bank deduction)</li>
<li><a href="/zakat-on-gold-calculator/">Zakat on gold calculator</a> (tola, gram, karat)</li>
<li><a href="/business-zakat-calculator/">Business zakat calculator</a> (stock, receivables, suppliers)</li>
<li><a href="/fitrana-calculator/">Fitrana calculator</a></li>
<li><a href="/fidya-kaffara-calculator/">Fidya and kaffara calculator</a></li>
<li><a href="/zakat-date-calculator/">Zakat date calculator</a> (hawl tracker, reminders, missed years)</li>
<li><a href="/ushr-calculator/">Ushr and livestock calculator</a> (crops, goats, cows, camels)</li>
<li><a href="/khums-calculator/">Khums calculator</a></li>
<li><a href="/nisab/">Nisab today</a> and <a href="/gold-rate-today/">gold rate today</a></li>
<li><a href="/free-zakat-widget/">Free nisab widget</a> for mosque and blog websites</li>
</ul>
<h2>Which tool should I use?</h2>
<ul>
<li><strong>A salaried person or family with savings and gold:</strong> start with the <a href="/">main calculator</a> and choose your madhab. Add family members to calculate each person's zakat separately.</li>
<li><strong>Only gold or jewellery:</strong> the <a href="/zakat-on-gold-calculator/">zakat on gold calculator</a> takes tola, gram or ounce and the karat (24K, 22K, 21K, 18K).</li>
<li><strong>A shopkeeper or trader:</strong> the <a href="/business-zakat-calculator/">business zakat calculator</a> values stock at selling price, adds money customers owe you and subtracts supplier bills.</li>
<li><strong>In Pakistan, with a savings account:</strong> the <a href="/zakat-calculator-pakistan/">Pakistan calculator</a> handles committees (BC), prize bonds and the bank's 1 Ramadan deduction.</li>
<li><strong>Before Eid:</strong> the <a href="/fitrana-calculator/">fitrana calculator</a> works out sadaqat al-fitr for every person in the house, and the <a href="/fidya-kaffara-calculator/">fidya and kaffara calculator</a> covers missed or broken fasts.</li>
<li><strong>Not sure when your zakat is due, or missed some years:</strong> the <a href="/zakat-date-calculator/">zakat date calculator</a>.</li>
<li><strong>Farmers and livestock owners:</strong> the <a href="/ushr-calculator/">ushr and livestock calculator</a>.</li>
<li><strong>Fiqh-e-Jafaria:</strong> the <a href="/khums-calculator/">khums calculator</a> for the yearly surplus, next to the <a href="/shia-zakat-calculator/">Shia zakat calculator</a>.</li>
</ul>
<p>Every tool runs in your browser, so nothing you enter is sent to us, and each one can produce a short PDF of your own figures for your records.</p>
[myzt_faq]
HTML
		. $author,
		'faq'   => array(
			array( 'q' => 'Are these zakat calculators free?', 'a' => 'Yes, all of them, with no sign-up.' ),
			array( 'q' => 'Which gold rate do the calculators use?', 'a' => 'The international spot price, refreshed every hour. You can enter your own local rate instead.' ),
			array( 'q' => 'Do the calculators work outside Pakistan?', 'a' => 'Yes. They support about 50 currencies, and grams and ounces as well as tola.' ),
		),
	);

	$p['zakat-calculator-pakistan'] = array(
		'title' => 'Zakat Calculator Pakistan',
		'seo'   => 'Zakat Calculator Pakistan {year}: Tola Gold, Rupees, Bank',
		'desc'  => 'Pakistan zakat calculator in rupees with today\'s gold rate per tola. Covers committee (BC), prize bonds, plots, bank 1 Ramadan deduction and Hanafi rules.',
		'nav'   => 'Pakistan',
		'blurb' => 'tola & rupees',
		'hub'   => 'calculators',
		'llms'  => true,
		'content' => <<<'HTML'
<p>Made for Pakistan: amounts in rupees with lakh formatting, gold and silver in tola, and fields for committees, prize bonds and plots. The calculator starts with Hanafi fiqh (Deobandi and Barelvi); you can switch to Ahl-e-Hadith or Shia.</p>
[zakat_calculator madhab="hanafi"]
[myzt_answer q="Zakat in Pakistan this year:"]Today 1 tola of 24K gold is about [myzt_rate type="gold-tola" currency="PKR"] and the silver nisab (52.5 tola) is about [myzt_rate type="nisab-silver" currency="PKR"] at international rates. If your total wealth is above that for a lunar year, zakat is 2.5%.[/myzt_answer]
<h2>What to include in Pakistan</h2>
<ul>
<li><strong>Committee (BC):</strong> the amount you have paid in so far is your money and is zakatable. Once you receive the committee, count what is left of it.</li>
<li><strong>Prize bonds and savings certificates (NSC, Behbood, DSC):</strong> count the amount you invested, in the "Savings certificates" field. If zakat was deducted from them, enter it under "Already paid". See <a href="/zakat-on-savings-certificates/">zakat on savings certificates</a>.</li>
<li><strong>Plots:</strong> a plot bought to sell is trade goods; count its market value. A house or plot for your own use has no zakat.</li>
<li><strong>Gold:</strong> local jewellery is usually 21K or 22K; choose the karat so only the pure gold is counted.</li>
</ul>
<h2>Bank deduction on 1 Ramadan</h2>
<p>Under Pakistan's zakat law, banks deduct 2.5% from savings accounts whose balance is above the government's nisab on 1 Ramadan. Current accounts are not deducted. People who are exempt on grounds of fiqh can submit a CZ-50 declaration to their bank before Ramadan. Read the <a href="/bank-zakat-deduction-pakistan/">full guide</a>.</p>
<h2>International rate vs. sarafa rate</h2>
<p>The calculator uses the international gold rate converted to rupees. The local sarafa rate can be a little higher or lower; if you want to use it, tick <em>Use my own local rate</em>.</p>
[myzt_faq]
HTML
		. $author . '[myzt_related slugs="hanafi-zakat-calculator,zakat-on-gold-calculator,fitrana-calculator,bank-zakat-deduction-pakistan"]',
		'faq'   => array(
			array( 'q' => 'Committee ke paison par zakat hai?', 'a' => 'Haan, committee mein jitni raqam aap jama kara chuke hain wo aap ki milkiyat hai aur us par zakat hai.' ),
			array( 'q' => 'Is zakat due on a plot in Pakistan?', 'a' => 'Only if it was bought with the intention to sell. Then its current market value is zakatable. A plot or house for living has no zakat.' ),
			array( 'q' => 'Does the bank deduction count as my zakat?', 'a' => 'Calculate your full zakat and subtract what the bank has already deducted. Ask your scholar about your case.' ),
		),
	);

	$p['zakat-on-gold-calculator'] = array(
		'title' => 'Zakat on Gold Calculator',
		'seo'   => 'Zakat on Gold Calculator {year}: Per Tola & Gram, Live Rate',
		'desc'  => 'How much zakat on gold? Enter tola or grams and karat (24K, 22K, 21K, 18K) and get zakat at today\'s gold rate, with worn jewellery rules for each madhab.',
		'nav'   => 'Zakat on Gold',
		'blurb' => 'tola / gram',
		'hub'   => 'calculators',
		'llms'  => true,
		'content' => <<<'HTML'
[myzt_answer q="How much zakat on 1 tola of gold?"]At today's rate 1 tola of 24K gold is about [myzt_rate type="gold-tola" currency="PKR"], so its zakat is 2.5% of that, about [myzt_rate type="gold-tola-zakat" currency="PKR"]. For 22K gold it is about [myzt_rate type="gold22-tola-zakat" currency="PKR"]. Zakat is due only if your total wealth reaches the nisab.[/myzt_answer]
<p>Tap <strong>Gold</strong> in the calculator, enter the weight in tola or grams and choose the karat.</p>
[zakat_calculator]
<h2>How zakat on gold is worked out</h2>
<ol>
<li>Find the pure gold: weight × karat ÷ 24. For example 10 g of 22K gold contains 9.17 g of pure gold.</li>
<li>Multiply by today's 24K price per gram.</li>
<li>Add it to your other zakatable wealth and check the nisab.</li>
<li>Pay 2.5% of the total.</li>
</ol>
<h2>Gold nisab</h2>
<p>The nisab of gold is 87.48 g (7.5 tola), about [myzt_rate type="nisab-gold" currency="PKR"] today. If you own only gold and nothing else, zakat is due only when your pure gold reaches this weight. If you also have cash or silver, Hanafi scholars add everything together and use the silver nisab.</p>
<h2>Worn jewellery</h2>
<p>Hanafi and Ahl-e-Hadith: zakatable. Shafi'i, Maliki and Hanbali: exempt if permissible and worn. See <a href="/zakat-on-jewellery/">zakat on jewellery in the 4 madhabs</a>.</p>
[myzt_faq]
HTML
		. $author . '[myzt_related slugs="gold-rate-today,nisab,zakat-on-jewellery,zakat-on-1-tola-gold"]',
		'faq'   => array(
			array( 'q' => '1 tola sone par kitni zakat hai?', 'a' => '1 tola sone ki aaj ki qeemat ka 2.5%. Lekin zakat tabhi farz hai jab aap ka kul maal nisab tak pohanche.' ),
			array( 'q' => 'Is zakat calculated on the purchase price or today\'s price?', 'a' => "On today's market value on the day your zakat year completes, not the price you paid." ),
			array( 'q' => 'Do I count stones and making charges?', 'a' => 'No. Only the weight of pure gold is counted, at the gold rate.' ),
		),
	);

	$p['business-zakat-calculator'] = array(
		'title' => 'Business Zakat Calculator',
		'seo'   => 'Business Zakat Calculator: Stock, Cash, Receivables',
		'desc'  => 'Calculate zakat on a business: stock at sale value, business cash, money owed by customers, minus supplier bills. Every madhab, with a PDF report for your records.',
		'nav'   => 'Business Zakat',
		'blurb' => 'stock & receivables',
		'hub'   => 'calculators',
		'llms'  => true,
		'content' => <<<'HTML'
[myzt_answer q="How is zakat on business calculated?"]Add business cash, stock at its current selling value and money customers owe you that you expect to receive, subtract supplier bills and other debts due now (where your madhab allows), and pay 2.5% if the total reaches the nisab.[/myzt_answer]
<p>Tap <strong>Business</strong> and <strong>Money owed to you</strong> in the calculator. When you are done, download the PDF report to keep a record of what you entered.</p>
[zakat_calculator]
<h2>What counts and what does not</h2>
<ul>
<li><strong>Counted:</strong> stock and raw materials for sale (at sale value), cash and bank balances of the business, good receivables.</li>
<li><strong>Not counted:</strong> shop, machinery, vehicles and furniture used to run the business.</li>
<li><strong>Doubtful debts:</strong> not counted now; pay zakat on them when they are received.</li>
<li><strong>Supplier bills:</strong> subtracted in Hanafi, Maliki, Hanbali and Ahl-e-Hadith calculations, not in the Shafi'i one.</li>
</ul>
<h2>Keep your records year to year</h2>
<p>Use <em>Save data file</em> to keep your figures on your own device and open them next year. Nothing is stored on our server.</p>
[myzt_faq]
HTML
		. $author . '[myzt_related slugs="madhab-comparison,maliki-zakat-calculator,nisab,zakat-calculator-pakistan"]',
		'faq'   => array(
			array( 'q' => 'Is zakat due on shop equipment?', 'a' => 'No. Fixed assets used to run the business are not zakatable; only stock for sale, cash and receivables are.' ),
			array( 'q' => 'Should stock be valued at cost or sale price?', 'a' => 'Most scholars say at its current market (selling) value on the zakat date.' ),
		),
	);

	$p['fitrana-calculator'] = array(
		'title' => 'Fitrana Calculator (Zakat al-Fitr)',
		'seo'   => 'Fitrana {year} Calculator: Sadqa-e-Fitr per Person',
		'desc'  => 'Calculate fitrana (sadaqat al-fitr) for your family: number of people times the amount for wheat, barley, dates or raisins. Who must pay and when.',
		'nav'   => 'Fitrana',
		'blurb' => 'per person',
		'hub'   => 'calculators',
		'llms'  => true,
		'content' => <<<'HTML'
[myzt_answer q="How much is fitrana?"]Fitrana is paid for every member of the family before the Eid prayer. In Hanafi fiqh it is half a sa' of wheat (about 2 kg) or one sa' of barley, dates or raisins (about 4 kg), or their value. Scholars announce the amount in money each Ramadan.[/myzt_answer]
[zakat_fitrana]
<h2>Who must pay fitrana?</h2>
<p>Every Muslim who has wealth above his basic needs on the morning of Eid pays for himself and for his young children. Many pay for their wife and other dependants as well.</p>
<h2>When to pay</h2>
<p>Before the Eid prayer, so that the poor can celebrate Eid. Paying it during Ramadan is allowed and makes it easier to reach people in need.</p>
<h2>Which item to choose</h2>
<p>You may pay the value of any of the four items. Those who can afford it are encouraged to pay by the more expensive items (dates or raisins), as this gives more to the poor.</p>
<p>Missed fasts you cannot make up, or a fast broken on purpose? Use the <a href="/fidya-kaffara-calculator/">fidya and kaffara calculator</a>.</p>
[myzt_faq]
HTML
		. $author . '[myzt_related slugs="who-can-receive-zakat,zakat-calculator-pakistan,khums-calculator,home"]',
		'faq'   => array(
			array( 'q' => 'Fitrana kis par wajib hai?', 'a' => 'Har us Muslim par jo Eid ki subah apni zaroorat se zyada maal ka malik ho; wo apni aur apne chhote bachon ki taraf se ada karta hai.' ),
			array( 'q' => 'Can fitrana be paid in money?', 'a' => 'Yes, in the Hanafi madhab paying the value in money is allowed and common.' ),
		),
	);

	$p['fidya-kaffara-calculator'] = array(
		'title' => 'Fidya and Kaffara Calculator',
		'seo'   => 'Fidya and Kaffara Calculator {year}: Roza Fidya in Rupees',
		'desc'  => 'Work out fidya for fasts you cannot make up and kaffara for a fast broken on purpose: number of fasts times the daily amount, with the Hanafi rules explained.',
		'nav'   => 'Fidya & Kaffara',
		'blurb' => 'roza fidya',
		'hub'   => 'calculators',
		'llms'  => true,
		'content' => <<<'HTML'
[myzt_answer q="How much is fidya for one fast?"]In the Hanafi madhab the fidya for one missed fast is the same as one fitrana: half a sa' of wheat (about 2 kg) or its value, given to a poor person. Kaffara for a fast broken on purpose is fasting 60 days in a row, or, for someone who cannot, feeding 60 poor people, which is 60 times that amount.[/myzt_answer]
[zakat_fidya]
<h2>Fidya: who pays it</h2>
<p>Fidya is for a person who cannot fast and has no hope of fasting later, such as someone very old or with a long-term illness. They pay one fidya for each fast. Someone who missed fasts because of travel, a short illness, pregnancy or breastfeeding makes the fasts up later (qada) and does not pay fidya instead. If a person who could have made up their fasts dies without doing so, and left a will (wasiyyat), the fidya is paid from up to one third of what they left.</p>
<h2>Kaffara: when it is due</h2>
<p>In Hanafi fiqh kaffara is due when an adult deliberately breaks a Ramadan fast by eating, drinking or marital relations without a valid excuse. The kaffara is to fast 60 days in a row. Only a person who truly cannot do that may feed 60 poor people (two meals each) or give each of them the amount of one fitrana. Several fasts broken in the same Ramadan need one kaffara in the Hanafi view, as long as the first kaffara has not been paid yet. Each broken fast is also made up with one qada fast.</p>
<h2>Other schools</h2>
<p>In the Shafi'i, Maliki and Hanbali schools the fidya and each kaffara meal are one mudd of the local staple food (about 0.6 kg), which is less than the Hanafi half sa'. The Shafi'i and Hanbali schools require kaffara only for breaking the fast with marital relations; eating or drinking deliberately needs qada and repentance. Use the amount your own scholars announce.</p>
<h2>How much in rupees?</h2>
<p>Each Ramadan, the Council of Islamic Ideology and major madrasas announce fitrana and fidya amounts for wheat, barley, dates and raisins. Enter that amount above, or the price of about 2 kg of flour where you live. Pay by the more expensive items if you can afford it.</p>
<p>Read the full guides: <a href="/roza-fidya/">roza fidya: who pays and how much</a> and <a href="/kaffara-for-breaking-a-fast/">kaffara for breaking a fast</a>. Also see the <a href="/fitrana-calculator/">fitrana calculator</a> and <a href="/who-can-receive-zakat/">who can receive zakat</a>; fidya and kaffara go to the same poor and needy people.</p>
[myzt_faq]
HTML
		. $author . '[myzt_related slugs="roza-fidya,kaffara-for-breaking-a-fast,fitrana-calculator,who-can-receive-zakat"]',
		'faq'   => array(
			array( 'q' => 'Roze ka fidya kitna hai?', 'a' => 'Hanafi fiqh mein aik roze ka fidya aik fitrane ke barabar hai: aadha sa\' gandum (taqreeban 2 kg) ya uski qeemat.' ),
			array( 'q' => 'What is the kaffara for breaking a fast?', 'a' => 'Fasting 60 days in a row. Only someone who cannot do that may feed 60 poor people instead.' ),
			array( 'q' => 'Can a young healthy person pay fidya instead of fasting?', 'a' => 'No. Fidya is only for those who can never make up the fasts. Others must make them up.' ),
			array( 'q' => 'Can fidya be given to one person?', 'a' => 'Yes, the fidya for several fasts may be given to one poor person. For kaffara by feeding, Hanafi scholars allow feeding one poor person on 60 days, but not giving one person 60 days\' amount on one day.' ),
		),
	);

	$p['zakat-date-calculator'] = array(
		'title' => 'Zakat Date Calculator and Hawl Tracker',
		'seo'   => 'Zakat Date Calculator: Hawl Tracker, Reminders & Missed Years',
		'desc'  => 'Find your next zakat date from the day your wealth reached the nisab, get calendar reminders, and calculate zakat for years you missed (qaza zakat).',
		'nav'   => 'Zakat date',
		'blurb' => 'hawl, reminders',
		'hub'   => 'calculators',
		'llms'  => true,
		'content' => <<<'HTML'
[myzt_answer q="When is my zakat due?"]Zakat is due one lunar (Islamic) year after the day your wealth first reached the nisab, and on the same Islamic date every year after that. Because the lunar year is about 354 days, the date moves about 11 days earlier each year in the Gregorian calendar. Ramadan is not required; many people choose it only for the extra reward.[/myzt_answer]
[zakat_hawl]
<h2>What is hawl?</h2>
<p>Hawl is the full lunar year that wealth must stay at or above the nisab before zakat becomes due. You do not count each rupee separately: in the Hanafi madhab what matters is that you were above the nisab at the start and at the end of the year, even if your balance went up and down in between. Money added during the year is counted with the rest on the zakat date.</p>
<h2>I don't know the exact date</h2>
<p>If you cannot remember when your wealth first reached the nisab, scholars advise picking a date you can reasonably estimate, such as an Islamic date you will remember (for example 1 Ramadan), and keeping to it every year. Enter that date above.</p>
<h2>Zakat for years you missed</h2>
<p>Zakat that was not paid stays owed; it does not lapse with time. Estimate your zakatable wealth on each missed zakat date and enter it year by year. In the Hanafi view, zakat you owed for an earlier year counts as a debt, so it reduces the wealth for the next year; the tick box does this for you. Pay what you can now and make a plan for the rest.</p>
<h2>Gregorian or lunar year?</h2>
<p>Zakat follows the lunar year. If you keep accounts on a Gregorian (solar) year, some scholars say you should pay 2.577% instead of 2.5% to make up for the extra 11 days. Our main calculator uses 2.5% on a lunar year.</p>
<p>More detail: <a href="/hawl-zakat-due-date/">what hawl is and when zakat becomes due</a>, and <a href="/missed-zakat-past-years/">how to pay zakat for past years</a>.</p>
<p>When the date comes, work out the amount with the <a href="/">zakat calculator</a>. If your bank deducted zakat on 1 Ramadan, enter it under "Already paid".</p>
[myzt_faq]
HTML
		. $author . '[myzt_related slugs="hawl-zakat-due-date,missed-zakat-past-years,home,nisab"]',
		'faq'   => array(
			array( 'q' => 'Does zakat have to be paid in Ramadan?', 'a' => 'No. It is due on your own zakat date. Paying in Ramadan is allowed if it is your date, or as an advance payment.' ),
			array( 'q' => 'Zakat ki tareekh kaise maloom karein?', 'a' => 'Jis din aapka maal pehli dafa nisab ko pohncha, us se aik qamri saal baad. Har saal wahi islami tareekh hoti hai.' ),
			array( 'q' => 'Do I have to pay zakat for past years I missed?', 'a' => 'Yes. Unpaid zakat remains owed. Estimate the wealth for each year and pay it.' ),
		),
	);

	$p['ushr-calculator'] = array(
		'title' => 'Ushr and Livestock Zakat Calculator',
		'seo'   => 'Ushr Calculator: Zakat on Crops (10%, 5%) and Livestock',
		'desc'  => 'Calculate ushr on wheat, rice and other crops (10% rain-fed, 5% irrigated) in maunds, and zakat on goats, sheep, cows, buffaloes and camels.',
		'nav'   => 'Ushr & livestock',
		'blurb' => 'fasal, maweshi',
		'hub'   => 'calculators',
		'llms'  => true,
		'content' => <<<'HTML'
[myzt_answer q="How much is ushr?"]Ushr is 10% of the harvest for land watered by rain or rivers, and 5% (nisf-ushr) for land watered by tube wells, canals you pay for, or other costly irrigation. It is due at harvest, with no waiting year. Imam Abu Hanifa set no minimum quantity; the Shafi'i, Maliki and Hanbali schools require at least 5 wasq (about 653 kg).[/myzt_answer]
[zakat_ushr]
<h2>Which crops?</h2>
<p>In the Hanafi madhab ushr is due on everything the land produces for sale or food: wheat, rice, maize, sugarcane, cotton, vegetables and fruit. The other schools limit it to staple foods that can be stored (wheat, rice, barley, dates, raisins and similar). Firewood, grass and reeds are not included.</p>
<h2>Who pays: owner or tenant?</h2>
<p>When land is given on a crop-share basis (batai), each party pays ushr on their own share. For land rented for cash, Imam Abu Hanifa said the owner pays; his students Abu Yusuf and Muhammad, and most other schools, say the tenant who owns the crop pays. Many Pakistani muftis follow the second view today.</p>
<h2>Zakat on livestock</h2>
<p>Zakat on animals applies to goats, sheep, cows, buffaloes and camels that graze freely for most of the year, are not used for ploughing or transport, and have been owned for a full lunar year. The minimums are 40 goats or sheep, 30 cows or buffaloes, and 5 camels. Dairy animals fed at home on bought fodder are not zakatable as livestock; their milk income becomes part of your cash. Animals bought to sell are trade goods: add their market value in the <a href="/business-zakat-calculator/">business zakat calculator</a>.</p>
<figure class="wp-block-table"><table><thead><tr><th>Goats and sheep</th><th>Give</th></tr></thead><tbody>
<tr><td>40 to 120</td><td>1</td></tr><tr><td>121 to 200</td><td>2</td></tr><tr><td>201 to 399</td><td>3</td></tr><tr><td>400 and above</td><td>1 for every 100</td></tr>
</tbody></table></figure>
<figure class="wp-block-table"><table><thead><tr><th>Cows and buffaloes</th><th>Give</th></tr></thead><tbody>
<tr><td>30 to 39</td><td>1 calf in its 2nd year (tabi')</td></tr><tr><td>40 to 59</td><td>1 cow in its 3rd year (musinnah)</td></tr><tr><td>60 and above</td><td>1 tabi' for every 30, 1 musinnah for every 40</td></tr>
</tbody></table></figure>
<p>Full guides: <a href="/ushr-on-crops/">ushr on wheat, rice, cotton and other crops</a> and <a href="/zakat-on-livestock/">zakat on goats, cows, buffaloes and camels</a>.</p>
<p>Ushr and livestock zakat go to the same people as other zakat; see <a href="/who-can-receive-zakat/">who can receive zakat</a>. For cash, gold and savings use the <a href="/">main calculator</a>.</p>
[myzt_faq]
HTML
		. $author . '[myzt_related slugs="ushr-on-crops,zakat-on-livestock,business-zakat-calculator,who-can-receive-zakat"]',
		'faq'   => array(
			array( 'q' => 'Gandum par kitna ushr hai?', 'a' => 'Barani (baarish wali) zameen par paidawar ka 10%, aur tube well ya khareede paani wali zameen par 5%.' ),
			array( 'q' => 'Are costs deducted before ushr?', 'a' => 'In the classical view, no: ushr is on the whole harvest, which is why irrigated land pays half. Some contemporary scholars allow deducting costs such as fertiliser; ask your scholar.' ),
			array( 'q' => 'Is there zakat on dairy buffaloes?', 'a' => 'Not as livestock if they are mostly fed bought fodder at home. Their income is counted with your cash.' ),
		),
	);

	$p['free-zakat-widget'] = array(
		'title' => 'Free Nisab and Gold Rate Widget for Your Website',
		'seo'   => 'Free Nisab Widget: Live Zakat Nisab & Gold Rate for Websites',
		'desc'  => 'Add a free, live nisab and gold rate box to your mosque, madrasa or blog website. Copy one line of code; it updates every hour in your currency.',
		'nav'   => 'Free widget',
		'blurb' => 'for mosques & blogs',
		'hub'   => 'calculators',
		'content' => <<<'HTML'
<p>Mosques, madrasas, Islamic centres and bloggers can show today's nisab and gold rate on their own website for free. The box below updates every hour from international gold and silver prices, in the currency you choose. No sign-up, no ads, no tracking.</p>
<h2>Preview and code</h2>
[myzt_embed_code currency="PKR"]
<h2>How to add it</h2>
<ol>
<li>Copy the code above.</li>
<li>In WordPress, add a "Custom HTML" block (or a Custom HTML widget in your sidebar) and paste it. On other sites, paste it where you want the box to appear.</li>
<li>Keep the small "Nisab by My Zakat Tool" line: it tells your visitors where the numbers come from.</li>
</ol>
<h2>Good to know</h2>
<ul>
<li>The silver nisab is 52.5 tola (612.36 g) and the gold nisab 7.5 tola (87.48 g). Hanafi scholars use the silver nisab for cash.</li>
<li>Prices are international spot rates; local jewellers' prices are a little higher.</li>
<li>The box is an estimate for guidance, not a fatwa; see our <a href="/disclaimer/">disclaimer</a>.</li>
</ul>
<p>Questions or a different design? <a href="/contact/">Contact us</a>.</p>
HTML
		. $author,
		'faq'   => array(),
	);

	$p['khums-calculator'] = array(
		'title' => 'Khums Calculator',
		'seo'   => 'Khums Calculator: 20% of Yearly Surplus (Sistani)',
		'desc'  => 'Calculate khums on your yearly surplus according to Ayatollah Sistani: savings, unused items and trade stock bought from income. Sahm-e-Imam and Sahm-e-Sadat.',
		'nav'   => 'Khums',
		'blurb' => 'Shia, 20%',
		'hub'   => 'calculators',
		'llms'  => true,
		'content' => <<<'HTML'
[myzt_answer q="What is khums?"]Khums is one fifth (20%) of what is left from a year's income after the year's living expenses. Half is Sahm-e-Imam and half is Sahm-e-Sadat. It is paid on your khums date each year.[/myzt_answer]
[zakat_khums]
<h2>What to include</h2>
<ul>
<li>Cash and bank savings that came from this year's income.</li>
<li>Food and other items bought from income that remain unused at the khums date.</li>
<li>Trade stock bought from income.</li>
</ul>
<h2>What not to include</h2>
<ul>
<li>Money on which khums was already paid.</li>
<li>Inheritance and mahr (in Ayatollah Sistani's view these are not subject to khums, with some exceptions). Gifts are different: he treats them as income, so khums is due on what is left of a gift at your khums date.</li>
<li>Your house, car and items you use, bought within the year for your needs.</li>
</ul>
<p>Rules differ between maraji'. Please confirm details with your marja's office. For a fuller explanation, read <a href="/khums-who-must-pay/">who must pay khums, and sahm-e-imam and sahm-e-sadat</a>.</p>
[myzt_faq]
HTML
		. $author . '[myzt_related slugs="khums-who-must-pay,shia-zakat-calculator,madhab-comparison,fitrana-calculator"]',
		'faq'   => array(
			array( 'q' => 'Is khums 20% of total savings?', 'a' => 'It is 20% of the surplus of the year from income, after the year\'s expenses, on which khums has not been paid.' ),
		),
	);

	$p['nisab'] = array(
		'title' => 'Nisab Today: Gold and Silver Nisab for Zakat',
		'seo'   => 'Nisab for Zakat Today ({year}): Gold & Silver Value',
		'desc'  => 'Today\'s zakat nisab in your currency: silver 612.36 g (52.5 tola) and gold 87.48 g (7.5 tola), from live international rates. Which nisab to use by madhab.',
		'nav'   => 'Nisab Today',
		'blurb' => 'in your currency',
		'llms'  => true,
		'content' => <<<'HTML'
[myzt_answer q="What is the nisab today?"]The silver nisab (612.36 g) is about [myzt_rate type="nisab-silver" currency="PKR"] and the gold nisab (87.48 g) is about [myzt_rate type="nisab-gold" currency="PKR"] today. Choose your currency below.[/myzt_answer]
[zakat_nisab]
[myzt_reviewed rates="1"]
<p>Run a mosque or blog website? Show this nisab on it with our <a href="/free-zakat-widget/">free nisab widget</a>.</p>
<h2>Which nisab applies to you?</h2>
<ul>
<li><strong>Only gold:</strong> the gold nisab, 87.48 g (7.5 tola) of pure gold.</li>
<li><strong>Only silver:</strong> the silver nisab, 612.36 g (52.5 tola).</li>
<li><strong>Cash or a mix:</strong> Hanafi scholars use the silver nisab; Hanbali and Ahl-e-Hadith use whichever is lower (silver today); Shafi'i authorities in Malaysia and Singapore use gold.</li>
<li><strong>Shia (Sistani):</strong> 69.12 g of gold or 483.84 g of silver in coins used as currency.</li>
</ul>
<p>Rates are international spot prices refreshed every hour and converted to your currency. Local market prices may differ slightly.</p>
[myzt_faq]
HTML
		. $author . '[myzt_related slugs="gold-rate-today,home,zakat-on-gold-calculator,madhab-comparison"]',
		'faq'   => array(
			array( 'q' => 'Nisab kitna hai?', 'a' => 'Chandi ka nisab 52.5 tola (612.36 gram) aur sone ka 7.5 tola (87.48 gram). Upar aaj ki qeemat aap ki currency mein di gayi hai.' ),
			array( 'q' => 'Why is the silver nisab so much lower than gold?', 'a' => 'Both weights were fixed in the time of the Prophet ﷺ when they had similar value. Silver has become much cheaper relative to gold, so the silver nisab is now far lower.' ),
		),
	);

	$p['gold-rate-today'] = array(
		'title' => 'Gold Rate Today per Tola and Gram',
		'seo'   => 'Gold Rate Today per Tola & Gram (24K, 22K, 21K) | Silver',
		'desc'  => 'Today\'s gold rate per tola, gram and ounce for 24K, 22K, 21K and 18K, plus silver, in PKR, INR, GBP, USD, AED, SAR and 45 more currencies. Updated hourly.',
		'nav'   => 'Gold Rate Today',
		'blurb' => '24K, 22K, 21K',
		'llms'  => true,
		'content' => <<<'HTML'
[myzt_answer q="Gold rate today:"]1 tola of 24K gold is about [myzt_rate type="gold-tola" currency="PKR"] and 1 gram about [myzt_rate type="gold-gram" currency="PKR"] at the international rate. Silver is about [myzt_rate type="silver-tola" currency="PKR"] per tola.[/myzt_answer]
[zakat_gold_rate]
[myzt_reviewed rates="1"]
<h2>About these rates</h2>
<p>These are international spot prices, refreshed every hour and converted with daily exchange rates. Jewellers' prices include making charges and local premiums, so the price you pay in a shop is higher. For zakat, the value of the pure gold is what counts.</p>
<p>1 tola = 11.664 g · 1 troy ounce = 31.103 g · 22K gold is 91.7% pure, 21K is 87.5%, 18K is 75%.</p>
<p>Use these rates directly in the <a href="/zakat-on-gold-calculator/">zakat on gold calculator</a>.</p>
[myzt_faq]
HTML
		. $author . '[myzt_related slugs="zakat-on-gold-calculator,nisab,home,zakat-calculator-pakistan"]',
		'faq'   => array(
			array( 'q' => 'How many grams is 1 tola?', 'a' => '1 tola is 11.664 grams.' ),
			array( 'q' => 'Why is the shop price different?', 'a' => 'Shops add making charges, taxes and local premiums to the international price.' ),
		),
	);

	/* ------------------------------------------------------------------ */
	$p['guides'] = array(
		'title' => 'Zakat Guides',
		'seo'   => 'Zakat Guides: Gold, Jewellery, Bank Deduction, Who to Pay',
		'desc'  => 'Short, sourced answers to common zakat questions: zakat on 1 tola gold, 1 lakh rupees, jewellery in the 4 madhabs, bank deduction in Pakistan and who can receive zakat.',
		'nav'   => 'Guides',
		'blurb' => 'answers',
		'llms'  => true,
		'content' => '<p>Clear answers to the zakat questions people ask most, each with its source and a link to the calculator so you can check your own numbers. Rulings differ between the schools, so every guide says which madhab a statement belongs to.</p><h2>All guides</h2>[myzt_guides]<h2>Start here</h2><p>New to zakat? Read <a href="/nisab/">what the nisab is</a>, then <a href="/who-can-receive-zakat/">who can receive zakat</a>, and use the <a href="/">calculator</a>. For the differences between schools see the <a href="/madhab-comparison/">madhab comparison</a>, and for rates see <a href="/gold-rate-today/">gold rate today</a>.</p>' . $author,
		'faq'   => array(),
	);

	/* ------------------------------------------------------------------ */
	$p['about'] = array(
		'title' => 'About My Zakat Tool',
		'seo'   => 'About My Zakat Tool: Who Made It and Why',
		'desc'  => 'My Zakat Tool is a free zakat calculator for every madhab, made by Ali Ahmad. Why it exists, how it is funded and how to contact us.',
		'nav'   => 'About',
		'blurb' => 'who we are',
		'content' => <<<'HTML'
<p>My Zakat Tool is a free website that helps Muslims calculate zakat according to their own school of thought, with today's gold and silver rate built in.</p>
<h2>Why we built it</h2>
<p>Most zakat calculators follow one view only and ask you to look up the gold rate yourself. Many Muslims follow a different madhab, and the answer can change a lot, especially for jewellery and debts. We wanted one calculator that shows every school's answer with its source, in plain language, in English and Urdu.</p>
<h2>Who is behind it</h2>
<p>The site is made and maintained by <strong>Ali Ahmad</strong> (<a href="https://www.linkedin.com/in/ali-ahmad-chaudhry-12777486/" rel="noopener" target="_blank">LinkedIn</a>). The rules are taken from published fatwas and classical texts listed on our <a href="/methodology/">methodology</a> page. We are not a fatwa-issuing body.</p>
<h2>How the site is funded</h2>
<p>The site is free. It may show a small number of clearly marked advertisements. We do not collect zakat or donations, and we never see the numbers you enter.</p>
<h2>Contact</h2>
<p>Found an error or have a suggestion? Email <a href="mailto:contact@myzakattool.com">contact@myzakattool.com</a>.</p>
HTML,
		'faq'   => array(),
	);

	$p['methodology'] = array(
		'title' => 'How We Calculate Zakat (Methodology and Sources)',
		'seo'   => 'How We Calculate Zakat: Methodology, Sources & Rates',
		'desc'  => 'The rules and sources behind My Zakat Tool for each madhab, the nisab weights, how gold and silver rates are fetched and converted, and what the calculator does not cover.',
		'nav'   => 'Methodology',
		'blurb' => 'sources',
		'llms'  => true,
		'content' => <<<'HTML'
<p>This page explains every rule the calculator uses and where it comes from. If you think something is wrong, please <a href="mailto:contact@myzakattool.com">tell us</a>.</p>
[myzt_reviewed]
<h2>Common to all Sunni schools</h2>
<ul>
<li>Rate: 2.5% of zakatable wealth after a lunar year (hawl).</li>
<li>Gold nisab 87.48 g (7.5 tola); silver nisab 612.36 g (52.5 tola).</li>
<li>Gold is counted by its pure content: weight × karat ÷ 24.</li>
<li>Cash, bank balances, committee payments, prize bonds, shares and crypto at market value, business stock at sale value, good receivables and plots bought for resale are counted.</li>
<li>Doubtful receivables are not counted until received.</li>
</ul>
<h2 id="hanafi">Hanafi</h2>
<p>Jewellery zakatable even if worn daily; debts due now deducted; gold, silver and cash combined by value against the silver nisab; only gold → gold nisab. Sources: Darul Uloom Deoband, Fatwa 2310/H=713/th=1431 (jewellery) and Fatwa 702/702=M/1429 (combining, silver nisab).</p>
<h2 id="shafii">Shafi'i</h2>
<p>Permissible worn jewellery exempt unless beyond custom (about 860 g); debts not deducted; gold and silver separate; cash valued on the gold standard by default (user may choose silver). Sources: Imam al-Nawawi, <em>al-Majmu'</em>; MUIS Office of the Mufti, "Zakat on Gold Jewellery"; SeekersGuidance, "Which debts affect zakat" (Shaykh Dr. Muhammad Fayez Awad).</p>
<h2 id="maliki">Maliki</h2>
<p>Permissible worn jewellery exempt; debts deducted from cash, gold, silver and trade goods; gold and silver combined; silver nisab by default (user may choose gold). Sources: Mufti of Wilayah Persekutuan, Irsyad Fatwa 38; SeekersGuidance (debts by madhab).</p>
<h2 id="hanbali">Hanbali</h2>
<p>Permissible jewellery kept for use or lending exempt; debts deducted; gold and silver combined; cash and trade goods measured by the nisab better for the poor. Source: <em>Akhsar al-Mukhtasarat</em>, Book of Zakat.</p>
<h2 id="ahlehadith">Ahl-e-Hadith</h2>
<p>Jewellery zakatable if it reaches the nisab; cash combined with gold and silver; lower nisab; debts deducted. Sources: Permanent Committee (al-Lajnah ad-Da'imah) and Shaykh Ibn Uthaymeen via IslamQA answers 19901 and 201807. We have not found a written fatwa from a Pakistani Ahl-e-Hadith institution on every point; this is our best reading.</p>
<h2 id="jafari">Shia (Ja'fari)</h2>
<p>Following Ayatollah Sistani, <em>Islamic Laws</em>, rulings 1912-1916: zakat on gold and silver only for coins used as currency (gold 69.12 g, silver 483.84 g); paper money and jewellery not zakatable today; khums applies to the yearly surplus.</p>
<h2>Gold, silver and currency rates</h2>
<p>Gold and silver spot prices in US dollars per troy ounce come from gold-api.com, with a daily fallback from the open currency-api by Fawaz Ahmed. Exchange rates come from the same currency-api. Our server refreshes them every hour and caches them; your browser never contacts these services. All values are international rates; you can enter your own local rate.</p>
<h2>What the calculator does not cover</h2>
<ul><li>Livestock and crops (ushr)</li><li>Exact hawl dates (we assume the year is complete)</li><li>Pension and provident funds, where scholars differ</li></ul>
<h2>Review</h2>
<p>The rules are compiled from the sources above by the site author. They have not yet been reviewed by a scholar on our behalf; when that happens, the reviewer's name will be shown on every page.</p>
HTML
		. $author,
		'faq'   => array(),
	);

	$p['contact'] = array(
		'title' => 'Contact',
		'seo'   => 'Contact My Zakat Tool',
		'desc'  => 'Contact My Zakat Tool to report an error in a rule or calculation, suggest a feature or ask about the site. Email contact@myzakattool.com.',
		'nav'   => 'Contact',
		'blurb' => 'email us',
		'content' => <<<'HTML'
<p>We read every message. The fastest way to reach us is email:</p>
<p><strong><a href="mailto:contact@myzakattool.com">contact@myzakattool.com</a></strong></p>
<h2>Reporting an error</h2>
<p>Please tell us the page, the madhab you selected and what you expected. You can also use the <em>Report an error</em> button under any result. Do not send personal financial details.</p>
<h2>Religious questions</h2>
<p>We do not issue fatwas. For a ruling about your own situation, please ask a qualified scholar of your school.</p>
HTML,
		'faq'   => array(),
	);

	$p['disclaimer'] = array(
		'title' => 'Disclaimer',
		'seo'   => 'Disclaimer: Not a Fatwa | My Zakat Tool',
		'desc'  => 'My Zakat Tool gives estimates for guidance only. It is not a fatwa, not financial or legal advice, and its PDF reports are not official documents.',
		'nav'   => 'Disclaimer',
		'blurb' => 'not a fatwa',
		'content' => <<<'HTML'
<p><strong>Short version:</strong> This calculator gives an estimate for guidance only. It is not a fatwa or religious ruling. Results may contain errors. Please confirm your zakat with a qualified scholar of your school of thought before paying.</p>
<p dir="rtl" lang="ur">یہ کیلکولیٹر صرف رہنمائی کے لیے اندازہ دیتا ہے۔ یہ کوئی فتویٰ یا شرعی حکم نہیں ہے، اور اس میں غلطی کا امکان ہو سکتا ہے۔ زکوٰۃ ادا کرنے سے پہلے اپنے مسلک کے مستند عالم سے ضرور تصدیق کر لیں۔</p>
<h2>1. Not a fatwa</h2>
<p>My Zakat Tool is an educational calculator. Nothing on this website, including calculator results, comparison tables, articles or references, is a fatwa, religious verdict or personal religious advice. We do not issue fatwas.</p>
<h2>2. Different schools of thought</h2>
<p>The calculator presents rulings of different schools of thought as we understand them from the published sources cited on our <a href="/methodology/">methodology</a> page. Scholars within the same school can differ. Your own scholar's ruling takes priority over this website.</p>
<h2>3. Possible errors</h2>
<p>We try to keep rules and calculations accurate, but errors, omissions or outdated information are possible. Results depend entirely on the information you enter.</p>
<h2>4. Gold and silver prices</h2>
<p>Prices come from third-party sources, are international spot rates converted to your currency, and may be delayed, unavailable or different from your local market price. We do not guarantee any price.</p>
<h2>5. Your responsibility</h2>
<p>Paying zakat correctly is your own religious responsibility. You use this website at your own risk.</p>
<h2>6. No liability</h2>
<p>To the fullest extent permitted by law, the owners and operators of this website are not liable for any religious, financial or other loss or consequence arising from use of, or reliance on, this website or its results.</p>
<h2>7. Not financial, tax or legal advice</h2>
<p>Nothing here is financial, tax, investment or legal advice. Government zakat deductions (for example bank deductions in Pakistan) follow their own laws.</p>
<h2 id="pdf-report">8. The PDF report is not an official document</h2>
<p>The PDF report is generated automatically in your browser from figures you entered yourself. It cannot be used as evidence, proof or a supporting document before any government department, bank, tax authority (including FBR), Zakat &amp; Ushr department, court or any other institution in Pakistan or elsewhere, because:</p>
<ol>
<li><strong>Figures are self-entered and unverified.</strong> We do not check whether you own these assets or whether the amounts are correct.</li>
<li><strong>No issuing authority.</strong> It is not issued, approved or registered by any government body, bank or religious institution, and carries no signature, stamp or reference number.</li>
<li><strong>Not a fatwa.</strong> The rules are summaries of published opinions of each school, not a ruling for your case.</li>
<li><strong>Prices are approximate.</strong> Rates are international rates at the time of generation.</li>
<li><strong>It can be edited.</strong> Anyone can create or change such a PDF, so it has no evidential value.</li>
<li><strong>Not for zakat exemption.</strong> It is not a substitute for the CZ-50 declaration or any legal form required for exemption from compulsory bank zakat deduction in Pakistan.</li>
</ol>
<p>Use the report only to keep your own record and to discuss with a qualified scholar.</p>
<p dir="rtl" lang="ur">یہ رپورٹ سرکاری دستاویز نہیں۔ یہ آپ کے خود درج کیے گئے اعداد سے بنی ہے، اس کی تصدیق نہیں ہوئی، اسے کسی ادارے نے جاری نہیں کیا اور اس پر کوئی دستخط، مہر یا نمبر نہیں۔ اسے کسی سرکاری ادارے، بینک، FBR، زکوٰۃ و عشر محکمے یا عدالت میں ثبوت کے طور پر استعمال نہیں کیا جا سکتا، اور یہ CZ-50 کا متبادل نہیں۔</p>
<h2>9. Corrections</h2>
<p>If you believe a rule or reference is wrong, please <a href="/contact/">contact us</a>. We review reports and correct errors.</p>
<h2>10. Changes</h2>
<p>We may update this disclaimer at any time. Continued use of the site means you accept the current version.</p>
HTML,
		'faq'   => array(),
	);

	$p['privacy-policy'] = array(
		'title' => 'Privacy Policy',
		'seo'   => 'Privacy Policy | My Zakat Tool',
		'desc'  => 'What My Zakat Tool collects (very little), why calculator entries never leave your device, and how cookies, analytics and advertising work on this site.',
		'nav'   => 'Privacy',
		'blurb' => 'your data',
		'content' => <<<'HTML'
<p>Last updated: [myzt_year]. This policy explains what information this website handles.</p>
<h2>Calculator entries stay on your device</h2>
<p>Everything you type into the calculators is processed in your own browser. It is not sent to our server. If you use <em>Save data file</em>, the file is saved on your device. A draft may be kept in your browser's local storage so your entries are still there when you return; you can remove it with <em>Clear all</em>.</p>
<h2>PDF reports</h2>
<p>PDF reports are created in your browser and downloaded directly. We never receive them.</p>
<h2>Server logs</h2>
<p>Like every website, our hosting provider records technical logs (IP address, browser, pages requested, time) for security and to keep the site running. These are kept for a limited time.</p>
<h2>Cookies, analytics and advertising</h2>
<p>We may use privacy-friendly analytics to count visits. If advertising is enabled, Google may use cookies to show ads, including personalised ads where you have agreed. You can manage Google ad personalisation at <a href="https://adssettings.google.com" rel="noopener nofollow" target="_blank">adssettings.google.com</a>. Visitors in the EEA and UK are asked for consent before such cookies are used.</p>
<h2>Email</h2>
<p>If you email us, we use your email only to reply.</p>
<h2>Children</h2>
<p>This site is not directed at children and does not knowingly collect their data.</p>
<h2>Contact</h2>
<p><a href="mailto:contact@myzakattool.com">contact@myzakattool.com</a></p>
HTML,
		'faq'   => array(),
		'privacy' => true,
	);

	$p['terms'] = array(
		'title' => 'Terms of Use',
		'seo'   => 'Terms of Use | My Zakat Tool',
		'desc'  => 'Terms for using My Zakat Tool: free educational use, no fatwa, no liability, content ownership and governing law.',
		'nav'   => 'Terms',
		'blurb' => 'rules of use',
		'content' => <<<'HTML'
<p>By using this website you agree to these terms.</p>
<h2>Use of the site</h2>
<p>The calculators and articles are free for personal, educational use. Do not misuse the site, attempt to break its security, or scrape it at a rate that harms its operation.</p>
<h2>No fatwa and no advice</h2>
<p>Results are estimates and not a fatwa, financial, tax or legal advice. See the <a href="/disclaimer/">disclaimer</a>.</p>
<h2>Limitation of liability</h2>
<p>The site is provided "as is" without warranties of any kind. To the fullest extent permitted by law, we are not liable for any loss arising from its use.</p>
<h2>Content</h2>
<p>Text, design and code on this site belong to My Zakat Tool unless stated otherwise. You may quote short parts with a link to the source page.</p>
<h2>Links</h2>
<p>We link to fatwas and other sites as sources. We are not responsible for their content.</p>
<h2>Governing law</h2>
<p>These terms are governed by the laws of Pakistan.</p>
<h2>Contact</h2>
<p><a href="mailto:contact@myzakattool.com">contact@myzakattool.com</a></p>
HTML,
		'faq'   => array(),
	);

	return $p;
}

/** Guide articles, created as posts in the "Guides" category. */
require_once __DIR__ . '/content-posts.php';
