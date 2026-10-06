# Role-based code review and fixes — 2026-10-06

This review examined the existing engineering implementation against the implementation roles in the source request. Findings below are verified code defects addressed in this pass. This is a self-review with automated regression evidence, not an independent security audit or full-product acceptance. No additional agents were used.

## Fixed findings

| Severity | Reviewing roles | Issue and resulting behavior | Main implementation |
|---|---|---|---|
| P1 | Security, Trust & Safety, PHP | Queued provider failure handling could overwrite a hard security block. Security findings now finish before external processing; later failure handling cannot downgrade BLOCK. | Application/ScanService.php |
| P1 | Trust & Safety, adversarial QA | A fingerprint added after upload was ignored by the worker. Receive and queued processing both enforce the current blocked fingerprint. | Application/ScanService.php |
| P1 | WordPress, file security, privacy | Reject/quarantine/delete changed state while local files stayed public. Local originals, sub-sizes, source companions and edit backups are withdrawn; reapproval reconstructs from the private original and preserves attachment ID. Held library decisions also withdraw local files. | Application/MediaWithdrawal.php, Publisher.php, ReviewService.php |
| P1 | WordPress, concurrency | Publication returned an existing attachment before validating revision/state. Stale calls are rejected; a held attachment can only be reapproved after fresh security checks. Row and advisory locks serialize local publication and moderator withdrawal. | Application/Publisher.php |
| P1 | SRE, WordPress | Metadata extension exceptions deleted an already committed public file. Metadata errors are audited without deleting the committed derivative. | Application/Publisher.php |
| P1 | Queue, SRE, data | Scan attempts advanced revisions before operations that could fail, making retries stale. Pending-to-content and final decision transitions now commit together; failed attempts preserve the queued revision. | Application/ScanService.php, Persistence/ScanRepository.php |
| P1 | Queue, SRE | A completed scan followed by a publication failure could not resume. An internal source-revision marker lets the same job resume publication without repeating provider requests. Terminal scan failures become FAILED review records. | Queue/Worker.php |
| P1 | Policy, data | Rescans reused old policies and same-state rescans could enqueue a nonexistent revision. Rescans pin the current immutable policy, advance the revision, and enqueue atomically. | Application/ScanService.php, Persistence/ScanRepository.php |
| P1 | Data, reliability | Pending scan records could commit without their queue jobs. Completion invokes enqueue before the transaction commits. The default security policy is also persisted as a usable snapshot. | Persistence/ScanRepository.php, PolicyRepository.php |
| P1 | ML, evaluation, Trust & Safety | Missing required category evidence was treated as clean, allowing the first partial provider result to end routing. Routing continues for missing evidence; publishable decisions with missing rule/band evidence require review. | Policy/EvidenceCoverage.php, Providers/Router.php |
| P1 | Policy, product | Content rules in Custom policies could silently skip external scanning. Saving rules/bands that need content evidence enables the required content processing. | Policy/Schema.php |
| P1 | ML, privacy, integrations | Required consensus could allow with fewer than two successful providers; missing required extracted text could allow. Both require review. Text-provider routing respects the policy region and circuit state. Ordinal/severity scores are excluded from numeric probability-disagreement comparisons. | Application/ScanService.php, Providers/Router.php |
| P1 | Policy, adversarial QA | A string such as "false" was truthy for calibration; nonfinite thresholds and malformed options passed validation. Calibration/shadow/options are typed and thresholds finite; unsupported metadata modes are rejected. | Policy/Schema.php, Condition.php |
| P1 | Multisite, enterprise | Cached repositories followed the shared wpdb object's changing blog prefix. Table prefixes are captured on construction, and publication/moderation reject the wrong active blog. | Persistence/Tables.php, Application/Publisher.php, ReviewService.php |
| P1 | File security, WordPress | Gateway reconstruction reread the mutable caller file rather than the inspected snapshot. Accepted bytes now come from the verified private snapshot, including SVG and plain text. | WordPress/UploadGateway.php |
| P1 | REST, WordPress | Publication validation silently ignored references beyond 100, omitted existing featured media/content on updates, missed legacy gallery IDs, and ignored the pending flag. Those cases now block or validate the complete supported set. | WordPress/PublicationGate.php |
| P2 | WordPress, QA | Identical uploads overwrote each other's scan association; successful SANITIZE gateway uploads remained SANITIZING. Hash associations use a FIFO and attachment creation completes SANITIZED. | WordPress/UploadGateway.php |
| P2 | Product, policy | Saved rule effects had no executor. Unsupported effects are explicitly rejected instead of pretending to suspend privileges, unpublish content or apply notifications. | Policy/Schema.php |
| P2 | Frontend, UX, accessibility | Bulk actions reported success when individual items failed; selections survived filters/pages; stale responses could replace cases or reveal a previous preview. Results report failed case IDs, selection and preview state reset, and requests are guarded. Settings only submit supported scalar values. | assets/src/admin.tsx, model.ts |
| P2 | Frontend, policy | Empty numeric input and incomplete ranges became zero. Both are rejected; the queue filter has an explicit accessible label. | assets/src/model.ts, admin.tsx |
| P2 | Performance, WordPress | Media Library columns issued one scan query per attachment. Attachment query results now preload the latest summaries in one bounded batch. | Admin/App.php, Persistence/ScanRepository.php |
| P2 | Security, performance | HTTP response bodies were bounded but headers were not. Response headers now have a 64 KiB aggregate limit. | Infrastructure/PinnedHttpClient.php |
| P2 | Integrations, reliability | Library continuation lost its batch ID, later scans could be skipped, and one bad item stopped the batch. Batch identity is propagated and individual failures are audited and marked pending. Allowed retrospective local media is reconstructed. | Queue/Worker.php |
| P2 | QA, release | The concurrency fixture acknowledged unrelated jobs. It now requires an empty disposable queue; the review regression suite is included in CI. | tests/Integration/concurrency.php, .github/workflows/ci.yml |

WordPress derivative metadata handling was checked against the official [attachment file-removal reference](https://developer.wordpress.org/reference/functions/wp_delete_attachment_files/). This implementation retains the attachment record for reapproval rather than deleting it through the core attachment API.

## Validation

- PHP unit/security/provider contracts: 47 tests, 113 assertions, PHP 8.5.8.
- Frontend model tests: 6 passed; TypeScript strict checking and production bundle build passed.
- Existing WordPress integration suite: 21 assertions passed on 6.8.3 and 7.0.4, PHP 8.3.28.
- New review integration suite: final 27 assertions passed on WordPress 7.0.4; earlier 25-assertion revision also passed on 6.8.3. Fixtures cover malware/fingerprint enforcement, public withdrawal and reapproval, metadata failure, retries, policy versions, rollback, category coverage, consensus, failed jobs, publication checks, retrospective reconstruction and sanitation state.
- Multisite: 8 isolation/network-policy assertions passed on WordPress 7.0.4.
- Two independent workers: 100 distinct job claims, zero duplicates.
- Chrome admin tests: 6 passed, including bulk-error and filter-selection regressions, scoped axe, keyboard and RTL checks on WordPress 6.8.3.
- PHP lint, security-focused PHPCS and PHPStan level 6 passed. No suppressions were added for this review.
- Current Composer and npm advisory audits passed; package loading and deterministic packaging were verified.

The CI WordPress matrix also contains 6.9.4, but this review did not reexecute that version locally. Vendor calls remain mocked; no live provider accuracy or malware-daemon certification is claimed. The axe test covers the Health view, not the whole administration interface.

## Remaining release blockers

The original complete-product requirements remain open. This pass does not implement document CDR, video/audio moderation, C2PA/authenticity models, representative moderation evaluation, metadata presets beyond Privacy Safe, complete privacy export/erasure and per-class retention, third-party/offload adapters, full enterprise provisioning, full appeals/assignment UX, complete translation or manual accessibility audits.

Publication still spans filesystem and database transactions. Locks, random destination names, retries and cleanup improve ordinary failures, but process termination can leave orphan public derivatives or incomplete attachment metadata. Withdrawal I/O failures can remove only part of a derivative set before reporting failure; filesystem changes cannot roll back with SQL. A durable publication/withdrawal recovery protocol and server-level private serving boundary remain production gates.

Local withdrawal cannot revoke CDN/browser caches, third-party/offloaded copies, external URLs or downloads. Unsupported/missing/shared primary file locations return an error. Legacy library inputs rejected before a scan record can be created are marked pending and audited; operators must review those items. REST publication checks do not cover classic/custom publishing paths or every possible URL/shortcode reference.

Coverage checks intentionally prefer review when a configured provider cannot supply explicit evidence for required categories. This is a safety guard, not proof of calibrated detection quality or a complete provider feature contract. Model/version compatibility, category-specific negative evidence and cross-provider calibration still require deployment acceptance.
