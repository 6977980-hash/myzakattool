<?php
/**
 * Page definitions: slug => title, SEO title, meta description, content, FAQ.
 * {year}, {cyear}, {fyear} and {rate:TYPE} in titles and descriptions are filled at runtime (MYZT_SEO::fill).
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
		'desc'  => "Free zakat calculator for Hanafi, Shafi'i, Maliki, Hanbali, Ahl-e-Hadith and Shia with today's gold and silver rate in your currency. Tola or gram, sourced.",
		'nav'   => 'Zakat Calculator',
		'blurb' => 'every madhab',
		'llms'  => true,
		'content' => <<<'HTML'
<p>Calculate your zakat in seconds with today's gold and silver rate built in. Choose your madhab (Hanafi, Shafi'i, Maliki, Hanbali, Ahl-e-Hadith or Shia Ja'fari) and see exactly how it is worked out, with the sources behind each madhab's main rules.</p>
[myzt_trust]
[zakat_calculator compare="open"]
[myzt_answer q="How much is zakat?"]Zakat is 2.5% (one fortieth) of your zakatable wealth once it has been at or above the nisab for one lunar year (Hanafi scholars look at the start and end of the year; the Shafi'i and Hanbali schools require it throughout). The nisab is the value of 87.48 g of gold or 612.35 g of silver; today that is about [myzt_rate type="nisab-silver" currency="PKR"] (silver) or [myzt_rate type="nisab-gold" currency="PKR"] (gold).[/myzt_answer]
<h2>What is the zakat percentage?</h2>
<p><strong>Zakat is 2.5% (one fortieth, 1/40) of your zakatable wealth.</strong> Divide the total by 40, or multiply it by 0.025: Rs 1,00,000 gives Rs 2,500 and Rs 10,00,000 gives Rs 25,000 (see <a href="/zakat-on-1-lakh-rupees/">zakat on 1 lakh rupees</a>). The rate is the same in every madhab. Only crops (ushr, 10% or 5%) and grazing animals have different rates.</p>
<h2>How to calculate zakat, step by step</h2>
<ol>
<li><strong>Add up what you own:</strong> cash at home, bank balances, gold and silver, business stock, shares, crypto, committee (BC) payments and money others owe you.</li>
<li><strong>Subtract debts</strong> that are due now, if your madhab allows it (Hanafi, Maliki and Hanbali scholars do; the relied-upon Shafi'i view and the Permanent Committee followed by Ahl-e-Hadith scholars do not).</li>
<li><strong>Compare with the nisab.</strong> Hanafi scholars use the silver nisab for cash and mixed wealth; Hanbali and Ahl-e-Hadith use whichever is lower; Shafi'i scholars in Malaysia and Singapore usually use gold.</li>
<li><strong>Pay 2.5%</strong> of the total if it reaches the nisab and a lunar year (hawl) has passed.</li>
</ol>
<h2>Why the result changes from one madhab to another</h2>
<p>The biggest difference is <strong>jewellery that is worn</strong>. In the Hanafi madhab zakat is due on it (Darul Uloom Deoband, Fatwa 2310/H=713/th=1431). In the Shafi'i, Maliki and Hanbali madhabs permissible worn jewellery is exempt. Debts and the choice of gold or silver nisab also change the answer. Press <em>Compare all madhabs</em> above to see your own numbers side by side, or read the <a href="/madhab-comparison/">full comparison</a>.</p>
<h2>Worked example</h2>
<p>Ahmed has Rs 5,00,000 cash, Rs 15,00,000 in the bank, 3 tola of 22K gold jewellery that he owns and his wife wears, and Rs 2,00,000 of debt due now.</p>
<ul>
<li><strong>Hanafi:</strong> the jewellery is counted and the debt is subtracted, so zakat is 2.5% of Rs 18,00,000 (Rs 45,000) plus 2.5% of the value of the gold.</li>
<li><strong>Ahl-e-Hadith:</strong> the jewellery is counted and the debt is not subtracted, so zakat is 2.5% of Rs 20,00,000 (Rs 50,000) plus 2.5% of the value of the gold.</li>
<li><strong>Maliki and Hanbali:</strong> worn jewellery is not counted and the debt is subtracted, so zakat is 2.5% of Rs 18,00,000 = Rs 45,000.</li>
<li><strong>Shafi'i:</strong> the jewellery is exempt and the debt is not subtracted, so Rs 20,00,000 is compared with the gold nisab (about [myzt_rate type="nisab-gold" currency="PKR"] today). If it is below that, nothing is due unless he chooses the silver nisab, which would make it Rs 50,000.</li>
<li><strong>Shia (Sistani):</strong> no zakat on paper money or jewellery; khums applies instead.</li>
</ul>
<p>The calculator above does these steps for you with today's rate. In Pakistan, the <a href="/zakat-calculator-pakistan/">Pakistan zakat calculator</a> adds tola, rupees, committee, prize bonds and the bank's 1 Ramadan deduction. Not sure when your zakat is due? The <a href="/zakat-date-calculator/">zakat date calculator</a> finds your date and sets reminders. Getting ready for Ramadan 2027 in Pakistan? <a href="/zakat-2027-pakistan/">Zakat 2027 Pakistan</a> collects the nisab, bank deduction, CZ-50 and fitrana dates, and is updated on announcement day.</p>
<h2>More tools</h2>
<p>The same live silver rate powers the <a href="/haq-mehr-calculator/">haq mehr calculator</a> (Mehr-e-Fatimi in today's money) and the <a href="/diyat-calculator/">diyat calculator</a> for Pakistan. To divide an estate among the heirs, the <a href="/wirasat-calculator/">wirasat (inheritance) calculator</a> works out every share by madhab, shows all six madhabs side by side and draws the family tree; once your share arrives, <a href="/zakat-on-inherited-wealth/">zakat on inherited wealth</a> explains what is due on it. See <a href="/calculators/">all calculators</a>, including fitrana, fidya, ushr and khums.</p>
<h2>Is my data safe?</h2>
<p>Yes. Everything is calculated inside your browser. Nothing you type is sent to our server or saved by us. You can download a PDF report or a data file for your own records.</p>
[myzt_faq]
HTML
		. $author . '[myzt_related slugs="zakat-calculator-pakistan,hanafi-zakat-calculator,zakat-on-gold-calculator,nisab"]',
		'faq'   => array(
			array( 'q' => 'What percentage is zakat?', 'a' => 'Zakat is 2.5%, one fortieth (1/40), of zakatable wealth held at or above the nisab for a lunar year. Crops (ushr) and livestock have their own rates: 10% or 5% of the harvest, and a set number of animals.' ),
			array( 'q' => 'Is zakat due on gold jewellery that is worn?', 'a' => "In the Hanafi madhab and according to the Saudi Permanent Committee (which our Ahl-e-Hadith calculator follows), yes. In the Shafi'i, Maliki and Hanbali madhabs, permissible jewellery that is worn is exempt." ),
			array( 'q' => 'Which nisab should I use, gold or silver?', 'a' => 'Hanafi scholars such as Darul Uloom Deoband use the silver nisab for cash and mixed assets because it is better for the poor. If you own only gold, the gold nisab of 87.48 g (7.5 tola) applies.' ),
			array( 'q' => 'Kya bank ki 1 Ramazan wali katauti ke baad dobara zakat deni hogi?', 'a' => 'Apni poori zakat calculate karen aur jo raqam bank pehle kaat chuka hai use minus kar len. Calculator mein "Already paid" par tap kar ke bank ki katauti likhen, baqi raqam khud nikal aayegi. Tafseel ke liye apne aalim se poochen.' ),
			array( 'q' => 'Does this calculator give a fatwa?', 'a' => 'No. It gives an estimate based on published rulings of each school, with sources. Please confirm with a qualified scholar.' ),
		),
	);

	/* ------------------------------------------------------------------ */
	$p['madhab'] = array(
		'title' => 'Zakat Calculator by Madhab',
		'seo'   => 'Zakat Calculator by Madhab: Hanafi, Shafi\'i, Shia & More',
		'desc'  => 'Pick your school of thought and calculate zakat by its rules: Hanafi, Shafi\'i, Maliki, Hanbali, Ahl-e-Hadith or Shia Ja\'fari, each with cited sources.',
		'nav'   => 'By Madhab',
		'blurb' => 'all schools',
		'llms'  => true,
		'content' => <<<'HTML'
[myzt_answer q="Does zakat differ by madhab?"]The rate is the same, 2.5% of wealth above the nisab for a lunar year, in every madhab. The schools differ on four points: whether worn jewellery is zakatable, whether debts are subtracted, which nisab (gold or silver) applies to cash, and whether gold and silver are added together. Shia Ja'fari fiqh puts zakat on nine items only and takes khums on savings.[/myzt_answer]
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
<p>The four questions that change the amount are: is worn jewellery zakatable, do debts reduce zakat, which nisab (gold or silver) applies to cash, and are gold and silver added together. For a family with a lot of jewellery, the Hanafi and Ahl-e-Hadith results are usually the highest; for someone with large debts, the Shafi'i and Ahl-e-Hadith results can be higher because debts are not subtracted. Each calculator page lists its source fatwas, and our <a href="/methodology/">methodology</a> explains how we read them.</p>
<h2>The four differences at a glance</h2>
<ul>
<li><strong>Worn jewellery:</strong> zakatable for Hanafi and Ahl-e-Hadith; exempt for Shafi'i, Maliki and Hanbali if permissible and worn; not zakatable in Ja'fari fiqh. Details in <a href="/zakat-on-jewellery/">zakat on jewellery</a>.</li>
<li><strong>Debts:</strong> subtracted in the Hanafi, Maliki and Hanbali calculations; not subtracted in the Shafi'i and Ahl-e-Hadith ones.</li>
<li><strong>Nisab for cash:</strong> silver for Hanafi; the lower of the two (silver today) for Hanbali and Ahl-e-Hadith; gold in Shafi'i practice in Malaysia and Singapore; see <a href="/nisab/">nisab today</a>.</li>
<li><strong>Gold with silver:</strong> added together by value in every Sunni school except the Shafi'i, which checks each against its own nisab.</li>
</ul>
<p>Whichever school you follow, the calculator gives an estimate. It is not a fatwa; see the <a href="/disclaimer/">disclaimer</a>.</p>
[myzt_faq]
HTML
		. $author . '[myzt_related slugs="madhab-comparison,hanafi-zakat-calculator,shia-zakat-calculator,zakat-on-jewellery"]',
		'faq'   => array(
			array( 'q' => 'Which madhab is followed in Pakistan?', 'a' => 'Most Sunni Muslims in Pakistan follow the Hanafi madhab (Deobandi and Barelvi). There are also large Ahl-e-Hadith and Shia (Ja\'fari) communities.' ),
			array( 'q' => 'Can I choose the madhab that gives less zakat?', 'a' => 'Scholars advise following the school you already follow, not choosing rulings for convenience. If unsure, ask a scholar.' ),
			array( 'q' => 'Main kaunsa maslak chunoon?', 'a' => 'Jis maslak par aap namaz aur roza mein amal karte hain, wahi chunain. Deobandi aur Barelvi dono Hanafi hain.' ),
			array( 'q' => 'Kya har maslak mein zakat 2.5% hai?', 'a' => 'Haan. Farq sirf is mein hai ke zevar, qarz aur nisab ko kaise gina jaye. Fiqh-e-Jafaria mein naqdi par zakat ke bajaye khums hai.' ),
			array( 'q' => 'Deobandi aur Barelvi ki zakat mein farq hai?', 'a' => 'Dono Hanafi fiqh par hain. Zevar, qarz aur nisab ke masail mein hamein un mein koi farq maloom nahi, is liye dono Hanafi zakat calculator istemal karen.' ),
			array( 'q' => 'Ahl-e-Hadith ke liye kaunsa calculator hai?', 'a' => 'Ahl-e-Hadith zakat calculator, jo Saudi Permanent Committee ke fatwon par chalta hai: pehne hue zevar par zakat, qarz minus nahi, aur naqdi ke liye dono nisab mein se kam wala.' ),
		),
	);

	$madhab_pages = array(
		'hanafi-zakat-calculator' => array(
			'key'   => 'hanafi',
			'question' => "How is zakat calculated in the Hanafi madhab?",
			'title' => 'Hanafi Zakat Calculator',
			'seo'   => 'Hanafi Zakat Calculator {year} (Deobandi & Barelvi)',
			'desc'  => 'Calculate zakat by Hanafi fiqh: jewellery included, debts deducted, silver nisab. Live gold and silver rate in tola or gram, with Darul Uloom Deoband fatwas.',
			'nav'   => 'Hanafi',
			'blurb' => 'Deobandi & Barelvi',
			'intro' => '<p>This calculator follows the Hanafi madhab, the school followed by most Muslims in Pakistan, India, Bangladesh, Afghanistan and Turkey. The rules below are taken from Darul Uloom Deoband fatwas; Barelvi scholars follow the same Hanafi fiqh.</p>',
			'answer' => 'In Hanafi fiqh zakat is 2.5% of all cash, gold, silver and trade goods after subtracting debts due now, if the total reaches the silver nisab of 612.35 g (52.5 tola). Gold jewellery is counted even if it is worn daily.',
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
<p>Both follow Hanafi fiqh, and we know of no difference between them on the rules this calculator uses (jewellery, debts and nisab). Our citations are Deobandi fatwas; we have not yet matched each rule to a page in a Barelvi reference such as <em>Bahar-e-Shariat</em> (Part 5, zakat). If your mufti says otherwise, follow your mufti.</p>
<h2>Bank deduction in Pakistan</h2>
<p>Banks deduct zakat from savings accounts on 1 Ramadan under Pakistan's zakat law. Calculate your full zakat here and subtract what the bank already deducted. See our <a href="/bank-zakat-deduction-pakistan/">bank deduction guide</a>.</p>
<p>This page is for Hanafi followers anywhere in the world, in any currency and in grams or tola. If you live in Pakistan, the <a href="/zakat-calculator-pakistan/">Pakistan zakat calculator</a> uses the same Hanafi rules and adds fields for committees, prize bonds, savings certificates and plots.</p>
<h2>Hanafi rules and their sources</h2>
<figure class="wp-block-table"><table><thead><tr><th>Question</th><th>Hanafi ruling</th><th>Source</th></tr></thead><tbody>
<tr><td>Worn gold and silver jewellery</td><td>Zakatable, even if worn every day</td><td>Darul Uloom Deoband; the hadith of the two bracelets (Abu Dawud 1563)</td></tr>
<tr><td>Nisab for cash and mixed wealth</td><td>Silver: 612.35 g (52.5 tola)</td><td>Darul Uloom Deoband; the 200 dirham nisab (Abu Dawud 1573)</td></tr>
<tr><td>Only gold</td><td>Gold nisab: 87.48 g (7.5 tola)</td><td>The 20 dinar nisab in the same hadith</td></tr>
<tr><td>Gold and silver together</td><td>Added by value</td><td><em>al-Hidayah</em>, Book of Zakat</td></tr>
<tr><td>Debts due now</td><td>Subtracted before the nisab is checked</td><td>SeekersGuidance (debts by madhab)</td></tr>
<tr><td>The lunar year (hawl)</td><td>Above the nisab at the start and end of the year; dips in between do not matter</td><td><em>al-Hidayah</em>; see the <a href="/hawl-zakat-due-date/">hawl guide</a></td></tr>
<tr><td>Children and the insane</td><td>No zakat on their wealth</td><td><em>al-Hidayah</em></td></tr>
</tbody></table></figure>
<h2>Worked example in rupees (Hanafi)</h2>
<p>Ayesha lives in Karachi and follows the Hanafi madhab. On her zakat date, 1 Ramadan, she has Rs 6,00,000 in a savings account, 4 tola of 22K jewellery that she wears, Rs 50,000 paid into a committee so far, and a credit card bill of Rs 30,000 due this month. Take an example rate of Rs 4,50,000 for 1 tola of 24K gold, so 22K is Rs 4,12,500 a tola.</p>
<ul>
<li><strong>Jewellery:</strong> 4 × Rs 4,12,500 = Rs 16,50,000. Counted, even though she wears it.</li>
<li><strong>Cash and committee:</strong> Rs 6,00,000 + Rs 50,000 = Rs 6,50,000.</li>
<li><strong>Debt due now:</strong> minus Rs 30,000.</li>
<li><strong>Total:</strong> Rs 22,70,000, far above the silver nisab, so zakat is 2.5% = <strong>Rs 56,750</strong>.</li>
</ul>
<p>Her savings account was above the bank's nisab, so the bank deducted 2.5% of it, Rs 15,000, on 1 Ramadan; she pays the remaining Rs 41,750. Under the Shafi'i, Maliki or Hanbali madhab her worn jewellery would be exempt, and her zakat would be much lower or nothing. The calculator above does the same steps with today's rate.</p>
<h2>What is not zakatable in Hanafi fiqh</h2>
<p>Your home, the plot you live on or plan to build on for yourself, furniture, clothes, a car for your own use, the tools of your work and books are basic needs, so they carry no zakat. Precious stones such as diamonds and pearls are not zakatable unless they are kept for sale. A plot or flat bought to sell is trade goods and is counted at its market value; one bought to rent out is not, but the saved rent is counted with your cash.</p>
<h2>How the Hanafi madhab differs from the others</h2>
<ul>
<li>It is one of the two views (with Ahl-e-Hadith) that counts worn jewellery.</li>
<li>It uses the silver nisab for cash, so more people owe zakat than under the gold nisab.</li>
<li>It subtracts debts due now, unlike the Shafi'i and Ahl-e-Hadith views.</li>
<li>It needs the nisab only at the start and end of the year, while the Shafi'i and Hanbali schools require it all year.</li>
<li>It puts no zakat on the wealth of children, while the other Sunni schools do.</li>
</ul>
<h2>Using this calculator, step by step</h2>
<ol>
<li>Pick your zakat date, the Islamic date on which your wealth first reached the nisab, or 1 Ramadan if you have always paid then.</li>
<li>Enter cash at home, every bank account, committee money paid in, prize bonds, savings certificates and shares bought to sell.</li>
<li>Under <em>Gold</em> and <em>Silver</em>, enter every piece of jewellery with its weight in tola or grams and its karat, including what you wear.</li>
<li>Under <em>Debts</em>, enter only what is due now: this month's rent, bills, the instalments due in the coming year and money you must return soon.</li>
<li>Press calculate. The result shows the silver nisab used, the zakat due and how each line was counted. Enter the bank's 1 Ramadan deduction under <em>Already paid</em>.</li>
</ol>
<p>Download the PDF for your records, or save a data file to open next year. Nothing you enter leaves your device.</p>
HTML,
			'faq'   => array(
				array( 'q' => 'Is zakat due on gold jewellery worn every day in Hanafi fiqh?', 'a' => 'Yes. Darul Uloom Deoband states that zakat is wajib on jewellery even if it is used daily (Fatwa 2310/H=713/th=1431).' ),
				array( 'q' => 'Hanafi nisab sona ya chandi?', 'a' => 'Agar sirf sona ho to 7.5 tola sone ka nisab. Agar naqd, maal-e-tijarat ya sona aur chandi dono hon to sab ki qeemat jor kar chandi ke nisab (52.5 tola) se dekha jata hai.' ),
				array( 'q' => 'Are debts subtracted in Hanafi zakat?', 'a' => 'Yes, debts due now are subtracted before checking the nisab.' ),
				array( 'q' => 'Deobandi aur Barelvi zakat mein koi farq hai?', 'a' => 'Nahi. Dono Hanafi fiqh par hain; zevar, qarz aur nisab ke masail mein hamein koi farq maloom nahi. Apne mufti sahib ki baat ko tarjeeh dein.' ),
				array( 'q' => 'Bachon ke maal par Hanafi fiqh mein zakat hai?', 'a' => 'Nahi. Hanafi fiqh mein nabaligh bache aur deewane ke maal par zakat nahi, jab ke baqi Sunni maslak is par zakat wajib kehte hain.' ),
				array( 'q' => 'Hanafi fiqh mein ghar aur gaari par zakat hai?', 'a' => 'Nahi. Rehne ka ghar, apne istemal ki gaari, furniture, kapre aur kaam ke auzaar zaroorat ki cheezein hain. Bechne ki niyyat se khareeda gaya plot ya flat karobari maal hai, us ki bazaar qeemat par zakat hai.' ),
				array( 'q' => 'Hanafi fiqh mein saal ke beech paise nisab se kam ho jayein to?', 'a' => 'Agar saal ke shuru aur aakhir mein nisab poora ho to beech ki kami se farq nahi parta, jab tak maal bilkul khatam na ho jaye.' ),
			),
			'related' => 'zakat-calculator-pakistan,zakat-on-gold-calculator,madhab-comparison,zakat-on-jewellery',
		),
		'shafi-zakat-calculator' => array(
			'key'   => 'shafii',
			'question' => "How is zakat calculated in the Shafi'i madhab?",
			'title' => "Shafi'i Zakat Calculator",
			'seo'   => "Shafi'i Zakat Calculator {year}: Worn Jewellery Is Exempt",
			'desc'  => "Calculate zakat by Shafi'i fiqh: worn jewellery exempt, debts not deducted, gold and silver checked separately. Live rates, choice of gold or silver nisab.",
			'nav'   => "Shafi'i",
			'blurb' => 'Malaysia, Indonesia, Yemen',
			'intro' => "<p>This calculator follows the Shafi'i madhab, followed in Malaysia, Indonesia, Singapore, Brunei, Yemen, Somalia, Kenya and Sri Lanka, and by many in Egypt, where the Hanafi, Shafi'i and Maliki schools are all followed.</p>",
			'answer' => "In Shafi'i fiqh permissible jewellery that a woman wears is exempt, debts do not reduce zakat, and gold and silver are separate classes that are not added together to reach the nisab.",
			'body'  => <<<'HTML'
<h2>Shafi'i zakat rules used in this calculator</h2>
<ul>
<li><strong>Jewellery:</strong> no zakat on permissible jewellery that is worn. If it goes beyond the customary amount (200 mithqal: about 850 g at 4.25 g per mithqal; the calculator uses the 860 g figure we read in MUIS guidance, pending verification) it becomes zakatable, as do pieces kept for investment (MUIS Office of the Mufti, citing Imam al-Nawawi's <em>al-Majmu'</em>).</li>
<li><strong>Debts:</strong> in the relied-upon position, debts do not prevent or reduce zakat (SeekersGuidance, "Which debts affect zakat").</li>
<li><strong>Gold and silver:</strong> treated as two separate classes; each is checked against its own nisab.</li>
<li><strong>Cash and trade goods:</strong> valued against a nisab standard. Official bodies in Malaysia and Singapore use the gold standard; you can switch to silver in the calculator.</li>
<li><strong>Money owed to you:</strong> zakat is paid every year on loans you are sure to get back.</li>
</ul>
<h2>Shafi'i rules and their sources</h2>
<figure class="wp-block-table"><table><thead><tr><th>Question</th><th>Shafi'i ruling</th><th>Source</th></tr></thead><tbody>
<tr><td>Worn jewellery</td><td>Exempt if permissible and within custom</td><td>MUIS, citing al-Nawawi's <em>al-Majmu'</em></td></tr>
<tr><td>Jewellery kept as savings, gold bars and coins</td><td>Zakatable</td><td>MUIS Office of the Mufti</td></tr>
<tr><td>Debts</td><td>Do not reduce zakat (relied-upon view)</td><td>SeekersGuidance, "Which debts affect zakat"</td></tr>
<tr><td>Gold and silver</td><td>Two classes, each with its own nisab, not added together</td><td>al-Nawawi, <em>al-Majmu'</em></td></tr>
<tr><td>Nisab weights</td><td>20 mithqal of gold (87.48 g) and 5 awqiyah (200 dirham) of silver (612.35 g)</td><td>"No zakat on less than five awqiyah" (Bukhari 1447)</td></tr>
<tr><td>The lunar year</td><td>The nisab must be held for the whole year</td><td>Ibn Majah 1792</td></tr>
<tr><td>Children's wealth</td><td>Zakatable; the guardian pays it</td><td>al-Nawawi, <em>al-Majmu'</em></td></tr>
</tbody></table></figure>
<h2>Jewellery and the nisab in the Shafi'i madhab</h2>
<p>The exemption covers jewellery that a woman may wear and that she keeps for wearing, in amounts that are customary for women like her. A man's gold ring or gold jewellery is not permitted to him, so it is zakatable. Jewellery bought as an investment, kept in a locker for the future, or broken and no longer wearable, is counted at its gold weight. Because gold and silver are separate classes, 50 g of gold and 400 g of silver are both below their nisab and carry no zakat, although their combined value would pass the silver nisab in the Hanafi calculation.</p>
<p>For cash, savings and trade goods, the Shafi'i authorities in Malaysia (such as the state zakat centres) and Singapore (MUIS) measure the nisab by gold, about [myzt_rate type="nisab-gold" currency="PKR"] today. Some Shafi'i scholars elsewhere advise the silver measure, which is lower and better for the poor. The calculator starts with gold and lets you switch.</p>
<h2>Worked example in rupees (Shafi'i)</h2>
<p>Fatima follows the Shafi'i madhab and lives in Karachi. On her zakat date she has Rs 25,00,000 in the bank, 60 g of 22K bangles she wears, and a loan of Rs 5,00,000 she is repaying. Take an example gold nisab of Rs 33,00,000 and silver nisab of Rs 3,60,000.</p>
<ul>
<li><strong>Bangles:</strong> permissible and worn, so not counted.</li>
<li><strong>Debt:</strong> not subtracted, so the savings stay at Rs 25,00,000.</li>
<li><strong>With the gold nisab:</strong> Rs 25,00,000 is below Rs 33,00,000, so no zakat is due this year.</li>
<li><strong>With the silver nisab:</strong> it is above Rs 3,60,000, so zakat is 2.5% = Rs 62,500.</li>
</ul>
<p>The choice of nisab decides the whole answer here, so ask a Shafi'i scholar you trust which one to use, and keep to it every year. A Hanafi with the same wealth would count the bangles, subtract the loan and use silver.</p>
<h2>How the Shafi'i madhab differs from the others</h2>
<ul>
<li>It is the only Sunni school that does not add gold and silver together.</li>
<li>Like the Ahl-e-Hadith view, it does not subtract debts, so a person with large loans can pay more than under the Hanafi, Maliki or Hanbali rules.</li>
<li>Like the Maliki and Hanbali schools, it exempts permissible worn jewellery.</li>
<li>It requires the nisab for the whole lunar year, as the Hanbali school does.</li>
</ul>
<h2>Using this calculator, step by step</h2>
<ol>
<li>Enter cash, bank balances and any trade stock. Leave the debts box empty, or enter debts to see how the Hanafi result would change in the comparison.</li>
<li>Enter gold you keep as savings, coins and bars under <em>Gold</em>. Mark jewellery you wear as worn; it is left out of the Shafi'i total.</li>
<li>Choose gold or silver as the nisab for cash. The calculator starts with gold, as MUIS and the Malaysian zakat centres do.</li>
<li>Press calculate. Gold, silver and cash are each checked against their own nisab, and zakat is 2.5% of each class that reaches it.</li>
</ol>
<p>For livestock and crops, which have their own nisab and rates, use the <a href="/ushr-calculator/">ushr and livestock calculator</a>. To pay for a child, run the calculator for the child's own savings separately.</p>
HTML,
			'faq'   => array(
				array( 'q' => "Is there zakat on worn jewellery in the Shafi'i madhab?", 'a' => 'No, as long as it is permissible and within the customary amount. Jewellery kept for investment or far beyond custom is zakatable.' ),
				array( 'q' => "Do debts reduce zakat for Shafi'is?", 'a' => "In the relied-upon Shafi'i position, no: debts do not prevent the obligation of zakat." ),
				array( 'q' => "Gold or silver nisab in Shafi'i fiqh?", 'a' => 'Gold and silver each have their own nisab. For cash, Malaysian and Singaporean authorities use the gold standard; the calculator lets you choose.' ),
				array( 'q' => "Shafi'i maslak mein pehne hue zevar par zakat hai?", 'a' => "Nahi, agar zevar jaiz ho aur aam rivaj ke andar pehna jata ho. Jo zevar bachat ke liye rakha ho, sone ke biscuit aur sikke, un par zakat hai." ),
				array( 'q' => "Shafi'i fiqh mein qarz minus hota hai?", 'a' => "Mu'tamad qaul ke mutabiq nahi. Qarz zakat ko kam nahi karta." ),
				array( 'q' => "Is zakat due on a child's savings in the Shafi'i madhab?", 'a' => 'Yes. The guardian pays it from the child\'s own wealth once it reaches the nisab and a year passes.' ),
				array( 'q' => 'Shafi\'i fiqh mein sona aur chandi mila kar nisab dekha jata hai?', 'a' => 'Nahi. Shafi\'i maslak mein sona aur chandi do alag qismein hain; har ek ko apne nisab se dekha jata hai aur dono ko mila kar nisab poora nahi kiya jata.' ),
				array( 'q' => 'Shafi\'i maslak mein naqdi ke liye kaunsa nisab hai?', 'a' => 'Malaysia aur Singapore ke idare sone ka nisab lete hain; kuch Shafi\'i ulama chandi ka nisab behtar samajhte hain jo kam hai aur ghareebon ke liye behtar. Calculator mein dono mein se chun sakte hain; apne aalim se pooch kar har saal ek hi rakhen.' ),
			),
			'related' => 'madhab-comparison,zakat-on-jewellery,nisab,gold-rate-today',
		),
		'maliki-zakat-calculator' => array(
			'key'   => 'maliki',
			'question' => "How is zakat calculated in the Maliki madhab?",
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
<li><strong>Debts:</strong> debts reduce zakat on "hidden" wealth: cash, gold, silver and trade goods. They do not reduce zakat on crops and livestock (see the <a href="/ushr-calculator/">ushr and livestock calculator</a>). Source: SeekersGuidance, "Which debts affect zakat".</li>
<li><strong>Gold and silver:</strong> may be combined to reach the nisab.</li>
<li><strong>Money owed to you:</strong> a merchant pays yearly on trade debts; for a cash loan, zakat is paid when it is received.</li>
<li><strong>Nisab for cash:</strong> the calculator starts with silver and lets you switch to gold. Ask a local scholar which your community uses.</li>
</ul>
<h2>Worked example (Maliki)</h2>
<p>Youssef runs a small shop. On his zakat date he has 40,000 in cash and in the bank, shop stock worth 60,000 at its selling price, his wife's gold jewellery that she wears (her own, about 100 g), and a supplier bill of 20,000 due now. The amounts are in any currency.</p>
<ul>
<li><strong>Jewellery:</strong> permissible and worn, so it is left out. Jewellery kept as savings or for sale would be counted.</li>
<li><strong>Zakatable wealth:</strong> 40,000 + 60,000 = 100,000.</li>
<li><strong>Debt:</strong> the supplier bill reduces cash and trade wealth, so 100,000 − 20,000 = 80,000.</li>
<li><strong>Zakat:</strong> 80,000 is far above the silver nisab, so he pays 2.5% = 2,000.</li>
</ul>
<p>If Youssef also farmed wheat, the 20,000 debt would not reduce the ushr on his harvest, because Maliki scholars do not set debts against crops or livestock. If he owned a spare plot he does not need, Maliki scholars would first set the debt against that plot; the calculator does not ask about such assets and subtracts the whole debt, and it says so in a note.</p>
<h2>How the Maliki result compares</h2>
<ul>
<li><strong>With the Hanafi result:</strong> the same when you have no jewellery, because both subtract debts. With worn jewellery the Hanafi result is higher, since Hanafi scholars count it.</li>
<li><strong>With the Shafi'i result:</strong> usually lower when you have debts, because Shafi'i scholars do not subtract them, and the Shafi'i calculation keeps gold and silver separate.</li>
<li><strong>With the Hanbali result:</strong> very close; both exempt worn jewellery and subtract debts. The difference is mostly in the nisab used for cash.</li>
</ul>
<h2>Money owed to you</h2>
<p>For a trader, money customers owe from sales is counted every year with the stock. A cash loan you gave a friend is different: Maliki scholars pay its zakat once, for one year, when it is repaid. To do that, enter it on the <em>Doubtful debts owed to you</em> line instead of <em>Money owed to you</em>, so it is left out for now. For livestock and crops, use the <a href="/ushr-calculator/">ushr and livestock calculator</a>; for the date your zakat falls due, use the <a href="/zakat-date-calculator/">zakat date calculator</a>.</p>
<h2>Maliki rules and their sources</h2>
<figure class="wp-block-table"><table><thead><tr><th>Question</th><th>Maliki ruling</th><th>Source</th></tr></thead><tbody>
<tr><td>Worn jewellery</td><td>Exempt if permissible and used</td><td>Irsyad Fatwa 38</td></tr>
<tr><td>Debts</td><td>Reduce cash, gold, silver and trade goods; not crops or livestock</td><td>SeekersGuidance, "Which debts affect zakat"</td></tr>
<tr><td>Gold and silver</td><td>May be combined to reach the nisab</td><td>Maliki manuals on zakat of gold and silver</td></tr>
<tr><td>Nisab weights</td><td>20 dinar (87.48 g) of gold, 200 dirham (612.35 g) of silver</td><td>Abu Dawud 1573; Bukhari 1447</td></tr>
<tr><td>Trade debts and loans</td><td>Trader pays yearly on sales owed; a cash loan is paid on once, when repaid</td><td>Maliki view summarised by SeekersGuidance</td></tr>
<tr><td>Children's wealth</td><td>Zakatable; the guardian pays it</td><td>Common to the Maliki, Shafi'i and Hanbali schools</td></tr>
</tbody></table></figure>
<h2>Worked example in rupees (Maliki)</h2>
<p>Take the same figures in rupees: Rs 4,00,000 in cash and in the bank, stock worth Rs 6,00,000 at selling price, worn jewellery, and a supplier bill of Rs 2,00,000 due now. The jewellery is left out, the bill is subtracted, and Rs 8,00,000 remains, above the silver nisab (about [myzt_rate type="nisab-silver" currency="PKR"] today). Zakat is 2.5% = <strong>Rs 20,000</strong>. Under the Hanafi madhab the jewellery would be added; under the Shafi'i, the bill would not be subtracted, giving Rs 25,000.</p>
<h2>Who follows the Maliki madhab</h2>
<p>The Maliki school is named after Imam Malik ibn Anas of Madinah, author of <em>al-Muwatta'</em>, one of the earliest collections of hadith and fiqh. It is the main school of North and West Africa, from Morocco to Nigeria, and of Sudan, and it is followed by many in the Gulf (Kuwait, the UAE and Bahrain have long Maliki traditions). Its manuals, such as the <em>Risalah</em> of Ibn Abi Zayd and the <em>Mukhtasar</em> of Khalil, give the rules this calculator follows.</p>
<h2>Using this calculator, step by step</h2>
<ol>
<li>Enter cash, bank balances, trade stock at selling price and money customers owe you.</li>
<li>Enter gold and silver kept as savings; mark jewellery that is worn so it is left out.</li>
<li>Enter debts due now; the calculator subtracts them from cash, gold, silver and stock only.</li>
<li>Choose silver or gold as the nisab for cash, as your local scholars do, and press calculate.</li>
</ol>
HTML,
			'faq'   => array(
				array( 'q' => 'Is worn jewellery zakatable in the Maliki madhab?', 'a' => 'No, permissible jewellery that is worn is exempt.' ),
				array( 'q' => 'Are debts deducted in Maliki zakat?', 'a' => 'Yes, from cash, gold, silver and trade goods, but not from crops or livestock.' ),
				array( 'q' => 'Is gold kept as savings zakatable for Malikis?', 'a' => 'Yes. Only permissible jewellery that is actually worn is exempt. Gold bars, coins and jewellery kept as savings or for sale are counted.' ),
				array( 'q' => 'When do Malikis pay zakat on a loan they gave?', 'a' => 'A cash loan is paid on once, for one year, when it comes back. A trader counts money owed from sales every year.' ),
				array( 'q' => 'Maliki maslak mein qarz minus hota hai?', 'a' => 'Haan, naqdi, sona, chandi aur karobari maal se qarz minus hota hai, lekin fasal aur maweshi ki zakat se nahi.' ),
				array( 'q' => 'Maliki maslak mein pehne hue zevar par zakat hai?', 'a' => 'Nahi, jaiz zevar jo pehna jata ho us par zakat nahi. Bachat ya bechne ke liye rakha zevar, sone ke biscuit aur sikke gine jate hain.' ),
				array( 'q' => 'Maliki maslak mein diye hue qarz ki zakat kab di jaye?', 'a' => 'Kisi ko diya hua naqd qarz wapas milne par sirf ek saal ki zakat di jati hai. Tajir ke grahakon par baqi raqam har saal stock ke saath gini jati hai.' ),
			),
			'related' => 'madhab-comparison,business-zakat-calculator,nisab,zakat-on-jewellery',
		),
		'hanbali-zakat-calculator' => array(
			'key'   => 'hanbali',
			'question' => "How is zakat calculated in the Hanbali madhab?",
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
<li><strong>Nisab for cash and trade goods:</strong> the standard that is best for the poor, which today is silver. The two nisabs, 20 dinars of gold and 200 dirhams of silver held for a year, come from the hadith of Ali (Abu Dawud 1573).</li>
<li><strong>Debts:</strong> subtracted before checking the nisab.</li>
</ul>
<p>Some well-known scholars in Saudi Arabia, such as the Permanent Committee, hold that jewellery is zakatable. If you follow that view, use the <a href="/ahl-e-hadith-zakat-calculator/">Ahl-e-Hadith calculator</a>, which applies it.</p>
<h2>Worked example (Hanbali)</h2>
<p>Khalid lives in Riyadh. On his zakat date he has SAR 30,000 in the bank, 50 g of 24K gold bars, his wife's gold jewellery that she wears, and SAR 10,000 of debt due now. Say gold is SAR 400 a gram (the calculator uses today's rate).</p>
<ul>
<li><strong>Jewellery:</strong> permissible and worn, so it is left out.</li>
<li><strong>Gold bars:</strong> 50 g × SAR 400 = SAR 20,000. On its own, 50 g is below the gold nisab of 87.48 g.</li>
<li><strong>Combining:</strong> Hanbali scholars add gold, silver and cash together and use the nisab that is better for the poor, which today is silver. SAR 30,000 + SAR 20,000 = SAR 50,000, far above the silver nisab.</li>
<li><strong>Debt:</strong> SAR 50,000 − SAR 10,000 = SAR 40,000.</li>
<li><strong>Zakat:</strong> 2.5% of SAR 40,000 = SAR 1,000.</li>
</ul>
<p>Under the Permanent Committee's view used in our Ahl-e-Hadith calculator, the jewellery would be counted and the debt would not be subtracted, so the same person would pay more. The <a href="/madhab-comparison/">comparison</a> shows both.</p>
<h2>Jewellery that is lent or kept</h2>
<p>The Hanbali exemption covers jewellery that is permissible for the owner and kept for wearing or for lending to others. It does not cover jewellery kept as savings or for sale, gold bars and coins, or jewellery a man wears that is not permitted to him; these are counted at their value.</p>
<h2>When Hanbalis pay zakat</h2>
<p>The wealth must stay at or above the nisab for the whole lunar year; if it drops below the nisab during the year, the year starts again when it reaches the nisab once more. Use the <a href="/zakat-date-calculator/">zakat date calculator</a> to track your date. In the Hanbali view, zakat on money owed to you by someone who can and will pay is due for every year, but you may pay it when you receive the money; the calculator counts it now.</p>
<h2>Hanbali rules and their sources</h2>
<figure class="wp-block-table"><table><thead><tr><th>Question</th><th>Hanbali ruling (relied-upon view)</th><th>Source</th></tr></thead><tbody>
<tr><td>Worn or lent jewellery</td><td>Exempt if permissible</td><td>Akhsar al-Mukhtasarat</td></tr>
<tr><td>Gold, silver and cash</td><td>Added together to complete the nisab</td><td>Hanbali manuals on zakat of gold and silver</td></tr>
<tr><td>Nisab for cash</td><td>Whichever is better for the poor (silver today)</td><td>Abu Dawud 1573</td></tr>
<tr><td>Debts</td><td>Subtracted before the nisab is checked</td><td>SeekersGuidance (debts by madhab)</td></tr>
<tr><td>The lunar year</td><td>Nisab held throughout the year</td><td>Ibn Majah 1792</td></tr>
<tr><td>Contemporary Saudi view</td><td>Jewellery zakatable (Permanent Committee)</td><td>IslamQA 19901</td></tr>
</tbody></table></figure>
<h2>Worked example in rupees (Hanbali)</h2>
<p>Usman, a Pakistani working in Riyadh, follows the Hanbali view. He has Rs 12,00,000 saved in Pakistan, 3 tola of 24K gold coins, his wife's worn jewellery, and a car loan instalment of Rs 1,00,000 due now. At an example rate of Rs 4,50,000 a tola the coins are worth Rs 13,50,000. Cash and coins are added (Rs 25,50,000), the debt is subtracted (Rs 24,50,000), and the total is above the silver nisab, so zakat is 2.5% = <strong>Rs 61,250</strong>. The jewellery is not counted. Under the Permanent Committee's view used in our Ahl-e-Hadith calculator, the jewellery would be added and the debt not subtracted.</p>
<h2>Who follows the Hanbali madhab</h2>
<p>The Hanbali school is named after Imam Ahmad ibn Hanbal of Baghdad, compiler of the <em>Musnad</em>. It is the official school in Saudi Arabia and is followed in Qatar and by many in Kuwait and the UAE. Many Pakistani, Indian and Bangladeshi workers in the Gulf follow their home madhab (usually Hanafi) while living there; this calculator is for those who follow Hanbali fiqh itself. Its standard texts, such as <em>Akhsar al-Mukhtasarat</em>, <em>Zad al-Mustaqni'</em> and Ibn Qudamah's <em>al-Mughni</em>, give the rules used here.</p>
<h2>Using this calculator, step by step</h2>
<ol>
<li>Enter cash, bank balances and any trade stock, in riyals, rupees or any currency.</li>
<li>Enter gold bars, coins and jewellery kept as savings; mark jewellery that is worn or lent so it is left out.</li>
<li>Enter debts due now; they are subtracted.</li>
<li>Press calculate. Gold, silver and cash are added and compared with the silver nisab.</li>
</ol>
HTML,
			'faq'   => array(
				array( 'q' => 'Is jewellery zakatable in the Hanbali madhab?', 'a' => 'In the relied-upon Hanbali position, no, if it is permissible and kept for use or lending. Some contemporary Saudi scholars hold that it is zakatable.' ),
				array( 'q' => 'Which nisab do Hanbalis use for cash?', 'a' => 'The one that is best for the poor, which today is the silver nisab.' ),
				array( 'q' => 'Are gold and cash added together in the Hanbali madhab?', 'a' => 'Yes. Gold, silver and cash are added together to complete the nisab, so a small amount of gold with some savings can make zakat due.' ),
				array( 'q' => 'Does wealth have to stay above the nisab all year for Hanbalis?', 'a' => 'Yes. In the Hanbali madhab the nisab must be held throughout the lunar year, not only at its start and end.' ),
				array( 'q' => 'Is zakat due on a child\'s wealth in the Hanbali madhab?', 'a' => 'Yes. The guardian pays it from the child\'s own wealth once it has been above the nisab for a lunar year, as in the Maliki and Shafi\'i schools. Only the Hanafi school exempts children.' ),
				array( 'q' => 'Hanbali maslak mein zevar par zakat hai?', 'a' => 'Mu\'tamad Hanbali qaul mein jaiz zevar jo pehna jaye ya udhaar diya jaye us par zakat nahi. Saudi Permanent Committee jaise kuch ulama zakat wajib kehte hain.' ),
				array( 'q' => 'Hanbali maslak mein qarz minus hota hai?', 'a' => 'Haan, jo qarz abhi ada karna hai woh nisab dekhne se pehle minus hota hai.' ),
				array( 'q' => 'Hanbali maslak mein kaunsa nisab lagta hai?', 'a' => 'Naqdi aur karobari maal ke liye woh nisab jo ghareebon ke liye behtar ho, jo aaj chandi ka nisab hai. Sona, chandi aur naqdi mila kar nisab poora kiya jata hai.' ),
			),
			'related' => 'ahl-e-hadith-zakat-calculator,madhab-comparison,nisab,gold-rate-today',
		),
		'ahl-e-hadith-zakat-calculator' => array(
			'key'   => 'ahlehadith',
			'question' => "How do Ahl-e-Hadith scholars calculate zakat?",
			'title' => 'Ahl-e-Hadith Zakat Calculator',
			'seo'   => 'Ahl-e-Hadith Zakat Calculator {year}: Zevar, Cash, Gold',
			'desc'  => 'Zakat calculator for Ahl-e-Hadith (Salafi): jewellery included, debts not deducted, cash added to gold and silver, lower nisab. Live rates, cited sources.',
			'nav'   => 'Ahl-e-Hadith',
			'blurb' => 'Salafi view',
			'intro' => '<p>This calculator applies the rulings of the Saudi Permanent Committee for Research and Fatwa (al-Lajnah ad-Da\'imah) and Shaykh Ibn Uthaymeen. Many Ahl-e-Hadith readers follow these scholars, but we have not found a Pakistani Ahl-e-Hadith fatwa confirming every point, so check with your own scholar.</p>',
			'answer' => 'Following the Saudi Permanent Committee, zakat is due on gold and silver jewellery that reaches the nisab, even if worn, and cash is added to gold and silver and measured by the lower of the two nisabs.',
			'body'  => <<<'HTML'
<h2>Rules used in this calculator</h2>
<ul>
<li><strong>Jewellery:</strong> "The more correct view is that zakat on jewellery is obligatory if it reaches the nisab" (IslamQA 19901, citing the Permanent Committee).</li>
<li><strong>Cash with gold and silver:</strong> cash may be added to gold or silver to complete the nisab, and cash is zakatable when it reaches the lower of the two nisabs (IslamQA 201807, citing the Permanent Committee and Ibn Uthaymeen).</li>
<li><strong>Debts:</strong> not deducted. "Being in debt does not mean that zakah should not be paid" (Permanent Committee); Shaykh Ibn Baz called this the more correct opinion and Shaykh Ibn Uthaymeen explained that zakat is tied to the wealth while a debt is a personal obligation (IslamQA 22426). A debt that is due now and being demanded can be paid off first, which reduces what you own on your zakat date.</li>
</ul>
<p>We have not found a published fatwa from a Pakistani Ahl-e-Hadith institution on every point above. If your scholar differs, the comparison table shows the other views.</p>
<h2>Rules and their sources</h2>
<figure class="wp-block-table"><table><thead><tr><th>Question</th><th>Ruling used here</th><th>Source</th></tr></thead><tbody>
<tr><td>Worn gold and silver jewellery</td><td>Zakatable once it reaches the nisab</td><td>IslamQA 19901 (Permanent Committee); the hadith of the two bracelets (Abu Dawud 1563)</td></tr>
<tr><td>Cash with gold and silver</td><td>Added together; the lower nisab (silver today) applies</td><td>IslamQA 201807</td></tr>
<tr><td>Debts</td><td>Not subtracted</td><td>IslamQA 22426</td></tr>
<tr><td>Nisab weights</td><td>87.48 g of gold, 612.35 g of silver</td><td>Bukhari 1447; Abu Dawud 1573</td></tr>
<tr><td>The lunar year</td><td>Wealth must stay at or above the nisab for a year</td><td>Ibn Majah 1792</td></tr>
<tr><td>Children's wealth</td><td>Zakatable; the guardian pays</td><td>View of the Permanent Committee and most scholars outside the Hanafi school</td></tr>
</tbody></table></figure>
<h2>Jewellery (zevar) in the Ahl-e-Hadith view</h2>
<p>Scholars who count jewellery rely on the hadiths in which the Prophet ﷺ asked women whether they paid zakat on their gold bracelets and warned those who did not (Abu Dawud 1563), and on the general verses on hoarding gold and silver. So every piece of gold and silver jewellery is counted, worn or not, as long as the owner's total gold or silver (or its value with cash) reaches the nisab. Only the pure metal is valued: choose 22K or 21K in the calculator. Stones and making charges are left out. The zakat is due from the woman who owns the jewellery; her husband may pay it for her with her permission.</p>
<h2>Worked example in rupees (Ahl-e-Hadith)</h2>
<p>Hafsa lives in Lahore. On her zakat date she has Rs 3,00,000 in the bank, 5 tola of 22K jewellery she wears, and owes Rs 1,00,000 to her brother. Take an example rate of Rs 4,12,500 a tola for 22K gold.</p>
<ul>
<li><strong>Jewellery:</strong> 5 × Rs 4,12,500 = Rs 20,62,500, counted although worn.</li>
<li><strong>Cash:</strong> Rs 3,00,000, added to the gold.</li>
<li><strong>Debt:</strong> not subtracted. If the brother is asking for it now, she can repay it before her zakat date, which lowers her cash.</li>
<li><strong>Zakat:</strong> 2.5% of Rs 23,62,500 = <strong>Rs 59,063</strong>.</li>
</ul>
<p>A Hanafi with the same wealth would also count the jewellery but would subtract the debt (zakat Rs 56,563). A Shafi'i, Maliki or Hanbali would leave the worn jewellery out, which changes the answer completely.</p>
<h2>How this view differs from the four madhabs</h2>
<ul>
<li>It agrees with the Hanafi madhab that worn jewellery is zakatable.</li>
<li>It agrees with the Shafi'i madhab that debts are not subtracted.</li>
<li>It agrees with the Hanbali madhab in taking the lower nisab for cash and in adding gold, silver and cash together.</li>
<li>Because it combines the strictest answer on both jewellery and debts, it often gives the highest result in the comparison.</li>
</ul>
<h2>Using this calculator, step by step</h2>
<ol>
<li>Enter cash at home, bank balances, committee money and savings certificates.</li>
<li>Enter all gold and silver jewellery, worn or kept, with its weight and karat.</li>
<li>Leave debts out unless you want to see the difference in the comparison; they are not subtracted in this view.</li>
<li>Press calculate. Gold, silver and cash are added and compared with the lower nisab, which is silver today, about [myzt_rate type="nisab-silver" currency="PKR"].</li>
<li>Enter the bank's 1 Ramadan deduction, if any, under <em>Already paid</em>.</li>
</ol>
<p>Ahl-e-Hadith scholars in Pakistan and India follow the Qur'an and Sunnah directly rather than one of the four madhabs, and they often rely on the fatwas of Shaykh Ibn Baz, Shaykh Ibn Uthaymeen and the Saudi Permanent Committee, which is why this calculator follows them.</p>
HTML,
			'faq'   => array(
				array( 'q' => 'Ahl-e-Hadith ke nazdeek zevar par zakat hai?', 'a' => 'Saudi Permanent Committee ke fatwe ke mutabiq (jis par yeh calculator chalta hai), nisab tak pohanchne wale zevar par zakat wajib hai, chahe pehna jaye.' ),
				array( 'q' => 'Can cash be added to gold to complete the nisab?', 'a' => 'Yes, according to the Permanent Committee and Shaykh Ibn Uthaymeen.' ),
				array( 'q' => 'Ahl-e-Hadith ke nazdeek qarz minus hota hai?', 'a' => 'Is calculator mein nahi, Saudi Permanent Committee aur Shaykh Ibn Baz ke mutabiq. Jo qarz abhi maanga ja raha ho use zakat ki tareekh se pehle ada kar dein to aap ki naqdi kam ho jati hai.' ),
				array( 'q' => 'Do Ahl-e-Hadith pay zakat on jewellery they wear every day?', 'a' => 'In the view this calculator follows, yes: the Permanent Committee holds that gold and silver jewellery is zakatable once it reaches the nisab, worn or not, at 2.5% of the value of its pure metal.' ),
				array( 'q' => 'Ahl-e-Hadith kaunsa nisab lete hain?', 'a' => 'Sona, chandi aur naqdi mila kar dono nisab mein se kam wala, jo aaj chandi ka nisab hai.' ),
				array( 'q' => 'Is there a Pakistani Ahl-e-Hadith fatwa behind this calculator?', 'a' => 'Not on every point yet. It follows the Saudi Permanent Committee, Shaykh Ibn Baz and Shaykh Ibn Uthaymeen, whom many Ahl-e-Hadith readers follow. Confirm with your own scholar.' ),
				array( 'q' => 'Ahl-e-Hadith ke nazdeek bachon ke maal par zakat hai?', 'a' => 'Is calculator ke mutabiq haan, jo Saudi Permanent Committee aur aksar ulama ki rai hai: bache ka maal nisab tak pohanche aur saal guzar jaye to sarparast us ke maal se zakat ada kare.' ),
				array( 'q' => 'Ahl-e-Hadith aur Hanafi zakat mein kya farq hai?', 'a' => 'Dono pehne hue zevar par zakat kehte hain. Farq yeh hai ke Hanafi fiqh mein jo qarz abhi ada karna ho woh minus hota hai, jabke is calculator ke Ahl-e-Hadith hisab mein (Saudi Permanent Committee ke mutabiq) qarz minus nahi hota, is liye natija aksar zyada aata hai.' ),
			),
			'related' => 'hanbali-zakat-calculator,zakat-on-jewellery,madhab-comparison,nisab',
		),
		'shia-zakat-calculator' => array(
			'key'   => 'jafari',
			'question' => "Do Shia Muslims pay zakat on cash and jewellery?",
			'title' => "Shia (Ja'fari) Zakat Calculator",
			'seo'   => "Shia Zakat Calculator {year} (Ja'fari, Sistani Rulings)",
			'desc'  => "Shia Ja'fari zakat explained by Ayatollah Sistani's rulings: which assets carry zakat, the gold and silver nisab in mithqal, and when khums applies instead.",
			'nav'   => 'Shia (Ja\'fari)',
			'blurb' => 'Sistani rulings',
			'intro' => "<p>This calculator follows the rulings of Ayatollah Sistani in <em>Islamic Laws</em> (Taudhih al-Masa'il), one of the leading marja's today, followed by many Shia Muslims in Pakistan, India and Iraq.</p>",
			'answer' => 'According to Ayatollah Sistani, zakat on gold and silver applies only to coins used as currency, so paper money, bank balances and jewellery carry no zakat today. Khums (20%) on the yearly surplus applies instead.',
			'body'  => <<<'HTML'
<h2>Zakat in Ja'fari fiqh (Sistani)</h2>
<ul>
<li><strong>Nine items only:</strong> zakat is due on wheat, barley, dates, raisins, camels, cows, sheep, and gold and silver coins.</li>
<li><strong>Gold nisab:</strong> 20 shar'i mithqal, about 69.12 g (ruling 1912). <strong>Silver nisab:</strong> 105 common mithqal, about 483.84 g (ruling 1913).</li>
<li><strong>Currency:</strong> zakat applies only when gold or silver is minted and used in transactions as money; modern paper money and coins of other metals do not qualify (ruling 1915).</li>
<li><strong>Jewellery:</strong> not zakatable while gold and silver are not used as currency (ruling 1916).</li>
</ul>
<p>Because of this, the calculator usually shows zero zakat for cash, bank money and jewellery in Ja'fari mode. Use the <a href="/khums-calculator/">khums calculator</a> for your yearly surplus, and read <a href="/khums-who-must-pay/">who must pay khums and what counts</a>.</p>
<p>Followers of other maraji' (for example Ayatollah Khamenei) should check their marja's rulings, which may differ in details.</p>
<h2>Ja'fari zakat at a glance</h2>
<figure class="wp-block-table"><table><thead><tr><th>Item</th><th>Zakat in Ja'fari fiqh (Sistani)</th><th>Note</th></tr></thead><tbody>
<tr><td>Wheat, barley, dates, raisins</td><td>10% if watered by rain or rivers, 5% if irrigated by pumps or carried water</td><td>Only above the nisab of about 847 kg; see the <a href="/ushr-calculator/">ushr calculator</a></td></tr>
<tr><td>Sheep and goats</td><td>1 for 40, rising in steps</td><td>Grazing freely all year, not working animals</td></tr>
<tr><td>Cows and buffaloes</td><td>1 calf for 30, rising in steps</td><td>Same conditions</td></tr>
<tr><td>Camels</td><td>1 sheep for 5, rising in steps</td><td>Same conditions</td></tr>
<tr><td>Gold and silver coins used as money</td><td>2.5%</td><td>Gold from 69.12 g, silver from 483.84 g (ruling 1913)</td></tr>
<tr><td>Paper money, bank balances, shares, crypto</td><td>No zakat</td><td>Khums applies to the year's surplus</td></tr>
<tr><td>Jewellery</td><td>No zakat (ruling 1916)</td><td>Khums applies if bought from untaxed income and not needed</td></tr>
<tr><td>Trade goods</td><td>Zakat is recommended, not obligatory</td><td>Khums applies to profits</td></tr>
</tbody></table></figure>
<h2>Why paper money carries khums, not zakat</h2>
<p>In Ja'fari fiqh the zakat on gold and silver is tied to coins that are actually minted and used as money, which is what the dinar and dirham were. Today's notes and bank balances are not gold or silver, so zakat does not apply to them (ruling 1915). That does not mean savings are untouched: once a year, on your khums date, 20% of what is left from the year's income after your expenses is paid as khums. This is why the Shia calculator above usually shows zero zakat for a salaried family, and the <a href="/khums-calculator/">khums calculator</a> shows what they owe instead.</p>
<h2>Worked example in rupees (Sistani)</h2>
<p>Raza lives in a village near Jhang and follows Ayatollah Sistani. On his dates he has Rs 10,00,000 in the bank, of which Rs 4,00,000 is saved from this year's income and the rest was already taxed with khums; his wife's 6 tola of gold jewellery; two buffaloes fed at home on bought fodder; and a wheat harvest of 1,000 kg from land watered by a tube well.</p>
<ul>
<li><strong>Cash and jewellery:</strong> no zakat.</li>
<li><strong>Buffaloes:</strong> no zakat; they are fewer than 30 and are not grazing animals.</li>
<li><strong>Wheat:</strong> above the nisab and irrigated, so zakat is 5% = 50 kg, or its value.</li>
<li><strong>Khums:</strong> 20% of the Rs 4,00,000 surplus = <strong>Rs 80,000</strong>, half sahm-e-imam and half sahm-e-sadat.</li>
</ul>
<p>A Hanafi neighbour with the same wealth would pay 2.5% zakat on the cash and the jewellery, and ushr on the wheat with no minimum quantity.</p>
<h2>Sistani, Khamenei and other maraji'</h2>
<p>All the major Shia maraji' limit obligatory zakat to the nine items and apply khums to the yearly surplus, so the overall picture is the same. They differ in details, such as the exact nisab weights, how the year is counted and what counts as an expense for khums. The figures on this page and in the calculator follow Ayatollah Sistani's <em>Islamic Laws</em>. If you follow Ayatollah Khamenei or another marja', check their published rulings or ask their office.</p>
<h2>Shia account holders and the bank deduction</h2>
<p>Pakistani banks deduct 2.5% zakat from savings accounts on 1 Ramadan. Followers of Fiqh-e-Jafaria can stop this by filing a CZ-50 declaration with each bank before Ramadan; see <a href="/bank-zakat-deduction-pakistan/">bank zakat deduction and CZ-50</a>. Fitra (zakat al-fitr) at Eid is obligatory in Ja'fari fiqh too; see the <a href="/fitrana-calculator/">fitrana calculator</a> and follow your marja's amount.</p>
<h2>Using this calculator, step by step</h2>
<ol>
<li>Choose Shia (Ja'fari) above. Cash, bank balances and jewellery are shown with zero zakat, with a note explaining why.</li>
<li>If you own gold or silver coins that are used as money, enter them; they are checked against the Sistani nisab.</li>
<li>For crops or grazing animals, use the <a href="/ushr-calculator/">ushr and livestock calculator</a>.</li>
<li>Then open the <a href="/khums-calculator/">khums calculator</a> for the surplus of your year's income on your khums date.</li>
</ol>
<p>The calculator gives an estimate from Ayatollah Sistani's published rulings. For your own case, especially for khums on a business or on a house, ask your marja's office or a trusted representative.</p>
HTML,
			'faq'   => array(
				array( 'q' => 'Do Shia Muslims pay zakat on cash?', 'a' => 'According to Ayatollah Sistani, no: paper money is not zakatable, but khums (20%) is due on the surplus of the year.' ),
				array( 'q' => "What is the gold nisab in Ja'fari fiqh?", 'a' => "20 shar'i mithqal, about 69.12 g, according to Ayatollah Sistani (ruling 1912)." ),
				array( 'q' => 'Shia zakat kin cheezon par hai?', 'a' => 'Ayatollah Sistani ke mutabiq sirf nau cheezon par: gandum, jau, khajoor, kishmish, oont, gaaye, bakri/bheir, aur sone chandi ke woh sikke jo raqam ke tor par chalte hon. Naqdi aur zevar par zakat nahi, un par khums ka hukm hai.' ),
				array( 'q' => 'Is jafari zakat different from khums?', 'a' => 'Yes. Ja\'fari zakat is on the nine items, mostly crops and livestock. Khums is 20% of the year\'s surplus income, including savings, and is paid separately.' ),
				array( 'q' => 'Kya Shia bank ki zakat katauti se bach sakte hain?', 'a' => 'Haan, Fiqh-e-Jafaria ke pairokar har bank mein Ramazan se pehle CZ-50 declaration jama kara kar katauti rukwa sakte hain.' ),
				array( 'q' => 'Fiqh-e-Jafaria mein sone ka nisab kitna hai?', 'a' => 'Ayatollah Sistani ke mutabiq sone ke sikkon ka nisab 20 shar\'i misqal (taqreeban 69.12 gram) aur chandi ka 105 aam misqal (taqreeban 483.84 gram) hai. Yeh sirf un sikkon par hai jo raqam ke tor par chalte hon.' ),
				array( 'q' => 'Kya Shia par fitra wajib hai?', 'a' => 'Ji haan, Fiqh-e-Jafaria mein bhi Eid par fitra (zakat al-fitr) wajib hai. Apne marja ki batayi hui raqam ada karen.' ),
			),
			'related' => 'khums-calculator,khums-who-must-pay,madhab-comparison,nisab',
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
			'content' => $m['intro'] . '[myzt_trust][zakat_calculator madhab="' . $m['key'] . '"][myzt_answer q="' . esc_attr( $m['question'] ) . '"]' . $m['answer'] . '[/myzt_answer]' .
				$m['body'] . '<p>See how the same numbers come out in every school in the <a href="/madhab-comparison/">madhab comparison</a>. How we read each source is explained in our <a href="/methodology/">methodology</a>.</p>[myzt_faq]' . $author . '[myzt_related slugs="' . $m['related'] . '"]',
			'faq'     => $m['faq'],
		);
	}

	/* ------------------------------------------------------------------ */
	$p['madhab-comparison'] = array(
		'title' => 'Zakat in the 4 Madhabs and Shia: Comparison',
		'seo'   => 'Zakat According to 4 Madhabs & Shia: Comparison Table',
		'desc'  => "How Hanafi, Shafi'i, Maliki, Hanbali, Ahl-e-Hadith and Shia fiqh differ on zakat: jewellery, debts, nisab, combining gold and silver. Sources and calculator.",
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
<tr><td>Debts subtracted</td><td>Yes</td><td>No</td><td>Yes (cash, gold, trade)</td><td>Yes</td><td>No</td><td>n/a</td></tr>
<tr><td>Nisab for cash</td><td>Silver</td><td>Gold (local practice)</td><td>Silver or gold</td><td>Lower of the two</td><td>Lower of the two</td><td>No zakat on paper money</td></tr>
<tr><td>Gold + silver combined</td><td>Yes, by value</td><td>No</td><td>Yes</td><td>Yes</td><td>Yes</td><td>No</td></tr>
<tr><td>Gold nisab</td><td>87.48 g</td><td>87.48 g</td><td>87.48 g</td><td>87.48 g</td><td>87.48 g</td><td>69.12 g (coins)</td></tr>
<tr><td>Main source</td><td>Darul Uloom Deoband</td><td>al-Majmu', MUIS</td><td>Irsyad Fatwa 38</td><td>Akhsar al-Mukhtasarat</td><td>Permanent Committee</td><td>Sistani, rulings 1912-1916</td></tr>
</tbody></table></figure>
<h2>Try it with your own numbers</h2>
<p>The calculator below shows your zakat in all six schools at once.</p>
[zakat_calculator compare="open"]
<h2>Inheritance differs too</h2>
<p>The schools also divide an estate differently in some families: a grandfather with brothers, the case of al-Mushtaraka, or what is left when only a spouse survives. The <a href="/wirasat-calculator/">wirasat calculator</a> shows any family's shares in all six madhabs side by side.</p>
<h2>Why there are differences</h2>
<p>The schools read the hadiths about jewellery differently. Hanafi scholars take the reports in which the Prophet ﷺ asked women whether they paid zakat on their bracelets as a general rule; the other three schools consider permissible jewellery like personal belongings, citing companions such as Aishah and Asma who did not pay zakat on the jewellery of the girls in their care. On debts, the Shafi'i school treats zakat as a right tied to the wealth itself, so a debt owed to someone else does not remove it.</p>
<p>All of these are legitimate scholarly positions. Follow the school you follow in your other worship, and ask your scholar when you are unsure.</p>
[myzt_faq]
HTML
		. $author . '[myzt_related slugs="hanafi-zakat-calculator,shafi-zakat-calculator,zakat-on-jewellery,methodology"]',
		'faq'   => array(
			array( 'q' => 'Which madhab gives the highest zakat?', 'a' => 'Usually the Hanafi and Ahl-e-Hadith calculations, because both count worn jewellery and use the lower silver nisab for cash. Ahl-e-Hadith is often the highest of all, because debts are not subtracted.' ),
			array( 'q' => 'Can I choose the madhab with the lowest zakat?', 'a' => 'Scholars advise following the school you normally follow, not picking the easiest view for each question.' ),
			array( 'q' => 'Kis maslak mein zakat sab se zyada banti hai?', 'a' => 'Aam tor par Hanafi aur Ahl-e-Hadith mein, kyun ke dono pehne hue zevar ko ginte hain aur naqdi ke liye chandi ka kam nisab lete hain. Ahl-e-Hadith hisab mein qarz minus nahi hota, is liye aksar wahi sab se zyada hota hai.' ),
			array( 'q' => 'Kya har maslak mein zevar par zakat hai?', 'a' => 'Nahi. Hanafi aur Ahl-e-Hadith mein pehne hue zevar par zakat hai; Shafi\'i, Maliki aur Hanbali mein jaiz pehna hua zevar mustasna hai; Ayatollah Sistani ke mutabiq bhi zevar par zakat nahi.' ),
		),
	);

	/* ------------------------------------------------------------------ */
	$p['calculators'] = array(
		'title' => 'Zakat Calculators',
		'seo'   => 'All Calculators: Zakat, Fitrana, Qurbani, Iddat, Wirasat',
		'desc'  => 'Free tools in one place: zakat on gold, business and savings, fitrana, fidya, zakat date, ushr, khums, haq mehr, diyat, wirasat, qurbani, iddat, gold rate.',
		'nav'   => 'Calculators',
		'blurb' => 'all tools',
		'llms'  => true,
		'content' => <<<'HTML'
[myzt_answer q="Which zakat calculator should I use?"]For most people, the main zakat calculator: choose your madhab and add cash, savings, gold and debts. Use the gold calculator for jewellery only, the business calculator for a shop, fitrana and fidya before Eid, ushr for crops and livestock, khums for Fiqh-e-Jafaria, and the wirasat calculator to divide an estate. All are free and run in your browser.[/myzt_answer]
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
<li><a href="/haq-mehr-calculator/">Haq mehr calculator</a> (Mehr-e-Fatimi and minimum mehr in today's money)</li>
<li><a href="/diyat-calculator/">Diyat calculator</a> (Pakistan's notified diyat and its live silver value)</li>
<li><a href="/wirasat-calculator/">Wirasat calculator</a> (Islamic inheritance by madhab, with a family tree; also in <a href="/wirasat-calculator-urdu/">Urdu</a>)</li>
<li><a href="/qurbani-calculator/">Qurbani calculator</a> (is qurbani wajib on you, with today's nisab and the Eid date)</li>
<li><a href="/iddat-calculator/">Iddat calculator</a> (the date iddat ends after talaq, khula or a husband's death)</li>
<li><a href="/nisab/">Nisab today</a> and <a href="/gold-rate-today/">gold rate today</a></li>
<li><a href="/free-zakat-widget/">Free nisab widget</a> for mosque and blog websites</li>
<li><a href="/zakat-2027-pakistan/">Zakat 2027 Pakistan</a>: nisab, bank deduction, CZ-50 and fitrana dates for Ramadan 2027</li>
</ul>
<h2>Zakat on salary, property, shares and more</h2>
<ul>
<li><a href="/zakat-on-salary/">Zakat on salary</a> (monthly income and savings)</li>
<li><a href="/zakat-on-property/">Zakat on property</a> (plots, houses and rent)</li>
<li><a href="/zakat-on-shares/">Zakat on shares</a> (shares and mutual funds)</li>
<li><a href="/zakat-on-provident-fund/">Zakat on provident fund</a></li>
<li><a href="/zakat-on-crypto/">Zakat on crypto</a></li>
<li><a href="/zakat-on-committee/">Zakat on committee (BC)</a></li>
<li><a href="/zakat-for-overseas-pakistanis/">Zakat for overseas Pakistanis</a></li>
<li><a href="/zakat-calculator-india/">Zakat calculator India</a> (rupees, grams and Hanafi rules)</li>
</ul>
<h2>Calculators in Urdu</h2>
<ul>
<li><a href="/zakat-calculator-urdu/">زکوٰۃ کیلکولیٹر اردو میں</a> (zakat calculator in Urdu)</li>
<li><a href="/zakat-on-gold-urdu/">سونے پر زکوٰۃ</a> (zakat on gold in Urdu)</li>
<li><a href="/nisab-urdu/">آج کا نصاب</a> (nisab today in Urdu)</li>
<li><a href="/fitrana-calculator-urdu/">فطرانہ کیلکولیٹر</a> (fitrana calculator in Urdu)</li>
<li><a href="/haq-mehr-calculator-urdu/">حق مہر کیلکولیٹر</a> (haq mehr calculator in Urdu)</li>
<li><a href="/wirasat-calculator-urdu/">وراثت کیلکولیٹر</a> (wirasat calculator in Urdu)</li>
<li><a href="/fidya-kaffara-calculator-urdu/">فدیہ اور کفارہ کیلکولیٹر</a> (fidya and kaffara calculator in Urdu)</li>
<li><a href="/diyat-calculator-urdu/">دیت کیلکولیٹر</a> (diyat calculator in Urdu)</li>
<li><a href="/khums-calculator-urdu/">خمس کیلکولیٹر</a> (khums calculator in Urdu)</li>
<li><a href="/ushr-calculator-urdu/">عشر کیلکولیٹر</a> (ushr calculator in Urdu)</li>
<li><a href="/qurbani-calculator-urdu/">قربانی کیلکولیٹر</a> (qurbani calculator in Urdu)</li>
<li><a href="/iddat-calculator-urdu/">عدت کیلکولیٹر</a> (iddat calculator in Urdu)</li>
</ul>
<h2>Which tool should I use?</h2>
<ul>
<li><strong>A salaried person or family with savings and gold:</strong> start with the <a href="/">main calculator</a> and choose your madhab. Add family members to calculate each person's zakat separately.</li>
<li><strong>Only gold or jewellery:</strong> the <a href="/zakat-on-gold-calculator/">zakat on gold calculator</a> takes tola, gram or ounce and the karat (24K, 22K, 21K, 18K).</li>
<li><strong>A shopkeeper or trader:</strong> the <a href="/business-zakat-calculator/">business zakat calculator</a> values stock at selling price, adds money customers owe you and subtracts supplier bills.</li>
<li><strong>In Pakistan, with a savings account:</strong> the <a href="/zakat-calculator-pakistan/">Pakistan calculator</a> handles committees (BC), prize bonds and the bank's 1 Ramadan deduction.</li>
<li><strong>Before Eid:</strong> the <a href="/fitrana-calculator/">fitrana calculator</a> works out sadaqat al-fitr for every person in the house, and the <a href="/fidya-kaffara-calculator/">fidya and kaffara calculator</a> covers missed or broken fasts.</li>
<li><strong>Not sure when your zakat is due, or missed some years:</strong> the <a href="/zakat-date-calculator/">zakat date calculator</a>.</li>
<li><strong>Farmers and livestock owners:</strong> the <a href="/ushr-calculator/">ushr and livestock calculator</a>, with guides on <a href="/ushr-on-crops/">ushr on crops</a> and <a href="/zakat-on-livestock/">zakat on goats, cows and buffaloes</a>.</li>
<li><strong>Fiqh-e-Jafaria:</strong> the <a href="/khums-calculator/">khums calculator</a> for the yearly surplus, next to the <a href="/shia-zakat-calculator/">Shia zakat calculator</a>.</li>
<li><strong>Before a nikah:</strong> the <a href="/haq-mehr-calculator/">haq mehr calculator</a> turns Mehr-e-Fatimi and the minimum mehr into today's money.</li>
<li><strong>Before Eid al-Adha:</strong> the <a href="/qurbani-calculator/">qurbani calculator</a> checks whether qurbani is wajib on you, counting spare things beyond your needs.</li>
<li><strong>After a divorce, khula or a husband's death:</strong> the <a href="/iddat-calculator/">iddat calculator</a> gives the date the iddat ends for your madhab.</li>
<li><strong>Lawyers and families in a diyat case:</strong> the <a href="/diyat-calculator/">diyat calculator</a> shows the amount notified for the year and its value at today's silver rate.</li>
<li><strong>After a death in the family:</strong> the <a href="/wirasat-calculator/">wirasat calculator</a> divides cash, land and gold among the heirs by your madhab, compares all six madhabs and draws a shajra you can download. Our guides explain the <a href="/daughters-share-in-inheritance/">daughter's share</a>, the <a href="/wife-husband-share-in-inheritance/">wife's and husband's share</a>, <a href="/orphaned-grandchildren-inheritance/">orphaned grandchildren</a> and <a href="/zakat-on-inherited-wealth/">zakat on inherited wealth</a>.</li>
</ul>
<p>Every tool runs in your browser, so nothing you enter is sent to us, and each one can produce a short PDF of your own figures for your records.</p>
[myzt_faq]
HTML
		. $author,
		'faq'   => array(
			array( 'q' => 'Are these zakat calculators free?', 'a' => 'Yes, all of them, with no sign-up.' ),
			array( 'q' => 'Which gold rate do the calculators use?', 'a' => 'The international spot price, refreshed every hour. You can enter your own local rate instead.' ),
			array( 'q' => 'Do the calculators work outside Pakistan?', 'a' => 'Yes. They support about 50 currencies, and grams and ounces as well as tola.' ),
			array( 'q' => 'Kya yeh zakat calculator muft hain?', 'a' => 'Ji haan, sab calculator bilkul muft hain aur koi sign-up nahi. Sab hisab aap ke browser mein hota hai, aap ke figures hamein nahi bheje jate.' ),
			array( 'q' => 'Urdu mein zakat calculator kahan hai?', 'a' => 'Is safhe par "Calculators in Urdu" ki list mein: zakat, sona, nisab, fitrana, haq mehr, wirasat, fidya aur kaffara, diyat, khums, ushr, qurbani aur iddat ke Urdu safhe.' ),
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
<p>Made for Pakistan: amounts in rupees with lakh formatting, gold and silver in tola, and fields for committees, prize bonds and plots. The calculator starts with Hanafi fiqh (Deobandi and Barelvi); you can switch to Ahl-e-Hadith or Shia. Outside Pakistan, use the <a href="/hanafi-zakat-calculator/">Hanafi calculator</a> or the <a href="/">main calculator</a>, which pick your currency automatically.</p>
[zakat_calculator madhab="hanafi"]
[myzt_answer q="Zakat in Pakistan this year:"]Today 1 tola of 24K gold is about [myzt_rate type="gold-tola" currency="PKR"] and the silver nisab (52.5 tola) is about [myzt_rate type="nisab-silver" currency="PKR"] at international rates. If your total wealth is above that for a lunar year, zakat is 2.5%.[/myzt_answer]
<p><strong>The zakat rate in Pakistan is 2.5% (1/40),</strong> the same as everywhere: Rs 2,500 on every Rs 1 lakh of zakatable wealth. Banks deduct the same 2.5% on 1 Ramadan. The figures for Ramadan 2027 are collected on <a href="/zakat-2027-pakistan/">zakat 2027 Pakistan</a> as they are announced.</p>
<h2>What to include in Pakistan</h2>
<ul>
<li><strong>Committee (BC):</strong> the amount you have paid in so far is your money and is zakatable. Once you receive the committee, count what is left of it.</li>
<li><strong>Prize bonds and savings certificates (NSC, Behbood, DSC):</strong> enter savings certificates at the amount you invested in the "Savings certificates" field, and prize bonds at their face value in the "Prize bonds" field. If zakat was deducted from them, enter it under "Already paid". See <a href="/zakat-on-savings-certificates/">zakat on savings certificates</a>.</li>
<li><strong>Plots:</strong> a plot bought to sell is trade goods; count its market value. A house or plot for your own use has no zakat.</li>
<li><strong>Gold:</strong> local jewellery is usually 21K or 22K; choose the karat so only the pure gold is counted.</li>
</ul>
<h2>Bank deduction on 1 Ramadan</h2>
<p>Under Pakistan's zakat law, banks deduct 2.5% from savings accounts whose balance is at or above the government's nisab on 1 Ramadan. Current accounts are not deducted. People who are exempt on grounds of fiqh can submit a CZ-50 declaration to their bank before Ramadan. Read the <a href="/bank-zakat-deduction-pakistan/">bank zakat deduction guide</a>.</p>
[myzt_official type="bank-nisab"]
<h2>Zakat kis par farz hai?</h2>
<p>Hanafi fiqh mein zakat har us aqil, baligh Muslim par farz hai jo zaroorat se zyada maal ka malik ho, woh maal nisab (52.5 tola chandi ki qeemat, aaj taqreeban [myzt_rate type="nisab-silver" currency="PKR"]) ke barabar ya us se zyada ho, aur us par aik qamri saal guzar jaye. Ghar, sawari, kapre, ghar ka saman aur kaam ke auzaar is mein nahi gine jate. Jo qarz abhi ada karna hai woh pehle minus hota hai. Shafi'i, Maliki, Hanbali aur Ahl-e-Hadith ulama bache aur deewane ke maal par bhi zakat wajib kehte hain, jo un ka wali ada karta hai.</p>
<h2>International rate vs. sarafa rate</h2>
<p>The calculator uses the international gold rate converted to rupees. The local sarafa rate can be a little higher or lower; if you want to use it, tick <em>Use my own local rate</em>.</p>
<h2>Zakat kaise nikalein: 5 steps</h2>
<ol>
<li><strong>Apni zakat ki tareekh tay karein.</strong> Zakat us din farz hoti hai jab aapke maal ko nisab tak pohanche aik qamri saal ho jaye. Bohat se log 1 Ramazan rakhte hain; apni tareekh ke liye <a href="/zakat-date-calculator/">zakat date calculator</a> dekhein.</li>
<li><strong>Us din sab kuch likhein:</strong> ghar ki naqdi, har bank account, sona aur chandi (tola aur karat ke saath), committee mein jama raqam, prize bonds, savings certificates, shares, bechne ke liye plot aur karobari maal.</li>
<li><strong>Jo qarz abhi ada karna hai</strong> (is mahine ka kiraya, bill, qist) Hanafi fiqh mein minus karein.</li>
<li><strong>Nisab se muqabla karein.</strong> Hanafi fiqh mein naqdi aur mile jule maal ke liye chandi ka nisab (52.5 tola) hai, jo aaj taqreeban [myzt_rate type="nisab-silver" currency="PKR"] hai.</li>
<li><strong>Kul ka 2.5% ada karein,</strong> aur bank ne 1 Ramazan ko jo kaata ho woh <em>Already paid</em> mein likh kar minus kar dein.</li>
</ol>
<h2>Gold in tola and grams</h2>
<figure class="wp-block-table"><table><thead><tr><th>Tola</th><th>Grams</th><th>Pure gold in 22K</th></tr></thead><tbody>
<tr><td>1</td><td>11.66 g</td><td>10.69 g</td></tr>
<tr><td>5</td><td>58.32 g</td><td>53.46 g</td></tr>
<tr><td>7.5 (gold nisab)</td><td>87.48 g</td><td>80.19 g</td></tr>
<tr><td>10</td><td>116.64 g</td><td>106.92 g</td></tr>
</tbody></table></figure>
<p>Jewellers in Pakistan also sell by masha and ratti: 1 tola = 12 masha = 96 ratti. Only the pure gold counts, so choose 22K or 21K in the calculator rather than entering the weight as 24K. For the full picture see <a href="/zakat-on-1-tola-gold/">zakat on 1 tola gold</a> and <a href="/zakat-on-jewellery/">zakat on jewellery</a>.</p>
<h2>Who receives your zakat</h2>
<p>Zakat goes to the eight groups named in Surah at-Tawbah (9:60), mainly the poor and the needy. It cannot go to your own parents, grandparents, children or grandchildren, and a husband cannot give his zakat to his wife. Brothers, sisters and other relatives who are eligible may receive it, with double reward. See <a href="/who-can-receive-zakat/">who can receive zakat</a>.</p>
[myzt_faq]
HTML
		. $author . '[myzt_related slugs="hanafi-zakat-calculator,zakat-on-gold-calculator,fitrana-calculator,bank-zakat-deduction-pakistan"]',
		'faq'   => array(
			array( 'q' => 'Committee ke paison par zakat hai?', 'a' => 'Haan, committee mein jitni raqam aap jama kara chuke hain wo aap ki milkiyat hai aur us par zakat hai.' ),
			array( 'q' => 'Is zakat due on a plot in Pakistan?', 'a' => 'Only if it was bought with the intention to sell. Then its current market value is zakatable. A plot or house for living has no zakat.' ),
			array( 'q' => 'Does the bank deduction count as my zakat?', 'a' => 'Calculate your full zakat and subtract what the bank has already deducted. Ask your scholar about your case.' ),
			array( 'q' => 'Zakat kis par farz hai?', 'a' => 'Hanafi fiqh mein har aqil baligh Muslim par jis ke paas zaroorat se zyada maal nisab ke barabar ya us se zyada ho aur us par aik qamri saal guzar jaye. Shafi\'i, Maliki, Hanbali aur Ahl-e-Hadith ke nazdeek bachon aur deewanon ke maal par bhi zakat hai, jo un ka wali ada karta hai. Fiqh-e-Jafari (Sistani) mein bache ke sone, chandi aur naqdi par zakat nahi.' ),
			array( 'q' => 'Kya yeh calculator Urdu mein hai?', 'a' => 'Haan. Calculator ke upar "اردو" dabayein, poora calculator Urdu mein ho jata hai. Raqam lakh aur crore mein dikhayi jati hai.' ),
			array( 'q' => 'Savings certificates (NSC, Behbood) par zakat kaise lagegi?', 'a' => 'Jitni raqam lagayi hai usay "Savings certificates" field mein likhein. Agar un se zakat kat chuki hai to woh "Already paid" mein likhein.' ),
		),
	);

	$p['zakat-2027-pakistan'] = array(
		'title' => 'Zakat 2027 Pakistan: Dates, Nisab and Fitrana',
		'seo'   => 'Zakat 2027 Pakistan: Bank Deduction, CZ-50, Nisab, Fitrana',
		'desc'  => 'Ramadan 2027 in Pakistan: bank zakat deduction on 1 Ramadan (about 8 Feb), CZ-50 deadline, when the nisab and fitrana are announced, and last year\'s figures.',
		'nav'   => 'Zakat 2027 Pakistan',
		'blurb' => 'dates & updates',
		'hub'   => 'calculators',
		'llms'  => true,
		'content' => <<<'HTML'
[myzt_answer q="When is zakat deducted in Pakistan in 2027?"]Banks will deduct 2.5% zakat from savings accounts on 1 Ramadan 1448, expected around 8 February 2027 depending on the moon. The government notifies the deduction nisab a few days before; in 2026 it was Rs 5,03,529. File a CZ-50 before Ramadan if your fiqh exempts you.[/myzt_answer]
<p>This page collects every zakat date and figure that matters in Pakistan for Ramadan 2027, with last year's numbers until the new ones are announced. <strong>We update it on announcement day</strong>: the bank nisab, the fitrana and fidya amounts and any change to the CZ-50 process are added here, and on the pages that use them, within hours of the official notice.</p>
<h2>Key dates for Ramadan 2027</h2>
<figure class="wp-block-table"><table><thead><tr><th>What</th><th>When (expected)</th><th>Last year</th></tr></thead><tbody>
<tr><td>CZ-50 declaration to your bank</td><td>Before 1 Ramadan; file in December or early January</td><td>Banks asked for it in the weeks before 19 February 2026</td></tr>
<tr><td>Fitrana and fidya amounts (Council of Islamic Ideology)</td><td>Late January or early February 2027</td><td>Announced 9 February 2026</td></tr>
<tr><td>Bank deduction nisab notified</td><td>A few days before 1 Ramadan</td><td>Notified 16 February 2026: Rs 5,03,529</td></tr>
<tr><td>1 Ramadan: zakat deducted from savings accounts</td><td>About 8 February 2027 (moon sighting)</td><td>19 or 20 February 2026</td></tr>
<tr><td>Fitrana due, before the Eid prayer</td><td>Eid al-Fitr, about 9 or 10 March 2027</td><td>March 2026</td></tr>
<tr><td>Diyat for the new fiscal year</td><td>From 1 July 2027</td><td>Rs 1,93,52,390 from 1 July 2026</td></tr>
</tbody></table></figure>
<p>Islamic dates depend on the sighting of the moon, so a day either way is normal. The Gregorian dates above are estimates from the lunar calendar.</p>
<h2>Official figures: latest announced</h2>
[myzt_official type="bank-nisab"]
[myzt_official type="fitrana"]
[myzt_official type="diyat"]
<h2>Bank deduction nisab in past years</h2>
[myzt_history type="bank-nisab"]
<p>The figure rose almost three times in 2026 because the silver price did. If silver stays where it is, the 2027 figure will be close to 52.5 tola of silver at the rate on the day it is set; the live value of that is about [myzt_rate type="nisab-silver" currency="PKR"] today. This is our estimate, not an official figure.</p>
<h2>What to do before Ramadan 2027</h2>
<ol>
<li><strong>Fix your zakat date.</strong> Many people use 1 Ramadan; if yours is different, the <a href="/zakat-date-calculator/">zakat date calculator</a> finds it.</li>
<li><strong>Decide about the bank deduction.</strong> If your fiqh exempts you, file CZ-50 in time; read <a href="/bank-zakat-deduction-pakistan/">bank zakat deduction and CZ-50</a>. If you would rather pay yourself, keep long-term savings in a current account.</li>
<li><strong>List your wealth on that date</strong> and work out the full amount with the <a href="/zakat-calculator-pakistan/">Pakistan zakat calculator</a>, then subtract what the bank deducted.</li>
<li><strong>Check today's nisab</strong> on <a href="/nisab/">nisab today</a>; it is not the same as the bank's figure.</li>
<li><strong>Prepare fitrana</strong> for each person in the house with the <a href="/fitrana-calculator/">fitrana calculator</a>, and fidya or kaffara with the <a href="/fidya-kaffara-calculator/">fidya calculator</a>.</li>
<li><strong>Choose who receives it:</strong> see <a href="/who-can-receive-zakat/">who can receive zakat</a>.</li>
</ol>
<h2>Fitrana 2027</h2>
<p>The fitrana for Ramadan 1448 has not been announced yet. Last year the Council of Islamic Ideology gave Rs 300 per person by wheat and Rs 1,600 by dates; in 2025 it was Rs 220 by wheat. Older years are on the <a href="/fitrana-calculator/">fitrana page</a>. When the 2027 amounts are out, the calculator switches to them on the same day.</p>
<p>The figures here come from official notices and their reports in the press, linked in each box. This page is for information; it is not a fatwa and not legal advice.</p>
[myzt_faq]
HTML
		. $author . '[myzt_related slugs="bank-zakat-deduction-pakistan,zakat-calculator-pakistan,fitrana-calculator,nisab"]',
		'faq'   => array(
			array( 'q' => 'Zakat 2027 mein bank kab kaatega?', 'a' => '1 Ramazan 1448 ko, jo chand ke mutabiq taqreeban 8 February 2027 ko hoga. Bank sirf savings aur munafa wale accounts se 2.5% kaat-ta hai jin mein hukoomat ke nisab ke barabar ya zyada raqam ho.' ),
			array( 'q' => 'What is the zakat nisab for 2027 in Pakistan?', 'a' => 'It has not been announced yet. It is usually notified a few days before 1 Ramadan. For 2026 it was Rs 5,03,529; we add the 2027 figure here on the day it is notified.' ),
			array( 'q' => 'Fitrana 2027 kitna hai?', 'a' => 'Abhi elaan nahi hua. 2026 mein Islami Nazriati Council ne gandum ke hisab se Rs 300 aur khajoor ke hisab se Rs 1,600 fi kas diya tha.' ),
			array( 'q' => 'When should I submit the CZ-50 form for 2027?', 'a' => 'Before 1 Ramadan 1448 (about 8 February 2027), and better in December or early January so the bank can mark your account. Ask your branch for its cut-off date.' ),
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
[myzt_answer q="How do you calculate zakat on gold?"]Work out the pure gold (weight × karat ÷ 24), value it at today's 24K rate of about [myzt_rate type="gold-gram" currency="PKR"] a gram, add your other zakatable wealth and, if the total reaches the nisab, pay 2.5%. Whether worn jewellery is counted depends on your madhab.[/myzt_answer]
<p><strong>Rates of [myzt_rate_date].</strong> Tap <strong>Gold</strong> in the calculator, enter the weight in grams, tola or ounces and choose the karat. Only want the figure for 1 tola? See <a href="/zakat-on-1-tola-gold/">zakat on 1 tola gold</a>, which has a table from 1 to 50 tola.</p>
[zakat_calculator]
<h2>How to calculate zakat on gold, step by step</h2>
<ol>
<li><strong>Weigh it.</strong> Use grams or tola (1 tola = 11.664 g). A jeweller's receipt often gives the weight; if not, any jeweller can weigh it.</li>
<li><strong>Find the pure gold:</strong> weight × karat ÷ 24. For example 10 g of 22K gold contains 9.17 g of pure gold, and 10 g of 18K contains 7.5 g.</li>
<li><strong>Multiply by today's 24K price per gram,</strong> about [myzt_rate type="gold-gram" currency="PKR"] at the international rate.</li>
<li><strong>Add it to your other zakatable wealth</strong> (cash, savings, silver, business stock) and check the nisab.</li>
<li><strong>Pay 2.5%</strong> of the total, once a lunar year has passed.</li>
</ol>
<h2>Worked example in grams</h2>
<p>Sara owns a 22K necklace of 40 g and 21K bangles of 30 g, and has Rs 3,00,000 in savings. Pure gold: 40 × 22 ÷ 24 = 36.67 g and 30 × 21 ÷ 24 = 26.25 g, so 62.92 g of pure gold. At an example price of Rs 37,000 a gram that is Rs 23,28,040. With her savings the total is Rs 26,28,040, well above the silver nisab, so in the Hanafi madhab her zakat is 2.5% = <strong>Rs 65,701</strong>. If she follows the Shafi'i, Maliki or Hanbali madhab and wears this jewellery, it is exempt, and only the savings are checked against the nisab. Put your own weights in the calculator above for today's figure.</p>
<h2>Karat, purity and today's price</h2>
[myzt_karat_table currency="PKR"]
<p>Gold coins and bars are usually 24K (99.9%). Pakistani jewellery is mostly 21K or 22K, Gulf jewellery 21K or 22K, and much Western jewellery 18K or 14K. If you do not know the karat, a jeweller can test it; the hallmark stamped inside (916 for 22K, 875 for 21K, 750 for 18K) also tells you.</p>
<h2>Gold nisab</h2>
<p>The nisab of gold is 87.48 g (7.5 tola), about [myzt_rate type="nisab-gold" currency="PKR"] today. If you own only gold and nothing else, zakat is due only when your pure gold reaches this weight. If you also have cash or silver, Hanafi scholars add everything together and use the silver nisab.</p>
<h2>Worn jewellery</h2>
<p>Hanafi and Ahl-e-Hadith: zakatable. Shafi'i, Maliki and Hanbali: exempt if permissible and worn. See <a href="/zakat-on-jewellery/">zakat on jewellery in the 4 madhabs</a>.</p>
<h2>Whose gold is it?</h2>
<p>Zakat is due from the owner. Jewellery a woman received at her wedding from her own family, or as mehr, is usually hers, so its zakat is on her; she may pay it from her own money, or her husband may pay it for her with her permission. Gold a family keeps for a daughter's future wedding is owned by whoever has not yet given it away, usually the parents. If ownership is unclear, settle it in the family first, then calculate.</p>
<h2>Inherited gold</h2>
<p>Gold you inherit is counted like gold you bought, from the time your share is yours; see <a href="/zakat-on-inherited-wealth/">zakat on inherited wealth</a> for when the zakat year starts. If the estate is not divided yet, the <a href="/wirasat-calculator/">wirasat calculator</a> shows each heir's share of the gold in tola and grams.</p>
[myzt_faq]
HTML
		. $author . '[myzt_related slugs="gold-rate-today,nisab,zakat-on-jewellery,zakat-on-1-tola-gold"]',
		'faq'   => array(
			array( 'q' => 'How do I calculate zakat on gold in grams?', 'a' => 'Multiply the weight in grams by the karat and divide by 24 to get pure gold, multiply by today\'s 24K price per gram, and take 2.5% if your total wealth is above the nisab.' ),
			array( 'q' => 'Sone ki zakat kaise nikalein?', 'a' => 'Sone ka wazan karat se zarb de kar 24 par taqseem karein, phir aaj ke 24 karat rate se qeemat nikalein, baqi maal ke saath jorein aur nisab poora ho to 2.5% ada karein.' ),
			array( 'q' => 'Is zakat calculated on the purchase price or today\'s price?', 'a' => "On today's market value on the day your zakat year completes, not the price you paid." ),
			array( 'q' => 'Do I count stones and making charges?', 'a' => 'No. Only the weight of pure gold is counted, at the gold rate.' ),
		),
	);

	$p['business-zakat-calculator'] = array(
		'title' => 'Business Zakat Calculator',
		'seo'   => 'Business Zakat Calculator {year}: Stock, Cash, Receivables',
		'desc'  => 'Calculate zakat on a business: stock at sale value, business cash and money owed by customers, minus supplier bills. Every madhab, with a PDF report.',
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
<li><strong>Supplier bills:</strong> subtracted in the Hanafi, Maliki and Hanbali calculations, not in the Shafi'i or Ahl-e-Hadith ones.</li>
</ul>
<h2>Worked example: a cloth shop</h2>
<p>Bilal owns a cloth shop in Lahore. On his zakat date:</p>
<figure class="wp-block-table"><table><thead><tr><th>Item</th><th>Amount</th><th>Counted?</th></tr></thead><tbody>
<tr><td>Stock at today's selling price</td><td>Rs 12,00,000</td><td>Yes</td></tr>
<tr><td>Cash in the till and business bank account</td><td>Rs 3,00,000</td><td>Yes</td></tr>
<tr><td>Customers who will pay (udhaar)</td><td>Rs 2,00,000</td><td>Yes</td></tr>
<tr><td>A customer who has stopped paying</td><td>Rs 50,000</td><td>No, until received</td></tr>
<tr><td>Shop fittings, sewing machines, delivery van</td><td>Rs 8,00,000</td><td>No (fixed assets)</td></tr>
<tr><td>Supplier bills due now</td><td>Rs 4,00,000</td><td>Subtracted where the madhab allows</td></tr>
</tbody></table></figure>
<ul>
<li><strong>Hanafi, Maliki and Hanbali:</strong> Rs 12,00,000 + Rs 3,00,000 + Rs 2,00,000 − Rs 4,00,000 = Rs 13,00,000. Zakat is 2.5% = <strong>Rs 32,500</strong>.</li>
<li><strong>Shafi'i and Ahl-e-Hadith:</strong> the supplier bills are not subtracted, so 2.5% of Rs 17,00,000 = <strong>Rs 42,500</strong>.</li>
</ul>
<p>If the Rs 50,000 is recovered later, Bilal pays zakat on it then. Any personal savings and gold go in the same calculation, as zakat is worked out on everything a person owns.</p>
<h2>Valuing stock</h2>
<ul>
<li><strong>Finished goods:</strong> the price you would sell them at on the zakat date. A wholesaler uses the wholesale price, a retailer the retail price; many scholars accept the price you could sell the whole stock for in one go.</li>
<li><strong>Raw materials</strong> that will become goods for sale are counted. Materials used up in running the business (fuel, cleaning supplies) are not.</li>
<li><strong>Old or damaged stock</strong> is counted at what it would really fetch, which may be far below cost.</li>
<li><strong>Online sellers:</strong> stock held in a warehouse or with a fulfilment service is still yours and is counted. Money held by a marketplace that will be paid out to you is a receivable.</li>
</ul>
<h2>Partnerships and companies</h2>
<p>In a partnership each partner pays zakat on their own share of the stock, cash and receivables, minus their share of the business debts where their madhab allows it. A partner who cannot get exact figures can estimate from the latest accounts. For shares in a listed company, enter the market value of shares you hold to sell; shares held long term for dividends are a separate question, so ask your scholar. A sole trader simply adds the business figures to their personal ones.</p>
<h2>Keep your records year to year</h2>
<p>Use <em>Save data file</em> to keep your figures on your own device and open them next year. Nothing is stored on our server. Pick a fixed zakat date, such as 1 Ramadan, and take stock on the same date every year; the <a href="/zakat-date-calculator/">zakat date calculator</a> can remind you. Animals bought to sell are trade goods too; animals kept for breeding and grazing are covered by the <a href="/ushr-calculator/">livestock calculator</a>.</p>
[myzt_faq]
HTML
		. $author . '[myzt_related slugs="madhab-comparison,maliki-zakat-calculator,zakat-date-calculator,zakat-calculator-pakistan"]',
		'faq'   => array(
			array( 'q' => 'Is zakat due on shop equipment?', 'a' => 'No. Fixed assets used to run the business are not zakatable; only stock for sale, cash and receivables are.' ),
			array( 'q' => 'Should stock be valued at cost or sale price?', 'a' => 'Most scholars say at its current market (selling) value on the zakat date.' ),
			array( 'q' => 'Karobar ki zakat kaise nikalein?', 'a' => 'Zakat ki tareekh par dukaan ka maal bechne wali qeemat par, karobari naqdi aur jo udhaar wapas milne ki umeed hai, sab jorein. Hanafi, Maliki aur Hanbali maslak mein supplier ke bill minus karein. Phir kul ka 2.5% ada karein. Dukaan, machinery aur gaari par zakat nahi.' ),
			array( 'q' => 'Is zakat due on money customers owe me?', 'a' => 'Yes, on money you expect to receive. Debts that are unlikely to be paid are left out until they are actually received.' ),
		),
	);

	$p['fitrana-calculator'] = array(
		'title' => 'Fitrana Calculator (Zakat al-Fitr)',
		'seo'   => 'Fitrana Calculator {fyear}: Sadqa-e-Fitr per Person',
		'desc'  => 'Calculate fitrana (sadaqat al-fitr) for your family: number of people times the amount for wheat, barley, dates or raisins. Who must pay and when.',
		'nav'   => 'Fitrana',
		'blurb' => 'per person',
		'hub'   => 'calculators',
		'llms'  => true,
		'content' => <<<'HTML'
[myzt_answer q="How much is fitrana?"]Fitrana is paid for every member of the family before the Eid prayer. In Hanafi fiqh it is half a sa' of wheat (about 1.75 to 2 kg) or one sa' of barley, dates or raisins (about 4 kg), or their value. Scholars announce the amount in money each Ramadan.[/myzt_answer]
<p>This fitrana calculator, which also works as a zakat al fitr calculator or fitr calculator for sadaqat al-fitr (sadqa-e-fitr in Urdu), multiplies the number of people in your house by the amount for the item you choose.</p>
[zakat_fitrana]
[myzt_official type="fitrana"]
<h2>Who must pay fitrana?</h2>
<p>In Hanafi fiqh, which the amounts above follow, fitrana is wajib on every Muslim (Bukhari 1503) who at dawn on Eid day owns wealth equal to the nisab over and above basic needs and debts. This wealth does not need to have been held for a year or be zakatable wealth (<em>al-Hidayah</em>, Sadaqat al-Fitr). The person pays for himself and his young children; many also pay for their wife and other dependants. The Shafi'i, Maliki and Hanbali schools set a lower bar: anyone who has more than the food the family needs for the day and night of Eid pays. The same Hanafi test, wealth beyond needs equal to the nisab, also decides whether qurbani is wajib on you: the <a href="/qurbani-calculator/">qurbani calculator</a> checks it at today's rate.</p>
<h2>When to pay</h2>
<p>Before the Eid prayer, so that the poor can celebrate Eid; the Prophet ﷺ called it a purification for the fasting person and food for the poor, accepted as fitrana when paid before the prayer (Abu Dawud 1609). Paying it during Ramadan is allowed and makes it easier to reach people in need.</p>
<h2>Which item to choose</h2>
<p>You may pay the value of any of the four items. Those who can afford it are encouraged to pay by the more expensive items (dates or raisins), as this gives more to the poor.</p>
<h2>Worked example: a family of five</h2>
<p>For Ramadan 1447 (February 2026) the Council of Islamic Ideology, Pakistan, gave minimum amounts per person of Rs 300 by wheat and Rs 1,600 by dates. A father paying for himself, his wife and three children pays:</p>
<ul>
<li><strong>By wheat:</strong> 5 × Rs 300 = Rs 1,500.</li>
<li><strong>By dates:</strong> 5 × Rs 1,600 = Rs 8,000.</li>
</ul>
<p>A baby born before dawn on Eid day is counted; a baby born after dawn is not. The amounts for Ramadan 2027 will be added to the calculator when they are announced; until then, enter the price where you live.</p>
<h2>For whom you pay</h2>
<ul>
<li><strong>Yourself and your young children:</strong> the head of the house pays for them. If a child has wealth of their own, it can be paid from that.</li>
<li><strong>Wife and adult children:</strong> in the Hanafi view each pays for themselves, but it is valid and common for the husband or father to pay for them with their permission. The other schools make the husband responsible for his wife.</li>
<li><strong>Others:</strong> you may pay for anyone else, such as a parent, with their permission.</li>
</ul>
<h2>Who receives fitrana</h2>
<p>Fitrana goes to the same people as zakat, mainly the poor and the needy. It cannot be given to your own parents, grandparents, children or grandchildren, and a husband and wife cannot give it to each other. Giving it to poor relatives such as brothers, sisters, uncles and aunts is allowed and rewarded twice. Several people's fitrana may go to one family. See <a href="/who-can-receive-zakat/">who can receive zakat</a>.</p>
<h2>Fitrana in past years</h2>
<p>The minimum amounts per person announced in Pakistan, with the source for each year. Searching for "fitrana 2025" or "fitrana 2024"? These are the figures from those years. Pay this year's amount, not an old one: the price of wheat and dates changes every year.</p>
[myzt_history type="fitrana"]
<p>We list only the years we could check against a published announcement. Fitrana for Ramadan 2027 will be added on the day the Council announces it; see <a href="/zakat-2027-pakistan/">zakat 2027 Pakistan</a>.</p>
<h2>Fitrana and zakat are different</h2>
<p>Fitrana is a fixed amount per person, due once a year at Eid, on wealth that does not need a year to pass. Zakat is 2.5% of your zakatable wealth, due on your own zakat date. Paying one does not replace the other; for zakat use the <a href="/">zakat calculator</a>.</p>
<p>Missed fasts you cannot make up, or a fast broken on purpose? Use the <a href="/fidya-kaffara-calculator/">fidya and kaffara calculator</a>, or read <a href="/roza-fidya/">who pays roza fidya and how much</a> and <a href="/kaffara-for-breaking-a-fast/">kaffara for breaking a fast</a>. In Urdu: <a href="/fitrana-calculator-urdu/">فطرانہ کیلکولیٹر</a>.</p>
[myzt_faq]
HTML
		. $author . '[myzt_related slugs="who-can-receive-zakat,zakat-calculator-pakistan,khums-calculator,home"]',
		'faq'   => array(
			array( 'q' => 'Fitrana kis par wajib hai?', 'a' => 'Hanafi fiqh mein har us Muslim par jo Eid ki subah (fajr ke waqt) bunyadi zarooraton aur qarz ke ilawa nisab ke barabar maal ka malik ho; is maal par saal guzarna zaroori nahi. Wo apni aur apne chhote bachon ki taraf se ada karta hai. Shafi\'i, Maliki aur Hanbali maslak mein jis ke paas Eid ke din aur raat ke khane se zyada ho, us par wajib hai.' ),
			array( 'q' => 'Can fitrana be paid in money?', 'a' => 'Yes, in the Hanafi madhab paying the value in money is allowed and common.' ),
			array( 'q' => 'Can fitrana be paid after Eid?', 'a' => 'It should be paid before the Eid prayer. If it was missed, it is still owed and should be paid as soon as possible.' ),
			array( 'q' => 'What was the fitrana amount in 2025?', 'a' => 'For Ramadan 1446 (2025) the Council of Islamic Ideology gave a minimum of Rs 220 per person by wheat, Rs 450 by barley, Rs 1,650 by dates and Rs 2,500 by raisins. In 2026 it was Rs 300 by wheat and Rs 1,600 by dates.' ),
			array( 'q' => 'Fitrana 2027 kitna hai?', 'a' => 'Ramazan 1448 (2027) ka fitrana abhi elaan nahi hua. Islami Nazriati Council aam tor par Ramazan ke shuru mein elaan karti hai; hum usi din yahan likh denge. Tab tak 2026 ki raqam Rs 300 (gandum) aur Rs 1,600 (khajoor) thi.' ),
		),
	);

	$p['fidya-kaffara-calculator'] = array(
		'title' => 'Fidya and Kaffara Calculator',
		'seo'   => 'Fidya Calculator {fyear}: Roza Fidya & Kaffara in Rupees',
		'desc'  => 'Work out fidya for fasts you cannot make up and kaffara for a fast broken on purpose: number of fasts times the daily amount, with the Hanafi rules explained.',
		'nav'   => 'Fidya & Kaffara',
		'blurb' => 'roza fidya',
		'hub'   => 'calculators',
		'llms'  => true,
		'content' => <<<'HTML'
[myzt_answer q="How much is fidya for one fast?"]In the Hanafi madhab the fidya for one missed fast is the same as one fitrana: half a sa' of wheat (about 1.75 to 2 kg) or its value, given to a poor person. Kaffara for a fast broken on purpose is fasting 60 days in a row, or, for someone who cannot, feeding 60 poor people, which is 60 times that amount.[/myzt_answer]
<p>Use it as a fidya calculator for missed fasts or as a kaffara (kaffarah) calculator for a fast broken on purpose: enter the number of fasts and the daily amount.</p>
[zakat_fidya]
[myzt_official type="fidya"]
<h2>Fidya: who pays it</h2>
<p>Fidya is for a person who cannot fast and has no hope of fasting later (Surah al-Baqarah 2:184), such as someone very old or with a long-term illness. They pay one fidya for each fast. Someone who missed fasts because of travel, a short illness, pregnancy or breastfeeding makes the fasts up later (qada) and does not pay fidya instead. If a person who could have made up their fasts dies without doing so, and left a will (wasiyyat), the fidya is paid from up to one third of what they left.</p>
<h2>Kaffara: when it is due</h2>
<p>In Hanafi fiqh kaffara is due when an adult deliberately breaks a Ramadan fast by eating, drinking or marital relations without a valid excuse. The kaffara is to fast 60 days in a row. Only a person who truly cannot do that may feed 60 poor people (Bukhari 1936, Muslim 1111) (two meals each) or give each of them the amount of one fitrana. Several fasts broken in the same Ramadan need one kaffara in the Hanafi view, as long as the first kaffara has not been paid yet. Each broken fast is also made up with one qada fast.</p>
<h2>Other schools</h2>
<p>In the Shafi'i, Maliki and Hanbali schools the fidya and each kaffara meal are one mudd of the local staple food (about 0.6 kg), which is less than the Hanafi half sa'. The Shafi'i and Hanbali schools require kaffara only for breaking the fast with marital relations; eating or drinking deliberately needs qada and repentance. Use the amount your own scholars announce.</p>
<h2>How much in rupees?</h2>
<p>Each Ramadan, the Council of Islamic Ideology and major madrasas announce fitrana and fidya amounts for wheat, barley, dates and raisins. Enter that amount above, or the price of about 2 kg of flour where you live. Pay by the more expensive items if you can afford it.</p>
<h2>Fidya for 30 fasts</h2>
<p>At the 2026 amounts of the Council of Islamic Ideology, fidya for a whole month of 30 fasts is 30 × Rs 300 = Rs 9,000 by wheat, or 30 × Rs 1,600 = Rs 48,000 by dates. In 2025 the same month was Rs 6,600 by wheat. A kaffara by feeding 60 people at Rs 300 is Rs 18,000. The fidya for 2027 follows the fitrana amount announced next Ramadan; past years are listed on the <a href="/fitrana-calculator/">fitrana calculator</a>.</p>
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

	$p['haq-mehr-calculator'] = array(
		'title' => 'Haq Mehr Calculator',
		'seo'   => 'Haq Mehr Calculator {cyear}: Mehr-e-Fatimi in Rupees Today',
		'desc'  => "Mehr-e-Fatimi and the minimum mehr in today's money from the live silver rate: grams, tola and rupees, other scholars' views, and a check for your own mehr.",
		'nav'   => 'Haq Mehr',
		'blurb' => 'mehr-e-fatimi today',
		'hub'   => 'calculators',
		'llms'  => true,
		'content' => <<<'HTML'
[myzt_answer q="How much is Mehr-e-Fatimi today?"]Mehr-e-Fatimi is 500 dirham of silver, which Pakistani and Indian muftis put at 131.25 tola or about 1,530.9 g of silver. At today's international silver rate that is about [myzt_mehr type="fatimi" currency="PKR"]. The minimum mehr in the Hanafi madhab is 10 dirham (about 30.62 g of silver), worth about [myzt_mehr type="minimum" currency="PKR"] today.[/myzt_answer]
[zakat_mehr currency="PKR"]
<h2>What is haq mehr?</h2>
<p>Mehr (mahr) is the money or property a husband gives his wife because of the nikah. The Qur'an calls it her right and a gift: "And give the women their mahr as a free gift" (al-Nisa 4:4). It belongs to the wife alone, not to her father or family, and she may spend it as she likes. It is written in the nikah nama, which has separate columns for the amount, the part that is paid at once (mu'ajjal) and the part that is deferred (muwajjal), and anything given at the time of the nikah.</p>
<h2>Why is mehr measured in silver?</h2>
<p>The amounts in the hadith and the books of fiqh are in dirhams, the silver coins of the time. A dirham is a fixed weight of silver, so the mehr keeps its value while the rupee loses value. That is why muftis tell people to work out Mehr-e-Fatimi and the minimum mehr from the silver price on the day of the nikah, not from an old rupee figure. The calculator above does this with the live international silver rate, which is refreshed every hour. Local sarafa prices are usually a little higher, so you may enter your own amount if you prefer the bazaar rate.</p>
<h2>Mehr-e-Fatimi: the sources and the different views</h2>
<p>Mehr-e-Fatimi is the mehr the Prophet (peace be upon him) gave for his daughter Fatimah (may Allah be pleased with her). Sayyidah Aisha said the mehr he gave his wives was twelve and a half uqiyah, which is 500 dirham (Sahih Muslim 1426). Sayyiduna Umar said it was not more than twelve uqiyah, or 480 dirham (Sunan Abu Dawud 2106, Jami' al-Tirmidhi 1114). Because of this, scholars give more than one figure:</p>
<ul>
<li><strong>500 dirham, 131.25 tola, about 1,530.9 g of silver.</strong> The figure given by Mufti Muhammad Shafi and preferred in many Pakistani fatwas. The calculator uses it by default.</li>
<li><strong>480 dirham, about 1,469.7 g.</strong> Based on the narration of Sayyiduna Umar.</li>
<li><strong>400 dirham, about 1,224.7 g.</strong> The view reported from Ibn al-Humam.</li>
</ul>
<p>Open "Other views held by scholars" under the table to see each of these in today's money. Paying Mehr-e-Fatimi is not obligatory. Many families choose it for its blessing, but any amount both sides agree on is valid, as long as it is not below the minimum of your madhab.</p>
<h2>Minimum mehr in each madhab</h2>
<ul>
<li><strong>Hanafi:</strong> 10 dirham, about 30.62 g of silver (2 tola 7.5 masha). If a smaller amount is fixed, the mehr becomes 10 dirham. Maulana Ashraf Ali Thanwi and Mufti Rasheed Ahmad Ludhianvi gave about 34 g, which the calculator also shows.</li>
<li><strong>Maliki:</strong> a quarter dinar of gold or 3 dirham of silver.</li>
<li><strong>Shafi'i and Hanbali:</strong> no fixed minimum; anything that has value may be mehr.</li>
<li><strong>Shia (Ayatollah Sistani):</strong> no fixed minimum; the mehr of the Sunnah is 500 dirham.</li>
</ul>
<h2>Is my mehr enough? Check it</h2>
<p>Type the amount written in your nikah nama in "Your agreed mehr". The calculator shows how much silver it buys today and what share of Mehr-e-Fatimi it is, and warns you if it is below the Hanafi minimum. If your mehr was fixed in gold, for example "5 tola gold", use the second box to see what it is worth today in 24K or 22K gold, or in silver.</p>
<h2>Prompt and deferred mehr</h2>
<p>Mu'ajjal (prompt) mehr is due as soon as the nikah takes place and the wife may ask for it at any time. Muwajjal (deferred) mehr is due at the time agreed, or at divorce or death. In Pakistan, section 10 of the Muslim Family Laws Ordinance 1961 says that if the nikah nama does not say how the mehr is to be paid, the whole of it is payable on demand. Unpaid mehr is a debt on the husband. If he dies before paying it, it is paid from his estate before the inheritance is divided; the <a href="/wirasat-calculator/">wirasat calculator</a> lets you enter it as a debt. The widow then also inherits her own share; see <a href="/wife-husband-share-in-inheritance/">the wife's and husband's share</a>. After a divorce or a husband's death, the <a href="/iddat-calculator/">iddat calculator</a> gives the date her iddat ends.</p>
<h2>Mehr and zakat</h2>
<p>Mehr the wife has received is her own wealth and counts towards her zakat like any other savings or gold. Many Hanafi muftis say zakat is not due on unpaid mehr until she receives it. Use the <a href="/">zakat calculator</a> for her total, and see <a href="/nisab/">today's nisab</a>.</p>
<p>This page gives figures from published fatwas and the live silver rate. It is not a fatwa; for a particular nikah, ask the imam or mufti who performs it.</p>
[myzt_faq]
HTML
		. $author . '[myzt_related slugs="haq-mehr-calculator-urdu,diyat-calculator,nisab,gold-rate-today"]',
		'faq'   => array(
			array( 'q' => 'Mehr-e-Fatimi kitna hai?', 'a' => '500 dirham chandi, yani 131.25 tola (taqreeban 1,530.9 gram). Rupees mein is ki qeemat aaj ke chandi ke rate se nikalti hai; upar calculator mein dekhein.' ),
			array( 'q' => 'Kam se kam haq mehr kitna hai?', 'a' => 'Hanafi fiqh mein 10 dirham, yani taqreeban 30.62 gram (2 tola 7.5 masha) chandi ki qeemat. Is se kam mehr tay ho to 10 dirham hi wajib hota hai.' ),
			array( 'q' => 'Is Mehr-e-Fatimi obligatory?', 'a' => 'No. It is a recommended choice for its blessing. Any amount both sides agree on is valid if it is not below the minimum of the madhab.' ),
			array( 'q' => 'Should mehr be calculated from the gold or the silver rate?', 'a' => 'Mehr-e-Fatimi and the minimum mehr are measured in dirhams, which are silver coins, so they are worked out from the silver rate. A mehr fixed in gold, such as 5 tola gold, is valued at the gold rate.' ),
			array( 'q' => 'Which silver rate does the calculator use?', 'a' => 'The international spot rate, refreshed every hour. Sarafa rates in Pakistan are often slightly higher.' ),
		),
	);

	$p['diyat-calculator'] = array(
		'title' => 'Diyat Calculator Pakistan',
		'seo'   => 'Diyat Amount 2026-27 Pakistan: Notified & Live Value',
		'desc'  => 'Diyat in Pakistan for 2026-27 is Rs 1,93,52,390, the value of 30,630 g of silver. See the live value at today\'s silver rate and every year\'s notified amount.',
		'nav'   => 'Diyat',
		'blurb' => 'blood money in Pakistan',
		'hub'   => 'calculators',
		'llms'  => true,
		'content' => <<<'HTML'
[myzt_answer q="What is the diyat amount in Pakistan?"]For the fiscal year 2026-27 the Federal Government has notified diyat at [myzt_diyat type="notified"], in force from 1 July 2026. The law fixes diyat at the value of 30,630 g of silver; at today's international silver rate that is about [myzt_diyat type="live"].[/myzt_answer]
[zakat_diyat]
[myzt_official type="diyat"]
<h2>What is diyat?</h2>
<p>Diyat is the compensation paid to the heirs of a person who has been killed. Islamic law sets it at 100 camels (the Quran orders diyat for a killing by mistake, Surah an-Nisa 4:92), or its equivalent of 1,000 dinar of gold or, in the Hanafi madhab, 10,000 dirham of silver. In Pakistan it is part of the Pakistan Penal Code (Qisas and Diyat law), and it applies in cases of qatl-i-khata (killing by mistake), qatl shibh-i-amd, and in qatl-i-amd where qisas is not enforced.</p>
<h2>How the amount is fixed</h2>
<p>Section 323 of the Pakistan Penal Code says the court fixes the diyat, but it may not be less than the value of 30,630 grams of silver. The Finance Division works out that value and notifies it for each fiscal year, from 1 July to 30 June. The silver weight never changes; only the rupee figure does, because the silver price and the rupee move. 30,630 g is very close to the classical 10,000 dirham of the Hanafi madhab (10,000 × 3.0618 g = 30,618 g).</p>
<h2>Why the amount almost doubled in 2026</h2>
<p>The notified amount was Rs 98,28,670 for 2025-26 and Rs 1,93,52,390 for 2026-27, an increase of about 97%. The reason is the price of silver, which rose sharply in the year before the notification. The table in the calculator lists every notified amount we have checked, with its source, and the live value shows where the next notification may land if silver prices stay where they are.</p>
<h2>Live value or notified amount: which one counts?</h2>
<p>For a court case, the amount notified for the year is the legal minimum. The live value on this page is for information: it shows what 30,630 g of silver is worth today at the international spot rate. Local bazaar silver rates in Pakistan are often a little higher than the spot rate.</p>
<h2>How diyat is paid and shared</h2>
<ul>
<li><strong>Instalments:</strong> under section 331 of the Penal Code diyat may be paid in a lump sum or in instalments spread over up to three years from the final judgment.</li>
<li><strong>Who receives it:</strong> the heirs of the person killed, in their shares of inheritance (see the <a href="/wirasat-calculator/">wirasat calculator</a>).</li>
<li><strong>Compromise:</strong> the heirs may forgive the diyat or agree on a different amount (badal-i-sulh) where the law allows.</li>
</ul>
<h2>Diyat in the different madhabs</h2>
<p>All schools agree on 100 camels as the basis. For gold, the figure is 1,000 dinar. For silver the Hanafi madhab gives 10,000 dirham and the Maliki and Hanbali schools 12,000 dirham; in the Shafi'i school the camels are the basis, and their value is paid when camels are not available. In Shia fiqh (Ayatollah Sistani) the options include 100 camels, 1,000 dinar or 10,000 dirham. Pakistani law follows the silver measure of 30,630 g.</p>
<p>This page explains the published figures and the law. It is not legal advice; for a case, speak to a lawyer. Related tools: the <a href="/haq-mehr-calculator/">haq mehr calculator</a>, which also uses the silver rate (in Urdu: <a href="/haq-mehr-calculator-urdu/">حق مہر کیلکولیٹر</a>), and <a href="/gold-rate-today/">today's gold and silver rate</a>.</p>
[myzt_faq]
HTML
		. $author . '[myzt_related slugs="haq-mehr-calculator,gold-rate-today,nisab,calculators"]',
		'faq'   => array(
			array( 'q' => 'Diyat ki raqam 2026-27 mein kitni hai?', 'a' => 'Wafaqi hukoomat ne maali saal 2026-27 ke liye diyat Rs 1,93,52,390 notify ki hai, jo 1 July 2026 se naafiz hai.' ),
			array( 'q' => 'How is diyat calculated in Pakistan?', 'a' => 'It is the value of 30,630 grams of silver (Pakistan Penal Code, section 323). The Finance Division notifies the rupee value every year.' ),
			array( 'q' => 'Can a court award less than the notified diyat?', 'a' => 'No. The court may award more, but not less than the notified value.' ),
			array( 'q' => 'Can diyat be paid in instalments?', 'a' => 'Yes. It may be paid in instalments over up to three years from the final judgment (section 331).' ),
			array( 'q' => 'Diyat kis ko milti hai?', 'a' => 'Maqtool ke warison ko, wirasat ke hisson ke mutabiq.' ),
		),
	);

	$p['wirasat-calculator'] = array(
		'title' => 'Wirasat Calculator (Islamic Inheritance) with Family Tree',
		'seo'   => 'Wirasat Calculator: Islamic Inheritance by Madhab + Shajra',
		'desc'  => "Islamic inheritance (wirasat) calculator for all six madhabs: each heir's share in rupees, kanal-marla and gold, a patwari-style shajra and a PDF report.",
		'nav'   => 'Wirasat',
		'blurb' => 'inheritance shares',
		'hub'   => 'calculators',
		'llms'  => true,
		'features' => array( 'Inheritance shares for Hanafi, Shafi\'i, Maliki, Hanbali, Ahl-e-Hadith and Shia Ja\'fari fiqh', 'Fill the form from a typed question in English, Urdu or Roman Urdu', 'All six madhabs side by side', 'Shares of cash, land (kanal, marla, square feet), gold and silver (tola and grams, with today\'s value)', 'Patwari-style family tree (shajra nasab)', 'Worked sheet with asl-e-masla, \'awl and radd', 'Pakistani law (MFLO 1961 section 4) next to the fiqh result', 'What-if: change one relative and compare', 'Share link and WhatsApp', 'Istifta draft for a dar al-ifta', 'PDF report' ),
		'content' => <<<'HTML'
[myzt_answer q="How is inheritance (wirasat) divided in Islam?"]First the funeral costs and all debts (including unpaid mehr) are paid from what the person left, then any will for non-heirs up to one third. The rest is divided among the heirs by the shares fixed in the Qur'an (al-Nisa 4:11, 4:12 and 4:176): for example a wife gets 1/8 when there are children, parents 1/6 each, and sons get twice what daughters get. Choose your madhab below and the calculator works out every heir's share, in rupees, land and gold.[/myzt_answer]
<p>This free wirasat (also written virasat or warasat) calculator divides an estate the way a mufti or a patwari in Pakistan would: by the fiqh you follow, with land in kanal and marla, gold in tola and a family tree you can print. It covers the Hanafi (Deobandi and Barelvi), Shafi'i, Maliki, Hanbali, Ahl-e-Hadith and Shia Ja'fari schools, and works for families anywhere, not only in Pakistan. On this page the calculator is in English; the same calculator and guide in Urdu are on the <a href="/wirasat-calculator-urdu/">Urdu wirasat page</a>.</p>
[zakat_wirasat]
<h2>Islamic inheritance calculator for Pakistan and worldwide</h2>
<p>Inheritance in Islam goes by several names. In Arabic it is <em>mirath</em> (ميراث) and the science of the fixed shares is <em>fara'id</em>, so this is also a faraid calculator or mirath calculator. In Pakistan and India the same thing is called wirasat, virasat or warasat (وراثت), and in Urdu also میراث. Whatever you call it, the rules are the same: the shares fixed in Surah an-Nisa, worked out by your madhab. As an inheritance calculator for Pakistan it adds what local families need: land in kanal and marla, gold in tola, a patwari-style shajra and the effect of section 4 of the Muslim Family Laws Ordinance. Families in the UK, the Gulf, Malaysia or anywhere else can use it in their own currency and units.</p>
<h2>How to use the calculator</h2>
<p><strong>Quickest way:</strong> type or paste the question in the "Calculate from a question" box at the top, in English, Urdu or Roman Urdu, for example "A woman died. Heirs: husband, mother, two full sisters" or "ek aurat fout hui, shohar, maa, do haqeeqi behnen". The page recognises the relatives and fills the form; check it and press calculate. Or fill the form step by step:</p>
<ol>
<li><strong>Enter what was left:</strong> cash and bank balance (with debts and funeral costs), land or a house in kanal, marla and feet, and gold and silver in tola.</li>
<li><strong>Enter the deceased:</strong> man or woman, and the name.</li>
<li><strong>Add the family:</strong> father, mother, wife or husband, sons and daughters. If those are few, open "other relatives" for the paternal and maternal grandparents (dada, dadi, nana, nani), full and half brothers and sisters, and uncles and aunts on both sides: chacha and taya, phuphi, mamu and khala. For each one say whether they are alive, died <em>before</em> the deceased, or died <em>after</em>. Someone who died first does not inherit (their children are asked for where the law can give them a share), while someone who died after has already inherited and their share passes to their own heirs.</li>
<li><strong>Choose the madhab:</strong> Hanafi (Deobandi and Barelvi), Shafi'i, Maliki, Hanbali, Ahl-e-Hadith or Shia Ja'fari, check the summary and press the button.</li>
</ol>
<h2>What you get after pressing calculate</h2>
<ul>
<li><strong>Every heir's share:</strong> the fraction, the cash in rupees, the land in kanal, marla and square feet (1 kanal = 20 marla, 1 marla = 272 sq ft), gold and silver in tola and grams with an estimate of today's value from the <a href="/gold-rate-today/">live gold and silver rate</a>, and the percentage, each with the reason in plain words.</li>
<li><strong>Who does not inherit, and why:</strong> for example "excluded because a son is alive" or "died before the deceased".</li>
<li><strong>A shajra nasab:</strong> the family tree a patwari draws, made from your entries. A large family is fitted to the screen and can be enlarged.</li>
<li><strong>The worked sheet (hisab ki kaapi):</strong> the base number of the case (asl-e-masla), how many parts each heir gets, and the steps of <em>'awl</em> or <em>radd</em> when they apply, set out the way a mufti checks a case.</li>
<li><strong>Six madhabs side by side:</strong> one table with the same family worked out by all six schools, so you can see at once whether your case is one where they differ.</li>
<li><strong>"What if" (agar yeh hota to):</strong> change one relative, for instance as if the father were alive or a brother did not exist, and see how the shares move without touching your main result.</li>
<li><strong>Fiqh and Pakistani law together:</strong> when a son or daughter died before the deceased and left children, Pakistani law can give a different result from the fiqh. The calculator then shows both, in two tabs: Pakistani law (what the patwari and the courts record) and your madhab's fiqh.</li>
<li><strong>Share and ask a mufti:</strong> copy a link or send it on WhatsApp so a relative or a mufti sees the same family and result. The link carries your entries in the address itself; nothing is saved on our server. A ready istifta (written question) for a dar al-ifta can be copied or sent in one tap.</li>
<li><strong>PDF report:</strong> the shajra alone on the first page (turned sideways for a big family) with space below for the patwari's report, then the share table, the reasons and the worked sheet.</li>
</ul>
<h2>The order: debts, will, then heirs</h2>
<p>Before anything is divided, the estate pays for a simple funeral, then every debt the person owed. Unpaid mehr is a debt to the wife and is paid in full, like any other loan; the <a href="/haq-mehr-calculator/">haq mehr calculator</a> shows what a mehr fixed in silver or gold is worth today. Only after that can a will (wasiyyat) be carried out, and only for people who are not heirs and only up to one third of what is left. A larger will needs the consent of the adult heirs. Whatever remains is the inheritance.</p>
<p>Two religious debts often come up at this stage: zakat the person did not pay, and fasts they missed. In the Hanafi school both are paid from the estate only if the person left a will for them, from up to one third; in the Shafi'i and Hanbali schools they come out of the estate before it is divided. See <a href="/missed-zakat-past-years/">missed zakat</a> and <a href="/roza-fidya/">fidya for a deceased person</a>.</p>
<h2>The fixed shares in the Qur'an</h2>
<ul>
<li><strong>Husband:</strong> 1/2, or 1/4 if the wife left children.</li>
<li><strong>Wife:</strong> 1/4, or 1/8 if the husband left children. Two, three or four wives share this one portion equally. More in <a href="/wife-husband-share-in-inheritance/">the wife's and husband's share</a>.</li>
<li><strong>Father:</strong> 1/6 when there is a son; 1/6 and whatever is left when there are only daughters; everything left when there are no children.</li>
<li><strong>Mother:</strong> 1/6 when there are children or two or more brothers or sisters, otherwise 1/3. When only the spouse and both parents are heirs, the mother gets a third of what is left after the spouse (al-Umariyyatan).</li>
<li><strong>Daughters:</strong> one daughter alone 1/2, two or more 2/3. With a son, children share the rest, a son getting twice a daughter. More in <a href="/daughters-share-in-inheritance/">the daughter's share</a>.</li>
<li><strong>Sisters</strong> (when there are no children and no father): one 1/2, two or more 2/3; with daughters, sisters take what is left.</li>
<li><strong>Brothers and sisters through the mother only:</strong> one 1/6, two or more share 1/3 equally.</li>
</ul>
<p>When the fixed shares add up to more than the whole, each is reduced in proportion (<em>'awl</em>). When they add up to less and there is no residuary heir, the rest goes back to the sharers except the husband or wife (<em>radd</em>). The calculator does both, tells you when it has, and shows the steps in the worked sheet.</p>
<h3>When only distant relatives are left</h3>
<p>If there is no sharer and no residuary heir (for example only a mamu, a khala or a phuphi), the Hanafi, Hanbali and Ahl-e-Hadith schools, and the later Shafi'i and Maliki scholars, give the estate to the relatives through women (<em>dhawu al-arham</em>). In Ja'fari fiqh uncles and aunts on both sides are the third class of heirs. How these relatives divide the estate is detailed and disputed, so the calculator marks such results for a mufti to confirm.</p>
<h2>Where the madhabs differ</h2>
<ul>
<li><strong>Grandfather with brothers.</strong> Hanafi scholars (following Abu Hanifa and Abu Bakr) and Ahl-e-Hadith scholars treat the paternal grandfather like the father: he excludes the brothers and sisters. The Shafi'i, Maliki and Hanbali schools follow Zayd ibn Thabit: the grandfather shares with them and gets the best of an equal share, one third, or one sixth. This includes the famous case of al-Akdariyya.</li>
<li><strong>Al-Mushtaraka.</strong> When a woman leaves a husband, a mother, two or more half-siblings through the mother and full brothers, nothing is left for the full brothers. Shafi'i and Maliki scholars let them share the third with the half-siblings; Hanafi and Hanbali scholars do not.</li>
<li><strong>Paternal grandmother.</strong> In the Hanbali school she inherits even while her son, the father, is alive.</li>
<li><strong>Radd to the husband or wife.</strong> When nobody else is left, later Hanafi scholars return the rest to the spouse; the Shafi'i, Maliki and Hanbali schools do not. Our Ahl-e-Hadith setting follows Ibn Taymiyyah's view and returns it too, but many scholars do not give the remainder to a spouse; ask a mufti.</li>
<li><strong>Shia Ja'fari fiqh</strong> works in three classes: parents and children first, then grandparents and siblings, then uncles and aunts. There is no <em>'awl</em>; grandchildren and nephews take the place of a parent who died first; and a wife inherits from the value of buildings and trees but not from land. The calculator shows a wife's share of land as zero in Ja'fari mode and divides the land among the other heirs.</li>
</ul>
<p>Open "six madhabs side by side" under your result to see which of these applies to your family. Zakat also differs between the schools; the <a href="/madhab-comparison/">madhab comparison</a> sets that out.</p>
<h2>Orphaned grandchildren and Pakistani law</h2>
<p>In all four Sunni schools a grandchild whose parent died first does not inherit while a son of the deceased is alive. Pakistan's Muslim Family Laws Ordinance 1961, section 4, changed this: the children of a predeceased son or daughter receive the share their parent would have received. The Federal Shariat Court held the section against Islamic injunctions, but an appeal is pending in the Supreme Court and courts still apply it. When your family has such a case, the calculator shows the result both ways, in two tabs. The full story, and what a grandfather can do through a will, is in <a href="/orphaned-grandchildren-inheritance/">orphaned grandchildren and section 4</a>.</p>
<h2>Land, gold and the house</h2>
<p>Shares are fractions of everything left, not of money alone. If the estate has 2 kanal 10 marla of land, a wife's 1/8 is 6.25 marla (6 marla 68 sq ft), and the calculator converts every share into kanal, marla and feet (1 kanal = 20 marla, 1 marla = 272 sq ft). Gold and silver are shown in tola and grams with an estimate at today's rate (see <a href="/zakat-on-1-tola-gold/">what 1 tola is worth</a>). Heirs may also agree to sell a property and divide the money, or let one heir keep it and pay the others their share.</p>
<h2>Zakat after you receive your share</h2>
<p>Once your share is yours, it counts with the rest of your wealth for zakat. Inherited cash and gold join your savings; inherited jewellery follows the jewellery rule of your school; land you keep to live on or farm has no zakat, though its crops carry <a href="/ushr-calculator/">ushr</a>. The details, including when the zakat year starts, are in <a href="/zakat-on-inherited-wealth/">zakat on inherited wealth</a>, and the <a href="/">zakat calculator</a> works out the amount.</p>
<h2>Daughters' right to inherit</h2>
<p>A daughter's share is fixed by Allah in the Qur'an, and it cannot be taken away by family custom, by a "gift" of her share to her brothers under pressure, or by leaving land only to sons. Pakistani law also protects it: depriving a woman of her inheritance by deceit is a crime under section 498A of the Pakistan Penal Code, and the Enforcement of Women's Property Rights Act 2020 lets a woman complain to the Ombudsperson. See <a href="/daughters-share-in-inheritance/">the daughter's share</a>.</p>
<h2>Is it accurate?</h2>
<p>The rules come from al-Sirajiyyah (the standard Hanafi text on fara'id), the main books of the other schools and Ayatollah Sistani's Islamic Laws for Ja'fari fiqh. The engine uses exact fractions, so the shares always add up to the whole estate. It is checked on every change against 425 worked cases from these books, 69 to 77 for each of the six schools, besides the famous named cases; 6 more cases where scholars differ are kept as open questions. Inheritance cases can still be complicated, especially when distant relatives, missing persons or several deaths are involved. Show the result to a mufti before dividing (the istifta button helps), and use a lawyer for the transfer of property. If a result looks wrong, please <a href="/contact/">tell us</a>; the calculator has the same link. How we choose our sources is on the <a href="/methodology/">methodology</a> page.</p>
<p>Everything is calculated in your browser; the names and amounts you type are not sent to us. Related: <a href="/haq-mehr-calculator/">haq mehr calculator</a> (unpaid mehr is a debt on the estate), <a href="/diyat-calculator/">diyat calculator</a> (diyat is divided among the heirs by these same shares) and the <a href="/">zakat calculator</a>.</p>
[myzt_faq]
HTML
		. $author . '[myzt_related slugs="wirasat-calculator-urdu,daughters-share-in-inheritance,zakat-on-inherited-wealth,haq-mehr-calculator"]',
		'faq'   => array(
			array( 'q' => 'Beti ka wirasat mein kitna hissa hai?', 'a' => 'Agar beta bhi ho to beti ko bete ka aadha milta hai. Sirf aik beti ho to aadha tarka, do ya zyada betiyan hon to mil kar do tihai.' ),
			array( 'q' => 'Biwi ka hissa kitna hai?', 'a' => 'Shohar ki olad ho to aathwan hissa (1/8), na ho to chautha (1/4). Aik se zyada biwiyan ye hissa barabar baant leti hain.' ),
			array( 'q' => 'Do grandchildren inherit if their father died before their grandfather?', 'a' => 'In Sunni fiqh, not while a son of the deceased is alive. Under section 4 of Pakistan\'s Muslim Family Laws Ordinance 1961 they get their father\'s share; the calculator then shows the fiqh and the law in two tabs. In Ja\'fari fiqh they take their parent\'s place only when no child of the deceased is alive.' ),
			array( 'q' => 'What if an heir died after the deceased but before the estate was divided?', 'a' => 'They had already inherited, so their share becomes part of their own estate and is divided among their own heirs (munasakha). Mark them as "died after" and their share is shown with this note.' ),
			array( 'q' => 'Is unpaid mehr paid before inheritance?', 'a' => 'Yes. Unpaid mehr is a debt on the husband and is paid from his estate before it is divided. The widow then also gets her inheritance share.' ),
			array( 'q' => 'Mamu, khala ya phuphi ko wirasat milti hai?', 'a' => 'Sirf tab jab koi hissa daar ya asaba (jaise beta, bhai, chacha) na ho. Sunni fiqh mein ye zawil arham hain; fiqh-e-Jafaria mein teesra tabqa. Calculator inhein "dusre rishtedar" mein shamil karta hai aur aise nateeje par mufti sahib se tasdeeq ka note deta hai.' ),
			array( 'q' => 'Can I see the result for every madhab at once?', 'a' => 'Yes. Open "six madhabs side by side" under the result: the same family is worked out by Hanafi, Shafi\'i, Maliki, Hanbali, Ahl-e-Hadith and Shia Ja\'fari fiqh in one table.' ),
			array( 'q' => 'How do I send the case to a mufti?', 'a' => 'Under the result, "share and ask a mufti" gives a link and a WhatsApp button that open the same family and result, and a ready istifta (written question) you can copy for a dar al-ifta. The worked sheet shows the steps the mufti will check.' ),
			array( 'q' => 'Is this a faraid or mirath calculator?', 'a' => 'Yes. Fara\'id is the science of the fixed inheritance shares and mirath is the Arabic word for inheritance; wirasat, virasat and warasat are the Urdu names. This calculator applies those rules for all six madhabs.' ),
			array( 'q' => 'Is there an inheritance calculator for Pakistan?', 'a' => 'This one is built for Pakistan: shares in rupees, land in kanal and marla, gold in tola, a patwari-style shajra and the MFLO 1961 section 4 result next to the fiqh. It also works in other countries and currencies.' ),
			array( 'q' => 'Kya ye calculator fatwa hai?', 'a' => 'Nahi. Ye har maslak ke shaye shuda usool se andaza deta hai. Taqseem se pehle mufti sahib se tasdeeq karein.' ),
		),
	);

	$p['zakat-date-calculator'] = array(
		'title' => 'Zakat Date Calculator and Hawl Tracker',
		'seo'   => 'When Is My Zakat Due? Zakat Date Calculator {year}',
		'desc'  => 'Zakat is due one lunar year (354 days) after your wealth first reached the nisab. Enter that day for your zakat date in Hijri and Gregorian, with reminders.',
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
		'seo'   => 'Ushr Calculator {year}: Wheat, Rice & Livestock Zakat',
		'desc'  => 'Calculate ushr on wheat, rice and other crops (10% rain-fed, 5% irrigated) in maunds, and zakat on goats, sheep, cows, buffaloes and camels.',
		'nav'   => 'Ushr & livestock',
		'blurb' => 'fasal, maweshi',
		'hub'   => 'calculators',
		'llms'  => true,
		'content' => <<<'HTML'
[myzt_answer q="How much is ushr?"]Ushr is 10% of the harvest for land watered by rain or rivers, and 5% (nisf-ushr) for land watered by tube wells or other costly irrigation (scholars differ on government canal water). It is due at harvest, with no waiting year. Imam Abu Hanifa set no minimum quantity; the Shafi'i, Maliki and Hanbali schools require at least 5 wasq (about 653 kg).[/myzt_answer]
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
		'llms'  => true,
		'hub'   => 'calculators',
		'content' => <<<'HTML'
[myzt_answer q="How can I show the nisab on my website?"]Copy the one line of code below and paste it into your page or a Custom HTML block. It shows today's silver and gold nisab and the gold rate in the currency you choose, refreshed every hour from international prices. It is free, with no sign-up, ads or tracking; please keep the small credit line.[/myzt_answer]
<p>Mosques, madrasas, Islamic centres and bloggers can show today's nisab and gold rate on their own website for free. The box below updates every hour from international gold and silver prices, in the currency you choose. No sign-up, no ads, no tracking.</p>
<h2>Preview and code</h2>
[myzt_embed_code currency="PKR"]
<h2>How to add it</h2>
<ol>
<li>Copy the code above.</li>
<li>In WordPress, add a "Custom HTML" block (or a Custom HTML widget in your sidebar) and paste it. On other sites, paste it where you want the box to appear.</li>
<li>Keep the small "Nisab by My Zakat Tool" line: it tells your visitors where the numbers come from.</li>
</ol>
<h2>About the numbers</h2>
<ul>
<li>The silver nisab is 52.5 tola (612.35 g) and the gold nisab 7.5 tola (87.48 g). Hanafi scholars use the silver nisab for cash.</li>
<li>Prices are international spot rates; local jewellers' prices are a little higher.</li>
<li>The box is an estimate for guidance, not a fatwa; see our <a href="/disclaimer/">disclaimer</a>.</li>
</ul>
<h2>What the box shows</h2>
<ul>
<li>Today's silver nisab (52.5 tola) and gold nisab (7.5 tola) in the currency you picked, worked out from the hourly international spot price.</li>
<li>The price of 1 tola of 24K gold and 1 tola of silver.</li>
<li>The time the rate was last refreshed, so visitors can see it is current.</li>
<li>The credit line links back to this site, where visitors can calculate their own zakat for any madhab.</li>
</ul>
<h2>Choosing the currency</h2>
<p>The code above uses Pakistani rupees. To show another currency, change <code>PKR</code> in <code>data-currency</code> to any of the about 50 three-letter codes we support, such as <code>INR</code>, <code>BDT</code>, <code>GBP</code>, <code>USD</code>, <code>EUR</code>, <code>AED</code>, <code>SAR</code>, <code>MYR</code> or <code>ZAR</code>. A mosque in the UK would use <code>GBP</code>; one in the UAE would use <code>AED</code>.</p>
<h2>Privacy and speed</h2>
<p>The box loads one small script from our site and reads the cached rate from our server. It sets no cookies, shows no ads, and does not collect anything about your visitors. It loads after the rest of your page, and if our server cannot be reached the box stays empty instead of breaking your page; the credit line still links to the live nisab page.</p>
<h2>Who uses it</h2>
<p>The widget is made for mosque and madrasa websites, Islamic centre newsletters, zakat committees and bloggers who write about zakat before Ramadan. Many mosques put it on their Ramadan or zakat page next to their own bank details for zakat collection; we do not collect or handle any zakat ourselves.</p>
<h2>More tips for site owners</h2>
<ul>
<li>The widget shows the nisab only. For a full calculation, link visitors to the <a href="/">zakat calculator</a>, or in Pakistan to the <a href="/zakat-calculator-pakistan/">Pakistan calculator</a>.</li>
<li>Silver is shown first because Hanafi scholars, and the Hanbali and Ahl-e-Hadith views, use the silver nisab for cash. Read <a href="/nisab/">which nisab applies</a>.</li>
</ul>
<p>Questions or a different design? <a href="/contact/">Contact us</a>.</p>
[myzt_faq]
HTML
		. $author . '[myzt_related slugs="nisab,gold-rate-today,calculators,home"]',
		'faq'   => array(
			array( 'q' => 'Is the nisab widget really free?', 'a' => 'Yes. There is no sign-up, no ads and no tracking. We only ask you to keep the small credit line.' ),
			array( 'q' => 'How often does the widget update?', 'a' => 'The rates behind it are refreshed every hour from international gold and silver prices.' ),
			array( 'q' => 'Does it work on Blogger, Wix or Squarespace?', 'a' => 'Yes, on any site that lets you paste HTML code into a page or an embed block.' ),
			array( 'q' => 'Kya nisab widget muft hai?', 'a' => 'Ji haan, koi sign-up, ad ya tracking nahi. Bas chhoti si credit line rehne den.' ),
			array( 'q' => 'Widget mein currency kaise badlen?', 'a' => 'Code mein data-currency ke andar PKR ki jagah apni currency ka teen harfi code likhen, jaise INR, GBP, AED ya SAR. Taqreeban 50 currencies support hain.' ),
		),
	);

	$p['khums-calculator'] = array(
		'title' => 'Khums Calculator',
		'seo'   => 'Khums Calculator {year}: 20% of Yearly Surplus (Sistani)',
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
<h2>Worked example</h2>
<p>Zainab is a teacher. Her khums date is 1 Muharram. On that date:</p>
<ul>
<li>Her bank savings are Rs 6,00,000. Rs 1,00,000 of this is left from last year, on which she already paid khums, so Rs 5,00,000 comes from this year's income.</li>
<li>Rice, flour and other supplies bought from her salary and still unused are worth Rs 20,000.</li>
<li>She bought a sewing machine for her own use during the year; it is part of her needs, so it is not counted.</li>
<li>Stock for her small online clothing business, bought from income, is worth Rs 80,000.</li>
</ul>
<p>Her surplus is Rs 5,00,000 + Rs 20,000 + Rs 80,000 = Rs 6,00,000. Khums is 20% = <strong>Rs 1,20,000</strong>: Rs 60,000 sahm-e-imam and Rs 60,000 sahm-e-sadat.</p>
<h2>Setting your khums date</h2>
<p>Your khums year starts from the day you first earned income (or from the day you choose to start keeping account, if you missed earlier years). Income earned during the year can be used for that year's expenses; whatever is left on the khums date is taxed at 20%. Using the same date each year keeps the accounts simple. If you are unsure about earlier years, ask your marja's office how to settle them.</p>
<h2>Where khums goes</h2>
<p>Sahm-e-imam is given to the marja you follow, or to a representative (wakil) authorised by their office. Sahm-e-sadat goes to poor and needy sayyids. Ayatollah Sistani's office gives detailed rules on who may receive each share and whether permission is needed; follow your marja's guidance.</p>
<p>Rules differ between maraji'. Please confirm details with your marja's office. For a fuller explanation, read <a href="/khums-who-must-pay/">who must pay khums, and sahm-e-imam and sahm-e-sadat</a>. Shia followers of Ayatollah Sistani do not pay zakat on cash or jewellery; see the <a href="/shia-zakat-calculator/">Shia zakat calculator</a> for what zakat does apply to.</p>
[myzt_faq]
HTML
		. $author . '[myzt_related slugs="khums-who-must-pay,shia-zakat-calculator,zakat-date-calculator,fitrana-calculator"]',
		'faq'   => array(
			array( 'q' => 'Is khums 20% of total savings?', 'a' => 'It is 20% of the surplus of the year from income, after the year\'s expenses, on which khums has not been paid.' ),
			array( 'q' => 'Is khums due on my house and car?', 'a' => 'Not on a house, car or other items bought within the year for your own needs and in keeping with your status, according to Ayatollah Sistani.' ),
			array( 'q' => 'Khums kis tareekh ko dena hai?', 'a' => 'Apni khums ki tareekh par, jo aam tor par us din se shuru hoti hai jab aap ne pehli dafa kamaya. Har saal usi tareekh ko bachi hui raqam ka 20% ada karein.' ),
		),
	);

	$p['nisab'] = array(
		'title' => 'Nisab Today: Gold and Silver Nisab for Zakat',
		'seo'   => 'Zakat Nisab {cyear} Today: Gold & Silver Nisab Value',
		'desc'  => 'Today\'s zakat nisab in your currency: silver 612.35 g (52.5 tola) and gold 87.48 g (7.5 tola), from live international rates. Which nisab to use by madhab.',
		'nav'   => 'Nisab Today',
		'blurb' => 'in your currency',
		'llms'  => true,
		'content' => <<<'HTML'
<p><strong>Nisab on [myzt_rate_date]:</strong> silver 612.35 g (52.5 tola) and gold 87.48 g (7.5 tola), valued at today's international rate.</p>
[myzt_answer q="What is the nisab today?"]The silver nisab (612.35 g) is about [myzt_rate type="nisab-silver" currency="PKR"] and the gold nisab (87.48 g) is about [myzt_rate type="nisab-gold" currency="PKR"] today. Choose your currency below.[/myzt_answer]
[zakat_nisab]
[myzt_reviewed rates="1"]
[myzt_official type="bank-nisab"]
<p>Own only a little gold? See <a href="/zakat-on-1-tola-gold/">how much zakat is due on 1 tola of gold</a> and <a href="/zakat-on-1-lakh-rupees/">on 1 lakh rupees</a>. Run a mosque or blog website? Show this nisab on it with our <a href="/free-zakat-widget/">free nisab widget</a>. The same nisab, with no waiting year, decides whether qurbani is wajib on you: check it with the <a href="/qurbani-calculator/">qurbani calculator</a>.</p>
<h2>Which nisab applies to you?</h2>
<ul>
<li><strong>Only gold:</strong> the gold nisab, 87.48 g (7.5 tola) of pure gold.</li>
<li><strong>Only silver:</strong> the silver nisab, 612.35 g (52.5 tola).</li>
<li><strong>Cash or a mix:</strong> Hanafi scholars use the silver nisab; Hanbali and Ahl-e-Hadith use whichever is lower (silver today); Shafi'i authorities in Malaysia and Singapore use gold.</li>
<li><strong>Shia (Sistani):</strong> 69.12 g of gold or 483.84 g of silver in coins used as currency.</li>
</ul>
<h2>Gold or silver nisab: which does each madhab use?</h2>
<figure class="wp-block-table"><table><thead><tr><th>Madhab</th><th>Only gold</th><th>Cash, savings or a mix</th><th>Gold and silver added?</th></tr></thead><tbody>
<tr><td>Hanafi (Deobandi, Barelvi)</td><td>Gold nisab, 87.48 g</td><td>Silver nisab, 612.35 g (Darul Uloom Deoband, Fatwa 702/702=M/1429)</td><td>Yes, by value</td></tr>
<tr><td>Shafi'i</td><td>Gold nisab</td><td>Gold in Malaysia and Singapore; silver may be chosen</td><td>No, each against its own nisab</td></tr>
<tr><td>Maliki</td><td>Gold nisab</td><td>Silver or gold; ask your local scholar</td><td>Yes</td></tr>
<tr><td>Hanbali</td><td>Gold nisab</td><td>Whichever is better for the poor, silver today</td><td>Yes</td></tr>
<tr><td>Ahl-e-Hadith</td><td>Gold nisab</td><td>The lower of the two, silver today (IslamQA 201807)</td><td>Yes</td></tr>
<tr><td>Shia (Sistani)</td><td>69.12 g, coins only (ruling 1912)</td><td>No zakat on paper money; khums instead (ruling 1915)</td><td>No</td></tr>
</tbody></table></figure>
<p>The two weights come from the hadith of Ali: 20 dinars of gold and 200 dirhams of silver held for a year (Abu Dawud 1573). Each madhab's full rules are on its own page, and the <a href="/madhab-comparison/">madhab comparison</a> puts them side by side.</p>
<h2>The bank's nisab is not the shar'i nisab</h2>
<p>People in Pakistan often mix up two different figures:</p>
<ul>
<li><strong>The shar'i nisab</strong> is the value of 612.35 g of silver (or 87.48 g of gold) on <em>your own</em> zakat date. It decides whether zakat is due on all your wealth together: cash at home, every account, gold, business stock and the rest. It changes every hour with the silver price, and it is the figure at the top of this page.</li>
<li><strong>The bank deduction nisab</strong> is one rupee figure the government notifies shortly before Ramadan. Banks use it on 1 Ramadan, one account at a time: a savings account at or above it has 2.5% deducted. It is worked out from the silver price when it is set and then stays fixed for the year.</li>
</ul>
<p>So an account below the bank's figure is not deducted, but you may still owe zakat on it, because the shar'i nisab looks at everything you own. And a deduction by the bank does not settle your zakat on your gold or other accounts. Subtract what the bank took from your full zakat; see <a href="/bank-zakat-deduction-pakistan/">bank zakat deduction and the CZ-50 form</a>.</p>
<h2>Nisab in past years</h2>
<p>The bank deduction nisab notified in Pakistan for each year, with its source. It rose sharply in 2026 because the silver price almost tripled.</p>
[myzt_history type="bank-nisab"]
<p>The shar'i nisab has always been the same weight: 52.5 tola of silver or 7.5 tola of gold. Only its value in rupees changes. For a year you missed, value your wealth and the nisab on that year's zakat date; the <a href="/missed-zakat-past-years/">missed zakat guide</a> shows how. For the 2027 figures as they are announced, see <a href="/zakat-2027-pakistan/">zakat 2027 in Pakistan</a>.</p>
<h2>How the nisab is worked out</h2>
<ol>
<li>Take the weight: 612.35 g of silver (52.5 tola) or 87.48 g of gold (7.5 tola), with 1 tola = 11.6638 g.</li>
<li>Multiply by today's price per gram of pure metal.</li>
<li>Convert to your currency at today's exchange rate.</li>
</ol>
<p>Rates are international spot prices refreshed every hour and converted to your currency. Local market prices may differ slightly; the calculator lets you enter your own sarafa rate.</p>
[myzt_faq]
HTML
		. $author . '[myzt_related slugs="gold-rate-today,home,zakat-on-gold-calculator,madhab-comparison"]',
		'faq'   => array(
			array( 'q' => 'Nisab kitna hai?', 'a' => 'Chandi ka nisab 52.5 tola (612.35 gram) aur sone ka 7.5 tola (87.48 gram). Upar aaj ki qeemat aap ki currency mein di gayi hai.' ),
			array( 'q' => 'Why is the silver nisab so much lower than gold?', 'a' => 'Both weights were fixed in the time of the Prophet ﷺ when they had similar value. Silver has become much cheaper relative to gold, so the silver nisab is now far lower.' ),
			array( 'q' => 'What was the zakat nisab in Pakistan in 2026?', 'a' => 'For bank deduction on 1 Ramadan 1447 (February 2026) the government notified Rs 5,03,529. Your own shar\'i nisab is the value of 52.5 tola of silver on your zakat date, shown live at the top of this page.' ),
			array( 'q' => 'Bank ka nisab aur shar\'i nisab mein kya farq hai?', 'a' => 'Bank ka nisab hukoomat har saal Ramazan se pehle aik raqam ki soorat mein deti hai aur bank sirf us account ko dekhta hai. Shar\'i nisab 52.5 tola chandi ki aaj ki qeemat hai aur aap ke saare maal par lagta hai.' ),
			array( 'q' => 'When will the 2027 nisab be announced?', 'a' => 'The bank deduction nisab for Ramadan 1448 is usually notified a few days before 1 Ramadan, expected around 8 February 2027. We add it here on the day it is announced.' ),
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
<p><strong>Gold rate on [myzt_rate_date]</strong>, per tola, gram and 10 grams, from the international spot price converted to your currency.</p>
[myzt_answer q="Gold rate today:"]1 tola of 24K gold is about [myzt_rate type="gold-tola" currency="PKR"] and 1 gram about [myzt_rate type="gold-gram" currency="PKR"] at the international rate. Silver is about [myzt_rate type="silver-tola" currency="PKR"] per tola.[/myzt_answer]
[zakat_gold_rate]
[myzt_reviewed rates="1"]
<h2>Gold rate by karat: 1 gram, 10 grams, 1 tola and 10 tola</h2>
<p>Pakistani jewellers quote per tola and per 10 grams; Indian and Gulf shops quote per gram or per 10 grams. The table converts today's 24K price into each of these for the common karats.</p>
[myzt_karat_table currency="PKR"]
<h2>Gold and silver in the last 30 days</h2>
[myzt_rate_chart currency="PKR"]
<p>The chart uses one reading a day of the international spot price. Prices in the sarafa bazaar follow the same trend but are usually a little higher.</p>
<h2>About these rates</h2>
<p>These are international spot prices, refreshed every hour and converted with daily exchange rates. Jewellers' prices include making charges and local premiums, so the price you pay in a shop is higher. For zakat, the value of the pure gold is what counts.</p>
<p>1 tola = 11.6638 g (often rounded to 11.664 g) · 1 troy ounce = 31.103 g · 22K gold is 91.7% pure, 21K is 87.5%, 18K is 75%.</p>
<p>Use these rates directly in the <a href="/zakat-on-gold-calculator/">zakat on gold calculator</a>, or see <a href="/zakat-on-1-tola-gold/">zakat on 1 tola gold</a> worked out at today's rate.</p>
<p>The silver price also sets two amounts people look for every year: <a href="/haq-mehr-calculator/">Mehr-e-Fatimi and the minimum haq mehr</a>, and the <a href="/diyat-calculator/">diyat amount in Pakistan</a> (the value of 30,630 g of silver).</p>
<h2>What does the gold rate mean for zakat?</h2>
<ul>
<li><strong>The nisab follows the rate.</strong> The gold nisab is 7.5 tola (87.48 g), about [myzt_rate type="nisab-gold" currency="PKR"] today, and the silver nisab 52.5 tola, about [myzt_rate type="nisab-silver" currency="PKR"]. See <a href="/nisab/">nisab today</a> for which one your madhab uses.</li>
<li><strong>Use the rate of your zakat date,</strong> not the price you paid. A rise in the gold price raises your zakat on the same jewellery.</li>
<li><strong>Use the pure-gold price.</strong> For 22K jewellery take 22/24 of the 24K price. Making charges and stones are not counted.</li>
<li><strong>Selling price, not buying price:</strong> some muftis say to value gold at what a jeweller would pay you for it, which is a little lower than the shop price. The international rate used here sits close to that buying-back price.</li>
</ul>
<h2>Sarafa rate vs. international rate</h2>
<p>The Karachi and Lahore sarafa associations publish their own daily rate per tola. It starts from the same international price, then adds the cost of bringing gold into the country, the exchange rate in the open market and a local premium, so it is usually somewhat higher than the figure here. Either is acceptable for zakat; what matters is to use one honest rate for your zakat date. If you prefer the bazaar rate, tick <em>Use my own local rate</em> in the <a href="/zakat-calculator-pakistan/">Pakistan zakat calculator</a>.</p>
<h2>Silver rate today</h2>
<p>1 tola of silver is about [myzt_rate type="silver-tola" currency="PKR"] and 1 gram about [myzt_rate type="silver-gram" currency="PKR"]. Silver matters for zakat more than its price suggests: Hanafi scholars measure cash and mixed wealth against the silver nisab, so a family with modest savings can owe zakat even with no gold.</p>
[myzt_faq]
HTML
		. $author . '[myzt_related slugs="zakat-on-gold-calculator,nisab,free-zakat-widget,zakat-calculator-pakistan"]',
		'faq'   => array(
			array( 'q' => 'How many grams is 1 tola?', 'a' => '1 tola is 11.664 grams.' ),
			array( 'q' => 'Why is the shop price different?', 'a' => 'Shops add making charges, taxes and local premiums to the international price.' ),
			array( 'q' => 'What is the 22K gold rate per tola today?', 'a' => '22K gold is 91.7% pure, so its price is 22/24 of the 24K rate. The karat table on this page shows it per gram, 10 grams, tola and 10 tola.' ),
			array( 'q' => 'Aaj sone ka rate kya hai?', 'a' => 'Is safhe ke upar aaj ka rate fi tola, fi gram aur 10 gram mein diya gaya hai, 24, 22, 21 aur 18 karat ke liye. Sarafa bazaar ka rate is se thora zyada hota hai.' ),
			array( 'q' => 'Which gold rate should I use for zakat?', 'a' => 'The market rate of pure gold on your zakat date. The international rate here or your local sarafa rate both work; use one honestly.' ),
			array( 'q' => 'Aaj 22 karat sone ka rate fi tola kya hai?', 'a' => '22 karat sona 91.7% khalis hota hai, is liye is ka rate 24 karat ke rate ka 22/24 hissa hai. Is safhe ke karat table mein fi gram, 10 gram, tola aur 10 tola rate diya gaya hai.' ),
			array( 'q' => 'Zakat ke liye sone ka kaunsa rate lagayen?', 'a' => 'Apni zakat ki tareekh wale din khalis sone ka bazaar rate. Yahan ka international rate ya sarafa bazaar ka rate, dono mein se koi ek imandari se istemal karen. Kuch mufti sahiban bechne wali qeemat (jo jeweller aap ko dega) lagane ko kehte hain.' ),
		),
	);

	/* ------------------------------------------------------------------ */
	$p['guides'] = array(
		'title' => 'Zakat Guides',
		'seo'   => 'Zakat and Wirasat Guides: Gold, Fidya, Ushr, Khums, Shares',
		'desc'  => 'Sourced guides: zakat on gold and jewellery, bank deduction, hawl, missed zakat, fidya, ushr, khums and inheritance shares of daughters, wives, grandchildren.',
		'nav'   => 'Guides',
		'blurb' => 'answers',
		'llms'  => true,
		'content' => '[myzt_answer q="Where do I start with zakat?"]Zakat is 2.5% of your savings, gold, silver and business stock once they have stayed at or above the nisab for a lunar year. Start with what the nisab is and who can receive zakat, then use the calculator. The guides below answer the common questions, from bank deduction to fidya, khums and inheritance.[/myzt_answer]<p>Clear answers to the zakat questions people ask most, with sources for the main rulings and a link to the calculator so you can check your own numbers. Rulings differ between the schools, so every guide says which madhab a statement belongs to.</p><h2>All guides</h2>[myzt_guides]<h2>Start here</h2><p>New to zakat? Read <a href="/nisab/">what the nisab is</a>, then <a href="/who-can-receive-zakat/">who can receive zakat</a>, and use the <a href="/">zakat calculator</a>. For the differences between schools see the <a href="/madhab-comparison/">madhab comparison</a>, and for rates see <a href="/gold-rate-today/">gold rate today</a>.</p><h2>Inheritance (wirasat)</h2><p>After a death in the family, start with the <a href="/wirasat-calculator/">wirasat calculator</a>, then read about the <a href="/daughters-share-in-inheritance/">daughter\'s share</a>, the <a href="/wife-husband-share-in-inheritance/">wife\'s and husband\'s share</a>, <a href="/orphaned-grandchildren-inheritance/">orphaned grandchildren and section 4</a> and <a href="/zakat-on-inherited-wealth/">zakat on inherited wealth</a>.</p><h2>Ramadan, Pakistan and Fiqh-e-Jafaria</h2><p>Before Ramadan, read about the <a href="/bank-zakat-deduction-pakistan/">bank deduction and the CZ-50 form</a> and keep an eye on <a href="/zakat-2027-pakistan/">zakat 2027 Pakistan</a> for the new nisab and fitrana. For missed or broken fasts see <a href="/roza-fidya/">roza fidya</a> and <a href="/kaffara-for-breaking-a-fast/">kaffara</a>. Followers of Fiqh-e-Jafaria should read <a href="/khums-who-must-pay/">who must pay khums</a>, and farmers <a href="/ushr-on-crops/">ushr on crops</a> and <a href="/zakat-on-livestock/">zakat on livestock</a>.</p><h2>Nikah, Eid and Roman Urdu</h2><p>Before a nikah, read <a href="/haq-mehr-guide/">haq mehr in Islam: amount, types and rules</a>; before Eid, <a href="/fitrana-guide/">fitrana: who pays, how much and when</a>. Roman Urdu mein: <a href="/zakat-kaise-nikalen/">zakat kaise nikalen</a>, zakat ka hisab asan tareeqe se.</p>' . $author,
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
<h2 id="ali-ahmad">Who is behind it: Ali Ahmad</h2>
<p>The site is made and maintained by <strong>Ali Ahmad</strong>, its founder and editor (<a href="https://www.linkedin.com/in/ali-ahmad-chaudhry-12777486/" rel="me noopener" target="_blank">LinkedIn</a>). He designed the calculators, writes the guides, and checks every rule against the published fatwas and classical texts listed on the <a href="/methodology/">methodology</a> page before it goes live.</p>
<p>He started the site after finding that most zakat calculators follow one madhab only and leave the gold rate to the user, while Muslims follow different schools and the answer for jewellery and debts changes a lot between them. The same gap led to the <a href="/wirasat-calculator/">wirasat calculator</a>: dividing an estate by hand is where families most often go wrong.</p>
<p><strong>Ali Ahmad is not a scholar or a mufti</strong>, and the site does not issue fatwas. Each rule names its source; where we found no specific source, the methodology page says the point is <em>our reading</em>. The rules are open to correction: write to <a href="mailto:contact@myzakattool.com">contact@myzakattool.com</a> and every correction is dated in the change list.</p>
<h2>What you will find here</h2>
<ul>
<li>A <a href="/">zakat calculator</a> with a version for each school: <a href="/hanafi-zakat-calculator/">Hanafi</a>, <a href="/shafi-zakat-calculator/">Shafi'i</a>, <a href="/maliki-zakat-calculator/">Maliki</a>, <a href="/hanbali-zakat-calculator/">Hanbali</a>, <a href="/ahl-e-hadith-zakat-calculator/">Ahl-e-Hadith</a> and <a href="/shia-zakat-calculator/">Shia (Ja'fari)</a>, and a <a href="/madhab-comparison/">side-by-side comparison</a>.</li>
<li>Tools for <a href="/fitrana-calculator/">fitrana</a>, <a href="/fidya-kaffara-calculator/">fidya and kaffara</a>, your <a href="/zakat-date-calculator/">zakat date</a>, <a href="/ushr-calculator/">ushr and livestock</a> and <a href="/khums-calculator/">khums</a>, plus a <a href="/free-zakat-widget/">free nisab widget</a> for mosque websites.</li>
<li>Family tools: the <a href="/haq-mehr-calculator/">haq mehr calculator</a>, the <a href="/diyat-calculator/">diyat calculator</a> and the <a href="/wirasat-calculator/">wirasat (inheritance) calculator</a> with a family tree for all six madhabs.</li>
<li>Today's <a href="/nisab/">nisab</a> and <a href="/gold-rate-today/">gold rate</a> in about 50 currencies, and <a href="/guides/">guides</a> to common questions.</li>
<li>Pages in Urdu, starting with the <a href="/zakat-calculator-urdu/">Urdu zakat calculator</a>.</li>
</ul>
<h2>How we choose the rules</h2>
<p>For each school we use rulings that are published and can be checked: fatwas from institutions such as Darul Uloom Deoband, the Saudi Permanent Committee as quoted by IslamQA, the Mufti offices of Malaysia and Singapore, classical texts such as <em>al-Hidayah</em>, <em>al-Majmu'</em> and <em>Akhsar al-Mukhtasarat</em>, and Ayatollah Sistani's <em>Islamic Laws</em>. Where we could not find a specific source for a rule, the <a href="/methodology/">methodology</a> page says it is our reading. Where scholars within a school disagree, the calculator shows a note rather than hiding the difference, and the open questions are listed publicly.</p>
<h2>What we are not</h2>
<p>We are not scholars and we do not issue fatwas. The site has not yet been reviewed by a scholar on our behalf; when it is, the reviewer's name will appear on every page. The calculator gives an estimate from published rulings, and for your own situation you should ask a qualified scholar of your school.</p>
<h2>Corrections</h2>
<p>When a reader or our own checks find a mistake, we fix it and record the change with its date in the <a href="/methodology/">methodology</a> page's change list, and say whether any calculation result changed. Every page shows the date it was last updated.</p>
<h2>How the site is funded</h2>
<p>The site is free. It may show a small number of clearly marked advertisements. We do not collect zakat or donations, and we never see the numbers you enter: every calculation runs in your own browser.</p>
<h2>Contact</h2>
<p>Found an error or have a suggestion? Email <a href="mailto:contact@myzakattool.com">contact@myzakattool.com</a> or see the <a href="/contact/">contact page</a>.</p>
HTML
		. $author,
		'faq'   => array(),
	);

	$p['methodology'] = array(
		'title' => 'How We Calculate Zakat (Methodology and Sources)',
		'seo'   => 'How We Calculate Zakat: Methodology, Sources & Rates',
		'desc'  => 'The rules and sources behind My Zakat Tool for each madhab and tool, the nisab weights, how gold and silver rates are fetched, and how content is checked.',
		'nav'   => 'Methodology',
		'blurb' => 'sources',
		'llms'  => true,
		'content' => <<<'HTML'
<p>This page explains the rules every calculator on this site uses (zakat, ushr, fitrana, fidya and kaffara, khums, haq mehr, diyat and wirasat) and where each comes from. Where we have no specific source for a rule, we say it is <em>our reading</em>. If you think something is wrong, please <a href="mailto:contact@myzakattool.com">tell us</a>.</p>
[myzt_reviewed]
<h2>Common to all Sunni schools</h2>
<ul>
<li>Rate: 2.5% of zakatable wealth after a lunar year (hawl).</li>
<li>Gold nisab 87.48 g (7.5 tola); silver nisab 612.35 g (52.5 tola), the figures used in Pakistan and India. We take 1 tola as 11.6638 g (often rounded to 11.664 g) and round the nisab weights to two decimals; charts that multiply the rounded 11.664 g get a silver nisab 0.01 g higher, a difference of less than 0.002%. Some bodies, including several in Malaysia and Singapore, use 85 g of gold and 595 g of silver (20 and 200 mithqal at 4.25 g). With 85 g the gold nisab is about 2.8% lower. We use the tola figures for every Sunni school; you can enter your own local rate if your scholars use the other one.</li>
<li>Gold is counted by its pure content: weight × karat ÷ 24, for both the nisab and the value. See the Hanafi note below on jewellery that is mostly gold.</li>
<li>Cash, bank balances, business stock at sale value, good receivables and plots bought for resale are counted. Committee (ROSCA) payments, prize bonds, shares and crypto are counted at their amount or market value as <em>our reading</em> of the general rule on money and trade goods; we do not yet cite a specific fatwa for each.</li>
<li>Long loans and 12-month instalments: only the instalments due in the coming year are subtracted, where the madhab subtracts debts (<em>our reading</em> of contemporary Hanafi practice).</li>
<li>Doubtful receivables are not counted until received.</li>
</ul>
<h2 id="hanafi">Hanafi</h2>
<p>Jewellery zakatable even if worn daily; debts due now deducted; gold, silver and cash combined by value against the silver nisab; only gold → gold nisab. Sources: Darul Uloom Deoband, Fatwa 2310/H=713/th=1431 (jewellery) and Fatwa 702/702=M/1429 (combining, silver nisab).</p>
<p><strong>Jewellery that is mostly gold (open question):</strong> we count only the pure gold in a piece, for the nisab and the value, so 7.5 tola of 22K jewellery (6.875 tola of pure gold) is below the gold nisab if you own nothing else. Many South Asian fatwas cite the rule in <em>al-Hidayah</em> that "if gold predominates, it takes the ruling of gold" and count such a piece as wholly gold; on that view zakat is due. When this changes your result the calculator says so. We have asked for a written Hanafi ruling and will update this page, with a dated note, once we have it.</p>
<h2 id="shafii">Shafi'i</h2>
<p>Permissible worn jewellery exempt unless beyond custom (about 860 g); debts not deducted; gold and silver separate; cash valued on the gold standard by default (user may choose silver). Sources: Imam al-Nawawi, <em>al-Majmu'</em>; MUIS Office of the Mufti, "Zakat on Gold Jewellery"; SeekersGuidance, "Which debts affect zakat" (Shaykh Dr. Muhammad Fayez Awad).</p>
<p>Two points are <em>our reading</em> and await confirmation: cash and trade goods are added to the metal you choose as the standard (gold by default), while the other metal is checked on its own; and the customary jewellery limit is taken as 860 g, although 200 mithqal at 4.25 g gives 850 g.</p>
<h2 id="maliki">Maliki</h2>
<p>Permissible worn jewellery exempt; debts deducted from cash, gold, silver and trade goods; gold and silver combined; silver nisab by default (user may choose gold). Sources: Mufti of Wilayah Persekutuan, Irsyad Fatwa 38; SeekersGuidance (debts by madhab).</p>
<p>Maliki scholars first set a debt against things you own but do not need (a spare plot or car, for example), and only the rest reduces zakat. The calculator does not ask about such assets and deducts the whole debt; it shows a note whenever you enter a debt.</p>
<h2 id="hanbali">Hanbali</h2>
<p>Permissible jewellery kept for use or lending exempt; debts deducted; gold and silver combined; cash and trade goods measured by the nisab better for the poor. Source: <em>Akhsar al-Mukhtasarat</em>, Book of Zakat.</p>
<h2 id="ahlehadith">Ahl-e-Hadith</h2>
<p>Jewellery zakatable if it reaches the nisab; cash combined with gold and silver; lower nisab; debts not deducted. Sources: Permanent Committee (al-Lajnah ad-Da'imah), Shaykh Ibn Baz and Shaykh Ibn Uthaymeen via IslamQA answers <a href="https://islamqa.info/en/answers/19901" rel="noopener" target="_blank">19901</a>, <a href="https://islamqa.info/en/answers/201807" rel="noopener" target="_blank">201807</a> and <a href="https://islamqa.info/en/answers/22426" rel="noopener" target="_blank">22426</a>. We have not found a written fatwa from a Pakistani Ahl-e-Hadith institution on every point; this is our best reading. On adding gold and silver together these scholars differ: Shaykh Ibn Baz added them, while Shaykh Ibn Uthaymeen kept them separate. The calculator adds them.</p>
<h2 id="jafari">Shia (Ja'fari)</h2>
<p>Following Ayatollah Sistani, <a href="https://www.sistani.org/english/book/48/" rel="noopener" target="_blank"><em>Islamic Laws</em></a>, <a href="https://www.sistani.org/english/book/48/2317/" rel="noopener" target="_blank">ruling 1912</a> (gold) and <a href="https://www.sistani.org/english/book/48/2318/" rel="noopener" target="_blank">rulings 1913-1916</a> (silver, currency and jewellery): zakat on gold and silver only for coins used as currency (gold 69.12 g, silver 483.84 g); paper money and jewellery not zakatable today; khums applies to the yearly surplus.</p>
<h2>Gold, silver and currency rates</h2>
<p>Gold and silver spot prices in US dollars per troy ounce come from gold-api.com, with a daily fallback from the open currency-api by Fawaz Ahmed. Exchange rates come from the same currency-api. Our server refreshes them every hour and caches them; your browser never contacts these services. All values are international rates; you can enter your own local rate.</p>
<h2>Already paid and bank deduction</h2>
<p>Amounts entered under <em>Already paid</em> (the bank's 1 Ramadan deduction, or zakat you gave earlier this year) are subtracted from the zakat due, never below zero. Savings certificates are counted at the amount invested. See <a href="/bank-zakat-deduction-pakistan/">bank zakat deduction</a> and <a href="/zakat-on-savings-certificates/">zakat on savings certificates</a>.</p>
<h2>The other tools</h2>
<ul>
<li><strong><a href="/zakat-date-calculator/">Zakat date and missed years</a>:</strong> the next zakat date is one lunar year of 354.367 days after the day wealth reached the nisab ("no zakat until a year passes", <a href="https://sunnah.com/abudawud:1573" rel="noopener" target="_blank">Abu Dawud 1573</a>). Hijri dates are shown from the Umm al-Qura calendar, so local moon sighting can differ by a day. For missed years the Hanafi option treats each earlier year's unpaid zakat as a debt that lowers the next year's wealth (<em>al-Hidayah</em>).</li>
<li><strong><a href="/wirasat-calculator/">Wirasat (inheritance)</a>:</strong> the Qur'anic shares (al-Nisa 4:11, 4:12, 4:176) with 'awl and radd in exact fractions. Hanafi rules follow <em>al-Sirajiyyah</em> and Ibn Abidin's <em>Radd al-Muhtar</em>; the Shafi'i, Maliki and Hanbali rules follow the main texts of each school, including Zayd ibn Thabit's method for the grandfather with brothers; the Ahl-e-Hadith rules treat the grandfather as the father (the view of Abu Bakr and Ibn Abbas) and follow Ibn Taymiyyah on radd to the spouse (an open question, below); Ja'fari rules follow Ayatollah Sistani's <em>Islamic Laws</em> (three classes, no 'awl, a wife's share from buildings and not from land). Pakistani law (Muslim Family Laws Ordinance 1961, section 4) is shown as a separate result. The engine is checked against 425 worked cases, with 6 more kept as open questions where scholars differ. Results with distant relatives (dhawu al-arham) carry a note to confirm with a mufti.</li>
<li><strong><a href="/ushr-calculator/">Ushr</a>:</strong> 10% for land watered by rain or rivers and 5% for costly irrigation (<a href="https://sunnah.com/bukhari:1483" rel="noopener" target="_blank">Bukhari 1483</a>). Imam Abu Hanifa set no minimum; the other schools require 5 wasq, about 653 kg (Muslim 979). Ayatollah Sistani's minimum is higher (about 847 kg) and covers wheat, barley, dates and raisins only.</li>
<li><strong>Livestock:</strong> goats, sheep and camels up to 120 follow the letter of Abu Bakr (<a href="https://sunnah.com/bukhari:1454" rel="noopener" target="_blank">Bukhari 1454</a>); cows and buffaloes follow the hadith of Mu'adh (one tabi' for every 30, one musinnah for every 40). Camels above 120 and the Ja'fari tables are not calculated: ask a scholar.</li>
<li><strong><a href="/fitrana-calculator/">Fitrana</a> and <a href="/fidya-kaffara-calculator/">fidya and kaffara</a>:</strong> in Hanafi fiqh one fitrana or one day's fidya is half a sa' of wheat (about 1.75 to 2 kg) or one sa' of barley, dates or raisins, or its value; the other schools use one mudd (about 0.6 kg) for fidya. Kaffara is 60 days of fasting, or feeding 60 poor people only for someone who cannot fast (<a href="https://sunnah.com/bukhari:1936" rel="noopener" target="_blank">Bukhari 1936</a>, Muslim 1111). Enter the money amount announced by your scholars each Ramadan; the fitrana calculator may show amounts we have filled in from those announcements.</li>
<li><strong><a href="/haq-mehr-calculator/">Haq mehr</a>:</strong> mehr is measured in silver dirhams, at 3.0618 g of silver to one shar'i dirham, the figure used by Indo-Pak muftis (10 dirham = 2 tola 7.5 masha = 30.618 g). The Hanafi minimum is 10 dirham (<em>al-Hidayah</em>), about 30.62 g; Maulana Ashraf Ali Thanwi and Mufti Rasheed Ahmad Ludhianvi gave about 34 g, which is shown too. Mehr-e-Fatimi is 500 dirham (131.25 tola, about 1,530.9 g) by default, from Sayyidah Aisha's report of twelve and a half uqiyah (Sahih Muslim 1426), the figure of Mufti Muhammad Shafi; 480 dirham (Sayyiduna Umar's report, Abu Dawud 2106 and Tirmidhi 1114) and 400 dirham (Ibn al-Humam) are shown as other views. The Maliki minimum is a quarter dinar or 3 dirham; the Shafi'i, Hanbali and Ja'fari schools set no minimum. Unpaid mehr is a debt, and in Pakistan section 10 of the Muslim Family Laws Ordinance 1961 makes it payable on demand when the nikah nama is silent. Values use the live international silver rate.</li>
<li><strong><a href="/diyat-calculator/">Diyat</a>:</strong> section 323 of the Pakistan Penal Code sets diyat at no less than the value of 30,630 g of silver, close to the classical Hanafi 10,000 dirham (10,000 × 3.0618 g = 30,618 g). The rupee amount is the one the Finance Division notifies for each fiscal year: Rs 1,93,52,390 for 2026-27 (circular of 27 July 2026, in force from 1 July 2026). The calculator lists the earlier notified amounts with their sources and shows the live value of 30,630 g of silver for information only; for a court case the notified amount is the legal minimum. The madhab figures (100 camels, 1,000 dinar, 10,000 or 12,000 dirham) are listed on the diyat page; Surah an-Nisa 4:92 is the Quranic basis.</li>
<li><strong><a href="/qurbani-calculator/">Qurbani</a>:</strong> Hanafi fiqh makes qurbani wajib on a sane, adult, resident Muslim who owns the zakat nisab on 10 to 12 Dhul Hijjah (<em>Bada'i al-Sana'i</em>). We use the same nisab test as for zakat (silver for mixed wealth, gold by weight when gold is all a person owns, debts due now deducted), with two differences: no lunar year is required, and things kept beyond basic needs count even when they carry no zakat. A traveller (musafir) is exempt. For the Shafi'i, Maliki and Hanbali schools and most Ahl-e-Hadith scholars it is a sunnah mu'akkadah, and for Ayatollah Sistani a recommended act, so the tool states the ruling and shows the Hanafi test for information. The Eid date is 10 Dhul Hijjah by the Umm al-Qura calendar.</li>
<li><strong><a href="/iddat-calculator/">Iddat</a>:</strong> a widow waits four months and ten days (al-Baqarah 2:234), counted by the moon when the death fell on the 1st of an Islamic month and as 130 days otherwise, Imam Abu Hanifa's rule for a broken month, which we apply to every school (others may differ by a day or two). A divorcee waits three quru' (2:228): three complete periods in the Hanafi, Hanbali and Ahl-e-Hadith settings, three purities in the Shafi'i, Maliki and Ja'fari settings; three months (90 days off the 1st) without periods (65:4); until birth when pregnant (65:4), and for a Ja'fari widow the later of birth and four months ten days. There is no divorce iddat before consummation (33:49); for the Hanafi and Hanbali settings a valid private meeting counts as consummation. Khula takes one period in the Ahl-e-Hadith setting (Abu Dawud 2229). For a divorce the end date is projected from the woman's last period, cycle length and days of bleeding, so it is an estimate. The Pakistan date is 90 days from the talaq, assuming notice to the Union Council chairman the same day (MFLO 1961 s. 7).</li>
<li><strong><a href="/khums-calculator/">Khums</a>:</strong> 20% of the year's surplus income, split equally into sahm-e-imam and sahm-e-sadat, following Ayatollah Sistani's <em>Islamic Laws</em> (khums chapter, rulings 1769 onwards and 1851). Gifts count as income; inheritance and mahr do not.</li>
</ul>
<h2>What is not covered</h2>
<ul><li>Pension and provident funds, where scholars differ</li><li>Camels above 120, and Shia livestock tables</li><li>Exact local moon-sighting dates</li></ul>
<h2>Open questions</h2>
<p>These rules are disputed or not yet confirmed. We have put them to scholars and will update the calculator and this page when we get written answers:</p>
<ul>
<li>Hanafi: jewellery that is mostly gold (pure content or full weight).</li>
<li>Shafi'i: adding cash to the chosen metal; the customary jewellery limit (850 or 860 g); 85 g or 87.48 g for the gold nisab.</li>
<li>Maliki: setting debts against spare non-zakatable assets first.</li>
<li>Ahl-e-Hadith: confirmation of each rule by a Pakistani Ahl-e-Hadith institution.</li>
<li>Inheritance, Ahl-e-Hadith: returning the remainder (radd) to a lone husband or wife. Our setting follows Ibn Taymiyyah, who allowed it; many scholars do not.</li>
<li>Fidya: the calculator uses the Hanafi amount (one fitrana a day); the Shafi'i, Maliki and Hanbali schools use one mudd (about 0.6 kg of food), which is less.</li>
</ul>
<h2>Changes</h2>
<ul>
<li><strong>18 October 2026 (official figures):</strong> the nisab, fitrana, fidya and diyat pages show the latest figure announced in Pakistan with its source, and past years' bank nisab (2021 to 2026) and fitrana amounts (2024 to 2026) in tables. Years we could not check against a published announcement are left out. Each madhab page now lists its rules with sources and has a worked example in rupees. A new <a href="/zakat-2027-pakistan/">zakat 2027 Pakistan</a> page collects this season's dates.</li>
<li><strong>18 October 2026 (sources):</strong> the hadith, verses, fatwas, books and laws cited on our pages now link to their source (sunnah.com, quran.com, the fatwa pages, Ayatollah Sistani's rulings and the Finance Division circular); this page now also explains the haq mehr and diyat rules; the About page has a fuller note on who writes the site; guides label their published and updated dates. No calculation result changed.</li>
<li><strong>18 October 2026 (accuracy):</strong> the Ahl-e-Hadith rule on returning the remainder to a lone husband or wife is now marked as an open question; the fidya and kaffara examples use the Council of Islamic Ideology's 1447 amounts (Rs 300 by wheat, Rs 1,600 by dates); quick answers with a live rupee figure show the time of the rate; the inheritance engine is described as checked against 425 cases plus 6 open questions. No calculation result changed.</li>
<li><strong>18 October 2026 (inheritance):</strong> the <a href="/wirasat-calculator/">wirasat calculator</a> page now describes every feature of the calculator (six madhabs side by side, the worked sheet, what-if, share link and istifta, mamu, khala, phuphi and nana), and four guides were added on the <a href="/daughters-share-in-inheritance/">daughter's share</a>, the <a href="/wife-husband-share-in-inheritance/">wife's and husband's share</a>, <a href="/orphaned-grandchildren-inheritance/">orphaned grandchildren</a> and <a href="/zakat-on-inherited-wealth/">zakat on inherited wealth</a>. No calculation result changed.</li>
<li><strong>17 October 2026 (accessibility and privacy):</strong> the calculator now works fully in Urdu (Urdu madhab names, units and an Urdu font), screen readers hear only the zakat total once you stop typing, and a <em>Delete saved data</em> button removes everything the calculators kept in your browser. Urdu names in the PDF report are spelled in Roman letters. No calculation result changed.</li>
<li><strong>17 October 2026 (Urdu):</strong> added Urdu pages for the <a href="/zakat-calculator-urdu/">zakat calculator</a>, <a href="/nisab-urdu/">nisab</a>, <a href="/zakat-on-gold-urdu/">zakat on gold</a> and <a href="/fitrana-calculator-urdu/">fitrana</a>, with worked examples on several English pages. They use the same rules as the English pages; no calculation result changed.</li>
<li><strong>17 October 2026:</strong> the silver nisab is now shown everywhere as 612.35 g, the figure the calculator uses (52.5 tola of 11.6638 g); results did not change.</li>
<li><strong>16 October 2026:</strong> listed the open questions above; added notes in the calculator for Hanafi gold jewellery, Maliki debts and fidya by madhab; marked rules without a specific source as our reading. No calculation result changed.</li>
</ul>
<h2>How the content is checked</h2>
<p>The rules and guides on this site are compiled from the sources above and approved by Ali Ahmad, who publishes the site. They have not yet been reviewed by a scholar on our behalf; when that happens, the reviewer's name will be shown on every page. If you find a mistake, please <a href="/contact/">tell us</a> and we will correct it.</p>
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
		'llms'  => true,
		'content' => <<<'HTML'
<p>We read every message. The fastest way to reach us is email:</p>
<p><strong><a href="mailto:contact@myzakattool.com">contact@myzakattool.com</a></strong></p>
<h2>Reporting an error</h2>
<p>Please tell us the page, the madhab you selected and what you expected. You can also use the <em>Report an error</em> button under any result. Do not send personal financial details.</p>
<p>A useful error report includes:</p>
<ul>
<li>the page address (for example /zakat-calculator-pakistan/);</li>
<li>the madhab and currency you chose;</li>
<li>the type of wealth involved (gold, cash, debts, stock...) with round example figures, not your real ones;</li>
<li>the result you got and the result you expected, with the fatwa or book you are relying on if you have one.</li>
</ul>
<p>When a report leads to a correction, we fix it and record it with its date on the <a href="/methodology/">methodology</a> page.</p>
<h2>Suggestions and translations</h2>
<p>Tell us which tool, currency or language you would like next. If you can help check our Urdu text, or translate the calculator into another language, we would be glad to hear from you.</p>
<h2>Mosques and websites</h2>
<p>To show today's nisab on your own website, use the <a href="/free-zakat-widget/">free nisab widget</a>. Write to us if you need a different size or design.</p>
<h2>Religious questions</h2>
<p>We do not issue fatwas. For a ruling about your own situation, please ask a qualified scholar of your school, for example the imam of your mosque or a recognised fatwa service such as the Darul Ifta of a major madrasa (Hanafi), IslamQA (Salafi and Ahl-e-Hadith), your country's Mufti office (Shafi'i, Maliki and Hanbali), or your marja's office (Shia). Our <a href="/methodology/">methodology</a> lists the sources we use.</p>
<h2>What we cannot do</h2>
<ul>
<li>We do not collect, hold or distribute zakat, fitrana or donations. Anyone asking you to pay zakat to "My Zakat Tool" is not us.</li>
<li>We cannot see or recover the figures you entered; they never leave your device.</li>
</ul>
<p>Prefer Urdu? Write to us in Urdu or Roman Urdu, or use the <a href="/zakat-calculator-urdu/">Urdu calculator</a>.</p>
HTML
		. $author,
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
HTML
		. $author,
		'faq'   => array(),
	);

	$p['privacy-policy'] = array(
		'title' => 'Privacy Policy',
		'seo'   => 'Privacy Policy | My Zakat Tool',
		'desc'  => 'What My Zakat Tool collects (very little), why calculator entries never leave your device, and how cookies, analytics and advertising work on this site.',
		'nav'   => 'Privacy',
		'blurb' => 'your data',
		'content' => <<<'HTML'
<p>Last updated: 16 October 2026. This policy explains what information this website handles.</p>
<h2>Calculator entries stay on your device</h2>
<p>Everything you type into the calculators is processed in your own browser. It is not sent to our server. If you use <em>Save data file</em>, the file is saved on your device. A draft may be kept in your browser's local storage so your entries are still there when you return. It is removed automatically after 13 months without use. <em>Clear all</em> removes the draft, and <em>Delete saved data</em> removes everything the calculators saved in your browser (amounts, family members, language choice and reminder dates).</p>
<h2>PDF reports</h2>
<p>PDF reports are created in your browser and downloaded directly. We never receive them.</p>
<h2>Fonts</h2>
<p>The inheritance calculator pages load the Gulzar and Noto Naskh Arabic Urdu fonts from Google Fonts so the family tree looks the same on every device. Your browser requests it from Google, which receives your IP address. Nothing you type in the calculator is sent. If you use its share link, the family, names and amounts you entered are written into the link itself (after the # sign, which browsers do not send to our server); anyone you give the link to can see them, so share it only with people you trust.</p>
<h2>Server logs</h2>
<p>Like every website, our hosting provider records technical logs (IP address, browser, pages requested, time) for security and to keep the site running. These are kept for a limited time.</p>
<h2>Cookies, analytics and advertising</h2>
<p>We may use privacy-friendly analytics to count visits. If advertising is enabled, Google may use cookies to show ads, including personalised ads where you have agreed. You can manage Google ad personalisation at <a href="https://adssettings.google.com" rel="noopener nofollow" target="_blank">adssettings.google.com</a>. Advertising is currently switched off. It will only be switched on after Google's consent message is set up, so that visitors in the EEA, UK and Switzerland are asked for consent before such cookies are used.</p>
<h2>Email</h2>
<p>If you email us, we use your email only to reply.</p>
<h2>Children</h2>
<p>This site is not directed at children and does not knowingly collect their data.</p>
<h2>Contact</h2>
<p><a href="mailto:contact@myzakattool.com">contact@myzakattool.com</a></p>
HTML
		. $author,
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
HTML
		. $author,
		'faq'   => array(),
	);

	// Zakat on salary, property, shares, provident fund, crypto, committee, expats and India (FIX-158, FIX-166).
	return $p + myzt_content_assets_a() + myzt_content_assets_b() + myzt_content_iddat_qurbani();
}

require_once __DIR__ . '/content-assets-a.php';
require_once __DIR__ . '/content-assets-b.php';
require_once __DIR__ . '/content-iddat-qurbani.php';

/** Guide articles, created as posts in the "Guides" category. */
require_once __DIR__ . '/content-posts.php';
