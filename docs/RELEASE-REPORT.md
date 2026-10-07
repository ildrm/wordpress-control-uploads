# Engineering release report — 2026-10-07

Version **0.1.0 remains unreleased**. The implemented core has expanded and passed the checks below. The complete platform in [SOURCE-REQUIREMENTS.md](SOURCE-REQUIREMENTS.md) is unfinished; [RELEASE-STATUS.md](RELEASE-STATUS.md) separates remaining code from external acceptance gates. This report supersedes earlier release-report counts. Historical findings remain in [CODE-REVIEW.md](CODE-REVIEW.md).

## Implemented work

The [22-role engineering review](PRODUCTION-REVIEW.md) records **62 corrected finding groups and bounded feature additions**, alongside the earlier 24 findings. The roles were self-review perspectives used by one engineer; no independent agents or auditor supplied sign-off.

Implemented paths now cover private upload interception, streaming fingerprints and file/resource checks, immutable policies and required-evidence decisions, text/located image redaction, raster/SVG reconstruction, leased jobs and local publication/withdrawal recovery, human review and appeals, reviewer/team/priority/deadline assignment and escalation, saved views and decision confirmations, resumable Setup, per-class retention and WordPress privacy export/erasure, authenticated headless uploads and shared real-file simulation, classic/featured/scheduled publication checks, audit integrity and outgoing notification jobs, REST/admin/CLI, network policy pins, diagnostics and schema migrations.

Optional default-off native processing inspects every bounded PDF page, sampled video frames and reduced audio clips, then reconstructs supported output. Separate Whisper transcription and pinned offline C2PA verification normalize ephemeral evidence. [MEDIA-PROCESSING.md](MEDIA-PROCESSING.md) defines bounds and limitations: Office/archive CDR, temporal/document redaction and complete temporal alignment are unavailable; valid original credentials do not survive public reconstruction. Production audit services require a separate deployment-owned signing key.

## Executed automated evidence

| Check | Executed environment | Result |
|---|---|---|
| PHP unit, security and provider contracts | PHP 8.2.29, 8.3.28, 8.4.21 and 8.5.8 | **93 tests / 259 assertions** passed on each runtime |
| Frontend model tests | Local Node/Vitest | **8 tests** passed |
| WordPress integration matrix | WordPress 6.8.3, 6.9.4 and 7.0.4; PHP 8.3.28; MariaDB 11.4 | **13 suites / 202 assertions** passed on each version |
| Multisite | Same three WordPress versions | **22 assertions** passed on each version |
| Concurrent queue claims | Two independent PHP processes; isolated temporary jobs table; same three WordPress versions | **100 distinct claims, zero duplicates**, plus failed-transaction-start rejection |
| Native PDF/video/audio tools | Disposable Linux PHP 8.3.28 container; FFmpeg 7.1.5; Poppler 25.03.0 | **18 native assertions** passed; the 15 WordPress processing assertions are included in each 202-assertion row |
| Offline Content Credentials | macOS PHP 8.5.8; official c2patool 0.28.1 signed/unsigned benign samples | **3 real-tool assertions** passed; signer trust was not asserted |
| Chrome administration/E2E | Stable WordPress 7.0.4 single-site fixture; one browser worker | **13 tests** passed |
| Static/build checks | PHP lint, security-focused PHPCS, PHPStan level 6, TypeScript and production bundle | Passed; PHPStan reported zero errors, with existing boundary-array exceptions and no new suppressions |
| Dependencies | Strict Composer validation; locked Composer and full npm advisory audits | Passed; no advisories reported at execution |
| Documentation/API | Local-link/evidence-path/schema checks and generated OpenAPI drift check | **30 Markdown files**, **2,577 statements / 186 sections**, **30 routes / 36 schemas**, database schema **2** |
| Distribution | Two deterministic builds and extracted-package runtime smoke check | Matching SHA-256; **84 runtime symbols** loaded without Composer/vendor |

The final WordPress matrix ran sequentially against the disposable multisite fixture after correcting its standalone host/blog initialization. WordPress 7.0.4 also passed the 13 integration suites and browser tests before multisite conversion. The fixture was restored to 7.0.4 afterward. Earlier revision/failed fixture runs are superseded by these results. CI declares equivalent separate jobs; no unexecuted hosted CI result is claimed. [TESTING.md](TESTING.md) gives the reproducible sequence and fixture limitations.

The 202 assertions comprise original integration (21), earlier review regressions (27), hardening (29), privacy (19), workflows (20), migrations (7), publication gate (12), real-file simulation (10), headless upload/status (9), lease ownership (7), audit keys (6), native WordPress processing (15) and publication crash recovery (10). Counts are per version, not independent production certifications.

The crash fixture sends SIGKILL after public copy and after SQL commit. Recovery removes uncommitted local derivatives, resumes committed attachment metadata and permits direct retry before cron. Other fixtures cover interrupted withdrawal and a replacement file at the same path. These checks do not simulate host power loss, filesystem/volume durability, every storage/database boundary or CDN revocation; [ADR 0004](ADRs/0004-local-media-recovery.md) defines those limits.

Browser coverage includes policy save/synthetic and genuine multipart simulation, moderation rationale and confirmation, bulk failure/selection/focus, uploader appeals, no-store API responses, Setup, typed media settings, genuine multipart headless receipt, keyboard/RTL and scoped axe checks. Some appeal/failure UI cases use mocked responses; real REST fixtures separately exercise permissions. Manual screen-reader and translated-locale acceptance remains open.

## Performance and artifact

The final tiny deterministic policy benchmark on PHP 8.5.8 ran 10,000 iterations: p50 **0.0015 ms**, p95 **0.003292 ms**, peak memory **4 MiB**. The compiled admin script is **36,259 uncompressed bytes**. These exclude decoding, providers, persistence and end-to-end processing. The historical million-row warm local query measurements in [PERFORMANCE-RESULTS.md](PERFORMANCE-RESULTS.md) were not rerun against this final revision and do not establish production throughput.

The distribution is generated at `dist/content-firewall-0.1.0.zip`; its external `SHA256SUMS` and `sbom.json` match the archive. Packaging includes runtime source, compiled assets, guides, catalog and both dependency lockfiles, and excludes development dependencies, tests, source TypeScript and native binaries. The verifier checks paths, required files, checksums, deterministic output and extracted autoloading. The checksum is outside the archive to avoid a self-referential digest.

## Remaining product and acceptance work

Code gaps include Office/archive reconstruction, temporal redaction/alignment, deepfake/authenticity models, remaining provider/category and negative QR contracts, calibration/drift/anomaly programs, managed credits/licensing/commercial services, explicit form/community/ecommerce/offload adapters, unresolved raw/custom media references and direct status-write integration, central/network analytics and credential administration, additional metadata presets, translated catalogs and remaining enterprise/product flows.

External acceptance still needs supplied live provider/malware deployments, a lawful representative labeled corpus, required third-party installations, deployment parser isolation and runtime limits, realistic concurrent load/network migration tests, infrastructure-specific serving/recovery and offload revocation, privacy/disclosure review, manual accessibility/localization and independent security assessment. No live vendor accounts or representative corpus were supplied. Mock contracts and benign fixtures establish software behavior, not achieved moderation accuracy or universal malware detection.

All complete-section requirements remain OPEN in the original ledger. The package is a reviewable **staging artifact**, not a flawless or fully production-ready release.
