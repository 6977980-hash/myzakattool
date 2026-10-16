// The plugin header, the version constant and the installer must agree, or a deploy
// would not refresh pages and cached assets (?ver=). Run: node --test tests/version.test.js
const test = require('node:test');
const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');

const main = fs.readFileSync(path.join(__dirname, '..', 'myzakattool.php'), 'utf8');

test('plugin header Version equals MYZAKATTOOL_VERSION', () => {
	const header = main.match(/^\s*\*\s*Version:\s*(\S+)/m);
	const constant = main.match(/define\(\s*'MYZAKATTOOL_VERSION',\s*'([^']+)'\s*\)/);
	assert.ok(header && constant, 'both version strings found');
	assert.equal(header[1], constant[1]);
	assert.match(constant[1], /^\d+\.\d+\.\d+$/);
});
