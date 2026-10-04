# My Zakat Tool

WordPress plugin behind [myzakattool.com](https://myzakattool.com/): a zakat calculator for every madhab (Hanafi, Shafi'i, Maliki, Hanbali, Ahl-e-Hadith, Shia Ja'fari) with live gold and silver rates, a side-by-side madhab comparison, a PDF report, and the whole site (pages, guides, menu, SEO, schema, icons) built in.

## Deployment

Hostinger Git deploy pulls the `main` branch into `public_html/wp-content/plugins/myzakattool`, so the plugin files live at the repo root.

Git deploys do not fire WordPress's activation hook, so the plugin installs itself the first time someone opens **wp-admin** after a deploy with a new version number:

- First install only: site title "My Zakat Tool", tagline, `/%postname%/` permalinks, comments off, the untouched "Hello world" post and "Sample page" moved to trash, a main menu.
- Every version change: creates any of the 28 pages and 5 guide posts that are missing, and updates pages it created to the new text unless someone has edited them, sets the home page as the static front page, schedules the hourly rate refresh and fetches rates once.

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
| `[zakat_calculator madhab="hanafi" compare="1"]` | The calculator (madhab optional) |
| `[zakat_gold_rate]` | Gold and silver rate tables |
| `[zakat_nisab]` | Today's nisab (server-rendered) |
| `[zakat_fitrana]`, `[zakat_fidya]`, `[zakat_khums]` | Fitrana, fidya/kaffara and khums calculators |
| `[zakat_hawl]`, `[zakat_ushr]` | Zakat date / hawl tracker (reminders, missed years) and ushr + livestock calculators |
| `[myzt_embed_code currency="PKR"]` | Preview and copy code for the embeddable nisab widget (`assets/js/embed.js`) |
| `[myzt_reviewed rates="1"]` | "Rules last reviewed" date (Settings) and a dated snapshot of the rates |
| `[myzt_rate type="gold-tola"]` | One live number in text (`gold-gram`, `gold22-tola`, `silver-tola`, `silver-gram`, `nisab-silver`, `nisab-gold`, `gold-tola-zakat`, `gold22-tola-zakat`) |
| `[myzt_answer]...[/myzt_answer]` | Quick-answer box |
| `[myzt_faq]` | FAQ from the page's FAQ data (with FAQPage schema) |
| `[myzt_author]`, `[myzt_trust]`, `[myzt_related slugs="a,b"]`, `[myzt_guides]`, `[myzt_year]`, `[myzt_ad where="article"]` | Author box, trust badges, related links, guide list, season year, ad slot |

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

```
node --test tests/engine.test.js
```

The engine (`assets/js/engine.js`) holds every madhab rule with its source; the tests pin the results for a fixed sample across all six madhabs.
