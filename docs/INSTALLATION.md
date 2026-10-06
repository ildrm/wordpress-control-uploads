# Installation and quick start

This engineering build has open production acceptance gates. Use an isolated development/staging site; read RELEASE-STATUS.md first.

1. Build assets with `npm ci && npm run build`. Install the generated ZIP through WordPress Plugins, or place the source in `wp-content/plugins/content-firewall`.
2. Configure a persistent private path outside served roots:

```php
define('CF_PRIVATE_DIR', '/srv/private/content-firewall');
define('CF_AUDIT_KEY', getenv('CONTENT_FIREWALL_AUDIT_KEY'));
define('CF_CLAMD_SOCKET', 'unix:///run/clamav/clamd.ctl');
```

Create that directory with PHP/worker ownership, mode 0700. Install current ClamAV signatures. Enable required malware checks through Settings only after testing the scanner.

3. Activate the plugin. Schema version 1 creates fourteen tables and granular administrator capabilities. No remote provider credentials are inferred or bundled.
4. Start with Security Only. Upload a harmless synthetic image; verify the attachment summary and original private snapshot. Select a review preset only after connecting an appropriate provider.
5. Configure only the desired providers using constants or environment variables: `CF_OPENAI_KEY`, `CF_GOOGLE_TOKEN`, `CF_SIGHTENGINE_USER`/`CF_SIGHTENGINE_SECRET`, `CF_AWS_ACCESS_KEY`/`CF_AWS_SECRET_KEY`/`CF_AWS_REGION`/optional `CF_AWS_SESSION_TOKEN`, `CF_AZURE_KEY`/`CF_AZURE_ENDPOINT`, or `CF_CUSTOM_KEY`/`CF_CUSTOM_ENDPOINT`.
6. Run a worker from system cron. Test a provider outage and confirm that pending content remains private. Review your privacy disclosure and lawful evaluation corpus before enforcing content rules.

External API keys are never put into admin JavaScript. Google OAuth token renewal is the operator's responsibility in this version. For a public distribution, supply exact provider terms/privacy links and complete current plugin-review acceptance.

Upgrade: back up the DB and private filesystem together, test the package on staging, run `wp content-firewall database migrate`, confirm schema and queue health, then enable new features gradually. No previous release schema exists; migration from arbitrary older prototypes is not supported.
