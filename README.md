# Nurture Impact Website

This README explains how the site is built, how to run it locally, and how
to deploy and maintain it on a conventional PHP + Apache host (Blacknight
shared hosting in production). It's written for someone relatively new to
web development.

---

## 1. What's in this project

```
/
├── index.php                  Homepage (dynamic: shows latest published projects & articles)
├── index.html                  Old URL; redirects to index.php
├── about.html                   About Alan / Nurture Impact
├── services.html                 All services overview
├── governance.html                Governance, Strategy & Board Development
├── grant-applications.html         Funding & Grant Applications
├── events-workshops.html            Events & Workshops
├── events.html                       Old URL; redirects to events-workshops.html
├── projects.php                       Projects list (dynamic, reads /data/projects.json)
├── project.php                         Single project page (?slug=...)
├── insights.php                         Insights/Articles list (dynamic, reads /data/articles.json)
├── article.php                           Single article page (?slug=...), with LinkedIn share
├── contact-handler.php                    Contact form submission handler (sends email)
├── styles.css                              One shared stylesheet for the whole site
├── favicon.ico, assets/favicon-*.png        Browser tab icons
├── assets/js/contact-form.js                 Contact form AJAX + success/error banner
├── .htaccess                                  Pretty URLs + security rules (see below)
├── includes/
│   ├── content.php                             Read/write the JSON content store
│   ├── mailer.php                               Contact-form email building + sending
│   └── partials/nav.php, footer.php              Shared header/footer for the .php pages
├── data/
│   ├── projects.json                              Source of truth for Projects
│   ├── articles.json                               Source of truth for Insights
│   └── admin-credentials.json                       Created automatically: admin login (not shipped)
├── backend/
│   ├── config.php                                   Site constants (paths, contact email, mail transport)
│   └── config.local.php                              Optional, not committed: server-specific secrets (see §6)
├── admin/                                             Password-protected content editor (see §5)
└── assets/                                             Images, incl. assets/uploads/ for admin-uploaded images
```

Most of the site is still plain HTML/CSS: Home, About, Services, Governance
and Grant Applications are readable files you can edit directly. Projects,
Insights and the homepage's "latest content" sections are PHP-powered
because they need to update automatically as content is published, without
anyone editing HTML by hand.

---

## 2. Contact details used on the site

- **Email:** `info@nurtureimpact.ie` (shown in the footer, About, and used as
  the contact form's destination)
- **Phone:** intentionally not shown publicly anywhere on the site
- **LinkedIn:** links to `https://www.linkedin.com/in/curtisalan` (Alan's
  profile)

If any of these change again in future, this is where they're defined:
- Email: `backend/config.php` → `NI_CONTACT_EMAIL`, plus the visible
  `mailto:` links in `includes/partials/footer.php` and each page's own
  footer/about section.
- LinkedIn: search the project for `linkedin.com/in/curtisalan`.

---

## 3. Why PHP + JSON files (not a database)?

Blacknight's standard shared hosting runs Apache + PHP, which is enough to
run this whole site. Rather than adding a MySQL database, Projects and
Articles are stored as two JSON files in `/data`. The admin area reads and
writes those files directly, and the homepage/Projects/Insights pages
always read the current content live, so publishing something in
`/admin` immediately becomes the newest item everywhere it's shown,
without editing any HTML. This keeps the site:

- Deployable by uploading files only, with no database creation step
- Easy to back up (the JSON files are just text; copy them anywhere)
- Simple to inspect or hand-edit if you're ever comfortable doing so

If content volume grows a lot in future, `includes/content.php` is the one
place that would need to change to move to MySQL. Nothing else in the
site would need to change, because every page calls through those
functions rather than reading files directly.

---

## 4. Running locally

You need PHP 8.x with the standard extensions (`json`, `fileinfo`,
`mbstring`). There's no build step: no npm, no compiling.

### 4.1 Quick preview (PHP's built-in server)

```bash
php -S localhost:8000
```

Then open `http://localhost:8000/` (serves `index.php` automatically) and
`http://localhost:8000/admin/` to set up your admin login. Edit a file and
refresh the page to see the change.

The built-in server ignores `.htaccess`, so the pretty URLs
(`/insights/your-slug`) and the "deny direct access" rules don't apply in
this mode. The `?slug=...` links the site itself uses work fine.

### 4.2 Full Apache preview (matches production)

To test `.htaccess` behaviour exactly as Blacknight will run it, serve the
folder with Apache + mod_php (or PHP-FPM) and make sure the vhost has
`AllowOverride All` and `mod_rewrite` / `mod_headers` enabled. For example
on Fedora:

```bash
sudo dnf install httpd php php-mbstring
# point a <VirtualHost> or Alias at this folder with AllowOverride All
sudo systemctl start httpd
```

The web server user (e.g. `apache`) needs write access to `data/` and
`assets/uploads/` for the admin area to save content.

---

## 5. The admin area at a glance

- URL: `/admin/`
- Protected by username/password (set on first visit via `/admin/setup.php`)
- Two content types: **Articles** (Insights) and **Projects**
- Each has a list view (Edit/Delete) and an add/edit form with image upload
- A **Published** checkbox controls visibility: unticked items are drafts,
  visible only in `/admin`, never on the public site or homepage
- The homepage, `/insights.php` and `/projects.php` always show the
  **newest published** items first (by date) automatically, with nothing to
  configure

To reset a forgotten admin password: delete `data/admin-credentials.json`
on the server and visit `/admin/` again to go through setup once more.

---

## 6. Contact form / email configuration

Every contact form on the site (homepage, About, Services, Governance,
Grant Applications, Events & Workshops) submits via JavaScript to
`contact-handler.php`, which:

- Validates the name, email and message are present and the email address
  is well-formed
- Silently discards anything caught by a hidden honeypot field (basic spam
  protection) without sending mail, but still reports "success" to the
  (bot) submitter so it gets no useful signal
- Strips line breaks from any field used in an email header (defends
  against header-injection spam)
- Sends **`info@nurtureimpact.ie`** an email with all submitted fields in
  an HTML table, plus a plain-text fallback version (a proper
  multipart/alternative email; most inboxes will show the HTML table)
- Reports success/failure back to the visitor inline on the page (no
  redirect, no exposed server errors), and still works, via a redirect,
  if JavaScript is unavailable

### Mail transport

Two transports are supported, chosen by the `NI_MAIL_TRANSPORT` setting
(read from an environment variable, never hard-coded):

- **`mail` (default):** PHP's built-in `mail()`, which hands off to the
  server's local mail setup. This works out of the box on Blacknight
  shared hosting and most conventional Apache/PHP hosts with no extra
  configuration.
- **`smtp`:** a small built-in SMTP client (no external library added)
  for sending via a real mail provider, useful where local `mail()`
  delivery is unreliable (for example a local machine with no mail
  server). Configure it with these values:

  ```
  NI_MAIL_TRANSPORT=smtp
  NI_SMTP_HOST=smtp.example.com
  NI_SMTP_PORT=587
  NI_SMTP_ENCRYPTION=tls
  NI_SMTP_USERNAME=...
  NI_SMTP_PASSWORD=...
  NI_MAIL_FROM_EMAIL=no-reply@nurtureimpact.ie
  NI_MAIL_FROM_NAME=Nurture Impact Website
  ```

  Provide them either as real environment variables (Apache `SetEnv` in
  the virtual host, or however your host's control panel exposes them),
  or by creating `backend/config.local.php` on the server:

  ```php
  <?php
  putenv('NI_MAIL_TRANSPORT=smtp');
  putenv('NI_SMTP_HOST=smtp.example.com');
  putenv('NI_SMTP_PORT=587');
  putenv('NI_SMTP_ENCRYPTION=tls');
  putenv('NI_SMTP_USERNAME=...');
  putenv('NI_SMTP_PASSWORD=...');
  ```

  `backend/` is blocked from web access by `backend/.htaccess`, so this
  file can never be downloaded. **No SMTP password or API key is ever
  committed to this project:** `backend/config.local.php` is listed in
  `.gitignore`.

### A note on testing

The SMTP transport is implemented as a plain, from-scratch client (SMTP
handshake, STARTTLS, AUTH LOGIN) since adding a full mailer library felt
like more than this simple site needs, but it has **not** been exercised
against a live mail server during development. Test it against your real
provider (e.g. send yourself a test enquiry through the live form) before
relying on it for production. The default `mail()` transport is the
simpler, more broadly-compatible option for Blacknight and is what's
enabled unless you deliberately switch it.

---

## 7. Deploying to Blacknight (production)

### 7.1 What gets uploaded

Upload the **entire contents of this folder** to your hosting account's
web root (usually `public_html/` or `httpdocs/`) via FTP/SFTP or the
Blacknight File Manager. Make sure hidden files (`.htaccess`) are
included: set your FTP client to show hidden files, or they won't
transfer. Don't overwrite the live `data/` folder once the site has real
content (see §8).

### 7.2 Database

**None required.** Projects and Articles are stored as JSON files, not in
MySQL.

### 7.3 File permissions

The web server needs to **write** to two places so the admin area can
save content and uploaded images:

- `/data/` (and the files inside it)
- `/assets/uploads/`

Set permissions on those folders to **755** (or **775** if 755 doesn't
work) via FTP or Blacknight's File Manager.

### 7.4 Setting up the admin area

1. Visit `https://www.nurtureimpact.ie/admin/`.
2. The first visit shows a one-time setup form: choose a username and
   password (this creates `data/admin-credentials.json`).
3. From then on, `/admin/` shows a normal login form.

### 7.5 Publishing content

Log into `/admin/` → **Articles** or **Projects** → **+ New...** → fill in
the fields → tick **Published** → Save. It appears immediately on the
relevant list page, at its own pretty URL (`/insights/your-slug` or
`/projects/your-slug`), and, if it's the newest published item, on the
homepage. Leaving **Published** unticked keeps it as a draft.

### 7.6 Pretty URLs

`.htaccess` rewrites `/insights/your-slug` to `article.php?slug=your-slug`
(and similarly for `/projects/your-slug`). This needs Apache's
`mod_rewrite`, standard on Blacknight. If pretty URLs don't work, contact
Blacknight support to confirm `mod_rewrite` is enabled. The `?slug=...`
links keep working either way.

### 7.7 Contact form on Blacknight

Leave `NI_MAIL_TRANSPORT` unset (defaults to `mail`) unless you have a
specific reason to use SMTP. Blacknight's shared hosting supports PHP's
`mail()` out of the box.

---

## 8. Backups and rollback

Because there's no database, a full backup is just a copy of the files.

**Before every deployment:**
1. Download a full copy of the current live site via FTP into a dated
   folder, e.g. `backup-2026-09-15/`. Pay particular attention to
   `/data/` (published content + admin login) and `/assets/uploads/`:
   these are the only things that can't be regenerated from the code.
2. Keep at least the last 2 or 3 dated backups.

**To roll back:** upload the previous dated backup's files back over the
live site via FTP. If only content changed, you can instead just restore
`/data/projects.json` and `/data/articles.json` without touching anything
else.

**Recommended safety net:** if comfortable, deploy to a staging subdomain
first (e.g. `staging.nurtureimpact.ie`) and check it before copying the
same files to the live site.

---

## 9. Security notes

- `data/admin-credentials.json`, `data/projects.json` and
  `data/articles.json` can never be downloaded directly: `.htaccess`
  denies all direct requests for `*.json` site-wide, plus `/data/` and
  `/backend/` each additionally deny all direct access outright.
- Uploaded images are restricted to JPEG/PNG/WEBP/GIF (checked by actual
  file content, not just the filename), capped at 5MB, saved under a
  randomly generated filename, and `assets/uploads/.htaccess` prevents
  anything in that folder from ever being executed as a script, even if
  someone found a way to upload a disguised file.
- Contact form input is escaped before being placed in the HTML email, and
  stripped of line breaks before being used in any email header, to
  prevent injection.
- Admin login has a small growing delay after failed attempts (basic
  brute-force friction) on top of the existing hashed-password check.
- No secrets are stored in any committed file. SMTP credentials are read
  from environment variables or the git-ignored
  `backend/config.local.php` only.

---

## 10. Images

Section/service images were rebalanced so the same photo isn't reused
across unrelated pages, and a couple of images that were mismatched to
the wrong topic (a funding-process graphic labelled "Strategy & Planning",
a funding-appraisal photo labelled "Bespoke Consultancy") were corrected.
Two exact-duplicate crops of the same stock photo (`workshop_1.png`,
`workshop_2.png`) and one unused near-duplicate (`funding.png`) were
removed since nothing referenced them after the rebalance. Every
remaining asset in `/assets` is referenced from at least one page or
content entry.
