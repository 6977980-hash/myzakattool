// Urdu names in the PDF report are spelled in Roman letters, because the standard PDF fonts have
// no Urdu glyphs (audit FIX-055). Run: node --test tests/pdf.test.js
const test = require('node:test');
const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const vm = require('node:vm');

const src = fs.readFileSync(path.join(__dirname, '..', 'assets', 'js', 'pdf.js'), 'utf8');
const sandbox = { window: {}, document: {} };
vm.runInNewContext(src.replace('window.MYZT_PDF = { build: build };', 'window.MYZT_PDF = { build: build, latin: latin };'), sandbox);
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
