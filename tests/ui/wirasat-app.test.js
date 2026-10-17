// Browser test for the wirasat calculator page (assets/wirasat/app.html, built from src/wirasat/).
// Run: npm run test:ui
// Opens the page in a frame like the [zakat_wirasat] shortcode does, loads the sample family,
// and checks the shares, the shajra, the frame height and a real PDF download.
const test = require('node:test');
const assert = require('node:assert/strict');
const http = require('node:http');
const fs = require('node:fs');
const path = require('node:path');
const { chromium } = require('playwright');

const ROOT = path.resolve(__dirname, '../..');
const TYPES = { '.html': 'text/html; charset=utf-8', '.js': 'text/javascript', '.css': 'text/css' };

let server, base, browser;

test.before(async () => {
	server = http.createServer((req, res) => {
		const url = new URL(req.url, 'http://x');
		const file = path.join(ROOT, url.pathname === '/' ? 'tests/ui/wirasat-host.html' : decodeURIComponent(url.pathname));
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
	await browser.close();
	server.close();
});

async function open(width) {
	const ctx = await browser.newContext({ viewport: { width, height: 900 }, acceptDownloads: true });
	const page = await ctx.newPage();
	const errors = [];
	page.on('pageerror', (e) => errors.push(e.message));
	// Google Fonts may be unreachable in CI; the page must work without them.
	await page.route(/fonts\.(googleapis|gstatic)\.com/, (r) => r.abort());
	await page.goto(base);
	const el = await page.waitForSelector('iframe.myzt-wirasat-frame');
	const f = await el.contentFrame();
	await f.waitForSelector('#go');
	return { page, ctx, errors, f };
}

test('the frame opens empty with the madhab from the shortcode and grows to its content', async () => {
	const { page, ctx, errors, f } = await open(1100);
	assert.equal(await f.locator('#madhab [aria-pressed="true"]').textContent(), 'شافعی');
	assert.equal(await f.inputValue('#dname'), '');
	await page.waitForFunction(() => parseInt(document.querySelector('iframe').style.height, 10) > 600);
	const h = await page.evaluate(() => document.querySelector('iframe').getBoundingClientRect().height);
	const inner = await f.evaluate(() => document.documentElement.scrollHeight);
	assert.ok(Math.abs(h - inner) < 4, `frame ${h}px fits its page ${inner}px`);
	assert.equal(await f.isVisible('header h1'), false, 'the WordPress page has the heading');
	assert.deepEqual(errors, []);
	await ctx.close();
});

test('sample family: shares, shajra, saved draft and a PDF report', async () => {
	const { page, ctx, errors, f } = await open(1100);
	await f.click('#reset');
	await f.click('#go');
	await f.waitForSelector('#resultSec:not([hidden])');
	const text = await f.textContent('#result');
	for (const s of ['1/6', '1/8', 'شجرہ نسب وارثان', 'متوفی حال', 'کنال']) assert.ok(text.includes(s), 'result shows ' + s);
	assert.ok((await f.locator('#tree .node, #tree [class*="node"]').count()) >= 10, 'every family member is in the shajra');
	const saved = await f.evaluate(() => localStorage.getItem('myzt_wirasat_v2'));
	assert.ok(saved && JSON.parse(saved).people.length === 10, 'draft saved under the myzt_ prefix');
	const grown = await page.evaluate(() => parseInt(document.querySelector('iframe').style.height, 10));
	assert.ok(grown > 1500, 'frame grew with the result: ' + grown);
	// The page scrolls down to the shajra by itself.
	await page.waitForFunction(() => scrollY > 300);
	await page.waitForTimeout(800);
	const treeTop = await page.evaluate(() => document.querySelector('iframe').getBoundingClientRect().top) + (await f.evaluate(() => document.getElementById('tree').parentNode.getBoundingClientRect().top));
	assert.ok(treeTop >= -2 && treeTop < 120, 'shajra at the top of the screen: ' + treeTop);

	const [dl] = await Promise.all([page.waitForEvent('download', { timeout: 60000 }), f.click('#pdf')]);
	const file = path.join(require('node:os').tmpdir(), 'wirasat-test.pdf');
	await dl.saveAs(file);
	const pdf = fs.readFileSync(file);
	assert.equal(pdf.subarray(0, 5).toString(), '%PDF-');
	assert.ok((pdf.toString('latin1').match(/\/Type \/Page\b/g) || []).length >= 2, 'shajra page plus report pages');
	assert.ok(dl.suggestedFilename().endsWith('.pdf'));
	assert.deepEqual(errors, []);
	await ctx.close();
});

test('phone width: no sideways scroll outside the shajra box', async () => {
	const { ctx, errors, f } = await open(380);
	await f.click('#reset');
	await f.click('#go');
	await f.waitForSelector('#resultSec:not([hidden])');
	const over = await f.evaluate(() => document.documentElement.scrollWidth - document.documentElement.clientWidth);
	assert.ok(over <= 1, 'page overflow ' + over + 'px');
	// The whole shajra fits the width; "شجرہ بڑا کریں" shows it full size with a sideways scroll.
	const fits = () => f.evaluate(() => { const b = document.getElementById('tree').parentNode; return b.scrollWidth - b.clientWidth; });
	assert.ok((await fits()) <= 1, 'shajra fits without scrolling');
	await f.click('#zoom');
	assert.ok((await fits()) > 50, 'full-size shajra scrolls sideways');
	assert.equal(await f.getAttribute('#zoom', 'aria-pressed'), 'true');
	await f.click('#zoom');
	assert.ok((await fits()) <= 1);
	assert.deepEqual(errors, []);
	await ctx.close();
});

test('adding family members does not move the page, and the frame follows dark mode', async () => {
	const { page, ctx, errors, f } = await open(390);
	for (const sel of ['[data-step^="r-wife"][data-d="1"]', '[data-step^="r-son"][data-d="1"]', '[data-step^="r-daughter"][data-d="1"]']) {
		const el = f.locator(sel).first();
		await el.scrollIntoViewIfNeeded();
		const at = async () => (await page.evaluate(() => document.querySelector('iframe').getBoundingClientRect().top)) + (await f.locator(sel).first().evaluate((e) => e.getBoundingClientRect().top));
		const before = await at();
		await el.click();
		await page.waitForTimeout(300);
		assert.ok(Math.abs((await at()) - before) < 2, sel + ' stayed under the finger');
	}
	await page.evaluate(() => localStorage.setItem('myzt_theme', 'dark'));
	await f.waitForFunction(() => document.documentElement.getAttribute('data-theme') === 'dark');
	assert.notEqual(await f.evaluate(() => getComputedStyle(document.querySelector('.sec')).backgroundColor), 'rgb(255, 255, 255)');
	assert.deepEqual(errors, []);
	await ctx.close();
});

test('no scrollbar flashes inside the frame when a row is added (the form jerked sideways)', async () => {
	const b = await chromium.launch({ ignoreDefaultArgs: ['--hide-scrollbars'] });
	const page = await b.newPage({ viewport: { width: 1100, height: 800 } });
	await page.route(/fonts\.(googleapis|gstatic)\.com/, (r) => r.abort());
	await page.goto(base);
	const f = await (await page.waitForSelector('iframe.myzt-wirasat-frame')).contentFrame();
	await f.waitForSelector('#go');
	await f.evaluate(() => { window.cw = []; const tick = () => { window.cw.push(document.documentElement.clientWidth); requestAnimationFrame(tick); }; tick(); });
	for (let i = 0; i < 3; i++) {
		await f.click('[data-step^="r-son"][data-d="1"]');
		await page.waitForTimeout(250);
	}
	const [lo, hi] = await f.evaluate(() => [Math.min(...window.cw), Math.max(...window.cw)]);
	assert.equal(lo, hi, 'frame width stayed ' + hi + 'px');
	await b.close();
});

test('gold: each share in tola and grams, with an estimate at the site rate', async () => {
	// tests/ui/rates.json: gold $4000/oz, Rs 280 per $, so one tola (11.6638 g) is Rs 4,20,000.
	const { ctx, errors, f } = await open(1100);
	await f.fill('#askText', 'ek aadmi fout hua, biwi aur ek beta, 8 tola sona');
	await f.click('#askGo');
	await f.click('#go');
	await f.waitForSelector('#resultSec:not([hidden])');
	const rows = await f.$$eval('#result table tr', (trs) => trs.map((tr) => [...tr.querySelectorAll('td')].map((td) => td.textContent.trim())).filter((r) => r.length));
	const wife = rows.find((r) => r[0] === 'بیوی'), son = rows.find((r) => r[0] === 'بیٹا');
	assert.equal(wife[1], '1/8');
	assert.equal(wife[2], '1 تولہ11.66 گرام · اندازاً Rs 4,20,000');
	assert.equal(son[2], '7 تولہ81.65 گرام · اندازاً Rs 29,40,000');
	const note = await f.textContent('#result');
	assert.ok(note.includes('قیمت صرف اندازے کے لیے ہے') && note.includes('Rs 4,20,000 فی تولہ'));
	assert.deepEqual(errors, []);
	await ctx.close();
});
