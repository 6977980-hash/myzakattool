// Browser tests for the wirasat audit fixes of November 2026 (F1-F14, report in the project's audit/wirasat-2026-11/).
// Run: npm run test:ui
const test = require('node:test');
const assert = require('node:assert/strict');
const http = require('node:http');
const fs = require('node:fs');
const path = require('node:path');
const { chromium } = require('playwright');

const ROOT = path.resolve(__dirname, '../..');
const TYPES = { '.html': 'text/html; charset=utf-8', '.js': 'text/javascript', '.css': 'text/css', '.json': 'application/json' };
let server, base, browser;

test.before(async () => {
	server = http.createServer((req, res) => {
		const url = new URL(req.url, 'http://x');
		const file = path.join(ROOT, url.pathname === '/' ? 'tests/ui/wirasat-host.html' : decodeURIComponent(url.pathname));
		if (!file.startsWith(ROOT) || !fs.existsSync(file) || fs.statSync(file).isDirectory()) { res.writeHead(404).end(); return; }
		res.writeHead(200, { 'Content-Type': TYPES[path.extname(file)] || 'application/octet-stream' });
		fs.createReadStream(file).pipe(res);
	});
	await new Promise((r) => server.listen(0, '127.0.0.1', r));
	base = 'http://127.0.0.1:' + server.address().port + '/';
	browser = await chromium.launch();
});
test.after(async () => { await browser.close(); server.close(); });

const enc = (o) => Buffer.from(JSON.stringify(Object.assign({ v: 1, x: 'm', m: 'hanafi', n: '', d: '' }, o)), 'utf8').toString('base64').replace(/\+/g, '-').replace(/\//g, '_').replace(/=+$/, '');
const dec = (link) => JSON.parse(Buffer.from(link.split('#w=')[1].replace(/-/g, '+').replace(/_/g, '/'), 'base64').toString('utf8'));

async function open(hash = '', ctx) {
	ctx = ctx || await browser.newContext({ viewport: { width: 1100, height: 900 }, acceptDownloads: true });
	const page = await ctx.newPage();
	const errors = [];
	page.on('pageerror', (e) => errors.push(e.message));
	await page.goto(base + hash);
	const f = await (await page.waitForSelector('iframe.myzt-wirasat-frame')).contentFrame();
	await f.waitForSelector('#summary div');
	return { ctx, page, f, errors };
}
const rows = (f) => f.$$eval('#result > .tbl table tbody tr', (trs) => trs.map((tr) => [...tr.cells].map((td) => td.textContent.trim())));
const byName = (r) => Object.fromEntries(r.map((x) => [x[0], x]));

test('F1: a shared link is read once; a reload keeps the edits; "start my own case" empties the form', async () => {
	const { ctx, page, f, errors } = await open('#w=' + enc({ a: { cash: { amount: '160000' } }, p: [['father', 1, -1, ''], ['mother', 1, -1, ''], ['wife', 0, -1, ''], ['wife', 0, -1, ''], ['son', 0, -1, '']] }));
	assert.equal(page.url().includes('#w='), false, 'the link leaves the address');
	assert.equal(await f.isVisible('#origin'), true, 'shared-case note');
	await f.click('[data-step^="r-daughter-"][data-d="1"]');
	assert.equal(await f.isVisible('#origin'), false, 'an edited case is the user\'s own');
	await page.reload();
	const f2 = await (await page.waitForSelector('iframe.myzt-wirasat-frame')).contentFrame();
	await f2.waitForSelector('#summary div');
	assert.match(await f2.textContent('#summary'), /بیٹیاں1/, 'the added daughter survives the reload');
	await f2.click('#reset');
	assert.equal(await f2.isVisible('#origin'), true, 'example-case note');
	await f2.click('#originNew');
	assert.match(await f2.textContent('#summary'), /بیٹے0/);
	assert.deepEqual(errors, []);
	await ctx.close();
});

test('F1: a worked-example link on the same page opens that case', async () => {
	const { ctx, page, f } = await open();
	await page.evaluate((h) => { location.hash = h; }, 'w=' + enc({ a: { cash: { amount: '960000' } }, p: [['father', 1, -1, ''], ['mother', 1, -1, ''], ['wife', 0, -1, ''], ['son', 0, -1, ''], ['son', 1, -1, ''], ['grandson', 0, 4, ''], ['granddaughter', 0, 4, '']] }));
	await f.waitForSelector('#resultSec:not([hidden])');
	const r = byName(await rows(f));
	assert.equal(r['بیٹا 1'][1], '7/16');
	assert.equal(r['بیٹا 1'][2], 'Rs 4,20,000');
	assert.equal(page.url().includes('#w='), false);
	await ctx.close();
});

test('F4 + F5: a changed form locks the PDF, share, istifta and six-madhab tools; the link keeps the fiqh tab', async () => {
	const { ctx, f } = await open('#w=' + enc({ a: { cash: { amount: '100000' } }, p: [['father', 1, -1, ''], ['mother', 1, -1, ''], ['son', 0, -1, ''], ['son', 1, -1, ''], ['grandson', 0, 3, '']] }));
	await f.click('#view [data-v="fiqh"]');
	assert.equal(dec(await f.inputValue('#shLink')).w, 'fiqh');
	await f.click('[data-step^="r-wife-"][data-d="1"]');
	assert.equal(await f.isDisabled('#pdf'), true);
	assert.match(await f.textContent('#pdfMsg'), /دوبارہ حساب/);
	for (const sel of ['details.tool', '#view']) assert.equal(await f.$$eval('#result ' + sel, (e) => e.every((x) => x.inert)), true, sel + ' locked');
	await f.click('#go');
	assert.equal(await f.isDisabled('#pdf'), false);
	assert.equal(dec(await f.inputValue('#shLink')).p.filter((p) => p[0] === 'wife').length, 1, 'the link has the new wife');
	await ctx.close();
});

test('F6: debts, mehr and the will come out first, the will capped at a third; debts beyond the cash come from the land value', async () => {
	const { ctx, f } = await open('#w=' + enc({ d: '60000', l: '150000', a: { cash: { amount: '300000' } }, p: [['father', 1, -1, ''], ['mother', 1, -1, ''], ['son', 0, -1, '']] }));
	let r = byName(await rows(f));
	assert.equal(r['بیٹا'][2], 'Rs 1,60,000', '300000 - 60000 - will 80000 (a third of 240000)');
	assert.match(await f.textContent('#result'), /80,000/);
	const g = await open('#w=' + enc({ d: '80000', a: { cash: { amount: '50000' }, land: { kanal: '10', value: '300000' } }, p: [['father', 1, -1, ''], ['mother', 1, -1, ''], ['wife', 0, -1, ''], ['son', 0, -1, '']] }));
	r = byName(await rows(g.f));
	assert.equal(r['بیوی'][2], '1 کنال 2.5 مرلہ(22.5 مرلے)', 'Rs 30,000 of the debt from land worth 3 lakh: 9 kanal left');
	await ctx.close(); await g.ctx.close();
});

test("F7: Ja'fari: the wife gets no land but her share of the buildings' value", async () => {
	const { ctx, f } = await open('#w=' + enc({ m: 'jafari', a: { cash: { amount: '800000' }, land: { kanal: '1', value: '3000000', build: '1200000' } }, p: [['father', 1, -1, ''], ['mother', 1, -1, ''], ['wife', 0, -1, ''], ['son', 0, -1, ''], ['daughter', 0, -1, '']] }));
	const r = byName(await rows(f));
	assert.equal(r['بیوی'][2], '0 کنال 0 مرلہ(0 مرلے)');
	assert.equal(r['بیوی'][4], 'Rs 1,50,000', '1/8 of 12 lakh');
	assert.equal(r['بیٹا'][4], '—');
	assert.equal(await f.isVisible('#a-land-build'), true);
	await f.click('#madhab [data-v="hanafi"]');
	assert.equal(await f.isVisible('#a-land-build'), false, "only in Ja'fari mode");
	await ctx.close();
});

test('F8 + F12: equal shares get equal rupees; the marla size is a choice', async () => {
	const { ctx, f } = await open();
	await f.click('#reset');
	await f.click('#go');
	const r = byName(await rows(f));
	assert.equal(r['بیٹی 1'][3], r['بیٹی 2'][3]);
	assert.equal(r['بیٹی 1'][3], 'Rs 3,385');
	assert.ok((await f.textContent('#result')).includes('کسر سے بچی رقم'));
	assert.equal(await f.inputValue('#a-land-ft'), '272.25');
	await f.selectOption('#a-land-ft', '225');
	await f.fill('#a-land-foot', '10');
	await f.click('#go');
	assert.ok(byName(await rows(f))['بیوی'][2].includes('فٹ'));
	await ctx.close();
});

const ASK = [
	['Rs 20 lakh', 'A man died. Heirs: wife, two sons, three daughters, mother alive, father died before. Estate Rs 20 lakh and 4 kanal land', 'Rs 20,00,000'],
	['60 lakh', 'Man died, wife and 2 daughters, father and mother alive, 60 lakh', 'Rs 60,00,000'],
	['1 lakh 60 hazar', 'Ek aadmi fout hua, do biwiyan aur ek beta, tarka 1 lakh 60 hazar rupay', 'Rs 1,60,000'],
	['12 lakh cash', 'A man died leaving 2 sons and 1 daughter, 10 marla house and 12 lakh cash', 'Rs 12,00,000'],
	['Estate 160000', 'A man died. Heirs: two wives and one son. Estate 160000', 'Rs 1,60,000'],
];
for (const [name, text, cash] of ASK) {
	test('F2 parser money: ' + name, async () => {
		const { ctx, f } = await open();
		await f.fill('#askText', text);
		await f.click('#askGo');
		assert.ok((await f.textContent('#summary')).includes(cash), name);
		await ctx.close();
	});
}

test('F3: a son who died first and "left two sons" gives grandsons; "my father" warns', async () => {
	const { ctx, f } = await open();
	await f.fill('#askText', 'A man died. His son died before him and left two sons. Another son is alive. Estate Rs 300000');
	await f.click('#askGo');
	await f.click('#go');
	const r = byName(await rows(f));
	assert.equal(r['بیٹا 2'] && r['بیٹا 2'][1], '1/2', 'section 4 tab: the living son 1/2, the two sons of the late son 1/4 each');
	assert.ok((await f.textContent('#summary')).includes('نواسے نواسیاں2'));
	await f.click('#clear');
	await f.fill('#askText', 'My father passed away. He left 2 sons, 1 daughter and my mother.');
	await f.click('#askGo');
	assert.ok((await f.$$('#askOut .err')).length >= 1, 'first-person warning');
	await ctx.close();
});

test("F13: a question does not replace the user's own form without asking", async () => {
	const { ctx, f } = await open();
	await f.fill('#a-cash-amount', '500000');
	await f.click('[data-step^="r-son-"][data-d="1"]');
	await f.fill('#askText', 'ek aurat fout hui, shohar aur ek beti');
	await f.click('#askGo');
	assert.equal(await f.isVisible('#askYes'), true);
	await f.click('#askNo');
	assert.ok((await f.textContent('#summary')).includes('5,00,000'));
	await f.click('#askGo');
	await f.click('#askYes');
	assert.ok((await f.textContent('#summary')).includes('شوہر1'));
	// A form filled from a question and then changed by hand is the user's own: the next question asks again.
	await f.click('[data-step^="r-daughter-"][data-d="1"]');
	await f.fill('#askText', 'ek aadmi fout hua, biwi aur ek beta');
	await f.click('#askGo');
	assert.equal(await f.isVisible('#askYes'), true, 'asks after hand edits');
	await ctx.close();
});
