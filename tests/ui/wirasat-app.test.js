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
	assert.deepEqual(errors, []);
	await ctx.close();
});
