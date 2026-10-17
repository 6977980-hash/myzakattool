/*
 * My Zakat Tool: the page around the wirasat calculator frame ([zakat_wirasat]).
 * The calculator (assets/wirasat/app.html) reports its height, so the frame grows with it and
 * has no scrollbar of its own, and asks the page to scroll when it shows the shajra.
 */
(function () {
	var frames = document.querySelectorAll('iframe.myzt-wirasat-frame');
	if (!frames.length) return;
	addEventListener('message', function (e) {
		var d = e.data;
		if (!d || typeof d !== 'object') return;
		for (var i = 0; i < frames.length; i++) {
			var f = frames[i];
			if (e.source !== f.contentWindow) continue;
			if (d.myztWirasatHeight > 0) f.style.height = Math.min(d.myztWirasatHeight, 20000) + 'px';
			if (typeof d.myztWirasatScroll === 'number') {
				var top = f.getBoundingClientRect().top + window.pageYOffset + d.myztWirasatScroll;
				var smooth = !(window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches);
				window.scrollTo({ top: Math.max(0, top - 8), behavior: smooth ? 'smooth' : 'auto' });
			}
		}
	});
	// This script can load after the frame has already reported; ask again.
	for (var j = 0; j < frames.length; j++) {
		try { frames[j].contentWindow.postMessage({ myztWirasatPing: 1 }, '*'); } catch (x) {}
		frames[j].addEventListener('load', function () { this.contentWindow.postMessage({ myztWirasatPing: 1 }, '*'); });
	}
})();
