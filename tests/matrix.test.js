// Independent test matrix (audit 16 Oct 2026, FIX-062). Run: node --test tests/matrix.test.js
// Expected values are worked out here by hand formulas, not by calling the engine, so a change
// to engine.js that moves any result fails one of these rows.
// Rows marked METHOD encode a methodology choice that may change after scholar review (Phase 4):
// update the expected value in the same PR that changes the rule.
const test = require('node:test');
const assert = require('node:assert/strict');
const E = require('../assets/js/engine.js');

// Rate snapshot from the live REST payload, 16 Oct 2026 21:40 UTC.
const GOLD_USD_OZ = 4166.100098, SILVER_USD_OZ = 57.116001, PKR = 277.33821319;
const OZ = 31.1034768, TOLA = 11.6638038;
const goldG = GOLD_USD_OZ * PKR / OZ, silverG = SILVER_USD_OZ * PKR / OZ;
const P = { gold: goldG, silver: silverG };
const nisabGold = 7.5 * TOLA * goldG, nisabSilver = 52.5 * TOLA * silverG;

function check(madhab, input, expected, prices = P) {
	const r = E.calculate(madhab, input, prices);
	assert.ok(Math.abs(r.payable - expected) < 0.01, `${madhab}: expected ${expected.toFixed(2)}, got ${r.payable}`);
	return r;
}

test('constants match the published nisab', () => {
	assert.equal(E.GRAMS_PER_TOLA, TOLA);
	assert.equal(E.GRAMS_PER_OZ, OZ);
	assert.ok(Math.abs(nisabSilver - 311858.85) < 0.01);
	assert.ok(Math.abs(nisabGold - 3249615.25) < 0.01);
});

test('T01 empty input gives zero in every madhab', () => {
	for (const m of E.MADHAB_ORDER) check(m, {}, 0);
});

test('T02-T04 silver nisab boundary (Hanafi)', () => {
	check('hanafi', { money: { cash: nisabSilver - 1 } }, 0);
	check('hanafi', { money: { cash: nisabSilver } }, nisabSilver * 0.025);
	check('hanafi', { money: { cash: nisabSilver + 1 } }, (nisabSilver + 1) * 0.025);
});

test('T05 gold only, by purity and unit (Hanafi; METHOD: nisab by pure-gold weight, FIX-018)', () => {
	for (const k of [24, 22, 21, 18]) {
		const pure = 7.5 * TOLA * k / 24;
		const exp = pure >= 7.5 * TOLA - 1e-9 ? pure * goldG * 0.025 : 0;
		check('hanafi', { goldKept: { weight: 7.5, unit: 'tola', karat: k } }, exp);
	}
	check('hanafi', { goldKept: { weight: 100, unit: 'gram', karat: 18 } }, 0); // 75 g pure < 87.48 g
	check('hanafi', { goldKept: { weight: 3, unit: 'oz', karat: 24 } }, 3 * OZ * goldG * 0.025);
});

test('T06 gold and silver together', () => {
	const input = { goldKept: { weight: 2, unit: 'tola', karat: 22 }, silverKept: { weight: 10, unit: 'tola' } };
	const g = 2 * TOLA * goldG * 22 / 24, s = 10 * TOLA * silverG;
	check('hanafi', input, g + s >= nisabSilver ? (g + s) * 0.025 : 0);
	check('shafii', input, 0); // separate classes, each below its own nisab
	check('jafari', input, 0); // Sistani: only minted coins in circulation
});

test('T07 worn gold plus cash', () => {
	const input = { goldWorn: { weight: 1, unit: 'tola', karat: 22 }, money: { cash: 10000 } };
	const g = TOLA * goldG * 22 / 24;
	check('hanafi', input, g + 10000 >= nisabSilver ? (g + 10000) * 0.025 : 0);
	check('maliki', input, 10000 >= nisabSilver ? 250 : 0); // worn jewellery exempt
});

test('T08 cash, bank and stock', () => {
	check('hanafi', { money: { cash: 50000, bank: 300000, stock: 400000 } }, 750000 * 0.025);
});

test('T09 debts per madhab', () => {
	const liab = { debts: 3e5, installments: 1e5, bills: 2e4, suppliers: 3e4 };
	check('hanafi', { money: { cash: 1e6 }, liabilities: liab }, 550000 * 0.025);
	check('shafii', { money: { cash: 1e6 }, liabilities: liab }, 1e6 >= nisabGold ? 1e6 * 0.025 : 0);
	check('ahlehadith', { money: { cash: 1e6 }, liabilities: { debts: 3e5 } }, 1e6 * 0.025);
	check('hanafi', { money: { cash: 2e5 }, liabilities: { debts: 5e5 } }, 0);
});

test('T10 already paid never goes negative', () => {
	const base = { money: { cash: 1e6 } };
	check('hanafi', { ...base, liabilities: { paidAlready: 25000 } }, 0);
	check('hanafi', { ...base, liabilities: { bankDeducted: 10000 } }, 15000);
	check('hanafi', { ...base, liabilities: { bankDeducted: 20000, paidAlready: 20000 } }, 0);
	check('hanafi', { money: { cash: 1000 }, liabilities: { bankDeducted: 500 } }, 0);
});

test('T11-T15 receivables, plot, committee, certificates, shares', () => {
	check('hanafi', { money: { cash: 1e5, receivables: 2e5, receivablesDoubtful: 3e5 } }, 3e5 >= nisabSilver ? 3e5 * 0.025 : 0);
	check('hanafi', { money: { plot: 5e6 } }, 5e6 * 0.025);
	check('hanafi', { money: { committee: 1.2e5, cash: 1e5 } }, 2.2e5 >= nisabSilver ? 2.2e5 * 0.025 : 0);
	check('hanafi', { money: { savingsCerts: 5e5, prizeBonds: 1e5 } }, 6e5 * 0.025);
	check('hanafi', { money: { shares: 4e5, crypto: 1e5 } }, 5e5 * 0.025);
});

test('T16 currency conversion and own rate', () => {
	const PU = { gold: GOLD_USD_OZ / OZ, silver: SILVER_USD_OZ / OZ };
	check('hanafi', { money: { cash: 1000 } }, 1000 >= 52.5 * TOLA * PU.silver ? 25 : 0, PU);
	const pg = E.perGram({ goldUsdOz: GOLD_USD_OZ, silverUsdOz: SILVER_USD_OZ, fx: PKR });
	assert.ok(Math.abs(pg.gold - goldG) < 1e-6);
	assert.ok(Math.abs(pg.silver - silverG) < 1e-6);
	check('hanafi', { money: { cash: 100000 } }, 100000 >= 52.5 * TOLA * 300 ? 2500 : 0, { gold: 30000, silver: 300 });
});

test('T17 large values and strings', () => {
	check('hanafi', { money: { cash: 999999999999 } }, 999999999999 * 0.025);
	check('hanafi', { money: { cash: '1,00,000' } }, 0);
});

test('T18 same input across all six madhabs', () => {
	const sample = { money: { cash: 150000, bank: 350000 }, goldWorn: { weight: 3, unit: 'tola', karat: 22 }, liabilities: { debts: 100000 } };
	const gw = 3 * TOLA * 22 / 24 * goldG, money = 500000;
	const exp = {
		hanafi: (money + gw - 1e5) * 0.025,
		shafii: money >= nisabGold ? money * 0.025 : 0,
		maliki: money - 1e5 >= nisabSilver ? (money - 1e5) * 0.025 : 0,
		hanbali: money - 1e5 >= Math.min(nisabSilver, nisabGold) ? (money - 1e5) * 0.025 : 0,
		ahlehadith: (money + gw) * 0.025,
		jafari: 0,
	};
	assert.deepEqual([...E.MADHAB_ORDER].sort(), Object.keys(exp).sort());
	for (const m of E.MADHAB_ORDER) check(m, sample, exp[m]);
	check('shafii', { goldWorn: { weight: 900, unit: 'gram', karat: 22 } }, 900 * 22 / 24 * goldG * 0.025);
});

test('T21 invalid values reaching the engine', () => {
	check('hanafi', { money: { cash: -500000, bank: 600000 } }, 600000 * 0.025); // negatives count as 0
	check('hanafi', { money: { cash: 'abc' } }, 0);
	// METHOD/FIX-009: karat 0 is treated as 24K today; update when invalid karat becomes an error.
	check('hanafi', { goldKept: { weight: 10, unit: 'tola', karat: 0 } }, 10 * TOLA * goldG * 0.025);
});

test('T22 Hanbali with gold only uses the gold nisab by weight', () => {
	check('hanbali', { goldKept: { weight: 5, unit: 'tola', karat: 24 } }, 0);
});

test('Side tools: fitrana, fidya, kaffara, khums, family', () => {
	assert.equal(E.fitrana(2.7, 300), 600);
	assert.equal(E.fidya(30, 300), 9000);
	assert.equal(E.kaffara(1, 300), 18000); // 60 poor people
	assert.equal(E.kaffara(3, 300), 54000);
	assert.deepEqual(E.khums({ savings: 100000, unusedItems: 20000, tradeStock: 0, debts: 50000 }), { surplus: 70000, khums: 14000, sahmImam: 7000, sahmSadat: 7000 });
	assert.equal(E.family([{ payable: 100 }, { payable: 50.5 }]), 150.5);
});

test('Ushr rates and crop nisab', () => {
	assert.deepEqual(E.ushr('hanafi', 100, 100, 'rain'), { rate: 0.1, nisabKg: 0, due: true, kg: 10, value: 1000 });
	assert.equal(E.ushr('shafii', 652, 100, 'irrigated').due, false);
	const mixed = E.ushr('shafii', 653, 100, 'mixed');
	assert.equal(mixed.rate, 0.075);
	assert.ok(Math.abs(mixed.value - 4897.5) < 1e-9);
	assert.equal(E.ushr('jafari', 846, 1, 'rain').due, false);
});

test('Livestock table boundaries', () => {
	const l = (t, c) => E.livestock(t, c).map((x) => x.n + ' ' + x.what).join(', ');
	const cases = [
		['sheep', 39, ''], ['sheep', 40, '1 sheep'], ['sheep', 121, '2 sheep'], ['sheep', 201, '3 sheep'], ['sheep', 399, '3 sheep'], ['sheep', 400, '4 sheep'], ['sheep', 550, '5 sheep'],
		['cows', 29, ''], ['cows', 30, '1 tabi'], ['cows', 40, '1 musinnah'], ['cows', 59, '1 musinnah'], ['cows', 60, '2 tabi'], ['cows', 70, '1 tabi, 1 musinnah'], ['cows', 120, '3 musinnah'],
		['camels', 4, ''], ['camels', 5, '1 sheep'], ['camels', 24, '4 sheep'], ['camels', 25, '1 bintMakhad'], ['camels', 36, '1 bintLabun'], ['camels', 46, '1 hiqqa'], ['camels', 61, '1 jadha'], ['camels', 76, '2 bintLabun'], ['camels', 91, '2 hiqqa'],
	];
	for (const [t, c, exp] of cases) assert.equal(l(t, c), exp, `${t} ${c}`);
});

test('Missed years: with and without subtracting earlier zakat', () => {
	const sub = E.missedZakat([1e6, 1e6, 1e6], 150000, true);
	assert.deepEqual(sub.rows.map((r) => r.zakat), [25000, 24375, 23765.625]);
	assert.equal(sub.total, 73140.625);
	assert.equal(E.missedZakat([1e6, 1e6, 1e6], 150000, false).total, 75000);
	assert.equal(E.missedZakat([160000, 160000], 150000, true).total, 7900);
});

test('Hawl dates follow the lunar year', () => {
	assert.deepEqual(E.hawlDates('2025-03-01', 3), ['2026-02-18', '2027-02-08', '2028-01-28']);
	assert.equal(E.hawlYearsBetween('2020-01-01', '2026-10-16'), 6);
});
