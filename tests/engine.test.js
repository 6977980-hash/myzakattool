// Run: node --test tests/
const test = require('node:test');
const assert = require('node:assert/strict');
const E = require('../assets/js/engine.js');

// Sample prices: Rs 3,85,000 per tola of 24K gold, Rs 4,500 per tola of silver.
const prices = { gold: 385000 / E.GRAMS_PER_TOLA, silver: 4500 / E.GRAMS_PER_TOLA };

const sample = {
	money: { cash: 150000, bank: 350000 },
	goldWorn: { weight: 3, unit: 'tola', karat: 22 },
	liabilities: { debts: 100000 },
};

const round = (n) => Math.round(n);

test('Hanafi: worn jewellery included, debts deducted, silver nisab', () => {
	const r = E.calculate('hanafi', sample, prices);
	assert.equal(r.nisabBasis, 'silver');
	assert.equal(round(r.zakatable), 1458750);
	assert.equal(round(r.zakat), 36469);
	assert.equal(r.due, true);
});

test("Shafi'i: jewellery exempt, debts not deducted, gold nisab -> below nisab", () => {
	const r = E.calculate('shafii', sample, prices);
	assert.equal(r.nisabBasis, 'gold');
	assert.equal(r.due, false);
	assert.equal(r.zakat, 0);
});

test("Shafi'i with silver basis chosen by user", () => {
	const r = E.calculate('shafii', { ...sample, nisabBasis: 'silver' }, prices);
	assert.equal(round(r.zakat), 12500); // 5,00,000 x 2.5%, no debt deduction
});

test('Maliki and Hanbali: jewellery exempt, debts deducted', () => {
	assert.equal(round(E.calculate('maliki', sample, prices).zakat), 10000);
	assert.equal(round(E.calculate('hanbali', sample, prices).zakat), 10000);
});

test('Ahl-e-Hadith: jewellery included, lower nisab', () => {
	assert.equal(round(E.calculate('ahlehadith', sample, prices).zakat), 36469);
});

test("Ja'fari (Sistani): no zakat on paper money or jewellery, khums note", () => {
	const r = E.calculate('jafari', sample, prices);
	assert.equal(r.zakat, 0);
	assert.equal(r.khums, true);
	assert.deepEqual(r.notes, ['jafari_khums']);
});

test('Hanafi: only gold below 7.5 tola is not zakatable (gold nisab applies)', () => {
	const r = E.calculate('hanafi', { goldKept: { weight: 7, unit: 'tola', karat: 24 } }, prices);
	assert.equal(r.nisabBasis, 'gold');
	assert.equal(r.due, false);
});

test('Hanafi: only gold of 7.5 tola 24K is zakatable', () => {
	const r = E.calculate('hanafi', { goldKept: { weight: 7.5, unit: 'tola', karat: 24 } }, prices);
	assert.equal(r.due, true);
	assert.ok(Math.abs(r.zakat - 7.5 * 385000 * 0.025) < 0.01);
});

test('Hanafi: small gold plus small cash combine on silver nisab (Deoband 702)', () => {
	const r = E.calculate('hanafi', { money: { cash: 50000 }, goldKept: { weight: 15, unit: 'gram', karat: 24 } }, prices);
	assert.equal(r.nisabBasis, 'silver');
	assert.equal(r.due, true);
});

test("Shafi'i: worn gold above 860 g becomes zakatable", () => {
	const r = E.calculate('shafii', { goldWorn: { weight: 900, unit: 'gram', karat: 24 } }, prices);
	assert.ok(r.notes.includes('shafii_excess_jewellery'));
	assert.equal(r.due, true);
});

test('Debts larger than wealth give zero, not negative', () => {
	const r = E.calculate('hanafi', { money: { cash: 1000 }, liabilities: { debts: 5000 } }, prices);
	assert.equal(r.zakatable, 0);
	assert.equal(r.zakat, 0);
});

test('compare returns all six madhabs in order', () => {
	assert.deepEqual(E.compare(sample, prices).map((r) => r.madhab), E.MADHAB_ORDER);
});

test('perGram converts USD/oz with fx', () => {
	const p = E.perGram({ goldUsdOz: 3110.34768, silverUsdOz: 31.1034768, fx: 2 });
	assert.ok(Math.abs(p.gold - 200) < 1e-9);
	assert.ok(Math.abs(p.silver - 2) < 1e-9);
});

test('Roman Urdu parser', () => {
	assert.deepEqual(E.parseText('mere paas 3 tola sona aur 5 lakh hai cash'), {
		gold: { weight: 3, unit: 'tola' }, cash: 500000,
	});
	const r = E.parseText('5 tola 22k sona, 2 lakh bank, 50k cash aur 1.5 lakh qarz');
	assert.deepEqual(r.gold, { weight: 5, unit: 'tola', karat: 22 });
	assert.equal(r.bank, 200000);
	assert.equal(r.cash, 50000);
	assert.equal(r.debts, 150000);
	assert.deepEqual(E.parseText('100 gram chandi + 1 crore business'), {
		silver: { weight: 100, unit: 'gram' }, stock: 10000000,
	});
	assert.equal(E.parseText('committee mein 60,000').committee, 60000);
});

test('fitrana and khums', () => {
	assert.equal(E.fitrana(5, 300), 1500);
	assert.equal(E.khums({ savings: 100000, unusedItems: 20000 }).khums, 24000);
});

test('country defaults', () => {
	assert.deepEqual(E.countryDefaults('pk'), { currency: 'PKR', unit: 'tola', madhab: 'hanafi' });
	assert.equal(E.countryDefaults('ID').madhab, 'shafii');
	assert.equal(E.countryDefaults('XX').currency, 'USD');
});

test('zakat already paid (bank deduction) reduces what is left to pay', () => {
	const input = { money: { bank: 800000, savingsCerts: 200000 }, liabilities: { bankDeducted: 20000 } };
	const r = E.calculate('hanafi', input, prices);
	assert.equal(round(r.zakat), 25000);
	assert.equal(r.paid, 20000);
	assert.equal(round(r.payable), 5000);
	// Paid more than owed: nothing left, never negative.
	const over = E.calculate('hanafi', { money: { bank: 400000 }, liabilities: { paidAlready: 50000 } }, prices);
	assert.equal(over.payable, 0);
	assert.equal(over.paid, over.zakat);
	// Ja'fari: zakat 0, so nothing is payable.
	assert.equal(E.calculate('jafari', input, prices).payable, 0);
	// Family total sums what is left to pay.
	assert.equal(round(E.family([r, E.calculate('hanafi', { money: { bank: 400000 } }, prices)])), 15000);
	assert.equal(E.parseText('2 lakh behbood').savingsCerts, 200000);
});

test('hawl dates and missed years', () => {
	assert.deepEqual(E.hawlDates('2025-03-01', 2), ['2026-02-18', '2027-02-08']);
	assert.equal(E.hawlYearsBetween('2023-01-01', '2026-01-01'), 3);
	const m = E.missedZakat([500000, 500000], 100000, true);
	assert.equal(m.rows[0].zakat, 12500);
	assert.equal(m.rows[1].zakat, (500000 - 12500) * 0.025);
	assert.equal(E.missedZakat([500000, 500000], 100000, false).total, 25000);
	assert.equal(E.missedZakat([50000], 100000, false).total, 0);
});

test('ushr and livestock', () => {
	assert.deepEqual(E.ushr('hanafi', 400, 100, 'rain'), { rate: 0.1, nisabKg: 0, due: true, kg: 40, value: 4000 });
	assert.equal(E.ushr('shafii', 400, 100, 'rain').due, false);
	assert.equal(E.ushr('maliki', 1000, 100, 'irrigated').kg, 50);
	assert.deepEqual(E.livestock('sheep', 39), []);
	assert.deepEqual(E.livestock('sheep', 121), [{ n: 2, what: 'sheep' }]);
	assert.deepEqual(E.livestock('sheep', 450), [{ n: 4, what: 'sheep' }]);
	assert.deepEqual(E.livestock('cows', 30), [{ n: 1, what: 'tabi' }]);
	assert.deepEqual(E.livestock('cows', 70), [{ n: 1, what: 'tabi' }, { n: 1, what: 'musinnah' }]);
	assert.deepEqual(E.livestock('cows', 120), [{ n: 3, what: 'musinnah' }]);
	assert.deepEqual(E.livestock('camels', 12), [{ n: 2, what: 'sheep' }]);
	assert.deepEqual(E.livestock('camels', 50), [{ n: 1, what: 'hiqqa' }]);
});
