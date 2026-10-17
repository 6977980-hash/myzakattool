/**
 * My Zakat Tool: inheritance (wirasat) calculator and family tree (shajra).
 *
 * The visitor picks a madhab, adds the relatives and the estate, and gets each heir's share,
 * a patwari-style shajra drawn on a canvas, and a PNG or PDF of it to save or share.
 * Everything stays in the browser; the draft is kept in localStorage (myzt_wirasat).
 */
(function () {
	'use strict';

	var W = window.MYZT_WIRASAT;
	var E = window.MYZT_ENGINE;
	var CFG = window.MYZT || {};
	if (!W) return;

	var KEY = 'myzt_wirasat';
	var MADHABS = W.MADHABS;

	/* ---------- strings ---------- */
	var T = {
		en: {
			step1: '1. Choose the madhab', step1h: 'The whole calculation follows the rules of the madhab you choose.',
			m_hanafi: 'Hanafi', m_shafii: 'Shafi\'i', m_maliki: 'Maliki', m_hanbali: 'Hanbali', m_ahlehadith: 'Ahl-e-Hadith', m_jafari: 'Shia (Ja\'fari)',
			step2: '2. The person who has died', dname: 'Name (optional)', male: 'Man', female: 'Woman',
			step3: '3. Relatives', step3h: 'Add every relative, alive or not. Mark who died before and who died after.',
			g_spouse: 'Husband or wife', g_parents: 'Parents', g_children: 'Children', g_grand: 'Grandchildren', g_sib: 'Brothers and sisters', g_neph: 'Nephews and nieces', g_gp: 'Grandparents', g_unc: 'Uncles, aunts, cousins',
			add: '+', remove: 'Remove', name: 'Name', parentOf: 'Child of',
			kidsQ: 'Did %s leave children? Add them: depending on the madhab and section 4, the share may pass to them.', kidsHave: 'Children added', kidSon: 'Son', kidDaughter: 'Daughter',
			r_husband: 'Husband', r_wife: 'Wife', r_father: 'Father', r_mother: 'Mother', r_dada: 'Dada (father\'s father)', r_dadi: 'Dadi (father\'s mother)', r_nana: 'Nana (mother\'s father)', r_nani: 'Nani (mother\'s mother)',
			r_son: 'Son', r_daughter: 'Daughter', r_grandson: 'Grandson', r_granddaughter: 'Granddaughter',
			r_brother: 'Brother (same parents)', r_sister: 'Sister (same parents)', r_pbrother: 'Half-brother (same father)', r_psister: 'Half-sister (same father)', r_mbrother: 'Half-brother (same mother)', r_msister: 'Half-sister (same mother)',
			r_nephew: 'Nephew', r_niece: 'Niece', r_chacha: 'Chacha / taya (father\'s brother)', r_phuphi: 'Phuphi (father\'s sister)', r_mamu: 'Mamu (mother\'s brother)', r_khala: 'Khala (mother\'s sister)', r_cousin: 'Cousin (chacha\'s son)',
			s_short_husband: 'Husband', s_short_wife: 'Wife', s_short_dada: 'Dada', s_short_dadi: 'Dadi', s_short_nana: 'Nana', s_short_nani: 'Nani', s_short_brother: 'Brother', s_short_sister: 'Sister', s_short_pbrother: 'Half-brother (father)', s_short_psister: 'Half-sister (father)', s_short_mbrother: 'Half-brother (mother)', s_short_msister: 'Half-sister (mother)', s_short_chacha: 'Chacha', s_short_phuphi: 'Phuphi', s_short_mamu: 'Mamu', s_short_khala: 'Khala', s_short_cousin: 'Cousin',
			st_alive: 'Alive', st_before: 'Died before %s', st_after: 'Died after %s', theDeceased: 'the deceased',
			sec4: 'Also apply Pakistani law (MFLO 1961, section 4)', sec4h: 'Children of a son or daughter who died first get the share their parent would have received. Fiqh gives them nothing while a son is alive; scholars differ on this law.',
			sec4j: 'In Ja\'fari fiqh grandchildren take their parent\'s place when no child of the deceased is alive.',
			step4: '4. What they left', step4h: 'Add each kind of property. Values are optional except for cash.',
			i_cash: 'Cash and bank', i_land: 'Land', i_gold: 'Gold', i_silver: 'Silver', i_house: 'House or building', i_other: 'Other (car, shop, shares...)',
			amount: 'Amount', value: 'Value (optional)', valueReq: 'Value', label: 'What is it?', acre: 'Acre', kanal: 'Kanal', marla: 'Marla', tola: 'tola', gram: 'gram', karat: 'Karat',
			currency: 'Currency', autoValue: 'Value at today\'s rate',
			step5: '5. Paid first', step5h: 'Taken from the estate before it is divided.',
			d_funeral: 'Funeral (kafan-dafan) costs', d_debts: 'Debts, including unpaid mehr', d_will: 'Will (wasiyyat) for non-heirs', d_willH: 'At most one third of what is left after debts.',
			willCapped: 'The will is more than one third, so only one third (%s) is taken. More needs the heirs\' consent.',
			shortfall: 'The debts are more than the estate you entered. Heirs are not liable for the rest from their own money.',
			needMadhab: 'Choose a madhab to start.', needPeople: 'Add the relatives to see the shares.',
			res: 'Result', heir: 'Heir', share: 'Share', gets: 'Gets', excluded: 'Not inheriting',
			sumOk: 'All shares add up to the whole estate.', base: 'Shares out of',
			tree: 'Family tree (shajra)', treeLang: 'Tree language', png: 'Download picture', pdf: 'Download PDF', wa: 'Share on WhatsApp', making: 'Making…',
			treeTitle: 'Shajra-e-Wirasat', of: 'of', footer: 'Estimate only, not a fatwa or legal advice. myzakattool.com/wirasat-calculator', date: 'Date',
			disc: 'This calculator gives an estimate from published rules of each madhab. It is not a fatwa or legal advice. Inheritance is serious: please confirm with a mufti (and a lawyer for property transfer) before dividing.',
			e_parent: 'Choose whose child this is.', e_onlyOne: 'There can be only one %s.', e_fourWives: 'At most four wives.', e_spouseSex: 'Check the husband or wife: it does not match the deceased.',
			after: 'Died after: this share now goes to their own heirs.',
			n_sec4: 'Pakistani law (section 4) applied: the children of a son or daughter who died first take their parent\'s share.',
			n_mushtaraka: 'Al-Mushtaraka: full brothers share the third with the half-brothers through the mother (Shafi\'i, Maliki).',
			n_akdariyya: 'Al-Akdariyya: a famous case solved by Zayd ibn Thabit.',
			n_zayd: 'Grandfather with brothers: he gets the best of a share like a brother, one third, or one sixth (Zayd ibn Thabit).',
			n_radd: 'Radd: what was left after the fixed shares returns to the sharers (not to the husband or wife).',
			n_raddSpouse: 'No relative is left, so the rest also goes to the husband or wife (later Hanafi fatwa).',
			n_dhawi: 'Dhawi al-arham: no sharer or residuary is left, so relatives through women inherit. Scholars differ on how to divide among them: confirm with a mufti.',
			n_unassigned: 'Part of the estate has no heir in this list. Ask a mufti.',
			n_imam: 'Ja\'fari: a wife alone takes one quarter; the rest goes to the Imam (sahm-e-Imam). Ask your marja\'s office.',
			n_hajib: 'Ja\'fari: the brothers/sisters reduce the mother\'s share because the father is alive.',
			n_class3: 'Ja\'fari class 3: please confirm the split between paternal and maternal uncles and aunts with your marja\'s office.',
			n_awl: '\'Awl: the fixed shares added up to more than the estate, so each one was reduced in the same proportion.',
			n_landWife: 'Ja\'fari: the wife does not inherit from land, only from buildings and trees. Her share of a house is from the building\'s value.',
			why_husband: 'Husband: 1/2, or 1/4 when there are children', why_wife: 'Wife: 1/4, or 1/8 when there are children (wives share it)',
			why_father: 'Father', why_mother: 'Mother: 1/3, or 1/6 with children or two siblings', why_grandfather: 'Grandfather in place of the father', why_grandmother: 'Grandmother: 1/6',
			why_daughters: 'Daughters: 1/2 for one, 2/3 for two or more', why_sondaughter: 'Son\'s daughter: 1/6 next to one daughter', why_children: 'Children: the rest, a son twice a daughter',
			why_asaba: 'Residuary: takes what is left', why_maalGhayr: 'With daughters, sisters take the rest', why_sisters: 'Sisters: 1/2 for one, 2/3 for two or more', why_consSister: 'Half-sister (father): 1/6 next to one full sister',
			why_uterine: 'Mother\'s side: shared equally', why_muqasama: 'Shares with the grandfather', why_mushtaraka: 'Al-Mushtaraka', why_akdariyya: 'Al-Akdariyya',
			why_radd: 'Radd', why_dhawi: 'Dhawi al-arham', why_rep: 'Takes the share of the parent who died first', why_uncles: 'Uncles and aunts', why_passed: 'Died first: the share passes to their children',
			b_son: 'Excluded by the son', b_grandson: 'Excluded by the grandson', b_father: 'Excluded by the father', b_grandfather: 'Excluded by the grandfather', b_mother: 'Excluded by the mother',
			b_brother: 'Excluded by the full brother', b_sister: 'Excluded by the full sister', b_twoDaughters: 'Two daughters already take 2/3', b_twoSisters: 'Two full sisters already take 2/3',
			b_descendant: 'Excluded by the children', b_higherAsaba: 'A closer relative takes the rest', b_notSharer: 'Not an heir while closer relatives exist', b_nothingLeft: 'Nothing left after the fixed shares',
			b_diedBefore: 'Died first, so does not inherit', b_parentAlive: 'Their parent is alive', b_class1: 'Parents and children inherit first (Ja\'fari)', b_class2: 'Siblings and grandparents inherit first (Ja\'fari)', b_fullSibling: 'Excluded by full siblings',
		},
		ur: {
			step1: '1۔ مسلک چنیں', step1h: 'پورا حساب اسی مسلک کے اصولوں کے مطابق ہوگا جو آپ چنیں گے۔',
			m_hanafi: 'حنفی', m_shafii: 'شافعی', m_maliki: 'مالکی', m_hanbali: 'حنبلی', m_ahlehadith: 'اہلِ حدیث', m_jafari: 'شیعہ (جعفری)',
			step2: '2۔ جن کی وراثت تقسیم ہو رہی ہے', dname: 'نام (اختیاری)', male: 'مرد', female: 'عورت',
			step3: '3۔ رشتہ دار', step3h: 'سب رشتہ دار شامل کریں، زندہ ہوں یا نہیں۔ بتائیں کون پہلے فوت ہوا اور کون بعد میں۔',
			g_spouse: 'شوہر یا بیوی', g_parents: 'والدین', g_children: 'اولاد', g_grand: 'پوتے پوتیاں، نواسے نواسیاں', g_sib: 'بہن بھائی', g_neph: 'بھتیجے بھانجے', g_gp: 'دادا دادی، نانا نانی', g_unc: 'چچا، پھوپھی، ماموں، خالہ',
			add: '+', remove: 'ہٹائیں', name: 'نام', parentOf: 'کس کی اولاد',
			kidsQ: 'کیا %s کی اولاد ہے؟ انہیں شامل کریں: مسلک اور دفعہ 4 کے مطابق حصہ ان کو جا سکتا ہے۔', kidsHave: 'شامل اولاد', kidSon: 'بیٹا', kidDaughter: 'بیٹی',
			r_husband: 'شوہر', r_wife: 'بیوی', r_father: 'والد', r_mother: 'والدہ', r_dada: 'دادا', r_dadi: 'دادی', r_nana: 'نانا', r_nani: 'نانی',
			r_son: 'بیٹا', r_daughter: 'بیٹی', r_grandson: 'پوتا / نواسا', r_granddaughter: 'پوتی / نواسی',
			r_brother: 'سگا بھائی', r_sister: 'سگی بہن', r_pbrother: 'علاتی بھائی (باپ شریک)', r_psister: 'علاتی بہن (باپ شریک)', r_mbrother: 'اخیافی بھائی (ماں شریک)', r_msister: 'اخیافی بہن (ماں شریک)',
			r_nephew: 'بھتیجا / بھانجا', r_niece: 'بھتیجی / بھانجی', r_chacha: 'چچا / تایا', r_phuphi: 'پھوپھی', r_mamu: 'ماموں', r_khala: 'خالہ', r_cousin: 'چچا زاد بھائی',
			gs_son: 'پوتا', gs_daughter: 'نواسا', gd_son: 'پوتی', gd_daughter: 'نواسی', nb: 'بھتیجا', ns: 'بھانجا', nib: 'بھتیجی', nis: 'بھانجی',
			st_alive: 'زندہ', st_before: '%s کی وفات سے پہلے فوت ہوئے', st_after: '%s کی وفات کے بعد فوت ہوئے', theDeceased: 'مرحوم', theDeceasedF: 'مرحومہ',
			sec4: 'پاکستانی قانون بھی لگائیں (عائلی قوانین 1961، دفعہ 4)', sec4h: 'جو بیٹا یا بیٹی پہلے فوت ہو گئے ہوں ان کی اولاد کو وہ حصہ ملتا ہے جو ان کے والد یا والدہ کو ملتا۔ فقہ میں بیٹے کی موجودگی میں انہیں کچھ نہیں ملتا؛ اس قانون پر علما کا اختلاف ہے۔',
			sec4j: 'فقہ جعفری میں جب مرحوم کی کوئی اولاد زندہ نہ ہو تو پوتے نواسے اپنے والد یا والدہ کی جگہ لیتے ہیں۔',
			step4: '4۔ ترکہ (جو چھوڑ کر گئے)', step4h: 'ہر قسم کی جائیداد الگ لکھیں۔ نقد کے علاوہ قیمت لکھنا اختیاری ہے۔',
			i_cash: 'نقد اور بینک', i_land: 'زمین', i_gold: 'سونا', i_silver: 'چاندی', i_house: 'مکان یا عمارت', i_other: 'دوسری چیز (گاڑی، دکان، شیئرز...)',
			amount: 'رقم', value: 'قیمت (اختیاری)', valueReq: 'قیمت', label: 'کیا چیز ہے؟', acre: 'ایکڑ', kanal: 'کنال', marla: 'مرلہ', tola: 'تولہ', gram: 'گرام', karat: 'قیراط',
			currency: 'کرنسی', autoValue: 'آج کے ریٹ پر قیمت',
			step5: '5۔ تقسیم سے پہلے ادائیگی', step5h: 'یہ رقمیں ترکے سے تقسیم سے پہلے نکالی جاتی ہیں۔',
			d_funeral: 'کفن دفن کا خرچ', d_debts: 'قرض، ادا نہ کیا گیا مہر بھی', d_will: 'وصیت (غیر وارث کے لیے)', d_willH: 'قرض کے بعد بچنے والے مال کے ایک تہائی تک۔',
			willCapped: 'وصیت ایک تہائی سے زیادہ ہے، اس لیے صرف ایک تہائی (%s) لی گئی۔ زیادہ کے لیے وارثوں کی رضامندی ضروری ہے۔',
			shortfall: 'قرض آپ کے لکھے ترکے سے زیادہ ہے۔ باقی قرض وارثوں کے اپنے مال سے لازم نہیں۔',
			needMadhab: 'شروع کرنے کے لیے مسلک چنیں۔', needPeople: 'حصے دیکھنے کے لیے رشتہ دار شامل کریں۔',
			res: 'نتیجہ', heir: 'وارث', share: 'حصہ', gets: 'کیا ملے گا', excluded: 'وارث نہیں',
			sumOk: 'سب حصے مل کر پورا ترکہ بنتے ہیں۔', base: 'کل حصے',
			tree: 'شجرہ', treeLang: 'شجرے کی زبان', png: 'تصویر ڈاؤن لوڈ کریں', pdf: 'پی ڈی ایف ڈاؤن لوڈ کریں', wa: 'واٹس ایپ پر بھیجیں', making: 'بن رہا ہے…',
			treeTitle: 'شجرۂ وراثت', of: '', footer: 'صرف اندازہ، فتویٰ یا قانونی مشورہ نہیں۔ myzakattool.com/wirasat-calculator-urdu', date: 'تاریخ',
			disc: 'یہ کیلکولیٹر ہر مسلک کے شائع شدہ اصولوں سے اندازہ دیتا ہے۔ یہ فتویٰ یا قانونی مشورہ نہیں۔ وراثت اہم معاملہ ہے: تقسیم سے پہلے کسی مفتی صاحب (اور جائیداد کی منتقلی کے لیے وکیل) سے تصدیق کر لیں۔',
			e_parent: 'بتائیں یہ کس کی اولاد ہے۔', e_onlyOne: '%s ایک ہی ہو سکتا ہے۔', e_fourWives: 'زیادہ سے زیادہ چار بیویاں۔', e_spouseSex: 'شوہر یا بیوی چیک کریں: یہ مرحوم کے مطابق نہیں۔',
			after: 'بعد میں فوت ہوئے: یہ حصہ اب ان کے اپنے وارثوں میں جائے گا۔',
			n_sec4: 'پاکستانی قانون (دفعہ 4) لگایا گیا: پہلے فوت ہونے والے بیٹے یا بیٹی کی اولاد نے ان کا حصہ لیا۔',
			n_mushtaraka: 'مسئلہ مشترکہ: سگے بھائی ماں شریک بہن بھائیوں کے ساتھ تہائی میں شریک ہوئے (شافعی، مالکی)۔',
			n_akdariyya: 'مسئلہ اکدریہ: حضرت زید بن ثابت کا مشہور فیصلہ۔',
			n_zayd: 'دادا بھائیوں کے ساتھ: انہیں بھائی جتنا حصہ، ایک تہائی یا چھٹا حصہ، جو زیادہ ہو، ملتا ہے (زید بن ثابت)۔',
			n_radd: 'رد: مقررہ حصوں کے بعد بچا ہوا مال انہی حصہ داروں کو لوٹایا گیا (شوہر یا بیوی کو نہیں)۔',
			n_raddSpouse: 'کوئی اور رشتہ دار نہیں، اس لیے باقی بھی شوہر یا بیوی کو ملا (متاخرین احناف کا فتویٰ)۔',
			n_dhawi: 'ذوی الارحام: کوئی حصہ دار یا عصبہ نہیں بچا، اس لیے عورتوں کے واسطے والے رشتہ دار وارث بنے۔ ان کی تقسیم میں اختلاف ہے: مفتی صاحب سے تصدیق کریں۔',
			n_unassigned: 'ترکے کے ایک حصے کا اس فہرست میں کوئی وارث نہیں۔ مفتی صاحب سے پوچھیں۔',
			n_imam: 'فقہ جعفری: اکیلی بیوی کو چوتھائی ملتا ہے؛ باقی امام کا حق ہے۔ اپنے مرجع کے دفتر سے پوچھیں۔',
			n_hajib: 'فقہ جعفری: والد زندہ ہیں، اس لیے بھائی بہنوں نے والدہ کا حصہ کم کر دیا۔',
			n_class3: 'فقہ جعفری، تیسرا طبقہ: چچا پھوپھی اور ماموں خالہ کی تقسیم اپنے مرجع کے دفتر سے تصدیق کریں۔',
			n_awl: 'عول: مقررہ حصے ترکے سے زیادہ ہو گئے، اس لیے سب کے حصے ایک ہی نسبت سے کم ہوئے۔',
			n_landWife: 'فقہ جعفری: بیوی کو زمین سے حصہ نہیں ملتا، صرف عمارت اور درختوں کی قیمت سے۔ مکان میں اس کا حصہ عمارت کی قیمت سے ہے۔',
			why_husband: 'شوہر: آدھا، اولاد ہو تو چوتھائی', why_wife: 'بیوی: چوتھائی، اولاد ہو تو آٹھواں (بیویاں آپس میں بانٹیں)',
			why_father: 'والد', why_mother: 'والدہ: تہائی، اولاد یا دو بہن بھائی ہوں تو چھٹا', why_grandfather: 'دادا، والد کی جگہ', why_grandmother: 'دادی/نانی: چھٹا حصہ',
			why_daughters: 'بیٹیاں: ایک ہو تو آدھا، دو یا زیادہ ہوں تو دو تہائی', why_sondaughter: 'پوتی: ایک بیٹی کے ساتھ چھٹا حصہ', why_children: 'اولاد: باقی سب، بیٹے کا بیٹی سے دگنا',
			why_asaba: 'عصبہ: باقی مال لیتا ہے', why_maalGhayr: 'بیٹیوں کے ساتھ بہنیں باقی لیتی ہیں', why_sisters: 'بہنیں: ایک ہو تو آدھا، دو یا زیادہ تو دو تہائی', why_consSister: 'علاتی بہن: سگی بہن کے ساتھ چھٹا',
			why_uterine: 'ماں کی طرف: برابر تقسیم', why_muqasama: 'دادا کے ساتھ شریک', why_mushtaraka: 'مسئلہ مشترکہ', why_akdariyya: 'مسئلہ اکدریہ',
			why_radd: 'رد', why_dhawi: 'ذوی الارحام', why_rep: 'پہلے فوت ہونے والے والد/والدہ کا حصہ', why_uncles: 'چچا، پھوپھی، ماموں، خالہ', why_passed: 'پہلے فوت ہوئے: حصہ ان کی اولاد کو',
			b_son: 'بیٹے کی موجودگی میں محروم', b_grandson: 'پوتے کی موجودگی میں محروم', b_father: 'والد کی موجودگی میں محروم', b_grandfather: 'دادا کی موجودگی میں محروم', b_mother: 'والدہ کی موجودگی میں محروم',
			b_brother: 'سگے بھائی کی موجودگی میں محروم', b_sister: 'سگی بہن کی موجودگی میں محروم', b_twoDaughters: 'دو بیٹیاں پورا دو تہائی لے چکیں', b_twoSisters: 'دو سگی بہنیں پورا دو تہائی لے چکیں',
			b_descendant: 'اولاد کی موجودگی میں محروم', b_higherAsaba: 'زیادہ قریبی رشتہ دار باقی لیتا ہے', b_notSharer: 'قریبی وارثوں کی موجودگی میں وارث نہیں', b_nothingLeft: 'مقررہ حصوں کے بعد کچھ نہیں بچا',
			b_diedBefore: 'پہلے فوت ہوئے، اس لیے وارث نہیں', b_parentAlive: 'ان کے والد/والدہ زندہ ہیں', b_class1: 'پہلے طبقے (والدین، اولاد) کی موجودگی میں محروم', b_class2: 'دوسرے طبقے (بہن بھائی، دادا نانا) کی موجودگی میں محروم', b_fullSibling: 'سگے بہن بھائیوں کی موجودگی میں محروم',
		},
	};

	var lang = 'en';
	try { lang = localStorage.getItem('myzt_lang') || (document.documentElement.lang || '').slice(0, 2) || 'en'; } catch (e) {}
	if (CFG.lang && T[CFG.lang]) lang = CFG.lang;
	if (!T[lang]) lang = 'en';
	function tr(L, k) { return (T[L] && T[L][k]) || T.en[k] || k; }
	function t(k) { return tr(lang, k); }

	function esc(s) {
		return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) {
			return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
		});
	}
	function num(v) {
		if (E && E.parseAmount) return E.parseAmount(v).value;
		var n = parseFloat(String(v || '').replace(/,/g, ''));
		return isFinite(n) && n > 0 ? n : 0;
	}
	function money(v, cur) {
		try {
			return new Intl.NumberFormat(/^(PKR|INR|BDT|NPR|LKR)$/.test(cur) ? 'en-IN' : 'en-US', { style: 'currency', currency: cur, maximumFractionDigits: 0, currencyDisplay: 'narrowSymbol' }).format(Math.round(v || 0));
		} catch (e) { return cur + ' ' + Math.round(v || 0).toLocaleString(); }
	}
	function plain(v) { return v ? String(v) : ''; }
	function r2(x) { return Math.round(x * 100) / 100; }
	function load() { try { var v = localStorage.getItem(KEY); return v ? JSON.parse(v) : null; } catch (e) { return null; } }
	function save(s) { try { localStorage.setItem(KEY, JSON.stringify(s)); } catch (e) {} }

	/* ---------- relation names ---------- */

	// Full label in the form; on the tree a short one that knows the line (pota or nawasa, bhateeja or bhanja).
	function relName(p, L, people) {
		L = L || lang;
		var par = p.parent && people ? people.filter(function (x) { return x.id === p.parent; })[0] : null;
		if (L === 'ur' && par) {
			var viaMale = /^(son|brother|pbrother|mbrother|chacha)$/.test(par.rel);
			if (p.rel === 'grandson') return tr(L, viaMale ? 'gs_son' : 'gs_daughter');
			if (p.rel === 'granddaughter') return tr(L, viaMale ? 'gd_son' : 'gd_daughter');
			if (p.rel === 'nephew') return tr(L, viaMale ? 'nb' : 'ns');
			if (p.rel === 'niece') return tr(L, viaMale ? 'nib' : 'nis');
		}
		if (L === 'en' && par) {
			if (p.rel === 'grandson') return par.rel === 'son' ? "Son's son" : "Daughter's son";
			if (p.rel === 'granddaughter') return par.rel === 'son' ? "Son's daughter" : "Daughter's daughter";
			if (p.rel === 'nephew') return (/brother/.test(par.rel) ? "Brother's" : "Sister's") + ' son';
			if (p.rel === 'niece') return (/brother/.test(par.rel) ? "Brother's" : "Sister's") + ' daughter';
		}
		return tr(L, (L === 'en' && T.en['s_short_' + p.rel]) ? 's_short_' + p.rel : 'r_' + p.rel);
	}

	var GROUPS = [
		['g_spouse', ['husband', 'wife']],
		['g_parents', ['father', 'mother']],
		['g_children', ['son', 'daughter']],
		['g_grand', ['grandson', 'granddaughter']],
		['g_sib', ['brother', 'sister', 'pbrother', 'psister', 'mbrother', 'msister']],
		['g_neph', ['nephew', 'niece']],
		['g_gp', ['dada', 'dadi', 'nana', 'nani']],
		['g_unc', ['chacha', 'phuphi', 'mamu', 'khala', 'cousin']],
	];
	var ITEM_TYPES = ['cash', 'land', 'gold', 'silver', 'house', 'other'];

	function defaultCurrency() {
		var c = 'PKR';
		if (E && E.countryDefaults) c = E.countryDefaults(CFG.country).currency;
		var list = CFG.currencies || ['PKR'];
		return list.indexOf(c) >= 0 ? c : (list.indexOf('PKR') >= 0 ? 'PKR' : list[0] || 'USD');
	}
	// Price of 1 g of pure gold or silver in the chosen currency, from the site's live rates.
	function perGram(metal, cur) {
		var R = CFG.rates || {};
		var fx = cur === 'USD' ? 1 : +((R.fx || {})[String(cur).toLowerCase()] || 0);
		var oz = metal === 'gold' ? +R.goldUsdOz : +R.silverUsdOz;
		return fx && oz ? oz * fx / 31.1034768 : 0;
	}
	var TOLA_G = 11.6638038;

	/* ---------- the widget ---------- */

	function Wirasat(root) {
		var st = load() || {};
		st = {
			madhab: MADHABS.indexOf(st.madhab) >= 0 ? st.madhab : (root.dataset.madhab && MADHABS.indexOf(root.dataset.madhab) >= 0 ? root.dataset.madhab : ''),
			sex: st.sex === 'f' ? 'f' : 'm',
			name: typeof st.name === 'string' ? st.name.slice(0, 60) : '',
			sec4: !!st.sec4,
			people: Array.isArray(st.people) ? st.people.filter(function (p) { return p && W.REL[p.rel]; }).slice(0, 80) : [],
			items: Array.isArray(st.items) ? st.items.filter(function (i) { return i && ITEM_TYPES.indexOf(i.type) >= 0; }).slice(0, 30) : [],
			ded: st.ded && typeof st.ded === 'object' ? st.ded : {},
			currency: st.currency || defaultCurrency(),
			treeLang: st.treeLang === 'en' || st.treeLang === 'ur' ? st.treeLang : (lang === 'ur' || CFG.country === 'PK' ? 'ur' : 'en'),
		};
		if ((CFG.currencies || []).indexOf(st.currency) < 0) st.currency = defaultCurrency();
		var seq = st.people.reduce(function (m, p) { return Math.max(m, +String(p.id).replace(/\D/g, '') || 0); }, 0);
		function newId() { return 'p' + (++seq); }
		function persist() { save(st); }

		function deceasedLabel(L) {
			return st.name || (L === 'ur' ? tr(L, st.sex === 'f' ? 'theDeceasedF' : 'theDeceased') : tr(L, 'theDeceased'));
		}
		function statusLabel(p, L) {
			return tr(L || lang, 'st_' + (p.status || 'alive')).replace('%s', deceasedLabel(L || lang));
		}
		function parentsFor(rel) {
			var def = W.REL[rel];
			return def.parent ? st.people.filter(function (p) { return def.parent.indexOf(p.rel) >= 0; }) : [];
		}
		function canAdd(rel) {
			if (rel === 'husband' && st.sex !== 'f') return false;
			if (rel === 'wife' && (st.sex !== 'm' || count('wife') >= 4)) return false;
			if (W.SINGLE.indexOf(rel) >= 0 && count(rel) >= 1) return false;
			if (W.REL[rel].parent && !parentsFor(rel).length) return false;
			return true;
		}
		function count(rel) { return st.people.filter(function (p) { return p.rel === rel; }).length; }
		function seg(attr, opts, cur) {
			return '<span class="myzt-seg" role="group">' + opts.map(function (o) {
				return '<button type="button" data-' + attr + '="' + o[0] + '" aria-pressed="' + (cur === o[0]) + '">' + esc(o[1]) + '</button>';
			}).join('') + '</span>';
		}

		/* ---- form ---- */

		// Relations whose children can stand in for them when they died first.
		var KIDS = { son: ['grandson', 'granddaughter'], daughter: ['grandson', 'granddaughter'], brother: ['nephew', 'niece'], sister: ['nephew', 'niece'], pbrother: ['nephew', 'niece'], psister: ['nephew', 'niece'], mbrother: ['nephew', 'niece'], msister: ['nephew', 'niece'], chacha: ['cousin'] };
		function kidsPrompt(p) {
			var kinds = KIDS[p.rel];
			if (!kinds || p.status !== 'before') return '';
			var kids = st.people.filter(function (q) { return q.parent === p.id; });
			var who = p.name || relName(p, lang, st.people);
			return '<div class="myzt-wkids"><span class="myzt-small">' + esc(t('kidsQ').replace('%s', who)) + '</span> ' +
				kinds.map(function (k, i) { return '<button type="button" class="myzt-btn" data-addkid="' + k + '" data-for="' + esc(p.id) + '">+ ' + esc(t(i ? 'kidDaughter' : 'kidSon')) + '</button>'; }).join(' ') +
				(kids.length ? '<span class="myzt-small"> ' + esc(t('kidsHave')) + ': ' + kids.map(function (q) { return esc(q.name || relName(q, lang, st.people)); }).join('، ') + '</span>' : '') + '</div>';
		}
		function personRow(p) {
			var par = parentsFor(p.rel);
			var name = p.name ? '' : '';
			return '<div class="myzt-wp" data-row="' + esc(p.id) + '"><div class="myzt-wp-h"><b>' + esc(relName(p, lang, st.people)) + '</b>' +
				'<button type="button" class="myzt-link" data-del="' + esc(p.id) + '" aria-label="' + esc(t('remove') + ' ' + relName(p, lang, st.people)) + '">' + esc(t('remove')) + '</button></div>' +
				'<div class="myzt-wp-f"><input class="myzt-inp" maxlength="40" data-pname="' + esc(p.id) + '" value="' + esc(p.name || name) + '" placeholder="' + esc(t('name')) + '" aria-label="' + esc(t('name')) + '">' +
				'<select class="myzt-sel" data-pstatus="' + esc(p.id) + '" aria-label="' + esc(relName(p, lang, st.people)) + '">' + ['alive', 'before', 'after'].map(function (s) {
					return '<option value="' + s + '"' + ((p.status || 'alive') === s ? ' selected' : '') + '>' + esc(statusLabel({ status: s })) + '</option>';
				}).join('') + '</select>' +
				(par.length ? '<select class="myzt-sel" data-pparent="' + esc(p.id) + '" aria-label="' + esc(t('parentOf')) + '"><option value="">' + esc(t('parentOf')) + '…</option>' + par.map(function (q, i) {
					return '<option value="' + esc(q.id) + '"' + (p.parent === q.id ? ' selected' : '') + '>' + esc((q.name || relName(q, lang, st.people) + ' ' + (i + 1))) + '</option>';
				}).join('') + '</select>' : '') + '</div>' + kidsPrompt(p) + '</div>';
		}

		function itemRow(it, i) {
			var h = '<div class="myzt-wp" data-irow="' + i + '"><div class="myzt-wp-h"><b>' + esc(t('i_' + it.type)) + '</b><button type="button" class="myzt-link" data-delitem="' + i + '">' + esc(t('remove')) + '</button></div><div class="myzt-wp-f">';
			function inp(k, label, mode) {
				return '<label class="myzt-wi"><span>' + esc(label) + '</span><input class="myzt-inp" inputmode="' + (mode || 'decimal') + '" data-item="' + i + '" data-k="' + k + '" value="' + esc(plain(it[k])) + '" placeholder="0"></label>';
			}
			if (it.type === 'cash') h += inp('qty', t('amount') + ' (' + st.currency + ')');
			if (it.type === 'land') h += inp('acre', t('acre')) + inp('kanal', t('kanal')) + inp('marla', t('marla')) + inp('value', t('value') + ' (' + st.currency + ')');
			if (it.type === 'gold' || it.type === 'silver') {
				h += inp('qty', it.unit === 'gram' ? t('gram') : t('tola')) +
					'<span class="myzt-wi">' + seg('iunit-' + i, [['tola', t('tola')], ['gram', t('gram')]], it.unit || 'tola') + '</span>' +
					(it.type === 'gold' ? '<span class="myzt-wi"><span>' + esc(t('karat')) + '</span>' + seg('ikarat-' + i, [['24', '24'], ['22', '22'], ['21', '21'], ['18', '18']], String(it.karat || 22)) + '</span>' : '') +
					inp('value', t('value') + ' (' + st.currency + ')');
				var auto = metalValue(it);
				if (auto && !num(it.value)) h += '<p class="myzt-small" style="flex-basis:100%">' + esc(t('autoValue')) + ': ' + money(auto, st.currency) + '</p>';
			}
			if (it.type === 'house' || it.type === 'other') {
				h += '<label class="myzt-wi myzt-wi-l"><span>' + esc(t('label')) + '</span><input class="myzt-inp" maxlength="40" data-item="' + i + '" data-k="label" data-text="1" value="' + esc(it.label || '') + '"></label>' + inp('value', t('valueReq') + ' (' + st.currency + ')');
			}
			return h + '</div></div>';
		}
		function metalValue(it) {
			var g = num(it.qty) * (it.unit === 'gram' ? 1 : TOLA_G);
			var pg = perGram(it.type === 'gold' ? 'gold' : 'silver', st.currency);
			return g * pg * (it.type === 'gold' ? (+it.karat || 22) / 24 : 1);
		}

		function render() {
			var h = '<div class="myzt-card">' +
				'<div class="myzt-sec" style="border:0;padding-top:0"><h2 class="myzt-h">' + esc(t('step1')) + '</h2><p class="myzt-small">' + esc(t('step1h')) + '</p>' +
				'<div class="myzt-wm">' + MADHABS.map(function (m) { return '<button type="button" class="myzt-btn' + (st.madhab === m ? ' p' : '') + '" data-madhab="' + m + '" aria-pressed="' + (st.madhab === m) + '">' + esc(t('m_' + m)) + '</button>'; }).join('') + '</div></div>';
			if (!st.madhab) {
				root.innerHTML = h + '<p class="myzt-note">' + esc(t('needMadhab')) + '</p><div class="myzt-disc">' + esc(t('disc')) + '</div></div>';
				return;
			}
			h += '<div class="myzt-sec"><h2 class="myzt-h">' + esc(t('step2')) + '</h2><div class="myzt-wp-f">' +
				'<input class="myzt-inp" maxlength="60" data-dname value="' + esc(st.name) + '" placeholder="' + esc(t('dname')) + '" aria-label="' + esc(t('dname')) + '">' +
				seg('sex', [['m', t('male')], ['f', t('female')]], st.sex) + '</div></div>';

			h += '<div class="myzt-sec"><h2 class="myzt-h">' + esc(t('step3')) + '</h2><p class="myzt-small">' + esc(t('step3h')) + '</p>';
			GROUPS.forEach(function (g) {
				var rels = g[1].filter(function (rel) { return !(rel === 'husband' && st.sex !== 'f') && !(rel === 'wife' && st.sex !== 'm'); });
				var people = st.people.filter(function (p) { return g[1].indexOf(p.rel) >= 0; });
				h += '<div class="myzt-wg"><div class="myzt-wg-h">' + esc(t(g[0])) + '</div><div class="myzt-wadd">' + rels.map(function (rel) {
					var ok = canAdd(rel);
					return '<button type="button" class="myzt-btn" data-add="' + rel + '"' + (ok ? '' : ' disabled') + '>+ ' + esc(t('r_' + rel)) + '</button>';
				}).join('') + '</div>' + people.map(personRow).join('') + '</div>';
			});
			if (st.madhab === 'jafari') h += '<p class="myzt-small">' + esc(t('sec4j')) + '</p>';
			else h += '<label class="myzt-small myzt-wchk"><input type="checkbox" data-sec4' + (st.sec4 ? ' checked' : '') + '> <b>' + esc(t('sec4')) + '</b><br>' + esc(t('sec4h')) + '</label>';
			h += '</div>';

			h += '<div class="myzt-sec"><h2 class="myzt-h">' + esc(t('step4')) + '</h2><p class="myzt-small">' + esc(t('step4h')) + '</p>' +
				'<label class="myzt-small">' + esc(t('currency')) + ' <select class="myzt-sel" data-cur style="width:auto">' + (CFG.currencies || ['PKR']).map(function (c) { return '<option' + (c === st.currency ? ' selected' : '') + '>' + c + '</option>'; }).join('') + '</select></label>' +
				'<div class="myzt-wadd">' + ITEM_TYPES.map(function (ty) { return '<button type="button" class="myzt-btn" data-additem="' + ty + '">+ ' + esc(t('i_' + ty)) + '</button>'; }).join('') + '</div>' +
				st.items.map(itemRow).join('') + '</div>';

			h += '<div class="myzt-sec"><h2 class="myzt-h">' + esc(t('step5')) + '</h2><p class="myzt-small">' + esc(t('step5h')) + '</p><div class="myzt-wp-f">' +
				['funeral', 'debts', 'will'].map(function (k) {
					return '<label class="myzt-wi"><span>' + esc(t('d_' + k)) + ' (' + st.currency + ')</span><input class="myzt-inp" inputmode="decimal" data-ded="' + k + '" value="' + esc(plain(st.ded[k])) + '" placeholder="0"></label>';
				}).join('') + '</div><p class="myzt-small">' + esc(t('d_willH')) + '</p></div>';

			h += '<div data-res aria-live="polite"></div><div class="myzt-disc">' + esc(t('disc')) + '</div></div>';
			keep(function () { root.innerHTML = h; });
			results();
		}
		// Re-render without losing the field the visitor is typing in.
		var drawing = false;
		function keep(draw) {
			if (drawing) return;
			drawing = true;
			var a = document.activeElement, sel = '';
			if (a && root.contains(a)) {
				for (var i = 0; i < a.attributes.length; i++) {
					var at = a.attributes[i];
					if (at.name.indexOf('data-') === 0) sel += '[' + at.name + '="' + String(at.value).replace(/["\\]/g, '\\$&') + '"]';
				}
			}
			try { draw(); } finally { drawing = false; }
			if (sel) { try { var el = root.querySelector(sel); if (el) el.focus({ preventScroll: true }); } catch (e) {} }
		}

		/* ---- calculation ---- */

		function compute() {
			var people = st.people.map(function (p) { return { id: p.id, rel: p.rel, status: p.status || 'alive', parent: p.parent || undefined, name: p.name }; });
			var errs = W.validate(people, st.sex);
			var r = errs.length || !people.length ? null : W.calculate(people, { madhab: st.madhab, deceasedSex: st.sex, sec4: st.sec4 && st.madhab !== 'jafari' });
			var items = st.items.map(function (it) {
				var o = { type: it.type, unit: it.unit || 'tola', karat: +it.karat || 22, label: it.label || '' };
				if (it.type === 'cash') o.qty = num(it.qty);
				else if (it.type === 'land') { o.qty = W.toSarsahi({ acre: num(it.acre), kanal: num(it.kanal), marla: num(it.marla) }); o.value = num(it.value); o.acreIn = num(it.acre) > 0; }
				else if (it.type === 'gold' || it.type === 'silver') { o.qty = num(it.qty) * (it.unit === 'gram' ? 1 : TOLA_G); o.value = num(it.value) || metalValue(it); }
				else o.value = num(it.value);
				return o;
			});
			var net = W.netEstate(items, { funeral: num(st.ded.funeral), debts: num(st.ded.debts), will: num(st.ded.will) });
			return { people: people, errs: errs, r: r, net: net };
		}
		function landText(s, L) {
			var o = W.fromSarsahi(s);
			var parts = [];
			if (o.kanal) parts.push(o.kanal + ' ' + tr(L, 'kanal'));
			if (o.marla) parts.push(o.marla + ' ' + tr(L, 'marla'));
			if (o.sarsahi || !parts.length) parts.push(r2(o.sarsahi) + ' ' + (L === 'ur' ? 'سرسائی' : 'sarsahi'));
			return parts.join(' ');
		}
		// What one heir gets of each item, as short lines.
		function getsLines(c, id, L) {
			var r = c.r, f = W.val(r.shares[id].f), lines = [];
			c.net.items.forEach(function (it) {
				var fi = it.type === 'land' && r.landShares ? W.val(r.landShares[id]) : f;
				if (!fi) return;
				if (it.type === 'cash') { if (it.qty * it.factor) lines.push(money(it.qty * it.factor * fi, st.currency)); }
				else if (it.type === 'land') { if (it.qty) lines.push(landText(it.qty * it.factor * fi, L) + (it.value ? ' (' + money(it.value * it.factor * fi, st.currency) + ')' : '')); }
				else if (it.type === 'gold' || it.type === 'silver') {
					var g = it.qty * it.factor * fi;
					if (g) lines.push(r2(g / TOLA_G) + ' ' + tr(L, 'tola') + ' ' + tr(L, 'i_' + it.type) + (it.value ? ' (' + money(it.value * it.factor * fi, st.currency) + ')' : ''));
				} else if (it.value) lines.push((it.label || tr(L, 'i_' + it.type)) + ': ' + money(it.value * it.factor * fi, st.currency));
			});
			return lines;
		}
		function fracText(f) { return f.n ? f.n + '/' + f.d : '0'; }
		function pct(f) { return r2(W.val(f) * 100) + '%'; }
		function reasonText(s, L) {
			if (s.blocked) return tr(L, 'b_' + s.blocked);
			return s.why ? tr(L, 'why_' + s.why) : '';
		}

		function results() {
			var box = root.querySelector('[data-res]');
			if (!box) return;
			var c = compute();
			if (!c.people.length) { box.innerHTML = '<p class="myzt-note">' + esc(t('needPeople')) + '</p>'; return; }
			if (c.errs.length) {
				box.innerHTML = '<div class="myzt-note">' + c.errs.map(function (e) {
					if (e.code === 'onlyOne') return esc(t('e_onlyOne').replace('%s', t('r_' + e.rel)));
					return esc(t('e_' + e.code));
				}).filter(function (x, i, a) { return a.indexOf(x) === i; }).join('<br>') + '</div>';
				return;
			}
			var r = c.r;
			var heirs = c.people.filter(function (p) { return r.shares[p.id].f.n; });
			var out = c.people.filter(function (p) { return !r.shares[p.id].f.n; });
			var h = '<div class="myzt-sec"><h2 class="myzt-h">' + esc(t('res')) + '</h2><div class="myzt-scroll"><table class="myzt-table myzt-wt"><thead><tr><th>' + esc(t('heir')) + '</th><th>' + esc(t('share')) + '</th><th>' + esc(t('gets')) + '</th></tr></thead><tbody>' +
				heirs.map(function (p) {
					var s = r.shares[p.id];
					return '<tr><td><b>' + esc(p.name || relName(p, lang, c.people)) + '</b>' + (p.name ? '<br><span class="myzt-small">' + esc(relName(p, lang, c.people)) + '</span>' : '') +
						'<br><span class="myzt-small">' + esc(reasonText(s, lang)) + (s.ref ? ' · ' + esc(s.ref) : '') + '</span>' + (s.after ? '<br><span class="myzt-small"><b>' + esc(t('after')) + '</b></span>' : '') + '</td>' +
						'<td class="z" dir="ltr">' + fracText(s.f) + '<br><span class="myzt-small">' + pct(s.f) + '</span></td><td>' + getsLines(c, p.id, lang).map(esc).join('<br>') + '</td></tr>';
				}).join('') + '</tbody></table></div>';
			if (out.length) {
				h += '<details class="myzt-more"><summary class="myzt-small">' + esc(t('excluded')) + ' (' + out.length + ')</summary><ul class="myzt-small">' + out.map(function (p) {
					var s = r.shares[p.id];
					var txt = s.why === 'passed' ? t('why_passed') : reasonText(s, lang);
					return '<li><b>' + esc(p.name || relName(p, lang, c.people)) + '</b> (' + esc(relName(p, lang, c.people)) + '): ' + esc(txt) + '</li>';
				}).join('') + '</ul></details>';
			}
			var notes = r.notes.slice();
			if (r.awl) notes.push('awl');
			if (r.landShares && c.net.items.some(function (it) { return it.type === 'land' || it.type === 'house'; })) notes.push('landWife');
			notes = notes.filter(function (n, i, a) { return a.indexOf(n) === i && T.en['n_' + n]; });
			h += notes.map(function (n) { return '<p class="myzt-note">' + esc(t('n_' + n)) + '</p>'; }).join('');
			if (c.net.willCapped) h += '<p class="myzt-note">' + esc(t('willCapped').replace('%s', money(c.net.willUsed, st.currency))) + '</p>';
			if (c.net.shortfall > 0.5) h += '<p class="myzt-note">' + esc(t('shortfall')) + '</p>';
			h += '<p class="myzt-small">' + esc(t('sumOk')) + ' ' + esc(t('base')) + ' <span dir="ltr">' + r.base + '</span>.</p></div>';
			h += '<div class="myzt-sec"><h2 class="myzt-h">' + esc(t('tree')) + '</h2>' +
				'<div class="myzt-wtools"><span class="myzt-small">' + esc(t('treeLang')) + '</span> ' + seg('tl', [['ur', 'اردو'], ['en', 'English']], st.treeLang) + '</div>' +
				'<div class="myzt-wcanvas"><canvas data-tree role="img" aria-label="' + esc(t('tree')) + '"></canvas></div>' +
				'<div class="myzt-wadd"><button type="button" class="myzt-btn p" data-act="png">⬇ ' + esc(t('png')) + '</button><button type="button" class="myzt-btn" data-act="pdf">⬇ ' + esc(t('pdf')) + '</button><button type="button" class="myzt-btn" data-act="share">' + esc(t('wa')) + '</button></div></div>';
			box.innerHTML = h;
			last = c;
			drawSoon();
		}
		var last = null, drawTimer = null;
		function drawSoon() {
			clearTimeout(drawTimer);
			drawTimer = setTimeout(function () {
				var cv = root.querySelector('[data-tree]');
				if (!cv || !last) return;
				fontReady(st.treeLang).then(function () { drawTree(cv, last, st.treeLang, 1); });
			}, 30);
		}

		/* ---- shajra ---- */

		function fontReady(L) {
			if (L !== 'ur' || !document.fonts || !document.fonts.load) return Promise.resolve();
			return Promise.race([
				document.fonts.load('16px Gulzar', 'شجرہ').catch(function () {}),
				new Promise(function (res) { setTimeout(res, 2500); }),
			]);
		}
		function fonts(L) {
			return L === 'ur'
				? { b: '17px Gulzar, "Noto Nastaliq Urdu", "Jameel Noori Nastaleeq", serif', s: '13px Gulzar, "Noto Nastaliq Urdu", "Jameel Noori Nastaleeq", serif', h: '26px Gulzar, "Noto Nastaliq Urdu", serif', lh: 27, sh: 22 }
				: { b: '600 14px system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif', s: '12px system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif', h: '700 22px system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif', lh: 19, sh: 16 };
		}

		/** Places every person on a grid: grandparents, parents' generation, own generation, children, grandchildren. */
		function layout(c, BW) {
			var GX = 26, slot = BW + GX;
			var P = c.people;
			var pos = {}, links = [], couples = [];
			function of(rel) { return P.filter(function (p) { return p.rel === rel; }); }
			function kids(id) { return P.filter(function (p) { return p.parent === id; }); }
			function place(id, x, row) { pos[id] = { x: x, row: row }; }
			var x = 0;
			of('chacha').concat(of('phuphi')).forEach(function (u) {
				var cs = kids(u.id), w = Math.max(1, cs.length);
				place(u.id, x + w * slot / 2, 1);
				cs.forEach(function (k, i) { place(k.id, x + (i + 0.5) * slot, 2); });
				if (cs.length) links.push([[u.id], cs.map(function (k) { return k.id; })]);
				x += w * slot;
			});
			var bStart = x;
			var sibs = ['brother', 'sister', 'pbrother', 'psister', 'mbrother', 'msister'].reduce(function (a, rel) { return a.concat(of(rel)); }, []);
			sibs.forEach(function (s) {
				var cs = kids(s.id), w = Math.max(1, cs.length);
				place(s.id, x + w * slot / 2, 2);
				cs.forEach(function (k, i) { place(k.id, x + (i + 0.5) * slot, 3); });
				if (cs.length) links.push([[s.id], cs.map(function (k) { return k.id; })]);
				x += w * slot;
			});
			var sp = of('husband').concat(of('wife'));
			var ch = of('son').concat(of('daughter'));
			var chW = ch.reduce(function (a, k) { return a + Math.max(1, kids(k.id).length); }, 0);
			var top = 1 + sp.length, w = Math.max(top, chW, 1);
			var dx = x + (w - top) * slot / 2 + slot / 2;
			place('_d', dx, 2);
			sp.forEach(function (s, i) { place(s.id, dx + (i + 1) * slot, 2); couples.push(['_d', s.id]); });
			var cx = x + (w - chW) * slot / 2;
			ch.forEach(function (k) {
				var g = kids(k.id), cw = Math.max(1, g.length);
				place(k.id, cx + cw * slot / 2, 3);
				g.forEach(function (gg, i) { place(gg.id, cx + (i + 0.5) * slot, 4); });
				if (g.length) links.push([[k.id], g.map(function (gg) { return gg.id; })]);
				cx += cw * slot;
			});
			if (ch.length) links.push([sp.length ? ['_d', sp[0].id] : ['_d'], ch.map(function (k) { return k.id; })]);
			x += w * slot;
			if (x - bStart < 2 * slot) x = bStart + 2 * slot;
			var mid = (bStart + x) / 2;
			var father = of('father')[0], mother = of('mother')[0];
			if (father) place(father.id, mid - slot / 2, 1);
			if (mother) place(mother.id, mid + slot / 2, 1);
			if (father && mother) couples.push([father.id, mother.id]);
			var parentIds = [father, mother].filter(Boolean).map(function (p) { return p.id; });
			if (parentIds.length) links.push([parentIds, sibs.map(function (s) { return s.id; }).concat('_d')]);
			of('mamu').concat(of('khala')).forEach(function (u) { place(u.id, x + slot / 2, 1); x += slot; });
			// Grandparents above their own children.
			var right = -Infinity;
			[['dada', 'dadi', [father].concat(of('chacha'), of('phuphi'))], ['nana', 'nani', [mother].concat(of('mamu'), of('khala'))]].forEach(function (g) {
				var a = of(g[0])[0], b = of(g[1])[0];
				if (!a && !b) return;
				var ch2 = g[2].filter(Boolean).filter(function (p) { return pos[p.id]; });
				var xs = ch2.map(function (p) { return pos[p.id].x; });
				var center = xs.length ? (Math.min.apply(null, xs) + Math.max.apply(null, xs)) / 2 : (g[0] === 'dada' ? mid - slot : mid + slot);
				var left = center - (a && b ? slot / 2 : 0);
				if (left - slot / 2 < right + GX / 2) left = right + slot / 2 + GX / 2;
				if (a) place(a.id, left, 0);
				if (b) place(b.id, a ? left + slot : left, 0);
				right = (a && b ? left + slot : left) + slot / 2;
				if (a && b) couples.push([a.id, b.id]);
				if (ch2.length) links.push([[a, b].filter(Boolean).map(function (p) { return p.id; }), ch2.map(function (p) { return p.id; })]);
			});
			// Persons whose parent is missing (should not happen after validation) go at the far right.
			P.forEach(function (p) { if (!pos[p.id]) { place(p.id, x + slot / 2, 2); x += slot; } });
			var xsAll = Object.keys(pos).map(function (k) { return pos[k].x; });
			var minX = Math.min.apply(null, xsAll) - BW / 2, maxX = Math.max.apply(null, xsAll) + BW / 2;
			var rows = [];
			Object.keys(pos).forEach(function (k) { if (rows.indexOf(pos[k].row) < 0) rows.push(pos[k].row); });
			rows.sort();
			return { pos: pos, links: links, couples: couples, minX: minX, maxX: maxX, rows: rows };
		}

		function wrap(ctx, text, w) {
			var words = String(text).split(' '), out = [], cur = '';
			words.forEach(function (wd) {
				var next = cur ? cur + ' ' + wd : wd;
				if (cur && ctx.measureText(next).width > w) { out.push(cur); cur = wd; } else cur = next;
			});
			if (cur) out.push(cur);
			return out.map(function (l) { return fit(ctx, l, w); });
		}
		function fit(ctx, s, w) {
			s = String(s);
			if (ctx.measureText(s).width <= w) return s;
			while (s.length > 1 && ctx.measureText(s + '…').width > w) s = s.slice(0, -1);
			return s + '…';
		}

		function drawTree(cv, c, L, scale) {
			var F = fonts(L);
			var r = c.r;
			var BW = L === 'ur' ? 210 : 190;
			var probe = cv.getContext('2d');
			probe.font = F.s;
			var maxLines = 0;
			var cards = {};
			c.people.concat([{ id: '_d' }]).forEach(function (p) {
				var lines = [];
				if (p.id === '_d') {
					lines.push({ t: deceasedLabel(L), f: 'b' });
					lines.push({ t: tr(L, 'm_' + st.madhab), f: 's' });
				} else {
					var s = r.shares[p.id];
					lines.push({ t: p.name || relName(p, L, c.people), f: 'b' });
					lines.push({ t: p.name ? relName(p, L, c.people) : (p.status && p.status !== 'alive' ? '' : tr(L, 'st_alive')), f: 's' });
					if (p.status === 'before' || p.status === 'after') lines.push({ t: statusLabel(p, L), f: 's', c: '#8a6d1d' });
					if (s.f.n) {
						lines.push({ t: fracText(s.f) + '  ·  ' + pct(s.f), f: 'b', c: '#0b5d56', ltr: true });
						getsLines(c, p.id, L).forEach(function (g) { lines.push({ t: g, f: 's' }); });
					} else if (s.blocked !== 'diedBefore') {
						lines.push({ t: s.why === 'passed' ? tr(L, 'why_passed') : reasonText(s, L), f: 's', c: '#8a3b2e' });
					}
				}
				// Wrap long lines inside the box instead of cutting them.
				var wrapped = [];
				lines.filter(function (l) { return l.t; }).forEach(function (l) {
					probe.font = F[l.f];
					wrap(probe, l.t, BW - 16).forEach(function (part) { wrapped.push({ t: part, f: l.f, c: l.c, ltr: l.ltr }); });
				});
				cards[p.id] = wrapped;
				maxLines = Math.max(maxLines, wrapped.length);
			});
			var lh = F.sh, BH = 18 + maxLines * lh + 8, GY = 46;
			var lay = layout(c, BW);
			var M = 28, headH = L === 'ur' ? 92 : 78;
			var rowY = {};
			lay.rows.forEach(function (row, i) { rowY[row] = headH + i * (BH + GY); });
			var treeH = lay.rows.length * (BH + GY) - GY;
			// Table under the tree.
			var heirs = c.people.filter(function (p) { return r.shares[p.id].f.n; });
			var tLines = heirs.map(function (p) { return Math.max(1, getsLines(c, p.id, L).length); });
			var tRowH = function (i) { return 12 + tLines[i] * lh; };
			var tableH = 40 + tLines.reduce(function (a, n, i) { return a + tRowH(i); }, 0);
			var width = Math.max(720, lay.maxX - lay.minX + 2 * M);
			var height = headH + treeH + 40 + tableH + 56;
			var dpr = scale || Math.min(2, window.devicePixelRatio || 1);
			cv.width = Math.round(width * dpr);
			cv.height = Math.round(height * dpr);
			cv.style.width = width + 'px';
			cv.style.height = height + 'px';
			var ctx = cv.getContext('2d');
			ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
			ctx.fillStyle = '#ffffff';
			ctx.fillRect(0, 0, width, height);
			var ox = M - lay.minX + (width - (lay.maxX - lay.minX) - 2 * M) / 2;
			var rtl = L === 'ur';
			ctx.direction = rtl ? 'rtl' : 'ltr';
			ctx.textBaseline = 'middle';

			// Header
			ctx.fillStyle = '#0b5d56';
			ctx.font = F.h;
			ctx.textAlign = 'center';
			ctx.fillText(tr(L, 'treeTitle') + (L === 'en' ? ' of ' : ': ') + deceasedLabel(L), width / 2, 30);
			ctx.font = F.s;
			ctx.fillStyle = '#556a65';
			var today = new Date();
			ctx.fillText(tr(L, 'm_' + st.madhab) + '  ·  ' + tr(L, 'date') + ' ' + today.toISOString().slice(0, 10) + (st.sec4 && st.madhab !== 'jafari' ? '  ·  MFLO s.4' : ''), width / 2, L === 'ur' ? 64 : 56);

			function P(id) { var p = lay.pos[id]; return { x: p.x + ox, y: rowY[p.row] }; }
			// Lines
			ctx.strokeStyle = '#9fb8b2';
			ctx.lineWidth = 1.5;
			lay.couples.forEach(function (cp) {
				var a = P(cp[0]), b = P(cp[1]);
				var y = a.y + BH / 2;
				ctx.beginPath();
				ctx.moveTo(Math.min(a.x, b.x) + BW / 2, y - 3); ctx.lineTo(Math.max(a.x, b.x) - BW / 2, y - 3);
				ctx.moveTo(Math.min(a.x, b.x) + BW / 2, y + 3); ctx.lineTo(Math.max(a.x, b.x) - BW / 2, y + 3);
				ctx.stroke();
			});
			lay.links.forEach(function (lk) {
				var ps = lk[0].filter(function (id) { return lay.pos[id]; }).map(P), cs = lk[1].filter(function (id) { return lay.pos[id]; }).map(P);
				if (!ps.length || !cs.length) return;
				var px = ps.reduce(function (a, p) { return a + p.x; }, 0) / ps.length;
				var py = ps.length > 1 ? ps[0].y + BH / 2 : ps[0].y + BH;
				var cy = Math.min.apply(null, cs.map(function (q) { return q.y; }));
				var bus = cy - GY / 2;
				ctx.beginPath();
				ctx.moveTo(px, py); ctx.lineTo(px, bus);
				var xs = cs.map(function (q) { return q.x; }).concat(px);
				ctx.moveTo(Math.min.apply(null, xs), bus); ctx.lineTo(Math.max.apply(null, xs), bus);
				cs.forEach(function (q) { ctx.moveTo(q.x, bus); ctx.lineTo(q.x, q.y); });
				ctx.stroke();
			});
			// Boxes
			Object.keys(lay.pos).forEach(function (id) {
				var p = P(id), lines = cards[id] || [];
				var person = c.people.filter(function (q) { return q.id === id; })[0];
				var s = person ? r.shares[id] : null;
				var dead = person && person.status === 'before';
				var heir = s && s.f.n;
				var bx = p.x - BW / 2, by = p.y;
				ctx.save();
				roundRect(ctx, bx, by, BW, BH, 10);
				ctx.fillStyle = id === '_d' ? '#0f766e' : heir ? '#e6f4f1' : dead ? '#f1f1ef' : '#fafafa';
				ctx.fill();
				ctx.setLineDash(dead ? [5, 4] : []);
				ctx.strokeStyle = id === '_d' ? '#0b5d56' : heir ? '#0f766e' : person && person.status === 'after' ? '#c99a2e' : '#c9d6d3';
				ctx.lineWidth = heir || id === '_d' ? 2 : 1.2;
				ctx.stroke();
				ctx.restore();
				var y = by + 14 + lh / 2;
				lines.forEach(function (l) {
					ctx.font = F[l.f];
					ctx.fillStyle = id === '_d' ? '#ffffff' : l.c || (l.f === 'b' ? '#14302b' : '#556a65');
					ctx.textAlign = 'center';
					ctx.direction = l.ltr ? 'ltr' : rtl ? 'rtl' : 'ltr';
					ctx.fillText(fit(ctx, l.t, BW - 14), p.x, y);
					y += lh;
				});
				ctx.direction = rtl ? 'rtl' : 'ltr';
			});

			// Table
			var ty = headH + treeH + 40;
			var tx0 = M, tw = width - 2 * M;
			var cols = rtl ? [tx0 + tw, tx0 + tw * 0.62, tx0 + tw * 0.45] : [tx0, tx0 + tw * 0.38, tx0 + tw * 0.55];
			ctx.textAlign = rtl ? 'right' : 'left';
			ctx.font = F.b;
			ctx.fillStyle = '#0b5d56';
			ctx.fillText(tr(L, 'heir'), cols[0], ty + 14);
			ctx.fillText(tr(L, 'share'), cols[1], ty + 14);
			ctx.fillText(tr(L, 'gets'), cols[2], ty + 14);
			ty += 32;
			ctx.strokeStyle = '#dfe9e6';
			ctx.lineWidth = 1;
			heirs.forEach(function (p, i) {
				var s = r.shares[p.id];
				ctx.beginPath(); ctx.moveTo(tx0, ty - 4); ctx.lineTo(tx0 + tw, ty - 4); ctx.stroke();
				var cy0 = ty + 6 + lh / 2;
				ctx.font = F.b; ctx.fillStyle = '#14302b';
				ctx.fillText(fit(ctx, (p.name ? p.name + ' · ' : '') + relName(p, L, c.people), tw * 0.36), cols[0], cy0);
				ctx.direction = 'ltr';
				ctx.textAlign = rtl ? 'right' : 'left';
				ctx.fillStyle = '#0b5d56';
				ctx.fillText(fracText(s.f) + ' (' + pct(s.f) + ')', cols[1], cy0);
				ctx.direction = rtl ? 'rtl' : 'ltr';
				ctx.font = F.s; ctx.fillStyle = '#14302b';
				getsLines(c, p.id, L).forEach(function (g, j) { ctx.fillText(fit(ctx, g, tw * 0.44), cols[2], cy0 + j * lh); });
				ty += tRowH(i);
			});
			// Footer
			ctx.font = F.s;
			ctx.fillStyle = '#556a65';
			ctx.textAlign = 'center';
			ctx.fillText(tr(L, 'footer'), width / 2, height - 24);
		}
		function roundRect(ctx, x, y, w, h, rad) {
			ctx.beginPath();
			ctx.moveTo(x + rad, y);
			ctx.arcTo(x + w, y, x + w, y + h, rad);
			ctx.arcTo(x + w, y + h, x, y + h, rad);
			ctx.arcTo(x, y + h, x, y, rad);
			ctx.arcTo(x, y, x + w, y, rad);
			ctx.closePath();
		}

		/* ---- export ---- */

		function exportCanvas() {
			var cv = document.createElement('canvas');
			return fontReady(st.treeLang).then(function () { drawTree(cv, last, st.treeLang, 2); return cv; });
		}
		function fileName(ext) {
			var n = (st.name || 'wirasat').replace(/[^\w\u0600-\u06FF -]+/g, '').trim().replace(/\s+/g, '-') || 'wirasat';
			return 'shajra-' + n + '.' + ext;
		}
		function download(name, blob) {
			var a = document.createElement('a');
			a.href = URL.createObjectURL(blob);
			a.download = name;
			document.body.appendChild(a);
			a.click();
			setTimeout(function () { URL.revokeObjectURL(a.href); a.remove(); }, 500);
		}
		function toBlob(cv) { return new Promise(function (res) { cv.toBlob(res, 'image/png'); }); }
		var pdfReq = null;
		function loadJsPdf() {
			if (window.jspdf) return Promise.resolve(window.jspdf);
			if (!pdfReq) pdfReq = new Promise(function (res, rej) {
				var s = document.createElement('script');
				s.src = CFG.jspdfUrl;
				s.onload = function () { window.jspdf ? res(window.jspdf) : rej(new Error('pdf')); };
				s.onerror = function () { pdfReq = null; rej(new Error('pdf')); };
				document.head.appendChild(s);
			});
			return pdfReq;
		}
		function summary() {
			var r = last.r;
			return tr(lang, 'treeTitle') + ': ' + deceasedLabel(lang) + ' (' + t('m_' + st.madhab) + ')\n' + last.people.filter(function (p) { return r.shares[p.id].f.n; }).map(function (p) {
				return '• ' + (p.name || relName(p, lang, last.people)) + ': ' + fracText(r.shares[p.id].f) + ' (' + pct(r.shares[p.id].f) + ')';
			}).join('\n');
		}
		function act(kind, btn) {
			if (!last || !last.r) return;
			var label = btn.textContent;
			btn.disabled = true;
			btn.textContent = t('making');
			var done = function () { btn.disabled = false; btn.textContent = label; };
			exportCanvas().then(function (cv) {
				if (kind === 'png') return toBlob(cv).then(function (b) { download(fileName('png'), b); });
				if (kind === 'pdf') {
					return loadJsPdf().then(function (J) {
						var w = cv.width / 2 * 0.75, h = cv.height / 2 * 0.75;
						var doc = new J.jsPDF({ orientation: w > h ? 'l' : 'p', unit: 'pt', format: [w, h] });
						doc.addImage(cv.toDataURL('image/png'), 'PNG', 0, 0, w, h);
						doc.setProperties({ title: tr('en', 'treeTitle') + ' - ' + (st.name || ''), creator: 'myzakattool.com' });
						download(fileName('pdf'), doc.output('blob'));
					});
				}
				return toBlob(cv).then(function (b) {
					var text = summary() + '\n' + location.href.split('#')[0];
					var file = null;
					try { file = new File([b], fileName('png'), { type: 'image/png' }); } catch (e) {}
					if (file && navigator.canShare && navigator.canShare({ files: [file] })) {
						return navigator.share({ files: [file], text: text }).catch(function () {});
					}
					download(fileName('png'), b);
					window.open('https://wa.me/?text=' + encodeURIComponent(text), '_blank', 'noopener');
				});
			}).then(done, done);
		}

		/* ---- events ---- */

		var calcTimer = null;
		function soon() { clearTimeout(calcTimer); calcTimer = setTimeout(results, 250); }
		function removePerson(id) {
			var gone = [id];
			for (var i = 0; i < gone.length; i++) {
				st.people.forEach(function (p) { if (p.parent === gone[i] && gone.indexOf(p.id) < 0) gone.push(p.id); });
			}
			st.people = st.people.filter(function (p) { return gone.indexOf(p.id) < 0; });
		}

		root.addEventListener('click', function (e) {
			var b;
			if ((b = e.target.closest('[data-madhab]'))) { st.madhab = b.dataset.madhab; persist(); render(); return; }
			if ((b = e.target.closest('[data-sex]'))) {
				st.sex = b.dataset.sex;
				st.people = st.people.filter(function (p) { return !(p.rel === 'husband' && st.sex === 'm') && !(p.rel === 'wife' && st.sex === 'f'); });
				persist(); render(); return;
			}
			if ((b = e.target.closest('[data-add]'))) {
				var rel = b.dataset.add;
				if (!canAdd(rel)) return;
				var p = { id: newId(), rel: rel, status: 'alive', name: '' };
				var par = parentsFor(rel);
				if (par.length) p.parent = par[par.length - 1].id;
				st.people.push(p);
				persist(); render();
				var inp = root.querySelector('[data-pname="' + p.id + '"]');
				if (inp) inp.focus();
				return;
			}
			if ((b = e.target.closest('[data-addkid]'))) {
				var kid = { id: newId(), rel: b.dataset.addkid, status: 'alive', name: '', parent: b.dataset.for };
				st.people.push(kid);
				persist(); render();
				var ki = root.querySelector('[data-pname="' + kid.id + '"]');
				if (ki) ki.focus();
				return;
			}
			if ((b = e.target.closest('[data-del]'))) { removePerson(b.dataset.del); persist(); render(); return; }
			if ((b = e.target.closest('[data-additem]'))) { st.items.push({ type: b.dataset.additem, unit: 'tola', karat: 22 }); persist(); render(); return; }
			if ((b = e.target.closest('[data-delitem]'))) { st.items.splice(+b.dataset.delitem, 1); persist(); render(); return; }
			if ((b = e.target.closest('[data-tl]'))) { st.treeLang = b.dataset.tl; persist(); root.querySelectorAll('[data-tl]').forEach(function (x) { x.setAttribute('aria-pressed', x === b); }); drawSoon(); return; }
			if ((b = e.target.closest('[data-act]'))) { act(b.dataset.act, b); return; }
			var segBtn = e.target.closest('button');
			if (segBtn) {
				for (var i = 0; i < segBtn.attributes.length; i++) {
					var m = /^data-i(unit|karat)-(\d+)$/.exec(segBtn.attributes[i].name);
					if (m) {
						var it = st.items[+m[2]];
						if (it) { it[m[1]] = segBtn.attributes[i].value; persist(); render(); }
						return;
					}
				}
			}
		});
		root.addEventListener('input', function (e) {
			var el = e.target, d = el.dataset;
			if (d.pname) { var p = st.people.filter(function (x) { return x.id === d.pname; })[0]; if (p) p.name = el.value.slice(0, 40); }
			else if (d.dname !== undefined) st.name = el.value.slice(0, 60);
			else if (d.item !== undefined) { var it = st.items[+d.item]; if (it) it[d.k] = d.text ? el.value.slice(0, 40) : el.value; }
			else if (d.ded) st.ded[d.ded] = el.value;
			else return;
			persist();
			soon();
		});
		root.addEventListener('change', function (e) {
			var el = e.target, d = el.dataset;
			if (d.pstatus) { var p = st.people.filter(function (x) { return x.id === d.pstatus; })[0]; if (p) p.status = el.value; }
			else if (d.pparent) { var q = st.people.filter(function (x) { return x.id === d.pparent; })[0]; if (q) q.parent = el.value; }
			else if (d.sec4 !== undefined) st.sec4 = el.checked;
			else if (d.cur !== undefined) st.currency = el.value;
			else return;
			persist();
			render();
		});
		render();
	}

	function boot() {
		document.querySelectorAll('.myzt[data-widget="wirasat"]').forEach(function (el) {
			if (el.dataset.ready) return;
			el.dataset.ready = '1';
			el.lang = lang;
			el.dir = lang === 'ur' ? 'rtl' : 'ltr';
			Wirasat(el);
		});
	}
	if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot);
	else boot();
})();
