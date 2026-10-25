# My Zakat Tool

WordPress plugin behind [myzakattool.com](https://myzakattool.com/): a zakat calculator for every madhab (Hanafi, Shafi'i, Maliki, Hanbali, Ahl-e-Hadith, Shia Ja'fari) with live gold and silver rates, a side-by-side madhab comparison, a PDF report, and the whole site (pages, guides, menu, SEO, schema, icons) built in.

## Deployment

Hostinger Git deploy pulls the `main` branch into `public_html/wp-content/plugins/myzakattool`, so the plugin files live at the repo root.

Git deploys do not fire WordPress's activation hook, so the plugin installs itself the first time someone opens **wp-admin** after a deploy with a new version number:

- First install only: site title "My Zakat Tool", tagline, `/%postname%/` permalinks, comments off, the untouched "Hello world" post and "Sample page" moved to trash, a main menu.
- Every version change: creates any of the 28 pages and 13 guide posts that are missing, and updates pages it created to the new text unless someone has edited them, sets the home page as the static front page, schedules the hourly rate refresh and fetches rates once.

**Settings → My Zakat Tool** shows the rate status, a "Refresh rates now" button, "Create missing pages", author details, fitrana amounts, AdSense IDs and the ads ON/OFF switch.

## Rates

Fetched on the server every hour and cached, never from the visitor's browser to a third party:

- Gold and silver (USD/oz): gold-api.com, falling back to the fawazahmed0 currency API, then the last saved value.
- Currency conversion: fawazahmed0 currency API (jsDelivr, then its pages.dev mirror).

If WP-Cron is unreliable, add a Hostinger cron job (hPanel → Advanced → Cron Jobs) every 30 minutes:
`wget -q -O - https://myzakattool.com/wp-cron.php?doing_wp_cron >/dev/null 2>&1`
and add `define( 'DISABLE_WP_CRON', true );` to `wp-config.php`.

## Shortcodes

| Shortcode | What it shows |
|---|---|
| `[zakat_calculator madhab="hanafi" compare="1" country="PK"]` | The calculator (madhab optional; `country` keeps that country's currency and unit for every visitor; `tiles`, `currency`, `unit` preset a first visit) |
| `[zakat_gold_rate]` | Gold and silver rate tables |
| `[zakat_nisab]` | Today's nisab (server-rendered) |
| `[zakat_fitrana]`, `[zakat_fidya]`, `[zakat_khums]` | Fitrana, fidya/kaffara and khums calculators |
| `[zakat_hawl]`, `[zakat_ushr]` | Zakat date / hawl tracker (reminders, missed years) and ushr + livestock calculators |
| `[zakat_iddat]`, `[zakat_qurbani currency="PKR"]` | Iddat end date (death, talaq, khula, per madhab) and the qurbani wajib check |
| `[myzt_embed_code currency="PKR"]` | Preview and copy code for the embeddable nisab widget (`assets/js/embed.js`) |
| `[myzt_reviewed rates="1"]` | "Rules last reviewed" date (Settings) and a dated snapshot of the rates |
| `[myzt_rate type="gold-tola"]` | One live number in text (`gold-gram`, `gold22-tola`, `silver-tola`, `silver-gram`, `nisab-silver`, `nisab-gold`, `gold-tola-zakat`, `gold22-tola-zakat`) |
| `[myzt_official type="bank-nisab"]`, `[myzt_history type="fitrana"]` | Latest official figure box and the past-years table (`bank-nisab`, `fitrana`, `fidya`, `diyat`), from `MYZT_Frontend::official()` |
| `[myzt_1448 type="fitrana"]` | One sentence: "not announced yet" for Ramadan 1448, or the announced figure once `NEXT` is live |
| `[myzt_answer]...[/myzt_answer]` | Quick-answer box |
| `[myzt_faq]` | FAQ from the page's FAQ data (with FAQPage schema) |
| `[myzt_author]`, `[myzt_trust]`, `[myzt_related slugs="a,b"]`, `[myzt_guides]`, `[myzt_year]`, `[myzt_ad where="article"]` | Author box, trust badges, related links, guide list, season year, ad slot |

## Announcement day (Ramadan 1448 / 2027)

The Council of Islamic Ideology usually announces fitrana two or three weeks before Ramadan (mid to late January 2027), and the government notifies the bank deduction nisab a few days before 1 Ramadan (about 8 February 2027). On the day:

1. In `includes/class-frontend.php`, find `const NEXT`. Fill the line for the figure that came out and change its first value from `false` to `true`:
   - fitrana: `array( true, '1448', '2027', array( 'wheat' => '350', 'barley' => '1200', 'dates' => '1800', 'raisins' => '4000' ), 'Council of Islamic Ideology, 25 Jan 2027', 'https://link-to-the-news-or-notice' )` (plain rupees, no commas).
   - bank nisab: `array( true, '1448', '2027', 'Rs 5,50,000', 'Ministry of Poverty Alleviation, 5 Feb 2027', 'https://...' )`.
2. That one line adds the 1448 row on top of the official box and the history table, removes "not announced yet", puts the figure in the /zakat-2027-pakistan/ title (`{t2027}`), and for fitrana switches the fitrana and fidya calculators (unless amounts were typed in Settings → My Zakat Tool, which still win).
3. Update the FAQ answers on /zakat-2027-pakistan/ ("What is the zakat nisab for 2027", "Fitrana 2027 kitna hai?") in `includes/content.php`, bump the patch version, run the tests, merge, then open wp-admin once so the pages refresh.
4. After Ramadan, move the row into `official()` as an ordinary row and reset `NEXT` for 1449.

## SEO built in

Titles and descriptions per page, Open Graph and X cards with a share image per page, JSON-LD (Organization, WebSite, Person, BreadcrumbList, WebPage, Article, FAQPage, WebApplication), visible breadcrumbs, robots meta, `robots.txt`, the core XML sitemap (users, tags and legal pages removed), favicon set, web app manifest, `llms.txt`, `security.txt` and `ads.txt` (only once an AdSense publisher ID is saved).

If Rank Math, Yoast, AIOSEO or SEOPress is activated, the plugin turns off its own meta tags and schema so nothing is duplicated.

## Recommended WordPress setup

1. Theme: GeneratePress (free). Settings → My Zakat Tool has a one-click "Install and activate GeneratePress" button. Activating it puts the plugin's main menu in the primary location automatically; footer trust links are added by the plugin.
2. LiteSpeed Cache (Hostinger), plus Cloudflare in front of the domain.
3. Security: built into the plugin (Settings → My Zakat Tool → Security): an optional secret login address (wp-login.php and wp-admin then show "not found" to visitors), 5 failed logins lock an IP for 15 minutes, generic login errors, no username discovery, XML-RPC off, security headers. If the login address is forgotten, add `define( 'MYZT_NO_LOGIN_SLUG', true );` to `wp-config.php`. For two-factor login install the free **Two Factor** plugin (or Wordfence), and add `define( 'DISALLOW_FILE_EDIT', true );` to `wp-config.php`.
4. Google Search Console: paste the HTML-tag verification code in Settings → My Zakat Tool, press Verify, then submit `https://myzakattool.com/wp-sitemap.xml`.
5. AdSense: once approved, enter the publisher ID and slot IDs in Settings → My Zakat Tool and switch ads on. Slots keep a fixed height so the page never jumps, and an empty slot shows nothing.

## Tests

Every pull request runs `.github/workflows/ci.yml`, and a red check should block the merge (main goes live on the next Hostinger deploy):

| Check | Command | What it covers |
|---|---|---|
| PHP lint (7.4, 8.3) | `npm run test:php` | `php -l` on every PHP file, on the oldest and newest supported PHP |
| Engine tests and matrix | `npm run test:js` | `node --check` on the scripts, the engine unit tests, the independent 50-case matrix (`tests/matrix.test.js`, expected values worked out by hand formulas) and the version check |
| Browser smoke tests | `npm install && npx playwright install chromium && npm run test:ui` | `tests/ui/fixture.html` (the same markup and `window.MYZT` config the shortcodes print) in Chromium: every widget boots without a JS error, Hanafi and Ahl-e-Hadith results, already-paid, stale rates refreshed from the REST API, saved draft, no sideways scroll on a phone |

Tests marked `todo` are known issues from the 16 Oct 2026 audit (Phase 3); they report but do not fail CI until the fix lands. When a madhab rule changes on purpose, update the expected value in `tests/matrix.test.js` in the same pull request. `tests/` and `package.json` are not used by WordPress; `tests/.htaccess` keeps the test files from being served, and the root `.htaccess` blocks `*.md`, `*.json`, `*.sh` and `*.yml` and sets long browser caching for the versioned CSS and JS.
