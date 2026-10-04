/**
 * My Zakat Tool: calculation engine.
 *
 * Pure functions, no DOM. Runs in the browser (window.MYZT_ENGINE) and in Node (tests).
 * Rules and citations: see the Methodology page and fiqh-rules notes.
 */
(function (root, factory) {
	if (typeof module === 'object' && module.exports) {
		module.exports = factory();
	} else {
		root.MYZT_ENGINE = factory();
	}
})(typeof self !== 'undefined' ? self : this, function () {
	'use strict';

	var GRAMS_PER_TOLA = 11.6638038;
	var GRAMS_PER_OZ = 31.1034768;
	// 7.5 tola (87.48 g) and 52.5 tola (612.36 g); defined from the tola so tola inputs match exactly.
	var GOLD_NISAB_G = 7.5 * GRAMS_PER_TOLA;
	var SILVER_NISAB_G = 52.5 * GRAMS_PER_TOLA;
	var RATE = 0.025;
	// Shafi'i: worn jewellery above the customary limit (200 mithqal) loses its exemption (MUIS, al-Majmu').
	var SHAFII_JEWELLERY_LIMIT_G = 860;

	/**
	 * jewellery: is worn jewellery zakatable.
	 * debts: are debts deducted.
	 * cashNisab: 'silver' | 'gold' | 'lower', default nisab for cash and mixed wealth.
	 * userNisab: may the user switch the nisab basis.
	 * combine: are gold and silver combined to complete the nisab.
	 */
	var MADHABS = {
		hanafi: {
			name: 'Hanafi', jewellery: true, debts: true, cashNisab: 'silver', userNisab: false, combine: true,
			ref: 'Darul Uloom Deoband, Fatwa 2310/H=713/th=1431 and 702/702=M/1429',
		},
		shafii: {
			name: "Shafi'i", jewellery: false, debts: false, cashNisab: 'gold', userNisab: true, combine: false,
			ref: "Imam al-Nawawi, al-Majmu'; MUIS Office of the Mufti (Zakat on Gold Jewellery)",
		},
		maliki: {
			name: 'Maliki', jewellery: false, debts: true, cashNisab: 'silver', userNisab: true, combine: true,
			ref: 'Mufti of Wilayah Persekutuan, Irsyad Fatwa 38; SeekersGuidance (debts by madhab)',
		},
		hanbali: {
			name: 'Hanbali', jewellery: false, debts: true, cashNisab: 'lower', userNisab: false, combine: true,
			ref: 'Akhsar al-Mukhtasarat, Book of Zakat (Hanbali)',
		},
		ahlehadith: {
			name: 'Ahl-e-Hadith', jewellery: true, debts: true, cashNisab: 'lower', userNisab: false, combine: true,
			ref: 'Permanent Committee (al-Lajnah ad-Daimah) via IslamQA 19901 and 201807',
		},
		jafari: {
			name: "Shia (Ja'fari)", jewellery: false, debts: false, cashNisab: 'gold', userNisab: false, combine: false,
			ref: 'Ayatollah Sistani, Islamic Laws, rulings 1912-1916', khums: true,
		},
	};

	var MADHAB_ORDER = ['hanafi', 'shafii', 'maliki', 'hanbali', 'ahlehadith', 'jafari'];

	// Asset fields that count as money / trade wealth (same treatment in every Sunni madhab).
	var MONEY_FIELDS = ['cash', 'bank', 'committee', 'businessCash', 'stock', 'receivables', 'shares', 'crypto', 'prizeBonds', 'plot', 'other'];
	var DEBT_FIELDS = ['debts', 'installments', 'bills', 'suppliers'];

	function num(v) {
		var n = typeof v === 'number' ? v : parseFloat(String(v || '').replace(/,/g, ''));
		return isFinite(n) && n > 0 ? n : 0;
	}

	function toGrams(weight, unit) {
		var w = num(weight);
		if (unit === 'tola') return w * GRAMS_PER_TOLA;
		if (unit === 'oz') return w * GRAMS_PER_OZ;
		return w;
	}

	function karatFactor(k) {
		var n = num(k);
		return n > 0 && n <= 24 ? n / 24 : 1;
	}

	/** Pure-gold grams for a metal entry {weight, unit, karat}. */
	function pureGoldGrams(item) {
		if (!item) return 0;
		return toGrams(item.weight, item.unit) * karatFactor(item.karat);
	}

	function silverGrams(item) {
		if (!item) return 0;
		return toGrams(item.weight, item.unit);
	}

	/**
	 * Price per gram in the user's currency from USD-per-ounce spot prices and a USD fx rate.
	 * rates: { goldUsdOz, silverUsdOz, fx } where fx = units of the currency per 1 USD.
	 */
	function perGram(rates) {
		var fx = num(rates.fx) || 1;
		return {
			gold: (num(rates.goldUsdOz) * fx) / GRAMS_PER_OZ,
			silver: (num(rates.silverUsdOz) * fx) / GRAMS_PER_OZ,
		};
	}

	function nisabValues(prices) {
		var gold = GOLD_NISAB_G * prices.gold;
		var silver = SILVER_NISAB_G * prices.silver;
		return { gold: gold, silver: silver, lower: Math.min(gold, silver) };
	}

	function sumFields(obj, fields) {
		var s = 0;
		for (var i = 0; i < fields.length; i++) s += num(obj && obj[fields[i]]);
		return s;
	}

	/**
	 * Calculate zakat for one person under one madhab.
	 *
	 * input: {
	 *   money: { cash, bank, committee, businessCash, stock, receivables, shares, crypto, prizeBonds, plot, other },
	 *   goldWorn, goldKept, silverWorn, silverKept: { weight, unit: 'gram'|'tola'|'oz', karat },
	 *   liabilities: { debts, installments, bills, suppliers },
	 *   nisabBasis: optional 'gold'|'silver' override (only where the madhab allows it)
	 * }
	 * prices: { gold, silver } per gram, pure, in the user's currency.
	 */
	function calculate(madhabKey, input, prices) {
		var m = MADHABS[madhabKey];
		if (!m) throw new Error('Unknown madhab: ' + madhabKey);
		input = input || {};
		var nisab = nisabValues(prices);
		var lines = [];
		var notes = [];

		var money = sumFields(input.money, MONEY_FIELDS);
		var goldWornG = pureGoldGrams(input.goldWorn);
		var goldKeptG = pureGoldGrams(input.goldKept);
		var silverWornG = silverGrams(input.silverWorn);
		var silverKeptG = silverGrams(input.silverKept);
		var debts = sumFields(input.liabilities, DEBT_FIELDS);

		var goldWornV = goldWornG * prices.gold;
		var goldKeptV = goldKeptG * prices.gold;
		var silverWornV = silverWornG * prices.silver;
		var silverKeptV = silverKeptG * prices.silver;

		if (m.khums) {
			// Sistani R1915-1916: zakat on gold/silver applies only to minted coins used as currency,
			// which is not the case today; paper money and jewellery carry no zakat. Khums applies instead.
			var anything = money + goldWornV + goldKeptV + silverWornV + silverKeptV;
			lines.push({ key: 'money', value: money, included: false, why: 'jafari_money' });
			lines.push({ key: 'gold', value: goldWornV + goldKeptV, included: false, why: 'jafari_gold' });
			lines.push({ key: 'silver', value: silverWornV + silverKeptV, included: false, why: 'jafari_gold' });
			return {
				madhab: madhabKey, name: m.name, ref: m.ref, zakatable: 0, debtsDeducted: 0,
				nisab: nisab.gold, nisabBasis: 'coins', due: false, zakat: 0, lines: lines,
				notes: anything > 0 ? ['jafari_khums'] : [], khums: true,
			};
		}

		// Jewellery treatment.
		var goldWornIncluded = m.jewellery;
		var silverWornIncluded = m.jewellery;
		if (!m.jewellery && madhabKey === 'shafii' && goldWornG > SHAFII_JEWELLERY_LIMIT_G) {
			goldWornIncluded = true;
			notes.push('shafii_excess_jewellery');
		}

		var goldV = goldKeptV + (goldWornIncluded ? goldWornV : 0);
		var silverV = silverKeptV + (silverWornIncluded ? silverWornV : 0);
		var goldG = goldKeptG + (goldWornIncluded ? goldWornG : 0);
		var silverG = silverKeptG + (silverWornIncluded ? silverWornG : 0);

		lines.push({ key: 'money', value: money, included: true });
		if (goldKeptV) lines.push({ key: 'goldKept', value: goldKeptV, included: true });
		if (goldWornV) lines.push({ key: 'goldWorn', value: goldWornV, included: goldWornIncluded, why: goldWornIncluded ? 'jewellery_yes' : 'jewellery_no' });
		if (silverKeptV) lines.push({ key: 'silverKept', value: silverKeptV, included: true });
		if (silverWornV) lines.push({ key: 'silverWorn', value: silverWornV, included: silverWornIncluded, why: silverWornIncluded ? 'jewellery_yes' : 'jewellery_no' });
		if (debts) lines.push({ key: 'debts', value: -debts, included: m.debts, why: m.debts ? 'debts_yes' : 'debts_no' });

		// Nisab basis for mixed wealth.
		var basis = m.cashNisab;
		if (m.userNisab && (input.nisabBasis === 'gold' || input.nisabBasis === 'silver')) basis = input.nisabBasis;

		var result;
		if (m.combine) {
			var gross = money + goldV + silverV;
			var net = m.debts ? Math.max(0, gross - debts) : gross;
			var only;
			// Only one metal and nothing else: that metal's own nisab applies (by weight).
			if (money === 0 && silverV === 0 && goldV > 0) only = 'gold';
			else if (money === 0 && goldV === 0 && silverV > 0) only = 'silver';
			var nisabV, nisabBasis;
			if (only) {
				nisabBasis = only;
				nisabV = nisab[only];
				if (m.debts && debts > 0) notes.push('debts_vs_metal');
			} else {
				nisabBasis = basis === 'lower' ? (nisab.silver <= nisab.gold ? 'silver' : 'gold') : basis;
				nisabV = nisab[nisabBasis];
			}
			var due = net > 0 && net >= nisabV * (1 - 1e-9);
			result = {
				zakatable: net, debtsDeducted: m.debts ? Math.min(debts, gross) : 0,
				nisab: nisabV, nisabBasis: nisabBasis, due: due, zakat: due ? net * RATE : 0,
			};
		} else {
			// Shafi'i: gold and silver are separate classes. Cash and trade wealth are valued
			// against the chosen standard and joined with that metal. Debts are not deducted.
			var poolMetal = basis === 'silver' ? 'silver' : 'gold';
			var pool = money + (poolMetal === 'gold' ? goldV : silverV);
			var otherMetal = poolMetal === 'gold' ? 'silver' : 'gold';
			var otherV = poolMetal === 'gold' ? silverV : goldV;
			var otherG = poolMetal === 'gold' ? silverG : goldG;
			var otherNisabG = otherMetal === 'gold' ? GOLD_NISAB_G : SILVER_NISAB_G;
			var poolDue = pool > 0 && pool >= nisab[poolMetal] * (1 - 1e-9);
			var otherDue = otherG >= otherNisabG * (1 - 1e-9);
			var z = (poolDue ? pool * RATE : 0) + (otherDue ? otherV * RATE : 0);
			if (otherV > 0) notes.push('shafii_separate');
			result = {
				zakatable: (poolDue ? pool : 0) + (otherDue ? otherV : 0), debtsDeducted: 0,
				nisab: nisab[poolMetal], nisabBasis: poolMetal, due: poolDue || otherDue, zakat: z,
				gross: pool + otherV,
			};
		}

		if (num(input.money && input.money.receivablesDoubtful)) notes.push('doubtful_receivables');

		result.madhab = madhabKey;
		result.name = m.name;
		result.ref = m.ref;
		result.lines = lines;
		result.notes = notes;
		result.userNisab = m.userNisab;
		return result;
	}

	/** Same input under every madhab. */
	function compare(input, prices) {
		return MADHAB_ORDER.map(function (k) { return calculate(k, input, prices); });
	}

	/** Combine several family members' results (zakat is due on each person separately). */
	function family(results) {
		var total = 0;
		for (var i = 0; i < results.length; i++) total += results[i].zakat;
		return total;
	}

	function fitrana(persons, perPerson) {
		return Math.max(0, Math.floor(num(persons))) * num(perPerson);
	}

	/** Khums (Ja'fari): 20% of the year's surplus income still held at the khums date. */
	function khums(input) {
		var surplus = num(input.savings) + num(input.unusedItems) + num(input.tradeStock) - num(input.debts);
		surplus = Math.max(0, surplus);
		return { surplus: surplus, khums: surplus * 0.2, sahmImam: surplus * 0.1, sahmSadat: surplus * 0.1 };
	}

	/* ---------- Roman Urdu / English free-text parser ---------- */

	var MULT = [
		[/^(crore|karor|karore|cr)$/, 1e7],
		[/^(lakh|lac|lakhs|lacs|laakh|lakh?h)$/, 1e5],
		[/^(million|mn|m)$/, 1e6],
		[/^(hazar|hazaar|hazār|thousand|k)$/, 1e3],
	];
	var UNIT = [
		[/^(tola|tole|tolay|tolas|tolah)$/, 'tola'],
		[/^(gram|grams|gm|gms|g|gr|grm)$/, 'gram'],
		[/^(oz|ounce|ounces)$/, 'oz'],
		[/^(karat|carat|kt|ct)$/, 'karat'],
	];
	var KEYWORDS = [
		[/^(sona|sonay|sone|sonaa|gold|zevar|zewar|jewellery|jewelry|zaiwar)$/, 'gold'],
		[/^(chandi|chaandi|silver)$/, 'silver'],
		[/^(bank|account|savings|saving)$/, 'bank'],
		[/^(cash|naqd|naqdi|paise|paisay|paisa|rupay|rupees|rupee|rs|pkr|ghar)$/, 'cash'],
		[/^(qarz|qarza|karz|udhar|udhaar|loan|debt|debts|bill|bills)$/, 'debts'],
		[/^(business|karobar|kaarobar|dukan|stock|maal|inventory)$/, 'stock'],
		[/^(committee|commitee|bc|bisi|kameti)$/, 'committee'],
		[/^(shares|share|stocks|mutual)$/, 'shares'],
		[/^(crypto|bitcoin|btc)$/, 'crypto'],
		[/^(plot|plaat|property|zameen)$/, 'plot'],
		[/^(lena|lenay|receivable|receivables|wapsi)$/, 'receivables'],
		[/^(prize|bond|bonds)$/, 'prizeBonds'],
	];

	function match(table, word) {
		for (var i = 0; i < table.length; i++) if (table[i][0].test(word)) return table[i][1];
		return null;
	}

	/**
	 * "mere paas 3 tola sona, 5 lakh cash aur 2 lakh qarz hai"
	 * -> { gold: {weight:3, unit:'tola'}, cash: 500000, debts: 200000 }
	 */
	function parseText(text) {
		var out = {};
		if (!text) return out;
		var parts = String(text).toLowerCase()
			.replace(/(\d),(\d)/g, '$1$2')
			.replace(/(\d)([a-z])/g, '$1 $2')
			.split(/\s*(?:,|;|\+|\band\b|\baur\b|\bor\b|\bphir\b|\.\s)\s*/);
		for (var p = 0; p < parts.length; p++) {
			var words = parts[p].split(/[^a-z0-9.]+/).filter(Boolean);
			var amount = null, unit = null, karat = null, kind = null;
			for (var i = 0; i < words.length; i++) {
				var w = words[i];
				if (/^\d+(\.\d+)?$/.test(w)) {
					var n = parseFloat(w);
					var next = words[i + 1] || '';
					var mul = match(MULT, next);
					var u = match(UNIT, next);
					if (u === 'karat' || (next === 'k' && n <= 24 && amount !== null)) { karat = n; i++; continue; }
					if (mul) { n *= mul; i++; }
					else if (u) { unit = u; i++; }
					if (amount === null) amount = n;
					continue;
				}
				var k = match(KEYWORDS, w);
				if (k && !kind) kind = k;
			}
			if (amount === null || !kind) continue;
			if (kind === 'gold' || kind === 'silver') {
				out[kind] = { weight: amount, unit: unit || 'tola' };
				if (karat) out[kind].karat = karat;
			} else {
				out[kind] = (out[kind] || 0) + amount;
			}
		}
		return out;
	}

	/* ---------- Country defaults ---------- */

	// country: [currency, unit, madhab]
	var COUNTRIES = {
		PK: ['PKR', 'tola', 'hanafi'], IN: ['INR', 'gram', 'hanafi'], BD: ['BDT', 'gram', 'hanafi'],
		AF: ['AFN', 'gram', 'hanafi'], TR: ['TRY', 'gram', 'hanafi'], UZ: ['UZS', 'gram', 'hanafi'],
		ID: ['IDR', 'gram', 'shafii'], MY: ['MYR', 'gram', 'shafii'], BN: ['BND', 'gram', 'shafii'],
		SG: ['SGD', 'gram', 'shafii'], EG: ['EGP', 'gram', 'shafii'], SO: ['SOS', 'gram', 'shafii'],
		YE: ['YER', 'gram', 'shafii'], LK: ['LKR', 'gram', 'shafii'],
		MA: ['MAD', 'gram', 'maliki'], DZ: ['DZD', 'gram', 'maliki'], TN: ['TND', 'gram', 'maliki'],
		LY: ['LYD', 'gram', 'maliki'], NG: ['NGN', 'gram', 'maliki'], SN: ['XOF', 'gram', 'maliki'],
		ML: ['XOF', 'gram', 'maliki'], MR: ['MRU', 'gram', 'maliki'], SD: ['SDG', 'gram', 'maliki'],
		SA: ['SAR', 'gram', 'hanbali'], QA: ['QAR', 'gram', 'hanbali'], AE: ['AED', 'gram', 'hanbali'],
		KW: ['KWD', 'gram', 'hanbali'], BH: ['BHD', 'gram', 'hanbali'], OM: ['OMR', 'gram', 'hanbali'],
		JO: ['JOD', 'gram', 'hanafi'], IQ: ['IQD', 'gram', 'jafari'], IR: ['IRR', 'gram', 'jafari'],
		AZ: ['AZN', 'gram', 'jafari'], LB: ['LBP', 'gram', 'jafari'],
		GB: ['GBP', 'gram', 'hanafi'], US: ['USD', 'gram', 'hanafi'], CA: ['CAD', 'gram', 'hanafi'],
		AU: ['AUD', 'gram', 'hanafi'], NZ: ['NZD', 'gram', 'hanafi'], ZA: ['ZAR', 'gram', 'hanafi'],
		DE: ['EUR', 'gram', 'hanafi'], FR: ['EUR', 'gram', 'maliki'], NL: ['EUR', 'gram', 'hanafi'],
		BE: ['EUR', 'gram', 'maliki'], IT: ['EUR', 'gram', 'hanafi'], ES: ['EUR', 'gram', 'maliki'],
		IE: ['EUR', 'gram', 'hanafi'], SE: ['SEK', 'gram', 'hanafi'], NO: ['NOK', 'gram', 'hanafi'],
		DK: ['DKK', 'gram', 'hanafi'], CH: ['CHF', 'gram', 'hanafi'], KE: ['KES', 'gram', 'shafii'],
		TZ: ['TZS', 'gram', 'shafii'], NP: ['NPR', 'gram', 'hanafi'], MV: ['MVR', 'gram', 'shafii'],
	};

	function countryDefaults(cc) {
		var c = COUNTRIES[String(cc || '').toUpperCase()];
		return c ? { currency: c[0], unit: c[1], madhab: c[2] } : { currency: 'USD', unit: 'gram', madhab: 'hanafi' };
	}

	return {
		GRAMS_PER_TOLA: GRAMS_PER_TOLA, GRAMS_PER_OZ: GRAMS_PER_OZ,
		GOLD_NISAB_G: GOLD_NISAB_G, SILVER_NISAB_G: SILVER_NISAB_G, RATE: RATE,
		MADHABS: MADHABS, MADHAB_ORDER: MADHAB_ORDER, COUNTRIES: COUNTRIES,
		toGrams: toGrams, perGram: perGram, nisabValues: nisabValues,
		calculate: calculate, compare: compare, family: family, fitrana: fitrana, khums: khums,
		parseText: parseText, countryDefaults: countryDefaults,
	};
});
