# Reproducing validation

Use a disposable local development site. Integration tests intentionally create users, posts, policies and scan records and change test configuration. Do not run them against a production or shared staging database. Tests check `WP_ENVIRONMENT_TYPE=development`; that guard does not make a real site's data disposable. [RELEASE-REPORT.md](RELEASE-REPORT.md) records executed versions and scope; the CI configuration alone is not proof of a passing run.

## Source checks

From the repository root, install the locked development dependencies and run:

```sh
composer install --no-interaction --prefer-dist
npm ci
composer validate --strict
composer lint
composer test
vendor/bin/phpcs --standard=.phpcs.xml
vendor/bin/phpstan analyse --memory-limit=2G
npm run typecheck
npm test
npm run build
composer audit --locked
npm audit
python3 tools/catalog.py
python3 tools/openapi.py --check
python3 tools/verify-docs.py
```

PHPStan can use `--debug` in environments that prohibit its parallel worker socket. Existing documented boundary-array exceptions remain; this does not replace runtime tests. Advisory audits describe the advisory database at execution time and should be repeated for a release candidate.

## WordPress fixture

`compose.test.yml` binds HTTP to `127.0.0.1:8887` and uses development-only database credentials. Start a fresh fixture, configure the private volume, install WordPress and activate the plugin:

```sh
docker compose -p cf-test -f compose.test.yml up -d db wordpress
docker compose -p cf-test -f compose.test.yml exec wordpress sh -c 'chown www-data:www-data /var/cf-private && chmod 700 /var/cf-private'
docker compose -p cf-test -f compose.test.yml run --rm cli wp core install --url=http://localhost:8887 --title='Firewall Test' --admin_user=admin --admin_password=cf-local-test-password --admin_email=admin@example.test --skip-email
docker compose -p cf-test -f compose.test.yml run --rm cli wp plugin activate content-firewall
```

The database is in tmpfs. Stopping/recreating the DB discards its data, while WordPress configuration/files and private volumes may remain. A later run must use a consistent fresh fixture; multisite constants in an old config cannot be combined with a new single-site database. Never delete an existing project's volumes as routine setup. Keep the fixture alive throughout the test sequence.

The real native suites require FFmpeg and Poppler in the disposable Linux WordPress container. Installing them here does not configure a production parser sandbox:

```sh
docker compose -p cf-test -f compose.test.yml exec wordpress sh -c 'apt-get update && apt-get install -y --no-install-recommends ffmpeg poppler-utils'
```

Run database-mutating suites sequentially. The explicit native paths are used by processing fixtures and need not be enabled in the saved product settings:

```sh
for suite in run review hardening privacy workflows migrations publication-gate simulation headless leases audit-key processing publication-crash concurrency
do
  docker compose -p cf-test -f compose.test.yml exec \
    -e CF_FFMPEG_BIN=/usr/bin/ffmpeg -e CF_FFPROBE_BIN=/usr/bin/ffprobe \
    -e CF_PDFINFO_BIN=/usr/bin/pdfinfo -e CF_PDFTOPPM_BIN=/usr/bin/pdftoppm \
    -e CF_PDFTOTEXT_BIN=/usr/bin/pdftotext -u www-data wordpress \
    php /var/www/html/wp-content/plugins/content-firewall/tests/Integration/$suite.php || exit 1
done
docker compose -p cf-test -f compose.test.yml exec \
  -e CF_FFMPEG_BIN=/usr/bin/ffmpeg -e CF_FFPROBE_BIN=/usr/bin/ffprobe \
  -e CF_PDFINFO_BIN=/usr/bin/pdfinfo -e CF_PDFTOPPM_BIN=/usr/bin/pdftoppm \
  -e CF_PDFTOTEXT_BIN=/usr/bin/pdftotext -u www-data wordpress \
  php /var/www/html/wp-content/plugins/content-firewall/tests/Integration/media-tools.php
```

Migration and concurrency fixtures create uniquely named temporary tables and remove only those tables. Their separate database connections explicitly initialize a blog ID, as required by [wpdb::set_prefix](https://developer.wordpress.org/reference/classes/wpdb/set_prefix/) and [set_blog_id](https://developer.wordpress.org/reference/classes/wpdb/set_blog_id/) on multisite. The concurrency fixture does not consume earlier suites' jobs. The common CLI bootstrap defaults to localhost:8887; `CF_TEST_HOST` can select the host of another disposable fixture. Publication-crash tests send SIGKILL to their dedicated child workers; recovery proves those process boundaries, not host power-loss or storage durability. Native samples are harmless synthetic media, not an adversarial parser corpus.

## Browser and multisite

After the database suites finish, run the browser suite against the single-site fixture. Its default test account matches the installation above; see `playwright.config.ts` for supported environment overrides.

```sh
npx playwright install chromium
npm run test:e2e
```

An installed Chrome can be selected with `CF_BROWSER_CHANNEL=chrome npm run test:e2e`. Do not run PHP fixtures, workers, core upgrades or multisite conversion concurrently with browser tests. Some failure/appeal UI cases use mocked responses; real REST fixtures separately exercise authorization. Axe checks cover selected screens and do not establish complete manual accessibility acceptance.

Convert only the disposable fixture after single-site/browser work is complete:

```sh
docker compose -p cf-test -f compose.test.yml run --rm cli wp core multisite-convert --title='Firewall Network' --base=/
docker compose -p cf-test -f compose.test.yml exec -u www-data wordpress php /var/www/html/wp-content/plugins/content-firewall/tests/Integration/multisite.php
```

The CI WordPress matrix uses separate jobs for 6.8.3, 6.9.4 and 7.0.4. It executes native, concurrency, browser and multisite checks in that order. Minimum-version declarations do not promise untested third-party integrations. Stop the containers only after completing the sequence.

## Offline Content Credentials and distribution

`tests/Integration/provenance-tools.php` requires explicitly supplied signed and unsigned benign fixtures and the pinned c2patool 0.28.1. It runs independently of WordPress:

```sh
CF_C2PA_BIN=/absolute/path/c2patool \
CF_C2PA_UNSIGNED_FIXTURE=/absolute/path/unsigned.jpg \
CF_C2PA_SIGNED_FIXTURE=/absolute/path/signed.jpg \
php tests/Integration/provenance-tools.php
python3 tools/verify-release.py
```

Use public test fixtures, never deploy fixture signing keys. The release verifier builds twice, compares hashes, checks ZIP paths/required files/checksums/dependency inventory and loads the extracted runtime without Composer/vendor. Native executables, development dependencies, tests and source TypeScript are excluded. Distribution checks do not certify moderation quality or deployment readiness; remaining product and acceptance gates are in [RELEASE-STATUS.md](RELEASE-STATUS.md).
