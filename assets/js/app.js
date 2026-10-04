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
			gold24: 'Gold 24K', silver: 'Silver', nisab: 'Nisab', per: '/', updated: 'updated', ago: 'ago',
			ownRate: 'Use my own local rate', ownGold: 'Gold 24K price per', ownSilver: 'Silver price per',
			rateMissing: 'Live rate not available right now. Please enter your local rate.',
			quickPh: 'Type it: "3 tola gold, 5 lakh cash and 1 lakh loan"', fill: 'Fill',
			filled: 'Filled from your text. Please check the fields below.', notUnderstood: 'Could not read that. Try: 3 tola gold, 2 lakh bank',
			have: 'What do you own?', haveHint: '(tap all that apply)',
			t_cash: 'Cash', t_bank: 'Bank', t_gold: 'Gold', t_silver: 'Silver', t_business: 'Business', t_shares: 'Shares / Crypto',
			t_committee: 'Committee / BC', t_receivables: 'Money owed to you', t_plot: 'Plot (for sale)', t_debts: 'Debts / Bills',
			f_cash: 'Cash at home', f_prizeBonds: 'Prize bonds', f_savingsCerts: 'Savings certificates (NSC, Behbood, DSC, RIC)',
			t_paid: 'Already paid', f_bankDeducted: 'Zakat the bank deducted on 1 Ramadan', f_paidAlready: 'Zakat already paid this year',
			h_bankDeducted: 'Shown on your bank statement or zakat certificate.', h_savingsCerts: 'Enter the amount invested (face value).',
			l_paid: 'Already paid / deducted by bank', toPay: 'Still to pay', totalZakat: 'Total zakat', f_bank: 'Bank balance (all accounts)',
			f_goldWorn: 'Gold jewellery you wear', f_goldKept: 'Other gold (bars, coins, kept jewellery)',
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
			due: 'Above nisab, zakat is due', notDue: 'Below nisab, zakat is not due',
			l_money: 'Cash, bank and trade wealth', l_goldKept: 'Gold (kept)', l_goldWorn: 'Gold jewellery (worn)',
			l_silverKept: 'Silver (kept)', l_silverWorn: 'Silver jewellery (worn)', l_debts: 'Debts deducted',
			l_gold: 'Gold', l_silver: 'Silver', l_total: 'Zakatable wealth', l_rate: '× 2.5%', why: 'why?',
			w_jewellery_yes: 'In this madhab zakat is due on gold and silver jewellery even if it is worn.',
			w_jewellery_no: 'In this madhab permissible jewellery that is worn has no zakat.',
			w_debts_yes: 'Debts due now are deducted before checking nisab.',
			w_debts_no: "In the relied-upon Shafi'i position, debts do not reduce zakat.",
			w_jafari_money: 'According to Ayatollah Sistani, paper money has no zakat. Khums may apply instead.',
			w_jafari_gold: 'According to Ayatollah Sistani, zakat applies only to gold and silver coins used as currency, which is not the case today.',
			n_jafari_khums: "No zakat on these assets in Ja'fari fiqh (Sistani), but khums (20%) may be due on your yearly surplus.",
			n_shafii_excess_jewellery: "Worn gold above about 860 g exceeds the customary limit, so it is counted (MUIS, al-Majmu').",
			n_shafii_separate: "In Shafi'i fiqh gold and silver are separate; the other metal is checked against its own nisab.",
			n_doubtful_receivables: 'Doubtful debts are not counted now; pay zakat on them when you receive them.',
			n_debts_vs_metal: 'Only one metal entered: its own nisab by weight is used.',
			nisabUsed: 'Nisab used', basisGold: 'gold (87.48 g)', basisSilver: 'silver (612.36 g)', basisCoins: 'coins only',
			chooseNisab: 'Nisab standard', compare: 'Compare all madhabs', hideCompare: 'Hide comparison',
			pdf: 'PDF report', whatsapp: 'WhatsApp', calendar: 'Add to calendar', report: 'Report an error',
			saveFile: 'Save data file', loadFile: 'Open data file', reset: 'Clear all',
			pdfName: 'Name on report (optional)', makePdf: 'Download PDF', making: 'Preparing…',
			cmpTitle: 'Your zakat in every madhab', cmpSub: 'Same inputs, cited sources',
			c_madhab: 'Madhab', c_jewellery: 'Worn jewellery', c_debts: 'Debts deducted', c_nisab: 'Nisab', c_zakat: 'Zakat', c_ref: 'Source',
			yes: 'Yes', no: 'No', included: 'Counted', exempt: 'Exempt', lower: 'Lower of the two', seeKhums: 'See khums',
			disc: 'This calculator gives an estimate for guidance only. It is not a fatwa. Results may contain errors. Please confirm with a qualified scholar of your madhab before paying.',
			discLink: 'Disclaimer', resetConfirm: 'Clear all entries?', savedLocal: 'Saved on this device only.',
			shareText: 'My zakat estimate', calTitle: 'Zakat due (one lunar year)',
			persons: 'Number of people', item: 'Pay as', perPerson: 'Amount per person', fitranaTotal: 'Total fitrana',
			fd_fasts: 'Fasts you cannot make up (fidya)', fd_broken: 'Kaffaras due (fasts broken on purpose)', fd_perDay: 'Amount for one poor person, one day', fd_fidya: 'Fidya', fd_kaffara: 'Kaffara (feeding 60 poor people each)', fd_total: 'Total to pay',
			fd_hFasts: 'Only for illness or old age with no hope of fasting later. Otherwise make the fasts up.', fd_hBroken: 'Hanafi: several fasts broken in the same Ramadan need one kaffara. Kaffara by feeding is only for someone who cannot fast 60 days in a row.',
			wheat: 'Wheat / flour', barley: 'Barley', dates: 'Dates', raisins: 'Raisins',
			k_savings: 'Savings from this year\'s income', k_unused: 'Items bought from income, still unused', k_stock: 'Trade stock (from income)', k_debts: 'Debts of this year',
			k_total: 'Khums (20%)', k_surplus: 'Surplus', k_imam: 'Sahm-e-Imam (10%)', k_sadat: 'Sahm-e-Sadat (10%)',
			perGram: 'per gram', perTola: 'per tola', perOz: 'per ounce', purity: 'Purity',
		},
		ur: {
			madhab: 'مسلک', currency: 'کرنسی', unit: 'وزن کی اکائی', change: 'تبدیل کریں', done: 'ٹھیک ہے',
			gold24: 'سونا 24 قیراط', silver: 'چاندی', nisab: 'نصاب', per: '/', updated: 'اپڈیٹ', ago: 'پہلے',
			ownRate: 'اپنا مقامی ریٹ لکھیں', ownGold: 'سونا 24 قیراط فی', ownSilver: 'چاندی فی',
			rateMissing: 'ابھی لائیو ریٹ دستیاب نہیں۔ براہ کرم اپنا مقامی ریٹ لکھیں۔',
			quickPh: 'لکھیں: 3 tola sona, 5 lakh cash aur 1 lakh qarz', fill: 'بھریں',
			filled: 'آپ کی تحریر سے خانے بھر دیے گئے۔ نیچے چیک کر لیں۔', notUnderstood: 'سمجھ نہیں آیا۔ ایسے لکھیں: 3 tola sona, 2 lakh bank',
			have: 'آپ کے پاس کیا ہے؟', haveHint: '(جو ہے اس پر ٹیپ کریں)',
			t_cash: 'نقد', t_bank: 'بینک', t_gold: 'سونا', t_silver: 'چاندی', t_business: 'کاروبار', t_shares: 'شیئرز/کرپٹو',
			t_committee: 'کمیٹی', t_receivables: 'لینا ہے', t_plot: 'پلاٹ (بیچنے کے لیے)', t_debts: 'قرض/بل',
			f_cash: 'گھر میں نقد رقم', f_prizeBonds: 'پرائز بانڈ', f_savingsCerts: 'بچت سرٹیفکیٹ (این ایس سی، بہبود، ڈی ایس سی)',
			t_paid: 'ادا شدہ', f_bankDeducted: 'یکم رمضان کو بینک کی کاٹی گئی زکوٰۃ', f_paidAlready: 'اس سال پہلے سے ادا کی گئی زکوٰۃ',
			h_bankDeducted: 'بینک اسٹیٹمنٹ یا زکوٰۃ سرٹیفکیٹ پر لکھی ہوتی ہے۔', h_savingsCerts: 'لگائی گئی رقم لکھیں۔',
			l_paid: 'ادا شدہ / بینک کی کٹوتی', toPay: 'ابھی ادا کرنی ہے', totalZakat: 'کل زکوٰۃ', f_bank: 'بینک بیلنس (تمام اکاؤنٹ)',
			f_goldWorn: 'پہنا جانے والا سونے کا زیور', f_goldKept: 'باقی سونا (بسکٹ، سکے، رکھا ہوا زیور)',
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
			due: 'نصاب سے زیادہ، زکوٰۃ فرض ہے', notDue: 'نصاب سے کم، زکوٰۃ فرض نہیں',
			l_money: 'نقد، بینک اور تجارتی مال', l_goldKept: 'سونا (رکھا ہوا)', l_goldWorn: 'سونے کا زیور (پہنا ہوا)',
			l_silverKept: 'چاندی (رکھی ہوئی)', l_silverWorn: 'چاندی کا زیور (پہنا ہوا)', l_debts: 'قرض منہا',
			l_gold: 'سونا', l_silver: 'چاندی', l_total: 'قابلِ زکوٰۃ مال', l_rate: '× 2.5%', why: 'کیوں؟',
			w_jewellery_yes: 'اس مسلک میں سونے چاندی کے زیور پر زکوٰۃ ہے، چاہے پہنا جائے۔',
			w_jewellery_no: 'اس مسلک میں پہنے جانے والے جائز زیور پر زکوٰۃ نہیں۔',
			w_debts_yes: 'نصاب دیکھنے سے پہلے فوری قرض منہا کیا جاتا ہے۔',
			w_debts_no: 'شافعی فقہ کے معتمد قول میں قرض زکوٰۃ کم نہیں کرتا۔',
			w_jafari_money: 'آیت اللہ سیستانی کے مطابق کاغذی کرنسی پر زکوٰۃ نہیں، اس کے بجائے خمس ہو سکتا ہے۔',
			w_jafari_gold: 'آیت اللہ سیستانی کے مطابق زکوٰۃ صرف ان سونے چاندی کے سکوں پر ہے جو بطور کرنسی چلیں، جو آج نہیں۔',
			n_jafari_khums: 'فقہ جعفری (سیستانی) میں ان چیزوں پر زکوٰۃ نہیں، لیکن سالانہ بچت پر خمس (20%) واجب ہو سکتا ہے۔',
			n_shafii_excess_jewellery: 'تقریباً 860 گرام سے زیادہ پہنا سونا عرف سے زیادہ ہے، اس لیے شامل ہے۔',
			n_shafii_separate: 'شافعی فقہ میں سونا اور چاندی الگ ہیں؛ دوسری دھات اپنے نصاب سے دیکھی جاتی ہے۔',
			n_doubtful_receivables: 'مشکوک قرض ابھی شامل نہیں؛ ملنے پر اس کی زکوٰۃ دیں۔',
			n_debts_vs_metal: 'صرف ایک دھات ہے، اس لیے اسی کا نصاب (وزن) لگا۔',
			nisabUsed: 'نصاب', basisGold: 'سونا (87.48 گرام)', basisSilver: 'چاندی (612.36 گرام)', basisCoins: 'صرف سکے',
			chooseNisab: 'نصاب کا معیار', compare: 'تمام مسالک کا موازنہ', hideCompare: 'موازنہ چھپائیں',
			pdf: 'PDF رپورٹ', whatsapp: 'واٹس ایپ', calendar: 'کیلنڈر میں شامل کریں', report: 'غلطی بتائیں',
			saveFile: 'ڈیٹا فائل محفوظ کریں', loadFile: 'ڈیٹا فائل کھولیں', reset: 'سب صاف کریں',
			pdfName: 'رپورٹ پر نام (اختیاری)', makePdf: 'PDF ڈاؤن لوڈ کریں', making: 'تیار ہو رہی ہے…',
			cmpTitle: 'ہر مسلک میں آپ کی زکوٰۃ', cmpSub: 'ایک ہی معلومات، حوالوں کے ساتھ',
			c_madhab: 'مسلک', c_jewellery: 'پہنا زیور', c_debts: 'قرض منہا', c_nisab: 'نصاب', c_zakat: 'زکوٰۃ', c_ref: 'حوالہ',
			yes: 'ہاں', no: 'نہیں', included: 'شامل', exempt: 'نہیں', lower: 'جو کم ہو', seeKhums: 'خمس دیکھیں',
			disc: 'یہ کیلکولیٹر صرف رہنمائی کے لیے اندازہ دیتا ہے۔ یہ فتویٰ نہیں، اور اس میں غلطی ممکن ہے۔ زکوٰۃ ادا کرنے سے پہلے اپنے مسلک کے مستند عالم سے تصدیق کر لیں۔',
			discLink: 'ڈسکلیمر', resetConfirm: 'سب خانے صاف کر دیں؟', savedLocal: 'صرف اسی ڈیوائس پر محفوظ۔',
			shareText: 'میری زکوٰۃ کا اندازہ', calTitle: 'زکوٰۃ کی تاریخ (ایک قمری سال)',
			persons: 'افراد کی تعداد', item: 'کس چیز سے', perPerson: 'فی فرد رقم', fitranaTotal: 'کل فطرانہ',
			fd_fasts: 'روزے جن کی قضا ممکن نہیں (فدیہ)', fd_broken: 'کفارے (جان بوجھ کر توڑے گئے روزے)', fd_perDay: 'ایک مسکین کا ایک دن کا کھانا', fd_fidya: 'فدیہ', fd_kaffara: 'کفارہ (ہر ایک کے لیے 60 مسکین)', fd_total: 'کل رقم',
			fd_hFasts: 'صرف بیماری یا بڑھاپے میں جب بعد میں روزہ رکھنے کی امید نہ ہو۔ ورنہ قضا رکھیں۔', fd_hBroken: 'حنفی: ایک رمضان کے کئی توڑے گئے روزوں کا ایک کفارہ کافی ہے۔ کھانا کھلانا صرف اس کے لیے ہے جو 60 مسلسل روزے نہ رکھ سکے۔',
			wheat: 'گندم / آٹا', barley: 'جو', dates: 'کھجور', raisins: 'کشمش',
			k_savings: 'اس سال کی آمدنی سے بچت', k_unused: 'آمدنی سے خریدی غیر استعمال شدہ چیزیں', k_stock: 'تجارتی مال (آمدنی سے)', k_debts: 'اس سال کے قرض',
			k_total: 'خمس (20%)', k_surplus: 'بچت', k_imam: 'سہمِ امام (10%)', k_sadat: 'سہمِ سادات (10%)',
			perGram: 'فی گرام', perTola: 'فی تولہ', perOz: 'فی اونس', purity: 'خالصیت',
		},
	};

	var lang = 'en';
	try { lang = localStorage.getItem(LANG_KEY) || (document.documentElement.lang || '').slice(0, 2) || 'en'; } catch (e) {}
	if (!T[lang]) lang = 'en';
	function t(k) { return (T[lang] && T[lang][k]) || T.en[k] || k; }

	/* ---------- helpers ---------- */
	function esc(s) {
		return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) {
			return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
		});
	}
	function num(v) { var n = parseFloat(String(v == null ? '' : v).replace(/[^0-9.]/g, '')); return isFinite(n) ? n : 0; }
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
		if (m < 60) return m + ' min ' + t('ago');
		var h = Math.round(m / 60);
		if (h < 48) return h + ' h ' + t('ago');
		return Math.round(h / 24) + ' d ' + t('ago');
	}
	function load(k, d) { try { var v = localStorage.getItem(k); return v ? JSON.parse(v) : d; } catch (e) { return d; } }
	function save(k, v) { try { localStorage.setItem(k, JSON.stringify(v)); } catch (e) {} }
	function unitLabel(u) { return u === 'tola' ? 'tola' : u === 'oz' ? 'oz' : 'g'; }
	function unitGrams(u) { return u === 'tola' ? E.GRAMS_PER_TOLA : u === 'oz' ? E.GRAMS_PER_OZ : 1; }
	function download(name, blob) {
		var a = document.createElement('a');
		a.href = URL.createObjectURL(blob);
		a.download = name;
		document.body.appendChild(a);
		a.click();
		setTimeout(function () { URL.revokeObjectURL(a.href); a.remove(); }, 500);
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
	function freshRates(cb) {
		if (!CFG.restUrl) return;
		if (RATES.updated && Date.now() / 1000 - RATES.updated < 2 * 3600) return;
		fetch(CFG.restUrl, { credentials: 'omit' }).then(function (r) { return r.json(); }).then(function (d) {
			if (d && d.goldUsdOz && (!RATES.updated || d.updated > RATES.updated)) { RATES = d; cb(); }
		}).catch(function () {});
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
		var draft = load(DRAFT_KEY, null);
		var st = draft && draft.v === 1 ? draft : {
			v: 1, madhab: cd.madhab, currency: cd.currency, unit: cd.unit,
			persons: [newPerson('')], active: 0, nisabBasis: '', own: { on: false, gold: 0, silver: 0 },
		};
		if (opts.madhab && E.MADHABS[opts.madhab]) st.madhab = opts.madhab;
		if (currencies().indexOf(st.currency) < 0) st.currency = currencies().indexOf(cd.currency) >= 0 ? cd.currency : 'USD';
		var ui = { ctx: false, compare: opts.compare === 'open', why: {}, pdf: false, msg: '' };

		function prices() {
			var g = unitGrams(st.unit);
			if (st.own.on && st.own.gold > 0) {
				return { gold: st.own.gold / g, silver: (st.own.silver || 0) / g };
			}
			var fx = st.currency === 'USD' ? 1 : fxFor(st.currency);
			if (!RATES.goldUsdOz || !fx) return null;
			return E.perGram({ goldUsdOz: RATES.goldUsdOz, silverUsdOz: RATES.silverUsdOz, fx: fx });
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
						metals[f[1]] = { weight: num(m.weight), unit: m.unit || st.unit, karat: f[1].indexOf('gold') === 0 ? (m.karat || 22) : 24 };
					}
				});
			});
			return {
				money: money, liabilities: liab, goldWorn: metals.goldWorn, goldKept: metals.goldKept,
				silverWorn: metals.silverWorn, silverKept: metals.silverKept, nisabBasis: st.nisabBasis,
			};
		}

		function persist() { save(DRAFT_KEY, st); }

		function field(kind, key, p) {
			var id = 'myzt-' + key + '-' + st.active;
			var help = t('h_' + key) !== 'h_' + key ? '<span class="myzt-help">' + esc(t('h_' + key)) + '</span>' : '';
			if (kind === 'metal') {
				var m = p.metal[key] || {};
				var u = m.unit || st.unit;
				var isGold = key.indexOf('gold') === 0;
				var k = m.karat || 22;
				var seg = ['tola', 'gram', 'oz'].map(function (x) {
					return '<button type="button" data-metal-unit="' + key + '" data-v="' + x + '" aria-pressed="' + (u === x) + '">' + unitLabel(x) + '</button>';
				}).join('');
				var kseg = isGold ? '<span class="myzt-seg" role="group" aria-label="' + esc(t('karat')) + '">' + [24, 22, 21, 18].map(function (x) {
					return '<button type="button" data-metal-karat="' + key + '" data-v="' + x + '" aria-pressed="' + (k === x) + '">' + x + 'K</button>';
				}).join('') + '</span>' : '';
				return '<div class="myzt-field"><label for="' + id + '">' + esc(t('f_' + key)) + help + '</label><div class="myzt-row">' +
					'<input class="myzt-inp" id="' + id + '" inputmode="decimal" autocomplete="off" data-metal="' + key + '" value="' + esc(m.weight || '') + '" placeholder="0">' +
					'<span class="myzt-seg" role="group">' + seg + '</span>' + kseg + '</div></div>';
			}
			var bag = kind === 'liab' ? p.liab : p.money;
			return '<div class="myzt-field"><label for="' + id + '">' + esc(t('f_' + key)) + help + '</label><div class="myzt-row">' +
				'<input class="myzt-inp" id="' + id + '" inputmode="decimal" autocomplete="off" data-' + kind + '="' + key + '" value="' + esc(plain(num(bag[key]), st.currency)) + '" placeholder="0"></div></div>';
		}

		function render() {
			var p = st.persons[st.active];
			var pr = prices();
			var m = E.MADHABS[st.madhab];
			var html = '';

			html += '<div class="myzt-grid"><div class="myzt-card">';
			// Context bar.
			html += '<div class="myzt-ctx"><div>' + flag(COUNTRY) + ' <b>' + esc(m.name) + '</b> · ' + esc(st.currency) + ' · ' + esc(unitLabel(st.unit)) + '</div>' +
				'<div><button type="button" class="myzt-link" data-act="lang">' + (lang === 'en' ? 'اردو' : 'English') + '</button> · ' +
				'<button type="button" class="myzt-link" data-act="ctx" aria-expanded="' + ui.ctx + '">' + esc(ui.ctx ? t('done') : t('change')) + '</button></div></div>';
			if (ui.ctx) {
				html += '<div class="myzt-ctxform">' +
					'<div><label for="myzt-madhab">' + esc(t('madhab')) + '</label><select class="myzt-sel" id="myzt-madhab" data-set="madhab">' +
					E.MADHAB_ORDER.map(function (k) { return '<option value="' + k + '"' + (k === st.madhab ? ' selected' : '') + '>' + esc(E.MADHABS[k].name) + '</option>'; }).join('') + '</select></div>' +
					'<div><label for="myzt-cur">' + esc(t('currency')) + '</label><select class="myzt-sel" id="myzt-cur" data-set="currency">' +
					currencies().map(function (c) { return '<option' + (c === st.currency ? ' selected' : '') + '>' + c + '</option>'; }).join('') + '</select></div>' +
					'<div><label for="myzt-unit">' + esc(t('unit')) + '</label><select class="myzt-sel" id="myzt-unit" data-set="unit">' +
					['tola', 'gram', 'oz'].map(function (u) { return '<option value="' + u + '"' + (u === st.unit ? ' selected' : '') + '>' + u + '</option>'; }).join('') + '</select></div></div>';
			}
			// Rates.
			if (pr) {
				var g = unitGrams(st.unit), nv = E.nisabValues(pr);
				html += '<div class="myzt-rates"><span>' + esc(t('gold24')) + ': <strong>' + money(pr.gold * g, st.currency) + '</strong>/' + unitLabel(st.unit) + '</span>' +
					'<span>' + esc(t('silver')) + ': <strong>' + money(pr.silver * g, st.currency) + '</strong>/' + unitLabel(st.unit) + '</span>' +
					'<span>' + esc(t('nisab')) + ': <strong>' + money(nv.silver, st.currency) + '</strong> (' + esc(t('silver')) + ') · <strong>' + money(nv.gold, st.currency) + '</strong> (' + esc(t('l_gold')) + ')</span>' +
					(st.own.on ? '' : '<span>' + esc(t('updated')) + ' ' + esc(ago(RATES.updated)) + '</span>') + '</div>';
			} else {
				html += '<div class="myzt-note">' + esc(t('rateMissing')) + '</div>';
			}
			html += '<label class="myzt-small"><input type="checkbox" data-act="own"' + (st.own.on || !pr ? ' checked' : '') + '> ' + esc(t('ownRate')) + '</label>';
			if (st.own.on || !pr) {
				html += '<div class="myzt-own"><label class="myzt-small">' + esc(t('ownGold')) + ' ' + unitLabel(st.unit) + '<input class="myzt-inp" inputmode="decimal" data-own="gold" value="' + esc(plain(st.own.gold, st.currency)) + '"></label>' +
					'<label class="myzt-small">' + esc(t('ownSilver')) + ' ' + unitLabel(st.unit) + '<input class="myzt-inp" inputmode="decimal" data-own="silver" value="' + esc(plain(st.own.silver, st.currency)) + '"></label></div>';
			}
			// Quick text.
			html += '<div class="myzt-quick"><input class="myzt-inp" data-quick placeholder="' + esc(t('quickPh')) + '" aria-label="' + esc(t('quickPh')) + '"><button type="button" class="myzt-btn" data-act="fill">' + esc(t('fill')) + '</button></div>';
			if (ui.msg) html += '<div class="myzt-note" role="status">' + esc(ui.msg) + '</div>';
			// Family members.
			html += '<div class="myzt-people">' + st.persons.map(function (pp, i) {
				return '<button type="button" class="myzt-person" data-person="' + i + '" aria-pressed="' + (i === st.active) + '">' + esc(pp.name || (i === 0 ? t('me') : t('personName') + ' ' + (i + 1))) + '</button>';
			}).join('') + '<button type="button" class="myzt-link" data-act="add">' + esc(t('addPerson')) + '</button></div>';
			if (st.active > 0) {
				html += '<div class="myzt-row"><input class="myzt-inp" data-pname value="' + esc(p.name) + '" placeholder="' + esc(t('personName')) + '"><button type="button" class="myzt-btn" data-act="rm">' + esc(t('remove')) + '</button></div>';
			}
			// Tiles.
			html += '<div class="myzt-q">' + esc(t('have')) + ' <small>' + esc(t('haveHint')) + '</small></div><div class="myzt-tiles">' +
				TILES.map(function (tile) {
					return '<button type="button" class="myzt-tile" data-tile="' + tile[0] + '" aria-pressed="' + !!p.tiles[tile[0]] + '"><span class="ic" aria-hidden="true">' + tile[1] + '</span>' + esc(t('t_' + tile[0])) + '</button>';
				}).join('') + '</div>';
			// Fields of chosen tiles.
			TILES.forEach(function (tile) {
				if (!p.tiles[tile[0]]) return;
				html += '<div class="myzt-sec"><h4>' + esc(t('t_' + tile[0])) + '</h4>' + tile[2].map(function (f) { return field(f[0], f[1], p); }).join('') + '</div>';
			});
			if (m.userNisab) {
				var nb = st.nisabBasis || m.cashNisab;
				html += '<div class="myzt-sec"><div class="myzt-field"><label>' + esc(t('chooseNisab')) + '</label><span class="myzt-seg">' +
					['gold', 'silver'].map(function (b) { return '<button type="button" data-nisab="' + b + '" aria-pressed="' + (nb === b) + '">' + esc(t(b === 'gold' ? 'basisGold' : 'basisSilver')) + '</button>'; }).join('') + '</span></div></div>';
			}
			html += '<p class="myzt-small">🔒 ' + esc(t('savedLocal')) + '</p>';
			html += '</div>';

			// Result.
			html += '<div class="myzt-card myzt-res" aria-live="polite">' + resultHtml(pr) + '</div></div>';

			if (ui.compare && pr) html += compareHtml(pr);
			root.innerHTML = html;
			sticky(pr);
		}

		function results(pr) {
			return st.persons.map(function (p) { return E.calculate(st.madhab, personInput(p), pr); });
		}

		function resultHtml(pr) {
			if (!pr) return '<div class="myzt-due">' + esc(t('yourZakat')) + '</div><div class="myzt-amt">—</div><div class="myzt-note">' + esc(t('rateMissing')) + '</div>';
			var all = results(pr);
			var r = all[st.active];
			var p = st.persons[st.active];
			var html = '<div class="myzt-due">' + esc(st.persons.length > 1 ? t('zakatFor') + ' ' + (p.name || (st.active === 0 ? t('me') : '#' + (st.active + 1))) : t('yourZakat')) + ' (' + esc(r.name) + ')</div>' +
				'<div class="myzt-amt">' + money(r.paid ? r.payable : r.zakat, st.currency) + '</div>' +
				(r.paid ? '<div class="myzt-small">' + esc(t('toPay')) + ' · ' + esc(t('totalZakat')) + ' ' + money(r.zakat, st.currency) + '</div>' : '') +
				'<div class="myzt-badge' + (r.due ? '' : ' no') + '">' + (r.due ? '✓ ' + esc(t('due')) : esc(t('notDue'))) + '</div>';
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
				'<button type="button" class="myzt-btn wide" data-act="reset">' + esc(t('reset')) + '</button></div>';
			if (ui.pdf) {
				html += '<div class="myzt-pdfname"><input class="myzt-inp" data-pdfname placeholder="' + esc(t('pdfName')) + '" aria-label="' + esc(t('pdfName')) + '"><button type="button" class="myzt-btn p" data-act="makepdf">' + esc(t('makePdf')) + '</button></div>';
			}
			html += '<div class="myzt-disc">' + esc(t('disc')) + (CFG.urls && CFG.urls.disclaimer ? ' <a href="' + esc(CFG.urls.disclaimer) + '">' + esc(t('discLink')) + '</a>' : '') + '</div>';
			return html;
		}

		function compareHtml(pr) {
			var input = personInput(st.persons[st.active]);
			var rows = E.compare(input, pr).map(function (r) {
				var m = E.MADHABS[r.madhab];
				var nb = r.khums ? t('basisCoins') : (m.cashNisab === 'lower' ? t('lower') : t(r.nisabBasis === 'gold' ? 'basisGold' : 'basisSilver'));
				var ref = CFG.urls && CFG.urls.methodology ? '<a href="' + esc(CFG.urls.methodology) + '#' + r.madhab + '">' + esc(m.ref.split(',')[0]) + '</a>' : esc(m.ref.split(',')[0]);
				return '<tr class="' + (r.madhab === st.madhab ? 'sel' : '') + '"><td>' + esc(r.name) + '</td><td>' + esc(m.jewellery ? t('included') : t('exempt')) + '</td><td>' + esc(m.debts ? t('yes') : t('no')) + '</td><td>' + esc(nb) + '</td>' +
					'<td class="z">' + money(r.zakat, st.currency) + (r.khums ? ' · ' + esc(t('seeKhums')) : '') + '</td><td>' + ref + '</td></tr>';
			}).join('');
			return '<div class="myzt-card myzt-cmp"><div class="myzt-cmp-h"><b>' + esc(t('cmpTitle')) + '</b><span class="myzt-small">' + esc(t('cmpSub')) + '</span></div>' +
				'<div class="myzt-scroll"><table class="myzt-table"><thead><tr><th>' + esc(t('c_madhab')) + '</th><th>' + esc(t('c_jewellery')) + '</th><th>' + esc(t('c_debts')) + '</th><th>' + esc(t('c_nisab')) + '</th><th>' + esc(t('c_zakat')) + '</th><th>' + esc(t('c_ref')) + '</th></tr></thead><tbody>' + rows + '</tbody></table></div></div>';
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
			if (!pr) { stickyEl.hidden = true; return; }
			var all = results(pr);
			var total = all.length > 1 ? E.family(all) : all[0].payable;
			stickyEl.hidden = false;
			stickyEl.innerHTML = '<span>' + esc(all.length > 1 ? t('family') : t('yourZakat')) + ' (' + esc(E.MADHABS[st.madhab].name) + ')</span><b>' + money(total, st.currency) + '</b>';
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
			else if (el.dataset.metal) { p.metal[el.dataset.metal] = p.metal[el.dataset.metal] || {}; p.metal[el.dataset.metal].weight = el.value.replace(/[^0-9.]/g, ''); }
			else if (el.dataset.own) st.own[el.dataset.own] = num(el.value);
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
			if (el.dataset.money || el.dataset.liab || el.dataset.own) el.value = plain(num(el.value), st.currency);
		});

		root.addEventListener('change', function (e) {
			var el = e.target;
			if (el.dataset.set) {
				st[el.dataset.set] = el.value;
				if (el.dataset.set === 'madhab') st.nisabBasis = '';
				persist(); render();
			} else if (el.dataset.act === 'own') {
				st.own.on = el.checked; persist(); render();
			} else if (el.hasAttribute('data-loadfile') && el.files[0]) {
				var fr = new FileReader();
				fr.onload = function () {
					try {
						var d = JSON.parse(fr.result);
						if (d && d.v === 1 && Array.isArray(d.persons)) { st = d; st.active = 0; persist(); render(); }
					} catch (err) {}
				};
				fr.readAsText(el.files[0]);
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
					var key = k + 'Worn';
					p.metal[key] = { weight: String(r[k].weight), unit: r[k].unit, karat: r[k].karat || (k === 'gold' ? 22 : 24) };
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
			if (d.metalKarat) { p.metal[d.metalKarat] = p.metal[d.metalKarat] || {}; p.metal[d.metalKarat].karat = +d.v; persist(); render(); return; }
			if (d.person) { st.active = +d.person; ui.why = {}; persist(); render(); return; }
			if (d.nisab) { st.nisabBasis = d.nisab; persist(); render(); return; }
			if (d.why) { ui.why[d.why] = !ui.why[d.why]; updateResult(); return; }
			switch (d.act) {
				case 'ctx': ui.ctx = !ui.ctx; render(); break;
				case 'lang': lang = lang === 'en' ? 'ur' : 'en'; try { localStorage.setItem(LANG_KEY, lang); } catch (x) {} root.dir = lang === 'ur' ? 'rtl' : 'ltr'; render(); break;
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
					if (window.confirm(t('resetConfirm'))) { st.persons = [newPerson('')]; st.active = 0; ui.msg = ''; persist(); render(); }
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
			var d = new Date(Date.now() + 354 * 864e5);
			var ymd = d.toISOString().slice(0, 10).replace(/-/g, '');
			var end = new Date(d.getTime() + 864e5).toISOString().slice(0, 10).replace(/-/g, '');
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
			if (!pr || !window.MYZT_PDF) return;
			btn.disabled = true;
			btn.textContent = t('making');
			var nameEl = root.querySelector('[data-pdfname]');
			window.MYZT_PDF.build({
				name: nameEl ? nameEl.value.slice(0, 60) : '',
				madhab: E.MADHABS[st.madhab].name, currency: st.currency, unit: st.unit,
				prices: pr, nisab: E.nisabValues(pr), own: st.own.on, source: RATES.source || '', updated: RATES.updated,
				persons: st.persons.map(function (p, i) {
					var input = personInput(p);
					return { name: p.name || (i === 0 ? 'Me' : 'Member ' + (i + 1)), input: input, result: E.calculate(st.madhab, input, pr) };
				}),
				money: function (v) { return money(v, st.currency); },
				site: CFG.siteUrl || location.origin,
			}).then(function () {
				btn.disabled = false; btn.textContent = t('makePdf');
			}, function () {
				btn.disabled = false; btn.textContent = t('makePdf');
			});
		}

		root.dir = lang === 'ur' ? 'rtl' : 'ltr';
		render();
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
				'<p class="myzt-small">' + esc(t('updated')) + ' ' + esc(ago(RATES.updated)) + ' · international spot rate</p></div>';
		}
		root.addEventListener('change', function (e) { if (e.target.dataset.cur !== undefined) { cur = e.target.value; render(); } });
		render();
		freshRates(render);
	}

	function Nisab(root) {
		var cur = pickCurrency(root);
		function render() {
			var pr = pricesFor(cur);
			if (!pr) return;
			var nv = E.nisabValues(pr);
			root.innerHTML = '<div class="myzt-card">' + curSelect(cur) + '<div class="myzt-scroll"><table class="myzt-table"><thead><tr><th>' + esc(t('nisab')) + '</th><th>Weight</th><th>' + esc(t('c_zakat')) + ' ' + esc(t('nisab')) + '</th></tr></thead><tbody>' +
				'<tr><td>' + esc(t('silver')) + '</td><td>612.36 g · 52.5 tola</td><td class="z">' + money(nv.silver, cur) + '</td></tr>' +
				'<tr><td>' + esc(t('l_gold')) + '</td><td>87.48 g · 7.5 tola</td><td class="z">' + money(nv.gold, cur) + '</td></tr></tbody></table></div>' +
				'<p class="myzt-small">' + esc(t('updated')) + ' ' + esc(ago(RATES.updated)) + ' · international spot rate</p></div>';
		}
		root.addEventListener('change', function (e) { if (e.target.dataset.cur !== undefined) { cur = e.target.value; render(); } });
		render();
		freshRates(render);
	}

	function Fitrana(root) {
		var F = CFG.fitrana || {};
		var cur = pickCurrency(root);
		var st = { persons: 1, item: 'wheat', amount: 0 };
		function preset() { return (F.currency === cur && F[st.item]) ? +F[st.item] : 0; }
		st.amount = preset();
		function render() {
			root.innerHTML = '<div class="myzt-card myzt-mini">' + curSelect(cur) +
				'<div class="myzt-field"><label for="myzt-fp">' + esc(t('persons')) + '</label><input class="myzt-inp" id="myzt-fp" inputmode="numeric" data-f="persons" value="' + st.persons + '"></div>' +
				'<div class="myzt-field"><label>' + esc(t('item')) + '</label><span class="myzt-seg">' + ['wheat', 'barley', 'dates', 'raisins'].map(function (i) {
					return '<button type="button" data-item="' + i + '" aria-pressed="' + (st.item === i) + '">' + esc(t(i)) + '</button>';
				}).join('') + '</span></div>' +
				'<div class="myzt-field"><label for="myzt-fa">' + esc(t('perPerson')) + ' (' + cur + ')</label><input class="myzt-inp" id="myzt-fa" inputmode="decimal" data-f="amount" value="' + esc(plain(st.amount, cur)) + '"></div>' +
				'<div class="myzt-due">' + esc(t('fitranaTotal')) + '</div><div class="myzt-amt" data-out>' + money(E.fitrana(st.persons, st.amount), cur) + '</div>' +
				(F.note ? '<p class="myzt-small">' + esc(F.note) + '</p>' : '') + '<div class="myzt-disc">' + esc(t('disc')) + '</div></div>';
		}
		root.addEventListener('input', function (e) {
			var f = e.target.dataset.f;
			if (!f) return;
			st[f] = num(e.target.value);
			root.querySelector('[data-out]').textContent = money(E.fitrana(st.persons, st.amount), cur);
		});
		root.addEventListener('change', function (e) { if (e.target.dataset.cur !== undefined) { cur = e.target.value; st.amount = preset(); render(); } });
		root.addEventListener('click', function (e) {
			var b = e.target.closest('[data-item]');
			if (b) { st.item = b.dataset.item; st.amount = preset() || st.amount; render(); }
		});
		render();
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
		function render() {
			root.innerHTML = '<div class="myzt-card myzt-mini">' + curSelect(cur) +
				'<div class="myzt-field"><label for="myzt-df">' + esc(t('fd_fasts')) + '<span class="myzt-help">' + esc(t('fd_hFasts')) + '</span></label><input class="myzt-inp" id="myzt-df" inputmode="numeric" data-f="fasts" value="' + (st.fasts || '') + '" placeholder="0"></div>' +
				'<div class="myzt-field"><label for="myzt-dk">' + esc(t('fd_broken')) + '<span class="myzt-help">' + esc(t('fd_hBroken')) + '</span></label><input class="myzt-inp" id="myzt-dk" inputmode="numeric" data-f="broken" value="' + (st.broken || '') + '" placeholder="0"></div>' +
				'<div class="myzt-field"><label>' + esc(t('item')) + '</label><span class="myzt-seg">' + ['wheat', 'barley', 'dates', 'raisins'].map(function (i) {
					return '<button type="button" data-item="' + i + '" aria-pressed="' + (st.item === i) + '">' + esc(t(i)) + '</button>';
				}).join('') + '</span></div>' +
				'<div class="myzt-field"><label for="myzt-da">' + esc(t('fd_perDay')) + ' (' + cur + ')</label><input class="myzt-inp" id="myzt-da" inputmode="decimal" data-f="amount" value="' + esc(plain(st.amount, cur)) + '"></div>' +
				'<div data-out>' + out() + '</div>' +
				(F.note ? '<p class="myzt-small">' + esc(F.note) + '</p>' : '') + '<div class="myzt-disc">' + esc(t('disc')) + '</div></div>';
		}
		root.addEventListener('input', function (e) {
			var f = e.target.dataset.f;
			if (!f) return;
			st[f] = num(e.target.value);
			root.querySelector('[data-out]').innerHTML = out();
		});
		root.addEventListener('change', function (e) { if (e.target.dataset.cur !== undefined) { cur = e.target.value; st.amount = preset(); render(); } });
		root.addEventListener('click', function (e) {
			var b = e.target.closest('[data-item]');
			if (b) { st.item = b.dataset.item; st.amount = preset() || st.amount; render(); }
		});
		render();
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
			}).join('') + '<div data-out>' + out() + '</div><div class="myzt-disc">' + esc(t('disc')) + '</div></div>';
		}
		root.addEventListener('input', function (e) {
			var k = e.target.dataset.k;
			if (!k) return;
			st[k] = num(e.target.value);
			root.querySelector('[data-out]').innerHTML = out();
		});
		root.addEventListener('change', function (e) { if (e.target.dataset.cur !== undefined) { cur = e.target.value; render(); } });
		render();
	}

	function boot() {
		var map = { calculator: Calculator, goldrate: GoldRate, nisab: Nisab, fitrana: Fitrana, fidya: Fidya, khums: Khums };
		document.querySelectorAll('.myzt[data-widget]').forEach(function (el) {
			var fn = map[el.dataset.widget];
			if (fn && !el.dataset.ready) { el.dataset.ready = '1'; fn(el); }
		});
	}
	if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot);
	else boot();
})();
