// Numbers printed in page text must match what the engine computes (audit FIX-032).
// Run: node --test tests/content.test.js
const test = require('node:test');
const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const E = require('../assets/js/engine.js');

const root = path.join(__dirname, '..');
const files = ['includes', 'assets/js'].flatMap((d) =>
	fs.readdirSync(path.join(root, d)).filter((f) => /\.(php|js)$/.test(f)).map((f) => path.join(d, f)));

test('silver nisab shown as the engine value (612.35 g, not 612.36 g)', () => {
	assert.equal(E.SILVER_NISAB_G.toFixed(2), '612.35');
	assert.equal(E.GOLD_NISAB_G.toFixed(2), '87.48');
	for (const f of files) {
		const s = fs.readFileSync(path.join(root, f), 'utf8');
		assert.ok(!s.includes('612.36'), f + ' still says 612.36');
	}
});

test('every page the audit asked for is listed in llms.txt', () => {
	const s = fs.readFileSync(path.join(root, 'includes/content.php'), 'utf8');
	for (const slug of ['calculators', 'contact', 'free-zakat-widget']) {
		const block = s.split("$p['" + slug + "'] = array(")[1];
		assert.ok(block, slug + ' page found');
		assert.match(block.split('<<<')[0], /'llms'\s*=>\s*true/, slug + ' has llms flag');
	}
});

test('past nisab table in PHP matches the engine (SUG-11)', () => {
	const php = fs.readFileSync(path.join(root, 'includes/class-frontend.php'), 'utf8').split('const NISAB_HISTORY')[1].split(');')[0];
	const rows = [...php.matchAll(/(\d{4}) => array\( ([\d.]+), ([\d.]+), ([\d.]+) \)/g)];
	assert.equal(rows.length, Object.keys(E.NISAB_HISTORY).length);
	for (const [, y, g, s, r] of rows) assert.deepEqual(E.NISAB_HISTORY[y], [+g, +s, +r], y);
});
