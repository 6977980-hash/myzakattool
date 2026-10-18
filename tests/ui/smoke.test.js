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
	// Widgets start one task after another (FIX-049): wait until every one has drawn.
	await page.waitForFunction(() => [...document.querySelectorAll('.myzt[data-widget]')].every((e) => e.children.length));
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
	for (const w of ['calculator', 'goldrate', 'nisab', 'fitrana', 'fidya', 'khums', 'hawl', 'ushr', 'mehr', 'diyat']) {
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

test('a negative amount outside the zakat calculator gets a message without Debts / Bills (FIX-125)', async () => {
	const { page, ctx } = await open();
	assert.match(await calc(page).textContent(), /Debts/, 'the main calculator has a Debts section');
	const box = page.locator('.myzt-khums input[data-k]').first();
	await box.fill('-100');
	assert.equal(await box.getAttribute('aria-invalid'), 'true');
	const msg = await page.locator('.myzt-khums .myzt-err').textContent();
	assert.match(msg, /cannot be negative/);
	assert.doesNotMatch(msg, /Debts/);
	await ctx.close();
});

test('number boxes are 16px so iOS does not zoom (FIX-112)', async () => {
	const { page, ctx } = await open();
	const small = await page.evaluate(() => [...document.querySelectorAll('.myzt .myzt-inp, .myzt .myzt-sel')].filter((e) => parseFloat(getComputedStyle(e).fontSize) < 16).length);
	assert.equal(small, 0);
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

// Phase 7 (audit FIX-049 to FIX-057): performance, accessibility and privacy.
test('pdf.js is not loaded with the page, only when a report is made (FIX-049)', async () => {
	const { page, ctx, errors } = await open();
	assert.equal(await page.evaluate(() => !!window.MYZT_PDF), false, 'not loaded up front');
	await enter(page, 'cash', { kind: 'money', key: 'cash' }, 1000000);
	await calc(page).locator('[data-act="pdf"]').click();
	await calc(page).locator('[data-pdfname]').fill('علی احمد');
	const [dl] = await Promise.all([page.waitForEvent('download'), calc(page).locator('[data-act="makepdf"]').click()]);
	assert.match(dl.suggestedFilename(), /\.pdf$/);
	assert.equal(await page.evaluate(() => !!window.MYZT_PDF), true);
	assert.deepEqual(errors, []);
	await ctx.close();
});

test('screen readers hear only the total, after typing stops (FIX-054)', async () => {
	const { page, ctx } = await open();
	assert.equal(await calc(page).locator('[aria-live]').count(), 0, 'the result box itself is not live');
	const live = page.locator('.myzt-calculator + .myzt-sr[role="status"]');
	assert.equal(await live.count(), 1);
	assert.equal(await live.textContent(), '', 'silent on page load');
	await enter(page, 'cash', { kind: 'money', key: 'cash' }, 1000000);
	await page.waitForFunction(() => document.querySelector('.myzt-sr').textContent.length > 0);
	assert.match(await live.textContent(), /^Your zakat \(Hanafi\): Rs\s25,000$/);
	await ctx.close();
});

test('widget headings follow the page h1; checkboxes are 20 px; date inputs have one name (FIX-053)', async () => {
	const { page, ctx } = await open();
	await calc(page).locator('[data-tile="cash"]').click();
	assert.equal(await page.locator('.myzt h4').count(), 0);
	assert.ok(await calc(page).locator('h2.myzt-h').count() >= 1);
	const box = await calc(page).locator('input[type="checkbox"]').first().boundingBox();
	assert.ok(box.width >= 20 && box.height >= 20, 'checkbox at least 20 px');
	assert.ok(await page.locator('#myzt-hs').getAttribute('aria-label'));
	assert.ok(await page.locator('#myzt-kd').getAttribute('aria-label'));
	await ctx.close();
});

test('the Urdu toggle sets lang="ur" and translates units and madhab names (FIX-055)', async () => {
	const { page, ctx, errors } = await open();
	await calc(page).locator('[data-act="lang"]').click();
	assert.equal(await calc(page).getAttribute('lang'), 'ur');
	assert.equal(await calc(page).getAttribute('dir'), 'rtl');
	const text = await calc(page).locator('.myzt-ctx').textContent();
	assert.match(text, /حنفی/);
	assert.match(text, /تولہ/);
	assert.doesNotMatch(text, /Hanafi|tola/);
	await calc(page).locator('[data-act="lang"]').click();
	assert.equal(await calc(page).getAttribute('lang'), 'en');
	assert.deepEqual(errors, []);
	await ctx.close();
});

test('Clear all leaves no draft; Delete saved data removes every saved key (FIX-057)', async () => {
	const { page, ctx } = await open();
	page.on('dialog', (d) => d.accept());
	await enter(page, 'cash', { kind: 'money', key: 'cash' }, 1000000);
	await page.evaluate(() => localStorage.setItem('myzt_khums_date', '2026-03-01'));
	assert.ok(await page.evaluate(() => localStorage.getItem('myzt_draft_v1')));
	await calc(page).locator('[data-act="reset"]').click();
	assert.equal(await page.evaluate(() => localStorage.getItem('myzt_draft_v1')), null, 'no empty draft left');
	await enter(page, 'cash', { kind: 'money', key: 'cash' }, 5000);
	await calc(page).locator('[data-act="forget"]').click();
	const left = await page.evaluate(() => Object.keys(localStorage).filter((k) => k.indexOf('myzt_') === 0));
	assert.deepEqual(left, []);
	assert.equal(await amount(page), 0);
	await ctx.close();
});

test('a draft untouched for 13 months is dropped (FIX-057)', async () => {
	const { page, ctx } = await open();
	await enter(page, 'cash', { kind: 'money', key: 'cash' }, 1000000);
	await page.evaluate(() => localStorage.setItem('myzt_draft_v1_at', String(Date.now() - 400 * 864e5)));
	await page.reload();
	await page.waitForSelector('.myzt-calculator .myzt-res');
	assert.equal(await amount(page), 0);
	await ctx.close();
});

test('haq mehr: Mehr-e-Fatimi from the silver rate, own mehr checked against the minimum', async () => {
	const { page, ctx, errors } = await open();
	const m = page.locator('.myzt-mehr');
	// silver 57.116001 USD/oz x 277.33821319 PKR / 31.1034768 g = Rs 509.28/g; x 1530.9 g = Rs 779,660.
	const perG = 57.116001 * 277.33821319 / 31.1034768;
	const fatimi = digits(await m.locator('tbody tr').nth(1).locator('td.z').textContent());
	assert.ok(Math.abs(fatimi - Math.round(1530.9 * perG)) <= 1, 'fatimi ' + fatimi);
	await m.locator('input[data-m="mine"]').fill('10000');
	assert.match(await m.locator('[data-mine]').textContent(), /less than the Hanafi minimum/);
	await m.locator('input[data-m="mine"]').fill('1000000');
	assert.doesNotMatch(await m.locator('[data-mine]').textContent(), /less than/);
	await m.locator('input[data-m="qty"]').fill('5');
	assert.equal(digits(await m.locator('[data-metal-out] .myzt-amt').textContent()), Math.round(5 * 11.6638038 * 4166.100098 * 277.33821319 / 31.1034768));
	assert.deepEqual(errors, []);
	await ctx.close();
});

test('diyat: notified amount and live silver value in rupees', async () => {
	const { page, ctx } = await open();
	const d = page.locator('.myzt-diyat');
	assert.equal(digits(await d.locator('.myzt-amt').textContent()), 19352390);
	const live = digits(await d.locator('.myzt-line b').first().textContent());
	assert.equal(live, Math.round(30630 * 57.116001 * 277.33821319 / 31.1034768));
	assert.equal(await d.locator('tbody tr').count(), 4);
	await ctx.close();
});

test('small widgets announce their result after typing, silent on load (FIX-115)', async () => {
	const { page, ctx } = await open();
	for (const w of ['goldrate', 'nisab', 'fitrana', 'fidya', 'khums', 'hawl', 'ushr', 'mehr']) {
		const live = page.locator(`.myzt-${w} + .myzt-sr[role="status"][aria-live="polite"]`);
		assert.equal(await live.count(), 1, `${w} has a live region`);
		assert.equal(await live.textContent(), '', `${w} silent on load`);
	}
	await page.locator('#myzt-fp').fill('3');
	await page.locator('#myzt-fa').fill('300');
	const fit = page.locator('.myzt-fitrana + .myzt-sr');
	await page.waitForFunction(() => document.querySelector('.myzt-fitrana + .myzt-sr').textContent.length > 0);
	assert.match(await fit.textContent(), /900/);
	await page.locator('#myzt-k-savings').fill('100000');
	await page.waitForFunction(() => document.querySelector('.myzt-khums + .myzt-sr').textContent.length > 0);
	assert.match(await page.locator('.myzt-khums + .myzt-sr').textContent(), /20,000/);
	await ctx.close();
});

test('field borders reach 3:1; small labels and links have a 44 px tap area (FIX-116, FIX-117)', async () => {
	const { page, ctx } = await open();
	const border = await page.locator('#myzt-fp').evaluate((el) => getComputedStyle(el).borderTopColor);
	assert.equal(border, 'rgb(107, 138, 131)');
	for (const sel of ['.myzt-calculator .myzt-check', '.myzt-calculator .myzt-add', '.myzt-hawl .myzt-check']) {
		const box = await page.locator(sel).first().boundingBox();
		assert.ok(box && box.height >= 44, `${sel} is ${box && box.height}px high`);
	}
	await ctx.close();
});

// Phase 7 of the 18 Oct 2026 audit: small-tool PDFs and calculator presets on the asset pages.
test('every small tool has a PDF button that downloads a report (FIX-126)', async () => {
	const { page, ctx, errors } = await open();
	for (const w of ['fitrana', 'fidya', 'khums', 'hawl', 'ushr', 'mehr', 'diyat']) {
		const has = await page.evaluate((w) => {
			let el = document.querySelector(`.myzt[data-widget="${w}"]`).nextElementSibling;
			if (el && el.classList.contains('myzt-sr')) el = el.nextElementSibling;
			return !!(el && el.classList.contains('myzt-pdfrow') && el.querySelector('button'));
		}, w);
		assert.ok(has, `${w} has a PDF button`);
	}
	await page.locator('.myzt[data-widget="fitrana"] input[data-f="persons"]').fill('4');
	const [dl] = await Promise.all([page.waitForEvent('download'), page.locator('.myzt[data-widget="fitrana"] + .myzt-sr + .myzt-pdfrow button').click()]);
	assert.match(dl.suggestedFilename(), /^fitrana-sadaqat-al-fitr-\d{4}-\d{2}-\d{2}\.pdf$/);
	assert.deepEqual(errors, []);
	await ctx.close();
});

test('an asset page preset opens its tiles and currency on a first visit only (FIX-158)', async () => {
	const ctx = await browser.newContext({ locale: 'en-US', timezoneId: 'Asia/Karachi' });
	const page = await ctx.newPage();
	await page.addInitScript(() => {
		document.addEventListener('DOMContentLoaded', () => {
			const c = document.querySelector('.myzt-calculator');
			c.dataset.tiles = 'shares,committee,nope';
			c.dataset.currency = 'INR';
			c.dataset.unit = 'gram';
		});
	});
	await page.goto(base);
	await page.waitForSelector('.myzt-calculator .myzt-res');
	const c = page.locator('.myzt-calculator');
	assert.equal(await c.locator('[data-tile="shares"]').getAttribute('aria-pressed'), 'true');
	assert.equal(await c.locator('[data-tile="committee"]').getAttribute('aria-pressed'), 'true');
	assert.equal(await c.locator('[data-tile="cash"]').getAttribute('aria-pressed'), 'false');
	assert.match(await c.locator('.myzt-ctx').textContent(), /INR/);
	await ctx.close();
});
