/**
 * My Zakat Tool: inheritance (wirasat / mirath) engine.
 *
 * Pure functions, no DOM. Runs in the browser (window.MYZT_WIRASAT) and in Node (tests).
 * Exact fractions throughout, so the shares always add up to the whole estate.
 *
 * Sunni schools: the Qur'anic shares (al-Nisa 4:11, 4:12, 4:176), the residuaries (asaba),
 * blocking (hajb), 'awl and radd as in al-Sirajiyyah (Hanafi), with the known differences of the
 * other schools: the grandfather with brothers (Zayd ibn Thabit's view for Shafi'i, Maliki and
 * Hanbali), al-mushtaraka (Shafi'i, Maliki), the paternal grandmother with the father (Hanbali).
 * Shia Ja'fari: the three classes (tabaqat) as in Ayatollah Sistani's Islamic Laws.
 * Pakistan option: Muslim Family Laws Ordinance 1961, section 4 (orphaned grandchildren).
 */
(function (root, factory) {
	if (typeof module === 'object' && module.exports) {
		module.exports = factory();
	} else {
		root.MYZT_WIRASAT = factory();
	}
})(typeof self !== 'undefined' ? self : this, function () {
	'use strict';

	/* ---------- exact fractions ---------- */

	function gcd(a, b) {
		a = Math.abs(a); b = Math.abs(b);
		while (b) { var t = a % b; a = b; b = t; }
		return a || 1;
	}
	function Q(n, d) {
		if (d === undefined) d = 1;
		if (d < 0) { n = -n; d = -d; }
		var g = gcd(n, d);
		return { n: n / g, d: d / g };
	}
	function add(a, b) { return Q(a.n * b.d + b.n * a.d, a.d * b.d); }
	function sub(a, b) { return Q(a.n * b.d - b.n * a.d, a.d * b.d); }
	function mul(a, b) { return Q(a.n * b.n, a.d * b.d); }
	function div(a, b) { return Q(a.n * b.d, a.d * b.n); }
	function cmp(a, b) { return a.n * b.d - b.n * a.d; }
	function max(a, b) { return cmp(a, b) >= 0 ? a : b; }
	function isZero(a) { return a.n === 0; }
	function val(a) { return a.n / a.d; }
	var ZERO = Q(0), ONE = Q(1);
	function sum(list) { return list.reduce(function (s, x) { return add(s, x); }, ZERO); }

	/* ---------- relations ---------- */

	// sex, and the relation the person must hang from (parent) when there is one.
	var REL = {
		husband: { sex: 'm' }, wife: { sex: 'f' },
		father: { sex: 'm' }, mother: { sex: 'f' },
		dada: { sex: 'm' }, dadi: { sex: 'f' }, nana: { sex: 'm' }, nani: { sex: 'f' },
		son: { sex: 'm' }, daughter: { sex: 'f' },
		grandson: { sex: 'm', parent: ['son', 'daughter'] }, granddaughter: { sex: 'f', parent: ['son', 'daughter'] },
		brother: { sex: 'm' }, sister: { sex: 'f' },
		pbrother: { sex: 'm' }, psister: { sex: 'f' },
		mbrother: { sex: 'm' }, msister: { sex: 'f' },
		nephew: { sex: 'm', parent: ['brother', 'sister', 'pbrother', 'psister', 'mbrother', 'msister'] },
		niece: { sex: 'f', parent: ['brother', 'sister', 'pbrother', 'psister', 'mbrother', 'msister'] },
		chacha: { sex: 'm' }, phuphi: { sex: 'f' }, mamu: { sex: 'm' }, khala: { sex: 'f' },
		cousin: { sex: 'm', parent: ['chacha'] },
	};
	var SINGLE = ['husband', 'father', 'mother', 'dada', 'dadi', 'nana', 'nani'];
	var MADHABS = ['hanafi', 'shafii', 'maliki', 'hanbali', 'ahlehadith', 'jafari'];

	// Where each share comes from (shown next to the share).
	var REFS = {
		husband: "Qur'an 4:12", wife: "Qur'an 4:12", father: "Qur'an 4:11", mother: "Qur'an 4:11",
		daughters: "Qur'an 4:11", children: "Qur'an 4:11", uterine: "Qur'an 4:12", sisters: "Qur'an 4:176",
		grandmother: 'Abu Dawud 2894 (1/6 to the grandmother)', sondaughter: 'Bukhari 6736 (1/6 with one daughter)',
		maalGhayr: 'Bukhari 6736 (sisters with daughters take the rest)', asaba: 'Bukhari 6732 (the rest to the nearest male relative)',
		umariyyatan: 'Umar and Zayd ibn Thabit, al-Umariyyatan', mushtaraka: 'Umar, al-Mushtaraka (Shafi\'i, Maliki)',
		akdariyya: 'Zayd ibn Thabit, al-Akdariyya', muqasama: 'Zayd ibn Thabit (grandfather with brothers)',
		radd: 'Radd: the remainder returns to the sharers', awl: "'Awl: shares reduced in proportion",
		dhawi: 'Dhawi al-arham: relatives through women, when no sharer or residuary is left',
		sec4: 'Muslim Family Laws Ordinance 1961, s. 4', jafariClass: 'Ayatollah Sistani, Islamic Laws (inheritance)',
		rep: 'Takes the share of the parent who died first',
	};

	function heirs(persons) {
		return persons.filter(function (p) { return p.status !== 'before'; });
	}

	/**
	 * Builds the units that inherit. A unit is one person, or a predeceased child (or sibling, or
	 * uncle) whose share passes to their own children ("by representation"), used for the Pakistani
	 * law option and for Ja'fari fiqh.
	 */
	function byId(persons) {
		var m = {};
		persons.forEach(function (p) { m[p.id] = p; });
		return m;
	}
	function kidsOf(persons, id) {
		return persons.filter(function (p) { return p.parent === id && p.status !== 'before'; });
	}

	/* ---------- result helpers ---------- */

	function Result(persons) {
		var r = { shares: {}, notes: [], awl: false, radd: false, unassigned: ZERO };
		persons.forEach(function (p) { r.shares[p.id] = { f: ZERO, why: null, ref: null, blocked: null }; });
		return r;
	}
	function give(r, ids, f, why, ref) {
		if (!ids.length) return;
		var each = div(f, Q(ids.length));
		ids.forEach(function (id) {
			var s = r.shares[id];
			s.f = add(s.f, each);
			if (!s.why) { s.why = why; s.ref = ref || REFS[why] || null; }
		});
	}
	// Male twice female: units carry their own sex.
	function give21(r, units, f, why, ref, equal) {
		var w = units.reduce(function (s, u) { return s + (equal ? 1 : u.sex === 'm' ? 2 : 1); }, 0);
		if (!w) return;
		units.forEach(function (u) {
			var part = mul(f, Q(equal ? 1 : u.sex === 'm' ? 2 : 1, w));
			giveUnit(r, u, part, why, ref);
		});
	}
	function giveUnit(r, u, part, why, ref) {
		if (u.members) {
			// A predeceased relative: the share goes to their children, sons twice daughters.
			r.shares[u.id].why = 'passed';
			r.shares[u.id].pass = part;
			give21(r, u.members.map(function (m) { return { id: m.id, sex: REL[m.rel].sex }; }), part, 'rep', ref ? ref + '; ' + REFS.rep : REFS.rep, u.equal);
		} else {
			give(r, [u.id], part, why, ref);
		}
	}
	function block(r, list, by) {
		list.forEach(function (p) {
			var s = r.shares[p.id || p];
			if (s && isZero(s.f) && !s.why && !s.blocked) s.blocked = by;
		});
	}
	function unit(p) { return { id: p.id, sex: REL[p.rel].sex, rel: p.rel }; }

	/* ---------- Sunni schools ---------- */

	function sunni(persons, opt) {
		var madhab = opt.madhab;
		var zayd = madhab === 'shafii' || madhab === 'maliki' || madhab === 'hanbali';
		var r = Result(persons);
		var H = heirs(persons);
		var map = byId(persons);
		function of(rel) { return H.filter(function (p) { return p.rel === rel; }); }

		var husband = opt.deceasedSex === 'f' ? of('husband') : [];
		var wives = opt.deceasedSex === 'm' ? of('wife').slice(0, 4) : [];
		var father = of('father')[0], mother = of('mother')[0];
		var sons = of('son').map(unit), daughters = of('daughter').map(unit);

		// Pakistani law (MFLO s. 4): a son or daughter who died first is replaced by their children.
		var sec4Kids = {};
		if (opt.sec4) {
			persons.filter(function (p) { return (p.rel === 'son' || p.rel === 'daughter') && p.status === 'before'; }).forEach(function (p) {
				var kids = kidsOf(persons, p.id);
				if (!kids.length) return;
				var u = { id: p.id, sex: REL[p.rel].sex, rel: p.rel, members: kids };
				(p.rel === 'son' ? sons : daughters).push(u);
				kids.forEach(function (k) { sec4Kids[k.id] = true; });
				r.notes.push('sec4');
			});
		}
		var gk = H.filter(function (p) { return (p.rel === 'grandson' || p.rel === 'granddaughter') && !sec4Kids[p.id]; });
		var sonKids = gk.filter(function (p) { return map[p.parent] && map[p.parent].rel === 'son'; });
		var daughterKids = gk.filter(function (p) { return map[p.parent] && map[p.parent].rel === 'daughter'; });
		var SS = [], SD = [];
		if (sons.length) block(r, sonKids, 'son');
		else sonKids.forEach(function (p) { (p.rel === 'grandson' ? SS : SD).push(unit(p)); });

		var maleDesc = sons.length + SS.length > 0;
		var femDesc = daughters.length + SD.length > 0;
		var desc = maleDesc || femDesc;

		var GF = father ? null : of('dada')[0];
		if (father) block(r, of('dada'), 'father');
		var FB = of('brother'), FS = of('sister'), PB = of('pbrother'), PS = of('psister');
		var U = of('mbrother').concat(of('msister'));
		var siblingsAll = FB.length + FS.length + PB.length + PS.length + U.length;

		var fards = []; // { ids, f, why }
		function fard(list, f, why, ref) { if (list.length) fards.push({ ids: list.map(function (p) { return p.id; }), f: f, why: why, ref: ref }); }

		// Spouses
		var spouseF = ZERO;
		if (husband.length) { spouseF = desc ? Q(1, 4) : Q(1, 2); fard(husband, spouseF, 'husband'); }
		if (wives.length) { spouseF = desc ? Q(1, 8) : Q(1, 4); fard(wives, spouseF, 'wife'); }

		// Father and grandfather: 1/6 with a male descendant; 1/6 plus the rest with only female descendants; else the rest.
		var asabaFather = null;
		var gfBlocksSiblings = !zayd; // Hanafi (Abu Hanifa, Abu Bakr's view) and Ahl-e-Hadith
		// Shafi'i, Maliki, Hanbali: the grandfather shares with full or paternal siblings instead of blocking them.
		var muqasama = !!GF && zayd && !maleDesc && (FB.length + FS.length + PB.length + PS.length) > 0;
		[father, GF].forEach(function (x) {
			if (!x || (x === GF && muqasama)) return;
			if (desc) fard([x], Q(1, 6), x === father ? 'father' : 'grandfather', REFS.father);
			if (!maleDesc) asabaFather = x;
		});

		// Mother
		if (mother) {
			if (desc || siblingsAll >= 2) fard([mother], Q(1, 6), 'mother');
			else if (father && (husband.length || wives.length)) fard([mother], div(sub(ONE, spouseF), Q(3)), 'mother', REFS.umariyyatan);
			else fard([mother], Q(1, 3), 'mother');
		}

		// Grandmothers: mother blocks both; father blocks his own mother (not in the Hanbali school).
		var gms = [];
		of('nani').forEach(function (p) { if (mother) block(r, [p], 'mother'); else gms.push(p); });
		of('dadi').forEach(function (p) {
			if (mother) block(r, [p], 'mother');
			else if (father && madhab !== 'hanbali') block(r, [p], 'father');
			else gms.push(p);
		});
		fard(gms, Q(1, 6), 'grandmother');
		block(r, of('nana'), 'notSharer');

		// Daughters and son's daughters
		var asabaKids = null;
		if (sons.length) asabaKids = sons.concat(daughters);
		else if (daughters.length) fards.push({ units: daughters, f: daughters.length === 1 ? Q(1, 2) : Q(2, 3), why: 'daughters' });
		if (!sons.length) {
			if (SS.length) asabaKids = SS.concat(SD);
			else if (SD.length) {
				if (!daughters.length) fards.push({ units: SD, f: SD.length === 1 ? Q(1, 2) : Q(2, 3), why: 'daughters' });
				else if (daughters.length === 1) fards.push({ units: SD, f: Q(1, 6), why: 'sondaughter' });
				else block(r, SD.map(function (u) { return u.id; }), 'twoDaughters');
			}
		}

		// Uterine siblings: blocked by any descendant, the father and the grandfather.
		var Ublocked = desc ? 'descendant' : father ? 'father' : GF ? 'grandfather' : null;
		if (Ublocked) block(r, U, Ublocked);

		// Full and consanguine siblings
		var sibBlock = maleDesc ? (sons.length ? 'son' : 'grandson') : father ? 'father' : (GF && gfBlocksSiblings) ? 'grandfather' : null;
		var asabaSib = null;
		if (sibBlock) {
			block(r, FB.concat(FS, PB, PS), sibBlock);
		} else if (muqasama) {
			// handled in zaydGrandfather()
		} else {
			if (FB.length) asabaSib = { units: FB.concat(FS).map(unit), why: 'asaba' };
			else if (FS.length && femDesc) asabaSib = { units: FS.map(unit), why: 'maalGhayr' };
			else if (FS.length) fards.push({ ids: FS.map(function (p) { return p.id; }), f: FS.length === 1 ? Q(1, 2) : Q(2, 3), why: 'sisters' });
			// Consanguine
			var consBlock = FB.length ? 'brother' : (FS.length && femDesc) ? 'sister' : null;
			if (consBlock) block(r, PB.concat(PS), consBlock);
			else if (!asabaSib) {
				if (PB.length) asabaSib = { units: PB.concat(PS).map(unit), why: 'asaba' };
				else if (PS.length && femDesc) asabaSib = { units: PS.map(unit), why: 'maalGhayr' };
				else if (PS.length) {
					if (FS.length === 1) fards.push({ ids: PS.map(function (p) { return p.id; }), f: Q(1, 6), why: 'consSister', ref: REFS.sisters });
					else if (FS.length >= 2) block(r, PS, 'twoSisters');
					else fards.push({ ids: PS.map(function (p) { return p.id; }), f: PS.length === 1 ? Q(1, 2) : Q(2, 3), why: 'sisters' });
				}
			} else {
				block(r, PB.concat(PS), FB.length ? 'brother' : 'sister');
			}
		}
		if (!Ublocked && U.length) fards.push({ ids: U.map(function (p) { return p.id; }), f: U.length === 1 ? Q(1, 6) : Q(1, 3), why: 'uterine', equal: true });

		// Distant male residuaries, nearest first.
		var nephews = H.filter(function (p) { return p.rel === 'nephew'; });
		var FBS = nephews.filter(function (p) { return map[p.parent] && map[p.parent].rel === 'brother'; });
		var PBS = nephews.filter(function (p) { return map[p.parent] && map[p.parent].rel === 'pbrother'; });
		var FU = of('chacha'), FUS = of('cousin');
		var distant = [['nephew', FBS], ['nephew', PBS], ['chacha', FU], ['cousin', FUS]];

		var asaba = null;
		if (asabaKids) asaba = { units: asabaKids, why: 'children' };
		else if (asabaFather) asaba = { units: [unit(asabaFather)], why: 'asaba', alsoFard: desc };
		else if (asabaSib) asaba = asabaSib;
		var higher = asaba || muqasama || asabaFather || sibBlock;
		distant.forEach(function (d) {
			if (!d[1].length) return;
			if (higher) block(r, d[1], 'higherAsaba');
			else { asaba = { units: d[1].map(unit), why: 'asaba' }; higher = true; }
		});

		/* ---- special cases ---- */

		// al-Mushtaraka (Shafi'i, Maliki): husband, mother or grandmother, 2+ uterine and full brothers, nothing left.
		var uterF = fards.filter(function (x) { return x.why === 'uterine'; })[0];
		if (asaba && asaba.why === 'asaba' && FB.length && uterF && U.length >= 2 && husband.length && (madhab === 'shafii' || madhab === 'maliki')) {
			var rest0 = sub(ONE, sum(fards.map(function (x) { return x.f; })));
			if (cmp(rest0, ZERO) <= 0) {
				uterF.ids = uterF.ids.concat(FB.concat(FS).map(function (p) { return p.id; }));
				uterF.why = 'mushtaraka';
				asaba = null;
				r.notes.push('mushtaraka');
			}
		}

		if (muqasama) return zaydGrandfather(r, fards, GF, FB, FS, PB, PS, husband, mother, femDesc);

		return finish(r, fards, asaba, persons, H, map, husband.concat(wives));
	}

	/** Grandfather with full or consanguine siblings, after Zayd ibn Thabit (Shafi'i, Maliki, Hanbali). */
	function zaydGrandfather(r, fards, GF, FB, FS, PB, PS, husband, mother, femDesc) {
		var others = sum(fards.map(function (x) { return x.f; }));
		var sibs = FB.length + FS.length + PB.length + PS.length;
		// al-Akdariyya: husband, mother, grandfather and one sister.
		if (husband.length && mother && sibs === 1 && (FS.length || PS.length) && fards.length === 2 && !femDesc) {
			var sis = FS[0] || PS[0];
			// Husband 3/9, mother 2/9 ('awl from 6 to 9); grandfather and sister share 4/9 as 2:1.
			give(r, [husband[0].id], Q(1, 3), 'husband');
			give(r, [mother.id], Q(2, 9), 'mother');
			give(r, [GF.id], Q(8, 27), 'akdariyya');
			give(r, [sis.id], Q(4, 27), 'akdariyya');
			r.awl = true;
			r.notes.push('akdariyya');
			return r;
		}
		var R = sub(ONE, others);
		var heads = 2 + (FB.length + PB.length) * 2 + FS.length + PS.length;
		var muq = mul(R, Q(2, heads));
		var gf = fards.length ? max(max(Q(1, 6), div(R, Q(3))), muq) : max(Q(1, 3), muq);
		var why = cmp(gf, muq) === 0 ? 'muqasama' : 'grandfather';
		fards.push({ ids: [GF.id], f: gf, why: why, ref: REFS.muqasama });
		var R2 = sub(R, gf);
		r.notes.push('zayd');
		if (cmp(R2, ZERO) <= 0) {
			block(r, FB.concat(FS, PB, PS), 'grandfather');
			return finish(r, fards, null);
		}
		// Mu'adda: consanguine siblings were counted against the grandfather; their part goes to full siblings.
		var asaba;
		if (FB.length) {
			asaba = { units: FB.concat(FS).map(unit), why: 'asaba' };
			block(r, PB.concat(PS), 'brother');
		} else if (FS.length) {
			var cap = FS.length === 1 ? Q(1, 2) : Q(2, 3);
			if (PB.length + PS.length && cmp(R2, cap) > 0) {
				fards.push({ ids: FS.map(function (p) { return p.id; }), f: cap, why: 'sisters' });
				asaba = { units: PB.concat(PS).map(unit), why: 'asaba' };
			} else {
				asaba = { units: FS.map(unit), why: 'muqasama' };
				block(r, PB.concat(PS), 'sister');
			}
		} else {
			asaba = { units: PB.concat(PS).map(unit), why: 'muqasama' };
		}
		return finish(r, fards, asaba);
	}

	/** Fixed shares, then the rest to the residuary; 'awl when the shares exceed the estate, radd when they fall short. */
	function finish(r, fards, asaba, persons, H, map, spouses) {
		var total = sum(fards.map(function (x) { return x.f; }));
		var scale = ONE;
		if (cmp(total, ONE) > 0) { scale = div(ONE, total); r.awl = true; }
		fards.forEach(function (x) {
			var f = mul(x.f, scale);
			if (x.units) give21(r, x.units, f, x.why, x.ref || REFS[x.why]);
			else give(r, x.ids, f, x.why, x.ref || REFS[x.why]);
		});
		var rest = r.awl ? ZERO : sub(ONE, total);
		if (asaba) {
			if (!isZero(rest)) give21(r, asaba.units, rest, asaba.why, REFS[asaba.why === 'children' ? 'children' : asaba.why === 'maalGhayr' ? 'maalGhayr' : asaba.why === 'muqasama' ? 'muqasama' : 'asaba']);
			else asaba.units.forEach(function (u) { if (!r.shares[u.id].why) r.shares[u.id].blocked = 'nothingLeft'; });
			return r;
		}
		if (isZero(rest) || cmp(rest, ZERO) < 0) return r;
		// Radd to the sharers except the spouses, in proportion to their shares.
		var spouseIds = {};
		(spouses || []).forEach(function (p) { spouseIds[p.id] = true; });
		var sharers = [];
		fards.forEach(function (x) {
			var ids = x.ids || x.units.map(function (u) { return u.id; });
			if (!ids.some(function (id) { return spouseIds[id]; })) sharers.push(x);
		});
		if (sharers.length) {
			var base = sum(sharers.map(function (x) { return x.f; }));
			sharers.forEach(function (x) {
				var f = mul(rest, div(x.f, base));
				if (x.units) give21(r, x.units, f, x.why, null);
				else give(r, x.ids, f, x.why, null);
			});
			r.radd = true;
			r.notes.push('radd');
			return r;
		}
		// Dhawi al-arham before radd to a spouse.
		if (persons && dhawi(r, persons, H, map, rest)) return r;
		var sp = (spouses || []);
		if (sp.length) {
			give(r, sp.map(function (p) { return p.id; }), rest, 'radd');
			r.radd = true;
			r.notes.push('raddSpouse');
			return r;
		}
		r.unassigned = rest;
		r.notes.push('unassigned');
		return r;
	}

	/** Relatives through women (Hanafi order, simplified): descendants, then grandfathers, then siblings' children, then aunts and uncles. */
	function dhawi(r, persons, H, map, rest) {
		function kidsVia(rels) {
			return H.filter(function (p) {
				return (p.rel === 'grandson' || p.rel === 'granddaughter' || p.rel === 'nephew' || p.rel === 'niece') && map[p.parent] && rels.indexOf(map[p.parent].rel) >= 0 && isZero(r.shares[p.id].f);
			});
		}
		var g1 = kidsVia(['daughter']);
		var g2 = H.filter(function (p) { return p.rel === 'nana'; });
		var g3 = kidsVia(['sister', 'psister', 'mbrother', 'msister']).concat(H.filter(function (p) { return p.rel === 'niece' && map[p.parent] && (map[p.parent].rel === 'brother' || map[p.parent].rel === 'pbrother'); }));
		var pat = H.filter(function (p) { return p.rel === 'phuphi'; });
		var mat = H.filter(function (p) { return p.rel === 'mamu' || p.rel === 'khala'; });
		var group = g1.length ? g1 : g2.length ? g2 : g3.length ? g3 : null;
		if (group) {
			group.forEach(function (p) { r.shares[p.id].blocked = null; });
			give21(r, group.map(unit), rest, 'dhawi', REFS.dhawi);
		} else if (pat.length || mat.length) {
			pat.concat(mat).forEach(function (p) { r.shares[p.id].blocked = null; });
			if (pat.length && mat.length) {
				give(r, pat.map(function (p) { return p.id; }), mul(rest, Q(2, 3)), 'dhawi', REFS.dhawi);
				give21(r, mat.map(unit), mul(rest, Q(1, 3)), 'dhawi', REFS.dhawi);
			} else if (pat.length) give(r, pat.map(function (p) { return p.id; }), rest, 'dhawi', REFS.dhawi);
			else give21(r, mat.map(unit), rest, 'dhawi', REFS.dhawi);
		} else return false;
		r.notes.push('dhawi');
		return true;
	}

	/* ---------- Shia Ja'fari (Sistani) ---------- */

	function jafari(persons, opt) {
		var r = Result(persons);
		var H = heirs(persons);
		var map = byId(persons);
		function of(rel) { return H.filter(function (p) { return p.rel === rel; }); }
		function before(rel) { return persons.filter(function (p) { return p.rel === rel && p.status === 'before'; }); }
		// A relative who died first, with children alive: their children take their place.
		function reps(rels, equal) {
			var out = [];
			rels.forEach(function (rel) {
				before(rel).forEach(function (p) {
					var kids = kidsOf(persons, p.id);
					if (kids.length) out.push({ id: p.id, sex: REL[p.rel].sex, rel: p.rel, members: kids, equal: equal });
				});
			});
			return out;
		}

		var husband = opt.deceasedSex === 'f' ? of('husband') : [];
		var wives = opt.deceasedSex === 'm' ? of('wife').slice(0, 4) : [];
		var spouses = husband.concat(wives);
		var father = of('father')[0], mother = of('mother')[0];

		var children = of('son').concat(of('daughter')).map(unit);
		var gkReps = [];
		if (!children.length) gkReps = reps(['son', 'daughter'], false);
		var kids = children.length ? children : gkReps;
		// Grandchildren whose parent is alive inherit nothing.
		H.filter(function (p) { return (p.rel === 'grandson' || p.rel === 'granddaughter'); }).forEach(function (p) {
			if (!gkReps.some(function (u) { return u.id === p.parent; })) block(r, [p], 'parentAlive');
		});

		var desc = kids.length > 0;
		var spouseF = ZERO;
		if (husband.length) spouseF = desc ? Q(1, 4) : Q(1, 2);
		if (wives.length) spouseF = desc ? Q(1, 8) : Q(1, 4);

		var cls = (father || mother || desc) ? 1 : null;
		var FB = of('brother'), FS = of('sister'), PB = of('pbrother'), PS = of('psister'), MB = of('mbrother'), MS = of('msister');
		var GP = of('dada').concat(of('dadi'), of('nana'), of('nani'));
		var sibs = FB.length + FS.length + PB.length + PS.length + MB.length + MS.length;
		var sibReps = sibs ? [] : reps(['brother', 'sister', 'pbrother', 'psister'], false).concat(reps(['mbrother', 'msister'], true));
		if (!cls && (sibs || GP.length || sibReps.length)) cls = 2;
		var UNC = of('chacha').concat(of('phuphi'), of('mamu'), of('khala'));
		var uncReps = UNC.length ? [] : reps(['chacha'], false);
		if (!cls && (UNC.length || uncReps.length)) cls = 3;

		// Everyone outside the inheriting class is excluded.
		var lower = { 2: ['dada', 'dadi', 'nana', 'nani', 'brother', 'sister', 'pbrother', 'psister', 'mbrother', 'msister', 'nephew', 'niece'], 3: ['chacha', 'phuphi', 'mamu', 'khala', 'cousin'] };
		[2, 3].forEach(function (c) {
			if (cls && c > cls) block(r, H.filter(function (p) { return lower[c].indexOf(p.rel) >= 0; }), 'class' + cls);
		});
		r.cls = cls;

		if (spouses.length) give(r, spouses.map(function (p) { return p.id; }), spouseF, husband.length ? 'husband' : 'wife');

		if (!cls) {
			// Only a spouse: the husband takes everything; the wife 1/4, the rest to the Imam.
			if (husband.length) { give(r, [husband[0].id], sub(ONE, spouseF), 'radd'); r.radd = true; }
			else if (wives.length) { r.unassigned = sub(ONE, spouseF); r.notes.push('imam'); }
			else { r.unassigned = ONE; r.notes.push('unassigned'); }
			return jafariLand(r, wives);
		}
		var rest = sub(ONE, spouseF);

		if (cls === 1) {
			// Mother's hajb: father alive with 2 brothers, or 1 brother and 2 sisters, or 4 sisters (full or paternal).
			var b = FB.length + PB.length, s = FS.length + PS.length;
			var hajib = !!father && (b >= 2 || (b === 1 && s >= 2) || s >= 4);
			if (hajib) r.notes.push('hajib');
			if (desc) {
				var sons = kids.filter(function (u) { return u.sex === 'm'; });
				var pf = [];
				if (father) pf.push({ id: father.id, f: Q(1, 6), why: 'father' });
				if (mother) pf.push({ id: mother.id, f: Q(1, 6), why: 'mother', noRadd: hajib });
				var pTotal = sum(pf.map(function (x) { return x.f; }));
				if (sons.length) {
					pf.forEach(function (x) { give(r, [x.id], x.f, x.why); });
					give21(r, kids, sub(rest, pTotal), 'children', REFS.children);
				} else {
					var dF = kids.length === 1 ? Q(1, 2) : Q(2, 3);
					var need = add(pTotal, dF);
					if (cmp(need, rest) >= 0) {
						// No 'awl in Ja'fari fiqh: the daughters bear the shortfall.
						pf.forEach(function (x) { give(r, [x.id], x.f, x.why); });
						give21(r, kids, sub(rest, pTotal), 'daughters', REFS.daughters, true);
					} else {
						var extra = sub(rest, need);
						var shareRadd = [{ f: dF, kids: true }].concat(pf.filter(function (x) { return !x.noRadd; }));
						var base = sum(shareRadd.map(function (x) { return x.f; }));
						pf.forEach(function (x) { give(r, [x.id], x.noRadd ? x.f : add(x.f, mul(extra, div(x.f, base))), x.why); });
						give21(r, kids, add(dF, mul(extra, div(dF, base))), 'daughters', REFS.daughters, true);
						r.radd = true;
						r.notes.push('radd');
					}
				}
			} else if (father && mother) {
				var m = hajib ? Q(1, 6) : Q(1, 3);
				give(r, [mother.id], m, 'mother');
				give(r, [father.id], sub(rest, m), 'father');
			} else {
				give(r, [(father || mother).id], rest, father ? 'father' : 'mother');
			}
			return jafariLand(r, wives);
		}

		if (cls === 2) {
			// Mother's side (uterine siblings, maternal grandparents) and father's side (full or paternal siblings, paternal grandparents).
			var fullSide = (FB.length || FS.length) ? FB.concat(FS) : PB.concat(PS);
			if (FB.length || FS.length) block(r, PB.concat(PS), 'fullSibling');
			var paternal = fullSide.map(unit).concat(of('dada').map(unit), of('dadi').map(unit), sibReps.filter(function (u) { return !u.equal; }));
			var maternal = MB.concat(MS, of('nana'), of('nani')).map(unit).concat(sibReps.filter(function (u) { return u.equal; }));
			if (maternal.length && paternal.length) {
				var single = maternal.length === 1 && (MB.length + MS.length === 1 || (maternal[0].members && maternal[0].equal));
				var mf = single ? Q(1, 6) : Q(1, 3);
				give21(r, maternal, mf, 'uterine', REFS.jafariClass, true);
				give21(r, paternal, sub(rest, mf), 'asaba', REFS.jafariClass);
			} else if (maternal.length) {
				give21(r, maternal, rest, 'uterine', REFS.jafariClass, true);
			} else {
				give21(r, paternal, rest, 'asaba', REFS.jafariClass);
			}
			return jafariLand(r, wives);
		}

		// Class 3: paternal uncles and aunts 2/3, maternal 1/3 (1/6 if only one).
		var pat = of('chacha').concat(of('phuphi')).map(unit).concat(uncReps);
		var mat = of('mamu').concat(of('khala')).map(unit);
		if (pat.length && mat.length) {
			var mf3 = mat.length === 1 ? Q(1, 6) : Q(1, 3);
			give21(r, mat, mf3, 'uncles', REFS.jafariClass, true);
			give21(r, pat, sub(rest, mf3), 'uncles', REFS.jafariClass);
		} else if (mat.length) give21(r, mat, rest, 'uncles', REFS.jafariClass, true);
		else give21(r, pat, rest, 'uncles', REFS.jafariClass);
		r.notes.push('class3');
		return jafariLand(r, wives);
	}

	/** Ja'fari: the wife inherits nothing from land (only from buildings and trees); the others share the land. */
	function jafariLand(r, wives) {
		var land = {};
		var wifeTotal = sum(wives.map(function (w) { return r.shares[w.id].f; }));
		var others = sub(sub(ONE, wifeTotal), r.unassigned);
		Object.keys(r.shares).forEach(function (id) {
			var f = r.shares[id].f;
			land[id] = wives.some(function (w) { return w.id === id; }) || isZero(others) ? ZERO : div(f, others);
		});
		if (wives.length) r.landShares = land;
		return r;
	}

	/* ---------- entry point ---------- */

	/**
	 * persons: [{ id, rel, status: 'alive' | 'before' | 'after', parent }]
	 * opt: { madhab, deceasedSex: 'm' | 'f', sec4: bool }
	 * Returns { shares: { id: { f: {n,d}, why, ref, blocked, pass } }, notes, awl, radd, unassigned, landShares?, base }
	 */
	function calculate(persons, opt) {
		opt = opt || {};
		var list = (persons || []).filter(function (p) { return p && REL[p.rel]; });
		var r = opt.madhab === 'jafari' ? jafari(list, opt) : sunni(list, opt);
		list.forEach(function (p) {
			var s = r.shares[p.id];
			if (p.status === 'before' && s.why !== 'passed') { s.blocked = 'diedBefore'; s.f = ZERO; }
			if (p.status === 'after' && !isZero(s.f)) s.after = true;
			if (isZero(s.f) && !s.why && !s.blocked && s.why !== 'passed') s.blocked = notHeirReason(p, opt);
		});
		// Lowest common denominator, like the "asl al-mas'ala" after tashih.
		var base = 1;
		Object.keys(r.shares).forEach(function (id) { var d = r.shares[id].f.d; base = base / gcd(base, d) * d; });
		if (r.unassigned && !isZero(r.unassigned)) base = base / gcd(base, r.unassigned.d) * r.unassigned.d;
		r.base = base;
		r.total = sum(Object.keys(r.shares).map(function (id) { return r.shares[id].f; }).concat([r.unassigned || ZERO]));
		return r;
	}
	function notHeirReason(p, opt) {
		if (opt.madhab !== 'jafari' && ['phuphi', 'mamu', 'khala', 'nana', 'niece'].indexOf(p.rel) >= 0) return 'notSharer';
		if (opt.madhab !== 'jafari' && (p.rel === 'grandson' || p.rel === 'granddaughter' || p.rel === 'nephew')) return 'notSharer';
		return 'higherAsaba';
	}

	/** Checks the family before calculating: one father, one mother, at most four wives, children attached to a parent. */
	function validate(persons, deceasedSex) {
		var errs = [];
		var count = {};
		var map = byId(persons);
		persons.forEach(function (p) {
			count[p.rel] = (count[p.rel] || 0) + 1;
			var def = REL[p.rel];
			if (!def) { errs.push({ id: p.id, code: 'unknown' }); return; }
			if (def.parent && !(map[p.parent] && def.parent.indexOf(map[p.parent].rel) >= 0)) errs.push({ id: p.id, code: 'parent' });
			if (p.rel === 'husband' && deceasedSex !== 'f') errs.push({ id: p.id, code: 'spouseSex' });
			if (p.rel === 'wife' && deceasedSex !== 'm') errs.push({ id: p.id, code: 'spouseSex' });
		});
		SINGLE.forEach(function (rel) { if (count[rel] > 1) errs.push({ rel: rel, code: 'onlyOne' }); });
		if (count.wife > 4) errs.push({ rel: 'wife', code: 'fourWives' });
		return errs;
	}

	/* ---------- estate ---------- */

	// Punjab revenue units: 1 acre = 8 kanal, 1 kanal = 20 marla, 1 marla = 9 sarsahi.
	var SARSAHI = { acre: 1440, kanal: 180, marla: 9, sarsahi: 1 };
	function toSarsahi(a) { return (+a.acre || 0) * 1440 + (+a.kanal || 0) * 180 + (+a.marla || 0) * 9 + (+a.sarsahi || 0); }
	function fromSarsahi(s) {
		var out = { kanal: Math.floor(s / 180) };
		s -= out.kanal * 180;
		out.marla = Math.floor(s / 9 + 1e-9);
		out.sarsahi = Math.round((s - out.marla * 9) * 100) / 100;
		if (out.sarsahi >= 9) { out.marla += 1; out.sarsahi = 0; }
		if (out.marla >= 20) { out.kanal += 1; out.marla -= 20; }
		return out;
	}

	/**
	 * Net estate after funeral costs, debts (including unpaid mehr) and the will (capped at one third).
	 * Money deductions come from cash first, then from the other items in proportion to their value.
	 * items: [{ type: 'cash' | 'land' | 'gold' | 'silver' | 'house' | 'other', qty, value }]
	 * Returns { items: [{ ...item, factor }], deducted, willUsed, willCapped, shortfall }
	 */
	function netEstate(items, d) {
		d = d || {};
		var funeral = Math.max(0, +d.funeral || 0), debts = Math.max(0, +d.debts || 0), will = Math.max(0, +d.will || 0);
		var value = function (it) { return it.type === 'cash' ? (+it.qty || 0) : (+it.value || 0); };
		var total = items.reduce(function (s, it) { return s + value(it); }, 0);
		var afterDebts = total - funeral - debts;
		var willCap = Math.max(0, afterDebts) / 3;
		var willUsed = total ? Math.min(will, willCap) : 0;
		var need = funeral + debts + willUsed;
		var out = items.map(function (it) { return Object.assign({}, it, { factor: 1 }); });
		var cash = out.filter(function (it) { return it.type === 'cash'; });
		cash.forEach(function (it) {
			var c = +it.qty || 0;
			var take = Math.min(c, need);
			it.factor = c ? (c - take) / c : 1;
			need -= take;
		});
		var rest = out.filter(function (it) { return it.type !== 'cash' && (+it.value || 0) > 0; });
		var restValue = rest.reduce(function (s, it) { return s + (+it.value || 0); }, 0);
		if (need > 0 && restValue > 0) {
			var f = Math.max(0, (restValue - need) / restValue);
			rest.forEach(function (it) { it.factor = f; });
			need = Math.max(0, need - restValue);
		}
		return { items: out, total: total, deducted: funeral + debts + willUsed - need, willUsed: willUsed, willCapped: will > willUsed + 0.5, shortfall: need };
	}

	return {
		Q: Q, add: add, sub: sub, mul: mul, div: div, cmp: cmp, val: val, ZERO: ZERO, ONE: ONE,
		REL: REL, SINGLE: SINGLE, MADHABS: MADHABS, REFS: REFS,
		calculate: calculate, validate: validate, netEstate: netEstate,
		SARSAHI: SARSAHI, toSarsahi: toSarsahi, fromSarsahi: fromSarsahi,
	};
});
