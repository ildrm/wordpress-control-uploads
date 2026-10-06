# Engineering release report — 2026-10-06

Status: unreleased 0.1.0 engineering build. The full production-grade platform requested in SOURCE-REQUIREMENTS.md is not complete. RELEASE-STATUS.md lists blocking requirements; no milestone is signed off solely because its module exists.

Implemented: modular namespaced upload gateway, streaming fingerprints, file/image limits, private storage, SVG/archive controls, raster/SVG CDR interfaces, mandatory scanner failure handling, state/CAS persistence, nested context rules, editable presets, immutable policies, simulations, provider routing/cache/quota/circuit primitives, human review and appeals API, signed outgoing webhook jobs, audit integrity, WordPress media/lifecycle/privacy/Site Health integrations, admin application, REST, CLI, network snapshots and diagnostics.

Providers: AWS Rekognition, Google Vision/OCR, Azure Content Safety, Sightengine nudity/gore, OpenAI image/text moderation, custom HTTPS scanner, local ClamD. Mock contracts pass. No supplied credentials or live malware daemon were available; actual authentication, taxonomy coverage and deployment behavior still require live acceptance.

Test evidence: 38 PHPUnit tests / 102 assertions on PHP 8.5.8; four TypeScript frontend tests; nineteen real WordPress integration assertions exercised on WordPress 6.8.3, 6.9.4 and 7.0.4 with PHP 8.3.28; six tenant isolation/network-policy assertions; two separate processes claimed 100 jobs without duplicates after a deadlock fix. Four Chrome admin/E2E tests passed on the current multisite installation, including scoped axe and keyboard/RTL checks. PHP lint, security-focused PHPCS, PHPStan level 6 with documented boundary-array exceptions, TypeScript and builds pass. Composer advisory audit and full npm advisory audit found no current advisories after upgrading development tooling.

The current WordPress 7.0.4 suite additionally includes pending-file expiration and persisted moderator-rationale checks (21 assertions). CLI diagnostics were exercised on PHP 8.3.35. CI and local test containers share their explicit development/private-path configuration.

Security: covered gateway paths prevent public movement before acceptance; security blocks cannot be shadowed; malicious parser inputs, unauthorized object access, expired/stale revisions and lease tokens have automated coverage. Self-review is not an independent audit. Full adversarial/CSRF/SSRF/webhook replay/offload/crash and enterprise validation remain open.

Performance: synthetic million-row indexed scan page p95 0.725 ms in a warm local database; local deterministic policy p95 0.000875 ms. Read PERFORMANCE-RESULTS.md for workload limits. These are not full pipeline/provider/production throughput measurements.

Moderation quality: per-category precision/recall/F1/FPR/FNR/coverage framework; deterministic boundary/disagreement/ordinal/unknown fixtures. No representative ML benchmark or achieved precision claim. Manual accessibility, screen-reader flow and translated RTL locale acceptance remain outstanding.

Database: schema 1 repeat migration tested. No previous released schema exists. Minimum MySQL 8/MariaDB 10.11+ is required for skip-locked workers; publication requires InnoDB core posts/postmeta. Historical/mass migrations and crash recovery require more testing.

Operations: persistent private directory outside public roots, appropriate PHP extensions, current ClamD signatures if mandatory scanning is enabled, deployment-owned provider credentials, reviewed privacy disclosure and a system-cron CLI worker. Begin with Security Only/monitor policies and human review; the complete build must pass outstanding gates before production enforcement.

Deliverables: source, Composer/npm lockfiles, CI, schemas, tests, source requirements and exhaustive ledger, architectural/ADRs/threat/privacy/provider/performance/UX/operations/API/CLI guides, generated route inventory, reproducible ZIP/checksum and dependency inventory. Package existence does not imply release acceptance.

Follow-up code review: [CODE-REVIEW.md](CODE-REVIEW.md) records 24 fixed findings across the implementation roles, including hard security precedence, current-policy rescans, retry recovery, local public-media withdrawal/reapproval, missing evidence, tenant prefix isolation and bulk-action feedback. Current review validation: 47 PHP tests/113 assertions, 6 frontend tests, 21 existing integration assertions, 27 review regressions, 8 multisite checks, 100 distinct concurrent claims, and 6 Chrome tests. New local tests ran on WordPress 6.8.3 and 7.0.4 with the exact scope noted in the review report. These fixes do not remove the full-product release blockers.
