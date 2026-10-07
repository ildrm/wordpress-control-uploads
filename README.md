# WordPress Content Firewall

An unreleased WordPress upload-governance implementation. **Full production acceptance remains open**; see [release status](docs/RELEASE-STATUS.md) and the [complete requirements ledger](docs/REQUIREMENTS-TRACEABILITY.md).

Implemented: private upload interception, file/resource checks, policy rules and private real-file/synthetic/history simulations, authenticated headless uploads, classic/scheduled publication checks, seven remote adapters including audio transcription, ClamD, image/SVG reconstruction, bounded text and located image redaction, DLP/QR payload inspection, leased jobs, local crash recovery, human review and uploader appeals, assignment/team/deadlines, saved queue views, resumable Setup, per-class retention and privacy export/erasure, optional PDF/video/audio processing and offline Content Credentials, REST, admin UI, CLI, audit and diagnostics.

Build and test:

```sh
composer install
npm ci
composer test
composer lint
composer analyse
npm run typecheck
npm test
npm run build
```

The real WordPress test environment uses test-only credentials and localhost port 8887:

```sh
docker compose -p cf-test -f compose.test.yml up -d db wordpress
docker compose -p cf-test -f compose.test.yml exec wordpress sh -c 'chown www-data:www-data /var/cf-private && chmod 700 /var/cf-private'
docker compose -p cf-test -f compose.test.yml run --rm cli wp core install --url=http://localhost:8887 --title='Firewall Test' --admin_user=admin --admin_password=cf-local-test-password --admin_email=admin@example.test --skip-email
docker compose -p cf-test -f compose.test.yml run --rm cli wp plugin activate content-firewall
docker compose -p cf-test -f compose.test.yml exec -u www-data wordpress php /var/www/html/wp-content/plugins/content-firewall/tests/Integration/run.php
docker compose -p cf-test -f compose.test.yml exec -u www-data wordpress php /var/www/html/wp-content/plugins/content-firewall/tests/Integration/review.php
docker compose -p cf-test -f compose.test.yml exec -u www-data wordpress php /var/www/html/wp-content/plugins/content-firewall/tests/Integration/hardening.php
docker compose -p cf-test -f compose.test.yml exec -u www-data wordpress php /var/www/html/wp-content/plugins/content-firewall/tests/Integration/privacy.php
docker compose -p cf-test -f compose.test.yml exec -u www-data wordpress php /var/www/html/wp-content/plugins/content-firewall/tests/Integration/workflows.php
docker compose -p cf-test -f compose.test.yml exec -u www-data wordpress php /var/www/html/wp-content/plugins/content-firewall/tests/Integration/publication-crash.php
npx playwright install chromium
npm run test:e2e
```

Use `CF_BROWSER_CHANNEL=chrome npm run test:e2e` when Chrome is already installed. The commands above show the basic sequence; [the complete testing guide](docs/TESTING.md) includes every integration suite, native tools, concurrency, browser and multisite order. They assume a fresh fixture. `compose.test.yml` stores the database in tmpfs: stopping/recreating the DB destroys its contents while WordPress config/files and private volumes may remain. Reinitialize a consistent disposable fixture before another installation, especially after multisite conversion; never reset a real site. Keep the fixture running through sequential database-mutating suites. Stop containers with `docker compose -p cf-test -f compose.test.yml down` only after finishing acceptance.

Build and verify a deterministic ZIP using `python3 tools/verify-release.py`. The artifact excludes development dependencies, tests and source TypeScript; no third-party PHP runtime packages are required. Composer PSR-4 loading is available in development; the distribution's equivalent autoloader supports installation without Composer. Verify generated API documentation with `python3 tools/openapi.py --check` and guide links/schema/evidence paths with `python3 tools/verify-docs.py`.

Read the [current 22-role production review](docs/PRODUCTION-REVIEW.md) and [earlier code review](docs/CODE-REVIEW.md).

Start with the [installation guide](docs/INSTALLATION.md), [operator runbook](docs/OPERATIONS.md), [provider contracts](docs/PROVIDER-MATRIX.md), [media processing](docs/MEDIA-PROCESSING.md), [privacy/retention](docs/PRIVACY.md), [threat model](docs/THREAT-MODEL.md) and [developer API](docs/DEVELOPER.md).
