<?php
/**
 * Guide posts that support the newer tools (hawl tracker, fidya/kaffara, ushr/livestock, savings certificates, khums).
 * Loaded by content-posts.php.
 *
 * @package MyZakatTool
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function myzt_content_posts_tools() {
	$author = '[myzt_author]';
	return array(
		'hawl-zakat-due-date' => array(
			'title'   => 'Hawl: When Is Zakat Due? Finding Your Zakat Date',
			'seo'     => 'Hawl and Zakat Due Date: When Is Zakat Due? ({year})',
			'desc'    => 'What hawl is, how to find your zakat date, what happens if wealth dips below nisab or grows mid-year, paying early, Ramadan, and lunar vs solar year.',
			'nav'     => 'Hawl and zakat date',
			'blurb'   => 'zakat ki tareekh',
			'content' => <<<'HTML'
[myzt_answer q="When does zakat become due?"]Zakat becomes due when your zakatable wealth has stayed at or above the nisab for one full lunar year, called the hawl. Your zakat date is the Islamic date on which your wealth first reached the nisab, and it repeats on that same Islamic date every year, about 11 days earlier in the Gregorian calendar each time.[/myzt_answer]
<p>Most people know zakat is 2.5%. Fewer know exactly <em>when</em> it falls due, and that question decides a lot: which balance you use, whether a bonus that arrived last month counts, and whether a bad month in the middle of the year cancels your zakat. This guide explains the zakat year (hawl), how each madhab treats the awkward cases, and what to do if you have lost track of your date. If you already know roughly when your wealth reached the nisab, enter it in our <a href="/zakat-date-calculator/">zakat date calculator</a>: it shows your next three zakat dates with their Hijri dates and can add them to your phone calendar as reminders.</p>
<h2>What hawl means</h2>
<p>Hawl (حول) literally means "a year that has turned". In zakat it is the full lunar year that wealth must be owned at the nisab level before zakat is owed on it. The rule comes from the hadith "There is no zakat on wealth until a year passes over it" (Abu Dawud 1573, narrated from Ali; Ibn Majah 1792, narrated from Aisha). All the Sunni schools apply hawl to cash, savings, gold, silver, trade stock and grazing livestock.</p>
<p>Two things start the clock:</p>
<ol>
<li><strong>Ownership of the nisab.</strong> The value of your zakatable assets, after debts that are due now (in the schools that subtract them), is at or above the nisab. In the Hanafi madhab most people use the silver nisab, which today is about [myzt_rate type="nisab-silver" currency="PKR"]; the gold nisab is about [myzt_rate type="nisab-gold" currency="PKR"]. See the <a href="/nisab/">nisab page</a> for which one your school uses.</li>
<li><strong>A date.</strong> The day you first crossed that line. One lunar year later is your first zakat date.</li>
</ol>
<p>Hawl is not counted per rupee. You do not track when each note entered your account. You have one zakat date, and on that date you look at what you own.</p>
<h2>How to find your zakat date</h2>
<ol>
<li><strong>Think back to when you first had savings above the nisab.</strong> For a salaried person it is often a few months after starting a job. For a woman it may be the day of her wedding, when jewellery and gifts became her own property. For a student it may be the day an inheritance or gift arrived.</li>
<li><strong>Convert that day to its Islamic date.</strong> If it was 15 January 2025, that was about 15 Rajab 1446.</li>
<li><strong>Keep that Islamic date for life,</strong> unless your wealth falls away completely and the year has to restart (see below).</li>
<li><strong>Each year on that date,</strong> add up what you own, subtract what your madhab allows, and pay 2.5% if the total is still at or above the nisab.</li>
</ol>
<p>Moon sighting in Pakistan is often a day later than the Umm al-Qura calendar, so treat the Gregorian dates below as approximate. A day either way does not matter much; consistency does.</p>
<h3>Worked example 1: Bilal's dates</h3>
<p>Bilal, a software engineer in Lahore, first had savings above the nisab on 15 Rajab 1446, around 15 January 2025. His zakat dates are:</p>
<figure class="wp-block-table"><table><thead><tr><th>Zakat year</th><th>Islamic date</th><th>Approx. Gregorian date</th></tr></thead><tbody>
<tr><td>Hawl starts</td><td>15 Rajab 1446</td><td>15 January 2025</td></tr>
<tr><td>1st zakat</td><td>15 Rajab 1447</td><td>4 January 2026</td></tr>
<tr><td>2nd zakat</td><td>15 Rajab 1448</td><td>24 December 2026</td></tr>
<tr><td>3rd zakat</td><td>15 Rajab 1449</td><td>13 December 2027</td></tr>
</tbody></table></figure>
<p>Notice the Gregorian date moving back by 10 or 11 days each year. A lunar year is about 354.37 days, while a solar year is 365.25 days. Over roughly 33 years your zakat date passes through every month of the Gregorian calendar. This is why a reminder set for "every 4 January" goes wrong after the first year, and why the <a href="/zakat-date-calculator/">hawl tracker</a> calculates each date from the lunar year instead.</p>
<h2>When wealth dips below the nisab during the year</h2>
<p>This is where the schools genuinely differ, and it affects many families: a wedding, a hospital bill or a business loss can empty an account for a few months.</p>
<h3>Hanafi: only the start and the end count</h3>
<p>In the Hanafi madhab, if the nisab was complete at the beginning of the year and at the end of it, a drop in between does not matter. <em>Al-Hidayah</em> (al-Marghinani, Kitab al-Zakat) states that a decrease of the nisab during the year does not cancel zakat as long as it is complete at both ends. The one exception is if your zakatable wealth is <strong>completely lost</strong> during the year, down to nothing: then the hawl ends, and a new one starts when you next reach the nisab.</p>
<h3>Shafi'i and Hanbali: the nisab must hold all year</h3>
<p>In the Shafi'i and Hanbali schools the nisab must be present continuously for the whole year. If your wealth falls below the nisab even briefly, the year breaks, and a new hawl starts on the day you are back above it. Imam al-Nawawi sets this out in <em>al-Majmu'</em> and Ibn Qudamah in <em>al-Mughni</em>. Many Ahl-e-Hadith scholars take the same view.</p>
<h3>Maliki: continuous, with an exception for profit</h3>
<p>The Maliki school also looks for the nisab across the year for money that comes from outside, such as salary, gifts or inheritance. But it has a well-known rule that <strong>profit follows its capital</strong>: if trading capital grows through profit, the profit takes the start date of the original capital, even if the capital on its own was below the nisab for part of the year (see <em>Mukhtasar Khalil</em>, Bab al-Zakat). For an ordinary salaried person the practical result is close to the Shafi'i view; for a trader it can be closer to the Hanafi result. A trader who follows the Maliki school should confirm the details with a scholar.</p>
<h3>Worked example 2: Amna's difficult year</h3>
<p>For simplicity, assume the nisab is Rs 2,00,000 in this example (check the live figure above for real calculations). Amna's zakat date is 1 Ramadan. On 1 Ramadan 1447 (around 18 February 2026) she had Rs 3,00,000. In Shawwal her mother's operation brought her balance down to Rs 60,000. By Rabi' al-Awwal 1448 she had saved back above Rs 2,00,000, and on 1 Ramadan 1448 (around 8 February 2027) she has Rs 3,50,000.</p>
<ul>
<li><strong>Hanafi:</strong> she had the nisab at both ends, so zakat is due on 1 Ramadan 1448: 2.5% of Rs 3,50,000 = Rs 8,750.</li>
<li><strong>Shafi'i and Hanbali:</strong> her year broke in Shawwal. A new hawl began on the day in Rabi' al-Awwal 1448 when she crossed Rs 2,00,000 again, so nothing is due on 1 Ramadan 1448. Her next zakat date is that day in Rabi' al-Awwal 1449, unless she chooses to pay early.</li>
<li><strong>If her balance had reached zero</strong> in Shawwal, all schools, including the Hanafi, would restart her year from the day she next reached the nisab.</li>
</ul>
<h2>Money added during the year</h2>
<p>Salaries, bonuses, gifts and committee (BC) payouts arrive throughout the year. Do they each need their own year?</p>
<ul>
<li><strong>Hanafi:</strong> no. New money of the same kind joins your existing hawl and is counted on your zakat date, even if it arrived the day before. Cash, gold, silver and trade goods are all one kind for this purpose. This is called <em>damm al-mal al-mustafad</em>, joining acquired wealth to the nisab you already own.</li>
<li><strong>Shafi'i and Hanbali:</strong> money that comes from outside (salary, a gift, an inheritance) starts its own year from the day you receive it. Profit on trade goods and the young of grazing animals follow the year of the original.</li>
<li><strong>Maliki:</strong> similar. New, unrelated wealth (fa'ida) starts its own year; trading profit joins the year of its capital.</li>
</ul>
<p>Tracking a separate year for every salary payment is impractical, so many Shafi'i and Hanbali scholars advise a simpler route: pay on everything you own on your one zakat date. For money that has not yet completed its own year, that payment counts as early zakat, which both schools allow (see below).</p>
<h3>Worked example 3: Hamza's bonus</h3>
<p>Hamza's zakat date is 10 Muharram. On 10 Muharram 1447 (around 5 July 2025) he paid zakat on Rs 4,00,000. That balance stayed through the year, and in Rabi' al-Thani 1447, a few months later, his company paid him a Rs 2,00,000 bonus. On 10 Muharram 1448 (around 25 June 2026) he has Rs 6,00,000.</p>
<ul>
<li><strong>Hanafi:</strong> the bonus joins his year. Zakat is 2.5% of Rs 6,00,000 = Rs 15,000.</li>
<li><strong>Shafi'i or Hanbali:</strong> Rs 10,000 is due now on the original Rs 4,00,000. The Rs 5,000 on the bonus is due when the bonus completes its own year in Rabi' al-Thani 1448. He may simply pay all Rs 15,000 now, treating the Rs 5,000 as an advance.</li>
</ul>
<h2>Paying zakat early (ta'jil)</h2>
<p>Paying before your zakat date is called ta'jil. The basis is the hadith in which al-Abbas asked the Prophet ﷺ whether he could pay his zakat before it was due, and he was allowed to (Abu Dawud 1624; Tirmidhi 678). The schools agree that you must already own the nisab when you pay early. Beyond that:</p>
<figure class="wp-block-table"><table><thead><tr><th>Madhab</th><th>Dip below nisab mid-year</th><th>Money added mid-year</th><th>Paying early</th></tr></thead><tbody>
<tr><td>Hanafi</td><td>Ignored if nisab at start and end (unless wealth is wiped out)</td><td>Joins your existing year</td><td>Allowed, even for several years ahead</td></tr>
<tr><td>Shafi'i</td><td>Year breaks and restarts</td><td>Own year (trade profit follows capital)</td><td>Allowed for one year ahead</td></tr>
<tr><td>Hanbali</td><td>Year breaks and restarts</td><td>Own year (trade profit follows capital)</td><td>Allowed, up to two years ahead</td></tr>
<tr><td>Maliki</td><td>Generally breaks; profit follows its capital</td><td>Own year for new money; profit joins capital</td><td>Only a short time before the due date, commonly given as about a month</td></tr>
</tbody></table></figure>
<p>If you pay early and then, on your zakat date, it turns out you did not owe zakat (for example because your wealth was lost), what you gave still counts as sadaqah, with its reward. If you owe more than you paid early, pay the difference on the date. Compare the schools side by side on the <a href="/madhab-comparison/">madhab comparison</a> page.</p>
<h2>Does zakat have to be paid in Ramadan?</h2>
<p>No. Nothing in the Quran or hadith ties zakat on wealth to Ramadan. It is due on your own zakat date, whatever month that falls in. Many people like to give in Ramadan because good deeds are multiplied, and that is fine, but there are two traps:</p>
<ul>
<li><strong>Delaying is not allowed.</strong> If your date is in Rajab, you should not hold the money until Ramadan. Most scholars say zakat should be paid promptly once it is due.</li>
<li><strong>Moving earlier is fine.</strong> If you want to give in Ramadan every year and your date falls after Ramadan, you can pay in Ramadan as an early payment in the Hanafi, Shafi'i and Hanbali schools, then settle any difference on your true date. Under the Maliki rule this works only if Ramadan falls shortly before your date.</li>
</ul>
<p>In Pakistan, banks deduct zakat from savings accounts on 1 Ramadan under the Zakat and Ushr Ordinance. That is the government's collection date, not your hawl. Count the deduction as part of the zakat you owe and subtract it on your own date. See <a href="/bank-zakat-deduction-pakistan/">bank zakat deduction in Pakistan</a> for how this works.</p>
<h2>Lunar or solar year: 2.5% or 2.577%?</h2>
<p>The hawl is a lunar year. Some people, especially business owners whose accounts close on 30 June or 31 December, prefer to calculate zakat on their Gregorian year-end. A solar year is about 11 days longer, so over time they would pay slightly less often than the lunar calendar requires. To make up for this, many contemporary scholars and Islamic finance bodies advise paying 2.577% on a solar year instead of 2.5%. The figure comes from 2.5% × 365.25 ÷ 354.37.</p>
<p>Example: a shop owner has Rs 20,00,000 of zakatable stock and cash on 30 June. On a lunar date the zakat would be Rs 50,000. If he uses 30 June every year, he pays 2.577%, which is Rs 51,540. Our calculators use 2.5% on a lunar year; if you use a solar date, apply 2.577% yourself.</p>
<h2>If you forget your zakat date</h2>
<p>This is very common, especially for people who started earning years ago. Scholars generally advise the following:</p>
<ol>
<li><strong>Make your best honest estimate.</strong> Think of events: your first job, your wedding, a property sale, the first time you opened a savings account. Pick the Islamic date that most likely matches.</li>
<li><strong>When unsure, lean earlier.</strong> Choosing a slightly earlier date means you are less likely to underpay.</li>
<li><strong>If you cannot estimate at all,</strong> pick an Islamic date you will remember, such as 1 Ramadan or 1 Muharram, and keep to it every year from now on.</li>
<li><strong>Write it down and set reminders.</strong> The <a href="/zakat-date-calculator/">zakat date calculator</a> saves your start date in your browser and creates a calendar file with your next five dates.</li>
</ol>
<p>If forgetting the date also means you missed paying for some years, those years are still owed. Our guide on <a href="/missed-zakat-past-years/">paying missed zakat for past years</a> explains how to estimate each year and catch up.</p>
<h2>Where there is no hawl, or a different year</h2>
<ul>
<li><strong>Crops (ushr):</strong> no year is needed. Ushr is due at harvest, based on "give its due on the day of its harvest" (Surah al-An'am 6:141). A farmer who harvests wheat twice a year pays ushr on each harvest. See <a href="/ushr-on-crops/">ushr on crops</a>.</li>
<li><strong>Grazing livestock:</strong> hawl does apply; animals must be owned for a full lunar year.</li>
<li><strong>Khums (Fiqh-e-Jafaria):</strong> khums on annual surplus has its own "khums year", counted from when you first started earning. You fix a yearly date and pay one fifth of what is left unspent on that date. Many people use a solar date for this; the reminder in our <a href="/khums-calculator/">khums calculator</a> repeats on the same Gregorian date each year. In Ja'fari fiqh zakat itself applies only to specific items, with its own year rules.</li>
</ul>
<h2>Common mistakes</h2>
<ul>
<li><strong>Using the same Gregorian date every year.</strong> After ten years you would be about 110 days late.</li>
<li><strong>Thinking each deposit needs a year</strong> when you follow the Hanafi madhab. It joins your one date.</li>
<li><strong>Assuming a bad month cancels zakat</strong> in the Hanafi madhab. It does not, unless your wealth reached zero.</li>
<li><strong>Waiting for Ramadan</strong> when your date has already passed.</li>
<li><strong>Treating the bank's 1 Ramadan deduction as your full zakat.</strong> It covers one account only.</li>
</ul>
<h2>What to do now</h2>
<ol>
<li>Work out, or estimate, the Islamic date your wealth first reached the nisab.</li>
<li>Enter it in the <a href="/zakat-date-calculator/">zakat date calculator</a> and save the calendar reminders.</li>
<li>Decide which madhab's rules you follow for dips and new money, and stay consistent.</li>
<li>On your date, add up everything and calculate the amount. If some years were missed, start a catch-up plan.</li>
</ol>
<p>Where your situation is unusual, such as a business with irregular income or wealth that was lost and regained several times, please ask a scholar you trust.</p>
[myzt_faq]
HTML
			. $author . '[myzt_related slugs="zakat-date-calculator,missed-zakat-past-years,nisab,bank-zakat-deduction-pakistan"]',
			'faq'     => array(
				array( 'q' => 'Is my zakat date the same every year?', 'a' => 'The Islamic date stays the same. The Gregorian date moves about 11 days earlier each year because the lunar year is shorter.' ),
				array( 'q' => 'Kya har mahine ki tankhwah par alag saal guzarna zaroori hai?', 'a' => 'Hanafi fiqh mein nahi. Saal ke dauran aane wali raqam pehle wale nisab ke saath mil jati hai aur aapki zakat ki tareekh par sab ka hisaab hota hai. Shafi\'i aur Hanbali fiqh mein nayi raqam ka apna saal hota hai, magar sab par ek saath advance ada karna jaiz hai.' ),
				array( 'q' => 'Agar saal ke beech mein paise nisab se kam ho jayein to kya hoga?', 'a' => 'Hanafi fiqh mein agar saal ke shuru aur aakhir mein nisab poora ho to beech ki kami se farq nahi parta, jab tak maal bilkul khatam na ho jaye. Shafi\'i aur Hanbali fiqh mein saal toot jata hai aur naya saal shuru hota hai.' ),
				array( 'q' => 'Can I pay next year\'s zakat in advance?', 'a' => 'Yes in the Hanafi, Shafi\'i and Hanbali schools, as long as you already own the nisab. The Shafi\'i school allows one year ahead and the Hanbali up to two; the Maliki school allows only a short time before the due date.' ),
				array( 'q' => 'Can I change my zakat date to Ramadan?', 'a' => 'You cannot delay it to Ramadan, but you can pay early in Ramadan in the schools that allow advance payment, and then settle any balance on your actual date.' ),
				array( 'q' => 'Does the hawl apply to ushr on crops?', 'a' => 'No. Ushr is due at each harvest without waiting a year. The year applies to cash, gold, silver, trade goods and grazing livestock.' ),
			),
		),

		'missed-zakat-past-years' => array(
			'title'   => 'Missed Zakat for Past Years: How to Calculate and Pay Qaza Zakat',
			'seo'     => 'Missed Zakat for Past Years: Qaza Zakat Guide {year}',
			'desc'    => 'Missed zakat for past years stays owed. How to estimate each year\'s wealth, which gold price to use, the Hanafi debt rule, instalments and a worked example.',
			'nav'     => 'Missed zakat',
			'blurb'   => 'qaza zakat',
			'content' => <<<'HTML'
[myzt_answer q="Do I have to pay zakat for past years I missed?"]Yes. Zakat that became due and was not paid stays owed; it does not lapse with time, in any madhab. Repent, estimate your zakatable wealth on each missed zakat date as honestly as you can, work out 2.5% for each year, and start paying now, in instalments if you cannot pay it all at once.[/myzt_answer]
<p>Many people only realise years later that they owned the nisab and never paid: a young professional whose savings crossed the line without them noticing, a wife who did not know her wedding gold was zakatable in the Hanafi madhab, or a family that assumed the bank's 1 Ramadan deduction covered everything. If that is you, do not panic and do not give up. The debt can be cleared, one year at a time.</p>
<p>The <a href="/zakat-date-calculator/">zakat date calculator</a> has a "missed years" section where you enter your wealth for each year you missed and it adds up what you owe. This guide explains the rulings behind it, how to fill it in when your records are gone, and where the schools differ.</p>
<h2>Unpaid zakat does not lapse</h2>
<p>Once zakat becomes due on your zakat date, it is a debt owed to Allah and to the poor. It is not like a prayer time that passes; it stays on you until it is paid. All four Sunni schools agree on this, and so does Ja'fari fiqh. Ten years of delay does not reduce it, and you cannot replace it with general sadaqah given without the intention of zakat.</p>
<p>The four schools also agree that zakat should be paid promptly once it is due, so the delay itself was wrong. That is why the first step is repentance, and the second is paying without further delay.</p>
<p>There is one Hanafi detail worth knowing. If wealth was destroyed after zakat became due through no fault of your own, for example by theft, fire or flood, Hanafi scholars say the zakat on what was lost drops. The Maliki, Shafi'i and Hanbali schools generally hold that the liability stays on you. Spending the money yourself, on a house, a wedding or a business, does not cancel the zakat in any school.</p>
<h2>Start with repentance (tawbah)</h2>
<p>The Quran warns those who hoard gold and silver and do not spend it in Allah's way (Surah at-Tawbah 9:34-35), and the Prophet ﷺ described the punishment of a person who is given wealth and does not pay its zakat (Sahih al-Bukhari 1403). These warnings are serious, but the door of tawbah is open. Sincere repentance means:</p>
<ul>
<li>regretting the delay and asking Allah's forgiveness;</li>
<li>resolving to pay on time from now on, which is easier once you know your zakat date (see <a href="/hawl-zakat-due-date/">hawl and the zakat due date</a>);</li>
<li>actually paying what is owed. Repentance from an unpaid debt is completed by settling it, not by regret alone.</li>
</ul>
<h2>Which years do you owe for?</h2>
<p>You owe zakat for every lunar year in which you owned zakatable wealth at or above the <a href="/nisab/">nisab</a> on your zakat date and did not pay. To find them:</p>
<ol>
<li><strong>Find your first zakat date.</strong> It is one lunar year after the day your wealth first reached the nisab. If you do not know that day, choose the most reasonable estimate, such as the month you started your first job or received your wedding jewellery, and pick an Islamic date you will remember.</li>
<li><strong>List each zakat date since then.</strong> Each is one lunar year (about 354 days) after the last. The zakat date calculator lists them for you and shows how many lunar years have passed.</li>
<li><strong>Remove years you did pay.</strong> If you paid in full for some years, leave them out. If you paid part, keep the year and subtract what you paid.</li>
<li><strong>Remove years you were below the nisab,</strong> for example if your savings were wiped out by a medical bill.</li>
</ol>
<p>Remember that zakat years are lunar. If ten Gregorian years have passed, that is about ten years and four months in the Islamic calendar, which may add one extra zakat date.</p>
<h2>Estimating wealth when records are lost</h2>
<p>Very few people have a neat balance sheet for each year. Scholars ask for your best reasonable estimate (ghalib al-zann), not certainty. Mufti Muhammad ibn Adam of Darul Iftaa Leicester suggests looking at old bank statements and wage slips, and paying slightly more than the estimate rather than less. That is the approach we recommend: when in doubt, err on the side of paying more.</p>
<h3>Where to look</h3>
<ul>
<li><strong>Bank and mobile wallet statements.</strong> Pakistani banks can usually issue statements for past years, and apps such as Easypaisa and JazzCash keep a history. Note the balance near each zakat date.</li>
<li><strong>Savings certificates and prize bonds.</strong> National Savings records show what you held and when.</li>
<li><strong>Gold.</strong> Most families know roughly how many tola they had and when pieces were bought, sold or given away. Weight matters more than receipts. In the Hanafi madhab worn jewellery counts; see <a href="/zakat-on-jewellery/">zakat on jewellery</a> for the other schools.</li>
<li><strong>Business stock.</strong> Old purchase registers, supplier bills or tax returns give a reasonable idea of stock value each year.</li>
<li><strong>Cash at home, committee (BC) money and loans you gave</strong> that you expected to get back.</li>
</ul>
<h3>Then subtract</h3>
<ul>
<li>Debts that were due at the time, such as an unpaid loan instalment or a supplier bill, in the way your madhab allows.</li>
<li>Any zakat the bank deducted on 1 Ramadan that year. It counts towards that year's zakat; see <a href="/bank-zakat-deduction-pakistan/">bank zakat deduction in Pakistan</a>.</li>
<li>Any amount you paid as zakat for that year.</li>
</ul>
<p>If one year is completely unknown, take the year before and the year after and use a figure at the higher end between them. Write down how you reached each number. It helps you stay honest and makes it easy to adjust later if you find an old statement.</p>
<h2>That year's gold price or today's?</h2>
<p>For cash and bank balances there is no real question: you owed 2.5% of the rupees you had, and that rupee amount is what you pay. The question arises for gold, silver and trade goods whose price has changed since. Gold that was Rs 1,00,000 a tola a few years ago may be far more today. Scholars differ here, including within the Hanafi school.</p>
<h3>The value on each year's zakat date</h3>
<p>Many Hanafi scholars say you value the gold at its price on that year's zakat date, because that is when the obligation fell on you. SeekersGuidance gives it as the answer for paying past years, citing Ibn 'Abidin's <em>Radd al-Muhtar</em>. Under this method you work out each year in rupees at that year's rate, and the rupee total is your debt.</p>
<h3>The value on the day you pay</h3>
<p>Another view, also found in Hanafi books, is that the zakat on gold is a share of the gold itself (one-fortieth of it). On this view you can work out how much gold you owed for each year, in grams or tola, and then either give that gold or pay its value on the day you pay. When gold prices have risen, this means paying more.</p>
<p>Both methods are recognised. If you follow a particular mufti or darul ifta, use their method. If you have no guidance and gold has risen, using today's price is the more cautious choice. The missed-years section of the <a href="/zakat-date-calculator/">zakat date calculator</a> works in money, so enter each year's wealth already converted at the price you have chosen.</p>
<h3>Which nisab for old years?</h3>
<p>The nisab was lower in rupees in earlier years, especially the silver nisab. The calculator fills in today's silver nisab (currently [myzt_rate type="nisab-silver" currency="PKR"]) and lets you edit it. If a year's wealth was close to the line, change the figure to that year's nisab; otherwise a year when you really owed zakat might show as zero. For gold-only wealth, Hanafi scholars apply the gold nisab of 7.5 tola, which today is [myzt_rate type="nisab-gold" currency="PKR"].</p>
<h2>Does last year's unpaid zakat reduce this year's?</h2>
<p>This point can make a real difference over several years, and the schools approach it differently.</p>
<h3>The Hanafi view</h3>
<p>In Hanafi fiqh, a debt that is owed and being claimed reduces your zakatable wealth, and unpaid zakat counts as such a debt. So the zakat you owed for year one is subtracted from your wealth in year two before working out year two's zakat, and so on. The classical example in <em>al-Hidaya</em> is someone who owns exactly 200 dirhams for two years without paying: they owe 5 dirhams for the first year and nothing for the second, because after the first year's 5 dirhams, only 195 remain, which is below the nisab.</p>
<p>The tick box "Count earlier unpaid zakat as a debt (Hanafi)" in the calculator does exactly this. It is ticked by default. Each year it subtracts all the zakat still owed from earlier years, then checks the nisab and takes 2.5% of what is left.</p>
<p>Not every contemporary Hanafi mufti applies this when calculating past years. Some, such as the South African Hanafi fatwa site Muftionline, advise working out each year in full and paying it separately. Untick the box if your mufti tells you to do that. It produces a slightly larger total, so it is also the cautious option.</p>
<h3>The other schools</h3>
<p>The other schools handle debts and zakat differently, and the details are technical, so we state them carefully:</p>
<ul>
<li><strong>Shafi'i:</strong> in the relied-upon view of the school, debts do not reduce zakat (Dar al-Ifta of Jordan states this). Many Shafi'i scholars therefore expect full zakat for each year, although some discuss special cases where the poor's share already taken out of the wealth lowers later years.</li>
<li><strong>Maliki and Hanbali:</strong> debts can reduce zakat on cash and gold, and some scholars of these schools apply this to earlier unpaid zakat too.</li>
<li><strong>Ahl-e-Hadith and Ja'fari:</strong> follow what your own scholars teach; ask them before ticking the box.</li>
</ul>
<p>If you do not follow the Hanafi madhab, the simplest and safest course is to untick the box and pay 2.5% on each year's full wealth, unless your scholar tells you otherwise.</p>
<h2>A worked example: three missed years</h2>
<p>Hamza, from Lahore, follows the Hanafi madhab. His zakat date is 1 Ramadan. He realises he did not pay on 1 Ramadan 1445, 1446 or 1447 (March 2024, March 2025 and February 2026). Using bank statements and the gold his family remembers, he estimates his zakatable wealth (cash, savings and gold, minus debts due) on each date. These are example figures, well above the nisab in every year.</p>
<figure class="wp-block-table"><table>
<thead><tr><th>Zakat date</th><th>Estimated wealth</th><th>Box ticked: base after earlier zakat</th><th>Zakat (ticked)</th><th>Zakat (unticked)</th></tr></thead>
<tbody>
<tr><td>1 Ramadan 1445</td><td>Rs 10,00,000</td><td>Rs 10,00,000</td><td>Rs 25,000</td><td>Rs 25,000</td></tr>
<tr><td>1 Ramadan 1446</td><td>Rs 12,00,000</td><td>Rs 11,75,000</td><td>Rs 29,375</td><td>Rs 30,000</td></tr>
<tr><td>1 Ramadan 1447</td><td>Rs 15,00,000</td><td>Rs 14,45,625</td><td>Rs 36,141</td><td>Rs 37,500</td></tr>
<tr><td><strong>Total</strong></td><td></td><td></td><td><strong>Rs 90,516</strong></td><td><strong>Rs 92,500</strong></td></tr>
</tbody>
</table></figure>
<p>With the box ticked, year two's base is Rs 12,00,000 minus the Rs 25,000 still owed for year one. Year three's base is Rs 15,00,000 minus Rs 54,375 (the first two years together). With the box unticked each year stands alone. The difference here is about Rs 2,000; it grows with more years and larger amounts.</p>
<p>If the bank had deducted Rs 15,000 from Hamza's savings account on 1 Ramadan 1446, he would subtract it, and that year would leave Rs 14,375 to pay with the box ticked.</p>
<h3>When the debt rule wipes out a year</h3>
<p>The Hanafi rule matters most near the nisab. Suppose (example figures) the nisab was Rs 1,48,000 and Bilal held Rs 1,50,000 on two zakat dates in a row. Year one: Rs 3,750. Year two: Rs 1,50,000 minus Rs 3,750 leaves Rs 1,46,250, which is below the nisab, so nothing is due for year two. Unticked, he would owe Rs 3,750 for each year.</p>
<h2>Paying it off: instalments are fine</h2>
<p>Ideally you pay the whole amount at once. If you cannot, pay what you can now and set a plan for the rest. Scholars allow this for someone who genuinely cannot pay in one go; what is not allowed is putting it off with no plan.</p>
<ul>
<li><strong>Start now.</strong> You do not have to finish calculating every year to begin. Pay the year you are surest about today.</li>
<li><strong>Pay the oldest year first,</strong> so your records stay clear.</li>
<li><strong>Make the intention</strong> each time: "this is zakat for my missed years". Money already given as general sadaqah cannot be turned into zakat afterwards.</li>
<li><strong>Do not neglect the current year.</strong> This year's zakat is due on its own date as well.</li>
<li><strong>Write it in your will.</strong> Note what is still owed in case you die before finishing.</li>
<li><strong>Give to eligible people.</strong> Missed zakat goes to the same eight categories as any zakat; see <a href="/who-can-receive-zakat/">who can receive zakat</a>. A poor brother, sister or other eligible relative is a good choice.</li>
</ul>
<h2>Zakat owed by someone who has died</h2>
<p>Families often discover after a death that a parent had not paid zakat for some years. The schools differ clearly here.</p>
<ul>
<li><strong>Hanafi:</strong> zakat is an act of worship that needs the person's own intention, so it is paid from the estate only if they left a will (wasiyyat) for it, and then from no more than one third of the estate after funeral costs and debts to people. Without a will, the heirs are not obliged to pay. An adult heir may still pay it from their own share voluntarily, and we hope Allah accepts it.</li>
<li><strong>Shafi'i and Hanbali:</strong> unpaid zakat is a debt owed to Allah and is paid from the estate before inheritance is divided and before bequests, whether or not the person left a will. They point to the hadith "the debt of Allah is more deserving to be paid" (Sahih al-Bukhari 1953, Sahih Muslim 1148).</li>
<li><strong>Maliki and Ja'fari:</strong> have their own detailed rules; ask a scholar before dividing the estate.</li>
</ul>
<p>Because this affects every heir's share, get a ruling from a mufti before the property is distributed.</p>
<h2>Common mistakes</h2>
<ul>
<li><strong>Thinking old zakat expires.</strong> It does not, however many years pass.</li>
<li><strong>Waiting for perfect records.</strong> A careful estimate, rounded up, is enough. Delay while searching for papers is the bigger problem.</li>
<li><strong>Using today's wealth for every year.</strong> Each year has its own figure. If your wealth grew, today's balance overstates the early years; if it shrank, it understates them.</li>
<li><strong>Forgetting the bank deduction</strong> on 1 Ramadan, or counting it twice.</li>
<li><strong>Using today's nisab for an old year near the line</strong> and wrongly getting zero.</li>
<li><strong>Ticking the Hanafi box without being Hanafi,</strong> or mixing gold values from different methods in the same calculation.</li>
<li><strong>Counting past sadaqah as zakat</strong> when there was no zakat intention at the time.</li>
</ul>
<h2>What to do now</h2>
<ol>
<li>Make tawbah and decide to settle the debt.</li>
<li>Open the <a href="/zakat-date-calculator/">zakat date calculator</a>, enter your first zakat date and the number of missed years.</li>
<li>Enter your estimated wealth for each year, oldest first, with the gold valued by the method you have chosen. Adjust the nisab if a year was close to it.</li>
<li>Tick or untick the Hanafi debt box according to your madhab or mufti.</li>
<li>Round the total up, subtract anything already paid, and pay what you can this week.</li>
<li>Write the remaining balance in your will and pay it off in instalments.</li>
</ol>
<p>If something in your situation is unusual, such as a large loss, a disputed inheritance or a business partnership, please ask your scholar.</p>
[myzt_faq]
HTML
			. $author . '[myzt_related slugs="zakat-date-calculator,hawl-zakat-due-date,nisab,zakat-on-gold-calculator"]',
			'faq'     => array(
				array( 'q' => 'Is there a time limit after which missed zakat no longer has to be paid?', 'a' => 'No. Unpaid zakat stays owed whether it was missed one year ago or twenty. Estimate each year and pay, starting now.' ),
				array( 'q' => 'Pichle saalon ki zakat kaise ada karein?', 'a' => 'Har saal ki zakat ki tareekh par apna andaazan maal likhein, har saal ka 2.5% nikaalein, aur jitna ho sake abhi ada karein. Baqi qiston mein de sakte hain.' ),
				array( 'q' => 'Can I pay missed zakat in monthly instalments?', 'a' => 'Yes, if you cannot pay it all at once. Make a firm plan, make the zakat intention with each payment, and write the remaining balance in your will.' ),
				array( 'q' => 'Kya purani zakat par aaj ka sone ka rate lagega?', 'a' => 'Ulama ka ikhtilaf hai. Kai Hanafi ulama har saal ki zakat ki tareekh ka rate lagate hain; aik qaul ke mutabiq ada ke din ki qeemat bhi di ja sakti hai. Agar rate barh gaya ho to aaj ka rate ehtiyat hai.' ),
				array( 'q' => 'My father died without paying zakat. Do we have to pay it?', 'a' => 'In the Hanafi madhab only if he left a will for it, from up to one third of the estate. In the Shafi\'i and Hanbali schools it is paid from the estate before inheritance. Ask a mufti before dividing the estate.' ),
				array( 'q' => 'I do not remember how much gold I had. What should I do?', 'a' => 'Use your best honest estimate of the weight in tola for each year, ask family members who remember, and round up when unsure.' ),
			),
		),

		'roza-fidya' => array(
			'title'   => 'Roza Fidya: How Much to Pay for Missed Fasts and Who Pays It',
			'seo'     => 'Roza Fidya {year}: Fidya for Missed Fasts in Rupees',
			'desc'    => 'Who may pay fidya instead of fasting, how much it is in the Hanafi and other schools, how to turn it into rupees, and worked examples for 10, 30 and 60 fasts.',
			'nav'     => 'Roza fidya guide',
			'blurb'   => 'roza fidya',
			'content' => <<<'HTML'
[myzt_answer q="How much is fidya for a missed fast?"]Fidya is paid only by someone who can never make up their fasts, such as a very old or permanently ill person. In the Hanafi madhab it is one fitrana for each fast: half a sa' of wheat (about 2 kg) or its value. The Shafi'i, Maliki and Hanbali schools set it at one mudd of staple food, about 0.6 kg.[/myzt_answer]
<p>Every Ramadan families ask the same question about an elderly parent or a relative with a long illness: they cannot fast, so what do they owe? The answer is fidya, a small payment of food or its value for each fast, given to the poor. It is simple to work out, but it is often paid by the wrong people or at the wrong rate. This guide explains who may pay it, how much it is in each school, how to turn it into rupees, and the mistakes to avoid. To skip straight to the numbers, use the <a href="/fidya-kaffara-calculator/">fidya and kaffara calculator</a>.</p>
<h2>What fidya is</h2>
<p>Fidya means a ransom or compensation. In fasting it is the food (or its value) given to a poor person in place of a fast that a person cannot keep and will never be able to make up. The basis is the Quran:</p>
<blockquote><p>"...And for those who can fast only with great difficulty, a ransom: feeding a poor person. Whoever does more good voluntarily, it is better for him. And fasting is better for you, if only you knew." (Surah al-Baqarah 2:184)</p></blockquote>
<p>Ibn Abbas explained that this verse remains in force for the very old man and woman who cannot fast: they feed one poor person for each day (Sahih al-Bukhari, Book of Tafsir, on 2:184). The verse before it, and 2:185, also make clear that a sick person or a traveller makes up the days later. That is the whole structure of the law in two lines: a temporary excuse means you fast later (qada); a permanent one means you pay fidya.</p>
<p>Fidya is different from kaffara. Kaffara is the heavier penalty for breaking a Ramadan fast on purpose without an excuse, and it is covered in our guide to <a href="/kaffara-for-breaking-a-fast/">kaffara for breaking a fast</a>. Fidya is not a punishment at all. It is a mercy for people who genuinely cannot fast.</p>
<h2>Who may pay fidya instead of fasting</h2>
<p>All four Sunni schools agree that fidya is for a person who cannot fast now and has no realistic hope of being able to fast later. In practice this means:</p>
<ul>
<li><strong>Old age (shaikh fani):</strong> an elderly man or woman for whom fasting causes real harm or unbearable hardship, and whose strength will not return.</li>
<li><strong>A chronic illness with no hope of recovery:</strong> for example advanced kidney disease needing frequent fluids, some types of diabetes where a doctor says fasting is dangerous, or a long-term condition requiring medicine through the day. The judgement should come from a trustworthy Muslim doctor, or at least an honest doctor who understands what a fast involves.</li>
</ul>
<p>Such a person does not fast, pays one fidya for each day of Ramadan they miss, and carries no sin. If the person can fast some days, for instance in the short days of winter qada, they should fast those days and pay fidya only for the rest.</p>
<p>One school differs on whether it is obligatory. In the Maliki school, an elderly person who cannot fast is not required to pay fidya, though giving it is recommended. The Hanafi, Shafi'i and Hanbali schools make it obligatory if the person can afford it.</p>
<h2>Who may not pay fidya instead of fasting</h2>
<p>This is where most mistakes happen. The following people have a valid reason not to fast, but their reason is temporary, so they must make up the fasts after Ramadan. Paying money does not replace their fasts.</p>
<ul>
<li><strong>A traveller (musafir):</strong> may leave the fast on a journey and makes it up later.</li>
<li><strong>A temporary illness:</strong> fever, an operation, a broken bone, a course of antibiotics. Once well, the person makes up the days.</li>
<li><strong>Menstruation and post-natal bleeding:</strong> the days are made up later, with no fidya.</li>
<li><strong>Pregnancy and breastfeeding:</strong> the woman may leave the fast if she fears harm to herself or her baby. What she owes afterwards depends on the school, below.</li>
</ul>
<h3>Pregnant and breastfeeding women: the school views</h3>
<ul>
<li><strong>Hanafi:</strong> she makes up the fasts (qada) only, with no fidya, whether she feared for herself, for the child, or both. This is the position of al-Hidaya and the later Hanafi texts, and it is what most muftis in Pakistan follow.</li>
<li><strong>Shafi'i:</strong> if she feared for herself, or for herself and the child, qada only. If she feared <em>only for the child</em>, she makes up the fasts and also pays one mudd of fidya for each day.</li>
<li><strong>Hanbali:</strong> the same division as the Shafi'i school: qada only when she fears for herself; qada plus one mudd for each day when she fears only for the child.</li>
<li><strong>Maliki:</strong> a pregnant woman makes up the fasts only; a breastfeeding woman who fears for her child makes them up and also pays fidya.</li>
</ul>
<p>So no school lets a healthy pregnant or nursing mother simply pay instead of fasting later. The question is only whether a fidya is added on top of the qada. If years of back-to-back pregnancies have left a woman with many fasts to make up, she still makes them up gradually; she does not convert them to money.</p>
<h3>Delaying qada past the next Ramadan</h3>
<p>Someone who could have made up last year's fasts but let the next Ramadan arrive without doing so has a further question. In the Shafi'i, Maliki and Hanbali schools they make up the fasts and also pay one mudd for each day delayed. In the Hanafi school they make up the fasts only, with no fidya for the delay, though they should repent for the delay if it had no excuse.</p>
<h2>How much fidya is for one fast</h2>
<h3>Hanafi</h3>
<p>The fidya for one fast equals one sadaqat al-fitr (fitrana). You may give any one of these, or its value in money:</p>
<ul>
<li>half a sa' of wheat or wheat flour, about 2 kg (scholars give figures between 1.75 kg and 2 kg depending on how they convert the sa');</li>
<li>one sa' of barley, about 4 kg;</li>
<li>one sa' of dates, about 4 kg;</li>
<li>one sa' of raisins, about 4 kg.</li>
</ul>
<p>Paying the value in money is allowed and is what nearly everyone does in Pakistan. Wheat gives the minimum. Scholars encourage those who can afford it to pay by dates or raisins, which come to several times more, because the reward follows what reaches the poor.</p>
<h3>Shafi'i, Maliki and Hanbali</h3>
<p>The fidya is one mudd of the main staple food of the place for each day, about 0.6 kg. In Pakistan the staple is wheat flour or rice; in the Gulf and Malaysia it is usually rice. Scholars of these schools generally prefer giving the food itself, although many contemporary bodies accept the value. One mudd is roughly a quarter of a sa', so the amount is much smaller than the Hanafi one.</p>
<h3>Shia (Ja'fari)</h3>
<p>For readers who follow Ayatollah Sistani, his rulings set the fidya at one mudd, about 750 grams, of food such as wheat, barley or bread for each day. The details on who pays it are in his <em>Islamic Laws</em> on sistani.org.</p>
<h2>How to work out fidya in rupees</h2>
<p>Do not rely on a figure from a forwarded message or last year's poster. The amount changes with flour prices, and each city's prices differ. Here is the method:</p>
<ol>
<li><strong>Find this year's announced amount.</strong> Each Ramadan the Council of Islamic Ideology, the major madrasas and local mosque committees announce fitrana amounts for wheat, barley, dates and raisins. The Hanafi fidya for one fast is the same as one fitrana, so use that figure.</li>
<li><strong>Choose the item.</strong> Wheat is the minimum; dates or raisins are better if you can afford them.</li>
<li><strong>Count the fasts.</strong> Count only the fasts the person truly cannot make up. A full Ramadan is 29 or 30 days.</li>
<li><strong>Multiply.</strong> Number of fasts times the amount for one fast. That is the whole sum.</li>
</ol>
<p>For example, <em>if</em> the announced wheat amount in your city is Rs X per person, then 30 fasts come to 30 times X. As a purely hypothetical illustration, if X were Rs 300, the fidya for 30 fasts would be Rs 9,000. That Rs 300 is not an official rate; replace it with the amount announced this year. If no amount has been announced where you live, use the local price of 2 kg of flour. For the Shafi'i, Maliki and Hanbali amount, use the price of about 0.6 kg of your staple food instead.</p>
<p>The <a href="/fidya-kaffara-calculator/">fidya calculator</a> does this multiplication for you: enter the number of fasts and the amount for one fast. The <a href="/fitrana-calculator/">fitrana calculator</a> uses the same per-person amounts, which helps if you are paying fitrana and fidya together before Eid.</p>
<h2>Worked examples: 10, 30 and 60 fasts</h2>
<p>The table uses hypothetical amounts for one fast, chosen only to show the arithmetic. They are not announced rates. Put this year's figures in their place.</p>
<figure class="wp-block-table"><table>
<thead><tr><th>Fasts</th><th>Hanafi, wheat (example Rs 300 each)</th><th>Hanafi, dates (example Rs 1,500 each)</th><th>Other schools, 1 mudd (example Rs 90 each)</th></tr></thead>
<tbody>
<tr><td>10</td><td>Rs 3,000</td><td>Rs 15,000</td><td>Rs 900</td></tr>
<tr><td>30 (one Ramadan)</td><td>Rs 9,000</td><td>Rs 45,000</td><td>Rs 2,700</td></tr>
<tr><td>60 (two Ramadans)</td><td>Rs 18,000</td><td>Rs 90,000</td><td>Rs 5,400</td></tr>
</tbody>
</table></figure>
<h3>Example 1: an elderly father</h3>
<p>Haji Rasheed is 84 and his doctor has told him not to fast because of heart failure. He follows the Hanafi school. He pays one fidya for each of the 30 days. If his family uses the wheat amount, the total is 30 times the announced wheat figure. His son, who can afford more, chooses to pay by the dates rate on his father's behalf, with his father's permission.</p>
<h3>Example 2: a mother who also missed fasts for pregnancy</h3>
<p>Samina missed 12 fasts last Ramadan while pregnant, feared only for the baby, and follows the Shafi'i school. She must make up all 12 fasts after the birth and also pay 12 mudds of fidya. Had she been Hanafi, she would make up the 12 fasts with nothing to pay.</p>
<h3>Example 3: a mix of days</h3>
<p>Nasreen has a long-term kidney condition and cannot fast in summer, but her doctor allows short winter fasts. She missed 30 days. She makes up as many as she can in winter, say 10, and pays fidya only for the 20 she has no prospect of making up. If her health later allows the rest, she fasts those too.</p>
<h2>When to pay, and to whom</h2>
<h3>In advance or after Ramadan</h3>
<ul>
<li><strong>Hanafi:</strong> the fidya may be paid at the start of Ramadan for the whole month, or day by day, or all together at the end or after Ramadan. Paying before Ramadan begins is not valid in advance for that Ramadan.</li>
<li><strong>Shafi'i:</strong> fidya may be given for each day on that day (including from the night before) or afterwards, but not for future days in advance. Paying for the whole month on the first night is therefore not valid for the later days.</li>
<li><strong>Hanbali and Maliki:</strong> scholars generally allow paying on each day or after; if you want to pay for the whole month at once, ask your scholar first.</li>
</ul>
<p>Whatever the school, paying promptly is better than letting it slide. Poor families need food in Ramadan, and an elderly person's health may not leave time for later.</p>
<h3>One poor person or several</h3>
<p>In the Hanafi school the fidya for many fasts may all be given to one poor person, and most Hanafi scholars also allow one fast's fidya to be split among several. The Shafi'i school allows several mudds to go to one person, but one mudd should not be divided between two. Either way, the recipient must be someone eligible for zakat: poor or needy, not your own parents, grandparents, children, grandchildren or spouse, and in the Sunni schools not a Sayyid. Our guide on <a href="/who-can-receive-zakat/">who can receive zakat</a> sets out the full list; fidya goes to the same poor and needy people.</p>
<p>As with zakat, the fidya should become the property of the poor person. Using it to build a mosque or pay a madrasa's electricity bill does not fulfil it. A charity that distributes food or cash to needy families directly is fine.</p>
<h2>Fidya for a deceased person</h2>
<p>If someone dies with missed fasts, what is owed depends on whether they had a chance to make them up.</p>
<ul>
<li><strong>No chance to make them up:</strong> if they were ill or travelling until death and never recovered, nothing is due, in any school.</li>
<li><strong>Could have made them up but did not (Hanafi):</strong> if they left a will (wasiyyat) asking for fidya, the heirs must pay it from up to one third of the estate. If there was no will, the heirs are not obliged, but adult heirs may pay it from their own money or their share, and we hope Allah accepts it. In the Hanafi view no one can fast on behalf of a dead person.</li>
<li><strong>Shafi'i:</strong> the fidya of one mudd per day is paid from the estate before inheritance is divided, whether or not there is a will. Following the hadith "Whoever dies owing fasts, his guardian fasts on his behalf" (Sahih al-Bukhari 1952, Sahih Muslim 1147), many Shafi'i scholars also allow a close relative to fast for the deceased instead.</li>
<li><strong>Hanbali:</strong> for missed Ramadan fasts, fidya is paid from the estate; the relative fasting on their behalf applies to vowed (nadhr) fasts.</li>
</ul>
<p>Fidya for the dead uses the same rate and recipients as fidya for the living. Settle debts owed to people first, then the will.</p>
<h2>What if the person recovers?</h2>
<p>Fidya stands in for a fast only while there is no hope of fasting. If someone paid fidya believing their illness was permanent and later recovers enough to fast, the Hanafi ruling is clear: they must make up those fasts, and the fidya they paid counts as voluntary charity, with its reward. This applies to a person whose illness was misjudged as permanent, which happens more often than people expect after a successful operation or a change of medicine. The other schools discuss this case in more detail, especially for the very elderly; if it applies to you, ask a scholar of your school.</p>
<h2>Common mistakes</h2>
<ul>
<li><strong>Paying fidya for a temporary excuse.</strong> A traveller, a student with exams, someone with a short illness or a pregnant woman must make up the fasts. Money does not replace them.</li>
<li><strong>Confusing fidya with kaffara.</strong> Fidya is one amount per fast for someone who cannot fast. Kaffara is for breaking a fast deliberately and is 60 days of fasting (or feeding 60 poor people if that is impossible). See <a href="/kaffara-for-breaking-a-fast/">kaffara for breaking a fast</a>.</li>
<li><strong>Using an old rate.</strong> Last year's figure is usually too low. Check this year's announcement.</li>
<li><strong>Giving it to family you already support.</strong> Fidya cannot go to your parents, children or spouse.</li>
<li><strong>Mixing schools to pay the least.</strong> Following the Hanafi rule on pregnancy (no fidya) but the Shafi'i amount (one mudd) for an elderly parent is picking and choosing. Follow one school's package.</li>
<li><strong>Not counting accurately.</strong> Write down the number of fasts missed and why, so you know which are qada and which are fidya.</li>
<li><strong>Paying for the whole month on the first night in a school that does not allow it.</strong> Hanafis may; Shafi'is should pay day by day or after.</li>
</ul>
<h2>What to do now</h2>
<ol>
<li>Decide whether the excuse is permanent (fidya) or temporary (qada). If unsure, ask a doctor about the illness and a scholar about the ruling.</li>
<li>Count the fasts in each category.</li>
<li>Note this year's announced fitrana amount for wheat, dates or the item you choose.</li>
<li>Work out the total in the <a href="/fidya-kaffara-calculator/">fidya and kaffara calculator</a>.</li>
<li>Give it to eligible poor people, directly or through a trustworthy charity, with the intention of fidya.</li>
</ol>
[myzt_faq]
HTML
			. $author . '[myzt_related slugs="fidya-kaffara-calculator,kaffara-for-breaking-a-fast,fitrana-calculator,who-can-receive-zakat"]',
			'faq'     => array(
				array( 'q' => 'Roze ka fidya kitna hai?', 'a' => 'Hanafi fiqh mein har roze ka fidya aik fitrane ke barabar hai, yani aadha sa\' gandum (taqreeban 2 kg) ya uski qeemat. Shafi\'i, Maliki aur Hanbali ke nazdeek aik mudd (taqreeban 0.6 kg) ghiza hai. Raqam har saal ke elaan karda fitrane se lein.' ),
				array( 'q' => 'Kya hamila ya doodh pilane wali aurat fidya de sakti hai?', 'a' => 'Hanafi fiqh mein nahi; woh baad mein qaza roze rakhe gi. Shafi\'i aur Hanbali ke nazdeek agar sirf bachay ka khauf tha to qaza ke saath fidya bhi hai.' ),
				array( 'q' => 'Can I pay fidya for all 30 fasts at the start of Ramadan?', 'a' => 'In the Hanafi school, yes. In the Shafi\'i school, no: pay for each day on that day or afterwards.' ),
				array( 'q' => 'Is fidya the same as kaffara?', 'a' => 'No. Fidya is a small amount per fast for someone who can never fast. Kaffara is the penalty for breaking a Ramadan fast on purpose.' ),
				array( 'q' => 'Can fidya be paid for my late mother?', 'a' => 'Yes. If she left a will for it, Hanafi heirs pay it from up to a third of her estate; without a will, adult heirs may pay it from their own money.' ),
				array( 'q' => 'My father paid fidya, then got better. What now?', 'a' => 'In the Hanafi school he makes up the fasts once he can, and the fidya already paid counts as voluntary charity.' ),
			),
		),

		'kaffara-for-breaking-a-fast' => array(
			'title'   => 'Kaffara for Breaking a Fast: Roza Todne ka Kaffara Explained',
			'seo'     => 'Roza Todne ka Kaffara: 60 Fasts or Feed 60 (in Rupees)',
			'desc'    => 'Kaffara for breaking a Ramadan fast on purpose: 60 fasts in a row or feeding 60 poor people, what each madhab counts, and how to work it out in rupees.',
			'nav'     => 'Kaffara for a broken fast',
			'blurb'   => 'roza ka kaffara',
			'content' => <<<'HTML'
[myzt_answer q="What is the kaffara for breaking a fast?"]A Ramadan fast broken on purpose without a valid excuse needs kaffara: fast 60 days in a row. Only someone who truly cannot fast that long may instead feed 60 poor people, two meals each or one fitrana amount each. One qada fast is also owed for the day broken. Which acts need kaffara differs by madhab.[/myzt_answer]
<p>Kaffara (expiation) is one of the heaviest penalties in the fiqh of fasting, and it is also one of the most misunderstood. Many people think they can simply pay a sum of money, while others think every broken fast needs 60 days of fasting. Neither is right. Below is the hadith it comes from, the order you must follow, what each school counts as a kaffara-level breach, and how to work out the amount in rupees. If you already know your situation, the <a href="/fidya-kaffara-calculator/">fidya and kaffara calculator</a> will do the arithmetic for you.</p>
<h2>Where kaffara comes from: the hadith</h2>
<p>The ruling rests on a well-known hadith narrated by Abu Hurayrah and recorded by both Bukhari (1936) and Muslim (1111). A man came to the Prophet ﷺ and said he was ruined, because he had had relations with his wife while fasting in Ramadan. The Prophet ﷺ asked him whether he could free a slave. He said no. He asked whether he could fast two months in a row. He said no. He asked whether he could feed sixty poor people. Again he said no. Then a large basket of dates was brought, and the Prophet ﷺ told him to give it in charity. The man asked whether there was anyone poorer than his own family in Madinah, and the Prophet ﷺ smiled and told him to feed his family with it.</p>
<p>Three things come out of this hadith that all four schools build on: kaffara is a real obligation, it has a fixed set of options, and the options are asked about one after another. The same three-step pattern appears in the Quran for the kaffara of zihar (Surah al-Mujadilah 58:3-4).</p>
<h2>The order: slave, then 60 fasts, then feeding</h2>
<ol>
<li><strong>Free a slave.</strong> This was the first option, but slavery no longer exists in the sense the fiqh describes, so this step does not apply today. Paying an "equivalent" in money does not replace it.</li>
<li><strong>Fast 60 days in a row.</strong> For almost everyone today this is the actual kaffara. A healthy adult who can fast must do this; they cannot choose to pay instead.</li>
<li><strong>Feed 60 poor people.</strong> This is only for a person who genuinely cannot fast 60 consecutive days, for example because of old age or a lasting illness, or because a doctor says such a long fast would cause real harm. Busy work, heat or finding it hard are not enough.</li>
</ol>
<p>This strict order is the position of the Hanafi, Shafi'i and Hanbali schools. The Maliki school reads the hadith as giving a choice between the options, and Maliki scholars generally say feeding is the preferred one. If you follow the Maliki school, ask your local scholar how they apply this.</p>
<h2>What needs kaffara in each school</h2>
<p>Kaffara is only for a Ramadan fast that was validly begun (with the intention) and then broken deliberately, by an adult who knew it was wrong and had no valid excuse such as illness or travel. Beyond that, the schools differ on which acts count.</p>
<figure class="wp-block-table"><table>
<thead><tr><th>School</th><th>Kaffara is due for</th><th>Eating or drinking on purpose</th><th>Several days in one Ramadan</th></tr></thead>
<tbody>
<tr><td>Hanafi</td><td>Deliberate eating, drinking or intercourse without excuse</td><td>Kaffara + qada</td><td>One kaffara, if none paid yet</td></tr>
<tr><td>Maliki</td><td>Deliberate eating, drinking or intercourse, knowingly violating the fast</td><td>Kaffara + qada</td><td>One kaffara for each day</td></tr>
<tr><td>Shafi'i</td><td>Intercourse only</td><td>Qada + repentance, no kaffara</td><td>One kaffara for each day</td></tr>
<tr><td>Hanbali</td><td>Intercourse only</td><td>Qada + repentance, no kaffara</td><td>One kaffara for each day</td></tr>
</tbody>
</table></figure>
<h3>Hanafi</h3>
<p>The Hanafi school (as set out in <em>al-Hidayah</em> and followed by Pakistani madrasas) holds that deliberately eating, drinking or having intercourse during a Ramadan fast, without any excuse, needs kaffara. The reasoning is that eating and drinking violate the fast in the same way, so they share the same penalty. Things that are not normally eaten as food or medicine, such as swallowing a pebble, break the fast but need qada only.</p>
<h3>Shafi'i and Hanbali</h3>
<p>Both schools limit kaffara to intercourse, because that is what the hadith is about. A person who eats or drinks on purpose has committed a serious sin and must repent and make up the day, but owes no kaffara. In the Shafi'i school only the husband owes the kaffara (the stronger view in the school); in the Hanafi school, and in the Maliki and Hanbali schools as generally stated, a wife who consented owes her own kaffara as well.</p>
<h3>Maliki</h3>
<p>Like the Hanafis, Maliki scholars require kaffara for deliberate eating or drinking as well as intercourse, provided it was done knowingly and in deliberate violation of a Ramadan fast.</p>
<h2>What does not need kaffara</h2>
<p>Most broken or doubtful fasts do not reach the level of kaffara. In these cases either nothing is owed, or only one qada fast:</p>
<ul>
<li><strong>Eating or drinking forgetfully.</strong> The fast is not broken at all. The Prophet ﷺ said whoever forgets and eats or drinks should complete the fast, because Allah fed him (Bukhari 1933, Muslim 1155). In the Maliki school such a fast is made up, but there is still no kaffara.</li>
<li><strong>Vomiting without meaning to.</strong> Nothing is owed. Making yourself vomit a mouthful breaks the fast and needs qada only (Abu Dawud 2380, Tirmidhi 720).</li>
<li><strong>A mistake about the time.</strong> Eating after sehri had ended because you thought there was still time, or opening the fast before sunset because you thought the sun had set, needs one qada fast and no kaffara, since it was not a deliberate breach.</li>
<li><strong>Water going down the throat during wudu</strong> or while rinsing the mouth: qada only in the Hanafi view.</li>
<li><strong>Being forced</strong> to break the fast: qada only.</li>
<li><strong>Breaking the fast for a valid reason</strong> such as illness, travel, pregnancy or breastfeeding when there is a real fear of harm: qada only. If the person cannot ever make it up, see <a href="/roza-fidya/">roza fidya</a> instead.</li>
<li><strong>Breaking a qada, nafl or vowed fast</strong> outside Ramadan: kaffara is only for Ramadan fasts. A broken qada or nafl fast is simply made up.</li>
<li><strong>Eating more after the fast is already broken.</strong> In the Hanafi view, if someone broke the fast by a mistake (for example, thinking the time for sehri had not ended) and then ate more thinking the fast was gone anyway, it is still qada only.</li>
</ul>
<h2>One kaffara or one for each day?</h2>
<p>Suppose someone deliberately broke three fasts in the same Ramadan and has not yet done any kaffara.</p>
<ul>
<li><strong>Hanafi:</strong> one kaffara covers all three, because kaffaras of the same kind overlap (tadakhul) as long as the first has not been carried out. They still owe three qada fasts. If the person had already completed a kaffara for the first broken fast and then broke another, a new kaffara is due. For fasts broken in different Ramadans, Hanafi scholars differ, and many advise a separate kaffara for each Ramadan, especially where intercourse was involved, so ask your scholar if this is your case.</li>
<li><strong>Shafi'i and Hanbali:</strong> each day broken by intercourse is a separate act needing its own kaffara, so three days means three kaffaras: 180 days of fasting, or 180 poor people fed by someone who cannot fast.</li>
<li><strong>Maliki:</strong> each day likewise needs its own kaffara.</li>
</ul>
<h2>The qada fast as well</h2>
<p>Kaffara does not replace the day that was broken. In addition to the kaffara, the person must keep one qada fast for each broken day. So a Hanafi who broke one fast on purpose and is able to fast will keep 61 fasts in total: 60 for the kaffara, which must be continuous, and one for the qada, which can be kept on any day. Sincere tawbah (repentance) is also required, because kaffara wipes out the penalty, but the sin itself is between the person and Allah.</p>
<h2>How fasting 60 days in a row works</h2>
<ul>
<li><strong>No gaps.</strong> The 60 fasts must be back to back. Missing even one day, whether by choice, illness or travel, breaks the sequence in the Hanafi view, and the person starts again from day one.</li>
<li><strong>Choose your window carefully.</strong> Fasting is not allowed on Eid ul-Fitr, Eid ul-Adha and the three days after it (ayyam at-tashriq), so a 60-day block that runs into those days is broken. Ramadan itself cannot be counted either, because its fasts are owed for Ramadan. In practice, many people in Pakistan start in Shawwal after the first few days, or in the winter months when days are short.</li>
<li><strong>Days or lunar months.</strong> In the Hanafi school, if you start on the first day of an Islamic month, two full lunar months count even if they total 59 days. If you start mid-month, count 60 days.</li>
<li><strong>Women and menstruation.</strong> A woman's monthly period does not break the sequence, because she cannot avoid it and few women have 60 days free of it. She stops on the days of her period and continues straight after, without starting again. Post-natal bleeding (nifas) and illness are treated differently in the Hanafi school and do break the sequence, so if this applies to you, ask your scholar.</li>
<li><strong>Intention.</strong> Make the intention of kaffara for each fast, from the night before (Hanafi), not just a general intention to fast.</li>
</ul>
<h2>Feeding 60 poor people</h2>
<p>If you truly cannot fast 60 days in a row, feeding is the replacement. In the Hanafi school there are two ways to do it:</p>
<ol>
<li><strong>Two full meals for each of 60 poor people,</strong> for example lunch and dinner, or sehri and iftar, to the point that they are satisfied. The same 60 people should eat both meals.</li>
<li><strong>Give each of 60 poor people the amount of one fitrana:</strong> half a sa' of wheat (about 2 kg), or one sa' of barley, dates or raisins, or the money value of that. The <a href="/fitrana-calculator/">fitrana calculator</a> uses the same per-person amount.</li>
</ol>
<p>Two rules about the number of people matter here:</p>
<ul>
<li><strong>One person on 60 different days is allowed.</strong> If you cannot find 60 people, you may give the fitrana amount (or two meals) to one poor person every day for 60 days. Each day counts as one person.</li>
<li><strong>One person all at once on one day is not.</strong> Handing one person 60 fitrana amounts on a single day counts as feeding one person only, in the Hanafi view. You would still owe 59.</li>
</ul>
<p>In the Shafi'i, Maliki and Hanbali schools each person gets one mudd of the local staple food (about 0.6 kg of wheat or rice), which is less than the Hanafi half sa', and these schools generally expect food rather than money. The recipients must be people who are eligible for zakat, though not your own parents, children or spouse; see <a href="/who-can-receive-zakat/">who can receive zakat</a>.</p>
<h2>Kaffara in rupees: a worked example</h2>
<p>The numbers below are <strong>hypothetical</strong>, only to show the method. Use the fitrana amount your scholars announce this Ramadan, or the local price of about 2 kg of wheat flour.</p>
<h3>Example 1: fitrana method</h3>
<p>Imagine the announced fitrana for wheat is Rs 300 per person. One kaffara by feeding is 60 × Rs 300 = <strong>Rs 18,000</strong>. If the person can afford it, paying by the dates or raisins rate (say Rs 1,200 per person in this example) gives 60 × Rs 1,200 = Rs 72,000, which carries more reward but is not required.</p>
<h3>Example 2: meals method</h3>
<p>Suppose a simple meal costs Rs 250. Two meals for 60 people is 60 × 2 × Rs 250 = <strong>Rs 30,000</strong>.</p>
<h3>Example 3: three broken fasts</h3>
<p>Bilal, elderly and diabetic, deliberately broke three fasts in one Ramadan and cannot fast 60 days. Under the Hanafi view he owes one kaffara (Rs 18,000 at the example rate) plus three qada fasts, or three fidya payments if he can never fast again. A Shafi'i in the same position owes nothing beyond qada for eating, but if the three days were broken by intercourse he owes three kaffaras.</p>
<p>The <a href="/fidya-kaffara-calculator/">kaffara calculator</a> multiplies the number of kaffaras by 60 and by the amount per person, so you only need to enter those two figures.</p>
<h2>Contrast: kaffara for a broken oath</h2>
<p>People often confuse fasting kaffara with the kaffara for breaking an oath (qasam). The oath kaffara is much lighter and is set out in Surah al-Ma'idah 5:89: feed ten poor people, or clothe them, or free a slave. Only a person who cannot do any of these fasts three days. In the Hanafi school those three days must be in a row. So "kaffara of 10 people" belongs to oaths, while "kaffara of 60" belongs to a deliberately broken Ramadan fast.</p>
<h2>Common mistakes</h2>
<ul>
<li><strong>Paying money when you can fast.</strong> If you are healthy enough to fast 60 days, feeding is not an option.</li>
<li><strong>Forgetting the qada fast.</strong> The kaffara does not cover the broken day itself.</li>
<li><strong>Giving all 60 shares to one person in one day</strong> and counting it as complete (Hanafi).</li>
<li><strong>Treating forgetful eating or a sehri mistake as kaffara.</strong> These need nothing or qada only.</li>
<li><strong>Restarting after a period.</strong> Menstruation pauses the sequence; it does not reset it.</li>
<li><strong>Planning a 60-day block across Eid.</strong> Eid days cannot be fasted and will break the sequence.</li>
<li><strong>Mixing up fidya and kaffara.</strong> Fidya is for fasts a person can never make up; kaffara is a penalty for a deliberate breach.</li>
</ul>
<h2>What to do now</h2>
<ol>
<li>Work out whether your case is kaffara, qada only or fidya, using your own madhab's rules above.</li>
<li>If kaffara is due and you can fast, pick a 60-day window with no Eid days and begin with the intention of kaffara.</li>
<li>If you genuinely cannot fast, find the current fitrana amount and enter it in the <a href="/fidya-kaffara-calculator/">fidya and kaffara calculator</a>.</li>
<li>Keep the qada fasts too, and make sincere tawbah.</li>
<li>If your case has a complication, such as illness partway through or several Ramadans involved, ask a scholar you trust.</li>
</ol>
[myzt_faq]
HTML
			. $author . '[myzt_related slugs="fidya-kaffara-calculator,roza-fidya,fitrana-calculator,who-can-receive-zakat"]',
			'faq'     => array(
				array( 'q' => 'Roza todne ka kaffara kya hai?', 'a' => 'Lagatar 60 roze rakhna. Jo shakhs waqai itne roze na rakh sake, wo 60 miskeenon ko do waqt khana khilaye ya har aik ko aik fitrane ke barabar de. Toote hue roze ki qaza alag se rakhni hai.' ),
				array( 'q' => 'Kya kaffara paison mein de sakte hain?', 'a' => 'Hanafi fiqh mein sirf us shakhs ke liye jo 60 roze na rakh sake: har miskeen ko fitrane ki qeemat, yani 60 fitrane. Jo roze rakh sakta hai us ke liye paise dena kafi nahi.' ),
				array( 'q' => 'How much is kaffara in rupees?', 'a' => 'Sixty times the fitrana amount announced for the year. For example, at a hypothetical Rs 300 per person, one kaffara is Rs 18,000.' ),
				array( 'q' => 'Does breaking a fast by eating need kaffara?', 'a' => 'In the Hanafi and Maliki schools, yes, if it was deliberate and without excuse. In the Shafi\'i and Hanbali schools, no: qada and repentance only.' ),
				array( 'q' => 'I broke two fasts this Ramadan. Do I owe two kaffaras?', 'a' => 'In the Hanafi view one kaffara is enough if you have not paid one yet, plus two qada fasts. In the Shafi\'i, Maliki and Hanbali views each day needs its own kaffara.' ),
				array( 'q' => 'Can a woman pause her 60 fasts for her period?', 'a' => 'Yes. Menstruation does not break the sequence; she continues after it ends without starting again.' ),
			),
		),

		'ushr-on-crops' => array(
			'title'   => 'Ushr on Crops: How Much on Wheat, Rice, Cotton and Sugarcane?',
			'seo'     => 'Ushr on Crops {year}: Gandum Par Ushr Kitna Hai? (10%, 5%)',
			'desc'    => 'Ushr is 10% of the harvest on rain-fed land and 5% on tube well or paid irrigation. Nisab, crops, costs, tenants and examples in maunds and rupees.',
			'nav'     => 'Ushr on crops',
			'blurb'   => 'fasal ka ushr',
			'content' => <<<'HTML'
[myzt_answer q="How much ushr is due on crops?"]Ushr is 10% of the harvest when the land is watered by rain, rivers or springs (barani), and 5% when it is watered by a tube well, bought canal water or other costly irrigation. It is due at harvest, with no waiting year. Imam Abu Hanifa set no minimum; the other schools start at 5 wasq, about 653 kg.[/myzt_answer]
<p>Ushr is the zakat of the land. A farmer who brings in 100 maund of wheat does not wait a year or compare it with the gold or silver nisab: a share of the crop is owed as soon as it is harvested. It is one of the oldest forms of zakat, and in a farming country like Pakistan it is the one many families actually pay most. You can work out your own figure in the <a href="/ushr-calculator/">ushr calculator</a>, which takes your harvest in maunds or kilograms, your watering method and your madhab. This guide explains the rules behind it: the rate, the minimum, which crops count, costs, tenants, orchards, and several worked examples.</p>

<h2>Where ushr comes from</h2>
<p>The Quran speaks of crops directly. After mentioning gardens, date palms, grain, olives and pomegranates, it says:</p>
<blockquote><p>"Eat of their fruit when they bear fruit, and give its due on the day of its harvest." (Surah al-An'am 6:141)</p></blockquote>
<p>It also says, "O you who believe, spend from the good things you have earned and from what We have brought out of the earth for you" (Surah al-Baqarah 2:267). The Prophet ﷺ then set the rate:</p>
<blockquote><p>"On what is watered by rain or springs, or is naturally irrigated, a tenth; and on what is watered by irrigation, half a tenth." (Sahih al-Bukhari 1483, narrated by Ibn 'Umar)</p></blockquote>
<p>The word ushr means "a tenth", and the 5% rate is called nisf-ushr, "half a tenth". The difference is about effort: land that drinks from the sky costs the farmer nothing to water, while land that needs a pump, a bullock-drawn well or paid water costs real money and labour, so the share owed is halved.</p>

<h2>The rate: 10%, 5%, or in between</h2>
<figure class="wp-block-table"><table><thead><tr><th>How the land is watered</th><th>Rate</th><th>On 100 maund</th></tr></thead><tbody>
<tr><td>Rain (barani), river flooding (sailaba), springs, a free natural stream</td><td>10% (ushr)</td><td>10 maund</td></tr>
<tr><td>Tube well, pump, bought water, canal water you pay a charge for</td><td>5% (nisf-ushr)</td><td>5 maund</td></tr>
<tr><td>Both, roughly equally through the season</td><td>7.5% (three quarters of ushr)</td><td>7.5 maund</td></tr>
</tbody></table></figure>
<h3>Canal water in Pakistan</h3>
<p>Most irrigated land in Punjab and Sindh takes canal water and pays a water rate (abiana) to the government. Many Pakistani scholars treat this as paid irrigation and apply 5%, especially where tube well water is added as well. Others point out that the farmer does not lift the water himself, and lean towards 10% where the canal charge is small. This is a genuine difference among contemporary muftis, so if all your water comes from a canal, ask your scholar which rate they hold.</p>
<h3>Mixed watering: two honest answers</h3>
<p>Many fields get some rain and some tube well water. The classical rule, found in Hanafi books and in Ibn Qudamah's <em>al-Mughni</em> for the Hanbali school, is:</p>
<ul>
<li><strong>Go by the majority.</strong> If most of the season's watering came from rain, pay 10%; if most came from the tube well, pay 5%. In the Hanafi school this is the main rule.</li>
<li><strong>If the two are about equal,</strong> the Shafi'i and Hanbali schools give three quarters of a tenth, which is 7.5%.</li>
</ul>
<p>Our <a href="/ushr-calculator/">calculator</a> offers a "mixed" option at 7.5%. That is the right answer when the watering was roughly half and half. If one source clearly dominated, choose "rain" or "irrigated" instead, following the majority rule. Some scholars prefer to split the rate in exact proportion (for example, two thirds rain and one third tube well), which gives a figure between 5% and 10%; that is also a recognised view.</p>

<h2>Is there a minimum (nisab) for ushr?</h2>
<p>This is the biggest difference between the schools, and it matters for small farmers.</p>
<ul>
<li><strong>Imam Abu Hanifa:</strong> no nisab. Ushr is due on any harvest, small or large, because the verse and the hadith of "a tenth" are general. This is the main Hanafi position, and our calculator uses it when you choose Hanafi.</li>
<li><strong>Imam Abu Yusuf and Imam Muhammad</strong> (his two students), and the <strong>Shafi'i, Maliki and Hanbali</strong> schools: no ushr below 5 wasq, based on the hadith "There is no sadaqah in less than five awsuq" (Sahih Muslim 979). Ahl-e-Hadith scholars follow this view as well.</li>
</ul>
<p>One wasq is 60 sa', so 5 wasq is 300 sa'. Measured in wheat this comes to roughly 653 kg, which is about <strong>16.3 maund</strong> (1 maund = 40 kg). Different scholars give slightly different modern weights because the sa' was a measure of volume, not weight, but 650 kg is the commonly used figure and the one our calculator applies.</p>
<p>In practice: a family with a small plot that produces 10 maund of wheat owes ushr in the Hanafi school (1 maund on rain-fed land) but nothing in the Shafi'i, Maliki or Hanbali view. Above about 16 maund, every Sunni school agrees ushr is due.</p>
<p><strong>Shia Ja'fari fiqh</strong> is narrower again: zakat on crops applies only to wheat, barley, dates and raisins, with its own minimum. Ayatollah Sistani's rulings state that minimum in an older unit that works out somewhat higher than 653 kg, and they treat costs differently from the classical Sunni view, so Shia readers should check his Islamic Laws on sistani.org.</p>

<h2>Which crops does ushr apply to?</h2>
<h3>Hanafi: almost everything the land produces</h3>
<p>Imam Abu Hanifa held that ushr is due on whatever is grown on the land with the aim of benefiting from it: wheat, rice, maize, millet, pulses, cotton, sugarcane, oilseeds, vegetables, melons and fruit. Things that grow on their own and are not normally cultivated for income, such as firewood, wild grass and reeds, are excluded. So in Hanafi fiqh a cotton grower, a sugarcane grower and a vegetable farmer all pay ushr.</p>
<h3>Shafi'i, Maliki and Hanbali: storable staples</h3>
<p>The other schools limit ushr to crops that are staple foods and can be dried and stored: wheat, rice, barley, maize, dates and raisins, with some differences in detail between them (the Hanbali school, for example, uses "measured and stored" as its test, which brings in some pulses and seeds). Cotton, sugarcane, fresh vegetables and most fruit are not subject to ushr in these schools. Their sale proceeds become cash, which is counted in your yearly zakat if you are above the nisab.</p>
<figure class="wp-block-table"><table><thead><tr><th>Crop</th><th>Hanafi</th><th>Shafi'i / Maliki / Hanbali</th></tr></thead><tbody>
<tr><td>Wheat, rice, maize</td><td>Yes</td><td>Yes (from 5 wasq)</td></tr>
<tr><td>Cotton</td><td>Yes</td><td>No</td></tr>
<tr><td>Sugarcane</td><td>Yes</td><td>No</td></tr>
<tr><td>Vegetables, fresh fruit (mangoes, citrus)</td><td>Yes</td><td>No</td></tr>
<tr><td>Dates, raisins</td><td>Yes</td><td>Yes (from 5 wasq)</td></tr>
<tr><td>Fodder grown to feed your own animals</td><td>Disputed; many say yes if grown as a crop</td><td>No</td></tr>
</tbody></table></figure>

<h2>Are costs deducted before ushr?</h2>
<p><strong>The classical view of all four Sunni schools is no.</strong> Ushr is taken from the whole harvest. The cost of watering is already accounted for by the lower 5% rate, and seed, fertiliser, ploughing and labour are not subtracted. This is why the rate is low compared with the size of the crop.</p>
<p><strong>Some contemporary scholars allow deducting costs,</strong> arguing that modern farming spends far more on diesel, fertiliser, pesticide and hired machinery than farming did in the early centuries, and that ushr should fall on the real produce. Some of them allow deducting only debts taken for the crop. These views exist, but they are a minority against the classical position. If you want to deduct costs, ask your scholar first, and be consistent from year to year. Our calculator follows the classical view and works on the full harvest.</p>

<h2>Who pays: owner, tenant, or both?</h2>
<h3>Batai (crop sharing)</h3>
<p>When land is farmed on shares, for example half to the owner and half to the cultivator, each person pays ushr on their own share. If the harvest is 100 maund of wheat on tube well land and it is split 50-50, the owner pays 2.5 maund on his 50 and the tenant pays 2.5 maund on his 50.</p>
<h3>Cash rent (theka or ijara of land)</h3>
<p>If the land is leased for a fixed cash rent, the schools differ:</p>
<ul>
<li><strong>Imam Abu Hanifa:</strong> the owner pays, because ushr is a duty attached to the land.</li>
<li><strong>Imam Abu Yusuf and Imam Muhammad</strong> (the sahibain), along with the Shafi'i, Maliki and Hanbali schools: the tenant pays, because ushr is a duty on the crop and the tenant owns the crop.</li>
</ul>
<p>Many Pakistani muftis today follow the view of the sahibain on this point and say the tenant pays ushr on the harvest. The owner's rent income is then ordinary money that joins his yearly zakat on cash. Whatever you do, agree it clearly in the lease so that ushr is not paid twice or not at all.</p>
<h3>Orchards and fruit sold on contract</h3>
<p>Ushr on orchards works like any other crop in the Hanafi school: mangoes, citrus, guavas and dates are all included, at 10% or 5% depending on watering. It is common in Pakistan to sell an orchard's fruit on contract (theka) to a contractor who picks and markets it. A rule often given by Hanafi muftis is: if the fruit was sold after it had formed and become usable, the owner who sold it pays ushr, and he can pay on the sale price; if it was sold before that stage and the buyer lets it ripen on the trees, the buyer pays. Contracts vary a lot, so check your arrangement with a scholar.</p>

<h2>Paying in grain or in money</h2>
<p>You can give ushr from the crop itself, which is what the hadith describes: 10 maund of wheat from 100. In the Hanafi school you may also pay its market value in rupees, which is often more useful to a poor family that needs cash for rent or medicine. If you pay in money, use the market price at the time you pay. The other schools generally prefer the crop itself; some of their scholars allow the value when it clearly benefits the recipient.</p>
<p>Ushr is due once per harvest. If your land gives two crops a year, wheat in rabi and rice or cotton in kharif, ushr is due on each. Stored grain is not charged ushr again in later years, but if you sell it, the money becomes part of your ordinary zakatable cash.</p>

<h2>Worked examples</h2>
<h3>1. Wheat on rain-fed land</h3>
<p>Rashid farms barani land near Chakwal and harvests 100 maund of wheat. Rain was the only water. Ushr is 10%: <strong>10 maund</strong> (400 kg). In every Sunni school this is above 5 wasq, so it is due regardless of madhab.</p>
<h3>2. Wheat on tube well land</h3>
<p>Same harvest, 100 maund, but on land in Sargodha watered by his own tube well. Ushr is 5%: <strong>5 maund</strong> (200 kg). At an example price of Rs 3,500 per maund, that is Rs 17,500 if he pays in money.</p>
<h3>3. Cotton in rupees</h3>
<p>Nadia's family grows cotton on 10 acres of tube well land and sells 250 maund of phutti at an example price of Rs 8,000 per maund, Rs 20,00,000 in total. In the Hanafi school ushr is 5% of the crop: 12.5 maund, or <strong>Rs 1,00,000</strong> in value. In the Shafi'i, Maliki and Hanbali schools cotton is not an ushr crop; the sale money instead joins their cash for the annual 2.5% zakat if it is still held when their zakat year completes.</p>
<h3>4. Mixed watering</h3>
<p>Imran's rice field was flooded by monsoon rain for about half the season and pumped from a tube well for the other half. 200 maund harvested. With roughly equal watering, ushr is 7.5%: <strong>15 maund</strong>. If he estimates that the tube well did most of the work, say three quarters of the watering, the majority rule gives 5%: 10 maund.</p>
<h3>5. A small plot</h3>
<p>A widow's small plot gives 8 maund of wheat (320 kg) on rain. In the Hanafi school, 10% is due: 0.8 maund, about 32 kg. In the Shafi'i, Maliki and Hanbali schools nothing is due, because 320 kg is below 5 wasq (about 653 kg).</p>
<h3>Converting maund and kilograms</h3>
<ul>
<li>1 maund = 40 kg, so kg = maund × 40, and maund = kg ÷ 40.</li>
<li>5 wasq ≈ 653 kg ≈ 16.3 maund.</li>
<li>A 50 kg bag of wheat is 1.25 maund.</li>
</ul>

<h2>Ushr and the government in Pakistan</h2>
<p>The Zakat and Ushr Ordinance 1980 set up a state system in which ushr was assessed on landholders and collected through local zakat and ushr committees, alongside the bank zakat deduction described in our guide to <a href="/bank-zakat-deduction-pakistan/">bank zakat deduction in Pakistan</a>. Over the years government collection of ushr fell away in practice, and after the 18th Amendment in 2010 zakat and ushr administration was devolved to the provinces. Arrangements may differ from province to province and can change, but today most farmers we hear from pay ushr themselves, directly to deserving people. If a government body does collect ushr from you, ask your scholar whether you still owe the difference, for example where the official rate or assessment was lower than the actual crop.</p>

<h2>Who receives ushr</h2>
<p>Ushr goes to the same eight categories as all zakat, listed in Surah at-Tawbah 9:60: the poor, the needy, people in debt, stranded travellers and the rest. The same exclusions apply: not your own parents, children or spouse, and not Sayyids in the Sunni schools. See <a href="/who-can-receive-zakat/">who can receive zakat</a> for the full list. Many farmers give part of their ushr to landless labourers who helped with the harvest, which is allowed as long as it is a separate gift and not their wages.</p>

<h2>Common mistakes</h2>
<ul>
<li><strong>Waiting for Ramadan.</strong> Ushr is due at harvest, not at your yearly zakat date. Delaying it without reason is a fault.</li>
<li><strong>Paying 2.5% on crops.</strong> That is the rate for cash and gold. Crops are 10% or 5%.</li>
<li><strong>Subtracting all costs first</strong> without having checked that your scholar holds that view.</li>
<li><strong>Forgetting the second crop.</strong> Rabi and kharif harvests each carry ushr.</li>
<li><strong>Both owner and tenant assuming the other pays</strong> on cash-rented land.</li>
<li><strong>Counting harvest wages as ushr.</strong> Grain given to labourers as payment for their work is wages, not zakat.</li>
</ul>

<h2>What to do now</h2>
<ol>
<li>Weigh or estimate your harvest and convert it to maunds or kg.</li>
<li>Decide the watering: rain or river (10%), tube well or paid water (5%), or roughly half and half (7.5%).</li>
<li>Check your madhab's rule on the minimum and on which crops count.</li>
<li>Enter the figures in the <a href="/ushr-calculator/">ushr calculator</a> to get the amount in grain and rupees.</li>
<li>Give it soon after harvest to people who are eligible.</li>
</ol>
<p>If you keep goats, cows or buffaloes as well, read our guide to <a href="/zakat-on-livestock/">zakat on livestock</a>, and use the <a href="/zakat-calculator-pakistan/">Pakistan zakat calculator</a> for your cash, gold and savings.</p>
[myzt_faq]
HTML
			. $author . '[myzt_related slugs="ushr-calculator,zakat-on-livestock,who-can-receive-zakat,zakat-calculator-pakistan"]',
			'faq'     => array(
				array( 'q' => 'Gandum par ushr kitna hai?', 'a' => 'Barani (baarish) ya darya aur chashme ke paani wali zameen par paidawar ka 10% (100 maund par 10 maund), aur tube well ya paise wale paani par 5% (100 maund par 5 maund).' ),
				array( 'q' => 'Kya ushr se pehle khaad aur beej ka kharcha nikal sakte hain?', 'a' => 'Classical fiqh mein nahi; ushr poori fasal par hai aur paani ka kharcha 5% rate mein shamil hai. Kuch hazir ulama kharcha minus karne ki ijazat dete hain, is liye apne aalim se poochein.' ),
				array( 'q' => 'Is ushr due on sugarcane and cotton?', 'a' => 'In the Hanafi school, yes, at 10% or 5% depending on watering. The Shafi\'i, Maliki and Hanbali schools limit ushr to storable staples, so cash crops like these are not included.' ),
				array( 'q' => 'Thekay par di gayi zameen ka ushr kaun dega?', 'a' => 'Imam Abu Hanifa ke nazdeek maalik, aur Imam Abu Yusuf aur Imam Muhammad ke nazdeek kashtkar. Pakistan ke bohat se mufti aaj doosri raaye par fatwa dete hain.' ),
				array( 'q' => 'Is there a minimum harvest before ushr is due?', 'a' => 'Imam Abu Hanifa set none. His students and the other Sunni schools require 5 wasq, roughly 653 kg or 16 maund of wheat.' ),
				array( 'q' => 'Can I pay ushr in cash instead of grain?', 'a' => 'Yes in the Hanafi school, at the market value when you pay. Other schools prefer the crop itself.' ),
			),
		),

		'zakat-on-livestock' => array(
			'title'   => 'Zakat on Livestock: Goats, Cows, Buffaloes and Camels (Maweshi ki Zakat)',
			'seo'     => 'Zakat on Goats, Cows & Camels: Maweshi ki Zakat Tables',
			'desc'    => 'Zakat on goats, sheep, cows, buffaloes and camels: the conditions, full tables from Abu Bakr\'s letter, dairy and Eid animals, partnerships and worked examples.',
			'nav'     => 'Zakat on livestock',
			'blurb'   => 'maweshi ki zakat',
			'content' => <<<'HTML'
[myzt_answer q="How much zakat is due on goats, cows and camels?"]Zakat is due on goats, sheep, cows, buffaloes and camels that graze freely for most of the year, are not working animals, and have been owned for a lunar year. The minimums are 40 goats or sheep (give 1), 30 cows or buffaloes (give a one-year calf) and 5 camels (give 1 goat). Stall-fed dairy animals and animals bought to sell follow different rules.[/myzt_answer]
<p>Livestock zakat is paid in animals, not as 2.5% of a value, and it has its own tables that go back to the time of the Prophet ﷺ. That makes it look complicated, but for most households it comes down to one or two questions: do your animals graze freely, and do you have at least 40 goats or 30 cows? This guide explains the conditions, gives the full tables, and walks through examples from Pakistani villages. To work out your own herd, use the livestock tab of the <a href="/ushr-calculator/">ushr and livestock calculator</a>.</p>
<p>The rules below are those of the four Sunni schools unless we say otherwise. Shia Ja'fari rules are similar but not identical; there is a short note on them further down.</p>

<h2>The source: the letter of Abu Bakr</h2>
<p>The tables come from a letter that Abu Bakr as-Siddiq wrote to Anas ibn Malik when he sent him to collect zakat in Bahrain. It begins: "This is the obligation of charity which the Messenger of Allah ﷺ made obligatory on the Muslims," and then lists the dues on camels and on sheep and goats. Imam al-Bukhari records it in his <em>Sahih</em>, in the Book of Zakat (the full text is in hadith 1454, with parts of it in neighbouring chapters). Abu Dawud and an-Nasa'i also narrate it.</p>
<p>The tables for cows come from the hadith of Mu'adh ibn Jabal, whom the Prophet ﷺ sent to Yemen with the instruction to take a tabi' from every 30 cows and a musinnah from every 40 (Abu Dawud, Tirmidhi and an-Nasa'i). All four schools accept these figures.</p>

<h2>Conditions: when livestock zakat is due</h2>
<p>Zakat on animals is due only when all of these are met:</p>
<ol>
<li><strong>Sa'imah (free grazing).</strong> The animals feed themselves on open or common pasture for most of the year. Abu Bakr's letter says "on the sheep that graze (sa'imah)". In the Hanafi and Hanbali schools "most of the year" means more than half of it. The Shafi'i school is stricter: if the animals are fed by their owner for a period long enough that they could not survive without it, they lose the sa'imah status. Animals fed at home on fodder you buy, or fodder you cut and carry to them, are <em>ma'lufah</em> (fed), not grazing.</li>
<li><strong>Not working animals.</strong> Bullocks used for ploughing, camels used for transport and donkeys or horses used for carts are tools of work. The Hanafi, Shafi'i and Hanbali schools exempt them, relying on narrations such as the one from Ali, "there is nothing on working animals" (Abu Dawud). <strong>The Maliki school differs:</strong> Imam Malik held that zakat is due on camels, cows and goats whether they graze or are fed, and whether they work or not, as long as they reach the nisab. A Maliki owner of 30 stall-fed cows therefore owes zakat on them.</li>
<li><strong>Owned for a full lunar year (hawl).</strong> As with cash, the herd must stay at or above the nisab for a lunar year. In the Hanafi school, young born to the herd during the year are counted with their mothers when the year ends, as long as the herd was at the nisab to begin with. See <a href="/hawl-zakat-due-date/">how the hawl works</a> for the general rules.</li>
<li><strong>Nisab.</strong> At least 40 goats or sheep, 30 cows or buffaloes, or 5 camels. Below these numbers nothing is due as livestock zakat, however valuable the animals are.</li>
</ol>
<p>Only camels, cows (including buffaloes) and goats or sheep carry this zakat. Horses, donkeys, mules and poultry do not, unless they are trade goods. Imam Abu Hanifa held a separate view that grazing horses kept for breeding carry zakat, but his students Abu Yusuf and Muhammad, and the other schools, do not, and that is how most Hanafi muftis answer today.</p>

<h2>Goats and sheep (bakriyon ki zakat)</h2>
<p>Goats and sheep are one kind for zakat: a herd of 25 goats and 20 sheep counts as 45 and owes one animal.</p>
<figure class="wp-block-table"><table><thead><tr><th>Number of goats or sheep</th><th>Zakat</th></tr></thead><tbody>
<tr><td>1 to 39</td><td>Nothing</td></tr>
<tr><td>40 to 120</td><td>1 goat or sheep</td></tr>
<tr><td>121 to 200</td><td>2</td></tr>
<tr><td>201 to 399</td><td>3</td></tr>
<tr><td>400 and above</td><td>1 for every full 100 (400 = 4, 500 = 5, 650 = 6)</td></tr>
</tbody></table></figure>
<p>Notice how wide the bands are. Someone with 41 goats and someone with 120 both give one. The animals between the steps are called <em>waqs</em> and carry nothing.</p>

<h2>Cows and buffaloes (gaye bhains ki zakat)</h2>
<p>Buffaloes are counted with cows by agreement of the scholars; they are treated as one kind. A herd of 18 cows and 15 buffaloes is 33 and owes one tabi'.</p>
<ul>
<li><strong>Tabi' (or tabi'ah):</strong> a calf that has completed one year and is in its second.</li>
<li><strong>Musinnah:</strong> a cow that has completed two years and is in its third.</li>
</ul>
<figure class="wp-block-table"><table><thead><tr><th>Number of cows or buffaloes</th><th>Zakat</th></tr></thead><tbody>
<tr><td>1 to 29</td><td>Nothing</td></tr>
<tr><td>30 to 39</td><td>1 tabi'</td></tr>
<tr><td>40 to 59</td><td>1 musinnah</td></tr>
<tr><td>60 to 69</td><td>2 tabi'</td></tr>
<tr><td>70 to 79</td><td>1 tabi' + 1 musinnah (30 + 40)</td></tr>
<tr><td>80 to 89</td><td>2 musinnah (40 + 40)</td></tr>
<tr><td>90 to 99</td><td>3 tabi' (30 + 30 + 30)</td></tr>
<tr><td>100 to 109</td><td>2 tabi' + 1 musinnah (30 + 30 + 40)</td></tr>
<tr><td>110 to 119</td><td>1 tabi' + 2 musinnah (30 + 40 + 40)</td></tr>
<tr><td>120 to 129</td><td>3 musinnah (40 × 3), or 4 tabi' (30 × 4)</td></tr>
</tbody></table></figure>
<p>From 60 onwards the rule is simple: split the herd into 30s and 40s so that as much of it as possible is covered, then give a tabi' for each 30 and a musinnah for each 40. At exactly 120 both splits cover the whole herd; either is valid, and our calculator shows 3 musinnah. Anything left over between the steps is waqs. There is a narration from Imam Abu Hanifa that adds a fraction of an animal for counts between 40 and 60, but his two students and the other schools treat that range as waqs, which is what the table above and the calculator follow.</p>

<h2>Camels (oonton ki zakat)</h2>
<p>Camel zakat starts with goats, because a single young camel would be too heavy a due on a small herd.</p>
<figure class="wp-block-table"><table><thead><tr><th>Number of camels</th><th>Zakat</th></tr></thead><tbody>
<tr><td>1 to 4</td><td>Nothing</td></tr>
<tr><td>5 to 24</td><td>1 goat for every 5 (5 = 1, 10 = 2, 15 = 3, 20 = 4)</td></tr>
<tr><td>25 to 35</td><td>1 bint makhad (female camel in its 2nd year)</td></tr>
<tr><td>36 to 45</td><td>1 bint labun (female in its 3rd year)</td></tr>
<tr><td>46 to 60</td><td>1 hiqqa (female in its 4th year)</td></tr>
<tr><td>61 to 75</td><td>1 jadha'a (female in its 5th year)</td></tr>
<tr><td>76 to 90</td><td>2 bint labun</td></tr>
<tr><td>91 to 120</td><td>2 hiqqa</td></tr>
</tbody></table></figure>
<p><strong>Above 120 camels the schools differ.</strong> The Shafi'i and Hanbali schools follow the wording of Abu Bakr's letter: one bint labun for every 40 and one hiqqa for every 50. The Hanafi school starts the count again with goats and young camels on top of the 2 hiqqa, based on narrations from Ali and Ibn Mas'ud. The Maliki school has its own view on the range just above 120. Few families in Pakistan own herds this size, so our calculator stops at 120; if you do, ask a scholar of your madhab.</p>

<h2>Which animal to give: age and quality</h2>
<p>The animal you give should be of middle quality: not the best of your herd and not the worst. When the Prophet ﷺ sent Mu'adh to Yemen he told him, "beware of taking the best of their wealth" (Bukhari 1496). Abu Bakr's letter in turn says the collector should not take an old animal, one with a defect (such as a one-eyed animal), or the breeding male, unless the owner chooses to give it.</p>
<ul>
<li><strong>Not sick, injured or blind.</strong> If the whole herd is sick or defective, you may give one from it.</li>
<li><strong>Not your prize animal.</strong> You are not required to give the pregnant goat, the milking buffalo the family depends on, or the breeding bull. You may if you wish, and it is rewarded.</li>
<li><strong>The right age.</strong> For cows and camels the age is in the tables. For goats and sheep, Hanafi books say the animal should have completed one year; the other schools set similar minimum ages, which vary a little by species. A newborn kid is not accepted.</li>
<li><strong>Female where the table says so.</strong> Camel dues are female animals. For cows the Hanafi school accepts a male or female tabi'.</li>
</ul>

<h2>Paying the value instead of an animal</h2>
<p>Many owners would rather give money than hand over a goat, especially when the recipient lives in a city.</p>
<ul>
<li><strong>Hanafi:</strong> paying the market value of the animal that is due is allowed, and is often better for the poor person. Value it as a middling animal of the right age on the day you pay, for example by asking what such a goat fetches at your local mandi.</li>
<li><strong>Shafi'i and Hanbali:</strong> the general rule is that the animal itself must be given; value is not accepted. Some Hanbali scholars, Ibn Taymiyyah among them, allowed value where there is a real need or benefit.</li>
<li><strong>Maliki:</strong> the well-known position is also to give the animal, with some allowance in limited cases.</li>
</ul>
<p>If you follow a school other than the Hanafi, give the animal unless your scholar has told you otherwise.</p>

<h2>Animals that are not livestock zakat</h2>
<h3>Dairy buffaloes and cows fed at home</h3>
<p>Most buffaloes and cows in Punjab and Sindh villages are kept at the house or in a dera and fed chara, wanda, bhoosa and green fodder that the family buys or cuts. These are not sa'imah, so there is no livestock zakat on them in the Hanafi, Shafi'i and Hanbali schools, even if there are 30 or more. The money from selling milk, however, is ordinary income. Whatever of it is still with you on your zakat date joins your cash and is counted in the <a href="/zakat-calculator-pakistan/">Pakistan zakat calculator</a>. Remember the Maliki view above: a Maliki farmer with 30 or more stall-fed cows owes livestock zakat on them.</p>
<h3>Animals bought to sell (Eid ul Adha traders)</h3>
<p>Goats, bulls and camels bought with the intention of selling them are trade goods, whether they graze or not. They are not counted by the tables at all. Instead, add their market value on your zakat date to your other business assets and pay 2.5%, using the cash nisab. This covers the traders who buy animals in the months before Eid ul Adha and fatten them for the mandi, and dairy farmers who rear calves specifically to sell. Use the <a href="/business-zakat-calculator/">business zakat calculator</a>. An animal you bought for your own qurbani is neither livestock zakat nor trade goods.</p>
<h3>Poultry and fish farms</h3>
<p>Chickens, ducks and fish are not among the zakatable livestock, so there is no table for them. A broiler farm or fish farm that raises stock to sell is a business: the birds or fish on hand at your zakat date are counted at market value as trade goods, together with your cash and feed held for sale. Sheds, cages, ponds and equipment are not zakatable. In a layer farm the hens are usually treated as means of production, and the egg income joins your cash. Contemporary muftis differ on some of these details, so ask your scholar if the amounts are large.</p>

<h2>Mixed herds and partnerships (khulta)</h2>
<p>In Pakistani villages it is common for brothers, or several neighbours, to graze their goats together under one shepherd. Does that make one herd or several? Abu Bakr's letter says: "Separate herds are not to be combined, nor a combined herd separated, out of fear of the charity; and whatever belongs to two partners, they settle between themselves equally."</p>
<ul>
<li><strong>Shafi'i and Hanbali:</strong> animals of different owners that share the same pen, pasture, shepherd, watering place and breeding male are treated as one herd (khulta). The dues are worked out on the combined number and shared in proportion. The Maliki school also accepts khulta, but only when each partner owns at least a nisab himself.</li>
<li><strong>Hanafi:</strong> mixing has no effect. Each owner's animals are counted on their own, and the hadith is understood to stop people from rearranging ownership to dodge zakat.</li>
</ul>
<p>The difference can go either way, as the examples below show.</p>

<h2>Worked examples</h2>
<h3>1. A village household: 45 goats and 12 buffaloes</h3>
<p>The goats graze on common land near the village all day for most of the year; the buffaloes stand at the house and eat bought fodder. The goats are 45, above 40, so 1 goat is due. The buffaloes owe nothing: they are stall-fed and below 30 anyway. Milk sold over the year that is still saved on the zakat date goes in with the family's cash. A Hanafi family could also give the value of a middling one-year-old goat, say Rs 40,000 as an example, instead of the goat.</p>
<h3>2. A Thar herder: 90 goats and 45 sheep</h3>
<p>Goats and sheep are combined: 135 animals, in the 121 to 200 band, so 2 animals are due. Give them from the more numerous kind, or one of each, at middle quality.</p>
<h3>3. Cholistan: 75 grazing cows and buffaloes</h3>
<p>75 is covered best by 30 + 40 = 70, so the due is 1 tabi' and 1 musinnah. The remaining 5 are waqs.</p>
<h3>4. Balochistan: 26 camels</h3>
<p>26 is in the 25 to 35 band: one bint makhad, a female camel that has completed its first year.</p>
<h3>5. Two brothers sharing a herd</h3>
<p>Each brother owns 30 goats, grazed together by one shepherd. In the Shafi'i and Hanbali view the herd is 60, so 1 goat is due and each brother bears half. In the Hanafi view each owns 30, below the nisab, so nothing is due. Reverse it: three partners each own 40 goats in one herd of 120. The Shafi'i and Hanbali answer is 1 goat in total, shared three ways; the Hanafi answer is 1 goat from each partner, 3 in all.</p>
<h3>6. An Eid ul Adha trader</h3>
<p>A trader has 50 bakray bought for the Eid market when his zakat date comes, with an example market value of Rs 60,000 each. They are trade goods worth Rs 30,00,000, so zakat is 2.5% of that, Rs 75,000, added to the rest of his business zakat. The goat table does not apply.</p>

<h2>A note on Shia Ja'fari rules</h2>
<p>Ja'fari fiqh, as set out by Ayatollah Sistani, also requires zakat on grazing camels, cows and sheep that are not working animals and have been owned for a year, with similar but not identical tables. For example, sheep have an extra step: 301 to 399 sheep owe 4. Our calculator follows the Sunni tables, so followers of Ayatollah Sistani should check his <em>Islamic Laws</em> on sistani.org or ask his office.</p>

<h2>Common mistakes</h2>
<ul>
<li><strong>Paying 2.5% of the value of dairy buffaloes.</strong> Stall-fed animals are not zakatable livestock (outside the Maliki school), and livestock zakat is never "2.5% of value" anyway. Only the milk income, once saved, joins your cash.</li>
<li><strong>Treating Eid animals as livestock.</strong> Animals bought to sell are trade goods at market value, even if there are fewer than 40.</li>
<li><strong>Forgetting that goats and sheep combine, and cows and buffaloes combine.</strong> 25 goats and 20 sheep is 45, not two herds below the nisab.</li>
<li><strong>Giving the weakest animal.</strong> A sick or old goat does not discharge the duty; give a middling one.</li>
<li><strong>Counting working bullocks.</strong> Animals used for ploughing or carts are exempt in the Hanafi, Shafi'i and Hanbali schools.</li>
<li><strong>Splitting a herd on paper to avoid zakat.</strong> The hadith forbids exactly this.</li>
<li><strong>Thinking livestock zakat replaces ushr.</strong> They are separate. Crops have their own rules: see <a href="/ushr-on-crops/">ushr on crops</a>.</li>
</ul>

<h2>What to do now</h2>
<ol>
<li>Separate your animals into grazing, stall-fed, working and for sale.</li>
<li>Count the grazing ones by kind: goats and sheep together, cows and buffaloes together, camels.</li>
<li>Enter the numbers in the livestock tab of the <a href="/ushr-calculator/">ushr and livestock calculator</a> to see which animals are due.</li>
<li>Add animals for sale to your business assets, and saved milk income to your cash.</li>
<li>Give the animals, or their value if you are Hanafi, to people who are eligible; see <a href="/who-can-receive-zakat/">who can receive zakat</a>.</li>
</ol>
[myzt_faq]
HTML
			. $author . '[myzt_related slugs="ushr-calculator,ushr-on-crops,business-zakat-calculator,who-can-receive-zakat"]',
			'faq'     => array(
				array( 'q' => 'Bakriyon par zakat kab farz hoti hai?', 'a' => 'Jab kam az kam 40 bakriyan ya bhedein hon, saal ka zyada hissa khud charti hon, aur un par poora qamari saal guzar jaye. 40 se 120 tak ek bakri deni hai.' ),
				array( 'q' => 'Ghar par chara khane wali bhainson par zakat hai?', 'a' => 'Hanafi, Shafi\'i aur Hanbali ke nazdeek maweshi ki zakat nahi, kyun ke woh charne wali (sa\'imah) nahi. Doodh bech kar jo raqam bachi hai woh naqdi mein shamil hogi. Maliki mazhab mein 30 ya zyada gaye bhains par zakat hai.' ),
				array( 'q' => 'Can I give money instead of a goat?', 'a' => 'In the Hanafi school, yes: give the market value of a middling animal of the right age. The Shafi\'i and Hanbali schools generally require the animal itself.' ),
				array( 'q' => 'Is there zakat on 20 cows?', 'a' => 'Not as livestock, because the nisab for cows and buffaloes is 30. If they were bought to sell, their market value is counted as trade goods instead.' ),
				array( 'q' => 'Qurbani ke liye khareede janwar par zakat hai?', 'a' => 'Apni qurbani ke liye liya gaya janwar zakat mein shamil nahi. Lekin jo beopari bechne ke liye janwar khareedta hai, us par tijarati maal ki tarah market value ka 2.5% zakat hai.' ),
				array( 'q' => 'Is there zakat on a poultry farm?', 'a' => 'Not livestock zakat. Birds raised to sell are trade goods counted at market value; sheds and equipment are exempt.' ),
			),
		),

		'zakat-on-savings-certificates' => array(
			'title'   => 'Zakat on Savings Certificates: NSC, DSC, Behbood and Prize Bonds',
			'seo'     => 'Zakat on NSC, Behbood & DSC {year}: Deduction Rules',
			'desc'    => 'Zakat on NSC, DSC and Behbood certificates in Pakistan: which schemes are deducted at source, which are exempt, the profit question and how not to pay twice.',
			'nav'     => 'Zakat on certificates',
			'blurb'   => 'NSC, Behbood zakat',
			'content' => <<<'HTML'
[myzt_answer q="Is zakat due on National Savings certificates?"]Yes. The amount you invested in Defence Savings, Special Savings, Regular Income or Behbood certificates is your own wealth and counts towards your zakat, even when National Savings does not deduct anything. Some schemes, like DSC and SSC, have zakat collected at source; others, like Behbood, RIC and the Pensioners' Benefit Account, are exempt from that deduction but not from zakat itself.[/myzt_answer]
<p>Millions of Pakistani families keep their savings in National Savings schemes: a retired father in Regular Income Certificates, a widowed mother in Behbood, a lump sum parked in Defence Savings Certificates for a daughter's wedding. Every Ramadan the same questions come up. Did National Savings already cut my zakat? Is the profit mine to count? Why was nothing deducted from my Behbood? This guide answers those questions and shows how to enter everything in the <a href="/zakat-calculator-pakistan/">Pakistan zakat calculator</a> so you pay the right amount, once.</p>

<h2>The basic rule: zakat is due on what you invested</h2>
<p>A savings certificate is not a purchase of something that gets used up. It is your money held by the government, which you can encash, usually with a small service charge or reduced profit if you break it early. Because it is owned by you and redeemable, scholars of all four Sunni schools treat the principal like cash in hand or a bank deposit.</p>
<ul>
<li><strong>Hanafi</strong> (Deobandi and Barelvi in Pakistan): the principal is counted with your cash, gold, silver and trade goods, and the total is compared with the silver nisab, about [myzt_rate type="nisab-silver" currency="PKR"] today. This is the position in standard Hanafi texts such as al-Hidayah and in the fatwas of the major Pakistani darul-iftas.</li>
<li><strong>Shafi'i, Maliki and Hanbali</strong>: the same principle applies. Money you own outright and can get back is zakatable, and a debt owed to you by a solvent, willing debtor (which the state, paying on request, clearly is) is counted every year. Imam an-Nawawi discusses this in al-Majmu', and Ibn Qudamah in al-Mughni.</li>
<li><strong>Ahl-e-Hadith</strong> scholars in Pakistan likewise count savings certificates as cash, and our <a href="/ahl-e-hadith-zakat-calculator/">Ahl-e-Hadith calculator</a> applies the lower of the gold and silver nisab to money, following the Permanent Committee (al-Lajnah ad-Daimah).</li>
<li><strong>Shia Ja'fari</strong> (Ayatollah Sistani): zakat on money applies only to gold and silver coins in circulation, so paper money and certificates carry no zakat. Khums applies to savings instead. See the <a href="/khums-calculator/">khums calculator</a>.</li>
</ul>
<p>So the question is never "is my DSC zakatable?" but "how much of it is mine, and has any zakat on it already been paid?"</p>

<h2>Which National Savings schemes have zakat deducted?</h2>
<p>Under the Zakat and Ushr Ordinance 1980, some National Savings schemes are listed for compulsory collection of zakat at source, and others are expressly exempt from that collection. The table below is based on what the Central Directorate of National Savings (CDNS) states on its scheme pages and FAQs. Rules change, so treat it as a guide and confirm with your National Savings Centre or bank branch.</p>
<figure class="wp-block-table"><table><thead><tr><th>Scheme</th><th>Compulsory zakat deduction?</th><th>Do you still owe zakat on it?</th></tr></thead><tbody>
<tr><td>Defence Savings Certificates (DSC)</td><td>Yes, collected at source "as per rules"</td><td>Yes. Subtract what was deducted.</td></tr>
<tr><td>Special Savings Certificates (SSC)</td><td>Yes, collected at source</td><td>Yes. Subtract what was deducted.</td></tr>
<tr><td>Special Savings Account (SSA)</td><td>Yes; CDNS says it is collected when the principal is withdrawn</td><td>Yes. Track deductions carefully (see below).</td></tr>
<tr><td>National Savings Savings Account</td><td>Yes, CDNS says zakat applies</td><td>Yes. Subtract what was deducted.</td></tr>
<tr><td>Sarwa Islamic Savings Account / Term Account</td><td>Per the Sarwa rules, deducted under the Zakat and Ushr Ordinance; ask your branch how it applies to your account</td><td>Yes. Subtract anything deducted.</td></tr>
<tr><td>Regular Income Certificates (RIC)</td><td>No, exempt from compulsory deduction</td><td>Yes, pay it yourself.</td></tr>
<tr><td>Behbood Savings Certificates (BSC)</td><td>No, exempt</td><td>Yes, if the holder is above the nisab.</td></tr>
<tr><td>Pensioners' Benefit Account (PBA)</td><td>No, exempt</td><td>Yes, if the holder is above the nisab.</td></tr>
<tr><td>Shuhada Family Welfare Account</td><td>No, exempt (same rule as Behbood)</td><td>Yes, if the holder is above the nisab.</td></tr>
<tr><td>Short Term Savings Certificates</td><td>No, exempt</td><td>Yes, pay it yourself.</td></tr>
<tr><td>Premium Prize Bonds and ordinary prize bonds</td><td>CDNS says premium bonds are exempt; ordinary bonds are bearer instruments with nobody to deduct from</td><td>Yes, on face value.</td></tr>
</tbody></table></figure>
<p>The most important column is the last one. "Exempt from zakat" on a government brochure means exempt from <em>compulsory deduction</em> by the state. It does not mean that Islamic law has excused you. A widow with Rs 20 lakh in Behbood certificates still owes zakat on it if she is above the nisab; the government has simply left it to her to pay it herself.</p>

<h3>When is the deduction made?</h3>
<p>For bank savings accounts, the valuation date is 1 Ramadan: the balance on that day is checked against the government's deduction nisab, and 2.5% is cut. For National Savings certificates, CDNS only says zakat is collected "at source as per rules", and for the Special Savings Account it says the collection happens when the principal is withdrawn. In practice, certificate holders report deductions shown on profit payments or at encashment, sometimes covering more than one Ramadan at once. Because the exact mechanics differ by scheme and have changed over the years, ask National Savings or your bank to show you what was deducted, on which date and for which year. The <a href="/bank-zakat-deduction-pakistan/">bank zakat deduction guide</a> explains the 1 Ramadan rule for ordinary accounts.</p>

<h3>The CZ-50 declaration</h3>
<p>A Muslim who is exempt from compulsory zakat on grounds of their fiqh, most commonly followers of Fiqh-e-Jafaria, can file a CZ-50 declaration with the deducting agency. For certificates, that means the National Savings Centre or bank where you hold them. It is a sworn declaration, normally on stamp paper, and it has to reach them before the deduction date. Ask the centre for its current format and deadline. Filing CZ-50 to avoid the deduction when you do not genuinely hold that belief is not a way to save money: you would still owe the zakat yourself.</p>

<h2>The profit question: is the interest part of your wealth?</h2>
<p>This is where Pakistani scholars genuinely differ, and it is worth understanding both views before you decide.</p>
<h3>View 1: profit on conventional schemes is riba and is not counted</h3>
<p>DSC, SSC, RIC, Behbood and the ordinary savings account pay a fixed, pre-agreed return on a loan to the government. Many Pakistani scholars, including the Deobandi darul-iftas and a large number of Barelvi and Ahl-e-Hadith muftis, consider this return to be riba, which the Quran prohibits (al-Baqarah 2:275-279). On this view the profit was never rightfully yours. You should give it away to the poor without the intention of earning reward, and you should not count it as your zakatable wealth or pay it out as your zakat. Your zakat is calculated on the principal only.</p>
<h3>View 2: accrued profit is counted with your wealth</h3>
<p>Other scholars, and many people who hold that these returns are permissible, count profit that has accrued and is payable to you as part of your wealth on your zakat date, just like a bank balance. Profit you have already received and spent is gone; profit that is sitting in your account or built into a DSC's encashment value is counted.</p>
<h3>What we suggest</h3>
<p>Follow the scholar you normally follow for halal and haram questions. If you hold View 1, enter only the principal in the calculator and give away the interest separately. If you hold View 2, enter the encashment value (principal plus accrued profit). If you are unsure, ask your scholar; the difference on large holdings can be significant, and the question of what to do with past interest matters more than the zakat figure.</p>
<h3>Sarwa Islamic schemes</h3>
<p>CDNS presents its Sarwa Islamic Savings and Term Accounts as shariah-compliant, invested in government projects under the supervision of a Sharia board. If you accept that structure, the profit is halal income, so it is simply your wealth: count the principal and any accrued, payable profit on your zakat date.</p>

<h2>Prize bonds</h2>
<p>A prize bond is a receipt for money lent to the government, refundable at face value at any National Savings Centre or bank. Count the face value of every bond you hold, whether ordinary or Premium, at your zakat date. A Rs 40,000 Premium bond is Rs 40,000 of wealth. National Savings does not deduct zakat on prize bonds, so the whole amount is for you to pay.</p>
<p>Scholars who regard prize bond winnings as gambling or riba advise giving them away without the intention of reward, as with interest. That affects what you do with a prize, not the zakat on the bond's face value.</p>

<h2>How to enter certificates in our calculator</h2>
<ol>
<li>Open the <a href="/zakat-calculator-pakistan/">Pakistan zakat calculator</a> (or the general calculator on the <a href="/">home page</a>) and choose your madhab.</li>
<li>In the cash tile, find <strong>Savings certificates (NSC, Behbood, DSC, RIC)</strong>. Enter the amount invested, that is the face value of all your certificates and National Savings accounts added together. If you follow View 2 above, add accrued profit too.</li>
<li>Enter prize bonds in the <strong>Prize bonds</strong> field at face value.</li>
<li>Fill in gold, silver, bank balances, cash and any short-term debts as usual.</li>
<li>Tap <strong>Already paid</strong> and enter any zakat that National Savings or your bank deducted from your certificates or accounts for this year. The calculator subtracts it from your zakat (not from your wealth) and shows what is <strong>still to pay</strong>.</li>
</ol>
<p>You can also type a quick sentence such as "10 lakh dsc, 5 lakh behbood"; the calculator recognises NSC, DSC and Behbood and puts them in the certificates field.</p>

<h2>Worked example: DSC, Behbood and gold</h2>
<p>Nasreen, a widow in Lahore, follows the Hanafi madhab. On her zakat date she holds (all amounts are examples):</p>
<ul>
<li>Rs 10,00,000 invested in Defence Savings Certificates, with about Rs 3,00,000 of accrued profit built into the encashment value.</li>
<li>Rs 5,00,000 in Behbood Savings Certificates.</li>
<li>Gold jewellery which, at today's rate, is worth Rs 6,00,000 (example value; the calculator uses the live rate of about [myzt_rate type="gold-tola" currency="PKR"] per tola of 24K).</li>
<li>Her DSC statement shows Rs 25,000 deducted as zakat for this year.</li>
</ul>
<p><strong>If she follows View 1 (principal only):</strong></p>
<figure class="wp-block-table"><table><thead><tr><th>Item</th><th>Amount</th></tr></thead><tbody>
<tr><td>DSC principal</td><td>Rs 10,00,000</td></tr>
<tr><td>Behbood principal</td><td>Rs 5,00,000</td></tr>
<tr><td>Gold</td><td>Rs 6,00,000</td></tr>
<tr><td><strong>Total zakatable wealth</strong></td><td><strong>Rs 21,00,000</strong></td></tr>
<tr><td>Zakat at 2.5%</td><td>Rs 52,500</td></tr>
<tr><td>Less: DSC deduction (Already paid)</td><td>Rs 25,000</td></tr>
<tr><td><strong>Still to pay</strong></td><td><strong>Rs 27,500</strong></td></tr>
</tbody></table></figure>
<p>She would also give away the Rs 3,00,000 of DSC profit (and the monthly Behbood profit she has received) to the poor without intending reward, according to the scholars who hold this view.</p>
<p><strong>If she follows View 2 (principal plus accrued profit):</strong> her wealth is Rs 24,00,000, zakat is Rs 60,000, and after the Rs 25,000 deduction she still owes Rs 35,000.</p>
<p>Notice that nothing was deducted from the Behbood certificates, yet they are the reason she owes more. Many families assume that "no deduction" means "no zakat" and underpay for years. If that has happened to you, see the guide on <a href="/missed-zakat-past-years/">missed zakat from past years</a>.</p>

<h2>Widows, pensioners and senior citizens</h2>
<p>Behbood certificates are open to senior citizens over 60, widows, disabled persons and special minors, and the Pensioners' Benefit Account to retired government pensioners. The government exempts these from compulsory deduction because the holders often depend on the monthly profit. But Islamic law looks at the person's total wealth, not at the scheme:</p>
<ul>
<li>If a widow's certificates, gold and cash together are below the nisab, she owes no zakat, and she may even be eligible to receive it. See <a href="/who-can-receive-zakat/">who can receive zakat</a>.</li>
<li>If she is above the nisab, she owes 2.5% on the total, including her Behbood or PBA principal, and pays it herself.</li>
<li>Zakat is due on each person separately. A mother's Behbood certificates are her zakat, not her son's, even if the son manages the paperwork. A son may pay his mother's zakat on her behalf with her permission.</li>
<li>Pension that you have spent on living costs is not counted; only what is left on your zakat date.</li>
<li>Gold jewellery a widow wears is zakatable in the Hanafi view but not in the Shafi'i, Maliki and Hanbali views. See <a href="/zakat-on-jewellery/">zakat on jewellery</a>.</li>
</ul>

<h2>How to avoid paying twice (or not at all)</h2>
<ul>
<li><strong>Collect your deduction records.</strong> Ask for a statement from National Savings or your bank showing every zakat deduction on your certificates and accounts, with dates.</li>
<li><strong>Match the deduction to the year.</strong> A deduction made at encashment may cover earlier Ramadans. Only count against this year what relates to this year; anything relating to earlier years counts against those years' zakat.</li>
<li><strong>Count every scheme, deducted or not.</strong> Behbood, RIC, PBA and prize bonds need to be added by you.</li>
<li><strong>Do not count the deduction as wealth.</strong> The amount cut is gone from your account; enter it under Already paid, not as savings.</li>
<li><strong>Use one zakat date.</strong> Your own zakat date (your hawl) may not be 1 Ramadan. Value everything on your own date and simply subtract what the state took during that year. See <a href="/hawl-zakat-due-date/">your hawl and zakat due date</a>.</li>
</ul>
<p>Small amounts follow the same 2.5% rule: Rs 1 lakh in a certificate means Rs 2,500, as in <a href="/zakat-on-1-lakh-rupees/">zakat on 1 lakh rupees</a>, provided your total is above the nisab.</p>

<h2>What to do now</h2>
<ol>
<li>List every National Savings certificate, account and prize bond held by each person in the family, with face values.</li>
<li>Get the zakat deduction records for this year from National Savings or your bank.</li>
<li>Decide, with your scholar, whether you count accrued profit.</li>
<li>Enter everything in the <a href="/zakat-calculator-pakistan/">Pakistan zakat calculator</a>, put deductions under Already paid, and pay what is still due to <a href="/who-can-receive-zakat/">eligible recipients</a>.</li>
</ol>
<p>This guide is general information. For your own holdings, especially large ones or past years' interest, please ask a qualified scholar.</p>
[myzt_faq]
HTML
			. $author . '[myzt_related slugs="zakat-calculator-pakistan,bank-zakat-deduction-pakistan,zakat-on-1-lakh-rupees,missed-zakat-past-years"]',
			'faq'     => array(
				array( 'q' => 'Behbood certificate par zakat hai?', 'a' => 'Haan. National Savings Behbood se zakat nahi kaat-ta, lekin agar aapka kul maal nisab se zyada hai to Behbood ki asal raqam par 2.5% zakat aap ko khud deni hogi.' ),
				array( 'q' => 'Does National Savings deduct zakat from Defence Savings Certificates?', 'a' => 'Yes, CDNS says zakat on DSC is collected at source under the rules. Ask your centre for a statement of what was deducted and enter it under Already paid.' ),
				array( 'q' => 'Is the profit on NSC certificates zakatable?', 'a' => 'Scholars differ. Many Pakistani scholars treat the profit on conventional schemes as riba to be given away, not counted as wealth; others count accrued profit. Ask your scholar.' ),
				array( 'q' => 'Kya prize bond par zakat hai?', 'a' => 'Haan, prize bond ki face value aap ka maal hai. Apne zakat ke din jitne bond aap ke paas hain unki poori qeemat shamil karen.' ),
				array( 'q' => 'Are Regular Income Certificates exempt from zakat?', 'a' => 'They are exempt from compulsory deduction at source, not from zakat. If you are above the nisab, count the principal and pay the zakat yourself.' ),
				array( 'q' => 'Can a Shia investor stop the deduction on certificates?', 'a' => 'A follower of Fiqh-e-Jafaria can file a CZ-50 declaration with the National Savings Centre or bank before the deduction date. Ask them for the current format and deadline.' ),
			),
		),

		'khums-who-must-pay' => array(
			'title'   => 'Khums: Who Must Pay, What Counts and How to Calculate It',
			'seo'     => 'Khums Kis Par Wajib Hai? Rules & Calculator ({year})',
			'desc'    => 'Who must pay khums under Ayatollah Sistani\'s rulings: yearly surplus, khums date, expenses, gifts, mahr, Sahm-e-Imam, Sahm-e-Sadat and a PKR example.',
			'nav'     => 'Khums: who must pay',
			'blurb'   => 'khums kis par',
			'content' => <<<'HTML'
[myzt_answer q="Who must pay khums?"]According to Ayatollah Sistani, every adult Shia whose income during the year is more than the year's reasonable living expenses must pay khums: one fifth (20%) of what is left over on their khums date. Half is Sahm-e-Imam, paid to the marja or his authorised representative, and half is Sahm-e-Sadat, for needy Sayyids.[/myzt_answer]
<p>For most Shia families in Pakistan, khums matters more than zakat. Under Ayatollah Sistani's rulings, paper money, bank balances and jewellery carry no zakat today. What is left of your salary or business profit at the end of your khums year carries khums instead. That covers almost everyone with a regular income.</p>
<p>This guide explains the rules as Ayatollah Sistani gives them in <em>Islamic Laws</em> (the khums chapter, rulings 1769 onwards, on sistani.org). When you have your figures, use the <a href="/khums-calculator/">khums calculator</a>. It splits the amount into the two shares and can add your khums date to your calendar. We are a calculator site, not a marja or a fatwa office. Where something is unclear, ask your marja's office or his representative.</p>

<h2>The Quranic basis</h2>
<blockquote><p>"And know that whatever you gain of anything, one fifth of it is for Allah and for the Messenger, and for the near relatives, the orphans, the needy and the traveller." (Surah al-Anfal 8:41)</p></blockquote>
<p>Shia jurists read "whatever you gain" broadly, to cover every kind of gain, not only spoils of war. This is why khums in Ja'fari fiqh is a yearly duty on ordinary earnings.</p>

<h2>The seven things khums applies to (Sistani)</h2>
<p><em>Islamic Laws</em> lists seven categories:</p>
<ol>
<li><strong>Surplus income from earnings and gains</strong> (fawa'id al-makasib): salary, business profit, rent, freelance income, and other gains left over after the year's expenses.</li>
<li><strong>Mined products</strong>, such as gold, silver, salt or oil taken from a mine.</li>
<li><strong>Treasure troves</strong>, meaning buried wealth that someone finds.</li>
<li><strong>Lawful property mixed with unlawful property</strong>, where the owner cannot tell how much is unlawful or who it belongs to.</li>
<li><strong>Gems taken by diving</strong> in the sea.</li>
<li><strong>Spoils of war.</strong></li>
<li><strong>Land bought by a non-Muslim (dhimmi) from a Muslim.</strong></li>
</ol>
<p>Categories 2 to 7 rarely touch an ordinary household. The first one is the khums nearly every working person owes, and it is what the rest of this guide covers.</p>

<h2>Surplus income: how the yearly calculation works</h2>
<p>Ruling 1769 says that whoever earns through trade, a craft, a job or any other work must pay khums on it. Ruling 1782 adds that once a year passes, khums is due on whatever exceeds the year's living expenses. So the formula is simple:</p>
<p><strong>Khums = 20% × (income received during the khums year − reasonable expenses of that year), counting only what is still in hand on the khums date.</strong></p>
<p>"In hand" covers more than cash. It includes bank balances, money lent to others that you can recover, stock bought for a shop, and things bought from income that are still unused. Ruling 1797 says provisions bought from the year's profit and still left at year end are liable, valued at the year-end price if it has gone up.</p>

<h3>Setting your khums year (ra's al-sana)</h3>
<ul>
<li><strong>When it starts:</strong> in Sistani's <em>Summary of the Rules of Worship</em>, employees, traders and craftsmen start their khums year when they begin working. For someone with no job, each gain, such as a gift, has its own year, counted from when it was received.</li>
<li><strong>Which calendar:</strong> guides based on his rulings (for example the World Federation's <em>Khums: A Brief Guide</em>) say the date can follow the Islamic or the Gregorian calendar. Many people in Pakistan choose an easy date such as 1 Muharram, or 1 January.</li>
<li><strong>Paying early:</strong> ruling 1783 allows you to pay khums on a profit whenever you receive it, or to wait until the end of the year. To move to a new, easier date, people usually do a full calculation and pay on that day. You cannot push the date later to delay payment. Ask the office how to fix a new date in your case.</li>
</ul>

<h3>The first year, if you have never paid</h3>
<p>Your first calculation is the hardest one. It has to cover every saving and asset that came from income on which khums was never paid and that was not spent as an expense within its own year. That can include an old bank balance, a plot bought as an investment, or gold kept as savings. Things bought from income and used within the same year, such as your house, furniture, clothes or car, are generally not liable. Sistani's <em>Dialogue on Khums</em> tells people with a backlog from earlier years to consult the marja or his deputy and reach a settlement (musalaha). If you are unsure what year an item was bought, or with what money, take that question to the office as well.</p>

<h2>What counts as expenses (ma'una)</h2>
<p>Ruling 1792 exempts what you spend on food, clothing, furniture, buying a house, your son's wedding, your daughter's jahez (trousseau), ziyarah and similar needs, <strong>as long as the amount is not beyond your status</strong>. Ruling 1795 counts Hajj and ziyarah costs as living expenses of the year. Ruling 1793 adds vows, kaffarah, and gifts or charity you give, again within your status.</p>
<figure class="wp-block-table"><table><thead><tr><th>Item</th><th>Usually</th><th>Condition</th></tr></thead><tbody>
<tr><td>Household bills, food, school fees, medical costs</td><td>Expense, no khums</td><td>Spent within the year</td></tr>
<tr><td>House you live in, bought within the year</td><td>Expense, no khums</td><td>You need it and it fits your status</td></tr>
<tr><td>Car or motorcycle for family or work</td><td>Expense, no khums</td><td>Bought and used within the year, suits your status</td></tr>
<tr><td>Wedding costs, jahez</td><td>Expense, no khums</td><td>Customary for your family's status</td></tr>
<tr><td>Hajj, Karbala or Mashhad ziyarah</td><td>Expense, no khums</td><td>Paid within the year</td></tr>
<tr><td>Ration, cloth or other goods still unused</td><td>Khums due</td><td>On their value at the khums date</td></tr>
<tr><td>Cash and bank savings from income</td><td>Khums due</td><td>On the balance at the khums date</td></tr>
<tr><td>Second plot, shares or gold bought to invest</td><td>Khums due</td><td>Investment, not a living need</td></tr>
</tbody></table></figure>
<p>"Status" (sha'n) is real and personal. A senior doctor in Lahore and a clerk in Hyderabad have different reasonable expenses. Spending that is wasteful or plainly beyond your standing does not count as an expense. Note too that ruling 1773 says money you save by living frugally is still liable. Being thrifty does not raise your expense allowance.</p>

<h2>What is excluded, and what is not</h2>
<h3>Gifts: not exempt in Sistani's rulings</h3>
<p>Many people assume gifts are free of khums. In Sistani's rulings they are not. Ruling 1770: a person who acquires property without earning it, for example a gift, must pay khums on it if it exceeds his living expenses for the year. His office gives the same answer on sistani.org: khums is due on the excess "if a year runs over it". So Eid money, a cash gift from an uncle abroad, or a gifted gold set kept as savings is part of your income. Khums is due on whatever of it is left on your khums date. A gift you use within the year, like jewellery a woman wears, is treated as an expense in the office's answers. Followers of other maraji' should check, because this is one of the points where they differ.</p>
<h3>Inheritance: generally exempt</h3>
<p>Ruling 1771 exempts property inherited in the normal Shia way. There are exceptions. Property inherited in another way, such as through ta'sib, is treated as a gain and is liable. If the deceased owed khums on the property and did not pay it, the heirs must pay it from the estate (ruling 1772). Any profit you later make from the inheritance, such as rent, is ordinary income.</p>
<h3>Mahr</h3>
<p>Ruling 1771 also exempts the mahr a wife receives, along with property received in a khul' divorce and lawful blood money (diyah). Profit she later earns from investing the mahr is income in the normal way.</p>

<h2>Special cases: saving for a house, unused items, business capital</h2>
<h3>Saving for a house</h3>
<p>This is the hardest rule for young families. Savings carried past the khums date are liable, even if you are saving for a house. The World Federation's guide based on Sistani's rulings says savings for future years are liable. Buying for future years is not an expense, unless the thing would be unavailable later or very hard to get. What helps:</p>
<ul>
<li>A house bought, or a payment made on it, <strong>within the same khums year</strong> from that year's income is an expense (ruling 1792).</li>
<li>Ruling 1803: if you borrow for a necessary or reasonable expense, such as a house or car for your own use, you may deduct repayments from the income of later years while the debt remains. This is how a house loan or a payment plan with a builder is treated.</li>
<li>We could not find a general exemption in his published rulings for house savings held over several years. If you are in real difficulty, ask his office about your case.</li>
</ul>
<h3>Items bought from income and left unused</h3>
<p>Under ruling 1797, provisions left over at the khums date are liable. Under ruling 1798, household furniture that was used during the year is generally not liable even when no longer needed. An air conditioner still in its box, a stack of unstitched suits, or a full year's wheat bought in bulk and still in store are counted at their value on the khums date. Clothes normally kept for future years are an exception.</p>
<h3>Capital for business</h3>
<p>Sistani's <em>Summary of the Rules of Worship</em> says that business capital and necessary business tools are not excluded from khums. If a shopkeeper puts this year's profit into stock or a new machine, khums is due on that amount. Once khums has been paid on a sum, it is never charged again, but the profit it earns later is new income. Ruling 1801 lets a trader set business losses against profit from the same year.</p>

<h2>The two shares: Sahm-e-Imam and Sahm-e-Sadat</h2>
<p>Ruling 1851 divides khums into two halves.</p>
<ul>
<li><strong>Sahm-e-Imam (10% of the surplus):</strong> must be given to a fully qualified jurist or spent on purposes he authorises. By obligatory precaution that jurist is the most learned marja. In practice, pay it to your marja's office or an authorised representative (wakil) who gives an official receipt.</li>
<li><strong>Sahm-e-Sadat (10%):</strong> for a Sayyid who is poor, orphaned, or stranded on a journey, and who is a Twelver Shia. You may not give it to someone you are already obliged to support, such as your wife or children. The khums chapter of <em>Islamic Laws</em> does not mention a permission requirement for this half. Many people still give it through his representative for convenience and checking, and his office can confirm the current position. If you hand it over yourself, make sure the recipient really is a Sayyid and in need. The ruling asks for proof such as two reliable witnesses, or the name being well known in the area.</li>
</ul>
<p>Sayyids generally may not receive zakat from non-Sayyids. Sahm-e-Sadat exists to meet their needs instead, as explained in <a href="/who-can-receive-zakat/">who can receive zakat</a>.</p>
<h3>Paying in rupees</h3>
<p>Ruling 1805 lets you pay khums from the item itself or pay its monetary value. Most people in Pakistan pay in PKR by bank transfer or cash to the representative. Value unused goods, gold and foreign-currency savings at their market rate on your khums date, not the price you paid.</p>

<h2>Zakat and khums for Shia in Pakistan: the difference</h2>
<figure class="wp-block-table"><table><thead><tr><th></th><th>Zakat (Sistani)</th><th>Khums (Sistani)</th></tr></thead><tbody>
<tr><td>On what</td><td>9 things only: wheat, barley, dates, raisins, camels, cows, sheep, gold and silver coins used as currency</td><td>Surplus of yearly income, plus six other categories</td></tr>
<tr><td>Cash and bank</td><td>Not zakatable: paper money is not gold or silver currency (ruling 1915)</td><td>20% of what is left at the khums date</td></tr>
<tr><td>Rate</td><td>Varies: 2.5% on coins, 5% or 10% on crops</td><td>20%</td></tr>
<tr><td>Who receives</td><td>The eight Quranic groups (9:60)</td><td>Marja (Sahm-e-Imam), needy Sayyids (Sahm-e-Sadat)</td></tr>
</tbody></table></figure>
<p>See the <a href="/shia-zakat-calculator/">Shia zakat calculator</a> for the zakat side. Zakat al-fitr (fitrana) at the end of Ramadan is still due for Shia as well.</p>
<p>Pakistani banks deduct 2.5% zakat from savings accounts on 1 Ramadan unless the account holder has filed a CZ-50 declaration on grounds of fiqh. Many followers of Fiqh-e-Jafaria file it. The deduction is a state collection; it is not your khums and does not reduce it. Read <a href="/bank-zakat-deduction-pakistan/">bank zakat deduction in Pakistan</a> for the form and deadlines.</p>

<h2>Worked example in PKR</h2>
<p>This example is hypothetical. Ali is a salaried employee in Karachi. His khums date is 1 Muharram, and he paid khums last year. On this year's 1 Muharram:</p>
<ul>
<li>Bank and cash: Rs 6,20,000. Of this, Rs 2,00,000 is money on which he already paid khums last year, so the untaxed part is <strong>Rs 4,20,000</strong>. This includes Rs 30,000 left from a Rs 50,000 Eid gift from his uncle.</li>
<li>Ration and cloth bought from salary, still unused: <strong>Rs 15,000</strong> at today's prices.</li>
<li>A motorcycle bought in Rajab for commuting (Rs 2,80,000): an expense, excluded.</li>
<li>His wife's mahr gold: hers, and exempt.</li>
<li>Unpaid hospital bill from this year, owed to the hospital: <strong>Rs 35,000</strong>, deducted.</li>
</ul>
<figure class="wp-block-table"><table><tbody>
<tr><td>Untaxed savings</td><td>Rs 4,20,000</td></tr>
<tr><td>+ Unused items</td><td>Rs 15,000</td></tr>
<tr><td>− This year's debts for expenses</td><td>Rs 35,000</td></tr>
<tr><td><strong>Surplus</strong></td><td><strong>Rs 4,00,000</strong></td></tr>
<tr><td><strong>Khums (20%)</strong></td><td><strong>Rs 80,000</strong></td></tr>
<tr><td>Sahm-e-Imam (10%)</td><td>Rs 40,000</td></tr>
<tr><td>Sahm-e-Sadat (10%)</td><td>Rs 40,000</td></tr>
</tbody></table></figure>
<p>Once Ali pays, all Rs 6,20,000 counts as khums-paid money. If next year he still has Rs 6,00,000 of it untouched, no khums is due on that part again. Only new surplus is counted.</p>
<h3>Two quick cases</h3>
<ul>
<li><strong>A student with no job</strong> receives Rs 1,00,000 from relatives over the year and has Rs 40,000 left. With Sistani, khums is due on the Rs 40,000 once a year has passed from when each gift was received, or on her chosen khums date: Rs 8,000.</li>
<li><strong>A shopkeeper</strong> puts Rs 3,00,000 of this year's profit into new stock. The stock is not an expense, so Rs 60,000 khums is due on it, valued at the khums date.</li>
</ul>

<h2>Common mistakes</h2>
<ul>
<li><strong>Taking 20% of total savings.</strong> Money already taxed is not charged again. Only this year's untaxed surplus counts.</li>
<li><strong>Treating gifts as exempt.</strong> In Sistani's rulings, a leftover gift is income.</li>
<li><strong>Forgetting unused goods</strong>, stock in the shop, and money lent to friends that you can get back.</li>
<li><strong>Counting the bank's 1 Ramadan deduction as khums.</strong> It is a separate state collection.</li>
<li><strong>Giving Sahm-e-Imam to any religious cause you like.</strong> It needs the marja's authorisation.</li>
<li><strong>Letting years pile up.</strong> The first calculation grows harder each year. Settle with the office and then keep a fixed date.</li>
</ul>

<h2>Other maraji'</h2>
<p>This guide follows Ayatollah Sistani, the marja most followed in Pakistan. Followers of Ayatollah Khamenei and other maraji' agree on the 20% and the two shares. They differ on details such as gifts, business capital, and how each share may be paid. Check your own marja's published rulings or his office.</p>

<h2>What to do now: set a reminder with our tool</h2>
<ol>
<li>Choose your khums date and note it down.</li>
<li>On that date, list your untaxed savings, unused items, trade stock and this year's unpaid debts.</li>
<li>Enter them in the <a href="/khums-calculator/">khums calculator</a> to see the surplus, the total and both shares.</li>
<li>In the same calculator, enter your khums date and tap <strong>Add khums date to calendar</strong>. It downloads an .ics file with your next five yearly khums dates and an alert three days before each one.</li>
<li>Pay Sahm-e-Imam to your marja's office or wakil and keep the receipt. Give Sahm-e-Sadat to deserving Sayyids.</li>
</ol>
<p>One caution: the calendar file repeats the same Gregorian date every year. If your khums year follows the Hijri calendar, like 1 Muharram, the date moves about 11 days earlier each year. Either update the reminder each year, or choose a Gregorian date for your khums year.</p>
[myzt_faq]
HTML
			. $author . '[myzt_related slugs="khums-calculator,shia-zakat-calculator,bank-zakat-deduction-pakistan,who-can-receive-zakat"]',
			'faq'     => array(
				array( 'q' => 'Khums kis par wajib hai?', 'a' => 'Ayatollah Sistani ke mutabiq har baligh Shia par jis ki saal bhar ki aamdani us ke munasib saalana kharchon se zyada ho. Khums ki tareekh par jo bacha ho us ka 20% dena hota hai.' ),
				array( 'q' => 'Kya tohfe (gift) par khums hai?', 'a' => 'Ayatollah Sistani ke nazdeek haan. Tohfa aamdani mein shumar hota hai, aur khums ki tareekh par jo hissa bacha ho us par 20% khums wajib hai. Doosre maraji\' ki raaye mukhtalif ho sakti hai.' ),
				array( 'q' => 'Is khums due on the house I live in?', 'a' => 'Not if you bought it from that year\'s income within the same khums year, you need it and it suits your status. A second house kept as an investment is liable.' ),
				array( 'q' => 'Can I give Sahm-e-Sadat to my poor Sayyid cousin?', 'a' => 'Yes, if he is a needy Twelver Shia Sayyid and not someone you are already obliged to support, such as your wife or child.' ),
				array( 'q' => 'Does the bank\'s zakat deduction count as khums?', 'a' => 'No. It is a state zakat collection under Pakistani law. Followers of Fiqh-e-Jafaria can avoid it by filing a CZ-50 declaration before Ramadan.' ),
				array( 'q' => 'Khums ki tareekh kaise tay karein?', 'a' => 'Naukri shuru karne ki tareekh se saal shuru hota hai. Aap Hijri ya English calendar ki koi asaan tareekh, jaise 1 Muharram, chun sakte hain. Is ke liye us din tak ka poora hisaab kar ke khums ada karein.' ),
			),
		),

	);
}
