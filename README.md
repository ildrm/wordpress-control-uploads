# WordPress Content Firewall

An unreleased WordPress upload-governance implementation. **Full production acceptance remains open**; see [release status](docs/RELEASE-STATUS.md) and the [complete requirements ledger](docs/REQUIREMENTS-TRACEABILITY.md).

Implemented: private upload interception, file/resource checks, policy rules and simulations, six remote moderation adapters, ClamD, safe image/SVG reconstruction, DLP/QR payload inspection, leased jobs, human review/appeals API, REST, admin UI, CLI, audit and diagnostics.

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
npx playwright install chromium
npm run test:e2e
```

Use `CF_BROWSER_CHANNEL=chrome npm run test:e2e` when Chrome is already installed. Stop test containers with `docker compose -p cf-test -f compose.test.yml down`; do not remove retained volumes until finished.

Build a deterministic ZIP using `python3 tools/package.py`. The artifact excludes development dependencies, tests and source TypeScript; no third-party PHP runtime packages are required. Composer PSR-4 loading is available in development; the distribution's equivalent autoloader supports installation without Composer.

Read the [role-based code review and fixes](docs/CODE-REVIEW.md).

Start with the [installation guide](docs/INSTALLATION.md), [operator runbook](docs/OPERATIONS.md), [provider contracts](docs/PROVIDER-MATRIX.md), [threat model](docs/THREAT-MODEL.md) and [developer API](docs/DEVELOPER.md).
