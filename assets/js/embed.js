/**
 * My Zakat Tool: embeddable nisab and gold rate box for other websites.
 *
 * <div data-myzt-embed data-currency="PKR"></div>
 * <script src="https://myzakattool.com/wp-content/plugins/myzakattool/assets/js/embed.js" async></script>
 */
(function () {
	'use strict';
	var TOLA = 11.6638038, OZ = 31.1034768;
	var script = document.currentScript;
	var base = script ? script.src.replace(/\/wp-content\/.*$/, '') : 'https://myzakattool.com';

	function fmt(v, cur) {
		try {
			return new Intl.NumberFormat(cur === 'PKR' || cur === 'INR' ? 'en-IN' : 'en', { style: 'currency', currency: cur, maximumFractionDigits: 0 }).format(Math.round(v));
		} catch (e) { return cur + ' ' + Math.round(v).toLocaleString(); }
	}

	function esc(s) { return String(s).replace(/[&<>"]/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]; }); }

	function render(el, r) {
		var cur = (el.getAttribute('data-currency') || 'PKR').toUpperCase();
		var fx = cur === 'USD' ? 1 : +(r.fx && r.fx[cur.toLowerCase()]);
		if (!r.goldUsdOz || !fx) { el.innerHTML = ''; return; }
		var g = r.goldUsdOz / OZ * fx, s = r.silverUsdOz / OZ * fx;
		var row = function (k, v, b) { return '<tr><td style="padding:4px 0;color:#5d736e">' + k + '</td><td style="padding:4px 0;text-align:right;font-weight:' + (b ? 700 : 600) + '">' + v + '</td></tr>'; };
		var when = r.updated ? new Date(r.updated * 1000).toLocaleString('en-GB', { day: 'numeric', month: 'short', hour: '2-digit', minute: '2-digit' }) : '';
		el.innerHTML = '<div style="font:14px/1.4 system-ui,-apple-system,Segoe UI,Roboto,sans-serif;color:#14302b;border:1px solid #dfe9e6;border-radius:12px;padding:14px 16px;max-width:360px;background:#fff">' +
			'<div style="font-weight:700;color:#0f766e;margin-bottom:6px">Nisab today (' + esc(cur) + ')</div>' +
			'<table style="width:100%;border-collapse:collapse">' +
			row('Silver nisab (52.5 tola)', fmt(s * TOLA * 52.5, cur), true) +
			row('Gold nisab (7.5 tola)', fmt(g * TOLA * 7.5, cur)) +
			row('Gold 24K per tola', fmt(g * TOLA, cur)) +
			row('Silver per tola', fmt(s * TOLA, cur)) +
			'</table><div style="font-size:11px;color:#5d736e;margin-top:6px">International rate' + (when ? ', updated ' + esc(when) : '') + '. Estimate only, not a fatwa.</div></div>';
	}

	function boot() {
		var els = document.querySelectorAll('[data-myzt-embed]');
		if (!els.length) return;
		fetch(base + '/wp-json/myzakattool/v1/rates', { credentials: 'omit' }).then(function (res) { return res.json(); }).then(function (r) {
			for (var i = 0; i < els.length; i++) render(els[i], r);
		}).catch(function () {});
	}

	if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot); else boot();
})();
