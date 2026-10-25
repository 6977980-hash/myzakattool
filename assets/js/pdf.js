/**
 * My Zakat Tool: PDF report, built entirely in the browser (jsPDF is loaded only when needed).
 * The report is mostly the user's own data; our notices stay small, in the footer.
 */
(function () {
	'use strict';

	var CFG = window.MYZT || {};
	// QR code for https://myzakattool.com/disclaimer/ (precomputed, so no QR library is shipped).
	var QR = ["11111110101101110010001111111","10000010100101110001001000001","10111010100101100000101011101","10111010011100111111101011101","10111010100011010011001011101","10000010011101100000101000001","11111110101010101010101111111","00000000000110111000100000000","10011111100001101101010010111","00101101010110111011000110110","11110111101000110100111010100","01010000011100111111110111001","01000011000001110000101100001","11011000010000011110101111111","11101110010100110011011000101","00111101001011100000011000101","01101010100000010001100001000","11101000000110010101110010110","11110010111101110011001011001","11111101110101001000000001100","11000011010011001100111111110","00000000100101010010100011000","11111110110001011011101011000","10000010111001001101100010010","10111010100101001001111111011","10111010111001111110010100001","10111010001110010000100110111","10000010011100101010011111101","11111110110011010001110000000"];

	var LABELS = {
		cash: 'Cash at home', prizeBonds: 'Prize bonds', savingsCerts: 'Savings certificates (NSC, Behbood etc.)', bank: 'Bank balance', businessCash: 'Business cash',
		stock: 'Stock / inventory', shares: 'Shares / mutual funds', crypto: 'Crypto', committee: 'Committee (BC) paid in',
		receivables: 'Money owed to you', receivablesDoubtful: 'Doubtful debts owed to you (not counted)', plot: 'Plot / property for sale', other: 'Other trade goods',
		debts: 'Debts due now', installments: 'Instalments (next 12 months)', bills: 'Unpaid bills', suppliers: 'Unpaid supplier bills',
		goldWorn: 'Gold jewellery (worn)', goldKept: 'Gold (kept)', silverWorn: 'Silver jewellery (worn)', silverKept: 'Silver (kept)',
	};

	var PAID = { bankDeducted: 'Zakat deducted by bank (already paid)', paidAlready: 'Zakat already paid this year' };

	var loading = null;
	function loadJsPdf() {
		if (window.jspdf) return Promise.resolve(window.jspdf);
		if (loading) return loading;
		loading = new Promise(function (resolve, reject) {
			var s = document.createElement('script');
			s.src = CFG.jspdfUrl;
			s.async = true;
			s.onload = function () { window.jspdf ? resolve(window.jspdf) : reject(new Error('jsPDF')); };
			s.onerror = reject;
			document.head.appendChild(s);
		});
		return loading;
	}

	/*
	 * Urdu letters spelled out in Roman Urdu, so an Urdu name such as "علی" prints as "Ali" instead of
	 * vanishing: the standard PDF fonts have no Urdu glyphs (FIX-055). Short vowels are not written in
	 * Urdu, so the spelling is approximate; vowel marks, where present, are dropped.
	 */
	var UR = {
		'ا': 'a', 'آ': 'aa', 'أ': 'a', 'إ': 'i', 'ب': 'b', 'پ': 'p', 'ت': 't', 'ٹ': 't', 'ث': 's', 'ج': 'j', 'چ': 'ch', 'ح': 'h', 'خ': 'kh',
		'د': 'd', 'ڈ': 'd', 'ذ': 'z', 'ر': 'r', 'ڑ': 'r', 'ز': 'z', 'ژ': 'zh', 'س': 's', 'ش': 'sh', 'ص': 's', 'ض': 'z', 'ط': 't', 'ظ': 'z',
		'ع': '', 'غ': 'gh', 'ف': 'f', 'ق': 'q', 'ک': 'k', 'ك': 'k', 'گ': 'g', 'ل': 'l', 'م': 'm', 'ن': 'n', 'ں': 'n', 'و': 'o', 'ؤ': 'o',
		'ہ': 'h', 'ۂ': 'h', 'ھ': 'h', 'ة': 'h', 'ۃ': 'h', 'ی': 'i', 'ي': 'i', 'ى': 'a', 'ئ': 'i', 'ے': 'e', 'ۓ': 'e', 'ء': '',
		'،': ',', '۔': '.', '؟': '?', '٫': '.', '٬': ',',
	};
	function roman(s) {
		if (!/[\u0600-\u06ff]/.test(s)) return s;
		s = s.replace(/[\u064b-\u065f\u0670]/g, '').replace(/[\u0660-\u0669\u06f0-\u06f9]/g, function (d) {
			return String(d.charCodeAt(0) & 15);
		});
		return s.replace(/[\u0600-\u06ff]+/g, function (w) {
			var r = '';
			for (var i = 0; i < w.length; i++) {
				var c = w.charAt(i), first = i === 0, last = i === w.length - 1;
				if (first && c === 'ع') { r += 'a'; if (w.charAt(1) === 'ا') i++; }
				else if (first && c === 'و') r += 'w'; // wasim
				else if (first && c === 'ی') r += 'y'; // yusuf
				else if (last && i > 0 && (c === 'ہ' || c === 'ة' || c === 'ۃ')) r += 'a'; // fatima, aisha
				else r += UR[c] != null ? UR[c] : '';
			}
			return r.charAt(0).toUpperCase() + r.slice(1);
		});
	}

	/** Standard PDF fonts cover Latin-1 only: spell out Urdu, drop accents and replace anything else. */
	function latin(s) {
		return roman(String(s)).normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/[\u02bb\u02bc\u2018\u2019]/g, "'").replace(/[^\x20-\x7e\xa0-\xff]/g, '');
	}

	function fmt(v, cur) {
		var loc = /^(PKR|INR|BDT|NPR|LKR)$/.test(cur) ? 'en-IN' : 'en-US';
		var n = new Intl.NumberFormat(loc, { maximumFractionDigits: 0 }).format(Math.round(v || 0));
		return (v < 0 ? '- ' : '') + cur + ' ' + n.replace('-', '');
	}

	function dates() {
		var d = new Date();
		var g = d.toLocaleDateString('en-GB', { day: 'numeric', month: 'long', year: 'numeric' });
		var h = '';
		try { h = new Intl.DateTimeFormat('en-u-ca-islamic-umalqura', { day: 'numeric', month: 'long', year: 'numeric' }).format(d); } catch (e) {}
		return { g: g, h: h };
	}

	function build(data) {
		return loadJsPdf().then(function (lib) {
			var doc = new lib.jsPDF({ unit: 'mm', format: 'a4' });
			var W = 210, M = 16, y = 18, cur = data.currency;
			var teal = [15, 118, 110], ink = [20, 48, 43], mute = [110, 130, 125];
			var dt = dates();

			function color(c) { doc.setTextColor(c[0], c[1], c[2]); }
			function text(s, x, yy, size, bold, c, align) {
				doc.setFont('helvetica', bold ? 'bold' : 'normal');
				doc.setFontSize(size);
				color(c || ink);
				doc.text(latin(s), x, yy, align ? { align: align } : undefined);
			}
			function line(yy) { doc.setDrawColor(223, 233, 230); doc.setLineWidth(0.3); doc.line(M, yy, W - M, yy); }
			function space(h) { if (y + h > 268) { doc.addPage(); y = 18; } }
			function row(label, value, bold, c) {
				space(7);
				text(label, M + 2, y, 10, bold, c);
				text(value, W - M - 2, y, 10, bold, c, 'right');
				y += 2.5; line(y); y += 4.5;
			}

			// Header.
			text('My Zakat Tool', M, y, 9, true, teal);
			text(dt.g + (dt.h ? '  ·  ' + dt.h : ''), W - M, y, 9, false, mute, 'right');
			y += 9;
			text('Zakat Estimate (Personal Record)', M, y, 17, true);
			y += 7;
			var meta = [];
			if (data.name) meta.push('Name: ' + data.name);
			meta.push('Madhab: ' + data.madhab);
			meta.push('Currency: ' + cur);
			text(meta.join('   ·   '), M, y, 10, false, ink);
			y += 8;

			// Summary box.
			var total = 0, anyDue = false, allKhums = true;
			var paidAll = 0;
			data.persons.forEach(function (p) { total += p.result.payable; paidAll += p.result.paid || 0; anyDue = anyDue || p.result.due; allKhums = allKhums && !!p.result.khums; });
			doc.setDrawColor(teal[0], teal[1], teal[2]);
			doc.setFillColor(230, 244, 241);
			doc.setLineWidth(0.5);
			doc.roundedRect(M, y, W - 2 * M, 24, 3, 3, 'FD');
			text((paidAll ? 'Zakat still to pay' : 'Total zakat') + (data.persons.length > 1 ? ' (family)' : ''), M + 6, y + 8, 10, false, mute);
			text(fmt(total, cur), M + 6, y + 18, 20, true, teal);
			// Ja'fari: no zakat on these assets at all, so "below nisab" would be wrong (FIX-011).
			var status = anyDue ? 'Above nisab: zakat is due' : allKhums ? 'No zakat on these assets (Sistani): see khums' : 'Below nisab: zakat is not due';
			text(status, W - M - 6, y + 14, 10, true, anyDue ? [30, 122, 60] : mute, 'right');
			y += 32;

			data.persons.forEach(function (p) {
				var r = p.result, inp = p.input;
				space(30);
				if (data.persons.length > 1) { text(p.name, M, y, 12, true, teal); y += 7; }
				text('What you entered', M, y, 11, true); y += 6;
				var money = inp.money || {}, liab = inp.liabilities || {};
				Object.keys(money).forEach(function (k) { if (money[k]) row(LABELS[k] || k, fmt(money[k], cur)); });
				['goldWorn', 'goldKept', 'silverWorn', 'silverKept'].forEach(function (k) {
					var entry = inp[k];
					if (!entry || !entry.weight) return;
					// Several pieces with their own karat are listed one by one (FIX-225).
					(entry.pieces || [entry]).forEach(function (m) {
						var gold = k.indexOf('gold') === 0, fine = m.fineness && m.fineness < 999 ? m.fineness : 0;
						var price = gold ? data.prices.gold * (m.karat || 24) / 24 : data.prices.silver * (fine ? fine / 1000 : 1);
						var grams = m.unit === 'tola' ? m.weight * 11.6638038 : m.unit === 'oz' ? m.weight * 31.1034768 : m.weight;
						var desc = m.weight + ' ' + (m.unit === 'gram' ? 'g' : m.unit) + (gold ? ' ' + (m.karat || 24) + 'K' : fine ? ' ' + fine : '');
						row(LABELS[k] + ' (' + desc + ')', fmt(grams * price, cur));
					});
				});
				Object.keys(liab).forEach(function (k) { if (liab[k] && !PAID[k]) row(LABELS[k] || k, fmt(-liab[k], cur)); });
				Object.keys(PAID).forEach(function (k) { if (liab[k]) row(PAID[k], fmt(liab[k], cur)); });

				y += 2; space(30);
				text('How it was calculated', M, y, 11, true); y += 6;
				if (r.khums) {
					doc.setFontSize(9.5); color(ink);
					var kt = doc.splitTextToSize("Ja'fari fiqh (Ayatollah Sistani): zakat is due only on gold and silver coins used as currency, so cash, bank money and jewellery carry no zakat. Khums (20% of the yearly surplus) may apply instead.", W - 2 * M - 4);
					doc.text(kt, M + 2, y); y += kt.length * 4.5 + 3;
				} else {
					r.lines.forEach(function (l) {
						if (!l.value) return;
						var name = { money: 'Cash, bank and trade wealth', goldKept: 'Gold (kept)', goldWorn: 'Gold jewellery (worn)', silverKept: 'Silver (kept)', silverWorn: 'Silver jewellery (worn)', debts: 'Debts deducted' }[l.key] || l.key;
						row(name + (l.included ? '' : '  (not counted in this madhab)'), fmt(l.value, cur), false, l.included ? ink : mute);
					});
					row('Zakatable wealth', fmt(r.zakatable, cur), true);
					row('Nisab used (' + (r.nisabBasis === 'gold' ? 'gold 87.48 g' : 'silver 612.35 g') + ')', fmt(r.nisab, cur));
					row(r.due ? 'Zakatable wealth x 2.5% = Zakat' : 'Below nisab, so zakat', fmt(r.zakat, cur), true, r.paid ? ink : teal);
					if (r.paid) {
						row('Already paid / deducted by bank', fmt(-r.paid, cur));
						row('Zakat still to pay', fmt(r.payable, cur), true, teal);
					}
					space(10);
					doc.setFont('helvetica', 'normal'); doc.setFontSize(8.5); color(mute);
					var f = doc.splitTextToSize('Formula: cash, bank, business stock, money owed to you and other zakatable assets are added to the value of gold and silver. Whether worn jewellery counts, and whether gold, silver and cash are pooled or checked against their own nisab, follows this madhab\'s rule. Debts are deducted only where this madhab allows it. If the zakatable wealth reaches the nisab, zakat = 2.5% of it.', W - 2 * M - 4);
					doc.text(f, M + 2, y); y += f.length * 3.8 + 4;
				}
			});

			// Rates used.
			space(22);
			text('Rates used', M, y, 11, true); y += 6;
			var gram = data.prices.gold, tola = gram * 11.6638038;
			row('Gold 24K', fmt(gram, cur) + ' / g   ·   ' + fmt(tola, cur) + ' / tola');
			row('Silver', fmt(data.prices.silver, cur) + ' / g   ·   ' + fmt(data.prices.silver * 11.6638038, cur) + ' / tola');
			row('Nisab', 'silver ' + fmt(data.nisab.silver, cur) + '   ·   gold ' + fmt(data.nisab.gold, cur));
			var src = data.own ? 'Your own local rate' : ('International spot rate' + (data.source ? ' (' + data.source + ')' : '') + (data.updated ? ', ' + new Date(data.updated * 1000).toLocaleString('en-GB') : ''));
			text('Source: ' + src, M + 2, y, 8.5, false, mute); y += 6;

			// Footer on every page: one small notice line and the QR code.
			var pages = doc.getNumberOfPages();
			for (var i = 1; i <= pages; i++) {
				doc.setPage(i);
				line(279);
				text('Personal estimate only. Not an official, legal or religious document. Not a fatwa.', M, 284, 7.5, false, mute);
				text('Details: myzakattool.com/disclaimer  ·  Madhab rules: myzakattool.com/methodology  ·  Page ' + i + '/' + pages, M, 288, 7.5, false, mute);
				var s = 0.55, qx = W - M - QR.length * s, qy = 281.5;
				doc.setFillColor(20, 48, 43);
				for (var r = 0; r < QR.length; r++) for (var c = 0; c < QR[r].length; c++) if (QR[r][c] === '1') doc.rect(qx + c * s, qy + r * s, s, s, 'F');
			}

			var fname = 'zakat-estimate-' + new Date().toISOString().slice(0, 10) + '.pdf';
			doc.save(fname);
		});
	}

	/** One-page record for the small tools (fitrana, fidya, khums, hawl, ushr, mehr, diyat): fields and results (FIX-126). */
	function simple(data) {
		return loadJsPdf().then(function (lib) {
			var doc = new lib.jsPDF({ unit: 'mm', format: 'a4' });
			var W = 210, M = 16, y = 18;
			var teal = [15, 118, 110], ink = [20, 48, 43], mute = [110, 130, 125];
			var dt = dates();
			function text(s, x, yy, size, bold, c, align) {
				doc.setFont('helvetica', bold ? 'bold' : 'normal');
				doc.setFontSize(size);
				doc.setTextColor(c[0], c[1], c[2]);
				doc.text(latin(s), x, yy, align ? { align: align } : undefined);
			}
			function line(yy) { doc.setDrawColor(223, 233, 230); doc.setLineWidth(0.3); doc.line(M, yy, W - M, yy); }
			function row(r) {
				if (y > 266) { doc.addPage(); y = 18; }
				doc.setFont('helvetica', 'normal'); doc.setFontSize(10);
				var label = doc.splitTextToSize(latin(r[0]), 110);
				text(label[0], M + 2, y, 10, r[2], r[2] ? teal : ink);
				text(r[1], W - M - 2, y, 10, true, r[2] ? teal : ink, 'right');
				y += 2.5; line(y); y += 4.5;
			}
			text('My Zakat Tool', M, y, 9, true, teal);
			text(dt.g + (dt.h ? '  ·  ' + dt.h : ''), W - M, y, 9, false, mute, 'right');
			y += 9;
			text(data.title + ' (Personal Record)', M, y, 16, true, ink);
			y += 10;
			[['What you entered', data.inputs], ['Result', data.results]].forEach(function (sec) {
				if (!sec[1].length) return;
				text(sec[0], M, y, 11, true, ink); y += 6;
				sec[1].forEach(row);
				y += 4;
			});
			text('Source page: ' + location.href.split('#')[0], M, y, 8.5, false, mute);
			var pages = doc.getNumberOfPages();
			for (var i = 1; i <= pages; i++) {
				doc.setPage(i);
				line(279);
				text('Personal estimate only. Not an official, legal or religious document. Not a fatwa.', M, 284, 7.5, false, mute);
				text('Details: myzakattool.com/disclaimer  ·  Page ' + i + '/' + pages, M, 288, 7.5, false, mute);
			}
			doc.save(data.title.toLowerCase().replace(/[^a-z]+/g, '-').replace(/^-|-$/g, '') + '-' + new Date().toISOString().slice(0, 10) + '.pdf');
		});
	}

	window.MYZT_PDF = { build: build, simple: simple };
})();
