<?php
/**
 * Guide posts that support the haq mehr, iddat and fitrana calculators, Roman Urdu zakat and iddat guides,
 * and guides for Muslims abroad: pensions, ISAs and mortgages (SUG-08), giving zakat abroad and through charities (SUG-10).
 * Loaded by content-posts.php.
 *
 * @package MyZakatTool
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function myzt_content_posts_guides() {
	$author = '[myzt_author]';
	return array(
		'haq-mehr-guide'      => array(
			'title'   => 'Haq Mehr in Islam: Amount, Types and Rules',
			'seo'     => 'Haq Mehr in Islam: Amount, Types and Rules ({cyear})',
			'desc'    => 'What haq mehr is, prompt and deferred mehr, Mehr-e-Fatimi and the minimum mehr in rupees today, the nikah nama, MFLO section 10, divorce, death and zakat.',
			'nav'     => 'Haq mehr guide',
			'blurb'   => 'mehr ke masail',
			'content' => <<<'HTML'
[myzt_answer q="How much is haq mehr in Islam?"]Haq mehr is whatever amount the husband and wife agree on at the nikah, as long as it is not below the minimum of their madhab. In the Hanafi madhab the minimum is 10 dirham of silver (about 30.62 g), worth about [myzt_mehr type="minimum" currency="PKR"] today. Mehr-e-Fatimi, 500 dirham or about 1,530.9 g of silver, is worth about [myzt_mehr type="fatimi" currency="PKR"] today; it is a recommended choice, not an obligation.[/myzt_answer]
<p>Mehr is one of the few things in a nikah that is the wife's right by name, yet it is often treated as a formality: a number written on the nikah nama that nobody reads again. This guide explains what mehr is, the two kinds written in the nikah nama, how Mehr-e-Fatimi and the minimum mehr are worked out, what Pakistani law says, what happens to mehr at divorce, khula and death, and how it affects zakat. To turn any of these amounts into today's money, use the <a href="/haq-mehr-calculator/">haq mehr calculator</a>, which works from the live silver rate.</p>
<h2>What is haq mehr?</h2>
<p>Mehr (mahr, also called sadaq) is the money or property a husband gives his wife because of the nikah. The Quran calls it her right and a gift: "And give the women their mahr as a free gift" (Surah an-Nisa 4:4). Three points follow from this verse and are agreed on by all the schools:</p>
<ul>
<li><strong>It belongs to the wife alone.</strong> It is not paid to her father, brother or family, and nobody may take it from her without her free consent. She may spend, save, invest or give it away as she likes.</li>
<li><strong>It is a duty on the husband,</strong> not a price for the bride and not a favour. Until it is paid, it is a debt he owes her.</li>
<li><strong>It is different from dowry (jahez).</strong> Jahez is what the bride's family gives at the wedding. It is not mehr, it does not reduce the mehr, and the Quran does not require it.</li>
</ul>
<p>Mehr can be cash, gold, silver, land, a house or anything else of value. In Pakistan it is most often fixed in rupees or in tola of gold, and some families fix it as Mehr-e-Fatimi in silver.</p>
<h2>What are mu'ajjal and muwajjal mehr?</h2>
<p>The nikah nama lets the couple split the mehr into two parts:</p>
<ul>
<li><strong>Mu'ajjal (prompt) mehr</strong> is due as soon as the nikah takes place. The wife may ask for it at any time, and it is best paid at the nikah or the rukhsati.</li>
<li><strong>Muwajjal (deferred) mehr</strong> is due at the time agreed in the nikah nama, or, if no time is given, at divorce or at the death of either spouse.</li>
</ul>
<p>A couple may make all of the mehr prompt, all of it deferred, or split it. Deferring the mehr is allowed, but the deferred part is still a real debt. It is not cancelled by the passing of years, and it does not lose its value if it was fixed in gold or silver.</p>
<h2>What does the nikah nama say about mehr?</h2>
<p>The standard Pakistani nikah nama has separate columns for the mehr: the amount of the mehr, how much of it is prompt and how much deferred, whether any part was paid at the time of the nikah, and whether any property was given in place of all or part of it. These are columns 13 to 16 on the usual form. Read them before you sign, and make sure the figures in words and in numbers match. If the mehr is in gold, write the weight and the karat, for example "5 tola 24K gold", not only a rupee figure, so that its value is clear years later.</p>
<h2>What does Pakistani law say? MFLO 1961, section 10</h2>
<p>Section 10 of the Muslim Family Laws Ordinance 1961 says that if the nikah nama, or the marriage contract, does not say how the mehr is to be paid, the whole of it is payable on demand. In practice this means a nikah nama with the mode of payment left blank makes the entire mehr prompt. A wife whose mehr is not paid can claim it before the Family Court.</p>
<h2>How much is Mehr-e-Fatimi today?</h2>
<p>Mehr-e-Fatimi is the mehr the Prophet ﷺ gave for his daughter Fatimah (may Allah be pleased with her). Sayyidah Aisha said the mehr he gave his wives was twelve and a half uqiyah, which is 500 dirham (Muslim 1426). Sayyiduna Umar said it was not more than twelve uqiyah, or 480 dirham (Abu Dawud 2106; Tirmidhi 1114). Because of these reports, scholars give more than one figure:</p>
<figure class="wp-block-table"><table><thead><tr><th>View</th><th>Silver</th><th>Value today</th></tr></thead><tbody>
<tr><td>500 dirham (Mufti Muhammad Shafi; preferred in many Pakistani fatwas)</td><td>131.25 tola, about 1,530.9 g</td><td>[myzt_mehr type="fatimi" currency="PKR"]</td></tr>
<tr><td>480 dirham (narration of Sayyiduna Umar)</td><td>about 1,469.7 g</td><td>see the <a href="/haq-mehr-calculator/">calculator</a></td></tr>
<tr><td>400 dirham (view reported from Ibn al-Humam)</td><td>about 1,224.7 g</td><td>see the <a href="/haq-mehr-calculator/">calculator</a></td></tr>
</tbody></table></figure>
<p>Paying Mehr-e-Fatimi is not obligatory. Many families choose it for its blessing, but any amount both sides agree on is valid, as long as it is not below the minimum of their madhab.</p>
<h2>What is the minimum mehr?</h2>
<ul>
<li><strong>Hanafi:</strong> 10 dirham, about 30.62 g of silver (2 tola 7.5 masha), worth about [myzt_mehr type="minimum" currency="PKR"] today. If a smaller amount is fixed, the mehr becomes 10 dirham. Maulana Ashraf Ali Thanwi and Mufti Rasheed Ahmad Ludhianvi gave about 34 g.</li>
<li><strong>Maliki:</strong> a quarter dinar of gold or 3 dirham of silver.</li>
<li><strong>Shafi'i and Hanbali:</strong> no fixed minimum; anything that has value may be mehr.</li>
<li><strong>Shia (Ayatollah Sistani):</strong> no fixed minimum; the mehr of the Sunnah is 500 dirham.</li>
</ul>
<p>There is no maximum in any school. Scholars do, however, warn against fixing a mehr so high that the husband has no real intention or means of paying it, because an unpaid mehr stays a debt on him in this world and the next.</p>
<h2>Why is mehr measured in silver?</h2>
<p>The amounts in the hadith and the books of fiqh are in dirhams, the silver coins of the time. A dirham is a fixed weight of silver, so a mehr measured in silver keeps its value while the rupee loses value. That is why muftis tell people to work out Mehr-e-Fatimi and the minimum mehr from the silver price on the day of the nikah, not from an old rupee figure someone remembers. Local sarafa prices are usually a little higher than the international rate our calculator uses; either is acceptable if used honestly.</p>
<h2>Worked example: a mehr fixed in rupees and gold</h2>
<p>Sara's nikah nama says: mehr Rs 3,00,000 and 3 tola of 22K gold. Rs 1,00,000 is mu'ajjal and was paid at the nikah; the rest, Rs 2,00,000 and the gold, is muwajjal with no date given.</p>
<ul>
<li><strong>Is it above the Hanafi minimum?</strong> Yes, by far. The minimum is about [myzt_mehr type="minimum" currency="PKR"].</li>
<li><strong>What is still owed?</strong> Rs 2,00,000 and 3 tola of 22K gold. The gold is owed as gold, so its value follows the gold rate on the day it is paid, not the day of the nikah.</li>
<li><strong>When is it due?</strong> At the time the couple agree, or at divorce or death, since no date is written. Sara may also ask for it earlier if her husband agrees to pay; many husbands pay deferred mehr during the marriage, which clears the debt.</li>
</ul>
<h2>What happens to mehr at divorce or khula?</h2>
<ul>
<li><strong>Talaq after the marriage was consummated:</strong> the whole mehr is due, prompt and deferred, and any unpaid part must be paid.</li>
<li><strong>Talaq before consummation:</strong> if a mehr was fixed, half of it is due (Surah al-Baqarah 2:237). In the Hanafi school a valid private meeting of the couple (khalwat-e-sahihah) is treated like consummation for the mehr, so the full mehr is then due.</li>
<li><strong>Khula:</strong> in khula the wife asks for the marriage to end, and she usually gives back the mehr she received, or gives up the unpaid part, as the price of the separation (Surah al-Baqarah 2:229). The basis is the wife of Thabit ibn Qays, whom the Prophet ﷺ asked whether she would return the garden her husband had given her (Bukhari 5273). What exactly is returned is agreed between the couple or decided by the Family Court in a court khula; ask a lawyer and a mufti about your own case.</li>
</ul>
<h2>What happens to mehr when the husband or wife dies?</h2>
<p>Unpaid mehr is a debt on the husband. If he dies before paying it, it is paid in full from his estate before the inheritance is divided, just like a bank loan. Only then does the widow take her inheritance share of what remains: 1/8 if he left children, 1/4 if he did not. See <a href="/wife-husband-share-in-inheritance/">the wife's and husband's share</a>, and enter the mehr as a debt in the <a href="/wirasat-calculator/">wirasat calculator</a>. A mehr fixed in silver or gold is paid at its value on the day it is paid; the <a href="/haq-mehr-calculator/">haq mehr calculator</a> converts it at the live rate. The <a href="/iddat-calculator/">iddat calculator</a> gives the date the iddat after a divorce or khula ends.</p>
<p>When the wife dies, the mehr her husband still owed her becomes part of her own estate. He pays it into her estate, and it is then divided among all her heirs, including him.</p>
<h2>Is zakat due on mehr?</h2>
<ul>
<li><strong>Mehr the wife has received</strong> is her own wealth, whether cash or gold. It is counted towards her zakat like any other savings or jewellery, on her own zakat date. See <a href="/zakat-on-jewellery/">zakat on jewellery</a> for how each madhab treats gold she wears.</li>
<li><strong>Unpaid mehr:</strong> many Hanafi muftis say zakat is not due on it until she receives it.</li>
<li><strong>Fiqh-e-Jafaria:</strong> according to Ayatollah Sistani, the mahr a wife receives is not subject to khums (see <a href="/khums-who-must-pay/">who must pay khums</a>).</li>
</ul>
<p>Use the <a href="/">zakat calculator</a> for her total, and check today's <a href="/nisab/">nisab</a>.</p>
<h2>Common mistakes</h2>
<ul>
<li><strong>Treating mehr as a formality.</strong> It is a debt that must be paid, either at the nikah or later.</li>
<li><strong>Giving mehr to the bride's father.</strong> It belongs to the bride.</li>
<li><strong>Using an old rupee figure for Mehr-e-Fatimi.</strong> It is a weight of silver; work it out from the rate on the day.</li>
<li><strong>Leaving the nikah nama columns blank.</strong> Under section 10 the whole mehr then becomes payable on demand, which may not be what either family meant.</li>
<li><strong>Forgetting unpaid mehr when dividing an estate.</strong> It comes before the shares of the heirs.</li>
</ul>
<p>In Urdu, read <a href="/haq-mehr-calculator-urdu/">حق مہر کیلکولیٹر</a>. This guide gives figures from published fatwas and the live silver rate. It is not a fatwa; for a particular nikah, divorce or khula, ask a qualified scholar.</p>
[myzt_faq]
HTML
			. $author . '[myzt_related slugs="haq-mehr-calculator,haq-mehr-calculator-urdu,wife-husband-share-in-inheritance,wirasat-calculator"]',
			'faq'     => array(
				array( 'q' => 'What is the difference between mu\'ajjal and muwajjal mehr?', 'a' => 'Mu\'ajjal (prompt) mehr is due as soon as the nikah takes place and the wife may ask for it at any time. Muwajjal (deferred) mehr is due at the time agreed, or at divorce or death.' ),
				array( 'q' => 'Haq mehr kitna hona chahiye?', 'a' => 'Jo raqam dono taraf ki razamandi se tay ho, bas apne maslak ki kam se kam miqdar se kam na ho. Hanafi fiqh mein kam se kam 10 dirham (taqreeban 30.62 gram chandi) hai. Mehr-e-Fatimi barkat ke liye pasandeeda hai, wajib nahi.' ),
				array( 'q' => 'Mehr-e-Fatimi kitna hai?', 'a' => '500 dirham chandi, yani 131.25 tola (taqreeban 1,530.9 gram). Rupees mein is ki qeemat aaj ke chandi ke rate se nikalti hai; haq mehr calculator mein dekhein.' ),
				array( 'q' => 'What if the nikah nama does not say how the mehr is paid?', 'a' => 'In Pakistan, section 10 of the Muslim Family Laws Ordinance 1961 makes the whole mehr payable on demand.' ),
				array( 'q' => 'Kya talaq ke baad mehr dena parta hai?', 'a' => 'Ji haan. Rukhsati aur milap ke baad talaq ho to poora mehr wajib hai. Milap se pehle talaq ho aur mehr tay tha to aadha mehr wajib hai (Surah al-Baqarah 2:237); Hanafi fiqh mein sahih khalwat bhi milap ke hukm mein hai.' ),
				array( 'q' => 'Is zakat due on unpaid mehr?', 'a' => 'Many Hanafi muftis say zakat is not due on mehr until the wife receives it. Once received, it is counted with her other wealth.' ),
			),
		),

		'fitrana-guide'       => array(
			'title'   => 'Fitrana (Sadaqat al-Fitr): Who Pays, How Much, When',
			'seo'     => 'Fitrana (Sadaqat al-Fitr) {fyear}: Who Pays, How Much, When',
			'desc'    => 'Sadqa fitr explained: who must pay in each madhab, for whom, the amount by wheat, barley, dates or raisins, paying in money, the deadline and who receives it.',
			'nav'     => 'Fitrana guide',
			'blurb'   => 'sadqa-e-fitr',
			'content' => <<<'HTML'
[myzt_answer q="How much is fitrana per person?"]Fitrana is paid for each member of the family before the Eid prayer. In Hanafi fiqh it is half a sa' of wheat (about 1.75 to 2 kg) or one sa' of barley, dates or raisins (about 4 kg), or their value. For Ramadan 1447 (2026) the Council of Islamic Ideology, Pakistan, gave minimum amounts per person of Rs 300 by wheat, Rs 1,100 by barley, Rs 1,600 by dates and Rs 3,800 by raisins.[/myzt_answer]
<p>Fitrana, also called sadaqat al-fitr, zakat al-fitr, sadqa fitr or simply fitra, is the small charity every Muslim household gives at the end of Ramadan. It is simple to pay, but families often have the same questions every year: who has to pay it, for whom, how much in rupees, whether money is acceptable, and the last time it can be given. This guide answers each one, with the differences between the madhabs. To work out the total for your house, use our <a href="/fitrana-calculator/">fitrana calculator</a>, which also works as a zakat al fitr calculator or fitr calculator: enter the number of people and choose the item.</p>
<h2>What is sadaqat al-fitr?</h2>
<p>Ibn Umar reported that the Messenger of Allah ﷺ made zakat al-fitr obligatory, a sa' of dates or a sa' of barley, on every Muslim, slave and free, male and female, young and old, and ordered that it be given before people go out to the Eid prayer (Bukhari 1503). Ibn Abbas reported that he called it a purification for the fasting person from idle talk and obscenity, and food for the poor (Abu Dawud 1609).</p>
<p>So fitrana has two purposes: it makes up for the small faults in our fasting, and it makes sure that the poor have something on the day of Eid. It is linked to the person, not to wealth held for a year, which is what makes it different from zakat.</p>
<h2>Who must pay fitrana?</h2>
<ul>
<li><strong>Hanafi:</strong> fitrana is wajib on every Muslim who, at dawn on Eid day, owns wealth equal to the nisab over and above basic needs and debts. This wealth does not need to have been held for a year, and it does not need to be zakatable wealth (<em>al-Hidayah</em>, Sadaqat al-Fitr). So a person who owes no zakat, because their savings have not completed a year, may still owe fitrana if they own the nisab on Eid morning in household goods beyond their needs.</li>
<li><strong>Shafi'i, Maliki and Hanbali:</strong> the bar is lower. Anyone who has more than the food the family needs for the day and night of Eid pays it.</li>
<li><strong>Shia (Ja'fari):</strong> fitra is obligatory too, on an adult who is not poor at the time of sunset on the night of Eid; follow the amount your marja's office announces.</li>
</ul>
<p>The nisab used in the Hanafi rule is today's silver nisab, about [myzt_rate type="nisab-silver" currency="PKR"]. See <a href="/nisab/">nisab today</a>.</p>
<h2>For whom do you pay?</h2>
<ul>
<li><strong>Yourself and your young children:</strong> the head of the house pays for them. If a child has wealth of their own, it can be paid from that.</li>
<li><strong>Wife:</strong> in the Hanafi view a wife who owns the nisab pays her own fitrana, but it is valid and common for the husband to pay for her with her permission. The Shafi'i, Maliki and Hanbali schools make the husband responsible for his wife's fitrana, as part of his duty to support her.</li>
<li><strong>Adult children:</strong> in the Hanafi view they pay for themselves if they own the nisab; the father may pay for them with their permission.</li>
<li><strong>Others:</strong> you may pay for anyone else, such as a parent or a household worker, with their permission.</li>
<li><strong>A baby born on Eid:</strong> a baby born before dawn on Eid day is counted; a baby born after dawn is not. A person who dies before dawn on Eid is not counted.</li>
</ul>
<p>Hanbali scholars also consider it recommended to pay for a baby still in the womb, following a practice reported from Uthman; it is not obligatory.</p>
<h2>How much is fitrana?</h2>
<p>The amount is measured in food. The sa' is a measure of volume, so its weight depends on the food, which is why scholars give approximate kilograms.</p>
<figure class="wp-block-table"><table><thead><tr><th>Item</th><th>Hanafi amount per person</th><th>CII minimum, Ramadan 1447 (2026)</th></tr></thead><tbody>
<tr><td>Wheat or flour</td><td>Half a sa', about 1.75 to 2 kg</td><td>Rs 300</td></tr>
<tr><td>Barley</td><td>One sa', about 4 kg</td><td>Rs 1,100</td></tr>
<tr><td>Dates</td><td>One sa', about 4 kg</td><td>Rs 1,600</td></tr>
<tr><td>Raisins</td><td>One sa', about 4 kg</td><td>Rs 3,800</td></tr>
</tbody></table></figure>
<p>The Council of Islamic Ideology announced the 2026 amounts on 9 February 2026, with Rs 200 for those using subsidised flour. For 2025 the amounts were Rs 220 by wheat, Rs 450 by barley, Rs 1,650 by dates and Rs 2,500 by raisins. The figures for Ramadan 2027 will be added to the <a href="/fitrana-calculator/">fitrana calculator</a> on the day they are announced; until then, use the price of the item where you live. Past years and their sources are on the calculator page.</p>
<p>In the Shafi'i, Maliki and Hanbali schools, and in the view of many Ahl-e-Hadith scholars, the amount is one full sa' of the local staple food for every item, wheat included, following Abu Sa'id al-Khudri, who said he would keep giving a full sa' (Muslim 985). This is usually given as about 2 to 3 kg depending on the food. In Pakistan that means a fuller measure of wheat or rice than the Hanafi half sa'.</p>
<h2>Which item should you choose?</h2>
<p>You may pay by any of the four items. Those who can afford it are encouraged to pay by the more expensive items, dates or raisins, because this gives more to the poor. A family that pays by wheat because money is tight has still paid its fitrana in full.</p>
<h2>Can fitrana be paid in money?</h2>
<ul>
<li><strong>Hanafi:</strong> yes. Paying the value in money is allowed, and it is what most people in Pakistan and India do, because the poor can spend it on what they actually need for Eid.</li>
<li><strong>Shafi'i, Maliki and Hanbali:</strong> the relied-upon view in each school is that fitrana is given as food, as in the hadith. Some contemporary scholars and official bodies in these regions accept money where giving food is impractical or less useful to the poor, often by following the Hanafi view on this point; ask your own scholar which practice to follow.</li>
<li><strong>Shia (Sistani):</strong> the value of the food may be given in money; follow your marja's amount.</li>
</ul>
<h2>Worked example: a family of six</h2>
<p>Imran and his wife live in Multan with three children and Imran's mother, who has no savings of her own. Imran owns more than the nisab and offers to pay for everyone. At the 2026 amounts:</p>
<ul>
<li><strong>By wheat:</strong> 6 × Rs 300 = Rs 1,800.</li>
<li><strong>By dates:</strong> 6 × Rs 1,600 = Rs 9,600.</li>
<li><strong>By raisins:</strong> 6 × Rs 3,800 = Rs 22,800.</li>
</ul>
<p>His wife and mother should know he is paying for them, since in the Hanafi view each adult's fitrana is their own duty. A sadqa fitr calculator like ours does this multiplication for you; use this year's amount when it is announced.</p>
<h2>When must fitrana be paid?</h2>
<ul>
<li><strong>The best time</strong> is on Eid morning before the Eid prayer, as the hadith commands.</li>
<li><strong>Early payment:</strong> the Hanafi school allows paying it before Eid, and in practice during Ramadan, so that it reaches the poor in time. The Shafi'i school allows it from the start of Ramadan. The Maliki and Hanbali schools allow it a day or two before Eid, as Ibn Umar used to do (Bukhari 1511).</li>
<li><strong>After the Eid prayer:</strong> it should not be delayed past the prayer. Abu Dawud 1609 says that given after the prayer it counts as ordinary sadaqah. If it was missed, it is still owed and should be paid as soon as possible.</li>
</ul>
<p>In Pakistan many mosques and charities collect fitrana from the middle of Ramadan so that it can be distributed before Eid. Giving it through them is fine, as long as they hand it over in time.</p>
<h2>Who receives fitrana?</h2>
<p>Fitrana goes to the same people as zakat, mainly the poor and the needy (Surah at-Tawbah 9:60). It cannot be given to your own parents, grandparents, children or grandchildren, and a husband and wife cannot give it to each other. Sayyids cannot receive it in the four Sunni schools. Giving it to poor relatives such as brothers, sisters, uncles and aunts is allowed and carries a double reward. Several people's fitrana may go to one family, and one person's fitrana may be split. Read <a href="/who-can-receive-zakat/">who can receive zakat</a> for the full list.</p>
<h2>Fitrana, zakat and fidya are different</h2>
<ul>
<li><strong>Fitrana:</strong> a fixed amount per person, once a year at Eid, on wealth that does not need a year to pass.</li>
<li><strong>Zakat:</strong> 2.5% of your zakatable wealth, due on your own zakat date. Use the <a href="/">zakat calculator</a>.</li>
<li><strong>Fidya:</strong> paid for each fast a person can never make up; in the Hanafi madhab one fidya equals one fitrana. Use the <a href="/fidya-kaffara-calculator/">fidya and kaffara calculator</a> and read <a href="/roza-fidya/">roza fidya</a>.</li>
</ul>
<p>Paying one does not replace the others. In Urdu, use the <a href="/fitrana-calculator-urdu/">فطرانہ کیلکولیٹر</a>. This guide is not a fatwa; if your situation is unusual, ask a qualified scholar.</p>
[myzt_faq]
HTML
			. $author . '[myzt_related slugs="fitrana-calculator,fitrana-calculator-urdu,who-can-receive-zakat,roza-fidya"]',
			'faq'     => array(
				array( 'q' => 'Fitrana kitna hai 2026 mein?', 'a' => 'Islami Nazriati Council ne Ramazan 1447 (2026) ke liye fi kas kam az kam Rs 300 gandum, Rs 1,100 jau, Rs 1,600 khajoor aur Rs 3,800 kishmish ke hisaab se bataya. Ramazan 2027 ki raqam elaan hone par calculator mein shamil ki jayegi.' ),
				array( 'q' => 'Sadqa fitr kis par wajib hai?', 'a' => 'Hanafi fiqh mein har us Muslim par jo Eid ki subah bunyadi zarooraton aur qarz ke ilawa nisab ke barabar maal ka malik ho; is par saal guzarna zaroori nahi. Shafi\'i, Maliki aur Hanbali maslak mein jis ke paas Eid ke din aur raat ke khane se zyada ho, us par wajib hai.' ),
				array( 'q' => 'Can zakat al-fitr be paid in money?', 'a' => 'Yes in the Hanafi madhab. In the Shafi\'i, Maliki and Hanbali schools the relied-upon view is to give food, though some contemporary scholars and official bodies accept money. Ayatollah Sistani allows the value in money.' ),
				array( 'q' => 'Kya biwi ka fitrana shohar par wajib hai?', 'a' => 'Hanafi fiqh mein biwi agar nisab ki malik ho to apna fitrana khud ada kare, lekin shohar us ki ijazat se ada kar de to durust hai. Shafi\'i, Maliki aur Hanbali maslak mein biwi ka fitrana shohar ke zimme hai.' ),
				array( 'q' => 'What is the last time to pay fitrana?', 'a' => 'Before the Eid prayer. Given after the prayer it counts as ordinary charity; if it was missed it is still owed and should be paid as soon as possible.' ),
				array( 'q' => 'Is a newborn baby included in fitrana?', 'a' => 'Yes, if born before dawn on Eid day. A baby born after dawn is not counted.' ),
			),
		),

		'haq-mehr-in-rupees'  => array(
			'title'   => 'Haq Mehr in Rupees Today: Mehr-e-Fatimi and Shari Mehr',
			'seo'     => 'Haq Mehr in Rupees {cyear}: Mehr-e-Fatimi, Shari Mehr',
			'desc'    => "Haq mehr in rupees today: Mehr-e-Fatimi, the minimum (shari) mehr and a mehr in tola of gold, worked out from the live silver and gold rate, with a calculator.",
			'nav'     => 'Haq mehr in rupees',
			'blurb'   => 'mehr ki raqam aaj',
			'content' => <<<'HTML'
[myzt_answer q="How much is haq mehr in rupees today?"]At today's international silver rate, Mehr-e-Fatimi (500 dirham, about 1,530.9 g or 131.25 tola of silver) is about [myzt_mehr type="fatimi" currency="PKR"], and the minimum mehr of the Hanafi madhab (10 dirham, about 30.62 g of silver), often called the shari mehr, is about [myzt_mehr type="minimum" currency="PKR"]. A mehr fixed in gold is worth today's gold rate: 1 tola of 24K gold is about [myzt_rate type="gold-tola" currency="PKR"].[/myzt_answer]
[zakat_mehr currency="PKR"]
<p>Families ask this question in the week before a nikah: how much is Mehr-e-Fatimi in rupees, what is the shari (minimum) mehr, and what is a mehr of a few tola of gold worth? None of these has a fixed rupee figure. They are weights of silver or gold, so their value moves with the metal price and the rupee. The calculator above works them out from the live rate, refreshed every hour, and the sections below explain each figure, show the same amounts in Indian rupees, and answer the questions people ask about old rupee figures and deferred mehr. For the rules of mehr itself (prompt and deferred mehr, the nikah nama, divorce and khula) read <a href="/haq-mehr-guide/">haq mehr in Islam: amount, types and rules</a>.</p>
<h2>Mehr-e-Fatimi in rupees</h2>
<p>Mehr-e-Fatimi is the mehr the Prophet ﷺ gave for his daughter Fatimah (may Allah be pleased with her). The common figure in Pakistani and Indian fatwas is 500 dirham of silver, based on the report of Sayyidah Aisha that the mehr of the Prophet's wives was twelve and a half uqiyah (Muslim 1426). One dirham is 3.0618 g of silver, so:</p>
<ul>
<li><strong>500 dirham</strong> = about 1,530.9 g = 131.25 tola of silver, worth about <strong>[myzt_mehr type="fatimi" currency="PKR"]</strong> today.</li>
<li><strong>480 dirham</strong> (the narration of Sayyiduna Umar, Abu Dawud 2106) = about 1,469.7 g.</li>
<li><strong>400 dirham</strong> (a view reported from Ibn al-Humam) = about 1,224.7 g.</li>
</ul>
<p>Open "Other views held by scholars" in the calculator above to see the 480 and 400 dirham figures in today's rupees. Paying Mehr-e-Fatimi is a recommended choice for its blessing; it is not obligatory, and any amount both families agree on is valid if it is not below the minimum.</p>
<h2>Shari mehr (the minimum mehr) in rupees</h2>
<p>When people in Pakistan say "shari mehr" they usually mean the least mehr that is valid. The schools differ:</p>
<ul>
<li><strong>Hanafi:</strong> 10 dirham, about 30.62 g of silver (2 tola 7.5 masha), worth about <strong>[myzt_mehr type="minimum" currency="PKR"]</strong> today. If a smaller amount is written, the mehr becomes 10 dirham. Some Deobandi scholars, such as Maulana Ashraf Ali Thanwi, gave about 34 g; the calculator shows that figure too.</li>
<li><strong>Maliki:</strong> a quarter dinar of gold or 3 dirham of silver.</li>
<li><strong>Shafi'i, Hanbali and Ahl-e-Hadith scholars:</strong> no fixed minimum; anything of value can be mehr, following the hadith "look for something, even an iron ring" (Bukhari 5135).</li>
<li><strong>Shia (Ayatollah Sistani):</strong> no fixed minimum; the mehr of the Sunnah is 500 dirham.</li>
</ul>
<p>The minimum is a floor, not a recommendation. A mehr that is far too small for the family's means is allowed in fiqh but often unfair to the bride; a mehr far beyond the husband's means is also discouraged.</p>
<h2>A mehr fixed in tola of gold</h2>
<p>Many nikah namas in Pakistan say "5 tola gold" or "10 tola gold". That mehr is owed as gold, so its rupee value is today's gold rate times the weight:</p>
<figure class="wp-block-table"><table><thead><tr><th>Mehr</th><th>Value today (PKR)</th></tr></thead><tbody>
<tr><td>1 tola 24K gold</td><td>[myzt_rate type="gold-tola" currency="PKR"]</td></tr>
<tr><td>1 tola 22K gold</td><td>[myzt_rate type="gold22-tola" currency="PKR"]</td></tr>
<tr><td>1 tola silver</td><td>[myzt_rate type="silver-tola" currency="PKR"]</td></tr>
</tbody></table></figure>
<p>Multiply by the number of tola in your nikah nama, or type the weight in the second box of the calculator, which also handles 22K and grams. If the nikah nama gives a weight but no karat, ask the families what was meant at the time; writing "24K" or "22K" next to the weight avoids the question later. Local sarafa rates are usually a little above the international rate used here.</p>
<h2>Haq mehr in Indian rupees</h2>
<p>The same weights apply in India. At today's rate, Mehr-e-Fatimi is about <strong>[myzt_mehr type="fatimi" currency="INR"]</strong> and the Hanafi minimum mehr about <strong>[myzt_mehr type="minimum" currency="INR"]</strong>. Choose INR in the calculator to see the other views and to check your own figure. Indian Muslim personal law also treats mehr as the wife's right and a debt on the husband until paid.</p>
<h2>Why the rupee figure changes every year</h2>
<p>A figure such as "Mehr-e-Fatimi is Rs 3 lakh" was right only on the day someone worked it out. Silver has risen sharply against the rupee, so the same 131.25 tola is now worth several times what it was a decade ago. That is why muftis tell families to work out Mehr-e-Fatimi from the silver rate on the day of the nikah and to write the rupee amount and the weight together in the nikah nama, for example "Mehr-e-Fatimi, 131.25 tola silver, Rs ___ on the day of nikah". Saying which one is owed avoids a dispute later.</p>
<h2>Worked example</h2>
<p>Hina and Usman agree on Mehr-e-Fatimi, half paid at the nikah and half deferred. On the day of the nikah the calculator shows Mehr-e-Fatimi at about [myzt_mehr type="fatimi" currency="PKR"].</p>
<ul>
<li><strong>If the nikah nama says "Mehr-e-Fatimi, 131.25 tola silver":</strong> the deferred half is 65.625 tola of silver. When Usman pays it years later, he pays that weight of silver or its value on the day he pays.</li>
<li><strong>If it gives only a rupee amount:</strong> the deferred half is that rupee figure. Most muftis say the written rupee amount is what is owed; a husband who pays more to make up for inflation does a kindness, but it is not required.</li>
</ul>
<p>Either way, the deferred half is a debt. If Usman dies before paying it, it is paid from his estate before the inheritance is divided; the <a href="/wirasat-calculator/">wirasat calculator</a> lets you enter it as a debt, and <a href="/wife-husband-share-in-inheritance/">the wife's and husband's share</a> explains what the widow inherits on top of it.</p>
<h2>Mehr after talaq, khula or a death</h2>
<p>After a talaq that follows consummation the whole mehr is due; before consummation, half of a fixed mehr (Surah al-Baqarah 2:237). In khula the wife usually returns the mehr or gives up the unpaid part (Bukhari 5273). The rupee value of a mehr fixed in gold or silver is taken on the day it is paid. The woman's iddat follows in each case; see <a href="/iddat-kitne-din-ki-hoti-hai/">iddat kitne din ki hoti hai</a> for the days, or the <a href="/iddat-calculator/">iddat calculator</a> for the date it ends.</p>
<h2>Zakat on mehr</h2>
<p>Mehr the wife has received, in cash or gold, is her own wealth and is counted in her zakat on her own zakat date. Many Hanafi muftis say there is no zakat on unpaid mehr until she receives it. See <a href="/zakat-on-jewellery/">zakat on jewellery</a> for gold she wears, and work out her total with the <a href="/">zakat calculator</a>.</p>
<p>In Urdu: <a href="/haq-mehr-calculator-urdu/">حق مہر کیلکولیٹر</a>. The full calculator page is the <a href="/haq-mehr-calculator/">haq mehr calculator</a>. These figures come from published fatwas and the live international rate. This page is not a fatwa; for a particular nikah, ask the imam or mufti who performs it.</p>
[myzt_faq]
HTML
			. $author . '[myzt_related slugs="haq-mehr-calculator,haq-mehr-guide,haq-mehr-calculator-urdu,iddat-kitne-din-ki-hoti-hai"]',
			'faq'     => array(
				array( 'q' => 'Mehr-e-Fatimi kitne rupay ka hai?', 'a' => 'Mehr-e-Fatimi 500 dirham, yani 131.25 tola (taqreeban 1,530.9 gram) chandi hai. Is ki rupees mein qeemat har din chandi ke rate ke saath badalti hai; upar calculator aaj ki raqam dikhata hai.' ),
				array( 'q' => 'Shari haq mehr kitna hai?', 'a' => 'Hanafi fiqh mein kam se kam mehr 10 dirham, yani taqreeban 30.62 gram (2 tola 7.5 masha) chandi ki qeemat hai. Shafi\'i aur Hanbali fiqh mein koi muqarrar kam se kam miqdar nahi.' ),
				array( 'q' => 'What is 5 tola gold mehr in rupees?', 'a' => 'Five times today\'s rate for 1 tola of the karat written in the nikah nama. Type 5 tola in the gold box of the calculator above to see it in 24K or 22K.' ),
				array( 'q' => 'Is an old rupee figure for Mehr-e-Fatimi still valid?', 'a' => 'No. Mehr-e-Fatimi is a weight of silver, so it must be worked out from the silver rate on the day of the nikah.' ),
				array( 'q' => 'If the mehr was written in rupees years ago, how much is owed now?', 'a' => 'Most muftis say the rupee amount written in the nikah nama is owed. A mehr written as a weight of gold or silver is paid at its value on the day of payment.' ),
				array( 'q' => 'Which silver rate does this page use?', 'a' => 'The international spot rate, refreshed every hour. Sarafa rates in Pakistan are often a little higher.' ),
			),
		),

		'iddat-kitne-din-ki-hoti-hai' => array(
			'title'   => 'Iddat Kitne Din Ki Hoti Hai? Talaq, Khula aur Bewa Ki Iddat',
			'seo'     => 'Iddat Kitne Din Ki Hoti Hai? Talaq, Khula, Bewa Ki Iddat',
			'desc'    => 'Iddat kitne din ki hoti hai: bewa ki iddat 130 din, talaq ki 3 haiz, haiz na aaye to 90 din, hamla mein paidaish tak. Har maslak ka hukm aur tareekh calculator.',
			'nav'     => 'Iddat kitne din ki',
			'blurb'   => 'iddat ke din',
			'content' => <<<'HTML'
[myzt_answer q="Iddat kitne din ki hoti hai?"]Bewa ki iddat 4 Islami mahine aur 10 din hai, yani 130 din, agar shohar ki wafat Islami mahine ki pehli tareekh ko na hui ho. Talaq ya khula ki iddat 3 haiz (ya 3 tuhr) hai, jo aam tor par do se teen mahine banti hai. Jis aurat ko haiz na aata ho us ki iddat 3 mahine (90 din), aur hamla aurat ki iddat bachay ki paidaish tak hai. Rukhsati aur milap se pehle talaq ho to koi iddat nahi.[/myzt_answer]
[zakat_iddat]
<p>Iddat woh muddat hai jis mein talaq, khula ya shohar ki wafat ke baad aurat naya nikah nahi kar sakti. Ghar mein jab yeh waqt aata hai to sab se pehla sawal yehi hota hai: iddat kitne din ki hoti hai, aur kis din khatam ho gi? Upar calculator mein apna maslak, kya hua (wafat, talaq ya khula) aur tareekh daalen; woh Islami aur angrezi dono tareekhon mein iddat ka aakhri din bata deta hai. Neeche har soorat ke din, har maslak ka hukm, aur misaalen hain. Aap jo likhte hain woh kahin save ya send nahi hota.</p>
<h2>Iddat ke din: aik nazar mein</h2>
<figure class="wp-block-table"><table><thead><tr><th>Soorat</th><th>Iddat</th><th>Taqreeban din</th></tr></thead><tbody>
<tr><td>Shohar ki wafat (bewa)</td><td>4 Islami mahine 10 din</td><td>130 din</td></tr>
<tr><td>Talaq, haiz aata ho</td><td>3 haiz ya 3 tuhr (maslak ke mutabiq)</td><td>aam tor par 60 se 90 din</td></tr>
<tr><td>Talaq, haiz na aata ho</td><td>3 mahine</td><td>90 din</td></tr>
<tr><td>Hamla aurat (talaq ya wafat)</td><td>bachay ki paidaish tak</td><td>paidaish ka din</td></tr>
<tr><td>Khula</td><td>talaq jaisi; Ahl-e-Hadith ulama ke nazdeek 1 haiz</td><td>1 se 3 haiz</td></tr>
<tr><td>Milap se pehle talaq</td><td>koi iddat nahi</td><td>0</td></tr>
</tbody></table></figure>
<h2>Bewa ki iddat: 4 mahine 10 din</h2>
<p>Quran kehta hai: "Tum mein se jo log wafat pa jayen aur biwiyan chhor jayen, woh biwiyan apne aap ko 4 mahine 10 din rokay rakhen" (Surah al-Baqarah 2:234). Yeh hukm har bewa ke liye hai, jawan ho ya umar raseedah, rukhsati hui ho ya na hui ho, haiz aata ho ya na aata ho. Sirf hamal is ko badalta hai.</p>
<ul>
<li><strong>Agar wafat Islami mahine ki pehli tareekh ko hui</strong> to 4 mahine chaand se gine jate hain aur 10 din jor diye jate hain.</li>
<li><strong>Agar kisi aur din hui</strong> to Imam Abu Hanifa ke nazdeek har mahina 30 din ka gina jata hai, yani poore 130 din. Kuch ulama sirf pehle adhoore mahine ko dinon se poora karte hain; farq zyada se zyada aik do din ka hai.</li>
<li><strong>Iddat wafat ke waqt se shuru hoti hai,</strong> khabar milne se nahi. Agar khabar 130 din ke baad mile to iddat pehle hi poori ho chuki.</li>
</ul>
<p><strong>Misaal:</strong> shohar ki wafat 15 March 2026 ko hui (26 Ramazan 1447, mahine ki pehli tareekh nahi). Hanafi hisab se 130 din: iddat <strong>23 July 2026</strong> ko khatam hoti hai, usi waqt jis waqt wafat hui thi.</p>
<p>Bewa iddat mein sog (ihdad) karti hai: zeenat, khushbu, mehndi aur shokh zevar se bachti hai (Bukhari 1280), aur jahan mumkin ho shohar wale ghar mein rehti hai (Abu Dawud 2300). Hanafi ulama ne us bewa ko jise rozi kamani ho, din mein bahar jane aur raat ghar wapas aane ki ijazat di hai.</p>
<h2>Talaq ki iddat: 3 haiz ya 3 tuhr</h2>
<p>"Talaq wali auratein apne aap ko teen quru' tak rokay rakhen" (Surah al-Baqarah 2:228). Arabi lafz quru' ke do maani hain, is liye maslakon ka hisab alag hai:</p>
<ul>
<li><strong>3 haiz:</strong> Hanafi, Hanbali aur aksar Ahl-e-Hadith ulama. Talaq ke baad teesra poora haiz khatam hone par iddat khatam. Jis haiz ke dauran talaq di gayi woh nahi gina jata.</li>
<li><strong>3 tuhr (paki ke din):</strong> Shafi'i, Maliki aur Shia Ja'fari fiqh. Talaq ke baad teesra haiz shuru hote hi iddat khatam, is liye yeh kuch din chhoti hoti hai.</li>
</ul>
<p><strong>Misaal:</strong> aakhri haiz 1 January 2026 ko shuru hua, 6 din raha, aur haiz har 28 din baad aata hai. Talaq 10 January ko paki ki halat mein hui. Agle haiz taqreeban 29 January, 26 February aur 26 March ko shuru honge. Hanafi hisab se teesra haiz khatam hone par iddat <strong>1 April 2026</strong> (81 din) ko poori, aur Shafi'i hisab se teesra haiz shuru hote hi <strong>26 March 2026</strong> (75 din) ko. Yeh andaza hai; asal mein iddat aurat ke asal haiz par khatam hoti hai.</p>
<p><strong>Jis aurat ko haiz na aata ho</strong> (kam umar, ya umar ki wajah se band ho chuka ho) us ki iddat 3 mahine hai (Surah at-Talaq 65:4): talaq Islami mahine ki pehli tareekh ko ho to chaand se, warna 90 din. Ayatollah Sistani ke nazdeek jis aurat ka haiz umar ki wajah se band ho chuka ho us par talaq ki iddat nahi.</p>
<p><strong>Rukhsati aur milap se pehle talaq</strong> ho to koi iddat nahi (Surah al-Ahzab 33:49), aur tay shuda mehr ka aadha wajib hai. Hanafi aur Hanbali fiqh mein nikah ke baad miyan biwi ki sahih khalwat (tanhai ki mulaqat) bhi is hukm mein milap jaisi hai, to poori iddat lazim hoti hai. Bewa ki iddat milap ke baghair bhi hai.</p>
<h2>Khula ki iddat</h2>
<p>Hanafi, Shafi'i aur Maliki fiqh mein khula ki iddat talaq jaisi hai, yani 3 quru'. Ahl-e-Hadith ulama 1 haiz kehte hain, kyun ke Nabi ﷺ ne Thabit bin Qais ki biwi ko aik haiz iddat guzarne ka hukm diya (Abu Dawud 2229, Tirmidhi 1185). Hanbali maslak mein 3 haiz hai, magar Imam Ahmad se aik haiz ki riwayat bhi hai jise Ibn Taymiyyah ne tarjeeh di. Pakistan mein adalat se milne wali khula ke baad bhi yehi iddat hai. Upar wali misaal mein Ahl-e-Hadith hisab se khula ki iddat 4 February 2026 ko poori hoti hai.</p>
<h2>Hamal ki halat mein iddat</h2>
<p>"Aur hamal walion ki iddat yeh hai ke bacha paida ho jaye" (Surah at-Talaq 65:4). Talaq ya khula ke baad har maslak mein iddat paidaish par khatam hoti hai, chahe jaldi ho ya der se. Bewa ke liye bhi chaaron Sunni maslak paidaish par iddat khatam karte hain (Subay'ah Aslamiyyah ki hadith, Muslim 1484). Shia Ja'fari fiqh mein hamla bewa do mein se jo muddat lambi ho woh guzarti hai: paidaish ya 4 mahine 10 din.</p>
<h2>Pakistan ka qanoon: 90 din ka notice</h2>
<p>Muslim Family Laws Ordinance 1961 ki dafa 7 ke tehat talaq dene wala shohar Union Council ke chairman ko likhit notice deta hai aur biwi ko us ki copy. Qanooni tor par talaq notice milne ke 90 din baad muasir hoti hai, aur hamal ho to paidaish ke baad, agar woh baad mein ho. Calculator yeh 90 din wali tareekh bhi dikhata hai. Yeh qanooni tareekh hai, fiqhi iddat ki jagah nahi; apne case ke liye wakeel se poochen.</p>
<h2>Iddat mein kya mana hai?</h2>
<ul>
<li><strong>Naya nikah:</strong> iddat mein nikah sahih nahi (2:235). Bewa ko ishare mein paigham diya ja sakta hai, khula paigham ya waada nahi.</li>
<li><strong>Bila zaroorat ghar se nikalna,</strong> Hanafi fiqh mein bewa aur talaq wali dono ke liye. Talaq-e-raj'i ki iddat mein shohar naye nikah ke baghair ruju kar sakta hai.</li>
<li><strong>Zeenat:</strong> bewa ke liye, aur Hanafi fiqh mein talaq-e-ba'in wali ke liye bhi.</li>
</ul>
<p>Hanafi maslak mein talaq wali biwi ko iddat ka nan nafaqa aur rehaish milti hai. Bewa ko tarke se apna hissa milta hai: <a href="/wife-husband-share-in-inheritance/">biwi ka wirasat mein hissa</a> aur <a href="/wirasat-calculator/">wirasat calculator</a> dekhen. Baqaya mehr shohar par qarz hai jo pehle ada hota hai; aaj ki raqam ke liye <a href="/haq-mehr-in-rupees/">haq mehr in rupees</a> dekhen.</p>
<h2>Aam ghaltiyan</h2>
<ul>
<li><strong>Iddat ko khabar milne se ginna.</strong> Iddat wafat ya talaq ke waqt se shuru hoti hai.</li>
<li><strong>Har talaq ki iddat 3 mahine samajhna.</strong> Haiz wali aurat ki iddat haiz se gini jati hai, mahinon se nahi.</li>
<li><strong>Bewa ki iddat ko 3 haiz samajhna.</strong> Bewa ki iddat 4 mahine 10 din hai, haiz se nahi.</li>
<li><strong>Qanooni 90 din ko iddat samajhna.</strong> Union Council ka 90 din wala waqt qanoon ka hai; fiqhi iddat alag gini jati hai.</li>
</ul>
<p>Mukammal tafseel angrezi mein: <a href="/iddat-calculator/">iddat calculator</a>; Urdu mein: <a href="/iddat-calculator-urdu/">عدت کیلکولیٹر</a>. Yeh page Quran, hadith aur har maslak ke shaya shuda fatawa ki roshni mein hai, fatwa nahi. Apni soorat ke liye, khaas tor par be-qaida haiz ya tareekh mein shak ho to, kisi mufti ya aalim se zaroor poochen.</p>
[myzt_faq]
HTML
			. $author . '[myzt_related slugs="iddat-calculator,iddat-calculator-urdu,haq-mehr-in-rupees,wife-husband-share-in-inheritance"]',
			'faq'     => array(
				array( 'q' => 'Bewa ki iddat kitne din ki hai?', 'a' => '4 Islami mahine aur 10 din. Agar shohar ki wafat Islami mahine ki pehli tareekh ko na hui ho to Hanafi hisab se 130 din.' ),
				array( 'q' => 'Talaq ki iddat kitne din ki hoti hai?', 'a' => 'Haiz wali aurat ki 3 haiz (Hanafi, Hanbali, aksar Ahl-e-Hadith) ya 3 tuhr (Shafi\'i, Maliki, Ja\'fari), jo aam tor par do se teen mahine banti hai. Haiz na aata ho to 3 mahine (90 din), aur hamal ho to paidaish tak.' ),
				array( 'q' => 'Khula ki iddat kitni hai?', 'a' => 'Hanafi, Shafi\'i aur Maliki fiqh mein talaq jaisi, yani 3 haiz ya tuhr. Ahl-e-Hadith ulama ke nazdeek 1 haiz.' ),
				array( 'q' => 'Kya rukhsati se pehle talaq ki iddat hoti hai?', 'a' => 'Nahi, agar milap ya (Hanafi aur Hanbali fiqh mein) sahih khalwat na hui ho (Surah al-Ahzab 33:49). Bewa ki iddat rukhsati ke baghair bhi hai.' ),
				array( 'q' => 'Iddat kab se shuru hoti hai?', 'a' => 'Wafat ya talaq ke waqt se, chahe aurat ko khabar baad mein mile.' ),
				array( 'q' => '130 din ki iddat kis ke liye hai?', 'a' => 'Us bewa ke liye jis ke shohar ki wafat Islami mahine ki pehli tareekh ke ilawa kisi din hui: 4 mahine × 30 din + 10 din = 130 din.' ),
			),
		),

		'zakat-kaise-nikalen' => array(
			'title'   => 'Zakat Kaise Nikalen: Zakat Ka Hisab Asan Tareeqe Se',
			'seo'     => 'Zakat Kaise Nikalen? Zakat Ka Hisab Asan Tareeqe Se ({year})',
			'desc'    => 'Zakat ka hisab step by step: nisab, 2.5%, 1 lakh par Rs 2,500, lakh se crore tak table, 1 tola sone ki zakat, masarif e zakat ki list aur bank ki katauti.',
			'nav'     => 'Zakat kaise nikalen',
			'blurb'   => 'zakat ka hisab',
			'content' => <<<'HTML'
[myzt_answer q="Zakat kaise nikalte hain?"]Apni zakat ki tareekh par apna sara naqd paisa, bank balance, sona, chandi aur karobari maal jama karen, jo qarz abhi ada karna hai woh minus karen, aur agar baqi raqam nisab (aaj taqreeban [myzt_rate type="nisab-silver" currency="PKR"]) se zyada ho to us ka 2.5% zakat hai. Yani har 1 lakh rupay par Rs 2,500, ya kul raqam ko 40 se taqseem kar den.[/myzt_answer]
<p>Zakat Islam ka teesra rukn hai, magar har saal Ramazan aate hi ghar mein yehi sawal hota hai: zakat kaise nikalen, kis cheez par hai, aur kitni banti hai? Is guide mein hum zakat ka hisab bilkul asan tareeqe se, qadam ba qadam samjhayenge, rupees ki misaalon ke saath. Neeche calculator bhi hai jis mein aap apne asal figures daal kar foran apni zakat dekh sakte hain.</p>
[zakat_calculator tiles="cash,bank,gold" currency="PKR" unit="tola" madhab="hanafi"]
<h2>Zakat kis par farz hai?</h2>
<p>Zakat har us aqil, baligh Muslim par farz hai jo nisab ke barabar zakat wale maal ka malik ho aur us maal par ek qamri (Islami) saal guzar jaye. Is saal ko hawl kehte hain. Hanafi fiqh mein nabaligh bachon ke maal par zakat nahi, jabke Shafi'i, Maliki aur Hanbali maslak mein bachon ke maal par bhi zakat hai jo sarparast ada karta hai.</p>
<p>Zakat in cheezon par hai:</p>
<ul>
<li>Ghar mein rakha naqd paisa, har bank account ka balance, prize bonds aur savings certificates</li>
<li>Sona aur chandi, chahe zevar ki shakal mein ho, sikke hon ya biscuit (zevar par maslak ka farq neeche dekhein)</li>
<li>Dukan ka maal, yani karobari stock, bechne ki qeemat par</li>
<li>Bechne ki niyyat se khareeda gaya plot ya makan</li>
<li>Committee (BC) mein ab tak jama ki gayi raqam, aur woh qarz jo aap ne kisi ko diya ho aur wapas milne ki umeed ho</li>
<li>Shares aur mutual funds jo bechne ke liye rakhe hon</li>
</ul>
<p>Rehne ka ghar, apni sawari ki gaari, ghar ka furniture, kapre, kaam ke auzaar aur kitabein zaroorat ki cheezein hain, in par zakat nahi.</p>
<h2>Nisab kya hai?</h2>
<p>Nisab woh kam se kam miqdar hai jis ke baad zakat farz hoti hai. Chandi ka nisab 52.5 tola (612.35 gram) hai aur sone ka nisab 7.5 tola (87.48 gram). Aaj ke rate par chandi ka nisab taqreeban [myzt_rate type="nisab-silver" currency="PKR"] hai aur sone ka [myzt_rate type="nisab-gold" currency="PKR"].</p>
<p>Hanafi ulama, jaise Darul Uloom Deoband, kehte hain ke agar aap ke paas naqdi, ya sona aur chandi dono, ya karobari maal mila jula ho to sab ki qeemat jor kar chandi ke nisab se dekha jaye, kyun ke is mein ghareebon ka faida zyada hai. Agar sirf sona ho aur kuch aur na ho to sone ka nisab, 7.5 tola, lagta hai. Tafseel ke liye <a href="/nisab/">aaj ka nisab</a> dekhein, ya Urdu mein <a href="/nisab-urdu/">نصاب</a>.</p>
<h2>Zakat ka hisab: qadam ba qadam</h2>
<ol>
<li><strong>Apni zakat ki tareekh tay karen.</strong> Yeh woh Islami tareekh hai jis din aap ka maal pehli dafa nisab tak pohancha tha. Bahut se log 1 Ramazan rakhte hain. Har saal usi Islami tareekh par hisab karen; <a href="/hawl-zakat-due-date/">hawl ki guide</a> aur <a href="/zakat-date-calculator/">zakat date calculator</a> is mein madad karte hain.</li>
<li><strong>Sara zakat wala maal jama karen.</strong> Naqdi, har bank account, sona, chandi, committee ki jama raqam, dukan ka maal aur dosri cheezein jo upar likhi hain. Sone aur chandi ki qeemat usi din ke rate se lagayen, khareed ki qeemat se nahi.</li>
<li><strong>Qarz minus karen.</strong> Hanafi fiqh mein jo qarz abhi ada karna hai, jaise is mahine ka kiraya, bill, ya lambe qarz ki agle saal ki qiston, woh minus hota hai. Shafi'i maslak aur Ahl-e-Hadith (Saudi Permanent Committee ke mutabiq) mein qarz minus nahi hota.</li>
<li><strong>Nisab se muqabla karen.</strong> Agar baqi raqam nisab se kam hai to is saal zakat farz nahi. Agar barabar ya zyada hai to poori raqam par zakat hai, sirf nisab se upar wale hisse par nahi.</li>
<li><strong>2.5% nikalen.</strong> Kul raqam ko 40 se taqseem karen, ya 0.025 se zarb den. Yehi aap ki zakat hai.</li>
<li><strong>Bank ki katauti minus karen.</strong> Agar bank ne 1 Ramazan ko aap ke savings account se zakat kaati hai to woh raqam aap ki zakat mein shumar hogi; baqi khud ada karen.</li>
<li><strong>Mustahiq ko den.</strong> Zakat dete waqt, ya raqam alag karte waqt, zakat ki niyyat karen aur kisi mustahiq shakhs ko us ka malik bana den.</li>
</ol>
<h2>Misaal: Ahmed ki zakat</h2>
<p>Ahmed Lahore mein rehte hain aur Hanafi hain. Un ki zakat ki tareekh 1 Ramazan hai. Us din un ke paas yeh hai (misaal ke liye 22K sone ka rate Rs 4,12,500 fi tola maan lete hain; asal hisab aaj ke rate se calculator karega):</p>
<ul>
<li>Bank ka savings account: Rs 3,00,000</li>
<li>Apna 2 tola 22K sona: 2 × Rs 4,12,500 = Rs 8,25,000</li>
<li>Committee mein ab tak jama: Rs 60,000</li>
<li>Is mahine ka credit card bill: Rs 40,000 (minus)</li>
</ul>
<p>Kul: Rs 3,00,000 + Rs 8,25,000 + Rs 60,000 − Rs 40,000 = <strong>Rs 11,45,000</strong>. Yeh chandi ke nisab se kahin zyada hai, is liye zakat 2.5% = <strong>Rs 28,625</strong>. Agar bank ne 1 Ramazan ko savings account se Rs 7,500 kaat liye the to ab Ahmed ko Rs 21,125 khud ada karne hain.</p>
<h2>1 lakh par kitni zakat hai?</h2>
<p>1 lakh rupay par zakat Rs 2,500 hai, yani 2.5%. Lekin yeh tab hai jab aap ka kul zakat wala maal nisab se zyada ho aur saal guzar gaya ho. Agar aap ke paas sirf 1 lakh rupay hain aur kuch aur nahi, to yeh aaj ke chandi ke nisab se kam hai, is liye zakat farz nahi. Ziyada tar gharon mein thora sona ya bachat bhi hoti hai; sab mila kar nisab se upar ho to 1 lakh par bhi Rs 2,500 dena hoga. English mein tafseel: <a href="/zakat-on-1-lakh-rupees/">zakat on 1 lakh rupees</a>.</p>
<h2>Lakh se crore tak zakat ka table</h2>
<figure class="wp-block-table"><table><thead><tr><th>Raqam</th><th>Zakat (2.5%)</th></tr></thead><tbody>
<tr><td>Rs 1,00,000 (1 lakh)</td><td>Rs 2,500</td></tr>
<tr><td>Rs 2,00,000 (2 lakh)</td><td>Rs 5,000</td></tr>
<tr><td>Rs 5,00,000 (5 lakh)</td><td>Rs 12,500</td></tr>
<tr><td>Rs 10,00,000 (10 lakh)</td><td>Rs 25,000</td></tr>
<tr><td>Rs 20,00,000 (20 lakh)</td><td>Rs 50,000</td></tr>
<tr><td>Rs 50,00,000 (50 lakh)</td><td>Rs 1,25,000</td></tr>
<tr><td>Rs 1,00,00,000 (1 crore)</td><td>Rs 2,50,000</td></tr>
</tbody></table></figure>
<p>Yeh raqam sirf tab farz hai jab aap ka kul maal nisab se zyada ho aur us par saal guzar chuka ho. Beech ki kisi raqam ke liye har lakh par Rs 2,500 jor len: masalan 3.5 lakh par Rs 8,750.</p>
<h2>1 tola sone ki zakat kitni hoti hai?</h2>
<p>Aaj ke rate par 1 tola 24 karat sone ki zakat taqreeban [myzt_rate type="gold-tola-zakat" currency="PKR"] hai, aur 1 tola 22 karat sone ki taqreeban [myzt_rate type="gold22-tola-zakat" currency="PKR"]. Yeh sone ki aaj ki qeemat ka 2.5% hai. 22 karat mein sirf khalis sona (91.7%) gina jata hai, is liye us ki zakat kam banti hai. Nag, moti aur banwai ki qeemat nahi gini jati.</p>
<p>Yaad rakhen: agar aap ke paas sirf 1 tola sona hai aur kuch aur maal nahi, to zakat farz nahi, kyun ke yeh sone ke nisab (7.5 tola) se kam hai. Agar sath mein kuch naqdi ya bachat bhi hai to Hanafi fiqh mein sab mila kar chandi ke nisab se dekha jata hai, aur aksar zakat farz ho jati hai. 1 se 50 tola tak aaj ka table <a href="/zakat-on-1-tola-gold/">zakat on 1 tola gold</a> par hai, aur sone ka hisab <a href="/zakat-on-gold-calculator/">zakat on gold calculator</a> ya Urdu mein <a href="/zakat-on-gold-urdu/">سونے پر زکوٰۃ</a> se karen.</p>
<h2>Zevar par zakat: maslak ka farq</h2>
<ul>
<li><strong>Hanafi (Deobandi, Barelvi):</strong> sone chandi ke zevar par zakat hai, chahe roz pehna jaye.</li>
<li><strong>Ahl-e-Hadith:</strong> Saudi Permanent Committee ke fatwe ke mutabiq, jis par hamara calculator chalta hai, nisab tak pohanchne wale zevar par zakat hai, chahe pehna jaye.</li>
<li><strong>Shafi'i, Maliki, Hanbali:</strong> jaiz zevar jo pehna jata ho us par zakat nahi; bachat ke liye rakhe zevar par hai.</li>
<li><strong>Fiqh-e-Jafaria (Ayatollah Sistani):</strong> naqdi aur zevar par zakat nahi, balke saal ki bachat par khums hai. <a href="/khums-calculator/">Khums calculator</a> dekhein.</li>
</ul>
<p>Zevar ki zakat us par hai jo us ka malik hai. Agar zevar biwi ki milkiyat hai to zakat biwi par hai; shohar us ki ijazat se ada kar sakta hai. Har maslak ka farq ek saath dekhne ke liye <a href="/madhab-comparison/">madhab comparison</a>, aur zevar ki tafseel <a href="/zakat-on-jewellery/">zakat on jewellery</a> par hai.</p>
<h2>Bank ki zakat katauti</h2>
<p>Pakistan mein Zakat and Ushr Ordinance 1980 ke tehat bank 1 Ramazan ko savings aur munafa wale accounts se 2.5% zakat kaat-te hain, agar balance hukumat ke elaan kiye gaye nisab se zyada ho. Current account se zakat nahi katti. Yeh katauti sirf us ek account ki hai; aap ka sona, ghar ki naqdi aur dosre account is mein shamil nahi. Is liye apni poori zakat ka hisab karen aur bank ki katauti us mein se minus kar den. Fiqh-e-Jafaria ke pairokar CZ-50 declaration de kar katauti rukwa sakte hain. Tafseel: <a href="/bank-zakat-deduction-pakistan/">bank zakat deduction in Pakistan</a>.</p>
<h2>Masarif e zakat list: zakat kis ko den?</h2>
<p>Quran Majeed mein zakat ke aath masarif bataye gaye hain (Surah at-Tawbah 9:60):</p>
<ol>
<li><strong>Fuqara:</strong> ghareeb log jin ke paas bunyadi zarooraton ke ilawa nisab ke barabar maal na ho.</li>
<li><strong>Masakeen:</strong> jo un se bhi zyada tangi mein hon.</li>
<li><strong>Amileen:</strong> hukumat ya kisi muntazim idare ki taraf se zakat jama aur taqseem karne wale.</li>
<li><strong>Muallafat ul quloob:</strong> jin ke dil Islam ki taraf mail karne hon. Hanafi ulama ke nazdeek yeh hissa aaj istemal nahi hota.</li>
<li><strong>Riqab:</strong> ghulamon ko azad karana; aaj kal bahut se ulama is ko na-haq qaid logon ki rihai par lagate hain.</li>
<li><strong>Ghaarimeen:</strong> qarzdar jo jaiz zaroorat ke liye liya gaya qarz ada na kar saken.</li>
<li><strong>Fi sabeelillah:</strong> Allah ki raah mein; Hanafi fiqh mein is se murad zaroorat mand mujahid ya deeni ilm ka ghareeb talib-e-ilm hai.</li>
<li><strong>Ibn us sabeel:</strong> musafir jis ke paas safar mein paise khatam ho jayen, chahe ghar par maaldar ho.</li>
</ol>
<p>Apne maa baap, dada dadi, nana nani, aulad aur pote poti ko zakat nahi de sakte, aur shohar apni biwi ko zakat nahi de sakta. Chaaron Sunni maslak mein Sayyid ko zakat nahi di jati. Mustahiq bhai, behan, chacha, mamu, khala aur dosre rishtedaron ko dena jaiz hai aur is mein dugna sawab hai. Masjid ki tameer mein zakat nahi lagti, kyun ke zakat kisi mustahiq shakhs ki milkiyat mein jana zaroori hai. Poori tafseel ke liye <a href="/who-can-receive-zakat/">who can receive zakat</a> ya Urdu mein <a href="/who-can-receive-zakat-urdu/">زکوٰۃ کس کو دی جا سکتی ہے</a> parhen.</p>
<h2>Aam ghaltiyan</h2>
<ul>
<li><strong>Sirf bank ki katauti ko poori zakat samajhna.</strong> Woh sirf ek account ki hai.</li>
<li><strong>Sone ki khareed ki qeemat lagana.</strong> Zakat ki tareekh wale din ki qeemat lagti hai.</li>
<li><strong>22 karat zevar ko 24 karat ginna.</strong> Sirf khalis sona gina jata hai.</li>
<li><strong>Har saal ek hi angrezi tareekh rakhna.</strong> Zakat ka saal qamri hai, angrezi tareekh har saal taqreeban 11 din pehle aati hai.</li>
<li><strong>Zakat ki tareekh guzar jane ke baad Ramazan ka intezar karna.</strong> Zakat farz hone ke baad der nahi karni chahiye; pehle ada karna jaiz hai, baad mein dena nahi.</li>
<li><strong>Chhooti hui zakat bhool jana.</strong> Pichle saalon ki zakat bhi zimme rehti hai; <a href="/missed-zakat-past-years/">missed zakat ki guide</a> dekhein.</li>
</ul>
<p>Apni asal zakat ke liye upar wala calculator ya <a href="/zakat-calculator-pakistan/">Pakistan zakat calculator</a> istemal karen, aur Urdu mein <a href="/zakat-calculator-urdu/">زکوٰۃ کیلکولیٹر</a>. Yeh guide fatwa nahi hai; apne khaas masle ke liye kisi mustanad aalim se zaroor poochen.</p>
[myzt_faq]
HTML
			. $author . '[myzt_related slugs="zakat-on-1-lakh-rupees,zakat-on-1-tola-gold,who-can-receive-zakat-urdu,zakat-calculator-urdu"]',
			'faq'     => array(
				array( 'q' => 'Zakat kaise nikalte hain?', 'a' => 'Zakat ki tareekh par sara naqd paisa, bank balance, sona, chandi aur karobari maal jama karen, jo qarz abhi ada karna hai woh minus karen, aur agar baqi raqam nisab se zyada ho to us ka 2.5% (kul raqam ka chalisvan hissa) zakat hai.' ),
				array( 'q' => '1 lakh par kitni zakat hai?', 'a' => 'Rs 2,500, agar aap ka kul zakat wala maal nisab se zyada ho aur us par saal guzar gaya ho. Sirf 1 lakh ho aur kuch aur na ho to yeh aaj ke nisab se kam hai aur zakat farz nahi.' ),
				array( 'q' => '1 tola sone ki zakat kitni hoti hai?', 'a' => '1 tola sone ki aaj ki qeemat ka 2.5%. 22 karat mein sirf khalis sona (91.7%) gina jata hai. Agar sirf 1 tola sona ho aur kuch aur maal na ho to zakat farz nahi.' ),
				array( 'q' => '1 crore par kitni zakat hai?', 'a' => 'Rs 2,50,000, yani 2.5%, agar zakat ki shuroot poori hon.' ),
				array( 'q' => 'Masarif e zakat kitne hain?', 'a' => 'Aath: fuqara, masakeen, amileen, muallafat ul quloob, riqab, ghaarimeen, fi sabeelillah aur ibn us sabeel (Surah at-Tawbah 9:60).' ),
				array( 'q' => 'Kya bank ki katauti ke baad dobara zakat deni hogi?', 'a' => 'Apni poori zakat ka hisab karen aur bank ne jo kaata hai woh us mein se minus kar den; baqi raqam khud ada karen.' ),
			),
		),
		'zakat-on-pension-401k-isa' => array(
			'title'   => 'Zakat on Pensions, 401(k), IRA, ISA and Mortgages',
			'seo'     => 'Zakat on Pension, 401(k), IRA, ISA & Mortgage ({year})',
			'desc'    => 'Zakat on a UK pension, SIPP or ISA, a US 401(k), IRA or RRSP: the three scholarly views, worked examples, and how much of a mortgage to deduct.',
			'nav'     => 'Zakat on pensions',
			'blurb'   => '401(k), ISA, mortgage',
			'content' => <<<'HTML'
[myzt_answer q="Is zakat due on a pension or 401(k)?"]Scholars differ. Many say no zakat is due on a pension you cannot yet withdraw, because it is not fully in your hands; others count every year what you could withdraw today after the penalty and tax; some count only the zakatable part of the investments inside it. A cash ISA is like a bank balance and a stocks and shares ISA like shares. For a mortgage, most contemporary scholars deduct only the instalments due in the next 12 months, not the whole loan.[/myzt_answer]
<p>Muslims in the UK, the US, Canada and Australia hold much of their wealth in accounts that classical books never discussed: workplace pensions, SIPPs, 401(k)s, IRAs, RRSPs, superannuation and ISAs. Many also carry a mortgage that is larger than all their savings. This guide sets out how scholars apply the rules of zakat to them, so you can follow the view of the scholar you trust and enter the right figures in the calculator.</p>
[zakat_calculator tiles="bank,shares,debts"]

<h2>The principle: is it fully yours, and can you reach it?</h2>
<p>Zakat is due on wealth you own completely (<em>milk tamm</em>) and can use. Classical scholars applied this to money held by someone else: a debt owed by a willing payer is counted, while wealth that is lost, seized or out of reach is not, or is counted only when it comes back (al-Kasani, <em>Bada'i al-Sana'i</em>; Ibn Qudamah, <em>al-Mughni</em>). A pension sits between the two. The money is invested in your name, but the law stops you taking it before a set age, or lets you take it only with a penalty. That is why contemporary scholars reach different answers, much as they do for the <a href="/zakat-on-provident-fund/">provident fund and GP fund</a> in Pakistan.</p>

<h2>Defined benefit (final salary) pensions</h2>
<p>A defined benefit pension, such as an NHS, teachers' or civil service pension in the UK or a traditional employer pension in the US, promises you an income later. There is no pot that belongs to you today, only a promise. Scholars broadly agree that <strong>no zakat is due on it until the payments reach you</strong>; once received, money you still hold on your zakat date is counted with your other savings. A tax-free lump sum is counted once you receive it.</p>

<h2>Defined contribution pensions: the three views</h2>
<p>A defined contribution pension is a pot of investments in your name: a UK workplace pension or SIPP, a US 401(k), 403(b) or IRA, a Canadian RRSP or an Australian super fund. The views are:</p>
<ol>
<li><strong>No zakat until you can access it.</strong> Before the minimum pension age (55 in the UK, rising to 57 in 2028; 59½ for a US 401(k) or IRA), you cannot take the money out, or only at a heavy cost. Many scholars, including many South Asian Hanafi muftis reasoning as Mufti Muhammad Shafi did for the provident fund, say it is not yet fully yours, so nothing is due until you can draw it. Some of them then ask for one year's zakat when it is received; others count it from then on like any other savings.</li>
<li><strong>Zakat every year on what you could withdraw today.</strong> Many North American scholars and zakat organisations point out that a 401(k) or IRA can in fact be cashed in early, with a 10% penalty and income tax. On this view you count each year the amount you would actually receive if you withdrew it now, after the penalty and tax.</li>
<li><strong>Zakat on the zakatable part of the investments.</strong> Some scholars, using the same method as for long-term shares, count only the part of the fund that is cash, bonds or the companies' own zakatable assets (cash, receivables, stock), not their buildings and machinery. This usually gives a much smaller figure; see <a href="/zakat-on-shares/">zakat on shares and funds</a>.</li>
</ol>
<p>Once you reach pension age and can draw the pot freely, the main reason for the first view falls away, and most scholars then count the value you could take (after tax) each year.</p>

<h3>Worked example: a 401(k) at age 40</h3>
<p>Yusuf lives in Texas and has $100,000 in his 401(k) and $20,000 in his checking account. If he cashed in the 401(k) today he would pay a 10% penalty ($10,000) and, say, 22% federal income tax ($22,000), leaving $68,000 (figures are only for the example).</p>
<ul>
<li><strong>View 1:</strong> he counts only the $20,000 in his checking account. Zakat: $500 if that is above the nisab, about [myzt_rate type="nisab-silver" currency="USD"] by silver today.</li>
<li><strong>View 2:</strong> $20,000 + $68,000 = $88,000. Zakat: <strong>$2,200</strong>.</li>
<li><strong>View 3:</strong> $20,000 plus the zakatable part of the funds inside the 401(k), which depends on what they hold.</li>
</ul>
<h3>Worked example: a UK workplace pension and SIPP</h3>
<p>Ayesha is 38 and lives in Birmingham. She has £45,000 in a workplace pension and a SIPP, £8,000 in a cash ISA and £3,000 in her current account. She cannot touch the pensions until 57. On view 1 she counts £11,000 and pays £275. If her scholar follows view 2, she can only use the value she could actually get, and as UK pensions cannot be cashed in before pension age at all (except in rare cases such as serious ill health), many who hold view 2 for a 401(k) still apply view 1 to UK pensions.</p>

<h2>ISAs and other savings accounts</h2>
<ul>
<li><strong>Cash ISA:</strong> the same as a bank balance. Count the whole balance. Interest on a conventional cash ISA is a separate question; many scholars ask you to give it away without intending reward, and not to count it as your wealth.</li>
<li><strong>Stocks and shares ISA:</strong> the ISA is only a tax wrapper. Count the shares and funds inside it as you would anywhere else (market value if held to sell; the zakatable part, or the market value to be cautious, if held long term); see <a href="/zakat-on-shares/">zakat on shares</a>.</li>
<li><strong>Lifetime ISA:</strong> you can withdraw early, but with a 25% charge. Count what you would receive after the charge, or the full value to be cautious.</li>
<li><strong>Junior ISA and children's accounts:</strong> the money belongs to the child. In the Hanafi madhab there is no zakat on a child's wealth; in the Shafi'i, Maliki, Hanbali and Ahl-e-Hadith views the guardian pays it from the child's money each year.</li>
<li><strong>Roth IRA:</strong> your own contributions (not the growth) can be withdrawn at any time without penalty or tax, so most scholars count at least the contributions every year.</li>
<li><strong>US 529 and education accounts:</strong> money you can take back is yours; ask your scholar how to treat the penalty on withdrawals not used for education.</li>
</ul>

<h2>Mortgages, car finance and student loans</h2>
<p>Debts reduce zakat in the Hanafi, Maliki and Hanbali schools, and not in the Shafi'i school (and our Ahl-e-Hadith setting). But a 25-year mortgage is different from a debt you must repay now. If the whole mortgage were deducted, most homeowners in the West would never pay zakat, even with large savings, which scholars do not accept.</p>
<ul>
<li><strong>The common contemporary view:</strong> deduct only the instalments falling due in the next 12 months (or, for some scholars, only those due on your zakat date), not the whole outstanding loan. Mufti Muhammad Taqi Usmani gives this view for long-term debts, and it is widely followed in the UK and North America. In the calculator, open <strong>Debts / Bills</strong> and enter 12 months of mortgage payments under <strong>Instalments due in the next 12 months</strong>.</li>
<li><strong>Maliki:</strong> the classical Maliki rule first sets a debt against wealth that carries no zakat beyond your needs (such as a second car or a second property you live in), and only the rest reduces your zakat.</li>
<li><strong>Shafi'i and Ahl-e-Hadith settings:</strong> no debt is deducted, so the mortgage makes no difference.</li>
<li><strong>Car finance and personal loans:</strong> the same as a mortgage: the next 12 months' payments.</li>
<li><strong>UK student loans:</strong> you repay only from income above a threshold, and the rest is written off. Many scholars therefore deduct nothing, or only what will actually be taken from your salary in the coming year.</li>
<li><strong>Credit cards and bills due now:</strong> deduct in full where your madhab deducts debts.</li>
</ul>
<p>Whether a conventional mortgage is permissible in the first place is a separate question on which scholars also differ; this guide only deals with its effect on zakat.</p>

<h2>How to enter it in the calculator</h2>
<ol>
<li>Choose your madhab and your currency (GBP, USD, CAD, AUD and the rest are all there).</li>
<li>Put bank accounts and cash ISAs under <strong>Bank</strong>.</li>
<li>Put shares, stocks and shares ISAs, and any pension you count (the amount your scholar's view gives) under <strong>Shares</strong>.</li>
<li>Under <strong>Debts / Bills</strong>, enter credit cards and bills due now, and the next 12 months of mortgage and car payments under <strong>Instalments</strong>.</li>
<li>Add gold and anything else you own. The calculator compares the total with the nisab and shows each madhab side by side.</li>
</ol>
<p>Living abroad with savings in Pakistan too? See <a href="/zakat-for-overseas-pakistanis/">zakat for overseas Pakistanis</a>, and for paying it, <a href="/giving-zakat-abroad/">giving zakat abroad and through charities</a>.</p>
<p>This guide is general information, not a fatwa. Pension rules change, and so do your own circumstances; for large sums, ask a qualified scholar.</p>
[myzt_faq]
HTML
			. $author . '[myzt_related slugs="zakat-on-provident-fund,zakat-on-shares,zakat-on-salary,zakat-for-overseas-pakistanis"]',
			'faq'     => array(
				array( 'q' => 'Do I pay zakat on my 401(k)?', 'a' => 'Scholars differ. Some say no zakat until you can withdraw it without penalty; others count each year what you would receive after the 10% penalty and tax; others count only the zakatable part of the funds. Follow the scholar you trust.' ),
				array( 'q' => 'Is zakat due on a UK pension?', 'a' => 'A defined benefit pension carries no zakat until it is paid. For a workplace pension or SIPP you cannot access before pension age, many scholars say nothing is due until you can draw it; others count the zakatable part of the investments.' ),
				array( 'q' => 'Is zakat due on an ISA?', 'a' => 'Yes. A cash ISA is counted like a bank balance; a stocks and shares ISA is counted like the shares and funds inside it.' ),
				array( 'q' => 'Can I deduct my mortgage from zakat?', 'a' => 'Most contemporary scholars deduct only the payments due in the next 12 months, not the whole mortgage. In the Shafi\'i view no debt is deducted.' ),
				array( 'q' => 'Pension fund par zakat hai?', 'a' => 'Jab tak pension fund se raqam nikal nahi sakte, bohat se ulama ke nazdeek us par zakat nahi; mil jane ke baad baqi bachat ke saath shamil hoti hai. Kuch ulama har saal wo raqam ginte hain jo penalty aur tax ke baad abhi nikal sakti hai.' ),
			),
		),

		'giving-zakat-abroad' => array(
			'title'   => 'Giving Zakat Abroad and Through Charities: What to Check',
			'seo'     => 'Giving Zakat Abroad & Through Charities: Rules and Checks',
			'desc'    => 'Sending zakat to another country, giving it through a charity, admin fees, non-Muslims and how to check a zakat fund in the UK, US, Canada and Pakistan.',
			'nav'     => 'Giving zakat abroad',
			'blurb'   => 'charities, abroad',
			'content' => <<<'HTML'
[myzt_answer q="Can I give my zakat abroad or through a charity?"]Yes. In the Hanafi madhab zakat sent to poor relatives or to people in greater need in another country is valid and not disliked, and the other schools allow it for greater need. A charity acts as your agent: your zakat is paid when it reaches an eligible person, so choose one that keeps zakat in a separate fund, gives it to individuals, and tells you how much goes on costs.[/myzt_answer]
<p>Most people do not hand their zakat to the poor themselves. They send it to relatives in Pakistan, India or Bangladesh, give it to a mosque or a large charity, or tap a button in an appeal. Each route works, but each has rules that decide whether your zakat is really paid. This guide covers them, with the checks to make before you give.</p>

<h2>Sending zakat to another country</h2>
<p>Classical scholars discussed moving zakat away from where the wealth is (<em>naql al-zakat</em>). In short: the Hanafi school allows it, without dislike, for poor relatives and people in greater need (<em>al-Hidayah</em>; Ibn 'Abidin, <em>Radd al-Muhtar</em>); the Maliki school allows it where the need is greater; the relied-upon Shafi'i and Hanbali positions prefer local recipients, though zakat sent elsewhere still counts in the Hanbali school and many contemporary scholars of both schools allow it for greater need; scholars followed by Ahl-e-Hadith readers allow it for relatives or need. Followers of Ayatollah Sistani may transfer zakat too, but they bear the risk if it is lost on the way while deserving people were available locally. The madhab-by-madhab detail is on <a href="/zakat-for-overseas-pakistanis/">zakat for overseas Pakistanis</a>.</p>
<h3>Which currency and which rate?</h3>
<ul>
<li>Work out your zakat in one currency on your zakat date (see <a href="/hawl-zakat-due-date/">your zakat date</a>).</li>
<li>When you send it, the recipient must receive the full amount you owe. Transfer fees are your cost, not part of the zakat: if the bank or app keeps £5, add £5.</li>
<li>If you send it in another currency, convert at the rate on the day you pay, so the recipient gets the value of what you owed.</li>
</ul>
<h3>Paying relatives back home</h3>
<p>Poor brothers, sisters, uncles, aunts, nephews and in-laws may receive your zakat, with double reward. Your parents, grandparents, children, grandchildren and spouse cannot. Make the intention of zakat when you send it or when you set it aside; the regular money you send home for household costs is not zakat. You do not have to tell the relative it is zakat. See <a href="/who-can-receive-zakat/">who can receive zakat</a>.</p>

<h2>Giving through a charity or mosque</h2>
<p>A charity that collects zakat acts as your agent (<em>wakil</em>). In the Hanafi madhab and most others, your zakat is paid when the agent hands it to an eligible person, not when you donate. That gives you four things to check:</p>
<ol>
<li><strong>A separate zakat fund.</strong> Zakat must not be mixed with general donations and spent on anything the charity likes.</li>
<li><strong>Ownership by a person (tamlik).</strong> The Hanafi school, followed by most Pakistanis and Indians, requires zakat to become the property of an eligible person. Building a mosque, school or hospital with it, or paying staff salaries, does not count. Food parcels, cash grants, paying a poor person's debt or medical bill on their behalf, and scholarships do.</li>
<li><strong>Costs.</strong> The Quran gives a share to "those employed to collect it" (9:60). Many classical scholars limit this to collectors appointed by a Muslim state; some contemporary scholars allow charities to take a share for collection costs. If you want all of your zakat to reach the poor, choose a charity with a "100% zakat policy" that pays its costs from other donations, or ask what percentage it keeps.</li>
<li><strong>Timing.</strong> Zakat should not be delayed once due. A charity that holds zakat for many months before distributing it delays your payment; ask when it is distributed.</li>
</ol>
<h2>Can zakat go to non-Muslims?</h2>
<p>The four Sunni schools and the Ja'fari school agree that zakat for the poor and needy goes to poor Muslims; the Prophet ﷺ told Mu'adh it is "taken from their rich and given to their poor" (Bukhari 1395). Some scholars allow the category of "those whose hearts are to be reconciled" to include non-Muslims, but the Hanafi school considers that share no longer in use. If a charity helps everyone regardless of faith, give your zakat only if it confirms that zakat goes to eligible Muslims, and help everyone else with your sadaqah, which has no such limit. Ayatollah Sistani adds that zakat for the poor should go to a Shia Ithna Ashari believer.</p>
<h2>Sayyids and Banu Hashim</h2>
<p>In the Sunni schools, descendants of the Prophet's family (Banu Hashim, commonly called Sayyids in South Asia) may not receive zakat; help them from sadaqah. In the Ja'fari school a non-Sayyid's zakat may not go to a Sayyid, who receives sahm-e-sadat from khums instead.</p>

<h2>How to check a charity, by country</h2>
<figure class="wp-block-table"><table><thead><tr><th>Country</th><th>Where to check</th></tr></thead><tbody>
<tr><td>United Kingdom</td><td>The <a href="https://register-of-charities.charitycommission.gov.uk/" rel="nofollow noopener" target="_blank">Charity Commission register</a> (England and Wales), OSCR (Scotland) or the Charity Commission for Northern Ireland: registration number, latest accounts and whether they were filed on time.</td></tr>
<tr><td>United States</td><td>The IRS <a href="https://apps.irs.gov/app/eos/" rel="nofollow noopener" target="_blank">Tax Exempt Organization Search</a> for 501(c)(3) status, and the charity's Form 990.</td></tr>
<tr><td>Canada</td><td>The CRA <a href="https://apps.cra-arc.gc.ca/ebci/hacc/srch/pub/dsplyBscSrch" rel="nofollow noopener" target="_blank">list of charities</a> and its annual T3010 return.</td></tr>
<tr><td>Pakistan</td><td>Registration with the SECP (section 42 companies) or a provincial charity commission, and, for many large charities, certification by the Pakistan Centre for Philanthropy. Ask for audited accounts.</td></tr>
</tbody></table></figure>
<p>Then ask the charity: Is zakat kept in a separate fund? Who decides eligibility, and is there a scholar or Shariah board? What share goes on costs? Where did last year's zakat go? A good zakat charity answers these in writing.</p>
<h2>Warning signs</h2>
<ul>
<li>Appeals forwarded on WhatsApp or social media with only a personal bank account or a mobile wallet number.</li>
<li>No registration number, no accounts, or a name that imitates a well-known charity.</li>
<li>Pressure to give "today only", or a promise that a donation will bring a particular reward or cure.</li>
<li>Zakat spent on buildings, events or staff with no separate zakat fund.</li>
</ul>
<h2>Giving directly</h2>
<p>Giving to people you know is in need, such as a relative, a neighbour, a widow in your area or a student, is often the surest way: you know they are eligible and that the full amount reached them. You may give someone more than the nisab in one go in the view of most scholars, although the Hanafi school dislikes making one poor person rich from zakat without a reason such as debt.</p>
<p>To work out how much to give, use the <a href="/">zakat calculator</a>; for who may receive it, see <a href="/who-can-receive-zakat/">the 8 categories</a>. This guide is general information, not a fatwa.</p>
[myzt_faq]
HTML
			. $author . '[myzt_related slugs="who-can-receive-zakat,zakat-for-overseas-pakistanis,zakat-on-pension-401k-isa,hawl-zakat-due-date"]',
			'faq'     => array(
				array( 'q' => 'Can I send my zakat to Pakistan from the UK?', 'a' => 'Yes. In the Hanafi madhab zakat sent to poor relatives or people in greater need in another country is valid and not disliked; the other schools allow it for greater need. Add the transfer fee yourself so the full amount arrives.' ),
				array( 'q' => 'Can a charity take admin fees from zakat?', 'a' => 'Scholars differ. Many limit the collectors\' share to collectors appointed by a Muslim state; some allow charities to use part for costs. Choose a charity with a 100% zakat policy if you want all of it to reach the poor.' ),
				array( 'q' => 'Can zakat be given to non-Muslims?', 'a' => 'Zakat for the poor and needy goes to poor Muslims in all the major schools. Help others with sadaqah.' ),
				array( 'q' => 'Kya zakat bahar mulk bhej sakte hain?', 'a' => 'Haan. Hanafi maslak mein ghareeb rishtedaron ya zyada zaroorat mand logon ko doosre mulk mein zakat bhejna jaiz hai. Bhejne ki fees apni taraf se den taake poori zakat pohnche.' ),
				array( 'q' => 'Is zakat paid when I donate to a charity or when it reaches the poor?', 'a' => 'The charity is your agent, so your zakat is paid when it reaches an eligible person. Choose a charity that distributes promptly and keeps zakat separate.' ),
			),
		),
	);
}
