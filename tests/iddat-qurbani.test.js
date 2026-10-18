// Run: node --test tests/iddat-qurbani.test.js
// Iddat dates follow the Quran's counts (2:234, 2:228, 65:4, 33:49) and each madhab's reading of quru'.
const test = require('node:test');
const assert = require('node:assert/strict');
const E = require('../assets/js/engine.js');

// 12 Oct 2026 is 1 Jumada al-Ula 1448 (Umm al-Qura); 18 Oct 2026 is the 7th.
const FIRST = '2026-10-12';
const MID = '2026-10-18';

test('Hijri calendar is available', () => {
	assert.deepEqual(E.hijriParts(FIRST), { day: 1, month: 5, year: 1448 });
});

test('widow: 130 days unless the death was on the 1st of an Islamic month', () => {
	const r = E.iddat({ madhab: 'hanafi', kind: 'death', start: MID });
	assert.equal(r.end, '2027-02-25');
	assert.equal(r.days, 130);
	assert.equal(r.basis, 'days');
	const m = E.iddat({ madhab: 'shafii', kind: 'death', start: FIRST });
	assert.equal(m.basis, 'moon');
	assert.deepEqual(E.hijriParts(m.end), { day: 11, month: 9, year: 1448 }); // 1 Ramadan + 10 days
	assert.equal(r.law, null);
});

test('widow keeps iddat without consummation; pregnancy ends it at birth, Ja\'fari waits for the later date', () => {
	assert.equal(E.iddat({ madhab: 'hanafi', kind: 'death', start: MID, consummated: false }).days, 130);
	const s = E.iddat({ madhab: 'hanafi', kind: 'death', start: MID, pregnant: true });
	assert.equal(s.byBirth, true);
	assert.equal(s.end, null);
	const j = E.iddat({ madhab: 'jafari', kind: 'death', start: MID, pregnant: true });
	assert.equal(j.byBirth, true);
	assert.equal(j.end, '2027-02-25');
	assert.ok(j.notes.includes('jafari_later'));
});

const cycle = { consummated: true, periods: 'regular', lastPeriod: '2026-10-05', cycle: 28, length: 6 };

test('talaq: three periods (Hanafi, Hanbali, Ahl-e-Hadith) end a period later than three purities (Shafi\'i, Maliki, Ja\'fari)', () => {
	// Periods begin 5 Oct, 2 Nov, 30 Nov, 28 Dec; the talaq on 18 Oct falls in a time of purity.
	for (const mz of ['hanafi', 'hanbali', 'ahlehadith']) {
		const r = E.iddat({ madhab: mz, kind: 'talaq', start: MID, ...cycle });
		assert.equal(r.end, '2027-01-03', mz);
		assert.equal(r.basis, 'haiz');
	}
	for (const mz of ['shafii', 'maliki', 'jafari']) {
		const r = E.iddat({ madhab: mz, kind: 'talaq', start: MID, ...cycle });
		assert.equal(r.end, '2026-12-28', mz);
		assert.equal(r.basis, 'tuhr');
	}
});

test('talaq during a period: that period is not counted', () => {
	const r = E.iddat({ madhab: 'hanafi', kind: 'talaq', start: '2026-11-03', ...cycle });
	assert.ok(r.notes.includes('in_period'));
	assert.equal(r.end, '2027-01-31'); // periods of 30 Nov, 28 Dec and 25 Jan, each 6 days
});

test('khula: one period for Ahl-e-Hadith, three for the others', () => {
	const a = E.iddat({ madhab: 'ahlehadith', kind: 'khula', start: MID, ...cycle });
	assert.equal(a.end, '2026-11-08');
	assert.ok(a.notes.includes('khula_one'));
	assert.equal(E.iddat({ madhab: 'hanafi', kind: 'khula', start: MID, ...cycle }).end, '2027-01-03');
	assert.ok(E.iddat({ madhab: 'hanbali', kind: 'khula', start: MID, ...cycle }).notes.includes('khula_hanbali'));
});

test('no periods: three months (90 days off the 1st); Ja\'fari menopause has none', () => {
	assert.equal(E.iddat({ madhab: 'hanafi', kind: 'talaq', start: MID, consummated: true, periods: 'none' }).days, 90);
	assert.equal(E.iddat({ madhab: 'maliki', kind: 'talaq', start: FIRST, consummated: true, periods: 'menopause' }).basis, 'moon');
	assert.equal(E.iddat({ madhab: 'jafari', kind: 'talaq', start: MID, consummated: true, periods: 'menopause' }).none, true);
	assert.equal(E.iddat({ madhab: 'jafari', kind: 'talaq', start: MID, consummated: true, periods: 'none' }).days, 90);
});

test('talaq before consummation: no iddat; pregnancy: until birth; Pakistan law date is 90 days', () => {
	const u = E.iddat({ madhab: 'shafii', kind: 'talaq', start: MID, consummated: false });
	assert.equal(u.none, true);
	assert.ok(u.notes.includes('unconsummated'));
	assert.ok(E.iddat({ madhab: 'hanafi', kind: 'talaq', start: MID, consummated: false }).notes.includes('khalwa'));
	const p = E.iddat({ madhab: 'hanafi', kind: 'talaq', start: MID, consummated: true, pregnant: true });
	assert.equal(p.byBirth, true);
	assert.equal(p.law, '2027-01-16');
});

test('missing dates do not invent an answer', () => {
	assert.equal(E.iddat({ madhab: 'hanafi', kind: 'death', start: '' }).end, null);
	const r = E.iddat({ madhab: 'hanafi', kind: 'talaq', start: MID, consummated: true, periods: 'regular' });
	assert.equal(r.needPeriod, true);
	assert.equal(r.end, null);
	// A last period after the talaq is not accepted.
	assert.equal(E.iddat({ madhab: 'hanafi', kind: 'talaq', start: MID, ...cycle, lastPeriod: '2026-10-20' }).needPeriod, true);
});

// Qurbani: Rs 4,500 per tola of silver gives a silver nisab of Rs 2,36,250.
const prices = { gold: 385000 / E.GRAMS_PER_TOLA, silver: 4500 / E.GRAMS_PER_TOLA };

test('qurbani: silver nisab for mixed wealth, no waiting year', () => {
	const r = E.qurbani({ money: { cash: 100000 }, goldKept: { weight: 1, unit: 'tola', karat: 22 } }, prices);
	assert.equal(Math.round(r.nisab), 236250);
	assert.equal(r.nisabBasis, 'silver');
	assert.equal(r.wajib, true);
});

test('qurbani: spare things count, debts are deducted', () => {
	assert.equal(E.qurbani({ money: { other: 300000 } }, prices).wajib, true);
	assert.equal(E.qurbani({ money: { other: 300000 }, liabilities: { debts: 100000 } }, prices).wajib, false);
});

test('qurbani: gold alone uses the 7.5 tola gold nisab', () => {
	const r = E.qurbani({ goldKept: { weight: 5, unit: 'tola', karat: 24 } }, prices);
	assert.equal(r.nisabBasis, 'gold');
	assert.equal(r.wajib, false);
});
