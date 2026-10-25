<?php
/**
 * Asset pages (part A): zakat on salary, property, shares and provident fund.
 * {year}, {cyear}, {fyear} and {rate:TYPE} in titles and descriptions are filled at runtime (MYZT_SEO::fill).
 *
 * @package MyZakatTool
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function myzt_content_assets_a() {
	$author = '[myzt_author]';
	$p      = array();

	/* ------------------------------------------------------------------ */
	$p['zakat-on-salary'] = array(
		'title' => 'Zakat on Salary',
		'seo'   => 'Zakat on Salary {year}: Calculator and Savings Rule',
		'desc'  => 'Is zakat due on salary? No monthly zakat on pay itself; 2.5% on what is saved on your zakat date once savings reach the nisab. Calculator for every madhab.',
		'nav'   => 'Zakat on Salary',
		'blurb' => 'salary par zakat',
		'hub'   => 'calculators',
		'llms'  => true,
		'content' => <<<'HTML'
[myzt_answer q="Is zakat due on salary?"]Not on the salary itself each month. Zakat is 2.5% of what you still have saved on your yearly zakat date, once your savings first reached the nisab (about [myzt_rate type="nisab-silver" currency="PKR"] by the silver measure today) and a lunar year has passed. Money you spent during the year carries no zakat.[/myzt_answer]
<p>Enter your cash at home, your bank balances and any bills or instalments due now. The calculator below opens with those boxes ready. Your salary slip is not needed: what matters is the balance left on your zakat date.</p>
[zakat_calculator tiles="cash,bank,debts"]
<h2>Do I pay zakat on my monthly salary?</h2>
<p>No. In all four Sunni schools zakat is not a tax on income. A salary is money that comes in and, for most people, goes out again on rent, food, school fees and bills. Zakat looks at wealth that stays with you. The rule comes from the hadith "There is no zakat on wealth until a year passes over it" (Abu Dawud 1573; Ibn Majah 1792). So a person who earns Rs 1,50,000 a month and spends all of it owes no zakat on that salary, however large it is.</p>
<p>What you do owe zakat on is your savings: cash at home, money in your current and savings accounts, money in wallets such as JazzCash or Easypaisa, prize bonds, savings certificates, gold and silver, and anything else zakatable. Money you have paid into a committee counts too (see <a href="/zakat-on-committee/">zakat on committee (BC)</a>), and so do coins held in an exchange or wallet (see <a href="/zakat-on-crypto/">zakat on crypto</a>). These are added together on one day each year, your zakat date.</p>
<h2>When does my zakat year start?</h2>
<p>Your zakat year (hawl) starts on the day your savings first reached the nisab. For many salaried people that is a few months after starting their first job. One lunar year later is your first zakat date, and it repeats on the same Islamic date every year. If you do not know the day, our guide to <a href="/hawl-zakat-due-date/">hawl and the zakat due date</a> explains how to estimate it, and the <a href="/zakat-date-calculator/">zakat date calculator</a> shows your next dates.</p>
<p>In the Hanafi madhab, which most people in Pakistan and India follow, two things matter:</p>
<ul>
<li><strong>The start and the end of the year.</strong> If your savings were at or above the nisab when the year started and are still at or above it on your zakat date, zakat is due, even if your balance dipped in the middle of the year. Only if your zakatable wealth fell to nothing does the year restart.</li>
<li><strong>Money added during the year joins the year.</strong> The salary you saved last month, a bonus that arrived a week ago and the gold you bought in between are all counted on your zakat date. You do not need to track a separate year for each payment.</li>
</ul>
<h2>Worked example: a salaried person in Karachi</h2>
<p>Ahmed works in a bank and earns Rs 2,20,000 a month. He follows the Hanafi madhab. His savings first reached the nisab on 1 Ramadan two years ago, so 1 Ramadan is his zakat date. On 1 Ramadan this year he has:</p>
<figure class="wp-block-table"><table><thead><tr><th>Item</th><th>Amount</th><th>Counted?</th></tr></thead><tbody>
<tr><td>Savings account</td><td>Rs 6,40,000</td><td>Yes</td></tr>
<tr><td>Current account (this month's salary, partly spent)</td><td>Rs 1,10,000</td><td>Yes</td></tr>
<tr><td>Cash at home</td><td>Rs 25,000</td><td>Yes</td></tr>
<tr><td>Prize bonds (face value)</td><td>Rs 75,000</td><td>Yes</td></tr>
<tr><td>Rent and electricity bill due this month</td><td>Rs 70,000</td><td>Subtracted (Hanafi)</td></tr>
<tr><td>Car and household furniture</td><td>-</td><td>No (personal use)</td></tr>
</tbody></table></figure>
<p>His zakatable total is Rs 6,40,000 + Rs 1,10,000 + Rs 25,000 + Rs 75,000 = Rs 8,50,000. Minus the Rs 70,000 due now, that is Rs 7,80,000, well above the silver nisab. Zakat is 2.5% = <strong>Rs 19,500</strong>. If his bank deducted zakat from the savings account on 1 Ramadan, that deduction counts towards the Rs 19,500; see <a href="/bank-zakat-deduction-pakistan/">bank zakat deduction in Pakistan</a>. For a quick check, zakat on every Rs 1,00,000 is Rs 2,500 (<a href="/zakat-on-1-lakh-rupees/">table up to 50 lakh</a>).</p>
<p>Notice what was not counted: the salaries he earned and spent during the year, his car and his furniture. Had his salary for the coming month already arrived the day before his zakat date, it would be counted, because it is in his account on that day.</p>
<h2>What if I save very little each month?</h2>
<p>If your total savings and gold never reach the nisab, no zakat is due at all. Check the live figure on the <a href="/nisab/">nisab page</a>. Hanafi scholars use the silver nisab for cash and mixed wealth, which is the lower and more cautious figure today. A woman who owns gold jewellery should add it in, because in the Hanafi madhab worn jewellery is zakatable and even a small amount of gold together with some savings can bring the total above the silver nisab.</p>
<h2>What about paying zakat from every salary?</h2>
<p>Some contemporary scholars, most famously Yusuf al-Qaradawi in his book <em>Fiqh al-Zakah</em>, argued that earned income (al-mal al-mustafad) can be taxed at 2.5% when it is received, without waiting for a year, relying on reports from some Companions. This is a minority view. The four Sunni schools and most scholars today hold that zakat on salary money is due only on what is still owned when the year completes. Paying something from every salary is still a good habit: you can set it aside as advance zakat and settle the exact amount on your zakat date, which the Hanafi, Shafi'i and Hanbali schools allow.</p>
<h2>What does each madhab say about zakat on salary?</h2>
<ul>
<li><strong>Hanafi:</strong> no zakat on the salary as it arrives. Savings held on your zakat date are counted, including money that came in during the year, as long as the nisab was there at the start and end of the year. Debts due now are subtracted. Silver nisab. Use the <a href="/hanafi-zakat-calculator/">Hanafi calculator</a>.</li>
<li><strong>Shafi'i:</strong> salary money is wealth that comes from outside, so in principle each saving starts its own year from the day it is received, and the nisab must hold through the whole year. Because tracking every payment is impractical, many Shafi'i scholars advise paying on everything on one date, treating the newer money as paid early. Debts are not subtracted in the relied-upon view.</li>
<li><strong>Maliki:</strong> similar to the Shafi'i view: new money such as salary (fa'ida) starts its own year. Debts are subtracted from cash. A single yearly date with early payment for newer money is the practical route.</li>
<li><strong>Hanbali:</strong> each new amount has its own year and the nisab must hold throughout. Debts are subtracted. Cash is measured by the nisab that is better for the poor, which today is silver. Paying everything on one date, partly in advance, is allowed.</li>
<li><strong>Ahl-e-Hadith:</strong> the <a href="/ahl-e-hadith-zakat-calculator/">Ahl-e-Hadith calculator</a> follows the Saudi Permanent Committee: the lower nisab, cash added to gold and silver, and debts not subtracted. A simpler method often suggested in Saudi fatwas for salaried people is to pay on all savings on the date the first savings complete a year, which pays the newer money early and is allowed. Ask your own scholar if you want to keep separate years.</li>
<li><strong>Shia (Ayatollah Sistani):</strong> no zakat on paper money or bank balances, so there is no zakat on salary savings. Instead, khums (20%) is due on what is left of the year's income after the year's expenses. Use the <a href="/khums-calculator/">khums calculator</a>.</li>
</ul>
<h2>Common mistakes</h2>
<ul>
<li><strong>Paying 2.5% of the yearly salary.</strong> That counts money you have already spent. Zakat is on what is left.</li>
<li><strong>Leaving out the current account.</strong> Every account counts, not only the savings account the bank deducts from.</li>
<li><strong>Forgetting gold.</strong> In the Hanafi madhab a wife's jewellery is her own zakat, but it often brings her above the nisab even when her savings are small. See <a href="/zakat-on-jewellery/">zakat on jewellery</a>.</li>
<li><strong>Counting the provident fund every year.</strong> Many Hanafi muftis say compulsory fund deductions are not zakatable until received; see <a href="/zakat-on-provident-fund/">zakat on provident fund</a>.</li>
</ul>
<p>If you earn abroad and keep savings both there and in Pakistan, all of it is added on the same date; <a href="/zakat-for-overseas-pakistanis/">zakat for overseas Pakistanis</a> covers currency, nisab and where to pay. This page explains well-known rulings to help you calculate; it is not a fatwa. For your own situation, ask a qualified scholar you trust.</p>
[myzt_faq]
HTML
		. $author . '[myzt_related slugs="zakat-calculator-pakistan,hawl-zakat-due-date,zakat-on-provident-fund,bank-zakat-deduction-pakistan"]',
		'faq'   => array(
			array( 'q' => 'Is zakat due on my monthly salary?', 'a' => 'Not on the salary as it arrives. Zakat is 2.5% of what you still have saved on your zakat date, once your savings have reached the nisab and a lunar year has passed.' ),
			array( 'q' => 'Salary par zakat kaise nikalein?', 'a' => 'Har mahine ki tankhwah par zakat nahi. Apni zakat ki tareekh par jo naqdi, bank balance, prize bond aur sona chandi bacha ho, sab jorein, jo bill abhi dene hain (Hanafi maslak mein) minus karein, aur agar kul nisab se zyada ho to 2.5% ada karein.' ),
			array( 'q' => 'Kya har mahine ki tankhwah par zakat farz hai?', 'a' => 'Nahi. Chaar Sunni maslak ke mutabiq zakat bachat par hai, aamdani par nahi. Jo tankhwah saal ke dauran kharch ho gayi us par zakat nahi. Kuch maujooda ulama (jaise Yusuf al-Qaradawi) tankhwah milte hi zakat ke qail hain, magar yeh aqliyati raye hai.' ),
			array( 'q' => 'Does a bonus received a week before my zakat date count?', 'a' => 'In the Hanafi madhab, yes: money added during the year joins your zakat year and is counted on your zakat date. In the Shafi\'i, Maliki and Hanbali schools it has its own year, but you may pay on it early with the rest.' ),
			array( 'q' => 'How much zakat on Rs 5,00,000 of savings?', 'a' => 'Rs 12,500, which is 2.5% of Rs 5,00,000, if your total zakatable wealth is above the nisab on your zakat date.' ),
		),
	);

	/* ------------------------------------------------------------------ */
	$p['zakat-on-property'] = array(
		'title' => 'Zakat on Plot and Property',
		'seo'   => 'Zakat on Plot and Property {year}: Rules and Calculator',
		'desc'  => 'Zakat on a plot is due only if you bought it to sell: 2.5% of its market value on your zakat date. No zakat on your home or rental property itself.',
		'nav'   => 'Zakat on Property',
		'blurb' => 'plot par zakat',
		'hub'   => 'calculators',
		'llms'  => true,
		'content' => <<<'HTML'
[myzt_answer q="Is zakat due on a plot?"]Only if you bought the plot with the intention of selling it. Then it is trade goods, and zakat is 2.5% of its market value on your zakat date: Rs 50,000 on a plot worth Rs 20,00,000. A plot or house for living in, for your own use, or bought with no firm intention to sell carries no zakat; nor does rental property, though the rent you save is counted.[/myzt_answer]
<p>Open the <strong>Plot / property for sale</strong> tile and enter what each plot held for sale would fetch today, then add your bank balances. The calculator below opens with both ready.</p>
[zakat_calculator tiles="plot,bank"]
<h2>When is zakat due on a plot?</h2>
<p>Land and buildings are not zakatable in themselves. They become zakatable only when they are <em>trade goods</em> (urud al-tijarah): something you own in order to sell for profit. The four Sunni schools agree that the intention to sell must be present when you acquire the property by purchase. So the question for every plot is simple: <strong>why did you buy it?</strong></p>
<figure class="wp-block-table"><table><thead><tr><th>Property</th><th>Zakat?</th></tr></thead><tbody>
<tr><td>The house you live in</td><td>No</td></tr>
<tr><td>A plot bought to build your own house on, or for your children</td><td>No</td></tr>
<tr><td>A plot bought with no firm intention (maybe build, maybe sell, maybe keep)</td><td>No, in the view widely given by Hanafi muftis in Pakistan and India</td></tr>
<tr><td>A plot bought to sell when the price rises</td><td>Yes, 2.5% of market value every year</td></tr>
<tr><td>A house or shop you rent out</td><td>No on the property; the rent you save is counted with your cash</td></tr>
<tr><td>A shop or office you run your business from</td><td>No (a fixed asset); the stock and cash in it are counted</td></tr>
<tr><td>Inherited land</td><td>No, until you decide to sell and actually trade it; see <a href="/zakat-on-inherited-wealth/">zakat on inherited wealth</a></td></tr>
</tbody></table></figure>
<h2>What if my intention changes later?</h2>
<p>In the Hanafi madhab, intention alone does not turn a plot bought for your own use into trade goods. If you bought land to build a house and later decide to sell it, it does not become zakatable merely because of that decision; the sale money is counted once it is in your hands. The reverse works more easily: if you bought a plot to sell and then decide to build your own house on it, it stops being trade goods from that decision. The Shafi'i school takes the same approach in its main position. Some Hanbali scholars hold that a later intention to trade is enough, so a Hanbali reader in that situation should ask a scholar.</p>
<h2>How is a trade plot valued?</h2>
<p>At the price it would realistically sell for on your zakat date, not what you paid. Ask a local estate agent or look at recent sales of similar plots in the same block. If prices have fallen, you pay on the lower value. Your zakat is due only if your total zakatable wealth reaches the <a href="/nisab/">nisab</a>. Many scholars accept a cautious, realistic figure rather than the highest asking price in the market.</p>
<h2>Worked example: two plots and a rented flat</h2>
<p>Saima lives in Islamabad and follows the Hanafi madhab. On her zakat date she owns:</p>
<figure class="wp-block-table"><table><thead><tr><th>Item</th><th>Value today</th><th>Counted?</th></tr></thead><tbody>
<tr><td>A 10 marla plot bought three years ago to sell</td><td>Rs 45,00,000</td><td>Yes (trade goods)</td></tr>
<tr><td>A 5 marla plot bought for her son's future house</td><td>Rs 28,00,000</td><td>No</td></tr>
<tr><td>A flat she rents out for Rs 60,000 a month</td><td>Rs 90,00,000</td><td>No (rental property)</td></tr>
<tr><td>Bank balance, including saved rent</td><td>Rs 7,50,000</td><td>Yes</td></tr>
<tr><td>Property tax and a repair bill due now</td><td>Rs 50,000</td><td>Subtracted (Hanafi)</td></tr>
</tbody></table></figure>
<p>Zakatable total: Rs 45,00,000 + Rs 7,50,000 − Rs 50,000 = Rs 52,00,000. Zakat is 2.5% = <strong>Rs 1,30,000</strong>. The house plot and the rented flat, worth Rs 1,18,00,000 together, add nothing. If she followed the Shafi'i or Ahl-e-Hadith view, the Rs 50,000 would not be subtracted and her zakat would be Rs 1,31,250.</p>
<h2>Property dealers and flippers</h2>
<p>A person who buys plots and houses to resell is a trader, and the plots are his stock. On his zakat date he adds the market value of every property he holds for sale to his business cash and money buyers still owe him, subtracts debts due now where his madhab allows it, and pays 2.5%. The <a href="/business-zakat-calculator/">business zakat calculator</a> is built for this. His own home, office and car are not counted.</p>
<h2>Plots bought on instalments</h2>
<p>Contemporary scholars discuss this case because Pakistani housing schemes are often sold on instalments. The answer depends on whether the plot is already yours:</p>
<ul>
<li><strong>The plot is allotted to you and you bought it to sell:</strong> it is your trade goods, so many contemporary Hanafi muftis say zakat is on its market value, and the instalments you still owe are a debt. Following the view widely given by contemporary Hanafi scholars for long loans, only the instalments due in the coming year are subtracted, not the whole remaining balance.</li>
<li><strong>Nothing is allotted yet and you have only paid in money:</strong> many scholars treat what you have paid as your money held by the developer and count the amount paid in if the purchase is for sale. Others look at it differently. Ask a scholar for your case.</li>
<li><strong>Bought for your own house:</strong> no zakat on the plot or on what you have paid, whatever stage it is at.</li>
</ul>
<p><strong>Plot files:</strong> buying and selling "files" before a plot is identified is common in Pakistan, and several scholars have questioned whether such a sale is valid at all. We have not found a clear, widely agreed ruling on zakat on files. If you hold files to trade, ask a scholar about the transaction itself first; for zakat, the cautious course is to count what a file would fetch today.</p>
<h2>What does each madhab say about zakat on property?</h2>
<ul>
<li><strong>Hanafi:</strong> no zakat on a home, rental property, or land for own use. A plot bought with the intention of resale is trade goods, counted at market value each year with your other wealth, and debts due now are subtracted. Silver nisab.</li>
<li><strong>Shafi'i:</strong> the same basic rule: the intention to trade at the time of purchase makes property trade goods, valued each year. Debts are not subtracted in the relied-upon view.</li>
<li><strong>Maliki:</strong> the Maliki school distinguishes two kinds of trader. A regular trader (mudir) who buys and sells all the time values his stock every year. A person who buys and waits for a good price (muhtakir), as many plot investors do, pays zakat once, for one year, when the plot is sold. This is a well-known Maliki rule; follow it only if Maliki fiqh is your school.</li>
<li><strong>Hanbali:</strong> property bought for trade is valued yearly at market price; some Hanbali scholars accept a later intention to trade. Debts are subtracted, and the nisab used is the one better for the poor.</li>
<li><strong>Ahl-e-Hadith:</strong> property held for sale is trade goods, valued yearly; a home and rental property carry no zakat. Debts are not subtracted, following the Saudi Permanent Committee.</li>
<li><strong>Shia (Ayatollah Sistani):</strong> zakat does not apply to land, buildings or trade goods. A plot bought from income that has not been taxed for khums, and that is not a need such as your home, generally comes under khums instead. Check the details with your marja's office and use the <a href="/khums-calculator/">khums calculator</a>.</li>
</ul>
<p>Add your gold, savings and other assets to the same calculation, in the <a href="/zakat-calculator-pakistan/">Pakistan zakat calculator</a> or the main <a href="/">zakat calculator</a>, because zakat is worked out on everything you own together.</p>
<p>This page explains well-known rulings to help you calculate; it is not a fatwa. Property cases can be complicated, so ask a qualified scholar about yours.</p>
[myzt_faq]
HTML
		. $author . '[myzt_related slugs="business-zakat-calculator,zakat-calculator-pakistan,zakat-on-inherited-wealth,nisab"]',
		'faq'   => array(
			array( 'q' => 'Is zakat due on the house I live in?', 'a' => 'No. A home and other property for your own use carry no zakat in any madhab.' ),
			array( 'q' => 'Plot par zakat hai ya nahi?', 'a' => 'Agar plot bechne ki niyyat se khareeda tha to haan: har saal zakat ki tareekh par uski bazaari qeemat ka 2.5%. Agar ghar banane, apne istemal ya bina pakki niyyat ke khareeda tha to us par zakat nahi.' ),
			array( 'q' => 'Kiraye wale ghar par zakat kaise nikalein?', 'a' => 'Ghar ya dukaan ki qeemat par zakat nahi. Jo kiraya bach kar aap ke paas hai woh baqi naqdi aur bank balance mein mil jata hai, aur zakat ki tareekh par us par 2.5% zakat hoti hai.' ),
			array( 'q' => 'Is zakat on a trade plot based on purchase price or market value?', 'a' => 'On its market value on your zakat date: what it would realistically sell for today, not what you paid.' ),
			array( 'q' => 'Is zakat due on a plot bought on instalments?', 'a' => 'Only if it was bought to sell. Many contemporary Hanafi muftis then count its market value and subtract the instalments due in the coming year. If nothing is allotted yet, many count what you have paid in. Ask a scholar for your case.' ),
		),
	);

	/* ------------------------------------------------------------------ */
	$p['zakat-on-shares'] = array(
		'title' => 'Zakat on Shares and Mutual Funds',
		'seo'   => 'Zakat on Shares and Mutual Funds {year}: PSX Calculator',
		'desc'  => 'Zakat on shares: traders pay 2.5% of market value; long-term investors may pay on the company\'s zakatable assets or 2.5% of market value. PSX and mutual funds.',
		'nav'   => 'Zakat on Shares',
		'blurb' => 'shares & funds',
		'hub'   => 'calculators',
		'llms'  => true,
		'content' => <<<'HTML'
[myzt_answer q="How much zakat is due on shares?"]If you buy shares to sell, zakat is 2.5% of their market value on your zakat date: Rs 25,000 on a portfolio worth Rs 10,00,000. If you hold them long term for dividends, many scholars allow paying only on your share of the company's zakatable assets, which is usually less; paying 2.5% of the full market value is the simpler and safer option.[/myzt_answer]
<p>Open the <strong>Shares / mutual funds</strong> tile and enter the value of your portfolio and fund units on your zakat date, then add your bank balances. The calculator below opens with both ready.</p>
[zakat_calculator tiles="shares,bank"]
<h2>Why are shares zakatable?</h2>
<p>A share is part ownership of a company. Contemporary scholars of all schools agree that shares, like other wealth held for growth or sale, are subject to zakat. The International Islamic Fiqh Academy of the OIC issued a resolution on zakat on shares in 1988, and AAOIFI's Shariah standard on zakat covers the same ground. What scholars discuss is <em>how much</em> of the share's value is zakatable, and that depends on why you hold it.</p>
<h2>Trader or investor: which are you?</h2>
<ul>
<li><strong>Trader:</strong> you buy shares to sell them at a profit, whether within days or months. The shares are your trade goods. Zakat is 2.5% of their full market value on your zakat date, exactly like stock in a shop. Most day traders and active PSX investors fall here.</li>
<li><strong>Long-term investor:</strong> you buy shares to keep and earn dividends, not to sell on price movements. Here scholars give two approaches, explained next.</li>
</ul>
<h2>Two methods for long-term shares</h2>
<h3>Method 1: your share of the company's zakatable assets</h3>
<p>A company owns buildings, machinery and other fixed assets that would not carry zakat if you owned them directly. On this view, which AAOIFI's standard and many contemporary scholars give, and which is widely quoted from Mufti Muhammad Taqi Usmani in Pakistan, the long-term investor pays zakat only on his share of the company's zakatable assets: cash, receivables, stock and raw materials. The steps are:</p>
<ol>
<li>From the company's latest balance sheet, add cash and bank balances, receivables, inventory and other zakatable current assets.</li>
<li>Divide by the number of shares to get the zakatable amount per share.</li>
<li>Multiply by the number of shares you own and pay 2.5% of the result.</li>
</ol>
<p>Scholars who use this method differ on details, such as whether the company's debts can be subtracted, and on what to do when the figures are hard to find. Some have suggested an estimate based on a share of market value; there is no single agreed percentage, so we do not give one.</p>
<h3>Method 2: 2.5% of the market value</h3>
<p>Many scholars and zakat bodies say the long-term investor may simply pay 2.5% of the market value, like a trader. It is easier, needs no balance sheet, and never underpays. If you are unsure which category you are in, or cannot get the company figures, this is the safer choice.</p>
<h2>Worked example: a PSX portfolio</h2>
<p>Usman follows the Hanafi madhab. On his zakat date he holds:</p>
<figure class="wp-block-table"><table><thead><tr><th>Holding</th><th>Market value</th><th>Why he holds it</th></tr></thead><tbody>
<tr><td>Cement and bank shares he trades</td><td>Rs 6,00,000</td><td>To sell</td></tr>
<tr><td>1,000 shares of a fertiliser company</td><td>Rs 4,00,000</td><td>Long term, for dividends</td></tr>
<tr><td>Units in an Islamic equity fund</td><td>Rs 3,00,000</td><td>Long term</td></tr>
<tr><td>Cash in his brokerage account</td><td>Rs 50,000</td><td>Waiting to invest</td></tr>
<tr><td>Bank balance</td><td>Rs 2,00,000</td><td>Savings</td></tr>
</tbody></table></figure>
<ul>
<li><strong>Using 2.5% of market value for everything:</strong> Rs 6,00,000 + Rs 4,00,000 + Rs 3,00,000 + Rs 50,000 + Rs 2,00,000 = Rs 15,50,000. Zakat = <strong>Rs 38,750</strong>.</li>
<li><strong>Using Method 1 for the fertiliser shares:</strong> suppose the latest accounts show zakatable assets of Rs 150 per share. His 1,000 shares give Rs 1,50,000 instead of Rs 4,00,000. The total becomes Rs 13,00,000 and zakat is <strong>Rs 32,500</strong>. (Rs 150 is an example figure for illustration only.)</li>
</ul>
<p>Cash in the brokerage account is plain money and is always counted in full. Coins and tokens bought to sell on follow the same trade-goods rule; see <a href="/zakat-on-crypto/">zakat on crypto</a>. A full-time trader running a business can use the <a href="/business-zakat-calculator/">business zakat calculator</a>, and anyone can total everything in the <a href="/zakat-calculator-pakistan/">Pakistan zakat calculator</a>. Dividends you have received and still have on your zakat date are part of your cash.</p>
<h2>Mutual funds, including Islamic funds</h2>
<p>A unit in a mutual fund is a share of everything the fund holds. Value it at the fund's net asset value (NAV) per unit on your zakat date, or the redemption price you would actually receive.</p>
<ul>
<li><strong>Money market, income and sukuk funds</strong> hold mostly cash-like assets, so count the full value.</li>
<li><strong>Equity funds</strong> follow the share rules: full value if you hold them to sell; for long-term units, a scholar may allow the zakatable-assets method, but full value is the simpler and safer choice.</li>
<li><strong>Islamic funds</strong> are not exempt from zakat because they are shariah-compliant. Being halal affects how the fund invests, not whether you owe zakat on it.</li>
<li><strong>Pension funds (VPS)</strong> you cannot withdraw from freely raise a separate question; see <a href="/zakat-on-provident-fund/">zakat on provident fund</a> for how scholars treat money you cannot yet reach.</li>
</ul>
<h2>Is zakat deducted from dividends in Pakistan?</h2>
<p>Under the Zakat and Ushr Ordinance 1980, zakat may be deducted at source on dividends and on some fund payouts for Muslim holders who have not filed a CZ-50 declaration. Rules and practice have changed over time, so check your dividend warrant, your broker's or CDC statement, or the fund's account statement for any zakat deducted. Whatever was deducted counts towards your zakat: enter it under <strong>Already paid</strong>. A deduction on dividends is not the full zakat on your shares, so you still need to calculate the rest. The <a href="/bank-zakat-deduction-pakistan/">bank zakat deduction guide</a> explains CZ-50.</p>
<p>If you hold shares in a company that pays zakat on behalf of its shareholders, some scholars say the shareholder need not pay again on those shares. Most listed companies in Pakistan do not do this, so assume you have to pay yourself unless you have clear confirmation.</p>
<h2>What does each madhab say about zakat on shares?</h2>
<p>Shares did not exist when the classical schools were formed, so the rulings below are contemporary scholars applying each school's rules on trade goods. The school you follow mainly changes the treatment of debts and the nisab.</p>
<ul>
<li><strong>Hanafi:</strong> shares held to sell are trade goods at market value. For long-term holdings, many Pakistani Hanafi scholars allow the zakatable-assets method. Debts due now are subtracted; silver nisab. See the <a href="/hanafi-zakat-calculator/">Hanafi calculator</a>.</li>
<li><strong>Shafi'i:</strong> scholars apply the trade goods rule to shares bought for sale. Debts are not subtracted in the relied-upon view. Authorities in Malaysia and Singapore publish their own guidance on shares, which Shafi'i readers there usually follow.</li>
<li><strong>Maliki:</strong> the rules for trade goods apply. The Maliki school distinguishes the active trader, who values his stock every year, from the buy-and-wait investor, who pays once when he sells; how that applies to shares is a question for a Maliki scholar, so ask before relying on it.</li>
<li><strong>Hanbali:</strong> trade goods at market value; many contemporary Hanbali scholars accept the zakatable-assets method for long-term holdings. Debts are subtracted.</li>
<li><strong>Ahl-e-Hadith:</strong> scholars following the Saudi Permanent Committee treat shares held for trade as trade goods at market value. For long-term holdings, Saudi scholars have given differing answers. Debts are not subtracted; the lower nisab applies.</li>
<li><strong>Shia (Ayatollah Sistani):</strong> there is no zakat on shares or cash. Shares bought from income on which khums has not been paid, and still held on your khums date, generally come under khums. Use the <a href="/khums-calculator/">khums calculator</a> and confirm with your marja's office.</li>
</ul>
<p>Before you count anything, make sure the company itself is shariah-compliant if that matters to you; zakat is a separate question from whether an investment is halal. This page explains well-known views to help you calculate; it is not a fatwa. Ask a qualified scholar about your portfolio.</p>
[myzt_faq]
HTML
		. $author . '[myzt_related slugs="business-zakat-calculator,zakat-calculator-pakistan,bank-zakat-deduction-pakistan,zakat-on-provident-fund"]',
		'faq'   => array(
			array( 'q' => 'Is zakat due on shares held long term?', 'a' => 'Yes. Many scholars allow a long-term investor to pay only on his share of the company\'s zakatable assets (cash, receivables, stock). Paying 2.5% of market value is simpler and safer.' ),
			array( 'q' => 'Shares par zakat kaise nikalein?', 'a' => 'Agar shares bechne ke liye hain to zakat ki tareekh par unki bazaari qeemat ka 2.5%. Agar lambe arse ke liye dividend ke liye rakhe hain to bahut se ulama company ke zakat wale assets ke hisse par zakat ki ijazat dete hain; poori bazaari qeemat par 2.5% dena aasaan aur mehfooz hai.' ),
			array( 'q' => 'Mutual fund par zakat hai?', 'a' => 'Haan. Zakat ki tareekh par units ki NAV ya wapsi ki qeemat ka 2.5%. Islamic fund bhi zakat se mustasna nahi. Agar fund ne zakat kaati ho to apni statement dekh kar use ada shuda zakat mein shamil karein.' ),
			array( 'q' => 'Does zakat deducted on dividends cover my zakat on shares?', 'a' => 'It counts towards it, but usually covers only part. Check your dividend or account statement for the amount deducted, enter it as already paid, and pay the rest yourself.' ),
			array( 'q' => 'Are Islamic mutual funds exempt from zakat?', 'a' => 'No. A shariah-compliant fund is still your wealth. Count its value on your zakat date like any other fund.' ),
		),
	);

	/* ------------------------------------------------------------------ */
	$p['zakat-on-provident-fund'] = array(
		'title' => 'Zakat on Provident Fund and GP Fund',
		'seo'   => 'Zakat on Provident Fund and GP Fund {year}: Rules',
		'desc'  => 'Zakat on GP fund and provident fund: many Hanafi muftis say none on compulsory deductions until received, nor for past years. Voluntary part and pension.',
		'nav'   => 'Zakat on Provident Fund',
		'blurb' => 'GP fund zakat',
		'hub'   => 'calculators',
		'llms'  => true,
		'content' => <<<'HTML'
[myzt_answer q="Is zakat due on provident fund?"]On the compulsory part of a GP fund or provident fund, many Hanafi muftis in Pakistan, following Mufti Muhammad Shafi, say no zakat is due until you receive it, and none is due for past years when you do. After receipt it joins your savings and is counted at 2.5% on your zakat date. On voluntary contributions scholars differ, and many say zakat is due on them every year.[/myzt_answer]
<p>Enter your cash and bank balances here. Leave out a compulsory fund you cannot yet withdraw if you follow the view below; add a fund you have received, or your voluntary part if your scholar counts it, to the bank box.</p>
[zakat_calculator tiles="bank,cash"]
<h2>Why is a provident fund treated differently?</h2>
<p>Zakat is due on wealth you own fully and can use. A government servant's GP fund and a company's provident fund are built from deductions from salary that you cannot touch until retirement or until a set event, plus the employer's contribution and any profit credited. The question is whether that balance is already yours.</p>
<p>The view most widely quoted in Pakistan comes from Mufti Muhammad Shafi, the Grand Mufti of Pakistan, in his treatise on the provident fund. He held that the compulsorily deducted salary is not yet in the employee's ownership and possession; it is a sum the employer owes, which becomes the employee's when it is paid. On this view:</p>
<ul>
<li><strong>No zakat while it sits in the fund,</strong> including the employer's share and the amount credited to it.</li>
<li><strong>No zakat for past years</strong> when you finally receive it.</li>
<li><strong>Once received,</strong> it is ordinary money. If you already have a zakat date, in the Hanafi madhab it joins your savings and is counted on that date; if not, your zakat year starts from when your wealth reaches the nisab.</li>
</ul>
<p>Many Deobandi muftis and darul-iftas in Pakistan give this answer. Scholars elsewhere, and some contemporary scholars in Pakistan, reason differently, as explained below.</p>
<h2>What about voluntary contributions?</h2>
<p>Many employees choose to put in more than the compulsory rate, or join a fund that is optional. Here scholars differ:</p>
<ul>
<li>Many Hanafi muftis say that money you choose to put in is like money you hand to an agent: it remains your wealth, so zakat is due on the voluntary part every year, along with your other savings.</li>
<li>Some treat the whole fund the same way once it is governed by the same rules and cannot be withdrawn.</li>
<li>If the fund lets you withdraw your balance whenever you wish, many scholars, Hanafi and others, say it is effectively in your control and is zakatable each year.</li>
</ul>
<p>Mufti Muhammad Shafi's treatise also discusses the extra amount the fund credits on balances, and whether taking it is permissible, especially on the voluntary part. That is a halal-and-haram question separate from zakat; ask your scholar about it.</p>
<h2>Pension, EOBI, gratuity and commutation</h2>
<p>A pension, EOBI old-age benefit, gratuity or commutation you have not yet received is not in your ownership. There is no zakat on it, and none for past years. Once the money reaches you, it is counted with your other savings on your zakat date. Monthly pension that you spend carries no zakat, in the same way as a salary; see <a href="/zakat-on-salary/">zakat on salary</a>.</p>
<h2>Worked example: a retired officer</h2>
<p>Tariq Sahib retired from a government department and follows the Hanafi madhab. His GP fund was made up only of compulsory deductions. Two months before his zakat date he received:</p>
<figure class="wp-block-table"><table><thead><tr><th>Item</th><th>Amount</th><th>Zakat now?</th></tr></thead><tbody>
<tr><td>GP fund final payment</td><td>Rs 35,00,000</td><td>Yes, joined to his savings</td></tr>
<tr><td>Commutation of pension</td><td>Rs 20,00,000</td><td>Yes, joined to his savings</td></tr>
<tr><td>Earlier savings in the bank</td><td>Rs 5,00,000</td><td>Yes</td></tr>
<tr><td>Zakat for the past 30 years of GP fund</td><td>-</td><td>None, in Mufti Muhammad Shafi's view</td></tr>
</tbody></table></figure>
<p>He has had savings above the nisab for years, so his zakat date stays the same. On that date he has Rs 35,00,000 + Rs 20,00,000 + Rs 5,00,000 = Rs 60,00,000, if none of it has been spent. Zakat is 2.5% = <strong>Rs 1,50,000</strong>. Had he put Rs 5,000 a month into the fund voluntarily, his scholar might have told him zakat was due on that part every year, and he would need to work out those past years; see <a href="/missed-zakat-past-years/">missed zakat for past years</a>.</p>
<p>If he puts the money in National Savings certificates, it stays zakatable; see <a href="/zakat-on-savings-certificates/">zakat on savings certificates</a>.</p>
<h2>What does each madhab say about provident fund?</h2>
<p>Provident funds are modern, so these are contemporary applications of each school's rules on wealth that is owed to you but not yet in your hands.</p>
<ul>
<li><strong>Hanafi:</strong> many Pakistani and Indian Hanafi muftis, following Mufti Muhammad Shafi, say no zakat on compulsory deductions, the employer's share or profit until received, and none for past years. Many of them say zakat is due yearly on voluntary contributions. A fund you can freely withdraw is treated as your wealth by many.</li>
<li><strong>Shafi'i:</strong> classical Shafi'i rules count a debt owed by a solvent party that you can claim, and require zakat for past years when a delayed sum is received. Contemporary Shafi'i scholars differ on whether a locked retirement fund is such a debt; many treat money you have no right to withdraw as not zakatable until received. Ask a Shafi'i scholar.</li>
<li><strong>Maliki:</strong> for money owed to you that you could not use, the Maliki school pays zakat for one year only when it is received. Contemporary Maliki scholars may apply this to a retirement fund; confirm with a scholar.</li>
<li><strong>Hanbali:</strong> like the Shafi'i school, classical Hanbali rules count a recoverable debt and pay past years on receipt. Contemporary Hanbali and Saudi scholars differ on locked retirement funds, and some say no zakat is due until the money can be withdrawn.</li>
<li><strong>Ahl-e-Hadith:</strong> we have not found a Pakistani Ahl-e-Hadith fatwa that settles this clearly. Ask your scholar; the <a href="/ahl-e-hadith-zakat-calculator/">Ahl-e-Hadith calculator</a> will count whatever you enter.</li>
<li><strong>Shia (Ayatollah Sistani):</strong> no zakat on money, so no zakat on a provident fund. Khums applies to income; ask your marja's office how and when khums applies to fund payments and pension, and use the <a href="/khums-calculator/">khums calculator</a>.</li>
</ul>
<h2>Is zakat deducted from GP fund or provident fund?</h2>
<p>Pakistan's Zakat and Ushr Ordinance 1980 provides for zakat to be deducted at source from a range of savings and investments, and people who file a CZ-50 declaration are exempt from those deductions. Whether anything is deducted from your own GP fund or provident fund depends on the fund and has changed over time, so check your fund statement. Anything actually deducted counts as zakat paid; enter it under <strong>Already paid</strong> in the calculator. See <a href="/bank-zakat-deduction-pakistan/">bank zakat deduction in Pakistan</a> for how CZ-50 works.</p>
<p>This page explains well-known views to help you calculate; it is not a fatwa. Because scholars differ on this topic, ask a qualified scholar you trust about your fund.</p>
[myzt_faq]
HTML
		. $author . '[myzt_related slugs="zakat-on-salary,zakat-calculator-pakistan,missed-zakat-past-years,hawl-zakat-due-date"]',
		'faq'   => array(
			array( 'q' => 'Is zakat due on GP fund every year?', 'a' => 'On the compulsory part, many Hanafi muftis in Pakistan, following Mufti Muhammad Shafi, say no: zakat is due only after you receive it, and not for past years. Other scholars differ, especially on voluntary contributions.' ),
			array( 'q' => 'GP fund par zakat hai?', 'a' => 'Bahut se Hanafi mufti sahiban (Mufti Muhammad Shafi ki raye ke mutabiq) kehte hain ke lazmi katoti wale GP fund par wusooli se pehle zakat nahi, aur milne par guzre saalon ki zakat bhi nahi. Milne ke baad yeh baqi bachat mein shamil ho kar zakat ki tareekh par gina jayega.' ),
			array( 'q' => 'Provident fund ki zakat kab deni hai?', 'a' => 'Jab fund ki raqam aap ko mil jaye aur aap ki zakat ki tareekh par aap ke paas ho, tab baqi bachat ke saath 2.5%. Apni marzi se kataye gaye hisse par bahut se ulama har saal zakat batate hain, is liye apne aalim se poochein.' ),
			array( 'q' => 'Is zakat due on pension, EOBI or gratuity not yet received?', 'a' => 'No. Money you have not received is not yet yours. Once it is paid to you, it is counted with your savings on your zakat date.' ),
			array( 'q' => 'Is zakat due on my voluntary provident fund contributions?', 'a' => 'Many Hanafi muftis say yes, every year, because you chose to put that money in and it remains yours. Some scholars treat it like the compulsory part. Ask your scholar.' ),
		),
	);

	return $p;
}
