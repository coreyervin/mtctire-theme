# MTC Tire — Theme Development Guide

## Project Overview

Custom WordPress FSE block theme for **MTC Tire Oakville** (`mtctire.ca`). Built locally in LocalWP, deployed to SiteGround via All-in-One WP Migration (AIOWPM). AIOWPM handles URL replacement (`mtctire.local` → `mtctire.ca`) automatically on import.

- **Local:** `http://mtctire.local`
- **Production:** `https://mtctire.ca`
- **Theme path:** `wp-content/themes/mtctire-theme/`
- **DB:** LocalWP MySQL — user `root`, password `root`, database `local`
  - Socket: `/Users/coreyervin/Library/Application Support/Local/run/CjmX_QT-y/mysql/mysqld.sock`
  - Binary: `/Applications/Local.app/Contents/Resources/extraResources/lightning-services/mysql-8.0.35+4/bin/darwin-arm64/bin/mysql`

## Design System

- **Background:** `#111111` (primary), `#0d0d0d` (secondary), `#161616` (trust bar)
- **Accent:** `#f3832e` (orange)
- **Text:** `#ffffff` (headings), `#aaaaaa` (body), `#666666` (muted)
- **Fonts:** Oswald (headings, uppercase), Inter (body/UI)
- **Borders/dividers:** `#1e1e1e`, `#222222`, `#2a2a2a`

## Architecture

### Templates (`templates/`)

| File | Used by |
|------|---------|
| `front-page.html` | Home page (static front page) |
| `page-contact.html` | Contact page (slug: `contact`) |
| `page-services.html` | Services landing (slug: `services`) |
| `page.html` | All other pages — two-column layout with service sidebar |
| `page-wide.html` | Wide full-width pages |
| `home.html` | Blog index (not the front page) |
| `single.html` | Blog posts |
| `archive.html` | Archive pages |

All page templates use `<!-- wp:post-content /-->` — page content lives in `post_content` and is editable in the WordPress Page Editor (Pages → Edit).

### Parts (`parts/`)
- `header.html` — site header with nav
- `footer.html` — footer with hours shortcode and copyright

### Patterns (`patterns/`)

PHP pattern files are **not** the live source of truth for most content — see the Synced Patterns section below. The PHP files serve as the seed source and as re-usable block inserter patterns.

| File | Purpose |
|------|---------|
| `hero.php` | Home page hero section |
| `trust-bar.php` | 4-item trust bar (rating, certified, Nokian, family-owned) |
| `services-grid.php` | Home page services grid |
| `about-strip.php` | Home page about strip |
| `brands.php` | Brands section |
| `reviews.php` | Google reviews (Trustindex shortcode) |
| `cta-banner.php` | CTA banner — used on all service/content pages |
| `service-sidebar.php` | Right sidebar — used on all service/content pages |
| `page-hero.php` | Page hero (dynamic — reads page title/featured image) |
| `service-*.php` | Individual service page content patterns |

## Synced Patterns (wp_block posts)

The seeder in `functions.php` (`mtc_seed_synced_patterns`, init priority 20) creates `wp_block` posts from the PHP pattern files. These IDs are stored in `wp_options` as `mtc_synced_pattern_ids`.

**Critical:** After initial seeding, the **DB `wp_block` post is the source of truth**, not the PHP file. Editing a PHP pattern file does NOT update the live site.

### To edit synced pattern content
- **Preferred:** Appearance → Editor → Patterns → find the pattern → edit visually
- **Direct DB update:** MySQL UPDATE on `wp_posts` where `post_type = 'wp_block'`

### Synced pattern IDs (local DB)
| Key | wp_block ID | Pattern |
|-----|-------------|---------|
| `mtc-front-hero` | 1157 | Hero |
| `mtc-front-trust-bar` | 1158 | Trust Bar |
| `mtc-front-services-grid` | 1159 | Services Grid |
| `mtc-front-about-strip` | 1160 | About Strip |
| `mtc-front-brands` | 1161 | Brands |
| `mtc-front-reviews` | 1162 | Reviews |
| `mtc-front-cta-banner` | 1163 | CTA Banner |
| `mtc-service-sidebar` | 1164 | Service Sidebar |

### To re-seed from scratch
Delete the option flag, then reload any page:
```sql
DELETE FROM wp_options WHERE option_name = 'mtc_synced_patterns_v2';
```

## Page Content Seeders

Two pages have their content seeded directly into `post_content` via `$wpdb->update()` (bypasses `wp_kses_post` which strips `<style>` tags):

| Seeder function | Page | Flag option | Page ID |
|----------------|------|-------------|---------|
| `mtc_seed_home_page` (priority 25) | Home | `mtc_home_page_seeded_v1` | 60 |
| `mtc_seed_contact_page` (priority 26) | Contact | `mtc_contact_page_seeded_v1` | 129 |

**Never use `wp_update_post()` to write block content containing `<style>` tags** — it will strip them silently. Always use `$wpdb->update()` directly.

To re-seed a page, delete its flag:
```sql
DELETE FROM wp_options WHERE option_name = 'mtc_home_page_seeded_v1';
-- or
DELETE FROM wp_options WHERE option_name = 'mtc_contact_page_seeded_v1';
```
Then clear the page's post_content and reload any page to trigger init hooks.

## Key Page IDs

| ID | Title | Slug | Template |
|----|-------|------|----------|
| 60 | Home | `home` | `front-page.html` |
| 80 | About Us | `about` | `page.html` |
| 129 | Contact | `contact` | `page-contact.html` |
| 1112 | Services | `services` | `page-services.html` |
| 1122 | Tires & Wheels | `tires-wheels` | `page.html` |
| 1125 | Tire Storage | `tire-storage` | `page.html` |
| 1127 | Automotive Repair | `automotive-repairs-maintenance` | `page.html` |
| 1129 | Wheel Alignment | `wheel-alignment-oakville` | `page.html` |
| 1131 | Brake Inspection | `brake-inspection-repairs-oakville` | `page.html` |
| 1133 | Safety Inspection | `provincial-safety-inspection` | `page.html` |

## functions.php — Key Hooks

### Shortcodes
- `[mtc_hours]` — renders business hours dynamically; reads open/close times from `wp_options` (`mtc_hours_weekday_open`, etc.); summer Saturday closure calculated automatically (Victoria Day weekend → Labour Day weekend)
- `[mtc_rating]` — outputs the Google rating value from `wp_options` (`mtc_rating_value`); used in Trust Bar, About Strip, and Home page content
- `[mtc_copyright]` — dynamic copyright year range (2005–current)

### Settings Page
**Settings → Business Hours** — edits weekday/Saturday hours and Google rating/review count, all stored in `wp_options`. The dynamic summer Saturday closure logic is code-only and not exposed here.

| Option key | Default | Used in |
|---|---|---|
| `mtc_hours_weekday_open` | `8:00am` | `[mtc_hours]` shortcode |
| `mtc_hours_weekday_close` | `5:30pm` | `[mtc_hours]` shortcode |
| `mtc_hours_sat_open` | `9:00am` | `[mtc_hours]` shortcode |
| `mtc_hours_sat_close` | `2:00pm` | `[mtc_hours]` shortcode |
| `mtc_rating_value` | `4.6` | `[mtc_rating]` shortcode + JSON-LD schema |
| `mtc_rating_count` | `200` | JSON-LD schema only |

`mtc_is_summer_sat_closed()` — shared helper used by both the `[mtc_hours]` shortcode and the JSON-LD schema to avoid duplicating the Victoria Day/Labour Day date logic.

### Filters
- `render_block_core/html` → `do_shortcode` — makes shortcodes work inside Custom HTML blocks
- `get_block_templates` — replaces `wp:pattern` slug refs for `mtctire/cta-banner` and `mtctire/service-sidebar` in theme templates with their synced `wp:block {"ref":ID}` equivalents at runtime

### Schema
JSON-LD `LocalBusiness` / `AutoRepair` schema injected sitewide in `<head>` (priority 5). Includes dynamic `openingHoursSpecification` that respects the summer Saturday closure.

### Promo URL checker
`wp_ajax_mtc_check_url` — server-side HEAD request proxy for the Manufacturer Rebates page. Validates treadpro.ca URLs only; 24h transient cache.

## Making Copy Changes

### Service page content (About, service pages)
Edit directly in WordPress: **Pages → [page name] → Edit**. All service pages use `page.html` which renders `post_content`.

### Home page sections
Go to **Pages → Home → Edit** — all 7 sections (hero, trust bar, services grid, about strip, brands, reviews, CTA) are editable as blocks.

### Contact page
Go to **Pages → Contact → Edit** — two-column layout (form + find us) is fully editable.

### CTA Banner & Service Sidebar
These are synced patterns used across all service pages: **Appearance → Editor → Patterns → MTC Tire**.

### Business Hours
**Settings → Business Hours** — updates the `[mtc_hours]` shortcode output everywhere it appears (contact page, anywhere else it's embedded).

### Google Rating
**Settings → Business Hours → Google Rating** — updates both the `[mtc_rating]` shortcode (Trust Bar, About Strip, Home page) and the JSON-LD `aggregateRating` schema. The review count field updates the schema only (not shown visibly on the site).

## Deployment

1. Export from LocalWP via AIOWPM (All-in-One WP Migration)
2. Import to SiteGround
3. AIOWPM automatically replaces `mtctire.local` → `mtctire.ca` in DB
4. After import, flush SG Optimizer cache (SiteGround → Speed → Caching) — otherwise public visitors see stale pages

## MySQL Direct Access (LocalWP)

```bash
"/Applications/Local.app/Contents/Resources/extraResources/lightning-services/mysql-8.0.35+4/bin/darwin-arm64/bin/mysql" \
  -u root -proot \
  --socket="/Users/coreyervin/Library/Application Support/Local/run/CjmX_QT-y/mysql/mysqld.sock" \
  local
```
