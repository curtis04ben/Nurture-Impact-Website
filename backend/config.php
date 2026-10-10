<?php
/**
 * Nurture Impact: backend configuration.
 *
 * This file holds site-wide constants only, no secrets. Values that ARE
 * secrets (SMTP credentials) are read from environment variables or from
 * an optional, git-ignored backend/config.local.php (see README ->
 * "Contact form / email configuration"), never hard-coded here.
 *
 * All persistent-data paths are defined in ONE place (this file):
 *   - NI_DATA_DIR     (data/)           -> projects.json, articles.json, admin-credentials.json
 *   - NI_UPLOADS_DIR  (assets/uploads/) -> images uploaded via /admin
 * Everything else in the project is ordinary application code and can be
 * replaced at any time without losing content, as long as these two
 * folders are kept.
 */

// Optional server-specific settings (SMTP credentials etc.). This file is
// not committed; see README for an example. /backend is blocked from web
// access by backend/.htaccess, so it is never downloadable.
if (file_exists(__DIR__ . '/config.local.php')) {
    require_once __DIR__ . '/config.local.php';
}

// Change this if the site is deployed somewhere other than nurtureimpact.ie
define('NI_SITE_URL', 'https://www.nurtureimpact.ie');
define('NI_SITE_NAME', 'Nurture Impact');

// --- Persistent data locations -------------------------------------------
define('NI_DATA_DIR', __DIR__ . '/../data');
define('NI_PROJECTS_FILE', NI_DATA_DIR . '/projects.json');
define('NI_ARTICLES_FILE', NI_DATA_DIR . '/articles.json');
// Admin credentials live alongside the other content data (not under
// /backend) so backing up the data/ folder backs up everything the admin
// area can create or change. See README -> "Backups".
define('NI_CREDENTIALS_FILE', NI_DATA_DIR . '/admin-credentials.json');
define('NI_UPLOADS_DIR', __DIR__ . '/../assets/uploads');

// Maximum uploaded image size (bytes) accepted by the admin area: 5MB
define('NI_MAX_UPLOAD_BYTES', 5 * 1024 * 1024);

// --- Contact form / email -------------------------------------------------
// Where contact form submissions are sent.
define('NI_CONTACT_EMAIL', 'info@nurtureimpact.ie');

// Mail transport: 'mail' (PHP's built-in mail(), the default; works out
// of the box on most Apache/PHP hosting incl. Blacknight) or 'smtp' (for
// more reliable delivery, e.g. via a transactional email provider).
//
// To switch to SMTP, provide these values either as real environment
// variables (e.g. Apache "SetEnv" in the virtual host) or via putenv()
// calls in backend/config.local.php. Never edit them into this file:
//   NI_MAIL_TRANSPORT=smtp
//   NI_SMTP_HOST=smtp.example.com
//   NI_SMTP_PORT=587
//   NI_SMTP_ENCRYPTION=tls        (tls, ssl, or none)
//   NI_SMTP_USERNAME=...
//   NI_SMTP_PASSWORD=...
//   NI_MAIL_FROM_EMAIL=no-reply@nurtureimpact.ie
//   NI_MAIL_FROM_NAME=Nurture Impact Website
define('NI_MAIL_TRANSPORT', getenv('NI_MAIL_TRANSPORT') ?: 'mail');
