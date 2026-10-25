<?php
/**
 * Guide posts (category "Guides"). Loaded by content.php.
 *
 * @package MyZakatTool
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/content-posts-tools.php';
require_once __DIR__ . '/content-posts-wirasat.php';
require_once __DIR__ . '/content-posts-guides.php';

function myzt_content_posts() {
	$author = '[myzt_author]';
	return myzt_content_posts_tools() + myzt_content_posts_wirasat() + myzt_content_posts_guides() + array(
		'who-can-receive-zakat'         => array(
			'title'   => 'Who Can Receive Zakat? The 8 Categories Explained',
			'seo'     => 'Who Can Receive Zakat? 8 Groups of Quran 9:60 & Who Cannot',
			'desc'    => 'Zakat goes to 8 groups (Quran 9:60), mainly the poor, the needy and those in debt. It cannot go to your parents, children, wife or (Sunni schools) Sayyids.',
			'nav'     => 'Who can receive zakat',
			'blurb'   => 'masarif-e-zakat',
			'content' => <<<'HTML'
[myzt_answer q="Who can receive zakat?"]The Quran (9:60) names eight groups: the poor (fuqara), the needy (masakin), zakat workers, those whose hearts are to be reconciled, freeing captives, people in debt, in the cause of Allah, and stranded travellers. Your own parents and children cannot receive your zakat, and a husband cannot give his to his wife; whether a wife may give hers to a poor husband is disputed.[/myzt_answer]
<p>Working out how much zakat you owe is half the job. The other half is making sure it reaches someone who is allowed to take it, because zakat given to the wrong person does not count as paid. Here is the list from the Quran, followed by the people scholars agree you should not give to, and the most common mistakes.</p>
<h2>Who are the 8 categories of zakat (masarif-e-zakat)?</h2>
<blockquote><p>"Zakat is only for the poor, the needy, those employed to collect it, those whose hearts are to be reconciled, freeing captives, those in debt, in the cause of Allah, and the traveller: an obligation from Allah." (Surah at-Tawbah 9:60)</p></blockquote>
<ol>
<li><strong>Fuqara (the poor):</strong> in Hanafi fiqh, a person who does not own wealth at the nisab level beyond basic needs (home, clothes, household goods, tools of work). A salaried person can still be eligible if, after basic needs, they hold less than the nisab.</li>
<li><strong>Masakin (the needy):</strong> people in even greater hardship, who may not have enough for the day.</li>
<li><strong>Zakat workers ('amilin):</strong> people appointed by a government or an organised body to collect and distribute zakat. Volunteers at your local mosque are not automatically in this category.</li>
<li><strong>Those whose hearts are to be reconciled:</strong> new Muslims and others the Islamic state wished to bring closer. Hanafi scholars hold that this share is not in use today; the other schools keep it.</li>
<li><strong>Freeing captives (riqab):</strong> originally freeing slaves; many scholars today apply it to ransoming prisoners held unjustly.</li>
<li><strong>People in debt (gharimin):</strong> someone who cannot repay a debt taken for a permissible need. Clearing a poor neighbour's hospital bill or overdue rent falls here.</li>
<li><strong>In the cause of Allah (fi sabilillah):</strong> in classical Hanafi fiqh, a needy person striving in Allah's path, including a poor student of religious knowledge.</li>
<li><strong>Stranded travellers (ibn as-sabil):</strong> someone who has run out of money away from home, even if they are well off at home.</li>
</ol>
<h2>Who cannot receive your zakat?</h2>
<ul>
<li><strong>Your parents and grandparents, children and grandchildren.</strong> You already have a duty to support them, so help them from your other money.</li>
<li><strong>Your wife.</strong> A husband may not give his zakat to his wife. Whether a wife may give her zakat to a poor husband is disputed: Imam Abu Hanifa said no, while Imam Abu Yusuf, Imam Muhammad and the Shafi'i school allow it, based on the hadith of Zaynab, the wife of Ibn Mas'ud.</li>
<li><strong>Anyone who owns wealth at the nisab or above</strong> beyond their basic needs.</li>
<li><strong>Sayyids (Banu Hashim)</strong> in all four Sunni schools. In Ja'fari fiqh a Sayyid may receive zakat from another Sayyid only; khums (sahm-e-sadat) is meant for them.</li>
<li><strong>Your own employees as part of their salary.</strong> Wages are owed anyway; zakat cannot replace them.</li>
</ul>
<p>Brothers, sisters, uncles, aunts, nephews, nieces and in-laws who are eligible may receive your zakat, and the Prophet ﷺ said giving to a relative is both charity and keeping family ties, so it carries a double reward (Tirmidhi 658).</p>
<h2>Common mistakes</h2>
<ul>
<li><strong>Building a mosque or madrasa with zakat.</strong> Most scholars, and the Hanafi school in particular, say zakat must become the property of a deserving person (tamlik). Construction does not do that. Give to institutions that keep a separate zakat fund for needy students and patients.</li>
<li><strong>Paying a domestic worker's salary from zakat.</strong> You can give a poor worker zakat as a separate gift, but not as wages.</li>
<li><strong>Giving to a "poor-looking" person without asking.</strong> If you have a reasonable belief they are eligible and later learn they were not, Hanafi scholars say your zakat is still valid. Making a sensible effort is enough.</li>
<li><strong>Waiting for Ramadan when someone needs help now.</strong> You may pay zakat in advance of the due date in the Hanafi, Shafi'i and Hanbali schools.</li>
</ul>
<h2>Practical tips</h2>
<ul>
<li>Make the intention (niyyah) of zakat when you give it, or when you set the money aside for it.</li>
<li>You do not have to tell the person it is zakat. Calling it a gift is fine and saves their dignity.</li>
<li>If you use a charity, ask whether zakat money is kept separate and how it reaches individuals.</li>
<li>Keep a short record of what you gave and to whom. It helps next year.</li>
</ul>
<p>First work out how much you owe with the <a href="/">zakat calculator</a>. If you follow Fiqh-e-Jafaria, see the <a href="/khums-calculator/">khums calculator</a> as well.</p>
[myzt_faq]
HTML
			. $author . '[myzt_related slugs="home,fitrana-calculator,madhab-comparison,khums-calculator"]',
			'faq'     => array(
				array( 'q' => 'Can I give zakat to my brother or sister?', 'a' => 'Yes, if they are eligible (they do not own the nisab beyond basic needs). Giving to relatives carries extra reward.' ),
				array( 'q' => 'Can zakat be given to a Sayyid?', 'a' => 'Not in the four Sunni schools. In Ja\'fari fiqh a Sayyid may take zakat only from another Sayyid.' ),
				array( 'q' => 'Kya zakat masjid ki tameer mein lag sakti hai?', 'a' => 'Aksar ulama, khaas tor par Hanafi, ke nazdeek nahi, kyun ke zakat kisi mustahiq shakhs ki milkiyat mein jana zaroori hai (tamlik).' ),
				array( 'q' => 'Do I have to tell the person it is zakat?', 'a' => 'No. Your intention is what counts; you can hand it over as a gift.' ),
			),
		),

		'zakat-on-jewellery'            => array(
			'title'   => 'Zakat on Jewellery: What the 4 Madhabs and Shia Say',
			'seo'     => 'Zakat on Jewellery: Hanafi, Shafi\'i, Maliki, Hanbali, Shia',
			'desc'    => 'Is zakat due on gold jewellery you wear? The Hanafi, Shafi\'i, Maliki, Hanbali, Ahl-e-Hadith and Shia rulings with sources, plus how to value it and who pays.',
			'nav'     => 'Zakat on jewellery',
			'blurb'   => 'zevar par zakat',
			'content' => <<<'HTML'
[myzt_answer q="Is zakat due on jewellery?"]In the Hanafi madhab and according to the Saudi Permanent Committee (which our Ahl-e-Hadith calculator follows), yes, even if it is worn. In the Shafi'i, Maliki and Hanbali madhabs permissible jewellery that is worn is exempt. According to Ayatollah Sistani it is exempt today.[/myzt_answer]
<p>Jewellery is where the schools differ most, and it is often the biggest item in a family's zakat. A woman with 10 tola of 22K gold could owe a large amount in one madhab and nothing in another. Below is what each school says, with the source we rely on, and then the practical questions: how to weigh it, what price to use and whose zakat it is.</p>
<h2>Is worn jewellery zakatable for Hanafis?</h2>
<p>Zakat is due on gold and silver jewellery whether it is worn every day or kept in a locker. Darul Uloom Deoband: "Zakah is wajib on them though they are used daily" (Fatwa 2310/H=713/th=1431). The Hanafi view rests on hadith such as the woman whose daughter wore gold bangles, whom the Prophet ﷺ asked whether she paid their zakat (Abu Dawud 1563).</p>
<h2>Is worn jewellery exempt for Shafi'is?</h2>
<p>No zakat on permissible jewellery that is worn, as long as it stays within what is customary (around 860 g of gold is the guideline used by MUIS, Singapore, citing al-Majmu'). Jewellery kept as an investment, or men's gold, is zakatable.</p>
<h2>What do the Maliki and Hanbali schools say?</h2>
<p>Permissible jewellery that is used or lent out is exempt (Irsyad Fatwa 38 for the Maliki school; <em>Akhsar al-Mukhtasarat</em> for the Hanbali). Jewellery bought to hold value or to trade is zakatable.</p>
<h2>Is jewellery zakatable for Ahl-e-Hadith?</h2>
<p>"The more correct view is that zakat on jewellery is obligatory if it reaches the nisab" (IslamQA 19901, citing the Permanent Committee). Our Ahl-e-Hadith calculator follows this view; we have not found a Pakistani Ahl-e-Hadith fatwa on it, so check with your own scholar.</p>
<h2>Is there zakat on jewellery in Shia fiqh (Sistani)?</h2>
<p>Women's gold and silver ornaments are not zakatable while gold and silver are not used as currency (Islamic Laws, ruling 1916). Khums may still apply to jewellery bought from income on which khums was not paid; see the <a href="/khums-calculator/">khums calculator</a>.</p>
<h2>How do you value jewellery for zakat?</h2>
<ul>
<li><strong>Count only the gold or silver.</strong> Stones, pearls, lacquer and beads are not zakatable unless you trade in them. If a set weighs 3 tola including stones, ask the jeweller for the gold weight or estimate it.</li>
<li><strong>Use the purity.</strong> 22K is 91.7% pure gold, 21K is 87.5% and 18K is 75%. The calculator applies this when you choose the karat.</li>
<li><strong>Ignore making charges.</strong> What you paid for design and labour is not part of the zakat value.</li>
<li><strong>Price:</strong> scholars say to use the value on your zakat date. Many Pakistani muftis prefer the price a jeweller would pay you, which is a little below the shop price. Our <a href="/gold-rate-today/">gold rate today</a> page shows the international price, which you can use or replace with your own local rate in the calculator.</li>
<li><strong>Artificial jewellery</strong> carries no zakat in any school.</li>
</ul>
<h2>Who pays: husband or wife?</h2>
<p>Zakat is due on the owner. Jewellery given to a bride as her property (from her parents or as mahr) is hers, and it is her zakat, calculated together with her own savings. If she has no cash, she may pay from the jewellery itself, or her husband may pay on her behalf with her permission. Jewellery the husband bought and still owns, which his wife only wears, is his zakat in the Hanafi view. The family mode in our calculator lets you calculate each person separately.</p>
<p><strong>Inherited jewellery</strong> follows the same rule as jewellery you bought: it is yours once your share is settled, and your school's ruling on worn or stored jewellery applies. See <a href="/zakat-on-inherited-wealth/">zakat on inherited wealth</a>, and the <a href="/wirasat-calculator/">wirasat calculator</a> for each heir's share of the gold in tola and grams.</p>
<h2>Example</h2>
<p>Ayesha owns 8 tola of 22K jewellery and Rs 50,000 in savings. In the Hanafi madhab the gold and cash are added and checked against the silver nisab, so zakat is due on both. In the Shafi'i madhab her worn jewellery is exempt and Rs 50,000 is below the nisab, so nothing is due. Try the same numbers in the <a href="/madhab-comparison/">madhab comparison</a>.</p>
<p>Calculate it now with the <a href="/zakat-on-gold-calculator/">zakat on gold calculator</a>, or read <a href="/zakat-on-1-tola-gold/">how much zakat is due on 1 tola</a>. Families who keep wealth in a plot or a second house rather than in gold should read <a href="/zakat-on-property/">zakat on property</a>, which explains when a plot is zakatable and when it is not.</p>
[myzt_faq]
HTML
			. $author . '[myzt_related slugs="zakat-on-gold-calculator,madhab-comparison,hanafi-zakat-calculator,shafi-zakat-calculator"]',
			'faq'     => array(
				array( 'q' => 'Is there zakat on gold I wear every day?', 'a' => 'In the Hanafi and Ahl-e-Hadith view, yes. In the Shafi\'i, Maliki and Hanbali view, permissible worn jewellery is exempt. Ayatollah Sistani also exempts it.' ),
				array( 'q' => 'Do I pay zakat on the stones in my jewellery?', 'a' => 'No. Only the gold or silver content counts, unless you deal in gems as a business.' ),
				array( 'q' => 'Biwi ke zevar ki zakat kaun dega?', 'a' => 'Jo malik hai. Agar zevar biwi ki milkiyat hai to zakat us par hai; shohar uski ijazat se ada kar sakta hai.' ),
				array( 'q' => 'Which price should I use, buying or selling?', 'a' => 'The value on your zakat date. Many muftis prefer the selling price (what a jeweller would pay you).' ),
				array( 'q' => 'Kya artificial zevar par zakat hai?', 'a' => 'Nahi. Artificial zevar par kisi maslak mein zakat nahi; zakat sirf sone aur chandi par hai.' ),
				array( 'q' => 'Zevar ki zakat mein nag aur banwai bhi gini jati hai?', 'a' => 'Nahi. Sirf sone ya chandi ka wazan gina jata hai; nag, moti aur banwai (making charges) ki qeemat nahi. 22 karat zevar mein sirf khalis sona (91.7%) gina jata hai.' ),
			),
		),

		'zakat-on-1-tola-gold'          => array(
			'title'   => 'How Much Zakat on 1 Tola Gold?',
			'seo'     => 'Zakat on 1 Tola Gold Today: {rate:gold-tola-zakat} (24K), 22K Too',
			'desc'    => 'Zakat on 1 tola of 24K gold today is {rate:gold-tola-zakat}, and {rate:gold22-tola-zakat} for 22K (2.5% of the live rate). When it is due, and worked examples.',
			'nav'     => 'Zakat on 1 tola gold',
			'blurb'   => '1 tola sone ki zakat',
			'content' => <<<'HTML'
[myzt_answer q="How much zakat on 1 tola of gold?"]Today 1 tola of 24K gold is worth about [myzt_rate type="gold-tola" currency="PKR"], so 2.5% is about [myzt_rate type="gold-tola-zakat" currency="PKR"]. For 22K gold it is about [myzt_rate type="gold22-tola-zakat" currency="PKR"]. Whether you actually owe it depends on what else you own.[/myzt_answer]
<p>"1 tola par kitni zakat?" is one of the most searched zakat questions in Pakistan, and the honest answer has two parts: the amount, which is simple, and whether it is due at all, which depends on the rest of your wealth and your madhab.</p>
<h2>How much zakat on 1 tola of gold?</h2>
<p>Zakat is one fortieth (2.5%) of the value. 1 tola is 11.664 g. For 24K gold multiply today's tola rate by 0.025. For 22K gold first multiply the 24K price by 22/24 (about 91.7%), because only the pure gold counts. The figures in the box above update with the international rate every hour.</p>
<h2>Is zakat due on just 1 tola?</h2>
<p><strong>If 1 tola of gold is all you own:</strong> no, in every Sunni school. It is below the gold nisab of 7.5 tola (87.48 g).</p>
<p><strong>If you also have cash, savings, silver or business stock:</strong> in the Hanafi madhab you add everything together and compare the total with the silver nisab, which today is only about [myzt_rate type="nisab-silver" currency="PKR"]. Most families with any savings cross it, and then zakat is due on the 1 tola as well. Our Ahl-e-Hadith calculator, following the Permanent Committee, also adds gold to cash and uses the lower nisab, so the result is similar. Hanbali scholars do the same for a gold coin or bar, but exempt the 1 tola if it is jewellery that is worn.</p>
<p><strong>In the Shafi'i madhab</strong> gold is not added to silver, and worn jewellery is exempt, so 1 tola alone or worn as jewellery carries no zakat.</p>
<h2>Example 1: gold plus savings (Hanafi)</h2>
<p>You have 1 tola of 22K gold and Rs 2,00,000 in the bank. Together they are above the silver nisab, so you pay 2.5% of the whole amount: Rs 5,000 on the cash plus about [myzt_rate type="gold22-tola-zakat" currency="PKR"] on the gold.</p>
<h2>Example 2: gold only</h2>
<p>A student has a 1 tola chain and no savings. Nothing is due, because 1 tola is below the 7.5 tola gold nisab and there is nothing else to add to it.</p>
<h2>Example 3: several tola</h2>
<p>For 5 tola multiply the 1 tola figure by five. Remember to subtract debts that are due now if your madhab allows it; the <a href="/hanafi-zakat-calculator/">Hanafi calculator</a> does this for you.</p>
<h2>Zakat on 1 to 50 tola gold today</h2>
<p>The table below is worked out from today's international rate ([myzt_rate_date]). It shows the value of 24K gold and the zakat due on it, and the zakat on the same weight of 22K jewellery, where only the pure gold (91.7%) is counted.</p>
[myzt_tola_table currency="PKR"]
<p>The table gives the zakat on the gold alone. Whether it is due depends on the rest of your wealth and your madhab, as the sections above explain.</p>
<h2>How much zakat on 10 tola gold?</h2>
<p>Zakat on 10 tola (116.64 g) of 24K gold is 0.25 tola of gold, or its value, about ten times the 1 tola figure: see the 10 tola row above. 10 tola is above the gold nisab of 7.5 tola, so in every Sunni school zakat is due on it once a lunar year has passed, even if you own nothing else. The exception is jewellery that is worn: in the Shafi'i, Maliki and Hanbali madhabs it is exempt, while Hanafi and Ahl-e-Hadith scholars count it. For 10 tola of 22K jewellery the pure gold is 9.17 tola, still above the nisab.</p>
<h2>How much zakat on 7.5 tola gold?</h2>
<p>7.5 tola is exactly the gold nisab (87.48 g of pure gold). If you own 7.5 tola of 24K gold and nothing else, zakat is due on it: 2.5% of its value, shown in the 7.5 tola row. If the 7.5 tola is 22K jewellery, it contains only 6.875 tola of pure gold, which is below the gold nisab when counted alone; many Hanafi muftis, however, count the full weight of jewellery that is mostly gold, so ask your scholar. If you have even a little cash or savings as well, the Hanafi silver nisab applies and zakat is due on all of it.</p>
<h2>Paying in gold or in money</h2>
<p>You may give the zakat as gold (one fortieth of the weight: 0.025 tola, or about 0.29 g, for each tola) or as its value in money. Most people pay money, which is easier for the person receiving it. Use the market value of the gold on your zakat date, not the price you paid.</p>
<h2>1 tola in grams, masha and ratti</h2>
<figure class="wp-block-table"><table><thead><tr><th>Unit</th><th>Equals</th></tr></thead><tbody>
<tr><td>1 tola</td><td>11.664 g = 12 masha = 96 ratti</td></tr>
<tr><td>1 masha</td><td>0.972 g = 8 ratti</td></tr>
<tr><td>1 ratti</td><td>0.1215 g</td></tr>
<tr><td>Zakat on 1 tola</td><td>0.025 tola = 0.29 g (about 2.4 ratti)</td></tr>
</tbody></table></figure>
<h2>Common mistakes</h2>
<ul>
<li><strong>Using the purchase price.</strong> Zakat is on today's value on your zakat date.</li>
<li><strong>Counting 22K or 21K jewellery as 24K.</strong> Only the pure gold counts; choose the karat in the calculator.</li>
<li><strong>Adding stones and making charges.</strong> These are not gold and are not counted.</li>
<li><strong>Forgetting the rest of your wealth.</strong> In the Hanafi madhab a small amount of gold with some savings usually makes zakat due on both.</li>
<li><strong>Paying for the wrong person.</strong> Zakat is due from the owner of the gold, often the wife, not the husband.</li>
</ul>
<p>Enter your own numbers in the <a href="/zakat-on-gold-calculator/">zakat on gold calculator</a>, or see today's <a href="/gold-rate-today/">gold rate</a> and <a href="/nisab/">nisab</a>. In Urdu, read <a href="/zakat-on-gold-urdu/">سونے پر زکوٰۃ</a>.</p>
[myzt_faq]
HTML
			. $author . '[myzt_related slugs="zakat-on-gold-calculator,gold-rate-today,nisab,zakat-on-1-lakh-rupees"]',
			'faq'     => array(
				array( 'q' => 'Is zakat due on 1 tola gold?', 'a' => 'Only if, together with your cash and other zakatable wealth, you are above the nisab (in the Hanafi view, the silver nisab). 1 tola alone is below the gold nisab.' ),
				array( 'q' => '1 tola mein kitne gram hote hain?', 'a' => '1 tola 11.664 gram ka hota hai.' ),
				array( 'q' => 'How much zakat on 10 tola gold?', 'a' => 'A quarter tola of gold (0.25 tola) or its value, about ten times the 1 tola figure; see the 10 tola row in the table. 10 tola is above the 7.5 tola gold nisab, so it is due once the year has passed, unless it is worn jewellery and you follow the Shafi\'i, Maliki or Hanbali madhab.' ),
				array( 'q' => '1 tola sone ki zakat kitni hoti hai?', 'a' => '1 tola sone ki aaj ki qeemat ka 2.5%, yani chalisvan hissa. Upar table mein 1 se 50 tola tak aaj ke rate se zakat di gayi hai. Agar sirf 1 tola sona ho aur kuch aur maal na ho to zakat farz nahi.' ),
				array( 'q' => '10 tola sone par kitni zakat hai?', 'a' => 'Paa tola (0.25 tola) sona ya us ki qeemat. Table mein 10 tola wali line dekhein.' ),
			),
		),

		'zakat-on-1-lakh-rupees'        => array(
			'title'   => 'Zakat on 1 Lakh Rupees: How Much?',
			'seo'     => 'Zakat on 1 Lakh Rupees = Rs 2,500 (Table up to 50 Lakh)',
			'desc'    => 'Zakat on Rs 1 lakh is Rs 2,500 (2.5%) when your total wealth is above the nisab, today {rate:nisab-silver}. Table from Rs 50,000 to Rs 50 lakh, and when none is due.',
			'nav'     => 'Zakat on 1 lakh',
			'blurb'   => '1 lakh ki zakat',
			'content' => <<<'HTML'
[myzt_answer q="How much zakat on 1 lakh rupees?"]Rs 2,500, which is 2.5% of Rs 1,00,000, if your total zakatable wealth has been at or above the nisab for a lunar year. If Rs 1 lakh is all you own, it is below today's silver nisab of about [myzt_rate type="nisab-silver" currency="PKR"], so nothing is due.[/myzt_answer]
<p>The 2.5% part is easy: divide by 40. What people get wrong is the condition in front of it. Zakat is not charged on each lakh you hold; it is charged on your total wealth once that total crosses the nisab and a lunar year has passed.</p>
<h2>Quick table</h2>
<figure class="wp-block-table"><table><thead><tr><th>Amount</th><th>Zakat (2.5%)</th></tr></thead><tbody>
<tr><td>Rs 50,000</td><td>Rs 1,250</td></tr>
<tr><td>Rs 1,00,000</td><td>Rs 2,500</td></tr>
<tr><td>Rs 2,00,000</td><td>Rs 5,000</td></tr>
<tr><td>Rs 5,00,000</td><td>Rs 12,500</td></tr>
<tr><td>Rs 10,00,000</td><td>Rs 25,000</td></tr>
<tr><td>Rs 25,00,000</td><td>Rs 62,500</td></tr>
<tr><td>Rs 50,00,000</td><td>Rs 1,25,000</td></tr>
</tbody></table></figure>
<p>These amounts apply only when your total is above the nisab.</p>
<h2>Is 1 lakh above the nisab?</h2>
<p>On its own, not at today's prices. The silver nisab, which Hanafi scholars use for cash, is about [myzt_rate type="nisab-silver" currency="PKR"]. But very few people own cash only. Add your gold, silver, bank balance, committee (BC) payments made so far, prize bonds and business stock. If the total crosses the nisab, zakat is due on all of it, including the 1 lakh.</p>
<h2>Example</h2>
<p>Bilal has Rs 1,00,000 cash and 2 tola of 22K gold. Together they are well above the silver nisab, so in the Hanafi madhab he pays Rs 2,500 on the cash plus 2.5% of the gold's value. If he also owes Rs 30,000 due this month, he subtracts it first.</p>
<h2>1, 2, 5 and 10 lakh: due or not, and will the bank deduct?</h2>
<p>Here is the same money looked at three ways: the 2.5%, whether it reaches the silver nisab on its own (about [myzt_rate type="nisab-silver" currency="PKR"] today), and whether a Pakistani bank would have cut zakat from it on 1 Ramadan 1447 (2026), when the deduction threshold was Rs 5,03,529.</p>
<figure class="wp-block-table"><table><thead><tr><th>Amount (your only wealth)</th><th>2.5%</th><th>Reaches the silver nisab on its own?</th><th>Bank deduction in 2026 (savings account)</th></tr></thead><tbody>
<tr><td>Rs 1,00,000</td><td>Rs 2,500</td><td>No: nothing due unless you own more</td><td>No (below Rs 5,03,529)</td></tr>
<tr><td>Rs 2,00,000</td><td>Rs 5,000</td><td>No at October 2026 prices: nothing due unless you own more</td><td>No</td></tr>
<tr><td>Rs 5,00,000</td><td>Rs 12,500</td><td>Yes: Rs 12,500 is due</td><td>No (just below Rs 5,03,529), so you pay it yourself</td></tr>
<tr><td>Rs 10,00,000</td><td>Rs 25,000</td><td>Yes: Rs 25,000 is due</td><td>Yes, about Rs 25,000 cut on 1 Ramadan</td></tr>
</tbody></table></figure>
<p>The nisab column uses the silver price in October 2026; check the live figure on <a href="/nisab/">nisab today</a>. If you own gold, other accounts or business stock as well, add them all together: then even Rs 1 lakh is part of a total that may be above the nisab.</p>
<h2>What about the bank's deduction?</h2>
<p>Banks in Pakistan deduct 2.5% on 1 Ramadan only from savings and profit-bearing accounts whose balance is at or above the government's deduction nisab. For Ramadan 1447 (2026) that was <strong>Rs 5,03,529</strong>, notified on 16 February 2026; the 1448 figure is announced a few days before Ramadan 2027 and posted on <a href="/zakat-2027-pakistan/">zakat 2027 Pakistan</a>. Current accounts are not deducted. The bank's cut is not always your full zakat, and it can be more than you owe if your debts are large, so work out your own total and subtract whatever the bank already took. See <a href="/bank-zakat-deduction-pakistan/">bank zakat deduction in Pakistan</a> for the CZ-50 form.</p>
<p>Check your full amount in rupees and tola, with the bank deduction entered under <em>Already paid</em>, in the <a href="/zakat-calculator-pakistan/">Pakistan zakat calculator</a>.</p>
[myzt_faq]
HTML
			. $author . '[myzt_related slugs="zakat-calculator-pakistan,nisab,zakat-on-1-tola-gold,home"]',
			'faq'     => array(
				array( 'q' => 'Is zakat due on 1 lakh rupees?', 'a' => 'Only if your total zakatable wealth, including gold and savings, is at or above the nisab for a lunar year. Then it is Rs 2,500.' ),
				array( 'q' => '1 lakh par kitni zakat hai?', 'a' => 'Rs 2,500, agar aapka kul maal nisab se zyada ho aur saal guzar gaya ho.' ),
				array( 'q' => 'How much zakat on 10 lakh rupees?', 'a' => 'Rs 25,000 (2.5%), if the conditions are met.' ),
			),
		),

		'bank-zakat-deduction-pakistan' => array(
			'title'   => 'Bank Zakat Deduction in Pakistan on 1 Ramadan',
			'seo'     => 'Bank Zakat Deduction {year} Pakistan: 1 Ramadan, CZ-50',
			'desc'    => 'How banks deduct zakat on 1 Ramadan in Pakistan, which accounts are affected, the government nisab, the CZ-50 exemption declaration, and whether to pay again.',
			'nav'     => 'Bank zakat deduction',
			'blurb'   => '1 Ramadan, CZ-50',
			'content' => <<<'HTML'
[myzt_answer q="Do banks deduct zakat in Pakistan?"]Yes. Under Pakistan's Zakat and Ushr Ordinance 1980, banks deduct 2.5% on 1 Ramadan from savings and similar accounts whose balance is at or above the nisab announced by the government for that year. Current accounts are not deducted.[/myzt_answer]
<p>Every year, the first day of Ramadan brings the same question in family WhatsApp groups: the bank cut money from my account, is my zakat paid? The short answer is that the deduction counts towards your zakat, but it rarely covers all of it.</p>
<h2>Which bank accounts are deducted?</h2>
<ul>
<li>Savings and profit-and-loss sharing accounts, term deposits and some government savings certificates held by Muslim citizens.</li>
<li>Only if the balance on 1 Ramadan is at or above the deduction nisab the government notifies shortly before Ramadan.</li>
<li>Current accounts, and accounts of non-Muslims, are not deducted.</li>
</ul>
[myzt_official type="bank-nisab"]
<h2>Exemption: the CZ-50 declaration</h2>
<p>A Muslim who is exempt on grounds of their fiqh, most commonly followers of Fiqh-e-Jafaria, can submit a CZ-50 declaration to the bank. It is an affidavit on stamp paper, attested as the bank requires, and it must reach the bank before Ramadan; banks usually ask for it a few weeks early. Ask your branch for its current form and deadline. Our PDF report is a personal estimate and cannot be used for this or any other official purpose.</p>
<h3>How to file the CZ-50 form, step by step</h3>
<ol>
<li><strong>Get the format</strong> from your bank's branch or website. Banks, the National Savings Centres, mutual funds and insurers each publish the same CZ-50 text under the Zakat and Ushr Ordinance 1980.</li>
<li><strong>Print it on stamp paper.</strong> Most banks ask for Rs 50 stamp paper; check what your bank accepts.</li>
<li><strong>Fill it in:</strong> your name, father's or husband's name, CNIC number, address, the account or certificate numbers, and the fiqh you follow.</li>
<li><strong>Sign it before an oath commissioner or notary,</strong> with two witnesses if the format asks for them.</li>
<li><strong>Submit the original to each institution</strong> that holds your money: one for each bank, and separate ones for savings certificates, funds and insurance. Some banks also accept it through their app or online banking.</li>
<li><strong>Keep the acknowledgement.</strong> The State Bank tells banks to stamp, date and sign a photocopy for you; it is your proof if zakat is deducted by mistake.</li>
</ol>
<h3>CZ-50 deadline for Ramadan 2027</h3>
<p>The deduction is made on the balance of 1 Ramadan 1448, expected around 8 February 2027. The declaration has to be on the bank's record before that day, and banks need time to mark the account, so file it in December or early January rather than in the last week. Your branch can tell you its own cut-off date. If zakat was deducted although you had filed in time, ask the bank for a refund with your acknowledged copy.</p>
<p>Not eligible for CZ-50 but want to pay zakat yourself? Keeping savings in a current account avoids the automatic deduction; then pay your full zakat on your own date.</p>
<h2>Bank nisab in past years</h2>
[myzt_history type="bank-nisab"]
<p>This figure only decides whether an account is deducted. Your own zakat uses the shar'i nisab on your zakat date; see <a href="/nisab/">nisab today</a> for the difference, and <a href="/zakat-2027-pakistan/">zakat 2027 Pakistan</a> for this season's dates.</p>
<h2>Do I have to pay zakat again?</h2>
<p>You pay the difference. Calculate your full zakat on all your wealth, then subtract what the bank already deducted. In our calculator, tap <strong>Already paid</strong> and enter the bank's deduction: it shows what is still left to pay. The bank looks at one account, on one fixed date, with the government's nisab. Your own zakat covers gold, cash at home, other accounts and business assets, on your own zakat date.</p>
<h2>Example</h2>
<p>Sana had Rs 8,00,000 in a savings account on 1 Ramadan, so the bank deducted Rs 20,000. She also owns 4 tola of 24K gold and keeps Rs 1,50,000 at home. At an example rate of Rs 4,30,000 a tola her gold is worth Rs 17,20,000, so her total is Rs 26,70,000. Her full zakat in the Hanafi madhab is 2.5% of that, Rs 66,750, and she still owes Rs 46,750 after the bank's Rs 20,000. Gold prices change, so the calculator uses today's rate.</p>
<h2>How to avoid paying twice</h2>
<ul>
<li>Keep the bank's zakat deduction certificate (shown on your statement) and subtract it from your total.</li>
<li>If you prefer to pay all your zakat yourself, keep long-term savings in a current account so the bank does not deduct, and pay in full on your own date.</li>
<li>Submit CZ-50 only if you are genuinely eligible under your fiqh.</li>
</ul>
<p>Hold National Savings certificates? Some schemes are deducted at source and some are exempt: see <a href="/zakat-on-savings-certificates/">zakat on savings certificates</a>.</p>
<p>Please ask your scholar about your own situation. Calculate the full amount with the <a href="/zakat-calculator-pakistan/">Pakistan zakat calculator</a>; if you follow Fiqh-e-Jafaria, see the <a href="/shia-zakat-calculator/">Shia zakat calculator</a> and <a href="/khums-calculator/">khums calculator</a>.</p>
[myzt_faq]
HTML
			. $author . '[myzt_related slugs="zakat-calculator-pakistan,hanafi-zakat-calculator,shia-zakat-calculator,zakat-on-1-lakh-rupees"]',
			'faq'     => array(
				array( 'q' => 'Is the bank deduction my full zakat?', 'a' => 'Usually not. It covers only that account. Calculate your total zakat and subtract the bank deduction.' ),
				array( 'q' => 'Kya current account se zakat katti hai?', 'a' => 'Nahi. Bank sirf savings aur munafa wale accounts se 1 Ramazan ko zakat kaat-te hain.' ),
				array( 'q' => 'Can I use the PDF from this site for CZ-50?', 'a' => 'No. It is a personal estimate, not an official or legal document.' ),
				array( 'q' => 'What is the CZ-50 form?', 'a' => 'A sworn declaration under the Zakat and Ushr Ordinance 1980, on stamp paper, by which a Muslim exempt on grounds of fiqh asks the bank not to deduct zakat. It must reach each bank before 1 Ramadan.' ),
				array( 'q' => 'CZ-50 form kab tak jama karana hai?', 'a' => '1 Ramazan se pehle, jab bank account ka balance dekhta hai. Ramazan 2027 ke liye December ya January ke shuru mein jama kara dein aur apni branch se un ki aakhri tareekh pooch lein.' ),
			),
		),
	);
}
