<?php
/**
 * Iddat calculator and qurbani calculator pages, in English (with Roman Urdu sections) and Urdu.
 * Chosen from Keyword Planner data of 18 Oct 2026: no working iddat or qurbani tool ranked for these searches.
 *
 * @package MyZakatTool
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function myzt_content_iddat_qurbani() {
	$author = '[myzt_author]';
	$open   = '<div class="myzt-ur" dir="rtl" lang="ur">';
	$close  = '</div>';
	$p      = array();

	/* ------------------------------------------------------------------ */
	$p['iddat-calculator'] = array(
		'title'    => 'Iddat Calculator',
		'seo'      => 'Iddat Calculator: When Does Iddat End? Talaq, Khula, Widow',
		'desc'     => "Find the date iddat ends after talaq, khula or a husband's death: 130 days, three periods or the birth, for each madhab, in Hijri and Gregorian dates.",
		'nav'      => 'Iddat',
		'blurb'    => 'talaq, khula, bewa',
		'hub'      => 'calculators',
		'llms'     => true,
		'features' => array( 'Iddat end date after a husband\'s death, talaq or khula', 'Hanafi, Shafi\'i, Maliki, Hanbali, Ahl-e-Hadith and Shia Ja\'fari rules', 'Counts by the moon or by days, as the fiqh requires', 'Estimate from the woman\'s own period dates', 'Pregnancy, no periods and menopause', 'Pakistan MFLO 1961 section 7 date for talaq', 'Hijri and Gregorian dates', 'Calendar reminder', 'Nothing is saved or sent' ),
		'content'  => <<<'HTML'
[myzt_answer q="How long is iddat?"]A widow's iddat is four Islamic months and ten days, which is 130 days unless the death fell on the 1st of an Islamic month. After talaq or khula it is three menstrual cycles (three quru'), or three months for a woman who has no periods. A pregnant woman's iddat ends when the baby is born. There is no iddat after a talaq that came before the marriage was consummated.[/myzt_answer]
<p>Choose your madhab and what happened, enter the date, and the calculator gives the day the iddat ends in both the Islamic (Hijri) and the Gregorian calendar. For a divorce it estimates the end from the woman's own period dates, because the Quran counts that iddat in cycles, not days. Nothing you type is saved or sent anywhere.</p>
[zakat_iddat]
<h2>Iddat after the husband's death (bewa ki iddat)</h2>
<p>"Those of you who die and leave wives behind: the wives shall wait by themselves four months and ten days" (Surah al-Baqarah 2:234). This applies to every widow, young or old, whether or not the marriage was consummated, and whether or not she has periods. Only pregnancy changes it.</p>
<ul>
<li><strong>If the husband died on the 1st of an Islamic month,</strong> the four months are counted by the moon and ten days are added.</li>
<li><strong>If he died on any other day,</strong> Imam Abu Hanifa counts every month as 30 days, so the iddat is 130 days. Some scholars complete only the broken first month with days and count the rest by the moon; the difference is a day or two at most.</li>
<li><strong>The iddat starts at the moment of death,</strong> even if the wife hears the news later. If she only learns of it after 130 days, her iddat is already over.</li>
<li><strong>It ends at the same time of day as the death.</strong> If the husband died at 10 in the morning, the iddat ends at 10 in the morning on the last day.</li>
</ul>
<p>During this iddat the widow mourns: she avoids adornment, perfume, henna and bright jewellery. The Prophet (peace be upon him) said a believing woman may not mourn anyone more than three days, "except a husband, for four months and ten days" (Bukhari 1280). She stays in the home she lived in with her husband where she can (Abu Dawud 2300, Tirmidhi 1204). Hanafi scholars allow a widow who needs to earn to go out during the day and return home at night.</p>
<h2>Iddat after talaq (talaq ki iddat)</h2>
<p>"Divorced women shall wait by themselves for three quru'" (Surah al-Baqarah 2:228). The word quru' has two meanings in Arabic, and the madhabs read it differently:</p>
<ul>
<li><strong>Three periods (haiz):</strong> the Hanafi and Hanbali schools, and most Ahl-e-Hadith scholars. The iddat ends when the bleeding of the third complete period after the talaq stops. A period during which the talaq was given is not counted.</li>
<li><strong>Three times of purity (tuhr):</strong> the Shafi'i and Maliki schools, and Shia Ja'fari fiqh. The days of purity between periods are counted, so the iddat ends as soon as the third period after the talaq begins. This makes it a few days shorter.</li>
</ul>
<p>Because nobody knows exactly when future periods will come, the calculator asks for the first day of the last period before the talaq, the usual number of days from one period to the next, and how many days the bleeding lasts. It projects the next three cycles from those. Treat the date as an estimate: the iddat really ends with the woman's actual periods.</p>
<p><strong>A woman without periods</strong> (a young girl, or a woman whose periods have stopped with age) waits three months (Surah al-Talaq 65:4). They are counted by the moon if the talaq fell on the 1st of an Islamic month, and as 90 days otherwise. In Ja'fari fiqh, according to Ayatollah Sistani, a woman whose periods have stopped with age has no iddat after divorce, while a woman of child-bearing age who does not menstruate waits three months.</p>
<p><strong>Before the marriage was consummated</strong> there is no iddat after a talaq: "you have no waiting period to count against them" (Surah al-Ahzab 33:49), and half of the fixed mehr is due. Hanafi and Hanbali scholars count a valid private meeting of husband and wife after the nikah (khalwa sahiha) as consummation for this rule, so the full iddat applies then. The widow's iddat applies even without consummation.</p>
<h2>Iddat after khula (khula ki iddat)</h2>
<p>For the Hanafi, Shafi'i and Maliki schools, the iddat of khula is the same as the iddat of talaq: three quru'. Ahl-e-Hadith scholars give it one period, following the hadith in which the Prophet (peace be upon him) told the wife of Thabit ibn Qays to wait one menstrual cycle (Abu Dawud 2229, Tirmidhi 1185). The Hanbali madhab counts three, but Imam Ahmad also has a narration of one period, which Ibn Taymiyyah preferred. A khula granted by a court in Pakistan is followed by the same iddat.</p>
<h2>Iddat during pregnancy</h2>
<p>"For those who are pregnant, their term is until they deliver" (Surah al-Talaq 65:4). After talaq or khula, every madhab agrees the iddat ends at birth, however soon or late. For a widow, the four Sunni schools also end it at birth: Subay'ah al-Aslamiyyah gave birth a short time after her husband died and the Prophet (peace be upon him) allowed her to remarry (Muslim 1484). Shia Ja'fari fiqh, following Imam Ali, makes the pregnant widow wait for whichever is longer: the birth or four months and ten days. The calculator shows that date too.</p>
<h2>Iddat kitne din ki hoti hai?</h2>
<p>Mukhtasar jawab: <strong>bewa ki iddat 4 mahine 10 din</strong> hai, yani 130 din, agar shohar ki wafat Islami mahine ki pehli tareekh ko na hui ho. <strong>Talaq ki iddat 3 haiz</strong> (Hanafi), jo aam tor par do se teen mahine banti hai. Jis aurat ko haiz na aata ho us ki iddat 3 mahine, yani 90 din. <strong>Hamla aurat ki iddat bachay ki paidaish tak</strong> hai. Rukhsati se pehle talaq ho jaye to koi iddat nahi. <strong>Khula ki iddat</strong> Hanafi fiqh mein talaq jaisi, yani 3 haiz, aur Ahl-e-Hadith ulama ke nazdeek 1 haiz hai.</p>
<p>Iddat ki muddat shohar ki wafat ya talaq ke waqt se shuru hoti hai, khabar milne ke waqt se nahi. Upar calculator mein tareekh daal kar dekh lein ke aap ki iddat kis din khatam ho gi. Urdu mein yahi calculator: <a href="/iddat-calculator-urdu/">عدت کیلکولیٹر</a>.</p>
<h2>What is not allowed during iddat</h2>
<ul>
<li><strong>A new nikah.</strong> A nikah during iddat is not valid (2:235). A man may hint at a proposal to a widow, but not make an open one or a promise.</li>
<li><strong>Leaving the marital home without need,</strong> for both the widow and the divorcee in Hanafi fiqh. A woman in a revocable divorce (talaq raj'i) stays in the home, and her husband may take her back during the iddat without a new nikah.</li>
<li><strong>Adornment</strong> for a widow, and for a woman in a final divorce (talaq ba'in) in Hanafi fiqh.</li>
</ul>
<p>A divorced wife is owed maintenance (nafaqa) and housing during her iddat in the Hanafi madhab. In the other schools a wife in a revocable divorce is maintained, while after a final divorce maintenance is due only if she is pregnant. A widow has no maintenance from the estate, but she inherits her own share: see <a href="/wife-husband-share-in-inheritance/">the wife's share in inheritance</a> and the <a href="/wirasat-calculator/">wirasat calculator</a>. Any unpaid mehr is a debt that is paid first; the <a href="/haq-mehr-calculator/">haq mehr calculator</a> shows Mehr-e-Fatimi and the minimum mehr in today's money.</p>
<h2>Pakistan law: talaq notice and the 90 days</h2>
<p>Section 7 of the Muslim Family Laws Ordinance 1961 asks a husband who pronounces talaq to give written notice to the chairman of the Union Council, with a copy to the wife. The talaq does not take effect until 90 days after the chairman receives the notice, and if the wife is pregnant, not until the birth if that comes later. The calculator shows that 90-day date. It is a legal date for Pakistan and does not replace the fiqh iddat; ask a lawyer about your case.</p>
<p>This page gives the rules from the Quran, the hadith and published fatwas of each madhab. It is not a fatwa. For your own situation, especially an irregular cycle or a doubt about the date, ask a mufti or a scholar you trust.</p>
[myzt_faq]
HTML
			. $author . '[myzt_related slugs="iddat-calculator-urdu,haq-mehr-calculator,wife-husband-share-in-inheritance,wirasat-calculator"]',
		'faq'      => array(
			array( 'q' => 'Iddat kitne din ki hoti hai?', 'a' => 'Bewa ki iddat 4 mahine 10 din (130 din), talaq ki iddat 3 haiz, haiz na aata ho to 3 mahine (90 din), aur hamla ki iddat bachay ki paidaish tak.' ),
			array( 'q' => 'How many days is the iddat after a husband\'s death?', 'a' => 'Four Islamic months and ten days. If the death was not on the 1st of an Islamic month, Hanafi scholars count 130 days.' ),
			array( 'q' => 'What is the iddat period after divorce?', 'a' => 'Three menstrual cycles (Hanafi, Hanbali and most Ahl-e-Hadith scholars) or three times of purity (Shafi\'i, Maliki and Ja\'fari fiqh). Three months for a woman with no periods, and until birth for a pregnant woman.' ),
			array( 'q' => 'Khula ki iddat kitni hai?', 'a' => 'Hanafi, Shafi\'i aur Maliki fiqh mein talaq jaisi, yani 3 haiz. Ahl-e-Hadith ulama ke nazdeek 1 haiz, Thabit bin Qais ki biwi wali hadith ki wajah se.' ),
			array( 'q' => 'Is there iddat if the marriage was not consummated?', 'a' => 'Not after a talaq (Quran 33:49), unless husband and wife had a valid private meeting, which Hanafi and Hanbali scholars treat as consummation. A widow keeps the full iddat even without consummation.' ),
			array( 'q' => 'When does the iddat start?', 'a' => 'At the moment of the death or the talaq, even if the woman learns of it later.' ),
			array( 'q' => 'Can a woman in iddat go to work?', 'a' => 'Hanafi scholars allow a widow who must earn to go out during the day and return at night. A divorcee in iddat stays in the home unless there is real need. Ask a scholar about your case.' ),
		),
	);

	/* ------------------------------------------------------------------ */
	$p['iddat-calculator-urdu'] = array(
		'title'   => 'عدت کیلکولیٹر',
		'seo'     => 'عدت کی مدت: طلاق، خلع اور بیوہ کی عدت کا کیلکولیٹر',
		'desc'    => 'طلاق، خلع یا شوہر کی وفات کے بعد عدت کس دن ختم ہوگی: 130 دن، تین حیض یا بچے کی پیدائش، ہر مسلک کے مطابق، ہجری اور عیسوی تاریخ میں۔',
		'nav'     => 'عدت',
		'blurb'   => 'عدت کی مدت',
		'lang'    => 'ur',
		'alt'     => 'iddat-calculator',
		'hub'     => 'zakat-calculator-urdu',
		'llms'    => true,
		'content' => $open . <<<'HTML'
[myzt_answer q="عدت کی مدت کتنی ہے؟"]بیوہ کی عدت چار اسلامی مہینے دس دن ہے، یعنی 130 دن، اگر وفات اسلامی مہینے کی پہلی تاریخ کو نہ ہوئی ہو۔ طلاق یا خلع کے بعد عدت تین حیض (تین قروء) ہے، اور جس عورت کو حیض نہ آتا ہو اس کی تین مہینے۔ حاملہ کی عدت بچے کی پیدائش پر ختم ہوتی ہے۔ رخصتی (ملاپ) سے پہلے طلاق ہو جائے تو کوئی عدت نہیں۔[/myzt_answer]
<p>اپنا مسلک اور صورت چنیں، تاریخ لکھیں، اور کیلکولیٹر بتا دے گا کہ عدت کس دن ختم ہوگی، ہجری اور عیسوی دونوں تاریخوں میں۔ طلاق کی صورت میں یہ عورت کی اپنی ماہواری کی تاریخوں سے اندازہ لگاتا ہے، کیونکہ قرآن نے یہ عدت دنوں میں نہیں بلکہ حیض میں بتائی ہے۔ آپ کا لکھا کچھ بھی محفوظ یا کہیں نہیں بھیجا جاتا۔</p>
[zakat_iddat]
<h2>بیوہ کی عدت</h2>
<p>"اور تم میں سے جو لوگ وفات پا جائیں اور بیویاں چھوڑ جائیں، وہ بیویاں اپنے آپ کو چار مہینے دس دن روکے رکھیں" (سورۃ البقرہ 2:234، Surah al-Baqarah 2:234)۔ یہ ہر بیوہ پر ہے، جوان ہو یا بوڑھی، رخصتی ہوئی ہو یا نہیں، اور ماہواری آتی ہو یا نہیں۔ صرف حمل سے یہ حکم بدلتا ہے۔</p>
<ul>
<li><strong>اگر وفات اسلامی مہینے کی پہلی تاریخ کو ہوئی</strong> تو چار مہینے چاند کے حساب سے گنے جائیں گے اور دس دن مزید۔</li>
<li><strong>کسی اور تاریخ کو وفات ہوئی</strong> تو امام ابو حنیفہؒ کے نزدیک ہر مہینہ 30 دن کا ہوگا، یعنی عدت 130 دن۔ بعض علما صرف پہلا ادھورا مہینہ دنوں سے پورا کرتے ہیں؛ فرق زیادہ سے زیادہ ایک دو دن کا ہے۔</li>
<li><strong>عدت وفات کے وقت سے شروع ہوتی ہے،</strong> چاہے بیوی کو خبر بعد میں ملے۔</li>
<li><strong>عدت اسی وقت ختم ہوتی ہے</strong> جس وقت وفات ہوئی تھی، مثلاً صبح 10 بجے وفات ہوئی تو آخری دن صبح 10 بجے۔</li>
</ul>
<p>اس عدت میں بیوہ سوگ کرتی ہے: زیب و زینت، خوشبو، مہندی اور زیور سے بچتی ہے۔ نبی کریم صلی اللہ علیہ وسلم نے فرمایا کہ مومن عورت کسی پر تین دن سے زیادہ سوگ نہ کرے، "سوائے شوہر کے، اس پر چار مہینے دس دن" (بخاری 1280، Bukhari 1280)۔ جہاں تک ممکن ہو وہ شوہر والے گھر میں رہے۔ حنفی علما کے نزدیک جس بیوہ کو روزی کمانی ہو وہ دن میں نکل سکتی ہے اور رات گھر گزارے۔</p>
<h2>طلاق کی عدت</h2>
<p>"اور طلاق والی عورتیں اپنے آپ کو تین قروء تک روکے رکھیں" (سورۃ البقرہ 2:228)۔ عربی میں قروء کے دو معنی ہیں، اس لیے مسالک میں فرق ہے:</p>
<ul>
<li><strong>تین حیض:</strong> حنفی، حنبلی اور اکثر اہلِ حدیث علما۔ طلاق کے بعد تیسرا پورا حیض ختم ہونے پر عدت ختم ہوتی ہے۔ جس حیض میں طلاق دی گئی وہ شمار نہیں ہوتا۔</li>
<li><strong>تین طہر:</strong> شافعی، مالکی اور فقہ جعفریہ۔ ماہواریوں کے درمیان کے پاک دن گنے جاتے ہیں، اس لیے طلاق کے بعد تیسرا حیض شروع ہوتے ہی عدت ختم ہو جاتی ہے۔</li>
</ul>
<p>چونکہ آئندہ ماہواری کی صحیح تاریخ کسی کو معلوم نہیں، کیلکولیٹر طلاق سے پہلے کی آخری ماہواری کا پہلا دن، ایک ماہواری سے اگلی تک کے دن اور خون کے دن پوچھتا ہے، اور ان سے اگلے تین چکر کا اندازہ لگاتا ہے۔ اصل میں عدت عورت کی حقیقی ماہواری کے مطابق ختم ہوگی۔</p>
<p><strong>جس عورت کو حیض نہیں آتا</strong> (کم عمر لڑکی، یا وہ جس کی ماہواری عمر کی وجہ سے بند ہو چکی) اس کی عدت تین مہینے ہے (سورۃ الطلاق 65:4)۔ آیت اللہ سیستانی کے مطابق جس عورت کی ماہواری عمر کی وجہ سے بند ہو چکی ہو اس پر طلاق کی عدت نہیں۔</p>
<p><strong>رخصتی سے پہلے طلاق</strong> ہو تو کوئی عدت نہیں (سورۃ الاحزاب 33:49) اور مقرر مہر کا آدھا دینا ہوگا۔ حنفی اور حنبلی علما کے نزدیک نکاح کے بعد میاں بیوی کا تنہائی میں اکٹھا ہونا (خلوتِ صحیحہ) بھی اس معاملے میں ملاپ کی طرح ہے، اس لیے پھر پوری عدت ہوگی۔ بیوہ کی عدت رخصتی کے بغیر بھی ہے۔</p>
<h2>خلع کی عدت</h2>
<p>حنفی، شافعی اور مالکی مسالک میں خلع کی عدت طلاق کی طرح تین قروء ہے۔ اہلِ حدیث علما اسے ایک حیض بتاتے ہیں، کیونکہ نبی کریم صلی اللہ علیہ وسلم نے ثابت بن قیسؓ کی بیوی کو ایک حیض عدت گزارنے کا حکم دیا (ابو داؤد 2229، ترمذی 1185)۔ حنبلی مسلک میں تین ہیں، اور امام احمدؒ سے ایک حیض کی روایت بھی ہے۔ پاکستان میں عدالت سے ملنے والے خلع کے بعد بھی یہی عدت ہے۔</p>
<h2>حاملہ کی عدت</h2>
<p>"اور حمل والی عورتوں کی عدت یہ ہے کہ وہ بچہ جن لیں" (سورۃ الطلاق 65:4)۔ طلاق اور خلع میں تمام مسالک کے نزدیک عدت پیدائش پر ختم ہوتی ہے۔ بیوہ کے بارے میں چاروں سنی مسالک بھی یہی کہتے ہیں؛ سبیعہ اسلمیہؓ کے ہاں شوہر کی وفات کے کچھ ہی دن بعد بچہ ہوا تو آپ صلی اللہ علیہ وسلم نے انہیں نکاح کی اجازت دی (مسلم 1484)۔ فقہ جعفریہ میں حاملہ بیوہ دونوں میں سے لمبی مدت گزارتی ہے: پیدائش یا چار مہینے دس دن۔</p>
<h2>عدت میں کیا منع ہے؟</h2>
<p>عدت میں نکاح نہیں ہو سکتا، اور بلا ضرورت گھر سے نکلنا منع ہے۔ طلاقِ رجعی کی عدت میں شوہر بغیر نئے نکاح کے رجوع کر سکتا ہے۔ حنفی مسلک میں طلاق والی عورت کو عدت کا نان نفقہ اور رہائش ملتی ہے۔ بیوہ کو ترکے سے اپنا حصہ ملتا ہے؛ دیکھیں <a href="/wirasat-calculator-urdu/">وراثت کیلکولیٹر</a>۔ بقایا مہر شوہر پر قرض ہے؛ آج کی رقم کے لیے <a href="/haq-mehr-calculator-urdu/">حق مہر کیلکولیٹر</a>۔</p>
<h2>پاکستانی قانون: طلاق کا نوٹس اور 90 دن</h2>
<p>عائلی قوانین آرڈیننس 1961 کی دفعہ 7 کے مطابق طلاق دینے والا یونین کونسل کے چیئرمین کو تحریری نوٹس اور بیوی کو اس کی کاپی دے گا۔ طلاق نوٹس ملنے کے 90 دن بعد مؤثر ہوتی ہے، اور حاملہ ہو تو پیدائش پر اگر وہ بعد میں ہو۔ کیلکولیٹر یہ تاریخ بھی دکھاتا ہے۔ یہ قانونی تاریخ ہے، فقہی عدت کی جگہ نہیں؛ اپنے مقدمے کے لیے وکیل سے پوچھیں۔</p>
<p>یہی کیلکولیٹر انگریزی میں: <a href="/iddat-calculator/">Iddat Calculator</a> (انگریزی میں)۔ یہ صفحہ قرآن، حدیث اور ہر مسلک کے شائع شدہ فتاویٰ پر مبنی ہے، فتویٰ نہیں۔ اپنی صورت کے لیے کسی مستند مفتی سے رجوع کریں۔</p>
[myzt_faq]
HTML
			. $author . '[myzt_related slugs="haq-mehr-calculator-urdu,wirasat-calculator-urdu,iddat-calculator,zakat-calculator-urdu"]' . $close,
		'faq'     => array(
			array( 'q' => 'عدت کتنے دن کی ہوتی ہے؟', 'a' => 'بیوہ کی عدت چار مہینے دس دن (130 دن)، طلاق کی تین حیض، حیض نہ آتا ہو تو تین مہینے (90 دن)، اور حاملہ کی بچے کی پیدائش تک۔' ),
			array( 'q' => 'بیوہ کی عدت کب شروع ہوتی ہے؟', 'a' => 'شوہر کی وفات کے وقت سے، چاہے خبر بعد میں ملے۔' ),
			array( 'q' => 'خلع کی عدت کتنی ہے؟', 'a' => 'حنفی، شافعی اور مالکی مسالک میں طلاق کی طرح تین حیض؛ اہلِ حدیث علما کے نزدیک ایک حیض۔' ),
			array( 'q' => 'کیا رخصتی سے پہلے طلاق پر عدت ہے؟', 'a' => 'نہیں (سورۃ الاحزاب 33:49)، سوائے اس کے کہ میاں بیوی تنہائی میں اکٹھے ہوئے ہوں، جسے حنفی اور حنبلی علما ملاپ کی طرح مانتے ہیں۔' ),
		),
	);

	/* ------------------------------------------------------------------ */
	$p['qurbani-calculator'] = array(
		'title'    => 'Qurbani Calculator: Is Qurbani Wajib on Me?',
		'seo'      => 'Qurbani Calculator: Qurbani Kis Par Wajib Hai? Nisab Today',
		'desc'     => "Check if qurbani is wajib on you with today's nisab: cash, gold, silver and spare things beyond your needs, the Hanafi rule, other madhabs and the Eid date.",
		'nav'      => 'Qurbani',
		'blurb'    => 'qurbani wajib?',
		'hub'      => 'calculators',
		'llms'     => true,
		'features' => array( 'Is qurbani wajib: the Hanafi nisab test with today\'s silver rate', 'Counts things beyond basic needs that carry no zakat', 'Debts deducted', 'Traveller (musafir) rule', 'Shafi\'i, Maliki, Hanbali, Ahl-e-Hadith and Shia rulings', 'Eid al-Adha date and days left', '50 currencies, tola or gram' ),
		'content'  => <<<'HTML'
[myzt_answer q="Who must give qurbani?"]In the Hanafi madhab qurbani is wajib on every sane, adult Muslim who is not travelling and who owns the nisab, the value of 612.35 g (52.5 tola) of silver, in cash, gold, silver, trade goods or other things beyond basic needs on the days of Eid al-Adha. Today that is about [myzt_rate type="nisab-silver" currency="PKR"]. No year has to pass. The Shafi'i, Maliki and Hanbali schools treat qurbani as a strongly stressed sunnah for anyone who can afford it.[/myzt_answer]
<p>Enter what you own on the days of Eid and the calculator tells you whether qurbani is wajib on you by the Hanafi rule, using today's silver rate in your currency. Choose another madhab to see its ruling. Nothing you enter is saved or sent.</p>
[zakat_qurbani]
<h2>Qurbani kis par wajib hai?</h2>
<p>Hanafi fiqh mein qurbani har us musalman par wajib hai jo <strong>aqil, baligh aur muqeem</strong> (musafir nahi) ho, aur 10 Zil Hajj ki fajr se 12 Zil Hajj ke ghuroob tak kisi bhi waqt <strong>sahib-e-nisab</strong> ho, yani us ke paas zaroorat se zyada itna maal ho jo saadhe bavan tola (612.35 gram) chandi ki qeemat ke barabar ho. Aaj ye raqam taqreeban [myzt_rate type="nisab-silver" currency="PKR"] hai. Zakat ki tarah saal guzarna shart nahi: agar Eid se aik din pehle bhi itna maal aa gaya to qurbani wajib hai.</p>
<p>Zakat se aik bara farq ye hai ke qurbani ke nisab mein <strong>woh cheezein bhi gini jati hain jin par zakat nahi</strong>, agar woh zaroorat se zyada hon: doosra makan ya plot jis mein aap nahi rehte aur jo bechne ke liye bhi nahi, zayed gari, istemal se bahar kapre, bartan ya saman. Rehne ka ghar, roz ke kapre, furniture aur kaam ke auzaar shamil nahi. Jo qarz abhi ada karna hai woh minus ho jata hai.</p>
<h2>What is the nisab for qurbani?</h2>
<p>The nisab for qurbani is the same as the nisab for zakat: 612.35 g of silver or 87.48 g (7.5 tola) of gold. Hanafi muftis in Pakistan and India use the silver nisab whenever a person owns a mix of things, because it is lower and so more people give. If someone owns only gold and nothing else, not even a little cash, the gold nisab of 7.5 tola applies. Our <a href="/nisab/">nisab page</a> shows both in your currency today, with the rate and the time it was updated.</p>
<p>Two differences from zakat matter here. First, there is no hawl: what counts is what you own on the three days of qurbani, not a full year. Second, things that are not zakatable still count if they are more than your needs, as the Hanafi books such as Bada'i al-Sana'i say. So a family with no savings but a spare plot, or a woman with a few tola of gold and some cash, can be sahib-e-nisab for qurbani.</p>
<h2>Does each family member give a separate qurbani?</h2>
<p>Qurbani is on the person, not on the household. In Hanafi fiqh a husband is not obliged to give it for his wife or grown children: each adult who owns the nisab gives one of their own. A wife who owns gold jewellery worth more than the nisab, or an adult son with savings, owes a separate qurbani. A father may give on their behalf with their permission. A child's qurbani is not wajib.</p>
<p>One goat, sheep or ram is one qurbani. A cow, buffalo or camel can be shared by up to seven people, each share counting as one qurbani (Muslim 1318), so a family of four who all owe qurbani can take four shares in a cow. The usual minimum ages are one year for a goat or sheep (a healthy six-month lamb that looks a year old is accepted in Hanafi fiqh), two years for a cow or buffalo and five years for a camel.</p>
<h2>The other madhabs</h2>
<ul>
<li><strong>Shafi'i, Maliki and Hanbali:</strong> qurbani is a sunnah mu'akkadah, a strongly stressed sunnah, for anyone who has more than the needs of the Eid days. Leaving it is disliked for one who can afford it, but not sinful. There is no nisab.</li>
<li><strong>Ahl-e-Hadith:</strong> most scholars hold it is a sunnah mu'akkadah for anyone who can afford it; some say it is wajib on the one who can afford it, citing the hadith "Whoever can afford it and does not sacrifice, let him not come near our prayer place" (Ibn Majah 3123).</li>
<li><strong>Shia (Ayatollah Sistani):</strong> qurbani is strongly recommended (mustahabb mu'akkad) for one who can afford it, and wajib only for a pilgrim on Hajj.</li>
</ul>
<h2>When is Eid al-Adha 2027?</h2>
<p>By the Umm al-Qura calendar, 10 Dhul Hijjah 1448 falls on <strong>Sunday 16 May 2027</strong>. In Pakistan and India Eid may be a day later, depending on the moon sighting. The calculator above counts the days left. Qurbani may be given from after the Eid prayer on 10 Dhul Hijjah until sunset on 12 Dhul Hijjah in the Hanafi, Maliki and Hanbali schools; the Shafi'i school and many Ahl-e-Hadith scholars allow the 13th as well. The first day is best.</p>
<h2>Common questions about qurbani rules</h2>
<p><strong>Qurbani on women:</strong> yes, in Hanafi fiqh a woman who owns the nisab, which often happens through her own jewellery, gives her own qurbani. <strong>Qurbani on a loan:</strong> someone on whom qurbani is not wajib does not need to borrow for it. Someone on whom it is wajib but who has no cash at hand may borrow or sell something spare to give it, or give its value in charity after the days have passed. <strong>Qurbani and zakat together:</strong> a person can owe both, and they are separate duties; use the <a href="/">zakat calculator</a> for zakat. Skins and meat may not be sold; the skin can be given to the poor or to a madrasa. For livestock you keep for breeding or sale, see <a href="/zakat-on-livestock/">zakat on goats, cows and buffaloes</a>.</p>
<p>Urdu mein yahi calculator: <a href="/qurbani-calculator-urdu/">قربانی کیلکولیٹر</a>. This page follows published Hanafi fatwas (Darul Uloom Deoband, Jamia Binoria and Banuri Town) and the standard texts of the other schools. It is not a fatwa; ask a scholar of your madhab about your own case.</p>
[myzt_faq]
HTML
			. $author . '[myzt_related slugs="qurbani-calculator-urdu,nisab,zakat-on-livestock,who-can-receive-zakat"]',
		'faq'      => array(
			array( 'q' => 'Qurbani kis par wajib hai?', 'a' => 'Hanafi fiqh mein har aqil, baligh, muqeem musalman par jo Eid ke dinon mein zaroorat se zyada maal mein 612.35 gram chandi ki qeemat ka malik ho. Saal guzarna shart nahi.' ),
			array( 'q' => 'Qurbani ka nisab kitna hai?', 'a' => 'Zakat wala nisab: saadhe bavan tola (612.35 gram) chandi ki qeemat. Sirf sona ho aur kuch na ho to saadhe saat tola sona.' ),
			array( 'q' => 'Is qurbani wajib or sunnah?', 'a' => 'Wajib in the Hanafi madhab for one who owns the nisab and is not travelling. A strongly stressed sunnah in the Shafi\'i, Maliki and Hanbali schools and for most Ahl-e-Hadith scholars; strongly recommended for Shia (Sistani).' ),
			array( 'q' => 'Is qurbani wajib on a woman?', 'a' => 'Yes, if she herself owns the nisab, for example through her jewellery and some cash. Her husband\'s qurbani does not cover hers.' ),
			array( 'q' => 'Does a house or car count for qurbani nisab?', 'a' => 'Your home and the car you use do not. A second house or plot you do not live in and an extra car do count, at their sale value, in Hanafi fiqh.' ),
			array( 'q' => 'Is qurbani wajib on a traveller?', 'a' => 'Not in the Hanafi madhab. A traveller (musafir) may still give it, and gets the reward.' ),
			array( 'q' => 'When is Eid al-Adha 2027?', 'a' => 'Expected on Sunday 16 May 2027 (10 Dhul Hijjah 1448) by the Umm al-Qura calendar; in Pakistan and India it may be a day later depending on the moon.' ),
		),
	);

	/* ------------------------------------------------------------------ */
	$p['qurbani-calculator-urdu'] = array(
		'title'   => 'قربانی کیلکولیٹر',
		'seo'     => 'قربانی کس پر واجب ہے؟ قربانی کا نصاب آج کتنا ہے',
		'desc'    => 'آج کے نصاب سے دیکھیں کہ آپ پر قربانی واجب ہے یا نہیں: نقد، سونا، چاندی اور ضرورت سے زائد چیزیں، حنفی حکم، دوسرے مسالک اور عید الاضحیٰ کی تاریخ۔',
		'nav'     => 'قربانی',
		'blurb'   => 'قربانی کا نصاب',
		'lang'    => 'ur',
		'alt'     => 'qurbani-calculator',
		'hub'     => 'zakat-calculator-urdu',
		'llms'    => true,
		'content' => $open . <<<'HTML'
[myzt_answer q="قربانی کس پر واجب ہے؟"]حنفی مسلک میں قربانی ہر اس عاقل بالغ مسلمان پر واجب ہے جو مسافر نہ ہو اور عید الاضحیٰ کے دنوں میں ضرورت سے زائد نقد، سونے، چاندی، تجارتی مال یا دوسری چیزوں میں ساڑھے باون تولہ (612.35 گرام) چاندی کی قیمت کا مالک ہو۔ آج یہ رقم تقریباً [myzt_rate type="nisab-silver" currency="PKR"] ہے۔ سال گزرنا شرط نہیں۔ شافعی، مالکی اور حنبلی مسالک میں قربانی استطاعت رکھنے والے کے لیے سنتِ مؤکدہ ہے۔[/myzt_answer]
<p>عید کے دنوں میں جو کچھ آپ کے پاس ہے وہ لکھیں، کیلکولیٹر آج کے چاندی کے ریٹ سے بتا دے گا کہ حنفی حکم کے مطابق آپ پر قربانی واجب ہے یا نہیں۔ دوسرا مسلک چنیں تو اس کا حکم نظر آئے گا۔ آپ کا لکھا کچھ بھی محفوظ یا کہیں نہیں بھیجا جاتا۔</p>
[zakat_qurbani currency="PKR"]
<h2>قربانی کا نصاب</h2>
<p>قربانی کا نصاب وہی ہے جو زکوٰۃ کا ہے: ساڑھے باون تولہ (612.35 گرام) چاندی یا ساڑھے سات تولہ (87.48 گرام) سونا۔ جس کے پاس مختلف چیزیں ہوں، پاکستان اور ہندوستان کے حنفی مفتی اس کے لیے چاندی کا نصاب لیتے ہیں، کیونکہ وہ کم ہے۔ اگر کسی کے پاس صرف سونا ہو اور کچھ بھی نقد نہ ہو تو ساڑھے سات تولہ سونے کا نصاب ہے۔ آج کا نصاب اپنی کرنسی میں <a href="/nisab-urdu/">آج کا نصاب</a> صفحے پر دیکھیں۔</p>
<h2>زکوٰۃ اور قربانی کے نصاب میں فرق</h2>
<ul>
<li><strong>سال گزرنا شرط نہیں:</strong> 10 ذوالحجہ کی فجر سے 12 ذوالحجہ کے غروب تک کسی بھی وقت نصاب کا مالک ہو جائے تو قربانی واجب ہے، چاہے مال عید سے ایک دن پہلے آیا ہو۔</li>
<li><strong>ضرورت سے زائد ہر چیز شمار ہوتی ہے:</strong> دوسرا مکان یا پلاٹ جس میں آپ نہیں رہتے، زائد گاڑی، استعمال سے باہر کپڑے، برتن یا سامان، چاہے ان پر زکوٰۃ نہ ہو (بدائع الصنائع)۔ رہائشی گھر، روزمرہ کپڑے، فرنیچر اور کام کے اوزار شمار نہیں ہوتے۔</li>
<li><strong>قرض منہا ہوتا ہے:</strong> جو قرض ابھی ادا کرنا ہے وہ مال سے کم کر دیا جاتا ہے۔</li>
</ul>
<h2>کیا گھر کے ہر فرد پر الگ قربانی ہے؟</h2>
<p>قربانی ہر شخص پر الگ ہے، گھرانے پر ایک نہیں۔ جو بیوی اپنے زیور اور کچھ نقد کی وجہ سے صاحبِ نصاب ہو، یا جس جوان بیٹے کے پاس بچت ہو، وہ اپنی الگ قربانی کریں گے۔ والد ان کی اجازت سے ان کی طرف سے کر سکتا ہے۔ نابالغ بچے پر قربانی واجب نہیں۔ ایک بکرا، بھیڑ یا دنبہ ایک قربانی ہے؛ گائے، بھینس یا اونٹ میں سات لوگ شریک ہو سکتے ہیں (مسلم 1318، Muslim 1318)۔ جانور کی کم سے کم عمر: بکرا اور بھیڑ ایک سال، گائے بھینس دو سال، اونٹ پانچ سال۔</p>
<h2>دوسرے مسالک کیا کہتے ہیں؟</h2>
<ul>
<li><strong>شافعی، مالکی اور حنبلی:</strong> قربانی سنتِ مؤکدہ ہے، اس شخص کے لیے جس کے پاس عید کے دنوں کی ضرورت سے زیادہ ہو۔ کوئی نصاب نہیں۔</li>
<li><strong>اہلِ حدیث:</strong> اکثر علما کے نزدیک استطاعت والے کے لیے سنتِ مؤکدہ؛ بعض واجب کہتے ہیں، اس حدیث کی بنا پر کہ "جو استطاعت کے باوجود قربانی نہ کرے وہ ہماری عید گاہ کے قریب نہ آئے" (ابن ماجہ 3123)۔</li>
<li><strong>شیعہ (آیت اللہ سیستانی):</strong> استطاعت والے کے لیے مستحبِ مؤکد؛ صرف حج کرنے والے پر واجب۔</li>
</ul>
<h2>عید الاضحیٰ 2027 کب ہے؟</h2>
<p>ام القریٰ کیلنڈر کے مطابق 10 ذوالحجہ 1448 اتوار 16 مئی 2027 کو ہے۔ پاکستان اور ہندوستان میں رؤیتِ ہلال کے مطابق عید ایک دن بعد بھی ہو سکتی ہے۔ حنفی مسلک میں قربانی عید کی نماز کے بعد سے 12 ذوالحجہ کے غروب تک ہو سکتی ہے، اور پہلا دن افضل ہے۔</p>
<p>یہی کیلکولیٹر انگریزی اور رومن اردو میں: <a href="/qurbani-calculator/">Qurbani Calculator</a> (انگریزی میں)۔ زکوٰۃ کے لیے <a href="/zakat-calculator-urdu/">اردو زکوٰۃ کیلکولیٹر</a> استعمال کریں۔ یہ صفحہ دارالعلوم دیوبند، جامعہ بنوریہ اور بنوری ٹاؤن کے شائع شدہ حنفی فتاویٰ پر مبنی ہے، فتویٰ نہیں۔ اپنی صورت کے لیے اپنے مسلک کے عالم سے پوچھیں۔</p>
[myzt_faq]
HTML
			. $author . '[myzt_related slugs="nisab-urdu,zakat-calculator-urdu,qurbani-calculator,who-can-receive-zakat-urdu"]' . $close,
		'faq'     => array(
			array( 'q' => 'قربانی کا نصاب کتنا ہے؟', 'a' => 'ساڑھے باون تولہ (612.35 گرام) چاندی کی قیمت کے برابر ضرورت سے زائد مال۔ صرف سونا ہو تو ساڑھے سات تولہ۔' ),
			array( 'q' => 'کیا قربانی کے لیے سال گزرنا شرط ہے؟', 'a' => 'نہیں۔ عید کے تین دنوں میں کسی بھی وقت نصاب کا مالک ہونا کافی ہے۔' ),
			array( 'q' => 'کیا عورت پر قربانی واجب ہے؟', 'a' => 'جی ہاں، اگر وہ خود نصاب کی مالک ہو، مثلاً اپنے زیور اور کچھ نقد کی وجہ سے۔ شوہر کی قربانی اس کی طرف سے کافی نہیں۔' ),
			array( 'q' => 'کیا مسافر پر قربانی واجب ہے؟', 'a' => 'حنفی مسلک میں نہیں، البتہ کرے تو ثواب ملے گا۔' ),
		),
	);

	return $p;
}
