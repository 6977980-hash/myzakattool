// Inheritance engine against tests/wirasat-golden.json: expected shares worked out by hand from the
// books of fara'id and published fatwas, independently of the engine. Cases marked "unresolved"
// (no settled ruling for that school) are listed but not asserted.
// Run: node --test tests/wirasat-golden.test.js
const test = require('node:test');
const assert = require('node:assert/strict');
const W = require('../assets/js/wirasat.js');
const CASES = require('./wirasat-golden.json');

const ESTATE = 1200000;
function frac(s) {
	const [n, d = '1'] = String(s).split('/');
	return W.Q(+n, +d);
}

for (const c of CASES) {
	const name = c.id + ' ' + c.madhab + ': ' + c.title;
	test(name, { skip: c.confidence === 'unresolved' ? 'unresolved ruling: ' + (c.note || '') : false }, () => {
		const errs = W.validate(c.persons, c.deceasedSex);
		assert.deepEqual(errs, [], 'family is valid');
		const r = W.calculate(c.persons, { madhab: c.madhab, deceasedSex: c.deceasedSex, sec4: !!c.sec4 });
		const got = {}, want = {};
		let money = 0;
		for (const p of c.persons) {
			const f = r.shares[p.id].f;
			got[p.id] = f.d === 1 ? String(f.n) : f.n + '/' + f.d;
			const e = frac(c.expected[p.id] ?? '0');
			want[p.id] = e.d === 1 ? String(e.n) : e.n + '/' + e.d;
			money += Math.round(ESTATE * f.n / f.d * 100) / 100;
		}
		assert.deepEqual(got, want);
		// The estate is fully accounted for: exact fractions sum to one (or the documented unassigned part), money within rounding.
		assert.equal(W.cmp(W.add(r.total, W.ZERO), W.ONE), 0, 'fractions add up to the whole estate');
		const unassigned = r.unassigned ? ESTATE * r.unassigned.n / r.unassigned.d : 0;
		assert.ok(Math.abs(money + unassigned - ESTATE) < 0.01 * c.persons.length, 'money adds up: ' + money);
	});
}
