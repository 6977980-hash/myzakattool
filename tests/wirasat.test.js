// Inheritance engine against worked examples from the books of fara'id and published fatwas.
// Run: node --test tests/wirasat.test.js
const test = require('node:test');
const assert = require('node:assert/strict');
const W = require('../assets/js/wirasat.js');

let seq = 0;
function fam(spec) {
	// spec: [['wife'], ['son', 2], ['grandson', 1, 'before-son'], ...]
	const out = [];
	const named = {};
	const count = {};
	for (const [rel, n = 1, opt = ''] of spec) {
		for (let i = 0; i < n; i++) {
			const p = { id: rel + (++seq), rel, status: 'alive' };
			const [status, parentKey] = opt.split('@');
			if (status) p.status = status;
			if (parentKey) p.parent = named[parentKey];
			out.push(p);
			count[rel] = (count[rel] || 0) + 1;
			named[rel] = named[rel] || p.id;
			named[rel + count[rel]] = p.id;
		}
	}
	return out;
}
function shares(people, madhab, sex, sec4) {
	const r = W.calculate(people, { madhab, deceasedSex: sex, sec4 });
	const out = {};
	for (const p of people) {
		const f = r.shares[p.id].f;
		if (f.n) out[p.rel] = (out[p.rel] ? out[p.rel] + ' ' : '') + f.n + '/' + f.d;
	}
	assert.equal(W.val(r.total), 1, 'shares add up to one: ' + JSON.stringify(out));
	return { s: out, r };
}
const SUNNI = ['hanafi', 'shafii', 'maliki', 'hanbali', 'ahlehadith'];

test('wife, son and daughter: 1/8, rest 2:1 (every madhab)', () => {
	for (const m of SUNNI.concat('jafari')) {
		const { s } = shares(fam([['wife'], ['son'], ['daughter']]), m, 'm');
		assert.deepEqual(s, { wife: '1/8', son: '7/12', daughter: '7/24' }, m);
	}
});

test('al-Umariyyatan: the mother takes a third of what is left after the spouse', () => {
	assert.deepEqual(shares(fam([['husband'], ['mother'], ['father']]), 'hanafi', 'f').s, { husband: '1/2', mother: '1/6', father: '1/3' });
	assert.deepEqual(shares(fam([['wife'], ['mother'], ['father']]), 'shafii', 'm').s, { wife: '1/4', mother: '1/4', father: '1/2' });
	// Ja'fari: the mother takes a third of the whole.
	assert.deepEqual(shares(fam([['husband'], ['mother'], ['father']]), 'jafari', 'f').s, { husband: '1/2', mother: '1/3', father: '1/6' });
});

test("'awl: husband and two full sisters (6 becomes 7)", () => {
	const { s, r } = shares(fam([['husband'], ['sister', 2]]), 'hanafi', 'f');
	assert.deepEqual(s, { husband: '3/7', sister: '2/7 2/7' });
	assert.equal(r.awl, true);
});

test("'awl: wife, two daughters, father and mother (24 becomes 27, al-Minbariyya)", () => {
	const { s } = shares(fam([['wife'], ['daughter', 2], ['father'], ['mother']]), 'hanafi', 'm');
	assert.deepEqual(s, { wife: '1/9', daughter: '8/27 8/27', father: '4/27', mother: '4/27' });
});

test('al-Mushtaraka: Hanafi gives full brothers nothing; Shafi\'i lets them share the third', () => {
	const people = fam([['husband'], ['mother'], ['mbrother', 2], ['brother']]);
	assert.deepEqual(shares(people, 'hanafi', 'f').s, { husband: '1/2', mother: '1/6', mbrother: '1/6 1/6' });
	assert.deepEqual(shares(people, 'shafii', 'f').s, { husband: '1/2', mother: '1/6', mbrother: '1/9 1/9', brother: '1/9' });
});

test('sister with a daughter takes the rest (asaba ma\'al ghayr)', () => {
	assert.deepEqual(shares(fam([['daughter'], ['sister']]), 'hanafi', 'm').s, { daughter: '1/2', sister: '1/2' });
	const p = fam([['daughter'], ['son', 1, 'before'], ['granddaughter', 1, '@son'], ['sister']]);
	assert.deepEqual(shares(p, 'hanafi', 'm').s, { daughter: '1/2', granddaughter: '1/6', sister: '1/3' });
});

test('radd: two daughters and mother (Hanafi) and the spouse gets no radd', () => {
	assert.deepEqual(shares(fam([['daughter', 2], ['mother']]), 'hanafi', 'm').s, { daughter: '2/5 2/5', mother: '1/5' });
	const { s } = shares(fam([['wife'], ['daughter']]), 'hanafi', 'm');
	assert.deepEqual(s, { wife: '1/8', daughter: '7/8' });
});

test('mother 1/6 with two siblings even when the father blocks them', () => {
	assert.deepEqual(shares(fam([['father'], ['mother'], ['brother', 2]]), 'hanafi', 'm').s, { father: '5/6', mother: '1/6' });
});

test('grandmothers share 1/6; Hanbali lets the paternal grandmother inherit with the father', () => {
	assert.deepEqual(shares(fam([['dadi'], ['nani'], ['son']]), 'hanafi', 'm').s, { dadi: '1/12', nani: '1/12', son: '5/6' });
	assert.deepEqual(shares(fam([['father'], ['dadi'], ['nani'], ['son']]), 'hanafi', 'm').s, { father: '1/6', nani: '1/6', son: '2/3' });
	assert.deepEqual(shares(fam([['father'], ['dadi'], ['nani'], ['son']]), 'hanbali', 'm').s, { father: '1/6', dadi: '1/12', nani: '1/12', son: '2/3' });
});

test('grandfather and brothers: Hanafi and Ahl-e-Hadith block them, the others share (Zayd)', () => {
	const p = fam([['dada'], ['brother']]);
	assert.deepEqual(shares(p, 'hanafi', 'm').s, { dada: '1/1' });
	assert.deepEqual(shares(p, 'ahlehadith', 'm').s, { dada: '1/1' });
	assert.deepEqual(shares(p, 'shafii', 'm').s, { dada: '1/2', brother: '1/2' });
	// Grandfather with 4 brothers: a third is better than a fifth.
	assert.deepEqual(shares(fam([['dada'], ['brother', 4]]), 'maliki', 'm').s, { dada: '1/3', brother: '1/6 1/6 1/6 1/6' });
	// With a sharer: wife 1/4, grandfather the best of 1/6, a third of the rest, or an equal share.
	assert.deepEqual(shares(fam([['wife'], ['dada'], ['brother']]), 'hanbali', 'm').s, { wife: '1/4', dada: '3/8', brother: '3/8' });
});

test('al-Akdariyya (Shafi\'i, Maliki, Hanbali)', () => {
	const { s } = shares(fam([['husband'], ['mother'], ['dada'], ['sister']]), 'shafii', 'f');
	assert.deepEqual(s, { husband: '1/3', mother: '2/9', dada: '8/27', sister: '4/27' });
});

test('consanguine sister gets 1/6 next to one full sister; blocked by two', () => {
	assert.deepEqual(shares(fam([['sister'], ['psister'], ['chacha']]), 'hanafi', 'm').s, { sister: '1/2', psister: '1/6', chacha: '1/3' });
	assert.deepEqual(shares(fam([['sister', 2], ['psister'], ['chacha']]), 'hanafi', 'm').s, { sister: '1/3 1/3', chacha: '1/3' });
});

test('uterine siblings: 1/6 alone, 1/3 shared equally, blocked by a daughter', () => {
	assert.deepEqual(shares(fam([['mbrother'], ['msister'], ['brother']]), 'hanafi', 'm').s, { mbrother: '1/6', msister: '1/6', brother: '2/3' });
	assert.deepEqual(shares(fam([['mbrother'], ['daughter'], ['brother']]), 'hanafi', 'm').s, { daughter: '1/2', brother: '1/2' });
});

test('distant residuaries: brother\'s son, then uncle, then cousin', () => {
	const p = fam([['wife'], ['brother', 1, 'before'], ['nephew', 1, '@brother'], ['chacha']]);
	assert.deepEqual(shares(p, 'hanafi', 'm').s, { wife: '1/4', nephew: '3/4' });
	assert.deepEqual(shares(fam([['wife'], ['chacha'], ['cousin', 1, '@chacha']]), 'hanafi', 'm').s, { wife: '1/4', chacha: '3/4' });
});

test('orphaned grandchildren: nothing in fiqh while a son lives; their parent\'s share under MFLO s. 4', () => {
	const p = fam([['wife'], ['son'], ['son', 1, 'before'], ['grandson', 1, '@son2'], ['granddaughter', 1, '@son2']]);
	assert.deepEqual(shares(p, 'hanafi', 'm').s, { wife: '1/8', son: '7/8' });
	const { s, r } = shares(p, 'hanafi', 'm', true);
	assert.deepEqual(s, { wife: '1/8', son: '7/16', grandson: '7/24', granddaughter: '7/48' });
	assert.ok(r.notes.includes('sec4'));
});

test('daughter\'s children inherit only as dhawi al-arham when nobody else is left', () => {
	const p = fam([['daughter', 1, 'before'], ['grandson', 1, '@daughter'], ['granddaughter', 1, '@daughter']]);
	const { s, r } = shares(p, 'hanafi', 'm');
	assert.deepEqual(s, { grandson: '2/3', granddaughter: '1/3' });
	assert.ok(r.notes.includes('dhawi'));
	// With a brother, the brother takes everything.
	assert.deepEqual(shares(fam([['daughter', 1, 'before'], ['grandson', 1, '@daughter'], ['brother']]), 'hanafi', 'm').s, { brother: '1/1' });
});

test('spouse alone: radd to the spouse when no relative is left', () => {
	const { s, r } = shares(fam([['wife']]), 'hanafi', 'm');
	assert.deepEqual(s, { wife: '1/1' });
	assert.ok(r.notes.includes('raddSpouse'));
});

test('Ahl-e-Hadith: radd to a lone spouse is noted as Ibn Taymiyya\'s view, not the Hanafi fatwa', () => {
	const { s, r } = shares(fam([['husband']]), 'ahlehadith', 'f');
	assert.deepEqual(s, { husband: '1/1' });
	assert.ok(r.notes.includes('raddSpouseAeh') && !r.notes.includes('raddSpouse'));
});

test('each share says which step it came from (fixed, residue, radd), and the fixed shares are kept for the worked sheet', () => {
	const f = (x) => x && (x.d === 1 ? String(x.n) : x.n + '/' + x.d);
	const parts = (r, p) => Object.fromEntries(Object.entries(r.shares[p.id].parts).map(([k, v]) => [k, f(v)]));
	// Father with one daughter: 1/6 fixed + 1/3 residue.
	let p = fam([['father'], ['daughter']]);
	let r = W.calculate(p, { madhab: 'hanafi', deceasedSex: 'f' });
	assert.deepEqual(parts(r, p[0]), { fard: '1/6', asaba: '1/3' });
	assert.deepEqual(r.fards.map((x) => f(x.f)), ['1/6', '1/2']);
	assert.equal(f(r.asabaGroup.f), '1/3');
	// Husband and daughter: the daughter's 1/2 + radd 1/4; the husband keeps his 1/4.
	p = fam([['husband'], ['daughter']]);
	r = W.calculate(p, { madhab: 'hanafi', deceasedSex: 'f' });
	assert.deepEqual(parts(r, p[1]), { fard: '1/2', radd: '1/4' });
	assert.deepEqual(parts(r, p[0]), { fard: '1/4' });
	// Ja'fari radd keeps the same totals, split into its two steps.
	p = fam([['mother'], ['daughter']]);
	r = W.calculate(p, { madhab: 'jafari', deceasedSex: 'm' });
	assert.deepEqual(parts(r, p[1]), { fard: '1/2', radd: '1/4' });
	assert.equal(f(r.shares[p[1].id].f), '3/4');
});

test('a person who died first inherits nothing; one who died after keeps the share', () => {
	const p = fam([['son'], ['daughter', 1, 'after'], ['father', 1, 'before']]);
	const { s, r } = shares(p, 'hanafi', 'm');
	assert.deepEqual(s, { son: '2/3', daughter: '1/3' });
	assert.equal(r.shares[p[2].id].blocked, 'diedBefore');
	assert.equal(r.shares[p[1].id].after, true);
});

/* ---------- Ja'fari ---------- */

test("Ja'fari: radd to the daughter and the parents", () => {
	assert.deepEqual(shares(fam([['father'], ['mother'], ['daughter']]), 'jafari', 'm').s, { father: '1/5', mother: '1/5', daughter: '3/5' });
});

test("Ja'fari: no 'awl, the daughters bear the shortfall", () => {
	const { s, r } = shares(fam([['husband'], ['father'], ['mother'], ['daughter', 2]]), 'jafari', 'f');
	assert.deepEqual(s, { husband: '1/4', father: '1/6', mother: '1/6', daughter: '5/24 5/24' });
	assert.equal(r.awl, false);
});

test("Ja'fari: mother's hajb by the brothers when the father is alive", () => {
	assert.deepEqual(shares(fam([['father'], ['mother'], ['brother', 2]]), 'jafari', 'm').s, { father: '5/6', mother: '1/6' });
	assert.deepEqual(shares(fam([['father'], ['mother']]), 'jafari', 'm').s, { father: '2/3', mother: '1/3' });
});

test("Ja'fari: grandchildren take their parent's place when no child is alive", () => {
	const p = fam([['son', 1, 'before'], ['granddaughter', 1, '@son'], ['daughter', 1, 'before'], ['grandson', 1, '@daughter'], ['brother']]);
	assert.deepEqual(shares(p, 'jafari', 'm').s, { granddaughter: '2/3', grandson: '1/3' });
});

test("Ja'fari: the wife gets nothing from land; the others share it", () => {
	const p = fam([['wife'], ['son'], ['daughter']]);
	const r = W.calculate(p, { madhab: 'jafari', deceasedSex: 'm' });
	assert.equal(W.val(r.landShares[p[0].id]), 0);
	assert.deepEqual(r.landShares[p[1].id], W.Q(2, 3));
	assert.deepEqual(r.landShares[p[2].id], W.Q(1, 3));
});

test("Ja'fari class 2: maternal side a third, paternal side the rest", () => {
	assert.deepEqual(shares(fam([['brother'], ['sister'], ['mbrother'], ['msister']]), 'jafari', 'm').s, { brother: '4/9', sister: '2/9', mbrother: '1/6', msister: '1/6' });
	assert.deepEqual(shares(fam([['brother'], ['mbrother']]), 'jafari', 'm').s, { brother: '5/6', mbrother: '1/6' });
	assert.deepEqual(shares(fam([['dada'], ['nana']]), 'jafari', 'm').s, { dada: '2/3', nana: '1/3' });
	// Class 1 blocks class 2.
	assert.deepEqual(shares(fam([['mother'], ['brother']]), 'jafari', 'm').s, { mother: '1/1' });
});

test("Ja'fari class 3: uncles and aunts", () => {
	assert.deepEqual(shares(fam([['chacha'], ['phuphi'], ['mamu'], ['khala']]), 'jafari', 'm').s, { chacha: '4/9', phuphi: '2/9', mamu: '1/6', khala: '1/6' });
	assert.deepEqual(shares(fam([['wife'], ['chacha']]), 'jafari', 'm').s, { wife: '1/4', chacha: '3/4' });
});

test('validate: one father, four wives at most, grandchildren need a parent', () => {
	const p = fam([['father', 2], ['wife', 5], ['grandson']]);
	const codes = W.validate(p, 'm').map((e) => e.code).sort();
	assert.deepEqual(codes, ['fourWives', 'onlyOne', 'parent']);
	assert.deepEqual(W.validate(fam([['husband']]), 'm').map((e) => e.code), ['spouseSex']);
});

test('land units and net estate', () => {
	assert.equal(W.toSarsahi({ kanal: 2, marla: 10 }), 450);
	assert.deepEqual(W.fromSarsahi(450 / 8), { kanal: 0, marla: 6, sarsahi: 2.25 });
	assert.deepEqual(W.fromSarsahi(W.toSarsahi({ acre: 1 })), { kanal: 8, marla: 0, sarsahi: 0 });
	const n = W.netEstate([{ type: 'cash', qty: 100000 }, { type: 'land', qty: 450, value: 900000 }], { funeral: 20000, debts: 30000, will: 500000 });
	// Will capped at a third of 950,000; cash pays 100,000 first, the land pays the rest.
	assert.equal(Math.round(n.willUsed), 316667);
	assert.equal(n.items[0].factor, 0);
	assert.equal(Math.round(n.items[1].factor * 900000), 1000000 - 50000 - 316667 - 0);
	assert.equal(n.willCapped, true);
});
