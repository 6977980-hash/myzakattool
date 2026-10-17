// Browser test for the wirasat calculator (assets/js/wirasat-ui.js). Run: npm run test:ui
// Opens tests/ui/wirasat.html, enters a family and an estate like a visitor, and checks the
// share table, the shajra canvas and the PNG and PDF downloads.
const test = require('node:test');
const assert = require('node:assert/strict');
const http = require('node:http');
const fs = require('node:fs');
const path = require('node:path');
const { chromium } = require('playwright');

const ROOT = path.resolve(__dirname, '../..');
const TYPES = { '.html': 'text/html', '.js': 'text/javascript', '.css': 'text/css' };

let server, base, browser;

test.before(async () => {
	server = http.createServer((req, res) => {
		const url = new URL(req.url, 'http://x');
		const file = path.join(ROOT, url.pathname === '/' ? 'tests/ui/wirasat.html' : decodeURIComponent(url.pathname));
		if (!file.startsWith(ROOT) || !fs.existsSync(file) || fs.statSync(file).isDirectory()) {
			res.writeHead(404).end();
			return;
		}
		res.writeHead(200, { 'Content-Type': TYPES[path.extname(file)] || 'application/octet-stream' });
		fs.createReadStream(file).pipe(res);
	});
	await new Promise((r) => server.listen(0, '127.0.0.1', r));
	base = 'http://127.0.0.1:' + server.address().port + '/';
	browser = await chromium.launch();
});

test.after(async () => {
	if (browser) await browser.close();
	if (server) server.close();
});

async function open(lang, viewport) {
	const ctx = await browser.newContext({ viewport: viewport || { width: 1100, height: 900 }, acceptDownloads: true });
	const page = await ctx.newPage();
	const errors = [];
	page.on('pageerror', (e) => errors.push(e.message));
	page.on('console', (m) => { if (m.type() === 'error') errors.push(m.text()); });
	// Google Fonts is not reachable in CI; the canvas falls back to the system font.
	await page.route(/fonts\.(googleapis|gstatic)\.com/, (r) => r.abort());
	await page.addInitScript((l) => { window.__MYZT_TEST = { lang: l }; }, lang);
	await page.goto(base);
	return { page, ctx, errors, w: page.locator('.myzt-wirasat') };
}

/** Hanafi: wife, father (died before), mother, sons Ahmad and Bilal (died before, with two children), a daughter and a brother. */
async function family(w, sec4) {
	await w.locator('[data-madhab="hanafi"]').click();
	await w.locator('[data-dname]').fill('Muhammad Aslam');
	for (const rel of ['wife', 'father', 'mother', 'son', 'son', 'daughter', 'brother']) await w.locator(`[data-add="${rel}"]`).click();
	const ids = await w.locator('[data-pname]').evaluateAll((els) => els.map((e) => e.dataset.pname));
	await w.locator(`[data-pname="${ids[3]}"]`).fill('Ahmad');
	await w.locator(`[data-pname="${ids[4]}"]`).fill('Bilal');
	await w.locator(`select[data-pstatus="${ids[4]}"]`).selectOption('before');
	await w.locator(`select[data-pstatus="${ids[1]}"]`).selectOption('before');
	await w.locator('[data-add="grandson"]').click();
	await w.locator('[data-add="granddaughter"]').click();
	const kids = await w.locator('select[data-pparent]').evaluateAll((els) => els.map((e) => e.dataset.pparent));
	for (const id of kids) await w.locator(`select[data-pparent="${id}"]`).selectOption(ids[4]);
	await w.locator('[data-additem="cash"]').click();
	await w.locator('input[data-item="0"][data-k="qty"]').fill('5000000');
	await w.locator('[data-additem="land"]').click();
	await w.locator('input[data-item="1"][data-k="kanal"]').fill('2');
	await w.locator('input[data-item="1"][data-k="marla"]').fill('10');
	await w.locator('input[data-ded="debts"]').fill('200000');
	if (sec4) await w.locator('[data-sec4]').check();
	await w.page().waitForTimeout(600); // typed amounts redraw after a short pause
}

function rows(w) {
	return w.locator('.myzt-wt tbody tr').evaluateAll((trs) => trs.map((tr) => tr.innerText.replace(/\s+/g, ' ')));
}

test('Hanafi family: shares, amounts after debt, and the shajra', async () => {
	const { ctx, errors, w } = await open('en');
	await family(w, false);
	const r = await rows(w);
	const ahmad = r.find((x) => x.startsWith('Ahmad'));
	assert.match(ahmad, /17\/36/);
	// 48,00,000 left after the debt; 17/36 of it.
	assert.match(ahmad, /Rs 22,66,667/);
	assert.ok(r.some((x) => /1\/8/.test(x)), 'wife 1/8');
	assert.ok(!r.some((x) => x.startsWith('Bilal')), 'a son who died before does not inherit');
	const box = await w.locator('canvas[data-tree]').boundingBox();
	assert.ok(box && box.width > 200 && box.height > 200);
	assert.deepEqual(errors, []);
	await ctx.close();
});

test('Section 4 gives the predeceased son\'s children his share', async () => {
	const { ctx, errors, w } = await open('en');
	await family(w, true);
	const r = await rows(w);
	assert.match(r.find((x) => x.startsWith('Ahmad')), /17\/60/);
	assert.ok(r.some((x) => /17\/90/.test(x)), 'grandson 17/90');
	assert.ok(r.some((x) => /17\/180/.test(x)), 'granddaughter 17/180');
	assert.deepEqual(errors, []);
	await ctx.close();
});

test('Urdu on a phone: PNG and PDF downloads work', async () => {
	const { page, ctx, errors, w } = await open('ur', { width: 390, height: 844 });
	await family(w, false);
	const [png] = await Promise.all([page.waitForEvent('download'), w.locator('[data-act="png"]').click()]);
	assert.match(png.suggestedFilename(), /\.png$/);
	const [pdf] = await Promise.all([page.waitForEvent('download'), w.locator('[data-act="pdf"]').click()]);
	assert.match(pdf.suggestedFilename(), /\.pdf$/);
	const head = fs.readFileSync(await pdf.path()).subarray(0, 5).toString();
	assert.equal(head, '%PDF-');
	const wide = await page.evaluate(() => document.documentElement.scrollWidth);
	assert.ok(wide <= 390, 'no sideways page scroll, got ' + wide);
	assert.deepEqual(errors, []);
	await ctx.close();
});

test('A daughter who died first is asked about her children', async () => {
	const { ctx, errors, w } = await open('en');
	await w.locator('[data-madhab="hanafi"]').click();
	for (const rel of ['wife', 'son', 'daughter']) await w.locator(`[data-add="${rel}"]`).click();
	const ids = await w.locator('[data-pname]').evaluateAll((els) => els.map((e) => e.dataset.pname));
	await w.locator(`[data-pname="${ids[2]}"]`).fill('Amna');
	await w.locator(`select[data-pstatus="${ids[2]}"]`).selectOption('before');
	const ask = w.locator(`[data-addkid][data-for="${ids[2]}"]`);
	assert.equal(await ask.count(), 2);
	await ask.first().click();
	await w.locator('[data-sec4]').check();
	await w.page().waitForTimeout(600);
	const r = await rows(w);
	// Section 4: Amna's son takes her share (1/3 of the 7/8 left after the wife).
	assert.ok(r.some((x) => /7\/24/.test(x)), JSON.stringify(r));
	assert.deepEqual(errors, []);
	await ctx.close();
});
