# Installation and quick start

This engineering build has open production acceptance gates. Use an isolated development/staging site; read RELEASE-STATUS.md first.

1. Build assets with `npm ci && npm run build`. Install the generated ZIP through WordPress Plugins, or place the source in `wp-content/plugins/content-firewall`, with `content-firewall.php` directly inside that directory. [PLUGIN-STRUCTURE.md](PLUGIN-STRUCTURE.md) describes the canonical layout. If replacing the earlier engineering build, deactivate it first and reactivate after replacement because its main-file basename changed.
2. Configure a persistent private path outside served roots:

```php
define('CF_PRIVATE_DIR', '/srv/private/content-firewall');
// Supply a secret generated from at least 32 random bytes before production use.
// CF_AUDIT_KEY may also be supplied directly as an environment variable.
$cf_audit_key = getenv('CONTENT_FIREWALL_AUDIT_KEY');
if (is_string($cf_audit_key)) { define('CF_AUDIT_KEY', $cf_audit_key); }
define('CF_CLAMD_SOCKET', 'unix:///run/clamav/clamd.ctl');
```

Create that directory with PHP/worker ownership, mode 0700. Install current ClamAV signatures. Enable required malware checks through Settings only after testing the scanner.

3. Ensure PHP 8.2+ has fileinfo, mbstring and sodium; image processing also needs GD, SVG needs DOM, Office/archive inspection needs ZIP and HTTP adapters need curl. Activate the plugin. Schema version 2 maintains fourteen tables, explicit metadata-erasure state and guarded migrations and granular administrator capabilities. No remote provider credentials are inferred or bundled.
4. Open Setup; its four steps persist progress and validate policy/privacy/limit inputs. Start with Security Only. Upload a harmless synthetic image; verify the attachment summary and original private snapshot. Select a review preset only after connecting an appropriate provider.
5. Configure only the desired providers using constants or environment variables: `CF_OPENAI_KEY`, `CF_GOOGLE_TOKEN`, `CF_SIGHTENGINE_USER`/`CF_SIGHTENGINE_SECRET`, `CF_AWS_ACCESS_KEY`/`CF_AWS_SECRET_KEY`/`CF_AWS_REGION`/optional `CF_AWS_SESSION_TOKEN`, `CF_AZURE_KEY`/`CF_AZURE_ENDPOINT`, or `CF_CUSTOM_KEY`/`CF_CUSTOM_ENDPOINT`. Audio transcription uses the separate `CF_OPENAI_TRANSCRIPTION_KEY`.
6. Run a worker from system cron. Test a provider outage and confirm that pending content remains private. Review your privacy disclosure and lawful evaluation corpus before enforcing content rules.

External API keys are never put into admin JavaScript. Google OAuth token renewal is the operator's responsibility in this version. For a public distribution, supply exact provider terms/privacy links and complete current plugin-review acceptance.

Upgrade: back up the DB and private filesystem together, test the package on staging, run `wp content-firewall database migrate`, confirm schema and queue health, then enable new features gradually. No previous released schema exists. The schema-1 prototype upgrades to 2 through dbDelta under a per-blog database lock; arbitrary older prototypes and large historical transformations need separate migration acceptance.

Optional media tools are deployment dependencies, never bundled binaries. Set `CF_PDFINFO_BIN`, `CF_PDFTOPPM_BIN`, `CF_PDFTOTEXT_BIN` for PDF; `CF_FFMPEG_BIN`, `CF_FFPROBE_BIN` for video/audio; and `CF_C2PA_BIN` for exactly c2patool 0.28.1 with optional `CF_C2PA_TRUST_ANCHORS`. Then enable only tested flags in Settings. See MEDIA-PROCESSING.md for parser isolation, bounds, transformations, credential loss and unsupported paths. Completing Setup does not certify these tools, privacy disclosure or detection quality.

For the disposable Linux fixture only, install native dependencies inside its WordPress service and run harmless tests:

```sh
docker compose -p cf-test -f compose.test.yml exec wordpress sh -c 'apt-get update && apt-get install -y --no-install-recommends ffmpeg poppler-utils'
docker compose -p cf-test -f compose.test.yml exec -e CF_FFMPEG_BIN=/usr/bin/ffmpeg -e CF_FFPROBE_BIN=/usr/bin/ffprobe -e CF_PDFINFO_BIN=/usr/bin/pdfinfo -e CF_PDFTOPPM_BIN=/usr/bin/pdftoppm -e CF_PDFTOTEXT_BIN=/usr/bin/pdftotext -u www-data wordpress php /var/www/html/wp-content/plugins/content-firewall/tests/Integration/media-tools.php
docker compose -p cf-test -f compose.test.yml exec -e CF_FFMPEG_BIN=/usr/bin/ffmpeg -e CF_FFPROBE_BIN=/usr/bin/ffprobe -e CF_PDFINFO_BIN=/usr/bin/pdfinfo -e CF_PDFTOPPM_BIN=/usr/bin/pdftoppm -e CF_PDFTOTEXT_BIN=/usr/bin/pdftotext -u www-data wordpress php /var/www/html/wp-content/plugins/content-firewall/tests/Integration/processing.php
```

These commands install tools only in the test container. They do not configure the web service permanently or repair the host installation. Production builds must pin/maintain tool versions in their own deployment and enforce OS limits/network denial. The acceptance script uses benign synthetic media, mocked moderation and no live provider credentials.

The test DB is tmpfs. Stopping its container destroys the database while named WordPress/private volumes may survive. Fresh installation commands require a consistent empty fixture; retained multisite constants/core files and a reset DB can disagree. Reinitialize only disposable test state, or use a separate fresh Compose project/port. Do not use fixture reset commands on a real deployment. Run DB-mutating suites sequentially, with browser acceptance before multisite conversion. [TESTING.md](TESTING.md) provides the full ordered validation sequence.

Production requires a dedicated `CF_AUDIT_KEY` outside the database, 32–4096 bytes in length, generated with adequate randomness. Empty, non-string or short explicitly configured keys fail with CONFIGURATION.AUDIT_KEY; they cannot produce predictable signatures or silently select a fallback. Development/staging with no dedicated key may use WordPress salts, whose rotation changes verifiability and whose fallback material may be stored by WordPress in the DB. The development fallback is not a production signing-key guarantee. Set the key in deployment before opening Setup or running services on a production site.
