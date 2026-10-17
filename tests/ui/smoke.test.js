// Browser smoke tests for assets/js/app.js (audit FIX-062). Run: npm run test:ui
// Serves the repo over a local HTTP server, opens tests/ui/fixture.html (the same markup and
// window.MYZT config the shortcodes print) in Chromium, and drives the widgets like a visitor.
const test = require('node:test');
const assert = require('node:assert/strict');
const http = require('node:http');
const fs = require('node:fs');
const path = require('node:path');
const { chromium } = require('playwright');

const ROOT = path.resolve(__dirname, '../..');
const TYPES = { '.html': 'text/html', '.js': 'text/javascript', '.css': 'text/css', '.svg': 'image/svg+xml', '.png': 'image/png' };

let server, base, browser;

test.before(async () => {
	server = http.createServer((req, res) => {
		const url = new URL(req.url, 'http://x');
		const file = path.join(ROOT, url.pathname === '/' ? 'tests/ui/fixture.html' : decodeURIComponent(url.pathname));
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

/** Open the fixture; returns the page and the list of JS errors seen. */
async function open(opts = {}) {
	const ctx = await browser.newContext({ viewport: opts.viewport || { width: 1280, height: 900 }, locale: 'en-US', timezoneId: opts.timezoneId || 'Asia/Karachi' });
	const page = await ctx.newPage();
	const errors = [];
	page.on('pageerror', (e) => errors.push(e.message));
	page.on('console', (m) => { if (m.type() === 'error') errors.push(m.text()); });
	const restHits = [];
	await page.route('**/wp-json/myzakattool/v1/rates**', (route) => {
		restHits.push(route.request().url());
		route.fulfill({ contentType: 'application/json', body: JSON.stringify(opts.rest || {}) });
	});
	if (opts.cfg) await page.addInitScript((c) => { window.__MYZT_TEST = c; }, opts.cfg);
	await page.goto(base);
	await page.waitForSelector('.myzt-calculator .myzt-res');
	return { page, ctx, errors, restHits };
}

const digits = (s) => Number(String(s).replace(/[^0-9]/g, ''));
const calc = (page) => page.locator('.myzt-calculator');
const amount = async (page) => digits(await calc(page).locator('.myzt-amt').first().textContent());

async function enter(page, tile, field, value) {
	const c = calc(page);
	if ((await c.locator(`[data-tile="${tile}"]`).getAttribute('aria-pressed')) !== 'true') await c.locator(`[data-tile="${tile}"]`).click();
	await c.locator(`input[data-${field.kind}="${field.key}"]`).fill(String(value));
}

test('every widget boots without a JavaScript error', async () => {
	const { page, ctx, errors } = await open();
	for (const w of ['calculator', 'goldrate', 'nisab', 'fitrana', 'fidya', 'khums', 'hawl', 'ushr']) {
		const html = await page.locator(`.myzt[data-widget="${w}"]`).innerHTML();
		assert.ok(html.length > 200, `${w} rendered`);
		assert.equal(await page.locator(`.myzt[data-widget="${w}"]`).getAttribute('data-ready'), '1', `${w} ready`);
	}
	assert.deepEqual(errors, []);
	await ctx.close();
});

test('Pakistan defaults to Hanafi in PKR; 10 lakh cash gives Rs 25,000', async () => {
	const { page, ctx, errors } = await open();
	assert.match(await calc(page).locator('.myzt-ctx').textContent(), /Hanafi.*PKR/);
	await enter(page, 'cash', { kind: 'money', key: 'cash' }, 1000000);
	assert.equal(await amount(page), 25000);
	assert.match(await calc(page).locator('.myzt-badge').textContent(), /zakat is due/);
	assert.deepEqual(errors, []);
	await ctx.close();
});

test('debts: Hanafi deducts them, Ahl-e-Hadith does not', async () => {
	const { page, ctx } = await open();
	await enter(page, 'cash', { kind: 'money', key: 'cash' }, 1000000);
	await enter(page, 'debts', { kind: 'liab', key: 'debts' }, 300000);
	assert.equal(await amount(page), 17500);
	await calc(page).locator('[data-act="ctx"]').click();
	await calc(page).locator('select[data-set="madhab"]').selectOption('ahlehadith');
	assert.equal(await amount(page), 25000);
	await ctx.close();
});

test('below nisab shows zero and "not due"', async () => {
	const { page, ctx } = await open();
	await enter(page, 'cash', { kind: 'money', key: 'cash' }, 100000);
	assert.equal(await amount(page), 0);
	assert.match(await calc(page).locator('.myzt-badge').textContent(), /not due/);
	await ctx.close();
});

test('already paid reduces what is left to pay', async () => {
	const { page, ctx } = await open();
	await enter(page, 'cash', { kind: 'money', key: 'cash' }, 1000000);
	await enter(page, 'paid', { kind: 'liab', key: 'bankDeducted' }, 10000);
	assert.equal(await amount(page), 15000);
	await ctx.close();
});

test('fresh rates are not refetched; stale cached rates are replaced from the REST API (FIX-001)', async () => {
	const fresh = await open();
	assert.equal(fresh.restHits.length, 0);
	await fresh.ctx.close();

	const now = Math.floor(Date.now() / 1000);
	const old = { goldUsdOz: 3000, silverUsdOz: 40, fx: { pkr: 277.33821319 }, updated: now - 3 * 86400, fxUpdated: now - 3 * 86400, source: 'gold-api' };
	const rest = { goldUsdOz: 4166.100098, silverUsdOz: 57.116001, fx: { pkr: 277.33821319 }, updated: now - 60, fxUpdated: now - 60, source: 'gold-api' };
	const { page, ctx, restHits, errors } = await open({ cfg: { rates: old }, rest });
	const nisab = page.locator('.myzt-nisab td.z').first();
	await page.waitForFunction(() => /3,11,859/.test(document.querySelector('.myzt-nisab td.z').textContent));
	assert.match(await nisab.textContent(), /3,11,859/); // 52.5 tola silver at the REST rate
	// Every widget on the page redraws from the one request, not only the first one to ask.
	for (const w of ['calculator', 'goldrate', 'nisab']) {
		assert.match(await page.locator(`.myzt[data-widget="${w}"]`).textContent(), /updated [12] min ago/, `${w} shows the new time`);
	}
	assert.equal(restHits.length, 1, 'one REST request per page');
	assert.match(restHits[0], /[?&]b=\d+/, 'cache-busting bucket');
	assert.deepEqual(errors, []);
	await ctx.close();
});

test('the input is kept in this browser after a reload', async () => {
	const { page, ctx } = await open();
	await enter(page, 'cash', { kind: 'money', key: 'cash' }, 1000000);
	await page.reload();
	await page.waitForSelector('.myzt-calculator .myzt-res');
	assert.equal(await amount(page), 25000);
	await ctx.close();
});

test('phone width: no sideways scroll', async () => {
	const { page, ctx } = await open({ viewport: { width: 360, height: 780 } });
	await enter(page, 'gold', { kind: 'metal', key: 'goldWorn' }, 3);
	const over = await page.evaluate(() => document.documentElement.scrollWidth - window.innerWidth);
	assert.ok(over <= 0, `page is ${over}px wider than the screen`);
	await ctx.close();
});

// Phase 3 (audit FIX-006 to FIX-017).
test('a negative amount is flagged, not silently made positive (FIX-006)', async () => {
	const { page, ctx } = await open();
	await enter(page, 'cash', { kind: 'money', key: 'cash' }, 1000000);
	await enter(page, 'bank', { kind: 'money', key: 'bank' }, -500000);
	const box = calc(page).locator('input[data-money="bank"]');
	assert.equal(await box.getAttribute('aria-invalid'), 'true');
	assert.match(await calc(page).locator('.myzt-err').textContent(), /cannot be negative/);
	assert.equal(await amount(page), 25000, 'the negative value is not counted');
	await box.blur();
	assert.equal(await box.inputValue(), '-500000', 'the typed text stays visible');
	await box.fill('500000');
	assert.equal(await box.getAttribute('aria-invalid'), null);
	assert.equal(await calc(page).locator('.myzt-err').count(), 0);
	assert.equal(await amount(page), 37500);
	await ctx.close();
});

test('unreadable input is flagged; Urdu digits and lakh commas are read (T21)', async () => {
	const { page, ctx } = await open();
	const box = calc(page).locator('input[data-money="cash"]');
	for (const v of ['abc', '1e6', '1.234,56']) {
		await enter(page, 'cash', { kind: 'money', key: 'cash' }, v);
		assert.equal(await box.getAttribute('aria-invalid'), 'true', v);
		assert.equal(await amount(page), 0, v);
	}
	await enter(page, 'cash', { kind: 'money', key: 'cash' }, '۱۰۰۰۰۰۰');
	assert.equal(await box.getAttribute('aria-invalid'), null);
	assert.equal(await amount(page), 25000);
	await enter(page, 'cash', { kind: 'money', key: 'cash' }, '10,00,000');
	assert.equal(await amount(page), 25000);
	await ctx.close();
});

test('kept gold bars and coins default to 24K, worn jewellery to 22K (FIX-007)', async () => {
	const { page, ctx } = await open();
	await enter(page, 'gold', { kind: 'metal', key: 'goldKept' }, 10);
	assert.equal(await calc(page).locator('[data-metal-karat="goldKept"][aria-pressed="true"]').getAttribute('data-v'), '24');
	assert.equal(await calc(page).locator('[data-metal-karat="goldWorn"][aria-pressed="true"]').getAttribute('data-v'), '22');
	await ctx.close();
});

test('silver has a fineness choice (FIX-008)', async () => {
	const { page, ctx } = await open();
	await enter(page, 'silver', { kind: 'metal', key: 'silverKept' }, 100);
	const pure = await amount(page);
	await calc(page).locator('[data-metal-fineness="silverKept"][data-v="925"]').click();
	const sterling = await amount(page);
	assert.ok(pure > 0 && Math.abs(sterling - pure * 0.925) <= 1, `${sterling} is 92.5% of ${pure}`);
	await ctx.close();
});

test('the comparison shows what is still to pay when zakat was already paid (FIX-010)', async () => {
	const { page, ctx } = await open();
	await enter(page, 'cash', { kind: 'money', key: 'cash' }, 1000000);
	await enter(page, 'paid', { kind: 'liab', key: 'bankDeducted' }, 10000);
	await calc(page).locator('[data-act="compare"]').click();
	const head = await page.locator('.myzt-cmp thead').textContent();
	assert.match(head, /Still to pay/);
	const hanafi = await page.locator('.myzt-cmp tbody tr').first().locator('td.z').allTextContents();
	assert.deepEqual(hanafi.map(digits), [25000, 15000]);
	await ctx.close();
});

test('a broken data file shows a message (FIX-012)', async () => {
	const { page, ctx } = await open();
	await calc(page).locator('input[data-loadfile]').setInputFiles({ name: 'x.json', mimeType: 'application/json', buffer: Buffer.from('not json') });
	await page.waitForSelector('.myzt-calculator [role="status"]');
	assert.match(await calc(page).locator('[role="status"]').textContent(), /could not be opened/);
	await ctx.close();
});

test('fitrana shows the preset and its source, or asks for an amount (FIX-013)', async () => {
	const withPreset = await open({ cfg: { fitrana: { currency: 'PKR', wheat: '300', barley: '1100', dates: '1600', raisins: '3800', note: 'Council of Islamic Ideology, 1447', fallback: true } } });
	const f = withPreset.page.locator('.myzt-fitrana');
	assert.equal(await f.locator('input[data-f="amount"]').inputValue(), '300');
	assert.match(await f.textContent(), /Council of Islamic Ideology/);
	assert.match(await f.textContent(), /Last announced amounts/);
	await f.locator('[data-item="dates"]').click();
	assert.equal(await f.locator('input[data-f="amount"]').inputValue(), '1,600');
	await withPreset.ctx.close();

	const none = await open({ cfg: { fitrana: { currency: 'PKR', wheat: '', barley: '', dates: '', raisins: '', note: '' } } });
	assert.match(await none.page.locator('.myzt-fitrana .myzt-note').textContent(), /Enter the fitrana amount/);
	await none.ctx.close();
});

// Phase 4 (audit FIX-018, 021, 025): disclosures only, results unchanged.
test('Hanafi 7.5 tola of 22K jewellery: zero, with the predominance note (FIX-018)', async () => {
	const { page, ctx } = await open();
	await enter(page, 'gold', { kind: 'metal', key: 'goldWorn' }, 7.5);
	assert.equal(await amount(page), 0);
	assert.match(await calc(page).textContent(), /Some Hanafi muftis count jewellery that is mostly gold/);
	await ctx.close();
});

test('fidya says which madhab the daily amount follows (FIX-025)', async () => {
	const { page, ctx } = await open();
	assert.match(await page.locator('.myzt-fidya').textContent(), /one mudd of food/);
	await ctx.close();
});

// Phase 6 (audit FIX-046): server-rendered Urdu pages open the widgets in Urdu.
test('Urdu page config (lang: ur) renders the calculator in Urdu, right to left', async () => {
	const { page, ctx, errors } = await open({ cfg: { lang: 'ur' } });
	assert.equal(await calc(page).getAttribute('dir'), 'rtl');
	assert.match(await calc(page).textContent(), /زکوٰۃ/);
	assert.deepEqual(errors, []);
	await ctx.close();
});
