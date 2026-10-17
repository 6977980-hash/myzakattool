// Builds the wirasat (inheritance) calculator page from one source.
//
//   src/wirasat/app.src.html  the page: layout, form, shajra, PDF report (edit this)
//   src/wirasat/ur.json       Urdu notes and reasons shown with the shares
//   assets/js/wirasat.js      the share engine (also used by the tests)
//
// Output: assets/wirasat/app.html, the page the [zakat_wirasat] shortcode shows in a frame.
// Commit it together with the source: Hostinger deploys the repository as it is, with no build step.
//
//   node tools/build-wirasat.js                       write assets/wirasat/app.html
//   node tools/build-wirasat.js --check               fail if app.html is out of date (CI)
//   node tools/build-wirasat.js --preview <file>      the stand-alone preview (Claude artifact) version
const fs = require('node:fs');
const path = require('node:path');

const ROOT = path.resolve(__dirname, '..');
const read = (f) => fs.readFileSync(path.join(ROOT, f), 'utf8');
const OUT = 'assets/wirasat/app.html';

function base() {
	return read('src/wirasat/app.src.html')
		.replace('/*ENGINE*/', () => read('assets/js/wirasat.js'))
		.replace('/*UR*/', () => read('src/wirasat/ur.json').trim());
}

// Site changes, each must match exactly once so a source edit cannot silently drop one.
const SITE = [
	['<title>Wirasat Shajra Prototype</title>', '<!doctype html>\n<html lang="ur" dir="rtl" data-theme="light">\n<meta charset="utf-8">\n<meta name="viewport" content="width=device-width, initial-scale=1">\n<meta name="robots" content="noindex">\n<title>وراثت کیلکولیٹر اور شجرہ</title>'],
	// The WordPress page has its own heading, and the frame sits on the page's white background.
	['[hidden] { display: none !important; }', '[hidden] { display: none !important; }\n.wrap > header { display: none; }\nhtml, body { margin: 0; background: transparent !important; }\n.wrap { padding-block: 4px 8px !important; }'],
	["var KEY = 'wirasat-proto-v3';", "var KEY = 'myzt_wirasat_v2'; // myzt_ prefix: \"Delete saved data\" on the site removes it"],
	['if (!st || !st.people) st = sample();', "if (!st || !st.people) { st = blank(); var qm = (location.search.match(/[?&]madhab=(\\w+)/) || [])[1]; if (qm && MADHABS.some(function (m) { return m[0] === qm; })) st.madhab = qm; }"],
	["one('https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js'), one('https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js')", "one('../vendor/html2canvas.min.js?ver=1.4.1'), one('../vendor/jspdf.umd.min.js?ver=4.2.1')"],
];

// Tells the page around the frame how tall the calculator is, so there is no inner scrollbar.
const RESIZE = `<script>
(function () {
  if (window.parent === window) return;
  var last = 0;
  function send() { var h = Math.ceil(document.documentElement.getBoundingClientRect().height); if (h !== last) { last = h; window.parent.postMessage({ myztWirasatHeight: h }, '*'); } }
  if (window.ResizeObserver) new ResizeObserver(send).observe(document.documentElement);
  window.addEventListener('load', send); send();
})();
</script>
`;

function site() {
	let s = base();
	for (const [a, b] of SITE) {
		const n = s.split(a).length - 1;
		if (n !== 1) throw new Error('build-wirasat: expected one match, found ' + n + ': ' + a.slice(0, 60));
		s = s.replace(a, () => b);
	}
	return '<!-- Built by tools/build-wirasat.js from src/wirasat/. Do not edit; edit the source and rebuild. -->\n' + s + RESIZE;
}

if (require.main === module) {
	const args = process.argv.slice(2);
	if (args[0] === '--preview') {
		fs.writeFileSync(args[1], base());
		console.log('wrote ' + args[1]);
	} else if (args[0] === '--check') {
		const now = fs.existsSync(path.join(ROOT, OUT)) ? read(OUT) : '';
		if (now !== site()) {
			console.error(OUT + ' is out of date: run node tools/build-wirasat.js and commit it.');
			process.exit(1);
		}
		console.log(OUT + ' is up to date');
	} else {
		fs.writeFileSync(path.join(ROOT, OUT), site());
		console.log('wrote ' + OUT);
	}
}

module.exports = { site, base };
