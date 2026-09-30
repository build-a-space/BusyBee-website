# Busy Bee Window & Gutter Cleaning — Website

SEO-focused PHP website for **busybeewg.com**. No database needed: settings live in a JSON file that the admin panel edits.

## Requirements
- PHP 8.1+ (with `fileinfo`, `mbstring`, `gd` optional)
- Apache with `mod_rewrite` (most shared hosts), or Nginx (see below)

## Deploy
1. Upload everything in this folder to your web root (`public_html`).
2. Make `data/` and `uploads/` writable by PHP (`chmod 755`, or `775` on some hosts).
3. Visit **`/dashboard-4-admin-panel`** right away and create your admin username + password (first-run setup only; the setup screen disappears once an account exists).
4. In **Business Info**, confirm the Website URL (`https://busybeewg.com`). It's used for canonicals, schema and the sitemap.
5. Submit `https://busybeewg.com/sitemap.xml` in Google Search Console.

Local preview: `php -S localhost:8000 router.php`

### Nginx
```
location ~ ^/(data|includes|templates|admin)/ { deny all; }
location ^~ /uploads/ { location ~ \.php$ { deny all; } }
location / { try_files $uri /index.php?$query_string; }
```

## Admin panel (`/dashboard-4-admin-panel`)
| Section | What you can change |
|---|---|
| Dashboard | One-click **site ON/OFF**, stats, latest estimate requests |
| Site On/Off | Maintenance page message, top announcement bar |
| Business Info | Phone numbers, emails, address, map, hours, rating, social links, homepage headline |
| Logos & Branding | Logo, favicon, homepage hero photo, social-share image, brand colors |
| Pages & SEO | Publish/unpublish any page; custom SEO title, meta description, H1 and image per page |
| Reviews | Add/edit/delete customer testimonials (also output as Review schema) |
| Messages | Inbox of every form submission (also emailed to you) |
| Media Library | Upload/delete photos |
| SEO & Tracking | Highlighted keywords, auto-interlinking, GA4, Search Console/Bing verification, 301 redirects |
| Account | Change username/password |

Security: bcrypt passwords, CSRF tokens, 5-attempt login lockout (15 min), `noindex` headers, private folders blocked by `.htaccess`, uploads can't execute code. To move the panel to a different secret URL, change `ADMIN_PATH` in `includes/config.php`.

## SEO features
- The URL structure matches the current site (e.g. `/gutter-cleaning`, `/shrewsbury-worcester-county-ma-window-cleaning`, `/middlesex-county-massachusetts`). Old URLs 301-redirect, and you can manage these in the admin.
- JSON-LD `@graph` on every page: LocalBusiness/HomeAndConstructionBusiness (address, geo, hours, areaServed, OfferCatalog, AggregateRating, Reviews), WebSite, WebPage, BreadcrumbList, Service, FAQPage, HowTo, BlogPosting, ItemList.
- Automatic internal linking and keyword highlighting (`includes/functions.php → enrich()`).
- Dynamic `sitemap.xml` and `robots.txt` (the site blocks crawlers automatically while it's switched OFF).
- Canonical URLs, Open Graph/Twitter cards, geo meta tags, breadcrumbs, and one-H1-per-page semantic HTML.
- Mobile-first, click-to-call button, and accessible navigation and FAQ accordions.

## Editing content
Service, town, county, blog and FAQ copy lives in `includes/content.php`. To add a town, add a line to `towns()` and its key to the county's `towns` list. The page, links, sitemap entry and schema are created automatically.
