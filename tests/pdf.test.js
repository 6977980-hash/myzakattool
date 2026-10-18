// Urdu names in the PDF report are spelled in Roman letters, because the standard PDF fonts have
// no Urdu glyphs (audit FIX-055). Run: node --test tests/pdf.test.js
const test = require('node:test');
const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const vm = require('node:vm');

const src = fs.readFileSync(path.join(__dirname, '..', 'assets', 'js', 'pdf.js'), 'utf8');
const calls = [];
function FakeDoc() {
	this.pages = 1;
	['setFont', 'setFontSize', 'setTextColor', 'setDrawColor', 'setLineWidth', 'line', 'setPage'].forEach((m) => { this[m] = () => {}; });
	this.text = (s) => calls.push(['text', s]);
	this.splitTextToSize = (s) => [s];
	this.getNumberOfPages = () => this.pages;
	this.addPage = () => { this.pages++; };
	this.save = (name) => calls.push(['save', name]);
}
const sandbox = { window: { jspdf: { jsPDF: FakeDoc } }, document: {}, location: { href: 'https://myzakattool.com/fitrana-calculator/#x' } };
vm.runInNewContext(src.replace('window.MYZT_PDF = { build: build, simple: simple };', 'window.MYZT_PDF = { build: build, simple: simple, latin: latin };'), sandbox);
const latin = sandbox.window.MYZT_PDF.latin;

test('Urdu names come out in Roman letters, not blank', () => {
	assert.equal(latin('علی احمد'), 'Ali Ahmd');
	assert.equal(latin('فاطمہ'), 'Fatma');
	assert.equal(latin('عائشہ'), 'Aisha');
	assert.equal(latin('وسیم'), 'Wsim');
});

test('Urdu digits become 0-9; Latin text is unchanged apart from accents', () => {
	assert.equal(latin('۱۲۳ Ali'), '123 Ali');
	assert.equal(latin('Zoë'), 'Zoe');
	assert.equal(latin('Rs 25,000'), 'Rs 25,000');
});

test('small-tool PDF prints the fields and results it is given (FIX-126)', async () => {
	await sandbox.window.MYZT_PDF.simple({ title: 'Fitrana (Sadaqat al-Fitr)', inputs: [['People', '5']], results: [['Total fitrana', 'Rs 1,500', true]] });
	const texts = calls.filter((c) => c[0] === 'text').map((c) => c[1]);
	assert.ok(texts.includes('Fitrana (Sadaqat al-Fitr) (Personal Record)'));
	assert.ok(texts.includes('People') && texts.includes('5') && texts.includes('Rs 1,500'));
	assert.ok(texts.some((t) => t.includes('Not a fatwa')));
	assert.ok(texts.includes('Source page: https://myzakattool.com/fitrana-calculator/'));
	assert.match(calls.find((c) => c[0] === 'save')[1], /^fitrana-sadaqat-al-fitr-\d{4}-\d{2}-\d{2}\.pdf$/);
});
