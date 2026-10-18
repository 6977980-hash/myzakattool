<?php
/**
 * Guide posts that support the wirasat (inheritance) calculator: the daughter's share, the wife's
 * and husband's share, orphaned grandchildren under section 4, and zakat on inherited wealth.
 * Loaded by content-posts.php. Every figure in the worked examples matches assets/js/wirasat.js.
 *
 * @package MyZakatTool
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function myzt_content_posts_wirasat() {
	$author = '[myzt_author]';
	return array(
		'daughters-share-in-inheritance' => array(
			'title'   => 'Daughter\'s Share in Inheritance in Islam (Beti ka Hissa)',
			'seo'     => 'Daughter\'s Share in Inheritance: Beti ka Wirasat mein Hissa',
			'desc'    => 'How much a daughter inherits in Islam: alone, with sisters or with brothers, who takes the rest, worked examples in rupees and her rights under Pakistani law.',
			'nav'     => 'Daughter\'s share in inheritance',
			'blurb'   => 'beti ka hissa',
			'content' => <<<'HTML'
[myzt_answer q="How much does a daughter inherit in Islam?"]If the deceased left a son as well, each daughter gets half of what each son gets. If there is no son, one daughter alone gets half of the estate and two or more daughters share two thirds equally. These shares are fixed in the Qur'an (al-Nisa 4:11) and apply in every madhab; the schools differ only on who takes what is left over.[/myzt_answer]
<p>In many families the daughter's share is the one most often delayed, reduced or quietly "gifted" back to her brothers. The Qur'an names it directly, in the same verse that names the son's share, and no custom can cancel it. This guide sets out what a daughter receives in each situation, with worked examples in rupees, and what Pakistani law does when she is denied it. To work out your own family's shares, including land in kanal and marla, use the <a href="/wirasat-calculator/">wirasat calculator</a>.</p>
<h2>The three cases</h2>
<blockquote><p>"Allah instructs you concerning your children: for the male, the like of the portion of two females. But if there are only daughters, two or more, for them is two thirds of what he left; and if there is only one, for her is half." (Surah al-Nisa 4:11)</p></blockquote>
<ol>
<li><strong>With a son:</strong> the children share what is left after the fixed shares (wife or husband, parents), and each son gets twice what each daughter gets. The daughter has no fixed fraction here; she is a residuary heir together with her brothers.</li>
<li><strong>One daughter, no son:</strong> half of the estate.</li>
<li><strong>Two or more daughters, no son:</strong> two thirds of the estate, shared equally among them.</li>
</ol>
<h3>Worked example 1: a son and a daughter together</h3>
<p>Aslam dies leaving Rs 60,00,000, a wife, two sons and one daughter. The wife takes 1/8 because there are children: Rs 7,50,000. The remaining Rs 52,50,000 is divided in five parts (two for each son, one for the daughter): each son gets Rs 21,00,000 and the daughter Rs 10,50,000. Every madhab gives this same answer.</p>
<h3>Worked example 2: only daughters</h3>
<p>Had Aslam left a wife, two daughters and a brother, the wife would still take 1/8 (Rs 7,50,000) and the daughters 2/3 between them (Rs 20,00,000 each). In all four Sunni schools and the Ahl-e-Hadith view the brother, as the nearest male relative, takes the rest: Rs 12,50,000. In Shia Ja'fari fiqh a brother does not inherit at all while there is a child, so the daughters take everything after the wife: Rs 26,25,000 each.</p>
<h2>Who takes what is left after the daughters</h2>
<p>When there are only daughters, part of the estate is left over after their 2/3 or 1/2. In the Sunni schools it goes, in order, to the father, then the paternal grandfather, then brothers, nephews, uncles and cousins on the father's side, following the hadith "give the shares to those entitled to them, and what remains goes to the nearest male relative" (Sahih al-Bukhari 6732). If none of these is alive, the Hanafi and Hanbali schools, and later Shafi'i and Maliki scholars, return the remainder to the daughters and other sharers (<em>radd</em>), never to the husband or wife while another heir exists. The early Shafi'i and Maliki position gave it to the public treasury (<em>bayt al-mal</em>); the calculator notes this. With sisters and daughters together, the sisters take the remainder.</p>
<p>In Ja'fari fiqh daughters and parents are in the first class of heirs, so brothers, uncles and their children inherit nothing while a daughter is alive; whatever is left after the fixed shares returns to the daughters and parents.</p>
<h2>Granddaughters</h2>
<p>A son's daughter takes a daughter's place when there is no son or daughter. With one daughter she receives 1/6, completing the 2/3. Two daughters exclude her, unless she has a brother or a male cousin through a son at her level or below, who makes her a residuary heir with him. A daughter's children do not inherit while closer heirs exist in the Sunni schools. Under Pakistani law the children of a son or daughter who died first can receive their parent's share; see <a href="/orphaned-grandchildren-inheritance/">orphaned grandchildren and section 4</a>.</p>
<h2>Why a son receives twice as much</h2>
<p>The difference follows the duties each one carries. A son must pay mehr when he marries and must support his wife, children and, when needed, his parents and unmarried sisters. A daughter's share is entirely her own: she owes no one maintenance from it, her mehr and her husband's support come on top of it, and she keeps it after marriage. Scholars point out that in several cases a woman inherits as much as a man (a mother and father with children each get 1/6) or more (a man leaving a wife, one daughter and a brother: the daughter takes 1/2, the brother 3/8).</p>
<h2>How daughters lose their share, and why it is not valid</h2>
<ul>
<li><strong>"Haq bakhshwana":</strong> a daughter is asked to sign her share over to her brothers. A gift is valid only when it is freely given; one made under family pressure, often before she even knows what she owns, is widely regarded by scholars as not a true gift, and Pakistani courts have set aside such transfers.</li>
<li><strong>Dowry instead of inheritance:</strong> jahez given at her wedding is a gift from the father in his lifetime. It does not replace her inheritance, which arises only at his death.</li>
<li><strong>Land only to sons:</strong> land is part of the estate like cash. Her share of every kanal and marla belongs to her, even if the family prefers to keep the land together. The heirs may agree that one of them keeps the land and pays her its value.</li>
<li><strong>Gifts to sons in the father's lifetime:</strong> the Prophet ﷺ told Nu'man ibn Bashir's father, who had given one son a gift, "Fear Allah and be fair between your children" (Sahih al-Bukhari 2587). Most scholars say lifetime gifts should be equal between children.</li>
</ul>
<h2>What Pakistani law says</h2>
<p>Section 498A of the Pakistan Penal Code makes it a crime to deprive a woman of her inheritance by deceitful or illegal means, punishable with imprisonment of five to ten years, a fine of ten lakh rupees, or both. The Enforcement of Women's Property Rights Act 2020 lets a woman in Islamabad who is kept out of her inheritance complain to the Ombudsperson (the office that also hears harassment complaints), who can order the property to be handed over. Khyber Pakhtunkhwa has a similar law of 2019. A lawyer can advise on the right route in each province.</p>
<h2>What to do now</h2>
<ol>
<li>List everything the deceased left: cash, bank, land, house, gold and silver, and every debt.</li>
<li>Enter the family in the <a href="/wirasat-calculator/">wirasat calculator</a> (or the <a href="/wirasat-calculator-urdu/">Urdu page</a>) and choose your madhab. Each daughter's share appears in rupees, marla and tola, with the reason.</li>
<li>Download the PDF with the shajra and share table, and show it to a mufti before dividing.</li>
<li>Once she receives her share, it counts with her own wealth for zakat; see <a href="/zakat-on-inherited-wealth/">zakat on inherited wealth</a>.</li>
</ol>
[myzt_faq]
HTML
			. $author . '[myzt_related slugs="wirasat-calculator,wife-husband-share-in-inheritance,orphaned-grandchildren-inheritance,zakat-on-inherited-wealth"]',
			'faq'     => array(
				array( 'q' => 'Beti ka hissa bete se aadha kyun hai?', 'a' => 'Kyun ke bete par mehr aur biwi bachon ka kharch farz hai, jabke beti ka hissa sirf us ka apna hai; us par kisi ka kharch wajib nahi.' ),
				array( 'q' => 'If there are only daughters, do the brothers of the deceased inherit?', 'a' => 'In the Sunni schools, yes: after the daughters\' 2/3 (or 1/2 for one) and the other fixed shares, the father or else the brothers take the rest. In Ja\'fari fiqh they do not; the daughters take it.' ),
				array( 'q' => 'Kya jahez wirasat ka badal hai?', 'a' => 'Nahi. Jahez walid ki zindagi mein tohfa hai; wirasat un ki wafat ke baad ka haq hai aur alag milti hai.' ),
				array( 'q' => 'Can a daughter give up her share?', 'a' => 'After the estate is divided she may freely give her share to anyone, as with anything she owns. A waiver signed under family pressure is not a free gift.' ),
				array( 'q' => 'Does a married daughter still inherit?', 'a' => 'Yes. Marriage does not change her share at all.' ),
			),
		),

		'wife-husband-share-in-inheritance' => array(
			'title'   => 'Wife\'s and Husband\'s Share in Inheritance (Biwi aur Shohar ka Hissa)',
			'seo'     => 'Wife\'s and Husband\'s Share in Inheritance (Biwi ka Hissa)',
			'desc'    => 'How much a wife or husband inherits in Islam, how several wives share, unpaid mehr, divorce and iddah, the Shia rule on land, with a worked example in rupees.',
			'nav'     => 'Wife\'s and husband\'s share',
			'blurb'   => 'biwi shohar ka hissa',
			'content' => <<<'HTML'
[myzt_answer q="How much does a wife inherit from her husband?"]A wife inherits one quarter (1/4) of her husband's estate if he left no children, and one eighth (1/8) if he left a child, by her or by another wife. A husband inherits half (1/2) of his wife's estate if she left no children, and one quarter (1/4) if she did. Several wives share the one quarter or one eighth equally (al-Nisa 4:12).[/myzt_answer]
<p>The spouse's share is the simplest in the law of inheritance, and the one most often mixed up with mehr, dowry and the family house. This guide explains the share itself, what is paid to the widow before it, and the cases in which the schools differ. The <a href="/wirasat-calculator/">wirasat calculator</a> works out the share in rupees, land and gold for your own family.</p>
<h2>The shares</h2>
<figure class="wp-block-table"><table><thead><tr><th>Heir</th><th>No children</th><th>With a child</th></tr></thead><tbody>
<tr><td>Husband (from his wife)</td><td>1/2</td><td>1/4</td></tr>
<tr><td>Wife (from her husband)</td><td>1/4</td><td>1/8</td></tr>
</tbody></table></figure>
<p>"Children" here means any child of the deceased, from this marriage or another, and in the Sunni schools a son's children too. A daughter's children reduce the spouse's share in Ja'fari fiqh but not in the Sunni schools. Two, three or four widows do not each get 1/8: they share the one 1/8 (or 1/4) equally.</p>
<h3>Worked example</h3>
<p>Imran dies leaving Rs 48,00,000, a wife, his mother, a son and a daughter. The wife takes 1/8 (Rs 6,00,000) and the mother 1/6 (Rs 8,00,000). The remaining Rs 34,00,000 goes to the children, the son twice the daughter: Rs 22,66,667 and Rs 11,33,333. A mufti writes this case on a base of 72 parts (wife 9, mother 12, son 34, daughter 17); the calculator's worked sheet shows the same parts.</p>
<h2>Paid to the widow before inheritance: mehr</h2>
<p>Unpaid mehr is a debt the husband owed his wife. It is paid in full from his estate before anything is divided, just like a bank loan, and only then does she take her 1/8 or 1/4 of what remains. A mehr fixed in silver or gold is paid at its value today; the <a href="/haq-mehr-calculator/">haq mehr calculator</a> converts it at the live rate.</p>
<p>When a wife dies, the mehr her husband still owed her becomes part of her own estate. He pays it into her estate, and it is then divided among all her heirs, including him.</p>
<h2>What is not part of the estate</h2>
<p>The wife's jewellery, dowry and gifts are her own property, not her husband's estate, unless they were clearly his. In the same way, a house in the wife's name belongs to her. Only what the deceased owned is divided.</p>
<h2>Divorce, iddah and an unconsummated nikah</h2>
<ul>
<li><strong>Nikah done, rukhsati not yet:</strong> a valid nikah makes them husband and wife, so each inherits from the other.</li>
<li><strong>Revocable divorce (talaq raj'i):</strong> if the husband dies while the wife is still in her iddah, she inherits, because the marriage had not yet ended.</li>
<li><strong>Irrevocable divorce:</strong> once the iddah of a revocable divorce is over, or after an irrevocable divorce, they no longer inherit from each other. If a husband divorces his wife during a fatal illness to keep her out of the inheritance, the Hanafi school still lets her inherit if he dies during her iddah, and the other schools have similar rules; ask a mufti about such a case.</li>
<li><strong>Remarriage of the widow</strong> does not take away a share she has already inherited.</li>
</ul>
<h2>Where the madhabs differ</h2>
<ul>
<li><strong>When there is no other heir:</strong> later Hanafi scholars return the rest of the estate to the husband or wife (<em>radd</em>). The Shafi'i, Maliki and Hanbali schools do not. Our Ahl-e-Hadith setting also returns it, following Ibn Taymiyyah's view, but many scholars do not give the remainder to a spouse, so this is an open question: ask a mufti before dividing. In Ja'fari fiqh a husband alone takes the whole estate, while a wife alone takes her quarter.</li>
<li><strong>Land in Ja'fari fiqh:</strong> a wife does not inherit from the land itself. She inherits from the value of buildings and trees on it and from everything else. The calculator shows her share of land as zero in Ja'fari mode and divides the land among the other heirs.</li>
<li><strong>The parents with a spouse:</strong> when a husband or wife leaves only a spouse and both parents, the mother takes a third of what is left after the spouse, not a third of the whole (the two 'Umariyyah cases). A wife leaving a husband, father and mother: husband 1/2, mother 1/6, father 1/3.</li>
</ul>
<h2>What to do now</h2>
<ol>
<li>Pay the funeral costs and the debts, including any unpaid mehr.</li>
<li>Enter the family in the <a href="/wirasat-calculator/">wirasat calculator</a> or the <a href="/wirasat-calculator-urdu/">Urdu version</a>, with all wives if there is more than one.</li>
<li>Open "six madhabs side by side" if your family follows a different school from the one you chose, and show the PDF to a mufti.</li>
<li>The widow's share is now her own wealth for zakat; see <a href="/zakat-on-inherited-wealth/">zakat on inherited wealth</a>.</li>
</ol>
[myzt_faq]
HTML
			. $author . '[myzt_related slugs="wirasat-calculator,haq-mehr-calculator,daughters-share-in-inheritance,zakat-on-inherited-wealth"]',
			'faq'     => array(
				array( 'q' => 'Do two wives each get 1/8?', 'a' => 'No. They share the single 1/8 (or 1/4 if there are no children) equally, so with two wives each gets 1/16.' ),
				array( 'q' => 'Kya mehr aur wirasat dono milte hain?', 'a' => 'Ji haan. Pehle ada na kiya gaya mehr qarz ke taur par poora milta hai, phir baqi tarke mein se biwi ka aathwan ya chautha hissa.' ),
				array( 'q' => 'Does a wife inherit if the rukhsati had not taken place?', 'a' => 'Yes. A valid nikah is enough for husband and wife to inherit from each other.' ),
				array( 'q' => 'Does a step-child reduce the wife\'s share?', 'a' => 'Yes. Any child of the husband, from any wife, reduces her share from 1/4 to 1/8.' ),
			),
		),

		'orphaned-grandchildren-inheritance' => array(
			'title'   => 'Orphaned Grandchildren and Inheritance: Fiqh and MFLO Section 4',
			'seo'     => 'Orphaned Grandchildren Inheritance: Section 4 MFLO (Yateem Pota)',
			'desc'    => 'Does a grandchild inherit if their parent died first? The fiqh of every madhab, section 4 of the Muslim Family Laws Ordinance, and what a will can do.',
			'nav'     => 'Orphaned grandchildren',
			'blurb'   => 'yateem pota',
			'content' => <<<'HTML'
[myzt_answer q="Does a grandson inherit if his father died before the grandfather?"]In the four Sunni schools and the Ahl-e-Hadith view, not while the grandfather leaves a living son: the nearer male relative excludes the further one. Pakistani law is different: under section 4 of the Muslim Family Laws Ordinance 1961 the children of a son or daughter who died first receive the share their parent would have received. A grandfather can also leave his orphaned grandchildren up to one third of his estate by will.[/myzt_answer]
<p>The yateem pota question is one of the most painful in inheritance. A son dies young, his children grow up with their grandparents, and when the grandfather dies they find that, by the classical rules, their uncles inherit and they do not. Pakistan changed this by law in 1961, and the change has been argued over in the courts ever since. This guide explains both positions and what the <a href="/wirasat-calculator/">wirasat calculator</a> shows.</p>
<h2>The classical rule in the Sunni schools</h2>
<p>The Prophet ﷺ said: "Give the fixed shares to those entitled to them, and what remains goes to the nearest male relative" (Sahih al-Bukhari 6732). A son is nearer than a son's son, so while any son is alive, the grandsons through a son who died first do not inherit as residuaries. A son's daughter is excluded in the same way. When the deceased leaves no son at all, the son's children do inherit: a son's son takes a son's place, and a son's daughter a daughter's place. A daughter's children belong to the distant relatives (<em>dhawu al-arham</em>) and inherit only when no closer heir exists.</p>
<h2>Ja'fari fiqh</h2>
<p>In Shia Ja'fari fiqh grandchildren take the place of their parent, but only when the deceased has no child of their own alive. While a son or daughter is alive, grandchildren through another child do not inherit. When they do inherit, each group takes the share their parent would have taken.</p>
<h2>Section 4 of the Muslim Family Laws Ordinance 1961</h2>
<p>Section 4 says that when a son or daughter of the deceased has died before the succession opens, their children living at that time receive, per stirpes, the share their parent would have received if alive. It applies to Muslims in Pakistan, and patwaris and civil courts record inheritance under it.</p>
<p>In 2000 the Federal Shariat Court, in <em>Allah Rakha v. Federation of Pakistan</em>, held section 4 repugnant to the injunctions of Islam. That judgment was appealed to the Shariat Appellate Bench of the Supreme Court, the appeal is still pending, and while it is pending the section stays in force. So in Pakistan today the law and the Sunni fiqh can give different answers for the same family.</p>
<h3>Worked example</h3>
<p>Rashid dies leaving Rs 30,00,000 and one living son, Tariq. His other son, Khalid, died two years earlier, leaving a son and a daughter.</p>
<ul>
<li><strong>Sunni fiqh:</strong> Tariq takes everything (Rs 30,00,000). Khalid's children inherit nothing from their grandfather.</li>
<li><strong>Section 4:</strong> each son's share is half. Tariq takes Rs 15,00,000, and Khalid's Rs 15,00,000 passes to his children, the boy twice the girl: Rs 10,00,000 and Rs 5,00,000.</li>
</ul>
<p>In the calculator, mark Khalid as "died before" and add his children under him. Because the two answers differ, the result appears in two tabs, "Pakistani law (patwari)" and your madhab's fiqh, and the PDF follows the tab you choose.</p>
<h2>What a grandfather can do: a will</h2>
<p>Because orphaned grandchildren are not heirs while a son is alive, a grandfather may leave them a will (<em>wasiyyat</em>) of up to one third of his estate in every Sunni school, with no need for the other heirs' consent. Many scholars strongly encourage this, citing the verse "it is prescribed for you, when death approaches, to make a bequest for parents and close relatives" (al-Baqarah 2:180). Several Muslim countries, starting with Egypt in 1946, made such a bequest obligatory (<em>wasiyya wajiba</em>). He may also give them gifts during his lifetime. The uncles, too, may freely give their orphaned nephews and nieces part of what they inherit.</p>
<h2>What to do now</h2>
<ol>
<li>Work out both positions in the <a href="/wirasat-calculator/">wirasat calculator</a> (or the <a href="/wirasat-calculator-urdu/">Urdu page</a>) and download the PDF.</li>
<li>Ask a mufti what your family should do as a matter of religion, and a lawyer what will be recorded in the land records.</li>
<li>If you are a grandparent with orphaned grandchildren, write your will now. A will within one third is valid in every school and avoids the dispute entirely.</li>
</ol>
[myzt_faq]
HTML
			. $author . '[myzt_related slugs="wirasat-calculator,daughters-share-in-inheritance,wife-husband-share-in-inheritance,wirasat-calculator-urdu"]',
			'faq'     => array(
				array( 'q' => 'Yateem pote ko dada ki wirasat milti hai?', 'a' => 'Sunni fiqh mein chacha (dada ka zinda beta) maujood ho to nahi. Pakistani qanoon (dafa 4, 1961) ke tehat use apne walid ka hissa milta hai. Dada wasiyyat se ek tihai tak de sakte hain.' ),
				array( 'q' => 'Is section 4 still the law in Pakistan?', 'a' => 'Yes. The Federal Shariat Court held it un-Islamic in 2000, but the appeal is pending before the Shariat Appellate Bench of the Supreme Court, so the section remains in force.' ),
				array( 'q' => 'Does section 4 also cover a daughter\'s children?', 'a' => 'Yes. The children of a predeceased daughter receive the share their mother would have received.' ),
				array( 'q' => 'Do orphaned grandchildren inherit if there is no living son?', 'a' => 'Yes, in every school: a son\'s children take the place of the son when no son is alive. The difference arises only when an uncle is alive.' ),
			),
		),

		'zakat-on-inherited-wealth' => array(
			'title'   => 'Zakat on Inherited Money, Gold and Property',
			'seo'     => 'Zakat on Inherited Money, Gold and Property (Wirasat par Zakat)',
			'desc'    => 'Is zakat due on an inheritance? When the zakat year starts, inherited gold and jewellery, land and houses, the deceased\'s own unpaid zakat and zakat before division.',
			'nav'     => 'Zakat on inherited wealth',
			'blurb'   => 'wirasat par zakat',
			'content' => <<<'HTML'
[myzt_answer q="Is zakat due on inherited money and gold?"]Inheritance itself is not taxed by zakat. Once your share is yours, inherited cash, gold, silver and trade goods count with the rest of your wealth, and zakat is due on them at 2.5% when your zakatable wealth is at or above the nisab and a lunar year has passed. Land or a house you keep to live in, rent out or farm has no zakat on its value.[/myzt_answer]
<p>After a death the family has two questions in quick succession: how to divide what was left, and what each heir now owes in zakat. The first is answered by the <a href="/wirasat-calculator/">wirasat calculator</a>, which gives each heir's share of cash, land and gold. This guide answers the second, and the <a href="/">zakat calculator</a> does the arithmetic once you know your share.</p>
<h2>First: the deceased's own zakat</h2>
<p>If the person who died had not paid zakat for some years, the schools differ on whether it is taken from the estate before division. In the Hanafi school it is paid only if they left a will for it, from up to one third; in the Shafi'i and Hanbali schools it is a debt to Allah paid from the estate before inheritance, will or no will. The details, and how to estimate missed years, are in <a href="/missed-zakat-past-years/">missed zakat for past years</a>. Missed fasts work in a similar way; see <a href="/roza-fidya/">fidya for a deceased person</a>.</p>
<h2>When does your zakat year start?</h2>
<ul>
<li><strong>If you already own the nisab (Hanafi):</strong> inherited cash, gold, silver and trade goods join your existing zakat year, just like a salary or a gift, and are counted on your next zakat date even if they arrived the week before. This is the Hanafi rule of joining acquired wealth to the nisab you own (see <a href="/hawl-zakat-due-date/">hawl and your zakat date</a>).</li>
<li><strong>If you already own the nisab (Shafi'i, Maliki, Hanbali):</strong> wealth that comes from outside, including an inheritance, starts its own lunar year. Many people simply pay on everything on their usual zakat date; Shafi'i and Hanbali scholars allow that as paying early.</li>
<li><strong>If the inheritance is what brings you to the nisab:</strong> your zakat year starts then, and your first zakat is due one lunar year later. The <a href="/zakat-date-calculator/">zakat date calculator</a> works out that date and sets a reminder.</li>
</ul>
<h2>When the estate takes years to divide</h2>
<p>Ownership passes to the heirs at the moment of death, but in many families the estate stays undivided for months or years, in a joint account or in one brother's hands. Whether each heir owes zakat for that time, and from when, depends on how much control they had over their share. Scholars differ on wealth that an owner could not reach, so if your share was held back from you, ask a scholar of your school. Where an heir knows their share and can take it whenever they ask, many scholars treat it as their own wealth for zakat from the start.</p>
<h2>Inherited gold and jewellery</h2>
<p>Gold and silver are zakatable however they were acquired. Inherited jewellery follows the jewellery rule of your school: in the Hanafi madhab and for Ahl-e-Hadith zakat is due on it even if worn; in the Shafi'i, Maliki and Hanbali madhabs jewellery that is worn is exempt, but jewellery kept in a locker as savings is not. See <a href="/zakat-on-jewellery/">zakat on jewellery</a>. The <a href="/zakat-on-gold-calculator/">zakat on gold calculator</a> values it by weight and karat at today's rate, and <a href="/zakat-on-1-tola-gold/">zakat on 1 tola of gold</a> shows the quick figure.</p>
<h2>Inherited land and houses</h2>
<ul>
<li><strong>A house you live in, or land you farm or rent out:</strong> no zakat on its value. Rent you save joins your cash, and crops from farmland carry <a href="/ushr-on-crops/">ushr</a> (10% or 5%) at harvest.</li>
<li><strong>Land you plan to sell:</strong> in the Hanafi school inherited land does not become trade goods just because you intend to sell it, since you did not acquire it by a purchase for trade. Zakat is due on the money once it is sold and joins your wealth. If you sell and later buy another plot to resell, that plot is trade goods.</li>
<li><strong>A share in a family business:</strong> your share of its stock, cash and receivables is zakatable as trade goods; the <a href="/business-zakat-calculator/">business zakat calculator</a> handles it.</li>
</ul>
<h2>Inherited savings certificates and bank accounts</h2>
<p>Inherited bank balances, National Savings certificates and prize bonds count at their value like your own. In Pakistan the bank may deduct zakat on 1 Ramadan from an account in the deceased's name or yours; subtract what was deducted so you do not pay twice. See <a href="/zakat-on-savings-certificates/">zakat on savings certificates</a> and <a href="/bank-zakat-deduction-pakistan/">bank zakat deduction</a>.</p>
<h2>Shia Ja'fari fiqh</h2>
<p>In Ayatollah Sistani's rulings inheritance received in the normal way is not subject to khums, and zakat applies to coined gold and silver, not to paper money or jewellery. See the <a href="/khums-calculator/">khums calculator</a> and <a href="/khums-who-must-pay/">who must pay khums</a>.</p>
<h2>What to do now</h2>
<ol>
<li>Find your share in the <a href="/wirasat-calculator/">wirasat calculator</a>.</li>
<li>Add it to your own savings and gold in the <a href="/">zakat calculator</a>, choosing your madhab.</li>
<li>Note your zakat date. If you are a woman who inherited jewellery, check the <a href="/nisab/">nisab</a> carefully: a few tola of gold can bring you to it.</li>
</ol>
[myzt_faq]
HTML
			. $author . '[myzt_related slugs="wirasat-calculator,home,zakat-on-jewellery,missed-zakat-past-years"]',
			'faq'     => array(
				array( 'q' => 'Wirasat mein mili raqam par zakat kab deni hai?', 'a' => 'Hanafi fiqh mein agar aap pehle se sahib-e-nisab hain to apni zakat ki tareekh par, baqi maal ke saath. Agar isi se nisab poora hua hai to ek qamri saal guzarne par.' ),
				array( 'q' => 'Is zakat due on an inherited house?', 'a' => 'No, not on the value of a house you live in or rent out. Zakat applies to the rent you save, and to the sale price once it is sold.' ),
				array( 'q' => 'Is zakat due on inherited jewellery?', 'a' => 'In the Hanafi and Ahl-e-Hadith view, yes, even if worn. In the Shafi\'i, Maliki and Hanbali schools worn jewellery is exempt.' ),
				array( 'q' => 'Do we pay the deceased\'s unpaid zakat before dividing the estate?', 'a' => 'In the Shafi\'i and Hanbali schools, yes. In the Hanafi school only if they left a will for it, from up to one third.' ),
			),
		),
	);
}
