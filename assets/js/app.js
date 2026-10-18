/**
 * My Zakat Tool: calculator UI and widgets.
 * Everything runs in the browser; nothing the user types is sent to the server.
 */
(function () {
	'use strict';

	var E = window.MYZT_ENGINE;
	var CFG = window.MYZT || {};
	if (!E) return;

	var DRAFT_KEY = 'myzt_draft_v1';
	var LANG_KEY = 'myzt_lang';

	/* ---------- strings ---------- */
	var T = {
		en: {
			madhab: 'Madhab', currency: 'Currency', unit: 'Weight unit', change: 'Change', done: 'Done',
			u_tola: 'tola', u_gram: 'g', u_oz: 'oz', uo_tola: 'tola', uo_gram: 'gram', uo_oz: 'oz', mins: 'min', hours: 'h', days: 'd',
			spotRate: 'international spot rate', weight: 'Weight', maund: 'maund', kg: 'kg', maund40: 'maund (40 kg)',
			forget: 'Delete saved data', forgetConfirm: 'Delete everything the calculators saved in this browser (amounts, family members, language and reminder dates)?', forgotten: 'Saved data deleted from this browser.',
			m_hanafi: 'Hanafi', m_shafii: 'Shafi\'i', m_maliki: 'Maliki', m_hanbali: 'Hanbali', m_ahlehadith: 'Ahl-e-Hadith', m_jafari: 'Shia (Ja\'fari)',
			gold24: 'Gold 24K', silver: 'Silver', nisab: 'Nisab', per: '/', updated: 'updated', ago: 'ago', manualRate: 'manual rate set by the site owner', fxRates: 'currency rates',
			ownRate: 'Use my own local rate', ownGold: 'Gold 24K price per', ownSilver: 'Silver price per',
			rateMissing: 'Live rate not available right now. Please enter your local rate.',
			ownNeedBoth: 'Enter both the gold and the silver rate to use your own rate. Until then the live rate is used.',
			quickPh: 'Type it: "3 tola gold, 5 lakh cash and 1 lakh loan"', fill: 'Fill',
			filled: 'Filled from your text. Please check the fields below.', notUnderstood: 'Could not read that. Try: 3 tola gold, 2 lakh bank',
			have: 'What do you own?', haveHint: '(tap all that apply)',
			t_cash: 'Cash', t_bank: 'Bank', t_gold: 'Gold', t_silver: 'Silver', t_business: 'Business', t_shares: 'Shares / Crypto',
			t_committee: 'Committee / BC', t_receivables: 'Money owed to you', t_plot: 'Plot (for sale)', t_debts: 'Debts / Bills',
			f_cash: 'Cash at home', f_prizeBonds: 'Prize bonds', f_savingsCerts: 'Savings certificates (NSC, Behbood, DSC, RIC)',
			t_paid: 'Already paid', f_bankDeducted: 'Zakat the bank deducted on 1 Ramadan', f_paidAlready: 'Zakat already paid this year',
			h_bankDeducted: 'Shown on your bank statement or zakat certificate.', h_savingsCerts: 'Enter the amount invested (face value).',
			l_paid: 'Already paid / deducted by bank', toPay: 'Still to pay', totalZakat: 'Total zakat', f_bank: 'Bank balance (all accounts)',
			f_goldWorn: 'Gold jewellery you wear (not men\'s gold)', f_goldKept: 'Other gold (bars, coins, kept jewellery)',
			f_silverWorn: 'Silver jewellery you wear', f_silverKept: 'Other silver',
			f_businessCash: 'Business cash and bank', f_stock: 'Stock / inventory (sale value)', f_suppliers: 'Unpaid supplier bills',
			f_shares: 'Shares / mutual funds (market value)', f_crypto: 'Crypto (market value)',
			f_committee: 'Amount you have paid into the committee', f_receivables: 'Money owed to you (likely to be repaid)',
			f_receivablesDoubtful: 'Doubtful debts owed to you (not counted until received)',
			f_plot: 'Plot / property bought to sell (market value)', f_other: 'Other trade goods',
			f_debts: 'Debts you must repay now', f_installments: 'Instalments due in the next 12 months', f_bills: 'Unpaid bills (rent, utilities)',
			h_committee: 'Zakat is due on what you have paid in so far.', h_plot: 'A home you live in has no zakat.',
			h_goldWorn: 'Madhabs differ on worn jewellery; the result explains.', h_stock: 'Value at current selling price.',
			karat: 'Karat', me: 'Me', addPerson: '+ Family member', personName: 'Name', remove: 'Remove',
			family: 'Family total', yourZakat: 'Your zakat', zakatFor: 'Zakat for',
			due: 'Above nisab, zakat is due', notDue: 'Below nisab, zakat is not due', khumsBadge: 'No zakat on these assets per Ayatollah Sistani; see khums',
			l_money: 'Cash, bank and trade wealth', l_goldKept: 'Gold (kept)', l_goldWorn: 'Gold jewellery (worn)',
			l_silverKept: 'Silver (kept)', l_silverWorn: 'Silver jewellery (worn)', l_debts: 'Debts deducted',
			l_gold: 'Gold', l_silver: 'Silver', l_total: 'Zakatable wealth', l_rate: '× 2.5%', why: 'why?',
			w_jewellery_yes: 'In this madhab zakat is due on gold and silver jewellery even if it is worn.',
			w_jewellery_no: 'In this madhab permissible jewellery that is worn has no zakat.',
			w_debts_yes: 'Debts due now are deducted before checking nisab.',
			w_debts_no: 'In this madhab debts do not reduce zakat.',
			w_shafii_jewellery_excess: "Worn jewellery above the customary amount (about 860 g) is counted in Shafi'i fiqh.",
			w_jafari_money: 'According to Ayatollah Sistani, paper money has no zakat. Khums may apply instead.',
			w_jafari_gold: 'According to Ayatollah Sistani, zakat applies only to gold and silver coins used as currency, which is not the case today.',
			n_jafari_khums: "No zakat on these assets in Ja'fari fiqh (Sistani), but khums (20%) may be due on your yearly surplus.",
			n_shafii_excess_jewellery: "Worn gold above about 860 g exceeds the customary limit, so it is counted (MUIS, al-Majmu').",
			n_shafii_separate: "In Shafi'i fiqh gold and silver are separate; the other metal is checked against its own nisab.",
			n_doubtful_receivables: 'Doubtful debts are not counted now; pay zakat on them when you receive them.',
			n_debts_vs_metal: 'You have debts and only one metal: that metal\'s own nisab by weight is used, and your debts are deducted from its value.',
			nisabUsed: 'Nisab used', basisGold: 'gold (87.48 g)', basisSilver: 'silver (612.35 g)', basisCoins: 'coins only',
			chooseNisab: 'Nisab standard', compare: 'Compare all madhabs', hideCompare: 'Hide comparison',
			pdf: 'PDF report', whatsapp: 'WhatsApp', calendar: 'Add to calendar', report: 'Report an error',
			saveFile: 'Save data file', loadFile: 'Open data file', reset: 'Clear all',
			pdfName: 'Name on report (optional)', makePdf: 'Download PDF', making: 'Preparing…',
			cmpTitle: 'Your zakat in every madhab', cmpSub: 'Same inputs, cited sources',
			c_madhab: 'Madhab', c_jewellery: 'Worn jewellery', c_debts: 'Debts deducted', c_nisab: 'Nisab', c_zakat: 'Zakat', c_ref: 'Source',
			yes: 'Yes', no: 'No', included: 'Counted', includedAbove: 'Counted above limit', exempt: 'Exempt', lower: 'Lower of the two', seeKhums: 'See khums',
			disc: 'This calculator gives an estimate for guidance only. It is not a fatwa. Results may contain errors. Please confirm with a qualified scholar of your madhab before paying.',
			discLink: 'Disclaimer', resetConfirm: 'Clear all entries?', savedLocal: 'Saved on this device only.',
			shareText: 'My zakat estimate', calTitle: 'Zakat due (one lunar year)',
			persons: 'Number of people', item: 'Pay as', perPerson: 'Amount per person', fitranaTotal: 'Total fitrana',
			mh_kind: 'Mehr', mh_min: 'Minimum mehr (Hanafi)', mh_fatimi: 'Mehr-e-Fatimi', mh_silver: 'Silver', mh_value: 'Value today',
			mh_dirham: 'dirham', mh_other: 'Other views held by scholars', mh_check: 'Check your mehr', mh_mine: 'Your agreed mehr', mh_mineHelp: 'Enter the amount in your nikah nama to see it in silver.',
			mh_inSilver: 'Equal to', mh_ofFatimi: 'of Mehr-e-Fatimi', mh_belowMin: 'This is less than the Hanafi minimum mehr of 10 dirham. In the Hanafi madhab the mehr is then raised to the minimum.',
			mh_metal: 'Mehr fixed in gold or silver?', mh_metalHelp: 'If the nikah nama says, for example, 5 tola gold, see what it is worth today.', mh_qty: 'Weight', mh_gold24: 'Gold 24K', mh_gold22: 'Gold 22K',
			mh_madhabNote: "Shafi'i and Hanbali scholars set no minimum: anything of value may be mehr. Maliki: a quarter dinar of gold or 3 dirham of silver. Shia (Sistani): no minimum; the mehr of the Sunnah is 500 dirham.",
			dy_notified: 'Diyat notified for', dy_from: 'in force from 1 July', dy_live: '30,630 g of silver at today\'s rate', dy_liveHelp: 'The law fixes diyat at the value of 30,630 g of silver. The government notifies the rupee amount once a year, so the live value moves with the silver price.',
			dy_history: 'Notified amounts', dy_fy: 'Fiscal year', dy_amount: 'Amount', dy_source: 'Source', dy_noRate: 'Live silver rate in rupees is not available right now.',
			dy_note: 'Courts may award more than the notified amount but not less (PPC s. 323). This is information, not legal advice; ask a lawyer about a case.',
			fd_fasts: 'Fasts you cannot make up (fidya)', fd_broken: 'How many kaffaras are due (not the number of fasts broken)', fd_perDay: 'Amount for one poor person, one day', fd_fidya: 'Fidya', fd_kaffara: 'Kaffara (feeding 60 poor people each)', fd_total: 'Total to pay',
			fd_hFasts: 'Only for illness or old age with no hope of fasting later. Otherwise make the fasts up.', fd_hBroken: 'Hanafi: several fasts broken in the same Ramadan need one kaffara. Kaffara by feeding is only for someone who cannot fast 60 days in a row.',
			wheat: 'Wheat / flour', barley: 'Barley', dates: 'Dates', raisins: 'Raisins',
			h_start: 'Date your wealth first reached the nisab (or your usual zakat date)', h_next: 'Your next zakat dates', h_left: 'days left',
			h_ics: 'Add next 5 zakat dates to my calendar', h_note: 'Dates move about 11 days earlier each year (lunar year). They may differ by a day with moon sighting.',
			h_missed: 'Missed years', h_missedN: 'How many years of zakat were not paid?', h_wealthY: 'Zakatable wealth on zakat date, year', h_sub: 'Count earlier unpaid zakat as a debt (Hanafi)',
			h_nisabNow: 'Nisab used (today\'s value, edit if needed)', h_missedTotal: 'Zakat owed for missed years', h_yearsSince: 'Lunar years since this date',
			u_crops: 'Crops (ushr)', u_animals: 'Livestock', u_madhab: 'Madhab', u_hanafi: 'Hanafi', u_others: "Shafi'i, Maliki, Hanbali, Ahl-e-Hadith", u_jafari: "Ja'fari (Sistani)",
			u_jafariNote: "Ayatollah Sistani: the minimum is higher (about 847 kg), and zakat on crops applies only to wheat, barley, dates and raisins.",
			u_notDueJ: 'Below the minimum of about 847 kg: no zakat on this crop (Ayatollah Sistani).',
			u_qty: 'Harvest quantity', u_price: 'Price per', u_water: 'Watering', u_rain: 'Rain / river (10%)', u_irr: 'Tube well / paid water (5%)', u_mixed: 'Half and half (7.5%)',
			u_due: 'Ushr to give', u_value: 'Value', u_notDue: 'Below the nisab of 5 wasq (about 653 kg): no ushr in this madhab.',
			u_note: 'Ushr is due at harvest, with no waiting year. Costs of seed, fertiliser and labour are not deducted in the classical view; some contemporary scholars allow deducting them, so ask your scholar. Hanafi: if both kinds of water are used, the one used for most of the season decides.',
			a_sheep: 'Goats and sheep', a_cows: 'Cows and buffaloes', a_camels: 'Camels', a_give: 'Give',
			a_none: 'Below the nisab: nothing due.', w_sheep: 'goat or sheep (at least 1 year old)', w_tabi: 'calf in its 2nd year (tabi\')', w_musinnah: 'cow in its 3rd year (musinnah)',
			w_bintMakhad: 'she-camel in its 2nd year', w_bintLabun: 'she-camel in its 3rd year', w_hiqqa: 'she-camel in its 4th year', w_jadha: 'she-camel in its 5th year', w_askScholar: 'More than 120 camels: please ask a scholar, the schools differ.',
			a_note: 'Only for animals that graze freely for most of the year, are not used for work, and have been owned for a lunar year. Animals kept for sale are trade goods: add their value in the main calculator.',
			k_date: 'Your khums date', k_ics: 'Add khums date to calendar', k_paid: 'Not included: money on which khums was already paid, inheritance and mahr. Gifts count as income in Ayatollah Sistani\'s rulings: include what is left of them in savings.',
			k_where: 'Pay Sahm-e-Imam to the office or authorised representative of your marja, and Sahm-e-Sadat to needy Sayyids.',
			k_savings: 'Savings from this year\'s income', k_unused: 'Items bought from income, still unused', k_stock: 'Trade stock (from income)', k_debts: 'Debts of this year',
			k_total: 'Khums (20%)', k_surplus: 'Surplus', k_imam: 'Sahm-e-Imam (10%)', k_sadat: 'Sahm-e-Sadat (10%)',
			perGram: 'per gram', perTola: 'per tola', perOz: 'per ounce', purity: 'Purity',
			err_negative: 'Amounts cannot be negative. Enter debts under Debts / Bills. This value is not counted.',
			err_negative_any: 'Amounts cannot be negative. This value is not counted.',
			err_invalid: 'Please type a plain number, for example 250000 or 2,50,000. This value is not counted.',
			fineness: 'Fineness', fine999: 'Pure (999)', fine925: 'Sterling (925)', fine900: '900',
			c_toPay: 'Still to pay',
			fileBad: 'This file could not be opened. Please choose a data file saved from this calculator.',
			fileCur: 'This file was saved in %s, which is not available here. Its amounts are shown in %t: please check them.',
			fileOk: 'Data file opened.',
			f_noPreset: 'Enter the fitrana amount announced for your area this year.',
			f_fallback: 'Last announced amounts shown. Replace them with this year\'s amount for your area.',
			h_oldest: 'Year 1 is the oldest unpaid year.', h_nisabY: 'Nisab that year (optional)',
			h_basis: 'Nisab standard for missed years', h_nisabNote: 'Hanafi uses the silver nisab; Shafi\'i and some others use gold. If you know the nisab of an earlier year, enter it for that year.',
			a_madhabNote: 'Maliki fiqh also counts animals that are fed or used for work. Ja\'fari (Ayatollah Sistani) rulings differ in some tables. This tool follows the Hanafi, Shafi\'i and Hanbali tables: please check with a scholar of your madhab.',
			h_receivables: 'Counted now. Hanafi and Maliki scholars allow paying zakat on a cash loan when it is repaid: if you choose that, enter it on the next line instead.',
			n_receivables_hanafi: 'Hanafi: you may instead pay zakat on money owed to you when you receive it, for every year it was owed.',
			n_hanafi_alloy: 'Counted by pure gold, this is below the nisab. Some Hanafi muftis count jewellery that is mostly gold (such as 22K) by its full weight; on that view zakat would be due. Ask your mufti which view to follow.',
			n_maliki_debts: 'Maliki: a debt is first set against things you own but do not need (a spare plot or car, for example); only the rest reduces zakat. We deduct the whole debt.',
			fd_madhabNote: 'Amount per day: Hanafi fiqh uses one fitrana (half a sa\' of wheat or its value). The Shafi\'i, Maliki and Hanbali schools use one mudd of food (about 0.6 kg), which is less.',
			n_receivables_maliki: 'Maliki: for a cash loan, zakat is paid once when it is received. To follow that, move it to the doubtful line. Trade debts of a merchant are counted every year.',
		},
		ur: {
			madhab: 'مسلک', currency: 'کرنسی', unit: 'وزن کی اکائی', change: 'تبدیل کریں', done: 'ٹھیک ہے',
			u_tola: 'تولہ', u_gram: 'گرام', u_oz: 'اونس', uo_tola: 'تولہ', uo_gram: 'گرام', uo_oz: 'اونس', mins: 'منٹ', hours: 'گھنٹے', days: 'دن',
			spotRate: 'بین الاقوامی اسپاٹ ریٹ', weight: 'وزن', maund: 'من', kg: 'کلو', maund40: 'من (40 کلو)',
			forget: 'محفوظ ڈیٹا مٹائیں', forgetConfirm: 'کیلکولیٹرز نے اس براؤزر میں جو کچھ محفوظ کیا ہے (رقمیں، گھر کے افراد، زبان اور یاد دہانی کی تاریخیں) سب مٹا دیں؟', forgotten: 'محفوظ ڈیٹا اس براؤزر سے مٹا دیا گیا۔',
			m_hanafi: 'حنفی', m_shafii: 'شافعی', m_maliki: 'مالکی', m_hanbali: 'حنبلی', m_ahlehadith: 'اہلِ حدیث', m_jafari: 'شیعہ (جعفری)',
			gold24: 'سونا 24 قیراط', silver: 'چاندی', nisab: 'نصاب', per: '/', updated: 'اپڈیٹ', ago: 'پہلے', manualRate: 'سائٹ کے مالک کا دستی ریٹ', fxRates: 'کرنسی ریٹ',
			ownRate: 'اپنا مقامی ریٹ لکھیں', ownGold: 'سونا 24 قیراط فی', ownSilver: 'چاندی فی',
			rateMissing: 'ابھی لائیو ریٹ دستیاب نہیں۔ براہ کرم اپنا مقامی ریٹ لکھیں۔',
			ownNeedBoth: 'اپنا ریٹ استعمال کرنے کے لیے سونے اور چاندی دونوں کا ریٹ لکھیں۔ تب تک لائیو ریٹ استعمال ہوگا۔',
			quickPh: 'لکھیں: 3 tola sona, 5 lakh cash aur 1 lakh qarz', fill: 'بھریں',
			filled: 'آپ کی تحریر سے خانے بھر دیے گئے۔ نیچے چیک کر لیں۔', notUnderstood: 'سمجھ نہیں آیا۔ ایسے لکھیں: 3 tola sona, 2 lakh bank',
			have: 'آپ کے پاس کیا ہے؟', haveHint: '(جو ہے اس پر ٹیپ کریں)',
			t_cash: 'نقد', t_bank: 'بینک', t_gold: 'سونا', t_silver: 'چاندی', t_business: 'کاروبار', t_shares: 'شیئرز/کرپٹو',
			t_committee: 'کمیٹی', t_receivables: 'لینا ہے', t_plot: 'پلاٹ (بیچنے کے لیے)', t_debts: 'قرض/بل',
			f_cash: 'گھر میں نقد رقم', f_prizeBonds: 'پرائز بانڈ', f_savingsCerts: 'بچت سرٹیفکیٹ (این ایس سی، بہبود، ڈی ایس سی، آر آئی سی)',
			t_paid: 'ادا شدہ', f_bankDeducted: 'یکم رمضان کو بینک کی کاٹی گئی زکوٰۃ', f_paidAlready: 'اس سال پہلے سے ادا کی گئی زکوٰۃ',
			h_bankDeducted: 'بینک اسٹیٹمنٹ یا زکوٰۃ سرٹیفکیٹ پر لکھی ہوتی ہے۔', h_savingsCerts: 'لگائی گئی رقم (فیس ویلیو) لکھیں۔',
			l_paid: 'ادا شدہ / بینک کی کٹوتی', toPay: 'ابھی ادا کرنی ہے', totalZakat: 'کل زکوٰۃ', f_bank: 'بینک بیلنس (تمام اکاؤنٹ)',
			f_goldWorn: 'پہنا جانے والا سونے کا زیور (مردوں کا سونا نہیں)', f_goldKept: 'باقی سونا (بسکٹ، سکے، رکھا ہوا زیور)',
			f_silverWorn: 'پہنا جانے والا چاندی کا زیور', f_silverKept: 'باقی چاندی',
			f_businessCash: 'کاروبار کی نقد اور بینک رقم', f_stock: 'مال / اسٹاک (فروخت کی قیمت)', f_suppliers: 'سپلائرز کے واجب الادا بل',
			f_shares: 'شیئرز / میوچل فنڈ (مارکیٹ قیمت)', f_crypto: 'کرپٹو (مارکیٹ قیمت)',
			f_committee: 'کمیٹی میں اب تک جمع کرائی رقم', f_receivables: 'دوسروں سے لینا (واپسی کی امید)',
			f_receivablesDoubtful: 'مشکوک قرض (ملنے پر زکوٰۃ)', f_plot: 'بیچنے کی نیت سے خریدا پلاٹ (مارکیٹ قیمت)', f_other: 'دیگر تجارتی مال',
			f_debts: 'فوری ادا کرنے والا قرض', f_installments: 'اگلے 12 ماہ کی قسطیں', f_bills: 'واجب الادا بل (کرایہ، بجلی)',
			h_committee: 'جتنی رقم اب تک جمع کرائی، اس پر زکوٰۃ ہے۔', h_plot: 'رہائشی گھر پر زکوٰۃ نہیں۔',
			h_goldWorn: 'پہنے ہوئے زیور پر مسالک کا اختلاف ہے، نتیجے میں وضاحت ہے۔', h_stock: 'موجودہ فروخت کی قیمت لکھیں۔',
			karat: 'قیراط', me: 'میں', addPerson: '+ گھر کا فرد', personName: 'نام', remove: 'ہٹائیں',
			family: 'گھر کا کل', yourZakat: 'آپ کی زکوٰۃ', zakatFor: 'زکوٰۃ برائے',
			due: 'نصاب سے زیادہ، زکوٰۃ فرض ہے', notDue: 'نصاب سے کم، زکوٰۃ فرض نہیں', khumsBadge: 'آیت اللہ سیستانی کے مطابق ان چیزوں پر زکوٰۃ نہیں؛ خمس دیکھیں',
			l_money: 'نقد، بینک اور تجارتی مال', l_goldKept: 'سونا (رکھا ہوا)', l_goldWorn: 'سونے کا زیور (پہنا ہوا)',
			l_silverKept: 'چاندی (رکھی ہوئی)', l_silverWorn: 'چاندی کا زیور (پہنا ہوا)', l_debts: 'قرض منہا',
			l_gold: 'سونا', l_silver: 'چاندی', l_total: 'قابلِ زکوٰۃ مال', l_rate: '× 2.5%', why: 'کیوں؟',
			w_jewellery_yes: 'اس مسلک میں سونے چاندی کے زیور پر زکوٰۃ ہے، چاہے پہنا جائے۔',
			w_jewellery_no: 'اس مسلک میں پہنے جانے والے جائز زیور پر زکوٰۃ نہیں۔',
			w_debts_yes: 'نصاب دیکھنے سے پہلے فوری قرض منہا کیا جاتا ہے۔',
			w_debts_no: 'اس مسلک میں قرض زکوٰۃ کم نہیں کرتا۔',
			w_shafii_jewellery_excess: 'شافعی فقہ میں عرف سے زیادہ (تقریباً 860 گرام سے اوپر) پہنا زیور شامل کیا جاتا ہے۔',
			w_jafari_money: 'آیت اللہ سیستانی کے مطابق کاغذی کرنسی پر زکوٰۃ نہیں، اس کے بجائے خمس ہو سکتا ہے۔',
			w_jafari_gold: 'آیت اللہ سیستانی کے مطابق زکوٰۃ صرف ان سونے چاندی کے سکوں پر ہے جو بطور کرنسی چلیں، جو آج نہیں۔',
			n_jafari_khums: 'فقہ جعفری (سیستانی) میں ان چیزوں پر زکوٰۃ نہیں، لیکن سالانہ بچت پر خمس (20%) واجب ہو سکتا ہے۔',
			n_shafii_excess_jewellery: 'تقریباً 860 گرام سے زیادہ پہنا سونا عرف سے زیادہ ہے، اس لیے شامل ہے۔',
			n_shafii_separate: 'شافعی فقہ میں سونا اور چاندی الگ ہیں؛ دوسری دھات اپنے نصاب سے دیکھی جاتی ہے۔',
			n_doubtful_receivables: 'مشکوک قرض ابھی شامل نہیں؛ ملنے پر اس کی زکوٰۃ دیں۔',
			n_debts_vs_metal: 'آپ پر قرض ہے اور صرف ایک دھات ہے: اسی دھات کا نصاب (وزن) لگا، اور قرض اس کی قیمت سے منہا کیا گیا۔',
			nisabUsed: 'نصاب', basisGold: 'سونا (87.48 گرام)', basisSilver: 'چاندی (612.35 گرام)', basisCoins: 'صرف سکے',
			chooseNisab: 'نصاب کا معیار', compare: 'تمام مسالک کا موازنہ', hideCompare: 'موازنہ چھپائیں',
			pdf: 'PDF رپورٹ', whatsapp: 'واٹس ایپ', calendar: 'کیلنڈر میں شامل کریں', report: 'غلطی بتائیں',
			saveFile: 'ڈیٹا فائل محفوظ کریں', loadFile: 'ڈیٹا فائل کھولیں', reset: 'سب صاف کریں',
			pdfName: 'رپورٹ پر نام (اختیاری)', makePdf: 'PDF ڈاؤن لوڈ کریں', making: 'تیار ہو رہی ہے…',
			cmpTitle: 'ہر مسلک میں آپ کی زکوٰۃ', cmpSub: 'ایک ہی معلومات، حوالوں کے ساتھ',
			c_madhab: 'مسلک', c_jewellery: 'پہنا زیور', c_debts: 'قرض منہا', c_nisab: 'نصاب', c_zakat: 'زکوٰۃ', c_ref: 'حوالہ',
			yes: 'ہاں', no: 'نہیں', included: 'شامل', includedAbove: 'حد سے زیادہ پر شامل', exempt: 'نہیں', lower: 'جو کم ہو', seeKhums: 'خمس دیکھیں',
			disc: 'یہ کیلکولیٹر صرف رہنمائی کے لیے اندازہ دیتا ہے۔ یہ فتویٰ نہیں، اور اس میں غلطی ممکن ہے۔ زکوٰۃ ادا کرنے سے پہلے اپنے مسلک کے مستند عالم سے تصدیق کر لیں۔',
			discLink: 'ڈسکلیمر', resetConfirm: 'سب خانے صاف کر دیں؟', savedLocal: 'صرف اسی ڈیوائس پر محفوظ۔',
			shareText: 'میری زکوٰۃ کا اندازہ', calTitle: 'زکوٰۃ کی تاریخ (ایک قمری سال)',
			persons: 'افراد کی تعداد', item: 'کس چیز سے', perPerson: 'فی فرد رقم', fitranaTotal: 'کل فطرانہ',
			mh_kind: 'مہر', mh_min: 'کم سے کم مہر (حنفی)', mh_fatimi: 'مہرِ فاطمی', mh_silver: 'چاندی', mh_value: 'آج کی قیمت',
			mh_dirham: 'درہم', mh_other: 'علما کی دوسری آرا', mh_check: 'اپنا مہر جانچیں', mh_mine: 'آپ کا طے شدہ مہر', mh_mineHelp: 'نکاح نامے میں لکھی رقم لکھیں اور دیکھیں کہ یہ کتنی چاندی بنتی ہے۔',
			mh_inSilver: 'برابر ہے', mh_ofFatimi: 'مہرِ فاطمی کا', mh_belowMin: 'یہ حنفی کم سے کم مہر (10 درہم) سے کم ہے۔ حنفی مسلک میں ایسی صورت میں مہر کم سے کم مقدار تک بڑھ جاتا ہے۔',
			mh_metal: 'مہر سونے یا چاندی میں طے ہے؟', mh_metalHelp: 'اگر نکاح نامے میں مثلاً 5 تولہ سونا لکھا ہے تو اس کی آج کی قیمت دیکھیں۔', mh_qty: 'وزن', mh_gold24: 'سونا 24 قیراط', mh_gold22: 'سونا 22 قیراط',
			mh_madhabNote: 'شافعی اور حنبلی علما کے نزدیک کوئی کم سے کم حد نہیں: ہر قیمتی چیز مہر بن سکتی ہے۔ مالکی: چوتھائی دینار سونا یا 3 درہم چاندی۔ شیعہ (سیستانی): کوئی کم سے کم حد نہیں؛ مہرُ السنہ 500 درہم ہے۔',
			dy_notified: 'دیت برائے مالی سال', dy_from: 'نافذ از یکم جولائی', dy_live: 'آج کے ریٹ پر 30,630 گرام چاندی', dy_liveHelp: 'قانون کے مطابق دیت 30,630 گرام چاندی کی قیمت ہے۔ حکومت سال میں ایک بار روپوں میں رقم کا اعلان کرتی ہے، اس لیے لائیو قیمت چاندی کے ساتھ بدلتی ہے۔',
			dy_history: 'اعلان کردہ رقمیں', dy_fy: 'مالی سال', dy_amount: 'رقم', dy_source: 'ماخذ', dy_noRate: 'ابھی روپے میں چاندی کا لائیو ریٹ دستیاب نہیں۔',
			dy_note: 'عدالت اعلان کردہ رقم سے زیادہ دیت دے سکتی ہے، کم نہیں (تعزیراتِ پاکستان دفعہ 323)۔ یہ معلومات ہیں، قانونی مشورہ نہیں؛ کسی مقدمے کے لیے وکیل سے پوچھیں۔',
			fd_fasts: 'روزے جن کی قضا ممکن نہیں (فدیہ)', fd_broken: 'کتنے کفارے واجب ہیں (توڑے گئے روزوں کی تعداد نہیں)', fd_perDay: 'ایک مسکین کا ایک دن کا کھانا', fd_fidya: 'فدیہ', fd_kaffara: 'کفارہ (ہر ایک کے لیے 60 مسکین)', fd_total: 'کل رقم',
			fd_hFasts: 'صرف بیماری یا بڑھاپے میں جب بعد میں روزہ رکھنے کی امید نہ ہو۔ ورنہ قضا رکھیں۔', fd_hBroken: 'حنفی: ایک رمضان کے کئی توڑے گئے روزوں کا ایک کفارہ کافی ہے۔ کھانا کھلانا صرف اس کے لیے ہے جو 60 مسلسل روزے نہ رکھ سکے۔',
			wheat: 'گندم / آٹا', barley: 'جو', dates: 'کھجور', raisins: 'کشمش',
			h_start: 'جس دن مال پہلی بار نصاب کو پہنچا (یا آپ کی زکوٰۃ کی تاریخ)', h_next: 'آپ کی اگلی زکوٰۃ کی تاریخیں', h_left: 'دن باقی',
			h_ics: 'اگلی 5 تاریخیں کیلنڈر میں شامل کریں', h_note: 'قمری سال کی وجہ سے تاریخ ہر سال تقریباً 11 دن پہلے آتی ہے۔ چاند کے حساب سے ایک دن کا فرق ہو سکتا ہے۔',
			h_missed: 'رہ جانے والے سال', h_missedN: 'کتنے سال کی زکوٰۃ ادا نہیں ہوئی؟', h_wealthY: 'زکوٰۃ کی تاریخ پر قابلِ زکوٰۃ مال، سال', h_sub: 'پچھلی ادا نہ کی گئی زکوٰۃ کو قرض شمار کریں (حنفی)',
			h_nisabNow: 'نصاب (آج کی قیمت، چاہیں تو بدلیں)', h_missedTotal: 'رہ جانے والے سالوں کی زکوٰۃ', h_yearsSince: 'اس تاریخ سے گزرے قمری سال',
			u_crops: 'فصل (عشر)', u_animals: 'مویشی', u_madhab: 'مسلک', u_hanafi: 'حنفی', u_others: 'شافعی، مالکی، حنبلی، اہلِ حدیث', u_jafari: 'جعفری (سیستانی)',
			u_jafariNote: 'آیت اللہ سیستانی: نصاب زیادہ ہے (تقریباً 847 کلو)، اور فصل کی زکوٰۃ صرف گندم، جو، کھجور اور کشمش پر ہے۔',
			u_notDueJ: 'تقریباً 847 کلو سے کم: اس فصل پر زکوٰۃ نہیں (آیت اللہ سیستانی)۔',
			u_qty: 'پیداوار کی مقدار', u_price: 'قیمت فی', u_water: 'آب پاشی', u_rain: 'بارش / دریا (10%)', u_irr: 'ٹیوب ویل / خریدا پانی (5%)', u_mixed: 'آدھا آدھا (7.5%)',
			u_due: 'عشر', u_value: 'قیمت', u_notDue: 'پانچ وسق (تقریباً 653 کلو) سے کم: اس مسلک میں عشر نہیں۔',
			u_note: 'عشر فصل کٹنے پر واجب ہے، سال گزرنا شرط نہیں۔ بیج، کھاد اور مزدوری کا خرچ روایتی رائے میں منہا نہیں ہوتا؛ بعض علما اجازت دیتے ہیں، اپنے عالم سے پوچھیں۔ حنفی: دونوں طرح کا پانی ہو تو جو زیادہ عرصہ استعمال ہوا اس کا اعتبار ہے۔',
			a_sheep: 'بکریاں اور بھیڑیں', a_cows: 'گائے اور بھینسیں', a_camels: 'اونٹ', a_give: 'دیں',
			a_none: 'نصاب سے کم: کچھ واجب نہیں۔', w_sheep: 'بکری یا بھیڑ (کم از کم 1 سال)', w_tabi: 'دوسرے سال کا بچھڑا (تبیع)', w_musinnah: 'تیسرے سال کی گائے (مسنہ)',
			w_bintMakhad: 'دوسرے سال کی اونٹنی', w_bintLabun: 'تیسرے سال کی اونٹنی', w_hiqqa: 'چوتھے سال کی اونٹنی', w_jadha: 'پانچویں سال کی اونٹنی', w_askScholar: '120 سے زیادہ اونٹ: عالم سے پوچھیں، مسالک میں اختلاف ہے۔',
			a_note: 'صرف ان جانوروں پر جو سال کا زیادہ حصہ چر کر گزارتے ہوں، کام میں نہ لیے جاتے ہوں اور ایک قمری سال ملکیت میں رہے ہوں۔ بیچنے کے لیے رکھے جانور تجارتی مال ہیں۔',
			k_date: 'آپ کی خمس کی تاریخ', k_ics: 'خمس کی تاریخ کیلنڈر میں شامل کریں', k_paid: 'شامل نہیں: وہ رقم جس کا خمس ادا ہو چکا، وراثت اور مہر۔ آیت اللہ سیستانی کے نزدیک تحفہ آمدنی ہے: جو بچا ہو اسے بچت میں شامل کریں۔',
			k_where: 'سہمِ امام اپنے مرجع کے دفتر یا مجاز نمائندے کو، اور سہمِ سادات مستحق سادات کو دیں۔',
			k_savings: 'اس سال کی آمدنی سے بچت', k_unused: 'آمدنی سے خریدی غیر استعمال شدہ چیزیں', k_stock: 'تجارتی مال (آمدنی سے)', k_debts: 'اس سال کے قرض',
			k_total: 'خمس (20%)', k_surplus: 'بچت', k_imam: 'سہمِ امام (10%)', k_sadat: 'سہمِ سادات (10%)',
			perGram: 'فی گرام', perTola: 'فی تولہ', perOz: 'فی اونس', purity: 'خالصیت',
			err_negative: 'رقم منفی نہیں ہو سکتی۔ قرض "قرض/بل" والے حصے میں لکھیں۔ یہ رقم شامل نہیں کی گئی۔',
			err_negative_any: 'رقم منفی نہیں ہو سکتی۔ یہ رقم شامل نہیں کی گئی۔',
			err_invalid: 'صرف عدد لکھیں، مثلاً 250000 یا 2,50,000۔ یہ رقم شامل نہیں کی گئی۔',
			fineness: 'خالصیت', fine999: 'خالص (999)', fine925: 'اسٹرلنگ (925)', fine900: '900',
			c_toPay: 'ابھی ادا کرنی ہے',
			fileBad: 'یہ فائل نہیں کھل سکی۔ اسی کیلکولیٹر سے محفوظ کی گئی ڈیٹا فائل منتخب کریں۔',
			fileCur: 'یہ فائل %s میں محفوظ تھی جو یہاں دستیاب نہیں۔ رقمیں %t میں دکھائی گئی ہیں: براہ کرم چیک کر لیں۔',
			fileOk: 'ڈیٹا فائل کھل گئی۔',
			f_noPreset: 'اپنے علاقے کے لیے اس سال اعلان کردہ فطرانہ کی رقم لکھیں۔',
			f_fallback: 'پچھلی اعلان کردہ رقم دکھائی گئی ہے۔ اپنے علاقے کی اس سال کی رقم لکھ دیں۔',
			h_oldest: 'سال 1 سب سے پرانا سال ہے۔', h_nisabY: 'اس سال کا نصاب (اختیاری)',
			h_basis: 'پچھلے سالوں کے لیے نصاب کا معیار', h_nisabNote: 'حنفی چاندی کا نصاب لیتے ہیں؛ شافعی اور بعض دوسرے سونے کا۔ کسی پچھلے سال کا نصاب معلوم ہو تو اس سال کے خانے میں لکھیں۔',
			a_madhabNote: 'مالکی فقہ میں چارہ کھانے والے اور کام کے جانوروں پر بھی زکوٰۃ ہے۔ فقہ جعفری (آیت اللہ سیستانی) کے بعض جدول مختلف ہیں۔ یہ ٹول حنفی، شافعی اور حنبلی جدول پر ہے: اپنے مسلک کے عالم سے تصدیق کریں۔',
			h_receivables: 'ابھی شامل ہے۔ حنفی اور مالکی علما نقد قرض کی زکوٰۃ وصولی پر دینے کی اجازت دیتے ہیں: ایسا کرنا ہو تو اسے اگلے خانے میں لکھیں۔',
			n_hanafi_alloy: 'خالص سونے کے حساب سے یہ نصاب سے کم ہے۔ بعض حنفی مفتی صاحبان زیادہ تر سونے والے زیور (جیسے 22 قیراط) کو پورے وزن سے گنتے ہیں؛ اس رائے پر زکوٰۃ واجب ہوگی۔ اپنے مفتی صاحب سے پوچھیں۔',
			n_maliki_debts: 'مالکی: قرض پہلے ان چیزوں سے پورا سمجھا جاتا ہے جو آپ کی ضرورت سے زائد ہوں (مثلاً فالتو پلاٹ یا گاڑی)؛ صرف باقی قرض زکوٰۃ کم کرتا ہے۔ ہم پورا قرض منہا کرتے ہیں۔',
			fd_madhabNote: 'روزانہ رقم: حنفی فقہ میں ایک فطرانہ (آدھا صاع گندم یا اس کی قیمت)۔ شافعی، مالکی اور حنبلی مسالک میں ایک مُد کھانا (تقریباً 0.6 کلو)، جو کم ہے۔',
			n_receivables_hanafi: 'حنفی: چاہیں تو دوسروں سے لینے والی رقم کی زکوٰۃ وصول ہونے پر، گزرے ہر سال کی، ادا کر سکتے ہیں۔',
			n_receivables_maliki: 'مالکی: نقد قرض کی زکوٰۃ وصول ہونے پر ایک بار دی جاتی ہے۔ اس کے لیے اسے مشکوک والے خانے میں لکھیں۔ تاجر کے تجارتی قرض ہر سال شامل ہیں۔',
		},
	};

	var lang = 'en';
	try { lang = localStorage.getItem(LANG_KEY) || (document.documentElement.lang || '').slice(0, 2) || 'en'; } catch (e) {}
	if (CFG.lang && T[CFG.lang]) lang = CFG.lang; // server-rendered Urdu pages (FIX-046)
	if (!T[lang]) lang = 'en';
	function t(k) { return (T[lang] && T[lang][k]) || T.en[k] || k; }

	/* ---------- helpers ---------- */
	function esc(s) {
		return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) {
			return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
		});
	}
	/** Typed amount as a number; negative or unreadable input counts as 0 and is flagged by checkInput(). */
	function num(v) { return E.parseAmount(v).value; }
	/** Mark a number box invalid (aria-invalid plus an inline message) while it holds a negative or unreadable value. */
	function checkInput(el) {
		var r = E.parseAmount(el.value), box = el.closest('.myzt-field') || el.parentNode;
		var msg = box.querySelector('.myzt-err');
		if (r.ok) {
			el.removeAttribute('aria-invalid');
			if (msg) { msg.remove(); el.removeAttribute('aria-describedby'); }
			return true;
		}
		el.setAttribute('aria-invalid', 'true');
		if (!msg) {
			msg = document.createElement('div');
			msg.className = 'myzt-err';
			msg.setAttribute('role', 'alert');
			if (el.id) { msg.id = el.id + '-err'; el.setAttribute('aria-describedby', msg.id); }
			box.appendChild(msg);
		}
		// Only the main calculator has a Debts / Bills section to point to (FIX-125).
		var w = el.closest('.myzt[data-widget]');
		msg.textContent = t(r.error === 'negative' && !(w && w.dataset.widget === 'calculator') ? 'err_negative_any' : 'err_' + r.error);
		return false;
	}
	function isNumberBox(el) { return el && el.tagName === 'INPUT' && /^(decimal|numeric)$/.test(el.getAttribute('inputmode') || ''); }
	document.addEventListener('input', function (e) { if (isNumberBox(e.target) && e.target.closest('.myzt')) checkInput(e.target); }, true);
	function lakhLocale(cur) { return /^(PKR|INR|BDT|NPR|LKR)$/.test(cur) ? 'en-IN' : 'en-US'; }
	function money(v, cur) {
		try {
			var small = Math.abs(v || 0) < 100;
			return new Intl.NumberFormat(lakhLocale(cur), { style: 'currency', currency: cur, minimumFractionDigits: 0, maximumFractionDigits: small ? 2 : 0, currencyDisplay: 'narrowSymbol' }).format(small ? (v || 0) : Math.round(v || 0));
		} catch (e) { return cur + ' ' + Math.round(v || 0).toLocaleString(); }
	}
	function plain(v, cur) {
		if (!v) return '';
		return new Intl.NumberFormat(lakhLocale(cur), { maximumFractionDigits: 2 }).format(v);
	}
	function flag(cc) {
		if (!cc || cc.length !== 2) return '';
		return String.fromCodePoint(127397 + cc.charCodeAt(0), 127397 + cc.charCodeAt(1));
	}
	function ago(ts) {
		if (!ts) return '';
		var m = Math.max(1, Math.round((Date.now() / 1000 - ts) / 60));
		if (m < 60) return m + ' ' + t('mins') + ' ' + t('ago');
		var h = Math.round(m / 60);
		if (h < 48) return h + ' ' + t('hours') + ' ' + t('ago');
		return Math.round(h / 24) + ' ' + t('days') + ' ' + t('ago');
	}
	/* "updated 20 min ago", plus a manual-rate label and the FX age when currency rates lag. */
	function stamp() {
		var s = t('updated') + ' ' + ago(RATES.updated);
		if (RATES.source === 'manual') s += ' · ' + t('manualRate');
		if (RATES.fxUpdated && Date.now() / 1000 - RATES.fxUpdated > 6 * 3600) s += ' · ' + t('fxRates') + ' ' + ago(RATES.fxUpdated);
		return s;
	}
	function load(k, d) { try { var v = localStorage.getItem(k); return v ? JSON.parse(v) : d; } catch (e) { return d; } }
	function save(k, v) { try { localStorage.setItem(k, JSON.stringify(v)); } catch (e) {} }
	function unitLabel(u) { return t(u === 'tola' ? 'u_tola' : u === 'oz' ? 'u_oz' : 'u_gram'); }
	/* Madhab name in the page language; the engine's English name stays in the PDF (FIX-055). */
	function mname(k) { return lang === 'en' ? E.MADHABS[k].name : t('m_' + k); }
	/* Every key this site keeps in the browser starts with "myzt_" (draft, language, hawl, khums date). */
	function forgetAll() {
		try {
			for (var i = localStorage.length - 1; i >= 0; i--) {
				var k = localStorage.key(i);
				if (k && k.indexOf('myzt_') === 0) localStorage.removeItem(k);
			}
		} catch (e) {}
	}
	/* Page language on a widget root: lang for screen readers and fonts, dir for layout (FIX-055). */
	function setLang(el) { el.lang = lang; el.dir = lang === 'ur' ? 'rtl' : 'ltr'; }
	/** The text of an element as one line, with a space between its parts (for screen readers). */
	function textOf(el) {
		var out = [], w = document.createTreeWalker(el, NodeFilter.SHOW_TEXT);
		while (w.nextNode()) { var v = w.currentNode.nodeValue.trim(); if (v) out.push(v); }
		return out.join(' ');
	}
	/*
	 * The small widgets get a polite live region like the calculator's (FIX-054, FIX-115). Call it
	 * after the widget's own listeners: once the visitor types or picks something and pauses, the
	 * result text from read() is spoken if it changed. Page load and rate refreshes stay silent.
	 */
	function speaker(root, read) {
		var live = document.createElement('div'), timer = 0, last = read();
		live.className = 'myzt-sr';
		live.setAttribute('role', 'status');
		live.setAttribute('aria-live', 'polite');
		root.parentNode.insertBefore(live, root.nextSibling);
		function check() {
			clearTimeout(timer);
			timer = setTimeout(function () {
				var text = read();
				if (!text || text === last) return;
				last = text;
				setLang(live);
				live.textContent = text;
			}, 900);
		}
		['input', 'change', 'click'].forEach(function (ev) { root.addEventListener(ev, check); });
	}
	/*
	 * A PDF button under a small widget (FIX-126): the fields as entered and the result lines, read
	 * from the widget itself so every tool shares one report. English pages only, because the PDF
	 * fonts have no Urdu letters.
	 */
	function pdfButton(root, title) {
		if (lang === 'ur' || !CFG.pdfUrl || root.closest('.myzt-ur')) return;
		var wrap = document.createElement('div'), btn = document.createElement('button');
		wrap.className = 'myzt myzt-pdfrow';
		btn.type = 'button';
		btn.className = 'myzt-btn';
		btn.textContent = '🖨 ' + t('pdf');
		wrap.appendChild(btn);
		// After the live region, which stays right after the widget (FIX-115).
		var after = root.nextElementSibling && root.nextElementSibling.classList.contains('myzt-sr') ? root.nextElementSibling : root;
		after.parentNode.insertBefore(wrap, after.nextSibling);
		function labelOf(l) { var c = l.cloneNode(true); c.querySelectorAll('.myzt-help').forEach(function (h) { h.remove(); }); return textOf(c); }
		btn.addEventListener('click', function () {
			var data = { title: title, inputs: [], results: [] };
			root.querySelectorAll('.myzt-field').forEach(function (f) {
				var l = f.querySelector('label'), i = f.querySelector('input:not([type=checkbox]), select'), on = f.querySelectorAll('[aria-pressed="true"]');
				var v = i ? i.value : [].map.call(on, textOf).join(', ');
				if (l && v) data.inputs.push([labelOf(l), v]);
			});
			root.querySelectorAll('.myzt-line, .myzt-due, tbody tr').forEach(function (el) {
				if (el.classList.contains('myzt-due')) {
					var amt = el.nextElementSibling;
					if (amt && amt.classList.contains('myzt-amt')) data.results.push([textOf(el), textOf(amt), true]);
				} else if (el.children.length > 1) {
					data.results.push([textOf(el.children[0]), [].slice.call(el.children, 1).map(textOf).join('  ·  ')]);
				}
			});
			btn.disabled = true;
			btn.textContent = t('making');
			var done = function () { btn.disabled = false; btn.textContent = '🖨 ' + t('pdf'); };
			loadPdf().then(function (P) { return P.simple(data); }).then(done, done);
		});
	}
	/** The text of the first element matching sel inside root, or ''. */
	function outText(root, sel) { var el = root.querySelector(sel); return el ? textOf(el) : ''; }
	function unitGrams(u) { return u === 'tola' ? E.GRAMS_PER_TOLA : u === 'oz' ? E.GRAMS_PER_OZ : 1; }
	/** Calendar file with one all-day event per date and a reminder 3 days before. */
	function icsFile(name, title, dates) {
		var stamp = new Date().toISOString().replace(/[-:]/g, '').slice(0, 15) + 'Z';
		var lines = ['BEGIN:VCALENDAR', 'VERSION:2.0', 'PRODID:-//My Zakat Tool//EN'];
		dates.forEach(function (iso, i) {
			var d = iso.replace(/-/g, '');
			var end = new Date(Date.parse(iso + 'T00:00:00Z') + 864e5).toISOString().slice(0, 10).replace(/-/g, '');
			lines.push('BEGIN:VEVENT', 'UID:' + Date.now() + '-' + i + '@myzakattool', 'DTSTAMP:' + stamp, 'DTSTART;VALUE=DATE:' + d, 'DTEND;VALUE=DATE:' + end,
				'SUMMARY:' + title, 'DESCRIPTION:' + (CFG.siteUrl || location.origin), 'BEGIN:VALARM', 'TRIGGER:-P3D', 'ACTION:DISPLAY', 'DESCRIPTION:' + title, 'END:VALARM', 'END:VEVENT');
		});
		lines.push('END:VCALENDAR');
		download(name, new Blob([lines.join('\r\n')], { type: 'text/calendar' }));
	}

	function hijri(iso) {
		try {
			return new Intl.DateTimeFormat((lang === 'ur' ? 'ur' : 'en') + '-u-ca-islamic-umalqura', { day: 'numeric', month: 'long', year: 'numeric', timeZone: 'UTC' }).format(new Date(iso + 'T00:00:00Z'));
		} catch (e) { return ''; }
	}

	/** Hijri day and month of an ISO date (Umm al-Qura), or null if the browser has no Islamic calendar. */
	function hijriDM(iso) {
		try {
			var o = {};
			new Intl.DateTimeFormat('en-u-ca-islamic-umalqura-nu-latn', { day: 'numeric', month: 'numeric', timeZone: 'UTC' }).formatToParts(new Date(iso + 'T00:00:00Z')).forEach(function (p) { o[p.type] = parseInt(p.value, 10); });
			return o.day && o.month ? o : null;
		} catch (e) { return null; }
	}

	/**
	 * Move each lunar-year date (from a fixed day count) by up to 3 days so it falls on the same
	 * Hijri day and month as the start date, matching the Hijri label shown next to it.
	 */
	function alignHijri(dates, startIso) {
		var s = hijriDM(startIso);
		if (!s) return dates;
		return dates.map(function (iso) {
			var base = Date.parse(iso + 'T00:00:00Z'), offs = [0, -1, 1, -2, 2, -3, 3], fallback = null;
			for (var i = 0; i < offs.length; i++) {
				var c = new Date(base + offs[i] * 864e5).toISOString().slice(0, 10), h = hijriDM(c);
				if (!h || h.month !== s.month) continue;
				if (h.day === s.day) return c;
				// Day 30 does not exist in a 29-day month: use the 29th.
				if (s.day === 30 && h.day === 29 && !fallback) fallback = c;
			}
			return fallback || iso;
		});
	}

	/** Next zakat dates on the same Hijri date as the start, from today on. */
	function zakatDates(startIso, count, fromIso) {
		var early = new Date(Date.parse(fromIso + 'T00:00:00Z') - 4 * 864e5).toISOString().slice(0, 10);
		return alignHijri(E.hawlDates(startIso, count + 2, early), startIso).filter(function (d) { return d >= fromIso; }).slice(0, count);
	}

	/** Re-render a widget and give focus back to the same control (matched by its id or data-* attributes). */
	function keepFocus(root, draw) {
		var a = document.activeElement, sel = '';
		if (a && a !== root && root.contains(a)) {
			if (a.id) sel = '#' + (window.CSS && CSS.escape ? CSS.escape(a.id) : a.id);
			else {
				for (var i = 0; i < a.attributes.length; i++) {
					var at = a.attributes[i];
					if (at.name.indexOf('data-') === 0) sel += '[' + at.name + '="' + String(at.value).replace(/["\\]/g, '\\$&') + '"]';
				}
				if (sel) sel = a.tagName.toLowerCase() + sel;
			}
		}
		draw();
		if (!sel) return;
		try {
			var el = root.querySelector(sel);
			if (el && el.focus) el.focus({ preventScroll: true });
		} catch (e) {}
	}

	function niceDate(iso) {
		try { return new Intl.DateTimeFormat(lang === 'ur' ? 'ur-PK' : 'en-GB', { day: 'numeric', month: 'long', year: 'numeric', timeZone: 'UTC' }).format(new Date(iso + 'T00:00:00Z')); } catch (e) { return iso; }
	}

	function download(name, blob) {
		var a = document.createElement('a');
		a.href = URL.createObjectURL(blob);
		a.download = name;
		document.body.appendChild(a);
		a.click();
		setTimeout(function () { URL.revokeObjectURL(a.href); a.remove(); }, 500);
	}

	/* pdf.js is only fetched when someone makes a report, so page load skips it (FIX-049). */
	var pdfReq = null;
	function loadPdf() {
		if (window.MYZT_PDF) return Promise.resolve(window.MYZT_PDF);
		if (!pdfReq) {
			pdfReq = new Promise(function (resolve, reject) {
				var s = document.createElement('script');
				s.src = CFG.pdfUrl;
				s.async = true;
				s.onload = function () { window.MYZT_PDF ? resolve(window.MYZT_PDF) : reject(new Error('pdf')); };
				s.onerror = function () { pdfReq = null; reject(new Error('pdf')); };
				document.head.appendChild(s);
			});
		}
		return pdfReq;
	}

	var RATES = CFG.rates || {};
	// Country guess without any IP lookup: time zone first, then browser language, then the CDN header.
	var TZ = {
		'Asia/Karachi': 'PK', 'Asia/Kolkata': 'IN', 'Asia/Calcutta': 'IN', 'Asia/Dhaka': 'BD', 'Asia/Kabul': 'AF', 'Europe/Istanbul': 'TR',
		'Asia/Tashkent': 'UZ', 'Asia/Jakarta': 'ID', 'Asia/Makassar': 'ID', 'Asia/Jayapura': 'ID', 'Asia/Pontianak': 'ID', 'Asia/Kuala_Lumpur': 'MY',
		'Asia/Kuching': 'MY', 'Asia/Brunei': 'BN', 'Asia/Singapore': 'SG', 'Africa/Cairo': 'EG', 'Africa/Mogadishu': 'SO', 'Asia/Aden': 'YE',
		'Asia/Colombo': 'LK', 'Africa/Casablanca': 'MA', 'Africa/Algiers': 'DZ', 'Africa/Tunis': 'TN', 'Africa/Tripoli': 'LY', 'Africa/Lagos': 'NG',
		'Africa/Dakar': 'SN', 'Africa/Bamako': 'ML', 'Africa/Nouakchott': 'MR', 'Africa/Khartoum': 'SD', 'Asia/Riyadh': 'SA', 'Asia/Qatar': 'QA',
		'Asia/Dubai': 'AE', 'Asia/Kuwait': 'KW', 'Asia/Bahrain': 'BH', 'Asia/Muscat': 'OM', 'Asia/Amman': 'JO', 'Asia/Baghdad': 'IQ',
		'Asia/Tehran': 'IR', 'Asia/Baku': 'AZ', 'Asia/Beirut': 'LB', 'Europe/London': 'GB', 'America/New_York': 'US', 'America/Chicago': 'US',
		'America/Denver': 'US', 'America/Los_Angeles': 'US', 'America/Phoenix': 'US', 'America/Toronto': 'CA', 'America/Vancouver': 'CA',
		'America/Edmonton': 'CA', 'America/Winnipeg': 'CA', 'America/Halifax': 'CA', 'Australia/Sydney': 'AU', 'Australia/Melbourne': 'AU',
		'Australia/Perth': 'AU', 'Australia/Brisbane': 'AU', 'Australia/Adelaide': 'AU', 'Pacific/Auckland': 'NZ', 'Africa/Johannesburg': 'ZA',
		'Europe/Berlin': 'DE', 'Europe/Paris': 'FR', 'Europe/Amsterdam': 'NL', 'Europe/Brussels': 'BE', 'Europe/Rome': 'IT', 'Europe/Madrid': 'ES',
		'Europe/Dublin': 'IE', 'Europe/Stockholm': 'SE', 'Europe/Oslo': 'NO', 'Europe/Copenhagen': 'DK', 'Europe/Zurich': 'CH', 'Africa/Nairobi': 'KE',
		'Africa/Dar_es_Salaam': 'TZ', 'Asia/Kathmandu': 'NP', 'Indian/Maldives': 'MV',
	};
	var COUNTRY = '';
	try { COUNTRY = TZ[Intl.DateTimeFormat().resolvedOptions().timeZone] || ''; } catch (e) {}
	if (!COUNTRY) {
		var nl = (navigator.language || '').split('-')[1];
		if (nl && E.COUNTRIES[nl.toUpperCase()]) COUNTRY = nl.toUpperCase();
	}
	if (!COUNTRY) COUNTRY = (CFG.country || '').toUpperCase();

	function fxFor(cur) {
		var fx = RATES.fx || {};
		return fx[String(cur).toLowerCase()] || 0;
	}
	function currencies() {
		var list = (CFG.currencies || ['USD']).filter(function (c) { return c === 'USD' || fxFor(c); });
		return list.length ? list : ['USD'];
	}

	/* Refresh rates in the background if the cached page carried old ones. */
	/* One request per page: every widget waits on it and redraws if newer rates came back. */
	var freshReq = null;
	function freshRates(cb) {
		if (!CFG.restUrl) return;
		if (!freshReq) {
			if (RATES.updated && Date.now() / 1000 - RATES.updated < 2 * 3600) return;
			// A 15-minute bucket keeps any in-between cache from serving an old copy.
			var url = CFG.restUrl + (CFG.restUrl.indexOf('?') < 0 ? '?' : '&') + 'b=' + Math.floor(Date.now() / 900000);
			freshReq = fetch(url, { credentials: 'omit' }).then(function (r) { return r.json(); }).then(function (d) {
				if (d && d.goldUsdOz && (!RATES.updated || d.updated > RATES.updated)) { RATES = d; return true; }
				return false;
			}).catch(function () { return false; });
		}
		freshReq.then(function (changed) { if (changed) cb(); });
	}

	/* ---------- field definitions ---------- */
	var TILES = [
		['cash', '💵', [['money', 'cash'], ['money', 'prizeBonds'], ['money', 'savingsCerts']]],
		['bank', '🏦', [['money', 'bank']]],
		['gold', '🥇', [['metal', 'goldWorn'], ['metal', 'goldKept']]],
		['silver', '🥈', [['metal', 'silverWorn'], ['metal', 'silverKept']]],
		['business', '🏪', [['money', 'businessCash'], ['money', 'stock'], ['liab', 'suppliers']]],
		['shares', '📈', [['money', 'shares'], ['money', 'crypto']]],
		['committee', '🤝', [['money', 'committee']]],
		['receivables', '📄', [['money', 'receivables'], ['money', 'receivablesDoubtful']]],
		['plot', '🏠', [['money', 'plot'], ['money', 'other']]],
		['debts', '➖', [['liab', 'debts'], ['liab', 'installments'], ['liab', 'bills']]],
		['paid', '✅', [['liab', 'bankDeducted'], ['liab', 'paidAlready']]],
	];

	function newPerson(name) {
		return { name: name || '', tiles: {}, money: {}, liab: {}, metal: {} };
	}

	/* ===================================================================== */
	/* Zakat calculator                                                       */
	/* ===================================================================== */
	function Calculator(root) {
		var opts = root.dataset;
		var cd = E.countryDefaults(COUNTRY);
		var UNITS = ['tola', 'gram', 'oz'], KARATS = [24, 22, 21, 18], FINENESS = [999, 925, 900];
		// Worn jewellery is usually 22K; bars, coins and other kept gold are usually 24K (FIX-007).
		function karatDefault(key) { return key === 'goldKept' ? 24 : 22; }

		// own.gold / own.silver are stored per gram (perGram: true) so a unit switch does not change them.
		function defaults() {
			return {
				v: 1, madhab: cd.madhab, currency: cd.currency, unit: cd.unit,
				persons: [newPerson('')], active: 0, nisabBasis: '', own: { on: false, gold: 0, silver: 0, perGram: true },
			};
		}
		function obj(x) { return x && typeof x === 'object' && !Array.isArray(x) ? x : {}; }

		/** Merge a saved draft or data file over the defaults, keeping only known, valid values. */
		function sanitize(d) {
			var s = defaults();
			d = obj(d);
			if (d.v !== 1) return s;
			if (E.MADHABS[d.madhab]) s.madhab = d.madhab;
			if (typeof d.currency === 'string' && /^[A-Z]{3}$/.test(d.currency)) s.currency = d.currency;
			if (UNITS.indexOf(d.unit) >= 0) s.unit = d.unit;
			if (d.nisabBasis === 'gold' || d.nisabBasis === 'silver') s.nisabBasis = d.nisabBasis;
			var o = obj(d.own), og = num(o.gold), os = num(o.silver);
			if (!o.perGram) { og /= unitGrams(s.unit); os /= unitGrams(s.unit); }
			s.own = { on: !!o.on, gold: og, silver: os, perGram: true };
			if (Array.isArray(d.persons) && d.persons.length) {
				s.persons = d.persons.slice(0, 20).map(function (pp) {
					pp = obj(pp);
					var np = newPerson(typeof pp.name === 'string' ? pp.name.slice(0, 40) : '');
					var tiles = obj(pp.tiles), mo = obj(pp.money), li = obj(pp.liab), me = obj(pp.metal);
					TILES.forEach(function (tile) {
						if (tiles[tile[0]]) np.tiles[tile[0]] = true;
						tile[2].forEach(function (f) {
							if (f[0] === 'money' && mo[f[1]] != null) np.money[f[1]] = num(mo[f[1]]);
							if (f[0] === 'liab' && li[f[1]] != null) np.liab[f[1]] = num(li[f[1]]);
							if (f[0] === 'metal' && me[f[1]]) {
								var m = obj(me[f[1]]), e = {};
								var w = m.weight == null ? '' : String(m.weight).replace(/[^0-9.]/g, '');
								if (w) e.weight = w;
								if (UNITS.indexOf(m.unit) >= 0) e.unit = m.unit;
								else if (w) e.unit = s.unit;
								if (KARATS.indexOf(+m.karat) >= 0) e.karat = +m.karat;
								if (FINENESS.indexOf(+m.fineness) >= 0) e.fineness = +m.fineness;
								np.metal[f[1]] = e;
							}
						});
					});
					return np;
				});
			}
			var act = parseInt(d.active, 10);
			s.active = act >= 0 && act < s.persons.length ? act : 0;
			return s;
		}
		function clearDraft() { try { localStorage.removeItem(DRAFT_KEY); localStorage.removeItem(DRAFT_KEY + '_at'); } catch (e) {} }

		// A draft not touched for 13 months is dropped (last year's figures still help next Ramadan) (FIX-057).
		var DRAFT_TTL = 396 * 864e5;
		var savedAt = +load(DRAFT_KEY + '_at', 0);
		if (savedAt && Date.now() - savedAt > DRAFT_TTL) clearDraft();
		var st, fresh = !load(DRAFT_KEY, null);
		try { st = sanitize(load(DRAFT_KEY, null)); } catch (e) { st = defaults(); clearDraft(); }
		if (opts.madhab && E.MADHABS[opts.madhab]) st.madhab = opts.madhab;
		// Asset pages (salary, plot, India...) open their own tiles and currency on a first visit (FIX-158).
		if (fresh) {
			if (opts.currency && /^[A-Z]{3}$/.test(opts.currency)) st.currency = opts.currency;
			if (UNITS.indexOf(opts.unit) >= 0) st.unit = opts.unit;
			(opts.tiles || '').split(',').forEach(function (k) {
				if (TILES.some(function (tile) { return tile[0] === k; })) st.persons[0].tiles[k] = true;
			});
		}
		if (currencies().indexOf(st.currency) < 0) st.currency = currencies().indexOf(cd.currency) >= 0 ? cd.currency : 'USD';
		var ui = { ctx: false, compare: opts.compare === 'open', why: {}, pdf: false, msg: '' };

		function livePrices() {
			var fx = st.currency === 'USD' ? 1 : fxFor(st.currency);
			if (!RATES.goldUsdOz || !RATES.silverUsdOz || !fx) return null;
			return E.perGram({ goldUsdOz: RATES.goldUsdOz, silverUsdOz: RATES.silverUsdOz, fx: fx });
		}
		/** Own rates are used when ticked, or when there is no live rate, but only once both are entered. */
		function usingOwn() {
			return (st.own.on || !livePrices()) && st.own.gold > 0 && st.own.silver > 0;
		}
		function prices() {
			if (usingOwn()) return { gold: st.own.gold, silver: st.own.silver };
			return livePrices();
		}

		function personInput(p) {
			var money = {}, liab = {}, metals = {};
			TILES.forEach(function (tile) {
				if (!p.tiles[tile[0]]) return;
				tile[2].forEach(function (f) {
					if (f[0] === 'money') money[f[1]] = num(p.money[f[1]]);
					if (f[0] === 'liab') liab[f[1]] = num(p.liab[f[1]]);
					if (f[0] === 'metal') {
						var m = p.metal[f[1]] || {};
						metals[f[1]] = f[1].indexOf('gold') === 0
							? { weight: num(m.weight), unit: m.unit || st.unit, karat: m.karat || karatDefault(f[1]) }
							: { weight: num(m.weight), unit: m.unit || st.unit, fineness: m.fineness || 999 };
					}
				});
			});
			return {
				money: money, liabilities: liab, goldWorn: metals.goldWorn, goldKept: metals.goldKept,
				silverWorn: metals.silverWorn, silverKept: metals.silverKept, nisabBasis: st.nisabBasis,
			};
		}

		function persist() { save(DRAFT_KEY, st); save(DRAFT_KEY + '_at', Date.now()); }

		function field(kind, key, p) {
			var id = 'myzt-' + key + '-' + st.active;
			var help = t('h_' + key) !== 'h_' + key ? '<span class="myzt-help">' + esc(t('h_' + key)) + '</span>' : '';
			if (kind === 'metal') {
				var m = p.metal[key] || {};
				var u = m.unit || st.unit;
				var isGold = key.indexOf('gold') === 0;
				var k = m.karat || karatDefault(key);
				var seg = ['tola', 'gram', 'oz'].map(function (x) {
					return '<button type="button" data-metal-unit="' + key + '" data-v="' + x + '" aria-pressed="' + (u === x) + '">' + unitLabel(x) + '</button>';
				}).join('');
				var kseg = isGold ? '<span class="myzt-seg" role="group" aria-label="' + esc(t('karat')) + '">' + [24, 22, 21, 18].map(function (x) {
					return '<button type="button" data-metal-karat="' + key + '" data-v="' + x + '" aria-pressed="' + (k === x) + '">' + x + 'K</button>';
				}).join('') + '</span>' : '<span class="myzt-seg" role="group" aria-label="' + esc(t('fineness')) + '">' + FINENESS.map(function (x) {
					return '<button type="button" data-metal-fineness="' + key + '" data-v="' + x + '" aria-pressed="' + ((m.fineness || 999) === x) + '">' + esc(t('fine' + x)) + '</button>';
				}).join('') + '</span>';
				return '<div class="myzt-field"><label for="' + id + '">' + esc(t('f_' + key)) + help + '</label><div class="myzt-row">' +
					'<input class="myzt-inp" id="' + id + '" inputmode="decimal" autocomplete="off" data-metal="' + key + '" value="' + esc(m.weight || '') + '" placeholder="0">' +
					'<span class="myzt-seg" role="group" aria-label="' + esc(t('unit')) + '">' + seg + '</span>' + kseg + '</div></div>';
			}
			var bag = kind === 'liab' ? p.liab : p.money;
			return '<div class="myzt-field"><label for="' + id + '">' + esc(t('f_' + key)) + help + '</label><div class="myzt-row">' +
				'<input class="myzt-inp" id="' + id + '" inputmode="decimal" autocomplete="off" data-' + kind + '="' + key + '" value="' + esc(plain(num(bag[key]), st.currency)) + '" placeholder="0"></div></div>';
		}

		function render() {
			var p = st.persons[st.active];
			var pr = prices();
			var live = livePrices();
			var own = usingOwn();
			var m = E.MADHABS[st.madhab];
			var html = '';

			html += '<div class="myzt-grid"><div class="myzt-card">';
			// Context bar.
			html += '<div class="myzt-ctx"><div>' + flag(COUNTRY) + ' <b>' + esc(mname(st.madhab)) + '</b> · ' + esc(st.currency) + ' · ' + esc(unitLabel(st.unit)) + '</div>' +
				'<div><button type="button" class="myzt-link" data-act="lang">' + (lang === 'en' ? 'اردو' : 'English') + '</button> · ' +
				'<button type="button" class="myzt-link" data-act="ctx" aria-expanded="' + ui.ctx + '">' + esc(ui.ctx ? t('done') : t('change')) + '</button></div></div>';
			if (ui.ctx) {
				html += '<div class="myzt-ctxform">' +
					'<div><label for="myzt-madhab">' + esc(t('madhab')) + '</label><select class="myzt-sel" id="myzt-madhab" data-set="madhab">' +
					E.MADHAB_ORDER.map(function (k) { return '<option value="' + k + '"' + (k === st.madhab ? ' selected' : '') + '>' + esc(mname(k)) + '</option>'; }).join('') + '</select></div>' +
					'<div><label for="myzt-cur">' + esc(t('currency')) + '</label><select class="myzt-sel" id="myzt-cur" data-set="currency">' +
					currencies().map(function (c) { return '<option' + (c === st.currency ? ' selected' : '') + '>' + c + '</option>'; }).join('') + '</select></div>' +
					'<div><label for="myzt-unit">' + esc(t('unit')) + '</label><select class="myzt-sel" id="myzt-unit" data-set="unit">' +
					['tola', 'gram', 'oz'].map(function (u) { return '<option value="' + u + '"' + (u === st.unit ? ' selected' : '') + '>' + esc(t('uo_' + u)) + '</option>'; }).join('') + '</select></div></div>';
			}
			// Rates.
			if (pr) {
				var g = unitGrams(st.unit), nv = E.nisabValues(pr);
				html += '<div class="myzt-rates"><span>' + esc(t('gold24')) + ': <strong>' + money(pr.gold * g, st.currency) + '</strong>/' + unitLabel(st.unit) + '</span>' +
					'<span>' + esc(t('silver')) + ': <strong>' + money(pr.silver * g, st.currency) + '</strong>/' + unitLabel(st.unit) + '</span>' +
					'<span>' + esc(t('nisab')) + ': <strong>' + money(nv.silver, st.currency) + '</strong> (' + esc(t('silver')) + ') · <strong>' + money(nv.gold, st.currency) + '</strong> (' + esc(t('l_gold')) + ')</span>' +
					(own ? '' : '<span>' + esc(stamp()) + '</span>') + '</div>';
			} else {
				html += '<div class="myzt-note">' + esc(t('rateMissing')) + '</div>';
			}
			html += '<label class="myzt-small myzt-check"><input type="checkbox" data-act="own"' + (st.own.on || !live ? ' checked' : '') + (live ? '' : ' disabled') + '> ' + esc(t('ownRate')) + '</label>';
			if (st.own.on || !live) {
				var ug = unitGrams(st.unit);
				html += '<div class="myzt-own"><label class="myzt-small">' + esc(t('ownGold')) + ' ' + unitLabel(st.unit) + '<input class="myzt-inp" inputmode="decimal" data-own="gold" value="' + esc(plain(round2(st.own.gold * ug), st.currency)) + '"></label>' +
					'<label class="myzt-small">' + esc(t('ownSilver')) + ' ' + unitLabel(st.unit) + '<input class="myzt-inp" inputmode="decimal" data-own="silver" value="' + esc(plain(round2(st.own.silver * ug), st.currency)) + '"></label></div>';
				if (live) html += '<div class="myzt-note" data-ownwarn' + (own ? ' hidden' : '') + '>' + esc(t('ownNeedBoth')) + '</div>';
			}
			// Quick text.
			html += '<div class="myzt-quick"><input class="myzt-inp" data-quick placeholder="' + esc(t('quickPh')) + '" aria-label="' + esc(t('quickPh')) + '"><button type="button" class="myzt-btn" data-act="fill">' + esc(t('fill')) + '</button></div>';
			if (ui.msg) html += '<div class="myzt-note" role="status">' + esc(ui.msg) + '</div>';
			// Family members.
			html += '<div class="myzt-people">' + st.persons.map(function (pp, i) {
				return '<button type="button" class="myzt-person" data-person="' + i + '" aria-pressed="' + (i === st.active) + '">' + esc(pp.name || (i === 0 ? t('me') : t('personName') + ' ' + (i + 1))) + '</button>';
			}).join('') + '<button type="button" class="myzt-link myzt-add" data-act="add">' + esc(t('addPerson')) + '</button></div>';
			if (st.active > 0) {
				html += '<div class="myzt-row"><input class="myzt-inp" data-pname value="' + esc(p.name) + '" placeholder="' + esc(t('personName')) + '" aria-label="' + esc(t('personName')) + '"><button type="button" class="myzt-btn" data-act="rm">' + esc(t('remove')) + '</button></div>';
			}
			// Tiles.
			html += '<div class="myzt-q">' + esc(t('have')) + ' <small>' + esc(t('haveHint')) + '</small></div><div class="myzt-tiles">' +
				TILES.map(function (tile) {
					return '<button type="button" class="myzt-tile" data-tile="' + tile[0] + '" aria-pressed="' + !!p.tiles[tile[0]] + '"><span class="ic" aria-hidden="true">' + tile[1] + '</span>' + esc(t('t_' + tile[0])) + '</button>';
				}).join('') + '</div>';
			// Fields of chosen tiles.
			TILES.forEach(function (tile) {
				if (!p.tiles[tile[0]]) return;
				html += '<div class="myzt-sec"><h2 class="myzt-h">' + esc(t('t_' + tile[0])) + '</h2>' + tile[2].map(function (f) { return field(f[0], f[1], p); }).join('') + '</div>';
			});
			if (m.userNisab) {
				var nb = st.nisabBasis || m.cashNisab;
				html += '<div class="myzt-sec"><div class="myzt-field"><label>' + esc(t('chooseNisab')) + '</label><span class="myzt-seg" role="group" aria-label="' + esc(t('chooseNisab')) + '">' +
					['gold', 'silver'].map(function (b) { return '<button type="button" data-nisab="' + b + '" aria-pressed="' + (nb === b) + '">' + esc(t(b === 'gold' ? 'basisGold' : 'basisSilver')) + '</button>'; }).join('') + '</span></div></div>';
			}
			html += '<p class="myzt-small">🔒 ' + esc(t('savedLocal')) + '</p>';
			html += '</div>';

			// Result.
			html += '<div class="myzt-card myzt-res">' + resultHtml(pr) + '</div></div>';

			if (ui.compare && pr) html += compareHtml(pr);
			keepFocus(root, function () { root.innerHTML = html; });
			sticky(pr);
		}

		function round2(v) { return Math.round((v || 0) * 100) / 100; }

		function results(pr) {
			return st.persons.map(function (p) { return E.calculate(st.madhab, personInput(p), pr); });
		}

		function resultHtml(pr) {
			if (!pr) return '<div class="myzt-due">' + esc(t('yourZakat')) + '</div><div class="myzt-amt">—</div><div class="myzt-note">' + esc(t('rateMissing')) + '</div>';
			var all = results(pr);
			var r = all[st.active];
			var p = st.persons[st.active];
			var html = '<div class="myzt-due">' + esc(st.persons.length > 1 ? t('zakatFor') + ' ' + (p.name || (st.active === 0 ? t('me') : '#' + (st.active + 1))) : t('yourZakat')) + ' (' + esc(mname(r.madhab)) + ')</div>' +
				'<div class="myzt-amt">' + money(r.paid ? r.payable : r.zakat, st.currency) + '</div>' +
				(r.paid ? '<div class="myzt-small">' + esc(t('toPay')) + ' · ' + esc(t('totalZakat')) + ' ' + money(r.zakat, st.currency) + '</div>' : '') +
				'<div class="myzt-badge' + (r.due ? '' : ' no') + '">' + (r.due ? '✓ ' + esc(t('due')) : esc(t(r.khums ? 'khumsBadge' : 'notDue'))) + '</div>';
			r.lines.forEach(function (l, i) {
				if (!l.value && l.key !== 'money') return;
				var why = l.why ? ' <button type="button" class="myzt-link myzt-why" data-why="' + i + '">' + esc(t('why')) + '</button>' : '';
				html += '<div class="myzt-line' + (l.included ? '' : ' off') + '"><span>' + esc(t('l_' + l.key)) + why + '</span><span>' + money(l.value, st.currency) + '</span></div>';
				if (l.why && ui.why[i]) html += '<div class="myzt-whytxt">' + esc(t('w_' + l.why)) + '</div>';
			});
			if (!r.khums) {
				html += '<div class="myzt-line"><span><b>' + esc(t('l_total')) + '</b></span><span><b>' + money(r.zakatable, st.currency) + '</b></span></div>' +
					'<div class="myzt-line"><span>' + esc(t('nisabUsed')) + ': ' + esc(t(r.nisabBasis === 'gold' ? 'basisGold' : 'basisSilver')) + '</span><span>' + money(r.nisab, st.currency) + '</span></div>' +
					'<div class="myzt-line"><span>' + esc(t('l_rate')) + '</span><span><b>' + money(r.zakat, st.currency) + '</b></span></div>';
			}
			if (r.paid) {
				html += '<div class="myzt-line"><span>' + esc(t('l_paid')) + '</span><span>' + money(-r.paid, st.currency) + '</span></div>' +
					'<div class="myzt-line"><span><b>' + esc(t('toPay')) + '</b></span><span><b>' + money(r.payable, st.currency) + '</b></span></div>';
			}
			r.notes.forEach(function (n) {
				html += '<div class="myzt-note">' + esc(t('n_' + n)) + (n === 'jafari_khums' && CFG.urls && CFG.urls.khums ? ' <a href="' + esc(CFG.urls.khums) + '">' + esc(t('seeKhums')) + ' →</a>' : '') + '</div>';
			});
			if (all.length > 1) {
				html += '<div class="myzt-line" style="margin-top:8px"><span><b>' + esc(t('family')) + '</b></span><span><b>' + money(E.family(all), st.currency) + '</b></span></div>';
			}
			html += '<div class="myzt-btns">' +
				'<button type="button" class="myzt-btn p wide" data-act="compare" aria-expanded="' + ui.compare + '">' + esc(ui.compare ? t('hideCompare') : t('compare')) + ' ⇄</button>' +
				'<button type="button" class="myzt-btn" data-act="pdf">🖨 ' + esc(t('pdf')) + '</button>' +
				'<button type="button" class="myzt-btn" data-act="wa">' + esc(t('whatsapp')) + '</button>' +
				'<button type="button" class="myzt-btn" data-act="ics">📅 ' + esc(t('calendar')) + '</button>' +
				'<button type="button" class="myzt-btn" data-act="err">⚑ ' + esc(t('report')) + '</button>' +
				'<button type="button" class="myzt-btn" data-act="savefile">' + esc(t('saveFile')) + '</button>' +
				'<label class="myzt-btn" style="text-align:center">' + esc(t('loadFile')) + '<input type="file" accept="application/json,.json" data-loadfile hidden></label>' +
				'<button type="button" class="myzt-btn" data-act="reset">' + esc(t('reset')) + '</button>' +
				'<button type="button" class="myzt-btn" data-act="forget">' + esc(t('forget')) + '</button></div>';
			if (ui.pdf) {
				html += '<div class="myzt-pdfname"><input class="myzt-inp" data-pdfname placeholder="' + esc(t('pdfName')) + '" aria-label="' + esc(t('pdfName')) + '"><button type="button" class="myzt-btn p" data-act="makepdf">' + esc(t('makePdf')) + '</button></div>';
			}
			html += '<div class="myzt-disc">' + esc(t('disc')) + (CFG.urls && CFG.urls.disclaimer ? ' <a href="' + esc(CFG.urls.disclaimer) + '">' + esc(t('discLink')) + '</a>' : '') + '</div>';
			return html;
		}

		function compareHtml(pr) {
			var input = personInput(st.persons[st.active]);
			var all = E.compare(input, pr);
			// With zakat already paid, also show what is left to pay, so the table matches the main result (FIX-010).
			var paid = all.some(function (r) { return r.paidEntered > 0; });
			var rows = all.map(function (r) {
				var m = E.MADHABS[r.madhab];
				var nb = r.khums ? t('basisCoins') : (m.cashNisab === 'lower' ? t('lower') : t(r.nisabBasis === 'gold' ? 'basisGold' : 'basisSilver'));
				var ref = CFG.urls && CFG.urls.methodology ? '<a href="' + esc(CFG.urls.methodology) + '#' + r.madhab + '">' + esc(m.ref.split(',')[0]) + '</a>' : esc(m.ref.split(',')[0]);
				return '<tr class="' + (r.madhab === st.madhab ? 'sel' : '') + '"><td>' + esc(mname(r.madhab)) + '</td><td>' + esc(m.jewellery ? t('included') : r.notes.indexOf('shafii_excess_jewellery') >= 0 ? t('includedAbove') : t('exempt')) + '</td><td>' + esc(m.debts ? t('yes') : t('no')) + '</td><td>' + esc(nb) + '</td>' +
					'<td class="z">' + money(r.zakat, st.currency) + (r.khums ? ' · ' + esc(t('seeKhums')) : '') + '</td>' + (paid ? '<td class="z">' + money(r.payable, st.currency) + '</td>' : '') + '<td>' + ref + '</td></tr>';
			}).join('');
			return '<div class="myzt-card myzt-cmp"><div class="myzt-cmp-h"><b>' + esc(t('cmpTitle')) + '</b><span class="myzt-small">' + esc(t('cmpSub')) + '</span></div>' +
				'<div class="myzt-scroll"><table class="myzt-table"><thead><tr><th>' + esc(t('c_madhab')) + '</th><th>' + esc(t('c_jewellery')) + '</th><th>' + esc(t('c_debts')) + '</th><th>' + esc(t('c_nisab')) + '</th><th>' + esc(t('c_zakat')) + '</th>' + (paid ? '<th>' + esc(t('c_toPay')) + '</th>' : '') + '<th>' + esc(t('c_ref')) + '</th></tr></thead><tbody>' + rows + '</tbody></table></div></div>';
		}

		var stickyEl = null;
		function sticky(pr) {
			if (!stickyEl) {
				stickyEl = document.createElement('div');
				stickyEl.className = 'myzt myzt-sticky';
				stickyEl.setAttribute('aria-hidden', 'true');
				document.body.appendChild(stickyEl);
				document.body.classList.add('myzt-has-sticky');
			}
			setLang(stickyEl);
			if (!pr) { stickyEl.hidden = true; announce(''); return; }
			var all = results(pr);
			var total = all.length > 1 ? E.family(all) : all[0].payable;
			var text = (all.length > 1 ? t('family') : t('yourZakat')) + ' (' + mname(st.madhab) + '): ' + money(total, st.currency);
			stickyEl.hidden = false;
			stickyEl.innerHTML = '<span>' + esc(all.length > 1 ? t('family') : t('yourZakat')) + ' (' + esc(mname(st.madhab)) + ')</span><b>' + money(total, st.currency) + '</b>';
			announce(text);
		}

		/*
		 * Screen readers hear only the total, once typing pauses, instead of the whole result
		 * box on every keystroke (FIX-054). The live region sits outside root, so re-renders keep it.
		 */
		var live = document.createElement('div'), liveTimer = 0, lastSaid = null;
		live.className = 'myzt-sr';
		live.setAttribute('role', 'status');
		live.setAttribute('aria-live', 'polite');
		root.parentNode.insertBefore(live, root.nextSibling);
		function announce(text) {
			clearTimeout(liveTimer);
			if (lastSaid === null) { lastSaid = text; return; } // nothing to say on first load
			liveTimer = setTimeout(function () {
				if (text === lastSaid) return;
				lastSaid = text;
				setLang(live);
				live.textContent = text;
			}, 900);
		}

		/* Update only the result side while typing, so the input keeps focus. */
		function updateResult() {
			var pr = prices();
			var res = root.querySelector('.myzt-res');
			if (res) res.innerHTML = resultHtml(pr);
			var cmp = root.querySelector('.myzt-cmp');
			if (cmp && pr) cmp.outerHTML = compareHtml(pr);
			sticky(pr);
			persist();
		}

		root.addEventListener('input', function (e) {
			var el = e.target, p = st.persons[st.active];
			if (el.dataset.money) p.money[el.dataset.money] = num(el.value);
			else if (el.dataset.liab) p.liab[el.dataset.liab] = num(el.value);
			else if (el.dataset.metal) {
				var me = p.metal[el.dataset.metal] = p.metal[el.dataset.metal] || {};
				var pw = E.parseAmount(el.value);
				me.weight = pw.ok && pw.value ? String(pw.value) : '';
				// Fix the unit on first entry, so a later change of the default unit does not turn 10 tola into 10 g.
				if (!me.unit) me.unit = st.unit;
			}
			else if (el.dataset.own) {
				st.own[el.dataset.own] = num(el.value) / unitGrams(st.unit);
				var warn = root.querySelector('[data-ownwarn]');
				if (warn) warn.hidden = usingOwn();
			}
			else if (el.hasAttribute('data-pname')) {
				p.name = el.value.slice(0, 40);
				var tab = root.querySelector('[data-person="' + st.active + '"]');
				if (tab) tab.textContent = p.name || t('personName') + ' ' + (st.active + 1);
				persist();
				return;
			}
			else return;
			updateResult();
		});

		root.addEventListener('focusout', function (e) {
			var el = e.target;
			if (el.getAttribute('aria-invalid') === 'true') return;
			if (el.dataset.money || el.dataset.liab) el.value = plain(num(el.value), st.currency);
			else if (el.dataset.own) el.value = plain(round2(st.own[el.dataset.own] * unitGrams(st.unit)), st.currency);
		});

		root.addEventListener('change', function (e) {
			var el = e.target;
			if (el.dataset.set) {
				var key = el.dataset.set, old = st[key];
				st[key] = el.value;
				if (key === 'madhab') st.nisabBasis = '';
				if (key === 'currency' && old !== el.value) {
					// Own rates are in the old currency: convert with the live exchange rate, or clear them.
					var fo = old === 'USD' ? 1 : fxFor(old), fn = el.value === 'USD' ? 1 : fxFor(el.value);
					if (fo && fn) { st.own.gold = st.own.gold * fn / fo; st.own.silver = st.own.silver * fn / fo; }
					else { st.own.gold = 0; st.own.silver = 0; }
				}
				persist(); render();
			} else if (el.dataset.act === 'own') {
				st.own.on = el.checked; persist(); render();
			} else if (el.hasAttribute('data-loadfile') && el.files[0]) {
				var fr = new FileReader(), input = el;
				// A malformed or incompatible file gets a message instead of being ignored (FIX-012).
				fr.onload = function () {
					var d = null, prev = st;
					try { d = JSON.parse(fr.result); } catch (err) {}
					if (!d || d.v !== 1 || !Array.isArray(d.persons) || !d.persons.length) { ui.msg = t('fileBad'); render(); return; }
					try {
						st = sanitize(d); st.active = 0;
						ui.msg = t('fileOk');
						if (currencies().indexOf(st.currency) < 0) {
							ui.msg = t('fileCur').replace('%s', st.currency).replace('%t', prev.currency);
							st.currency = prev.currency;
						}
						render(); persist();
					} catch (err2) { st = prev; ui.msg = t('fileBad'); render(); }
				};
				fr.onerror = function () { ui.msg = t('fileBad'); render(); };
				fr.readAsText(el.files[0]);
				input.value = '';
			}
		});

		root.addEventListener('keydown', function (e) {
			if (e.key === 'Enter' && e.target.hasAttribute('data-quick')) { e.preventDefault(); fill(e.target.value); }
		});

		function fill(text) {
			var r = E.parseText(text), p = st.persons[st.active], any = false;
			Object.keys(r).forEach(function (k) {
				any = true;
				if (k === 'gold' || k === 'silver') {
					p.tiles[k] = true;
					// Worn jewellery only when the text says so; otherwise bars, coins and kept gold.
					var key = k + (/zevar|zewar|zaiwar|jewell?ery|jewelry|زیور/i.test(text) ? 'Worn' : 'Kept');
					p.metal[key] = k === 'gold' ? { weight: String(r[k].weight), unit: r[k].unit, karat: r[k].karat || karatDefault(key) } : { weight: String(r[k].weight), unit: r[k].unit };
				} else if (k === 'debts') { p.tiles.debts = true; p.liab.debts = r[k]; }
				else {
					var tileOf = { cash: 'cash', bank: 'bank', stock: 'business', committee: 'committee', shares: 'shares', crypto: 'shares', plot: 'plot', receivables: 'receivables', prizeBonds: 'cash', savingsCerts: 'cash' }[k];
					if (tileOf) { p.tiles[tileOf] = true; p.money[k] = r[k]; }
				}
			});
			ui.msg = any ? t('filled') : t('notUnderstood');
			persist(); render();
		}

		root.addEventListener('click', function (e) {
			var b = e.target.closest('button');
			if (!b || !root.contains(b)) return;
			var p = st.persons[st.active], d = b.dataset;
			if (d.tile) { p.tiles[d.tile] = !p.tiles[d.tile]; ui.msg = ''; persist(); render(); return; }
			if (d.metalUnit) { p.metal[d.metalUnit] = p.metal[d.metalUnit] || {}; p.metal[d.metalUnit].unit = d.v; persist(); render(); return; }
			if (d.metalFineness) { p.metal[d.metalFineness] = p.metal[d.metalFineness] || {}; p.metal[d.metalFineness].fineness = +d.v; persist(); render(); return; }
			if (d.metalKarat) { p.metal[d.metalKarat] = p.metal[d.metalKarat] || {}; p.metal[d.metalKarat].karat = +d.v; persist(); render(); return; }
			if (d.person) { st.active = +d.person; ui.why = {}; persist(); render(); return; }
			if (d.nisab) { st.nisabBasis = d.nisab; persist(); render(); return; }
			if (d.why) { ui.why[d.why] = !ui.why[d.why]; updateResult(); return; }
			switch (d.act) {
				case 'ctx': ui.ctx = !ui.ctx; render(); break;
				case 'lang': lang = lang === 'en' ? 'ur' : 'en'; try { localStorage.setItem(LANG_KEY, lang); } catch (x) {} setLang(root); render(); break;
				case 'fill': fill(root.querySelector('[data-quick]').value); break;
				case 'add': st.persons.push(newPerson('')); st.active = st.persons.length - 1; persist(); render(); break;
				case 'rm': st.persons.splice(st.active, 1); st.active = 0; persist(); render(); break;
				case 'compare': ui.compare = !ui.compare; render(); break;
				case 'pdf': ui.pdf = !ui.pdf; updateResult(); break;
				case 'makepdf': makePdf(b); break;
				case 'wa': whatsapp(); break;
				case 'ics': ics(); break;
				case 'err': reportError(); break;
				case 'savefile': download('my-zakat-data.json', new Blob([JSON.stringify(st, null, 1)], { type: 'application/json' })); break;
				case 'reset':
					// Clear all leaves nothing behind: the empty draft is removed, not saved (FIX-057).
					if (window.confirm(t('resetConfirm'))) { st.persons = [newPerson('')]; st.active = 0; ui.msg = ''; clearDraft(); render(); }
					break;
				case 'forget':
					if (window.confirm(t('forgetConfirm'))) { forgetAll(); st = defaults(); ui.msg = t('forgotten'); render(); }
					break;
			}
		});

		function totalNow() {
			var pr = prices();
			if (!pr) return 0;
			return E.family(results(pr));
		}

		function whatsapp() {
			var text = t('shareText') + ' (' + E.MADHABS[st.madhab].name + '): ' + money(totalNow(), st.currency) + '\n' + (CFG.siteUrl || location.origin);
			window.open('https://wa.me/?text=' + encodeURIComponent(text), '_blank', 'noopener');
		}

		function ics() {
			var today = new Date().toISOString().slice(0, 10);
			var iso = zakatDates(today, 1, today)[0] || new Date(Date.now() + 354 * 864e5).toISOString().slice(0, 10);
			var ymd = iso.replace(/-/g, '');
			var end = new Date(Date.parse(iso + 'T00:00:00Z') + 864e5).toISOString().slice(0, 10).replace(/-/g, '');
			var body = ['BEGIN:VCALENDAR', 'VERSION:2.0', 'PRODID:-//My Zakat Tool//EN', 'BEGIN:VEVENT',
				'UID:' + Date.now() + '@myzakattool', 'DTSTAMP:' + new Date().toISOString().replace(/[-:]/g, '').slice(0, 15) + 'Z',
				'DTSTART;VALUE=DATE:' + ymd, 'DTEND;VALUE=DATE:' + end, 'SUMMARY:' + t('calTitle'),
				'DESCRIPTION:' + (CFG.siteUrl || location.origin), 'BEGIN:VALARM', 'TRIGGER:-P3D', 'ACTION:DISPLAY', 'DESCRIPTION:Zakat', 'END:VALARM',
				'END:VEVENT', 'END:VCALENDAR'].join('\r\n');
			download('zakat-reminder.ics', new Blob([body], { type: 'text/calendar' }));
		}

		function reportError() {
			var body = 'Page: ' + location.href + '\nMadhab: ' + st.madhab + '\nCurrency: ' + st.currency + '\nWhat looks wrong:\n';
			location.href = 'mailto:' + (CFG.email || '') + '?subject=' + encodeURIComponent('Calculator error report') + '&body=' + encodeURIComponent(body);
		}

		function makePdf(btn) {
			var pr = prices();
			if (!pr) return;
			btn.disabled = true;
			btn.textContent = t('making');
			var nameEl = root.querySelector('[data-pdfname]');
			var done = function () { btn.disabled = false; btn.textContent = t('makePdf'); };
			loadPdf().then(function (P) { return P.build({
				name: nameEl ? nameEl.value.slice(0, 60) : '',
				madhab: E.MADHABS[st.madhab].name, currency: st.currency, unit: st.unit,
				prices: pr, nisab: E.nisabValues(pr), own: usingOwn(), source: RATES.source || '', updated: RATES.updated,
				persons: st.persons.map(function (p, i) {
					var input = personInput(p);
					return { name: p.name || (i === 0 ? 'Me' : 'Member ' + (i + 1)), input: input, result: E.calculate(st.madhab, input, pr) };
				}),
				money: function (v) { return money(v, st.currency); },
				site: CFG.siteUrl || location.origin,
			}); }).then(done, done);
		}

		setLang(root);
		try { render(); } catch (e) {
			// A saved draft that still breaks the page: start again from the defaults.
			st = defaults(); clearDraft(); render();
		}
		freshRates(render);
	}

	/* ===================================================================== */
	/* Small widgets: nisab table, gold rate, fitrana, khums                  */
	/* ===================================================================== */
	function pickCurrency(root) {
		var cd = E.countryDefaults(COUNTRY);
		var c = root.dataset.currency || cd.currency;
		return currencies().indexOf(c) >= 0 ? c : 'USD';
	}
	function curSelect(cur) {
		return '<label class="myzt-small">' + esc(t('currency')) + ' <select class="myzt-sel" data-cur style="width:auto">' +
			currencies().map(function (c) { return '<option' + (c === cur ? ' selected' : '') + '>' + c + '</option>'; }).join('') + '</select></label>';
	}
	function pricesFor(cur) {
		var fx = cur === 'USD' ? 1 : fxFor(cur);
		if (!RATES.goldUsdOz || !fx) return null;
		return E.perGram({ goldUsdOz: RATES.goldUsdOz, silverUsdOz: RATES.silverUsdOz, fx: fx });
	}

	function GoldRate(root) {
		var cur = pickCurrency(root);
		function render() {
			var pr = pricesFor(cur);
			if (!pr) return;
			var rows = [24, 22, 21, 18].map(function (k) {
				var g = pr.gold * k / 24;
				return '<tr><td>' + k + 'K</td><td>' + money(g, cur) + '</td><td>' + money(g * E.GRAMS_PER_TOLA, cur) + '</td><td>' + money(g * E.GRAMS_PER_OZ, cur) + '</td></tr>';
			}).join('') + '<tr><td>' + esc(t('silver')) + '</td><td>' + money(pr.silver, cur) + '</td><td>' + money(pr.silver * E.GRAMS_PER_TOLA, cur) + '</td><td>' + money(pr.silver * E.GRAMS_PER_OZ, cur) + '</td></tr>';
			root.innerHTML = '<div class="myzt-card">' + curSelect(cur) + '<div class="myzt-scroll"><table class="myzt-table"><thead><tr><th>' + esc(t('purity')) + '</th><th>' + esc(t('perGram')) + '</th><th>' + esc(t('perTola')) + '</th><th>' + esc(t('perOz')) + '</th></tr></thead><tbody>' + rows + '</tbody></table></div>' +
				'<p class="myzt-small">' + esc(stamp()) + (RATES.source === 'manual' ? '' : ' · ' + t('spotRate')) + '</p></div>';
		}
		root.addEventListener('change', function (e) { if (e.target.dataset.cur !== undefined) { cur = e.target.value; render(); } });
		render();
		speaker(root, function () { return outText(root, 'tbody tr'); });
		freshRates(render);
	}

	function Nisab(root) {
		var cur = pickCurrency(root);
		function render() {
			var pr = pricesFor(cur);
			if (!pr) return;
			var nv = E.nisabValues(pr);
			root.innerHTML = '<div class="myzt-card">' + curSelect(cur) + '<div class="myzt-scroll"><table class="myzt-table"><thead><tr><th>' + esc(t('nisab')) + '</th><th>' + esc(t('weight')) + '</th><th>' + esc(t('c_zakat')) + ' ' + esc(t('nisab')) + '</th></tr></thead><tbody>' +
				'<tr><td>' + esc(t('silver')) + '</td><td>612.35 ' + unitLabel('gram') + ' · 52.5 ' + unitLabel('tola') + '</td><td class="z">' + money(nv.silver, cur) + '</td></tr>' +
				'<tr><td>' + esc(t('l_gold')) + '</td><td>87.48 ' + unitLabel('gram') + ' · 7.5 ' + unitLabel('tola') + '</td><td class="z">' + money(nv.gold, cur) + '</td></tr></tbody></table></div>' +
				'<p class="myzt-small">' + esc(stamp()) + (RATES.source === 'manual' ? '' : ' · ' + t('spotRate')) + '</p></div>';
		}
		root.addEventListener('change', function (e) { if (e.target.dataset.cur !== undefined) { cur = e.target.value; render(); } });
		render();
		speaker(root, function () { var b = outText(root, 'tbody'); return b ? t('nisab') + ': ' + b : ''; });
		freshRates(render);
	}

	/** Where the per-person amount comes from, or a clear prompt to enter it when there is no preset (FIX-013). */
	function presetNote(F, cur, has) {
		if (!has) return '<div class="myzt-note">' + esc(t('f_noPreset')) + '</div>';
		return (F.fallback ? '<div class="myzt-note">' + esc(t('f_fallback')) + '</div>' : '') + (F.note ? '<p class="myzt-small">' + esc(F.note) + '</p>' : '');
	}

	function Fitrana(root) {
		var F = CFG.fitrana || {};
		var cur = pickCurrency(root);
		var st = { persons: 1, item: 'wheat', amount: 0 };
		function preset() { return (F.currency === cur && F[st.item]) ? +F[st.item] : 0; }
		st.amount = preset();
		function render() { keepFocus(root, draw); }
		function draw() {
			root.innerHTML = '<div class="myzt-card myzt-mini">' + curSelect(cur) +
				'<div class="myzt-field"><label for="myzt-fp">' + esc(t('persons')) + '</label><input class="myzt-inp" id="myzt-fp" inputmode="numeric" data-f="persons" value="' + st.persons + '"></div>' +
				'<div class="myzt-field"><label>' + esc(t('item')) + '</label><span class="myzt-seg">' + ['wheat', 'barley', 'dates', 'raisins'].map(function (i) {
					return '<button type="button" data-item="' + i + '" aria-pressed="' + (st.item === i) + '">' + esc(t(i)) + '</button>';
				}).join('') + '</span></div>' +
				'<div class="myzt-field"><label for="myzt-fa">' + esc(t('perPerson')) + ' (' + cur + ')</label><input class="myzt-inp" id="myzt-fa" inputmode="decimal" data-f="amount" value="' + esc(plain(st.amount, cur)) + '"></div>' +
				'<div class="myzt-due">' + esc(t('fitranaTotal')) + '</div><div class="myzt-amt" data-out>' + money(E.fitrana(st.persons, st.amount), cur) + '</div>' +
				presetNote(F, cur, preset()) + '<div class="myzt-disc">' + esc(t('disc')) + '</div></div>';
		}
		root.addEventListener('input', function (e) {
			var f = e.target.dataset.f;
			if (!f) return;
			// People are whole numbers: 2.5 counts as 2.
			st[f] = f === 'persons' ? Math.floor(num(e.target.value)) : num(e.target.value);
			root.querySelector('[data-out]').textContent = money(E.fitrana(st.persons, st.amount), cur);
		});
		root.addEventListener('change', function (e) {
			if (e.target.dataset.f === 'persons') e.target.value = st.persons;
			if (e.target.dataset.cur !== undefined) { cur = e.target.value; st.amount = preset(); render(); }
		});
		root.addEventListener('click', function (e) {
			var b = e.target.closest('[data-item]');
			if (b) { st.item = b.dataset.item; st.amount = preset() || st.amount; render(); }
		});
		render();
		speaker(root, function () { return t('fitranaTotal') + ': ' + outText(root, '[data-out]'); });
		pdfButton(root, 'Fitrana (Sadaqat al-Fitr)');
	}

	function Fidya(root) {
		var F = CFG.fitrana || {};
		var cur = pickCurrency(root);
		var st = { fasts: 0, broken: 0, item: 'wheat', amount: 0 };
		function preset() { return (F.currency === cur && F[st.item]) ? +F[st.item] : 0; }
		st.amount = preset();
		function out() {
			var f = E.fidya(st.fasts, st.amount), k = E.kaffara(st.broken, st.amount);
			return '<div class="myzt-line"><span>' + esc(t('fd_fidya')) + '</span><span>' + money(f, cur) + '</span></div>' +
				'<div class="myzt-line"><span>' + esc(t('fd_kaffara')) + '</span><span>' + money(k, cur) + '</span></div>' +
				'<div class="myzt-due" style="margin-top:8px">' + esc(t('fd_total')) + '</div><div class="myzt-amt">' + money(f + k, cur) + '</div>';
		}
		function render() { keepFocus(root, draw); }
		function draw() {
			root.innerHTML = '<div class="myzt-card myzt-mini">' + curSelect(cur) +
				'<div class="myzt-field"><label for="myzt-df">' + esc(t('fd_fasts')) + '<span class="myzt-help">' + esc(t('fd_hFasts')) + '</span></label><input class="myzt-inp" id="myzt-df" inputmode="numeric" data-f="fasts" value="' + (st.fasts || '') + '" placeholder="0"></div>' +
				'<div class="myzt-field"><label for="myzt-dk">' + esc(t('fd_broken')) + '<span class="myzt-help">' + esc(t('fd_hBroken')) + '</span></label><input class="myzt-inp" id="myzt-dk" inputmode="numeric" data-f="broken" value="' + (st.broken || '') + '" placeholder="0"></div>' +
				'<div class="myzt-field"><label>' + esc(t('item')) + '</label><span class="myzt-seg">' + ['wheat', 'barley', 'dates', 'raisins'].map(function (i) {
					return '<button type="button" data-item="' + i + '" aria-pressed="' + (st.item === i) + '">' + esc(t(i)) + '</button>';
				}).join('') + '</span></div>' +
				'<div class="myzt-field"><label for="myzt-da">' + esc(t('fd_perDay')) + ' (' + cur + ')</label><input class="myzt-inp" id="myzt-da" inputmode="decimal" data-f="amount" value="' + esc(plain(st.amount, cur)) + '"></div>' +
				'<div data-out>' + out() + '</div>' +
				'<div class="myzt-note">' + esc(t('fd_madhabNote')) + '</div>' +
				presetNote(F, cur, preset()) + '<div class="myzt-disc">' + esc(t('disc')) + '</div></div>';
		}
		root.addEventListener('input', function (e) {
			var f = e.target.dataset.f;
			if (!f) return;
			st[f] = f === 'amount' ? num(e.target.value) : Math.floor(num(e.target.value));
			root.querySelector('[data-out]').innerHTML = out();
		});
		root.addEventListener('change', function (e) {
			var f = e.target.dataset.f;
			if (f === 'fasts' || f === 'broken') e.target.value = st[f] || '';
			if (e.target.dataset.cur !== undefined) { cur = e.target.value; st.amount = preset(); render(); }
		});
		root.addEventListener('click', function (e) {
			var b = e.target.closest('[data-item]');
			if (b) { st.item = b.dataset.item; st.amount = preset() || st.amount; render(); }
		});
		render();
		speaker(root, function () { return outText(root, '[data-out]'); });
		pdfButton(root, 'Fidya and kaffara');
	}

	function Khums(root) {
		var cur = pickCurrency(root);
		var st = { savings: 0, unusedItems: 0, tradeStock: 0, debts: 0 };
		function out() {
			var k = E.khums(st);
			return '<div class="myzt-line"><span>' + esc(t('k_surplus')) + '</span><span>' + money(k.surplus, cur) + '</span></div>' +
				'<div class="myzt-line"><span>' + esc(t('k_imam')) + '</span><span>' + money(k.sahmImam, cur) + '</span></div>' +
				'<div class="myzt-line"><span>' + esc(t('k_sadat')) + '</span><span>' + money(k.sahmSadat, cur) + '</span></div>' +
				'<div class="myzt-due" style="margin-top:8px">' + esc(t('k_total')) + '</div><div class="myzt-amt">' + money(k.khums, cur) + '</div>';
		}
		function render() {
			root.innerHTML = '<div class="myzt-card myzt-mini">' + curSelect(cur) + [['savings', 'k_savings'], ['unusedItems', 'k_unused'], ['tradeStock', 'k_stock'], ['debts', 'k_debts']].map(function (f) {
				return '<div class="myzt-field"><label for="myzt-k-' + f[0] + '">' + esc(t(f[1])) + '</label><input class="myzt-inp" id="myzt-k-' + f[0] + '" inputmode="decimal" data-k="' + f[0] + '" value="' + esc(plain(st[f[0]], cur)) + '"></div>';
			}).join('') + '<div data-out>' + out() + '</div>' +
				'<p class="myzt-small">' + esc(t('k_paid')) + '</p><p class="myzt-small">' + esc(t('k_where')) + '</p>' +
				'<div class="myzt-field"><label for="myzt-kd">' + esc(t('k_date')) + '</label><div class="myzt-row"><input class="myzt-inp" type="date" id="myzt-kd" aria-label="' + esc(t('k_date')) + '" data-kdate value="' + esc(kdate) + '">' +
				'<button type="button" class="myzt-btn" data-act="kics">📅 ' + esc(t('k_ics')) + '</button></div></div>' +
				'<div class="myzt-disc">' + esc(t('disc')) + '</div></div>';
		}
		var kdate = load('myzt_khums_date', '') || '';
		root.addEventListener('click', function (e) {
			if (!e.target.closest('[data-act="kics"]') || !kdate) return;
			// Khums year is a solar year: same date every year.
			// Built with Date.UTC so 29 February falls back to 28 February in non-leap years.
			var y = new Date().getUTCFullYear(), mo = +kdate.slice(5, 7) - 1, da = +kdate.slice(8, 10), list = [];
			var today = new Date().toISOString().slice(0, 10);
			for (var i = 0; list.length < 5 && i < 7; i++) {
				var dt = new Date(Date.UTC(y + i, mo, da));
				if (dt.getUTCMonth() !== mo) dt = new Date(Date.UTC(y + i, mo + 1, 0));
				var d = dt.toISOString().slice(0, 10);
				if (d >= today) list.push(d);
			}
			icsFile('khums-date.ics', t('k_date'), list);
		});
		root.addEventListener('change', function (e) { if (e.target.hasAttribute('data-kdate')) { kdate = e.target.value; save('myzt_khums_date', kdate); } });
		root.addEventListener('input', function (e) {
			var k = e.target.dataset.k;
			if (!k) return;
			st[k] = num(e.target.value);
			root.querySelector('[data-out]').innerHTML = out();
		});
		root.addEventListener('change', function (e) { if (e.target.dataset.cur !== undefined) { cur = e.target.value; render(); } });
		render();
		speaker(root, function () { return outText(root, '[data-out]'); });
		pdfButton(root, 'Khums');
	}

	function Hawl(root) {
		var KEY = 'myzt_hawl';
		var cur = pickCurrency(root);
		var st = load(KEY, null) || { start: '', missed: 0, wealth: [], sub: true, nisab: 0 };
		if (!Array.isArray(st.wealth)) st.wealth = [];
		if (!Array.isArray(st.nisabY)) st.nisabY = [];
		// Default nisab standard follows the visitor's madhab: gold where that school uses gold for cash (FIX-015).
		if (st.basis !== 'gold' && st.basis !== 'silver') st.basis = E.MADHABS[E.countryDefaults(COUNTRY).madhab].cashNisab === 'gold' ? 'gold' : 'silver';
		var today = new Date().toISOString().slice(0, 10);
		function nisabNow() { var pr = pricesFor(cur); return pr ? E.nisabValues(pr)[st.basis] : 0; }
		function out() {
			var h = '';
			if (st.start) {
				var dates = zakatDates(st.start, 3, today);
				h += '<div class="myzt-due">' + esc(t('h_next')) + '</div>';
				dates.forEach(function (d, i) {
					var left = Math.round((Date.parse(d + 'T00:00:00Z') - Date.parse(today + 'T00:00:00Z')) / 864e5);
					h += '<div class="myzt-line"><span>' + (i === 0 ? '<b>' : '') + esc(niceDate(d)) + (i === 0 ? '</b>' : '') + ' <span class="myzt-small">' + esc(hijri(d)) + '</span></span><span>' + left + ' ' + esc(t('h_left')) + '</span></div>';
				});
				h += '<div class="myzt-small" style="margin:6px 0">' + esc(t('h_yearsSince')) + ': ' + E.hawlYearsBetween(st.start, today) + '</div>' +
					'<button type="button" class="myzt-btn" data-act="ics">📅 ' + esc(t('h_ics')) + '</button>' +
					'<p class="myzt-small">' + esc(t('h_note')) + '</p>';
			}
			return h;
		}
		function missedOut() {
			var n = Math.min(15, Math.max(0, Math.floor(st.missed)));
			var nis = st.nisab || nisabNow();
			var r = E.missedZakat(st.wealth.slice(0, n), st.nisabY.slice(0, n), st.sub, nis);
			return r.rows.map(function (row, i) {
				return '<div class="myzt-line"><span>' + (i + 1) + (i === 0 ? ' <span class="myzt-small">(' + esc(t('h_oldest')) + ')</span>' : '') + '</span><span>' + money(row.zakat, cur) + '</span></div>';
			}).join('') + '<div class="myzt-due" style="margin-top:8px">' + esc(t('h_missedTotal')) + '</div><div class="myzt-amt">' + money(r.total, cur) + '</div>';
		}
		function render() {
			var n = Math.min(15, Math.max(0, Math.floor(st.missed)));
			var rows = '';
			for (var i = 0; i < n; i++) {
				rows += '<div class="myzt-field"><label for="myzt-hw' + i + '">' + esc(t('h_wealthY')) + ' ' + (i + 1) + '</label><input class="myzt-inp" id="myzt-hw' + i + '" inputmode="decimal" data-w="' + i + '" value="' + esc(plain(st.wealth[i] || 0, cur)) + '"></div>' +
					'<div class="myzt-field"><label for="myzt-hny' + i + '" class="myzt-small">' + esc(t('h_nisabY')) + '</label><input class="myzt-inp" id="myzt-hny' + i + '" inputmode="decimal" data-ny="' + i + '" value="' + esc(plain(st.nisabY[i] || 0, cur)) + '" placeholder="' + esc(plain(st.nisab || nisabNow(), cur)) + '"></div>';
			}
			root.innerHTML = '<div class="myzt-card myzt-mini">' +
				'<div class="myzt-field"><label for="myzt-hs">' + esc(t('h_start')) + '</label><input class="myzt-inp" type="date" id="myzt-hs" aria-label="' + esc(t('h_start')) + '" data-h="start" max="' + today + '" value="' + esc(st.start) + '"></div>' +
				'<div data-out>' + out() + '</div>' +
				'<div class="myzt-sec"><h2 class="myzt-h">' + esc(t('h_missed')) + '</h2>' + curSelect(cur) +
				'<div class="myzt-field"><label for="myzt-hm">' + esc(t('h_missedN')) + '</label><input class="myzt-inp" id="myzt-hm" inputmode="numeric" data-h="missed" value="' + (n || '') + '" placeholder="0"></div>' +
				'<div class="myzt-field"><label>' + esc(t('h_basis')) + '</label><span class="myzt-seg" role="group" aria-label="' + esc(t('h_basis')) + '">' + ['silver', 'gold'].map(function (b) {
					return '<button type="button" data-hbasis="' + b + '" aria-pressed="' + (st.basis === b) + '">' + esc(t(b === 'gold' ? 'basisGold' : 'basisSilver')) + '</button>';
				}).join('') + '</span><span class="myzt-help">' + esc(t('h_nisabNote')) + '</span></div>' +
				'<div class="myzt-field"><label for="myzt-hn">' + esc(t('h_nisabNow')) + '</label><input class="myzt-inp" id="myzt-hn" inputmode="decimal" data-h="nisab" value="' + esc(plain(st.nisab || nisabNow(), cur)) + '"></div>' +
				'<label class="myzt-small myzt-check"><input type="checkbox" data-h="sub"' + (st.sub ? ' checked' : '') + '> ' + esc(t('h_sub')) + '</label>' +
				(n ? '<p class="myzt-small">' + esc(t('h_oldest')) + '</p>' : '') + rows + '<div data-missed>' + (n ? missedOut() : '') + '</div></div>' +
				'<div class="myzt-disc">' + esc(t('disc')) + '</div></div>';
		}
		root.addEventListener('change', function (e) {
			var el = e.target;
			if (el.dataset.cur !== undefined) { cur = el.value; st.nisab = 0; save(KEY, st); render(); return; }
			if (el.dataset.h === 'start') { st.start = el.value; save(KEY, st); root.querySelector('[data-out]').innerHTML = out(); }
			if (el.dataset.h === 'sub') { st.sub = el.checked; save(KEY, st); root.querySelector('[data-missed]').innerHTML = missedOut(); }
			if (el.dataset.h === 'missed' && num(el.value) !== st.missed) { st.missed = num(el.value); save(KEY, st); setTimeout(render, 0); }
		});
		root.addEventListener('input', function (e) {
			var el = e.target;
			if (el.dataset.w !== undefined) st.wealth[+el.dataset.w] = num(el.value);
			else if (el.dataset.ny !== undefined) st.nisabY[+el.dataset.ny] = num(el.value);
			else if (el.dataset.h === 'nisab') st.nisab = num(el.value);
			else return;
			save(KEY, st);
			root.querySelector('[data-missed]').innerHTML = missedOut();
		});
		root.addEventListener('click', function (e) {
			var hb = e.target.closest('[data-hbasis]');
			if (hb) { st.basis = hb.dataset.hbasis; st.nisab = 0; save(KEY, st); render(); return; }
			if (e.target.closest('[data-act="ics"]') && st.start) icsFile('zakat-dates.ics', t('calTitle'), zakatDates(st.start, 5, today));
		});
		render();
		speaker(root, function () {
			var next = root.querySelector('[data-out] .myzt-line'), amt = root.querySelector('[data-missed] .myzt-amt');
			return [next ? t('h_next') + ': ' + textOf(next) : '', amt ? t('h_missedTotal') + ': ' + textOf(amt) : ''].filter(Boolean).join('. ');
		});
		pdfButton(root, 'Zakat date (hawl)');
		freshRates(function () { if (!st.nisab) render(); });
	}

	function Ushr(root) {
		var cur = pickCurrency(root);
		var cd = E.countryDefaults(COUNTRY);
		// Ahl-e-Hadith follow the 5-wasq nisab like the Shafi'i, Maliki and Hanbali schools.
		var st = { tab: 'crops', madhab: cd.madhab === 'hanafi' || cd.madhab === 'jafari' ? cd.madhab : 'shafii', qty: 0, unit: 'maund', price: 0, water: 'rain', sheep: 0, cows: 0, camels: 0 };
		function kg() { return st.unit === 'maund' ? st.qty * 40 : st.qty; }
		function cropsOut() {
			var perKg = st.unit === 'maund' ? st.price / 40 : st.price;
			var r = E.ushr(st.madhab, kg(), perKg, st.water);
			if (!r.due) return kg() ? '<div class="myzt-note">' + esc(t(st.madhab === 'jafari' ? 'u_notDueJ' : 'u_notDue')) + '</div>' : '';
			var qty = st.unit === 'maund' ? r.kg / 40 : r.kg;
			return '<div class="myzt-due">' + esc(t('u_due')) + '</div><div class="myzt-amt">' + (Math.round(qty * 100) / 100) + ' ' + esc(t(st.unit === 'maund' ? 'maund' : 'kg')) + '</div>' +
				(r.value ? '<div class="myzt-line"><span>' + esc(t('u_value')) + '</span><span><b>' + money(r.value, cur) + '</b></span></div>' : '');
		}
		function animalsOut() {
			return ['sheep', 'cows', 'camels'].map(function (k) {
				if (!st[k]) return '';
				var due = E.livestock(k, st[k]);
				var txt = due.length ? due.map(function (d) { return (d.n ? d.n + ' × ' : '') + t('w_' + d.what); }).join(' + ') : t('a_none');
				return '<div class="myzt-line"><span>' + esc(t('a_' + k)) + ': ' + st[k] + '</span><span><b>' + esc(txt) + '</b></span></div>';
			}).join('');
		}
		function seg(key, opts) {
			return '<span class="myzt-seg">' + opts.map(function (o) { return '<button type="button" data-u="' + key + '" data-v="' + o[0] + '" aria-pressed="' + (st[key] === o[0]) + '">' + esc(t(o[1])) + '</button>'; }).join('') + '</span>';
		}
		function render() { keepFocus(root, draw); }
		function draw() {
			// Hanafi: the water used for most of the season decides, so there is no mixed 7.5% option.
			if (st.madhab === 'hanafi' && st.water === 'mixed') st.water = 'rain';
			var h = '<div class="myzt-card myzt-mini"><div class="myzt-field">' + seg('tab', [['crops', 'u_crops'], ['animals', 'u_animals']]) + '</div>';
			if (st.tab === 'crops') {
				h += '<div class="myzt-field"><label>' + esc(t('u_madhab')) + '</label>' + seg('madhab', [['hanafi', 'u_hanafi'], ['shafii', 'u_others'], ['jafari', 'u_jafari']]) + '</div>' +
					(st.madhab === 'jafari' ? '<p class="myzt-note">' + esc(t('u_jafariNote')) + '</p>' : '') +
					'<div class="myzt-field"><label for="myzt-uq">' + esc(t('u_qty')) + '</label><div class="myzt-row"><input class="myzt-inp" id="myzt-uq" inputmode="decimal" data-n="qty" value="' + (st.qty || '') + '" placeholder="0">' +
					'<span class="myzt-seg"><button type="button" data-u="unit" data-v="maund" aria-pressed="' + (st.unit === 'maund') + '">' + esc(t('maund40')) + '</button><button type="button" data-u="unit" data-v="kg" aria-pressed="' + (st.unit === 'kg') + '">' + esc(t('kg')) + '</button></span></div></div>' +
					'<div class="myzt-field"><label for="myzt-up">' + esc(t('u_price')) + ' ' + esc(t(st.unit === 'maund' ? 'maund' : 'kg')) + ' (' + cur + ')</label><input class="myzt-inp" id="myzt-up" inputmode="decimal" data-n="price" value="' + esc(plain(st.price, cur)) + '"></div>' +
					'<div class="myzt-field"><label>' + esc(t('u_water')) + '</label>' + seg('water', [['rain', 'u_rain'], ['irrigated', 'u_irr']].concat(st.madhab === 'hanafi' ? [] : [['mixed', 'u_mixed']])) + '</div>' +
					'<div data-out>' + cropsOut() + '</div><p class="myzt-small">' + esc(t('u_note')) + '</p>';
			} else {
				h += ['sheep', 'cows', 'camels'].map(function (k) {
					return '<div class="myzt-field"><label for="myzt-a' + k + '">' + esc(t('a_' + k)) + '</label><input class="myzt-inp" id="myzt-a' + k + '" inputmode="numeric" data-n="' + k + '" value="' + (st[k] || '') + '" placeholder="0"></div>';
				}).join('') + '<div data-out>' + animalsOut() + '</div><p class="myzt-small">' + esc(t('a_note')) + '</p><p class="myzt-note">' + esc(t('a_madhabNote')) + '</p>';
			}
			root.innerHTML = h + curSelect(cur) + '<div class="myzt-disc">' + esc(t('disc')) + '</div></div>';
		}
		root.addEventListener('input', function (e) {
			var k = e.target.dataset.n;
			if (!k) return;
			st[k] = num(e.target.value);
			root.querySelector('[data-out]').innerHTML = st.tab === 'crops' ? cropsOut() : animalsOut();
		});
		root.addEventListener('click', function (e) {
			var b = e.target.closest('[data-u]');
			if (b) { st[b.dataset.u] = b.dataset.v; render(); }
		});
		root.addEventListener('change', function (e) { if (e.target.dataset.cur !== undefined) { cur = e.target.value; render(); } });
		render();
		speaker(root, function () { return outText(root, '[data-out]'); });
		pdfButton(root, 'Ushr and livestock zakat');
	}

	function Mehr(root) {
		var cur = pickCurrency(root);
		var st = { mine: 0, qty: 0, unit: 'tola', metal: 'gold24' };
		function row(label, v, pr, strong) {
			var g = E.mehrGrams(v);
			return '<tr><td>' + (strong ? '<b>' + esc(label) + '</b>' : esc(label)) + (v.dirham ? '<br><span class="myzt-small">' + v.dirham + ' ' + esc(t('mh_dirham')) + '</span>' : '') + '</td>' +
				'<td>' + (Math.round(g * 100) / 100) + ' ' + unitLabel('gram') + '<br><span class="myzt-small">' + (Math.round(g / E.GRAMS_PER_TOLA * 100) / 100) + ' ' + unitLabel('tola') + '</span></td>' +
				'<td class="z">' + (pr ? money(g * pr.silver, cur) : '—') + '</td></tr>';
		}
		function mineOut() {
			var pr = pricesFor(cur);
			if (!pr || !st.mine) return '';
			var c = E.mehrCheck(st.mine, pr.silver);
			return '<div class="myzt-line"><span>' + esc(t('mh_inSilver')) + '</span><span><b>' + (Math.round(c.grams * 10) / 10) + ' ' + unitLabel('gram') + ' · ' + (Math.round(c.tola * 100) / 100) + ' ' + unitLabel('tola') + '</b></span></div>' +
				'<div class="myzt-line"><span>' + esc(t('mh_fatimi')) + '</span><span><b>' + (Math.round(c.ofFatimi * 1000) / 10) + '%</b> ' + esc(t('mh_ofFatimi')) + '</span></div>' +
				(c.belowMin ? '<div class="myzt-note">' + esc(t('mh_belowMin')) + '</div>' : '');
		}
		function metalOut() {
			var pr = pricesFor(cur);
			if (!pr || !st.qty) return '';
			var g = st.qty * unitGrams(st.unit);
			var v = st.metal === 'silver' ? g * pr.silver : g * pr.gold * (st.metal === 'gold22' ? 22 / 24 : 1);
			return '<div class="myzt-due">' + esc(t('mh_value')) + '</div><div class="myzt-amt">' + money(v, cur) + '</div>';
		}
		function render() { keepFocus(root, draw); }
		function draw() {
			var pr = pricesFor(cur);
			var M = E.MEHR;
			root.innerHTML = '<div class="myzt-card myzt-mini">' + curSelect(cur) +
				'<div class="myzt-scroll"><table class="myzt-table"><thead><tr><th>' + esc(t('mh_kind')) + '</th><th>' + esc(t('mh_silver')) + '</th><th>' + esc(t('mh_value')) + '</th></tr></thead><tbody>' +
				row(t('mh_min'), M.minimum[0], pr, true) + row(t('mh_fatimi'), M.fatimi[0], pr, true) + '</tbody></table></div>' +
				'<details class="myzt-more"><summary class="myzt-small">' + esc(t('mh_other')) + '</summary><div class="myzt-scroll"><table class="myzt-table"><tbody>' +
				M.minimum.slice(1).concat(M.fatimi.slice(1)).map(function (v) { return row(v.by, v, pr, false); }).join('') + '</tbody></table></div></details>' +
				'<p class="myzt-small">' + (pr ? esc(stamp()) + (RATES.source === 'manual' ? '' : ' · ' + t('spotRate')) : esc(t('rateMissing'))) + '</p>' +
				'<div class="myzt-sec"><h2 class="myzt-h">' + esc(t('mh_check')) + '</h2>' +
				'<div class="myzt-field"><label for="myzt-mm">' + esc(t('mh_mine')) + ' (' + cur + ')<span class="myzt-help">' + esc(t('mh_mineHelp')) + '</span></label><input class="myzt-inp" id="myzt-mm" inputmode="decimal" data-m="mine" value="' + esc(plain(st.mine, cur)) + '" placeholder="0"></div>' +
				'<div data-mine>' + mineOut() + '</div></div>' +
				'<div class="myzt-sec"><h2 class="myzt-h">' + esc(t('mh_metal')) + '</h2><p class="myzt-small">' + esc(t('mh_metalHelp')) + '</p>' +
				'<div class="myzt-field"><span class="myzt-seg" role="group">' + ['gold24', 'gold22', 'silver'].map(function (m) {
					return '<button type="button" data-metal="' + m + '" aria-pressed="' + (st.metal === m) + '">' + esc(t(m === 'silver' ? 'mh_silver' : 'mh_' + m)) + '</button>';
				}).join('') + '</span></div>' +
				'<div class="myzt-field"><label for="myzt-mq">' + esc(t('mh_qty')) + '</label><div class="myzt-row"><input class="myzt-inp" id="myzt-mq" inputmode="decimal" data-m="qty" value="' + (st.qty || '') + '" placeholder="0">' +
				'<span class="myzt-seg" role="group">' + ['tola', 'gram'].map(function (u) { return '<button type="button" data-munit="' + u + '" aria-pressed="' + (st.unit === u) + '">' + esc(t('uo_' + u)) + '</button>'; }).join('') + '</span></div></div>' +
				'<div data-metal-out>' + metalOut() + '</div></div>' +
				'<div class="myzt-note">' + esc(t('mh_madhabNote')) + '</div><div class="myzt-disc">' + esc(t('disc')) + '</div></div>';
		}
		root.addEventListener('input', function (e) {
			var k = e.target.dataset.m;
			if (!k) return;
			st[k] = num(e.target.value);
			if (k === 'mine') root.querySelector('[data-mine]').innerHTML = mineOut();
			else root.querySelector('[data-metal-out]').innerHTML = metalOut();
		});
		root.addEventListener('click', function (e) {
			var b = e.target.closest('[data-metal]'), u = e.target.closest('[data-munit]');
			if (b) { st.metal = b.dataset.metal; render(); }
			if (u) { st.unit = u.dataset.munit; render(); }
		});
		root.addEventListener('change', function (e) { if (e.target.dataset.cur !== undefined) { cur = e.target.value; st.mine = 0; render(); } });
		render();
		speaker(root, function () { return [outText(root, '[data-mine]'), outText(root, '[data-metal-out]')].filter(Boolean).join('. '); });
		pdfButton(root, 'Haq mehr');
		freshRates(render);
	}

	/** Diyat is a Pakistani legal amount, so it is shown in rupees only. */
	function Diyat(root) {
		function render() {
			var pr = pricesFor('PKR');
			var N = E.DIYAT_NOTIFIED, now = N[0];
			root.innerHTML = '<div class="myzt-card myzt-mini">' +
				'<div class="myzt-due">' + esc(t('dy_notified')) + ' ' + esc(now.fy) + ' · ' + esc(t('dy_from')) + ' ' + esc(now.fy.slice(0, 4)) + '</div><div class="myzt-amt">' + money(now.pkr, 'PKR') + '</div>' +
				'<div class="myzt-line"><span>' + esc(t('dy_live')) + '</span><span><b>' + (pr ? money(E.diyatValue(pr.silver), 'PKR') : '—') + '</b></span></div>' +
				'<p class="myzt-small">' + (pr ? esc(stamp()) + (RATES.source === 'manual' ? '' : ' · ' + t('spotRate')) : esc(t('dy_noRate'))) + '</p>' +
				'<p class="myzt-small">' + esc(t('dy_liveHelp')) + '</p>' +
				'<div class="myzt-sec"><h2 class="myzt-h">' + esc(t('dy_history')) + '</h2><div class="myzt-scroll"><table class="myzt-table"><thead><tr><th>' + esc(t('dy_fy')) + '</th><th>' + esc(t('dy_amount')) + '</th><th>' + esc(t('dy_source')) + '</th></tr></thead><tbody>' +
				N.map(function (r) { return '<tr><td dir="ltr" style="white-space:nowrap">' + esc(r.fy) + '</td><td class="z">' + money(r.pkr, 'PKR') + '</td><td class="myzt-small">' + esc(r.src) + '</td></tr>'; }).join('') +
				'</tbody></table></div></div>' +
				'<div class="myzt-note">' + esc(t('dy_note')) + '</div></div>';
		}
		render();
		freshRates(render);
		pdfButton(root, 'Diyat (Pakistan)');
	}

	/*
	 * Each widget starts in its own task, so a page with several widgets never makes one long
	 * main-thread block (mobile Total Blocking Time, FIX-049). The first one starts at once.
	 */
	function boot() {
		var map = { calculator: Calculator, goldrate: GoldRate, nisab: Nisab, fitrana: Fitrana, fidya: Fidya, khums: Khums, hawl: Hawl, ushr: Ushr, mehr: Mehr, diyat: Diyat };
		var queue = [];
		document.querySelectorAll('.myzt[data-widget]').forEach(function (el) {
			var fn = map[el.dataset.widget];
			if (fn && !el.dataset.ready) { el.dataset.ready = '1'; queue.push([fn, el]); }
		});
		(function next() {
			var w = queue.shift();
			if (!w) return;
			setLang(w[1]);
			w[0](w[1]);
			if (queue.length) setTimeout(next, 0);
		})();
	}
	if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot);
	else boot();
})();
