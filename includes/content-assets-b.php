<?php
/**
 * Asset pages, set B: crypto, committee (BC), overseas Pakistanis and India.
 * {year}, {cyear}, {fyear} and {rate:TYPE} in titles and descriptions are filled at runtime (MYZT_SEO::fill).
 *
 * @package MyZakatTool
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function myzt_content_assets_b() {
	$author = '[myzt_author]';
	$p      = array();

	/* ------------------------------------------------------------------ */
	$p['zakat-on-crypto'] = array(
		'title' => 'Zakat on Crypto',
		'seo'   => 'Zakat on Crypto {year}: Bitcoin, Stablecoins & Staking',
		'desc'  => 'Zakat on Bitcoin and other crypto: 2.5% of market value on your zakat date for coins held to trade or invest. Stablecoins, staking, mining and each madhab.',
		'nav'   => 'Zakat on Crypto',
		'blurb' => 'Bitcoin, stablecoins',
		'hub'   => 'calculators',
		'llms'  => true,
		'content' => <<<'HTML'
[myzt_answer q="Is zakat due on crypto?"]Most contemporary scholars who accept cryptocurrency as property treat coins held to trade or invest like trade goods: zakat is 2.5% of their market value on your zakat date, added to your other wealth, if the total reaches the nisab. Stablecoins are treated like cash. Scholars differ on crypto itself, so follow the scholar you trust.[/myzt_answer]
<p>Open the <strong>Shares</strong> tile below: the crypto field is inside it. Enter the value of your coins in your own currency on your zakat date, together with your bank balance and anything else you own.</p>
[zakat_calculator tiles="shares,bank"]
<h2>How do scholars treat crypto for zakat?</h2>
<p>Bitcoin, Ethereum and other coins are new, so there is no ruling on them in the classical books. Contemporary scholars have reached different conclusions:</p>
<ul>
<li><strong>Crypto as property or trade goods.</strong> Many contemporary scholars who accept crypto as something that can be owned and sold say that coins bought to sell later at a profit, or held as an investment, are like trade goods (<em>'urud al-tijarah</em>). Their zakat is 2.5% of the market value on your zakat date. This is the view the calculator applies.</li>
<li><strong>Crypto as money.</strong> Some scholars treat widely used coins as a kind of money. The result is the same in practice: their value is added to your cash and is zakatable at 2.5%.</li>
<li><strong>Crypto as impermissible.</strong> Other scholars and fatwa bodies, including some in South Asia and the Gulf, have said that dealing in cryptocurrency is not permissible because of its uncertainty (<em>gharar</em>), speculation or lack of a lawful issuer. They generally advise getting out of it. If you follow such a scholar and still hold coins, ask them directly how to treat their value for zakat; do not assume it can simply be left out.</li>
</ul>
<p>We do not take a side on whether crypto is permissible. This page only explains how zakat is worked out by those who count it. On our <a href="/methodology/">methodology</a> page we explain that counting crypto at market value is our reading of the general rule on money and trade goods; we do not cite one specific fatwa for it.</p>
<h2>What value do I use?</h2>
<ul>
<li><strong>Market value on your zakat date,</strong> not what you paid for the coins. If Bitcoin has fallen since you bought it, use the lower price; if it has risen, use the higher one.</li>
<li><strong>In your own currency.</strong> Exchanges quote in US dollars or USDT. Convert the total into the currency you use for the rest of your zakat at that day's rate, so it can be added to your cash and gold and compared with the nisab.</li>
<li><strong>All your wallets and exchanges.</strong> Coins on an exchange, in a hardware wallet or in a self-custody app are all yours. Coins locked in a staking or savings product are still yours.</li>
<li><strong>Selling costs:</strong> some scholars allow you to use the price you would actually receive after the exchange's fee. Use the figure a sale would really give you.</li>
</ul>
<h2>Stablecoins, staking and mining</h2>
<ul>
<li><strong>Stablecoins</strong> such as USDT and USDC are designed to track a currency. They are commonly treated like cash in that currency: count their face value on your zakat date.</li>
<li><strong>Staking rewards and airdrops</strong> become yours when they are credited. Add whatever you still hold to your other wealth on your zakat date. In the Hanafi madhab new wealth of the same kind joins the year of the wealth you already have, so it does not need its own year (see <a href="/hawl-zakat-due-date/">hawl and your zakat date</a>).</li>
<li><strong>Mining:</strong> the machines you use to mine are equipment, like tools in a workshop, and are not zakatable. The coins you have mined and still hold are counted at market value.</li>
<li><strong>Coins lost or locked out of reach:</strong> if you have lost the keys and cannot get the coins back, many scholars treat them like wealth you cannot reach; ask your scholar.</li>
</ul>
<h2>Worked example</h2>
<p>Bilal follows the Hanafi madhab. On his zakat date he holds 0.05 BTC, 2 ETH and 600 USDT, plus Rs 2,00,000 in his bank account. He owes nothing that is due now. Take example prices on that day of Rs 2,50,00,000 for 1 BTC and Rs 9,00,000 for 1 ETH, and Rs 280 for 1 USDT.</p>
<ul>
<li>Bitcoin: 0.05 x Rs 2,50,00,000 = Rs 12,50,000.</li>
<li>Ethereum: 2 x Rs 9,00,000 = Rs 18,00,000.</li>
<li>USDT: 600 x Rs 280 = Rs 1,68,000.</li>
<li>Bank: Rs 2,00,000.</li>
</ul>
<p>Total: Rs 34,18,000, well above the silver nisab of about [myzt_rate type="nisab-silver" currency="PKR"] today. Zakat is 2.5% = <strong>Rs 85,450</strong>. These prices are only for the example; use the real prices on your own zakat date. He may pay in rupees; he does not have to pay in crypto.</p>
<h2>What does each madhab say about zakat on crypto?</h2>
<p>None of the four schools has a classical ruling on crypto. What differs is how each school's general rules on trade goods, debts and the nisab apply once crypto is treated as a trade good:</p>
<ul>
<li><strong>Hanafi:</strong> coins held to sell or as an investment are counted at market value each year with cash and gold, debts due now are subtracted, and the total is compared with the silver nisab. See the <a href="/hanafi-zakat-calculator/">Hanafi zakat calculator</a>.</li>
<li><strong>Shafi'i:</strong> goods count as trade goods when they were bought with the intention of trade. Their value is checked against the nisab used for cash (gold in Malaysia and Singapore) and debts are not subtracted in the relied-upon view. See the <a href="/shafi-zakat-calculator/">Shafi'i calculator</a>.</li>
<li><strong>Maliki:</strong> classical Maliki fiqh separates an active trader (<em>mudir</em>), who values stock every year, from a long-term holder waiting for a price rise (<em>muhtakir</em>), who pays zakat on the goods once, for one year, when they are sold. Contemporary Maliki scholars differ on how this applies to crypto, so ask yours. Debts are subtracted from cash and trade goods.</li>
<li><strong>Hanbali:</strong> trade goods are valued every year at market price, cash and trade goods are added together, and debts are subtracted. The lower of the two nisabs, which is better for the poor, applies to cash.</li>
<li><strong>Ahl-e-Hadith:</strong> our calculator follows the Saudi Permanent Committee and Shaykh Ibn Uthaymeen: trade goods and money are added and measured by the lower nisab, and debts are not subtracted. Some Saudi scholars followed by Ahl-e-Hadith readers have warned against dealing in crypto at all, so ask your own scholar.</li>
<li><strong>Shia (Ayatollah Sistani):</strong> there is no zakat on paper money, shares or crypto. Instead, khums (20%) is due on the surplus of your year, which includes crypto bought from income and still held on your khums date at its market value. Use the <a href="/khums-calculator/">khums calculator</a>.</li>
</ul>
<h2>Crypto and the law in Pakistan</h2>
<p>Pakistan's rules on virtual assets have been changing in recent years, and the government has set up bodies to look at how they should be regulated. This page is not legal or tax advice and does not say whether you should buy crypto. Zakat is a separate question: if you own coins with a market value, they are part of your wealth on your zakat date in the views explained above. Banks do not deduct zakat on crypto, so you pay it yourself.</p>
<p>For shares, mutual funds and ETFs, see <a href="/zakat-on-shares/">zakat on shares</a>. For the general rules on what to count, see the <a href="/">main zakat calculator</a> and <a href="/nisab/">nisab today</a>.</p>
<p>This is not a fatwa. Scholars differ on crypto, so ask a qualified scholar you trust about your own holdings.</p>
[myzt_faq]
HTML
		. $author . '[myzt_related slugs="zakat-on-shares,business-zakat-calculator,nisab,hawl-zakat-due-date"]',
		'faq'   => array(
			array( 'q' => 'How much zakat is due on Bitcoin?', 'a' => 'In the view of scholars who treat crypto as a trade good, 2.5% of its market value on your zakat date, added to your other wealth, if the total reaches the nisab.' ),
			array( 'q' => 'Do I use the price I paid or today\'s price?', 'a' => 'The market price on your zakat date, converted into your own currency at that day\'s rate. What you paid does not matter.' ),
			array( 'q' => 'Is zakat due on USDT and other stablecoins?', 'a' => 'They are commonly treated like cash in the currency they track: count their face value on your zakat date with your other money.' ),
			array( 'q' => 'Crypto par zakat hai?', 'a' => 'Jo ulama crypto ko maal maante hain un ki aksariyat ke nazdeek bechne ya investment ke liye rakhe coins tijarati maal ki tarah hain: zakat ki tareekh par market value ka 2.5%. Kuch ulama crypto ko hi najaiz kehte hain, is liye apne aalim se poochein.' ),
			array( 'q' => 'Staking ke reward par zakat kab hai?', 'a' => 'Reward milte hi aap ka maal ban jata hai. Zakat ki tareekh par jitna bacha ho use baqi maal ke saath jod lein; Hanafi fiqh mein us ke liye alag saal zaroori nahi.' ),
		),
	);

	/* ------------------------------------------------------------------ */
	$p['zakat-on-committee'] = array(
		'title' => 'Zakat on Committee (BC)',
		'seo'   => 'Zakat on Committee (BC) {year}: Before & After Payout',
		'desc'  => 'Zakat on a committee (BC, bisi): instalments paid in are counted before you get the payout; after it, the instalments you still owe are a debt. Example.',
		'nav'   => 'Zakat on Committee',
		'blurb' => 'BC, before and after payout',
		'hub'   => 'calculators',
		'llms'  => true,
		'content' => <<<'HTML'
[myzt_answer q="Is zakat due on committee (BC) money?"]Yes. Before you receive the committee, the instalments you have paid in are money owed back to you and are counted in your zakat. After you receive it, count what is left of the payout, and treat the instalments you still have to pay as a debt, which Hanafi, Maliki and Hanbali scholars subtract and Shafi'i and Ahl-e-Hadith scholars do not.[/myzt_answer]
<p>The calculator below opens with the <strong>Committee</strong>, <strong>Bank</strong> and <strong>Debts</strong> tiles. Enter what you have paid in so far, your other savings, and, if you have already received the payout, the instalments you still owe.</p>
[zakat_calculator tiles="committee,bank,debts" currency="PKR"]
<h2>What is a committee?</h2>
<p>A committee, also called BC or bisi, is a rotating savings group common in Pakistan and India. Each member pays a fixed instalment every month, and each month one member, picked by turn or by draw, receives the whole pot. With 12 members paying Rs 10,000 a month, each member receives Rs 1,20,000 once during the year and pays in Rs 1,20,000 over the twelve months. Nobody earns interest; the committee is simply a way to save and to get a lump sum earlier or later.</p>
<p>For zakat, what matters is where you stand on your own zakat date: have you received your payout yet or not?</p>
<h2>Before you receive the payout</h2>
<p>Every instalment you have paid in is still your money. It is held by the organiser and will come back to you when your turn comes, so it is a debt owed to you by people who are expected to pay. Count the full amount you have paid in so far, together with your cash, bank balances and gold.</p>
<ul>
<li>Do not count the instalments you have not paid yet; that money is still in your bank account or wallet and is counted there.</li>
<li>Do not count the full Rs 1,20,000 pot you will receive later; only what you have paid in.</li>
</ul>
<p>The Pakistan zakat calculator applies this same rule: "the amount you have paid in so far is your money and is zakatable". On our <a href="/methodology/">methodology</a> page we explain that this is our reading of the general rule on money owed to you; we do not cite a specific fatwa on committees.</p>
<h2>After you receive the payout</h2>
<p>Once you have the pot, two things change:</p>
<ol>
<li><strong>Whatever is left of the payout</strong> on your zakat date is cash or savings like any other and is counted. If you spent it on a wedding, a car or a house, what was spent is gone and is not counted.</li>
<li><strong>The instalments you still have to pay</strong> are now a debt you owe to the other members. Whether you subtract them depends on your madhab, as set out below.</li>
</ol>
<h2>Worked example: a Rs 10,000 x 12 committee</h2>
<p>Hina in Lahore is in a 12-member committee of Rs 10,000 a month. Her zakat date falls after the seventh instalment. She also has Rs 6,00,000 in her savings account. Assume her total is above the nisab, which today is about [myzt_rate type="nisab-silver" currency="PKR"] (silver).</p>
<p><strong>Case A: her turn has not come yet.</strong> She has paid 7 x Rs 10,000 = Rs 70,000. Her zakatable wealth is Rs 6,00,000 + Rs 70,000 = Rs 6,70,000, and zakat is 2.5% = <strong>Rs 16,750</strong> in the Hanafi, Maliki, Hanbali and Ahl-e-Hadith calculations, which use the silver nisab (or the lower of the two) for cash. The Shafi'i calculation uses the gold nisab, about [myzt_rate type="nisab-gold" currency="PKR"] today, so at Rs 6,70,000 nothing is due unless your Shafi'i scholar uses the silver nisab. The Shia view is below.</p>
<p><strong>Case B: she received Rs 1,20,000 in month four.</strong> She spent Rs 20,000 of it, so Rs 1,00,000 is left. She still owes 5 x Rs 10,000 = Rs 50,000 in instalments.</p>
<ul>
<li><strong>Hanafi, Maliki and Hanbali:</strong> Rs 6,00,000 + Rs 1,00,000 - Rs 50,000 = Rs 6,50,000. Zakat is <strong>Rs 16,250</strong>.</li>
<li><strong>Ahl-e-Hadith:</strong> the debt is not subtracted, so Rs 7,00,000 is counted. Zakat is <strong>Rs 17,500</strong>.</li>
<li><strong>Shafi'i:</strong> the debt is not subtracted either, but Rs 7,00,000 is below the gold nisab the Shafi'i calculation uses, so nothing is due (Rs 17,500 only if your scholar uses the silver nisab).</li>
</ul>
<p>Enter the Rs 70,000 (Case A) in the Committee tile, or enter the Rs 1,00,000 left over in the Bank or Cash tile and the Rs 50,000 still owed in the Debts tile (Case B). The calculator applies the debt rule of the madhab you choose.</p>
<h2>What does each madhab say about committee money?</h2>
<ul>
<li><strong>Hanafi:</strong> instalments paid in are money owed to you; zakat is due on them every year, though you may pay it when you receive the money. After the payout, remaining instalments are a debt; contemporary Hanafi scholars subtract debts due in the coming year, which for a one-year committee is all of them. See the <a href="/hanafi-zakat-calculator/">Hanafi calculator</a>.</li>
<li><strong>Shafi'i:</strong> money owed to you that you are sure to get back is counted every year. In the relied-upon position debts do not reduce zakat, so the instalments you still owe are not subtracted.</li>
<li><strong>Maliki:</strong> debts are subtracted from cash and trade goods. For a cash loan you gave, Maliki scholars pay its zakat once, for one year, when it is repaid. Whether a committee contribution is treated like such a loan is a question to ask your scholar; many people simply count it each year.</li>
<li><strong>Hanbali:</strong> zakat on money owed to you by someone who can and will pay is due for every year, but you may pay it when you receive it. Debts are subtracted.</li>
<li><strong>Ahl-e-Hadith:</strong> following the Saudi Permanent Committee, as our calculator does, the money you paid in is counted and debts are not subtracted. A debt that is due now can be paid off before your zakat date, which reduces your cash.</li>
<li><strong>Shia (Ayatollah Sistani):</strong> there is no zakat on cash or committee money. Khums (20%) may be due on savings left from the year's income, and how a committee is treated for khums is a question for your marja's office. Use the <a href="/khums-calculator/">khums calculator</a>.</li>
</ul>
<h2>Common questions people ask</h2>
<ul>
<li><strong>"The organiser holds the money, so who pays?"</strong> Each member pays on their own share. The organiser does not pay zakat on other members' instalments, because that money is not theirs.</li>
<li><strong>"My committee runs across two zakat dates."</strong> Look at your position on each date separately: what you had paid in, or what was left of the payout and what you still owed.</li>
<li><strong>"Does the bank deduct zakat on a committee?"</strong> No. The 1 Ramadan bank deduction only touches savings accounts (see <a href="/bank-zakat-deduction-pakistan/">bank zakat deduction</a>). You pay zakat on committee money yourself.</li>
</ul>
<p>For everything else you own, use the <a href="/zakat-calculator-pakistan/">Pakistan zakat calculator</a>. To find your zakat date, use the <a href="/zakat-date-calculator/">zakat date calculator</a>.</p>
<p>This is not a fatwa. If your situation is unusual, ask a qualified scholar.</p>
[myzt_faq]
HTML
		. $author . '[myzt_related slugs="zakat-calculator-pakistan,zakat-on-1-lakh-rupees,bank-zakat-deduction-pakistan,zakat-on-savings-certificates"]',
		'faq'   => array(
			array( 'q' => 'Committee ke paison par zakat hai?', 'a' => 'Haan. Payout milne se pehle jitni qistein aap jama kara chuke hain woh aap ki raqam hai aur zakat mein shamil hogi. Poora pot nahi, sirf jama shuda raqam.' ),
			array( 'q' => 'Committee mil gayi to zakat kaise nikalein?', 'a' => 'Payout mein se jo bacha hai use shamil karein. Baqi qistein qarz hain: Hanafi, Maliki aur Hanbali fiqh mein minus hongi, Shafi\'i aur Ahl-e-Hadith mein nahi.' ),
			array( 'q' => 'Do I count the whole committee amount before I receive it?', 'a' => 'No. Count only the instalments you have paid in so far. The instalments you have not paid yet are still in your account and are counted there.' ),
			array( 'q' => 'Is zakat due on a Rs 10,000 x 12 committee?', 'a' => 'On what you have paid in by your zakat date, for example Rs 70,000 after seven instalments, added to your other wealth. If the total reaches the nisab, zakat is 2.5% of it.' ),
			array( 'q' => 'BC ki zakat organiser dega?', 'a' => 'Nahi. Har member apne hisse ki zakat khud dega. Organiser ke paas jo doosre members ki raqam hai woh us ki milkiyat nahi.' ),
		),
	);

	/* ------------------------------------------------------------------ */
	$p['zakat-for-overseas-pakistanis'] = array(
		'title' => 'Zakat for Overseas Pakistanis',
		'seo'   => 'Zakat for Overseas Pakistanis {year}: Nisab in SAR, AED',
		'desc'  => 'Zakat for Pakistanis in Saudi Arabia, UAE, Qatar and the UK: which currency and nisab to use, bank deduction, and paying zakat to relatives in Pakistan.',
		'nav'   => 'Overseas Pakistanis',
		'blurb' => 'Gulf, UK, expats',
		'hub'   => 'calculators',
		'llms'  => true,
		'content' => <<<'HTML'
[myzt_answer q="How do overseas Pakistanis calculate zakat?"]Add up everything you own on your zakat date, in Pakistan and abroad, convert it into one currency at that day's rate, and pay 2.5% if the total reaches the nisab. Today the silver nisab is about [myzt_rate type="nisab-silver" currency="SAR"], [myzt_rate type="nisab-silver" currency="AED"] or [myzt_rate type="nisab-silver" currency="PKR"].[/myzt_answer]
<p>The calculator below opens in the currency of the country you are in (riyals in Saudi Arabia, dirhams in the UAE, pounds in the UK, rupees in Pakistan) with the <strong>Bank</strong>, <strong>Cash</strong> and <strong>Gold</strong> tiles open. Tap <em>Change</em> to switch to any other currency, for example rupees if most of your savings are back home; what matters is that every amount is in the same currency.</p>
[zakat_calculator tiles="bank,cash,gold"]
<h2>Nisab today in Gulf, UK and Pakistani currency</h2>
<figure class="wp-block-table"><table><thead><tr><th>Currency</th><th>Silver nisab (612.35 g)</th><th>Gold nisab (87.48 g)</th></tr></thead><tbody>
<tr><td>Saudi riyal (SAR)</td><td>[myzt_rate type="nisab-silver" currency="SAR"]</td><td>[myzt_rate type="nisab-gold" currency="SAR"]</td></tr>
<tr><td>UAE dirham (AED)</td><td>[myzt_rate type="nisab-silver" currency="AED"]</td><td>[myzt_rate type="nisab-gold" currency="AED"]</td></tr>
<tr><td>Qatari riyal (QAR)</td><td>[myzt_rate type="nisab-silver" currency="QAR"]</td><td>[myzt_rate type="nisab-gold" currency="QAR"]</td></tr>
<tr><td>British pound (GBP)</td><td>[myzt_rate type="nisab-silver" currency="GBP"]</td><td>[myzt_rate type="nisab-gold" currency="GBP"]</td></tr>
<tr><td>Pakistani rupee (PKR)</td><td>[myzt_rate type="nisab-silver" currency="PKR"]</td><td>[myzt_rate type="nisab-gold" currency="PKR"]</td></tr>
</tbody></table></figure>
<p>The weights are the same everywhere; only the price changes. Silver and gold are priced at the same international rate in each currency, so the nisab is the same wealth whichever currency you use. Which of the two applies to you depends on your madhab; see <a href="/nisab/">nisab today</a>.</p>
<h2>Which currency should I use?</h2>
<p>Most people working abroad have money in two places: a salary account in Riyadh, Dubai, Doha or London, and savings, gold or a plot back home. Zakat is worked out on all of it together, on one date.</p>
<ul>
<li><strong>Pick one currency for the sum.</strong> Many scholars say to value wealth in the currency of the place where you live, or where most of your wealth is. In practice, use the currency you think in. Because the nisab moves with the same gold and silver price, the answer is the same.</li>
<li><strong>Convert at the rate on your zakat date,</strong> not the rate when you sent the money home or the rate you hope to get. Use an ordinary market rate; the calculator does this for you when you switch currency.</li>
<li><strong>Count wealth in both countries.</strong> Your bank balance abroad, your Pakistani accounts, cash at home with your family if it is yours, gold kept in Pakistan, and any plot bought to sell are all part of the total.</li>
<li><strong>Keep the same zakat date</strong> wherever you live. Zakat follows the lunar year (hawl) of your wealth, not your visa or your tax year. See <a href="/hawl-zakat-due-date/">hawl and your zakat date</a>.</li>
</ul>
<h2>Does a Pakistani bank deduct zakat from overseas Pakistanis?</h2>
<p>The 1 Ramadan bank deduction under the Zakat and Ushr Ordinance 1980 applies to rupee savings and similar accounts that are at or above the government's deduction nisab. Foreign currency accounts are generally not subject to the compulsory deduction. Whether a rupee savings account held by a non-resident is deducted depends on how the bank has classified the account; if you are not sure, check with your bank before Ramadan.</p>
<p>Either way, the bank deduction is not your full zakat. If something was deducted, subtract it from the total you calculate. If nothing was deducted, you pay all of it yourself. The guide to <a href="/bank-zakat-deduction-pakistan/">bank zakat deduction in Pakistan</a> explains the deduction, the CZ-50 form and how to avoid paying twice.</p>
<p>Gulf countries do not deduct zakat from employees' personal accounts, and neither does the UK, so zakat on your savings abroad is always yours to pay.</p>
<h2>Worked example</h2>
<p>Imran works in Jeddah and follows the Hanafi madhab. On his zakat date he has SAR 30,000 in his Saudi account and SAR 2,000 in cash. In Pakistan he has Rs 4,00,000 in a savings account (the bank deducted nothing this year) and his wife's 3 tola of 22K gold jewellery, which is hers, not his. He owes a friend SAR 5,000, due now. Take an example rate of Rs 75 to one riyal.</p>
<ul>
<li>Saudi bank and cash: SAR 32,000.</li>
<li>Pakistani savings: Rs 4,00,000 / 75 = SAR 5,333.</li>
<li>His wife's jewellery is not counted in his zakat; she owns it, so it is part of her own zakat.</li>
<li>Debt due now: minus SAR 5,000 (Hanafi).</li>
</ul>
<p>Total: SAR 32,333, above the silver nisab of about [myzt_rate type="nisab-silver" currency="SAR"] today. Zakat is 2.5% = <strong>SAR 808</strong>, about Rs 60,600 at the example rate. He may pay it in Saudi Arabia, in Pakistan, or partly in each. In the Ahl-e-Hadith calculation the SAR 5,000 debt is not subtracted, so zakat would be SAR 933. The Shafi'i calculation does not subtract it either, but SAR 37,333 is below the gold nisab it uses (about [myzt_rate type="nisab-gold" currency="SAR"] today), so nothing would be due unless his scholar uses the silver nisab.</p>
<h2>Can I send my zakat to relatives in Pakistan?</h2>
<p>Yes, in the views most Pakistanis follow, if the relatives are eligible to receive zakat. Brothers, sisters, uncles, aunts, cousins and in-laws who are poor or in debt can receive your zakat, with the double reward of charity and family ties. But some people can never receive your zakat:</p>
<ul>
<li>Your parents, grandparents, children and grandchildren.</li>
<li>Your wife (a husband cannot give zakat to his wife).</li>
<li>Anyone who owns wealth at or above the nisab beyond their needs.</li>
</ul>
<p>The money you send home every month for your family's expenses is not zakat. It is support you give anyway, and it does not count even if the person happens to be eligible, unless you intended it as zakat when you gave it and the person is someone who may receive zakat. Zakat needs the intention at the time of giving or when you set the amount aside. See <a href="/who-can-receive-zakat/">who can receive zakat</a> for the full list.</p>
<h2>Can I pay zakat in another country? What each madhab says</h2>
<p>Classical scholars discussed sending zakat away from the place where the wealth is (<em>naql al-zakat</em>). Contemporary scholars often allow it when the need is greater elsewhere or the recipients are relatives, but the schools start from different positions:</p>
<ul>
<li><strong>Hanafi:</strong> zakat sent to another country is valid. Hanafi scholars dislike it without a reason, but sending it to poor relatives or to people in greater need is allowed without dislike. See the <a href="/hanafi-zakat-calculator/">Hanafi calculator</a>.</li>
<li><strong>Shafi'i:</strong> the relied-upon position is that zakat should be given in the land where the wealth is, if there are eligible people there. Many contemporary Shafi'i scholars allow sending it where the need is greater; ask yours.</li>
<li><strong>Maliki:</strong> zakat is given locally, but it may be sent elsewhere when people there are in greater need.</li>
<li><strong>Hanbali:</strong> the school's position is not to send zakat a long distance when there are eligible people locally, although it still counts if sent. Many contemporary Hanbali scholars allow it for relatives or greater need.</li>
<li><strong>Ahl-e-Hadith:</strong> scholars followed by Ahl-e-Hadith readers, such as those of the Saudi Permanent Committee, generally allow sending zakat to another country for a valid reason such as poor relatives or greater need.</li>
<li><strong>Shia (Ayatollah Sistani):</strong> Shia followers of Ayatollah Sistani do not pay zakat on cash, bank balances or jewellery; they pay khums (20%) on the year's surplus. Sahm-e-imam goes to the marja or an authorised representative, and sahm-e-sadat to needy sayyids, following the office's rules. Use the <a href="/khums-calculator/">khums calculator</a>.</li>
</ul>
<p>For everything in Pakistan in rupees and tola, the <a href="/zakat-calculator-pakistan/">Pakistan zakat calculator</a> has fields for committees, prize bonds and plots. If you have a Gulf or UK salary, see <a href="/zakat-on-salary/">zakat on salary</a>.</p>
<p>This is not a fatwa. For questions about your own family or accounts, ask a qualified scholar.</p>
[myzt_faq]
HTML
		. $author . '[myzt_related slugs="zakat-calculator-pakistan,who-can-receive-zakat,bank-zakat-deduction-pakistan,nisab"]',
		'faq'   => array(
			array( 'q' => 'Which currency should I use for zakat if I live in Saudi Arabia?', 'a' => 'Use one currency for everything, usually riyals if most of your wealth is there, and convert your Pakistani savings at the rate on your zakat date. The nisab moves with the same gold and silver price, so the result is the same in any currency.' ),
			array( 'q' => 'Kya bahar rehne wale Pakistani apni zakat Pakistan mein de sakte hain?', 'a' => 'Haan, mustahiq rishtedaron ya ghareebon ko. Hanafi fiqh mein rishtedaron ya zyada zaroorat mandon ko bhejna bila karahat jaiz hai. Walidain, dada dadi, nana nani, aulad aur biwi ko zakat nahi de sakte.' ),
			array( 'q' => 'Ghar har mahine jo paise bhejta hoon kya woh zakat hai?', 'a' => 'Nahi, jab tak dete waqt zakat ki niyyat na ho aur lene wala zakat ka mustahiq na ho. Walidain aur aulad ko bheje gaye paise kabhi zakat nahi bante.' ),
			array( 'q' => 'Does my Pakistani bank deduct zakat if I live abroad?', 'a' => 'Foreign currency accounts are generally not subject to the compulsory 1 Ramadan deduction. For a rupee savings account held as a non-resident, check with your bank. Any deduction counts towards your zakat; pay the rest yourself.' ),
			array( 'q' => 'Do I count my savings in both countries?', 'a' => 'Yes. Zakat is on all the wealth you own on your zakat date, wherever it is. Convert it into one currency at that day\'s rate and add it up.' ),
		),
	);

	/* ------------------------------------------------------------------ */
	$p['zakat-calculator-india'] = array(
		'title' => 'Zakat Calculator India',
		'seo'   => 'Zakat Calculator India {year}: Nisab in Rupees (INR) Today',
		'desc'  => 'Zakat calculator in Indian rupees with today\'s gold and silver rate per gram and 10 g. Nisab in INR, 22K 916 jewellery, Hanafi and Ahl-e-Hadith rules.',
		'nav'   => 'Zakat Calculator India',
		'blurb' => 'INR, grams, 916 gold',
		'hub'   => 'calculators',
		'llms'  => true,
		'content' => <<<'HTML'
[myzt_answer q="What is the nisab for zakat in India today?"]The silver nisab (612.35 g) is about [myzt_rate type="nisab-silver" currency="INR"] and the gold nisab (87.48 g) is about [myzt_rate type="nisab-gold" currency="INR"] today. If your zakatable wealth reaches the nisab that applies to you, zakat is 2.5% of it.[/myzt_answer]
<p>This zakat calculator works in Indian rupees and grams. It opens with the <strong>Cash</strong>, <strong>Bank</strong> and <strong>Gold</strong> tiles, starts with Hanafi fiqh, and uses today's international gold and silver price converted to INR. You can enter your own jeweller's rate instead.</p>
[zakat_calculator tiles="cash,bank,gold" currency="INR" unit="gram"]
<p>Prefer Urdu? Use the <a href="/zakat-calculator-urdu/">Urdu zakat calculator</a>, which you can also switch to rupees and grams.</p>
<h2>Zakat calculator in rupees: India or Pakistan?</h2>
<p>Search for "zakat calculator in rupees" and most results are made for Pakistan: tola, Pakistani rupees and the 1 Ramadan bank deduction. India is different in three ways:</p>
<ul>
<li><strong>Currency:</strong> Indian rupees (INR, ₹). The calculator shows amounts with lakh grouping, such as ₹1,00,000.</li>
<li><strong>Weights:</strong> Indian jewellers quote gold per gram and per 10 g. The tola is rarely used today, so enter your jewellery in grams.</li>
<li><strong>No bank deduction:</strong> India has no government zakat collection and banks do not deduct zakat. Every Muslim works out and pays their own zakat, directly or through a trusted madrasa, masjid or charity.</li>
</ul>
<p>If you live in Pakistan, use the <a href="/zakat-calculator-pakistan/">Pakistan zakat calculator</a> instead.</p>
<h2>Gold rate per gram, 10 g and 916 hallmark</h2>
<ul>
<li><strong>Nisab weights:</strong> 87.48 g of gold or 612.35 g of silver. In tola that is 7.5 and 52.5 tola (1 tola = 11.6638 g), but you do not need tola at all.</li>
<li><strong>10 g quotes:</strong> if your jeweller or newspaper quotes ₹ per 10 g, divide by 10 to get the rate per gram before entering it.</li>
<li><strong>22K and the 916 hallmark:</strong> most Indian jewellery is 22 carat, hallmarked "916", which means 91.6% pure gold, very close to 22/24. Zakat is on the pure gold: choose 22K in the calculator and it does this for you. 18K jewellery is marked 750 (75% pure).</li>
<li><strong>Making charges and stones:</strong> what you paid for making, and the weight of stones, are not gold. Use the gold weight only, at today's rate, not the bill you paid.</li>
</ul>
<p>For jewellery only, the <a href="/zakat-on-gold-calculator/">zakat on gold calculator</a> works in grams and carats, and <a href="/gold-rate-today/">gold rate today</a> shows the price in INR.</p>
<h2>Worked example in rupees</h2>
<p>Farhana lives in Hyderabad and follows the Hanafi madhab. On her zakat date she has ₹3,50,000 in her savings account, ₹50,000 in cash at home and 40 g of 22K (916) jewellery that she wears. She has a credit card bill of ₹40,000 due this month. Take an example rate of ₹12,000 a gram for 24K gold, so 22K is ₹11,000 a gram.</p>
<ul>
<li>Bank and cash: ₹3,50,000 + ₹50,000 = ₹4,00,000.</li>
<li>Jewellery: 40 g x ₹11,000 = ₹4,40,000.</li>
<li>Total: ₹8,40,000. Minus the bill due now: ₹8,00,000.</li>
</ul>
<p>This is above the silver nisab, so her zakat is 2.5% of ₹8,00,000 = <strong>₹20,000</strong>. In the Shafi'i calculation her worn jewellery is exempt and the bill is not subtracted, so ₹4,00,000 is checked against the nisab her scholars use. The example rate is not today's rate; the calculator above uses the live one.</p>
<h2>Which nisab and rules apply in India? Each madhab</h2>
<p>Most Muslims in India follow the Hanafi madhab, through the Deobandi and Barelvi traditions, and the calculator starts there. Ahl-e-Hadith communities are common in many states, many Muslims on the Konkan and Malabar coasts follow the Shafi'i school, and there are large Shia communities. Choose your school in the calculator:</p>
<ul>
<li><strong>Hanafi:</strong> cash, gold, silver and trade goods are added and compared with the silver nisab; jewellery is zakatable even if worn daily; debts due now are subtracted (Darul Uloom Deoband, Fatwa 702/702=M/1429 and Fatwa 2310/H=713/th=1431). See the <a href="/hanafi-zakat-calculator/">Hanafi zakat calculator</a>.</li>
<li><strong>Shafi'i:</strong> permissible worn jewellery is exempt, gold and silver are checked separately, and debts do not reduce zakat in the relied-upon position. Which nisab to use for cash is a question for your local scholars. See the <a href="/shafi-zakat-calculator/">Shafi'i calculator</a>.</li>
<li><strong>Maliki:</strong> worn jewellery is exempt, and debts are subtracted from cash, gold, silver and trade goods. Few Indian Muslims follow this school.</li>
<li><strong>Hanbali:</strong> worn jewellery is exempt, debts are subtracted, and the lower of the two nisabs, which is better for the poor (silver today), applies to cash.</li>
<li><strong>Ahl-e-Hadith:</strong> our calculator follows the Saudi Permanent Committee and Shaykh Ibn Uthaymeen, whom many Ahl-e-Hadith readers follow: jewellery is zakatable even if worn, cash is measured by the lower nisab, and debts are not subtracted. We have not found an Indian Ahl-e-Hadith fatwa confirming every point, so check with your own scholar. See the <a href="/ahl-e-hadith-zakat-calculator/">Ahl-e-Hadith calculator</a>.</li>
<li><strong>Shia (Ayatollah Sistani):</strong> no zakat on paper money or on gold jewellery that is not used as currency. Khums (20%) is due on the surplus of the year instead. Use the <a href="/khums-calculator/">khums calculator</a>.</li>
</ul>
<h2>Who can receive zakat in India?</h2>
<p>The eight groups named in Surah at-Tawbah (9:60), mainly the poor and the needy. You cannot give zakat to your parents, grandparents, children or grandchildren, and a husband cannot give it to his wife. Poor brothers, sisters and other relatives may receive it. Zakat is given to eligible Muslims, and Hanafi scholars stress that it must become the recipient's own property. Many people in India pay through madrasas and trusted local organisations; ask how they spend zakat funds. See <a href="/who-can-receive-zakat/">who can receive zakat</a>.</p>
<h2>When to pay</h2>
<p>Zakat is due when your wealth has been at or above the nisab for one lunar year. Many Indian families pay in Ramadan for the extra reward, but your real date is the anniversary of the day you first reached the nisab; the <a href="/zakat-date-calculator/">zakat date calculator</a> finds it. Fitrana (sadaqat al-fitr) is separate and is paid before Eid prayer; see the <a href="/fitrana-calculator/">fitrana calculator</a>.</p>
<p>This is not a fatwa. For questions about your own wealth, ask a qualified scholar or a darul ifta you trust.</p>
[myzt_faq]
HTML
		. $author . '[myzt_related slugs="zakat-on-gold-calculator,hanafi-zakat-calculator,nisab,zakat-calculator-urdu"]',
		'faq'   => array(
			array( 'q' => 'What is the nisab for zakat in India in rupees?', 'a' => 'The value of 612.35 g of silver or 87.48 g of gold at today\'s rate. Hanafi scholars use the silver nisab for cash and mixed wealth. The live INR figures are at the top of this page.' ),
			array( 'q' => 'Does any Indian bank deduct zakat?', 'a' => 'No. India has no government zakat collection, so you work out and pay your zakat yourself.' ),
			array( 'q' => 'How do I calculate zakat on 22K 916 gold?', 'a' => 'Weigh the gold in grams, leaving out stones, and value it at today\'s 22K rate (or 24K rate x 22/24). Zakat is 2.5% of the value once your total reaches the nisab.' ),
			array( 'q' => 'Zakat kitne rupaye par farz hoti hai India mein?', 'a' => 'Jab aap ka zakat wala maal nisab tak pohanch jaye: 612.35 gram chandi ya 87.48 gram sone ki qeemat. Hanafi ulama naqdi aur mile jule maal ke liye chandi ka nisab lete hain. Aaj ki qeemat is page ke upar hai.' ),
			array( 'q' => 'Sone ke zevar par zakat kaise nikalein, gram mein?', 'a' => 'Zevar ka sona gram mein tolein, nag aur making charge chhod kar, aaj ke 22 carat rate se qeemat nikalein aur us ka 2.5% dein. Hanafi fiqh mein pehne hue zevar par bhi zakat hai.' ),
		),
	);

	return $p;
}
