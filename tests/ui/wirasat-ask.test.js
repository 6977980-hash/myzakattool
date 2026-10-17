// Browser test for "سوال سے حساب" on the wirasat page: a question typed in Urdu or Roman Urdu fills the
// form, and the calculate button gives the expected shares. Run: npm run test:ui
// Expected shares are Hanafi (or the madhab named in the question), checked by hand against the rules.
const test = require('node:test');
const assert = require('node:assert/strict');
const http = require('node:http');
const fs = require('node:fs');
const path = require('node:path');
const { chromium } = require('playwright');

const ROOT = path.resolve(__dirname, '../..');
const CASES = 
[
	{ name: 'Ali ka sawal (Urdu, bullets)', text: 'ایک عورت فوت ہوئی۔ ورثاء:\n\n* شوہر\n* ماں\n* دو حقیقی بہنیں\n* ایک اخیافی بھائی\n* ایک اخیافی بہن\n* والد موجود نہیں، اولاد نہیں', expect: { 'شوہر': '3/10', 'والدہ': '1/10', 'سگی بہن 1': '1/5', 'سگی بہن 2': '1/5', 'ماں شریک بھائی': '1/10', 'ماں شریک بہن': '1/10' } },
	{ name: 'Wahi sawal Roman Urdu mein', text: 'ek aurat fout hui. waris: shohar, maa, do haqeeqi behnen, ek akhyafi bhai aur ek akhyafi behn. walid nahi, aulad nahi', expect: { 'شوہر': '3/10', 'والدہ': '1/10', 'سگی بہن 1': '1/5', 'ماں شریک بھائی': '1/10', 'ماں شریک بہن': '1/10' } },
	{ name: 'Aadmi, biwi, 2 betay 3 betiyan, tarka', text: 'ek aadmi fout hua, biwi, 2 betay aur 3 betiyan, walida zinda, walid pehle fout. tarka 20 lakh rupay aur 4 kanal zameen', expect: { 'بیوی': '1/8', 'والدہ': '1/6', 'بیٹا 1': '17/84', 'بیٹی 1': '17/168' } },
	{ name: 'Walidain aur ek beti', text: 'Ek shakhs ka inteqal hua. Waris: walidain zinda, ek beti.', expect: { 'والد': '1/3', 'والدہ': '1/6', 'بیٹی': '1/2' } },
	{ name: 'Bewa, teen betiyan, saga bhai', text: 'مرحوم کی بیوہ، تین بیٹیاں، اور ایک سگا بھائی ہے', expect: { 'بیوی': '1/8', 'بیٹی 1': '2/9', 'سگا بھائی': '5/24' } },
	{ name: 'Na-maloom rishta (khala)', text: 'ایک آدمی فوت ہوا، بیوی، ایک بیٹا، اور ایک خالہ', expect: { 'بیوی': '1/8', 'بیٹا': '7/8' }, unknown: true },
	{ name: 'Shafi\'i maslak + dada aur bhai', text: 'ek mard fout hua, shafi maslak. dada zinda, do sagay bhai, walid pehle fout ho gaye', expect: { 'دادا': '1/3', 'سگا بھائی 1': '1/3' } },
];

let server, base, browser, page, f;

test.before(async () => {
	server = http.createServer((req, res) => {
		const url = new URL(req.url, 'http://x');
		const file = path.join(ROOT, url.pathname === '/' ? 'tests/ui/wirasat-host.html' : decodeURIComponent(url.pathname));
		if (!file.startsWith(ROOT) || !fs.existsSync(file) || fs.statSync(file).isDirectory()) {
			res.writeHead(404).end();
			return;
		}
		res.writeHead(200, { 'Content-Type': file.endsWith('.html') ? 'text/html; charset=utf-8' : file.endsWith('.css') ? 'text/css' : 'text/javascript' });
		fs.createReadStream(file).pipe(res);
	});
	await new Promise((r) => server.listen(0, '127.0.0.1', r));
	base = 'http://127.0.0.1:' + server.address().port + '/';
	browser = await chromium.launch();
	page = await browser.newPage({ viewport: { width: 1100, height: 900 } });
	await page.route(/fonts\.(googleapis|gstatic)\.com/, (r) => r.abort());
	await page.goto(base);
	f = await (await page.waitForSelector('iframe.myzt-wirasat-frame')).contentFrame();
	await f.waitForSelector('#askGo');
});

test.after(async () => {
	await browser.close();
	server.close();
});

for (const c of CASES) {
	test(c.name, async () => {
		await f.fill('#askText', c.text);
		await f.click('#askGo');
		await f.click('#go');
		await f.waitForSelector('#resultSec:not([hidden])');
		const rows = await f.$$eval('#result table tr', (trs) => trs.map((tr) => [...tr.querySelectorAll('td')].map((td) => td.textContent.trim())).filter((r) => r.length));
		const got = {};
		rows.forEach((r) => { got[r[0]] = r[1]; });
		for (const [who, share] of Object.entries(c.expect)) assert.equal(got[who], share, who);
		const unknown = await f.$$eval('#askOut .err', (e) => e.length);
		assert.equal(unknown > 0, !!c.unknown, 'parts it did not understand are shown, and only those');
	});
}
