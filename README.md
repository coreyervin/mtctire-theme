# MTC Tire — WordPress Theme

Custom WordPress Full Site Editing (FSE) block theme for [MTC Tire Oakville](https://mtctire.ca) — a family-owned tire and automotive shop in Oakville, Ontario, serving the community since 2005.

## Tech Stack

- WordPress FSE block theme (no page builder)
- PHP 8.2
- Oswald + Inter (Google Fonts)
- Vanilla CSS (no framework)

## Theme Structure

```
mtctire-theme/
├── assets/
│   ├── css/          # Editor styles
│   └── images/       # Theme images (hero bg, shop photo)
├── parts/
│   ├── header.html   # Site header with navigation
│   └── footer.html   # Site footer with columns + copyright
├── patterns/         # Block patterns (homepage sections, service pages, etc.)
├── templates/        # Page templates (front-page, page, single, 404, etc.)
├── functions.php     # Shortcodes, schema, pattern registration
├── style.css         # Global styles
└── theme.json        # Design system (colours, fonts, spacing)
```

## Design System

| Token | Value |
|---|---|
| Primary background | `#111111` |
| Secondary background | `#0d0d0d` |
| Accent (orange) | `#f3832e` |
| Body text | `#aaaaaa` |
| Muted text | `#555555` |
| Heading font | Oswald |
| Body font | Inter |
| Max content width | 1140px |

## Shortcodes

| Shortcode | Description |
|---|---|
| `[mtc_hours]` | Dynamic business hours — auto-closes Saturdays from Victoria Day weekend through Labour Day weekend |
| `[mtc_copyright]` | Dynamic copyright line with founding year and current year |

## Pages

| Page | Template | Notes |
|---|---|---|
| Home | `front-page.html` | Hero, trust bar, services grid, about strip, brands, reviews, CTA |
| Services | `page-services.html` | Services landing with sidebar |
| Service pages (×6) | `page.html` | Tires & Wheels, Tire Storage, Automotive Repair, Wheel Alignment, Brake Inspection, Fleet Cards |
| Contact | `page-contact.html` | WPForms contact form + location info |
| About | `page.html` | About content pattern |
| Team | `page-wide.html` | Team photos and bios |
| Blog | `home.html` | Posts index, 3-column grid |
| Environmental Commitment | `page-wide.html` | OTS partnership, eco products |
| Manufacturer Rebates | `page-wide.html` | Brand rebate cards linking to treadpro.ca/promotions |
| Privacy Policy | `page-wide.html` | PIPEDA-compliant privacy policy |

## Plugins Required

- **WPForms** — contact form (form ID 1140)
- **Yoast SEO** — meta titles, descriptions, sitemaps
- **TrustIndex** — Google reviews widget (`[trustindex no-registration=google]`)

## Deployment Notes

After deploying to production, run a search-replace on the database:

```bash
wp search-replace 'mtctire.local' 'mtctire.ca' --all-tables
```

301 redirects for old site URLs are configured in `.htaccess` (lives in the WordPress root, not this repo).
