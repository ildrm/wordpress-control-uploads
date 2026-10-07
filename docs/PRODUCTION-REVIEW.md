# Production readiness review — 2026-10-07

The implemented plugin is materially safer and more reliable after this review, but the complete product in SOURCE-REQUIREMENTS.md is still unfinished. This report separates corrected defects from missing product capabilities and external acceptance work. It is a role-based engineering self-review, not an independent security certification. No additional agents were used.

## Scope and method

Reviewed the runtime modules, admin source and compiled assets, WordPress lifecycle, REST/CLI, provider contracts, security/storage/parsers, policies, persistence/queues, privacy, analytics, tests, build/CI/package tools and documentation. The original ledger contains 2,577 statements across sections 0–185; its OPEN statuses remain intentional. A section's existence does not establish acceptance of every statement under it. Composer/npm dependency internals were checked through locked advisory audits rather than individually reviewed.

Structural discovery used the installed codebase-memory graph and coverage checks, followed by current source reads for changed/stale metadata and exact behavior. Regression testing used harmless synthetic files, mocked providers, real WordPress/MySQL-compatible storage, multiple independent worker processes and Chrome. No live vendor credentials, representative moderation corpus or independent auditor were supplied.

## Required review and implementation roles

| Role | Responsibility and review outcome |
|---|---|
| Product Owner / Product Architect | Distinguish implemented behavior from the full product contract; keep missing milestones and acceptance gates visible. |
| Principal WordPress Architect | Upload interception, attachment updates, publication references, lifecycle, privacy hooks and multisite. Reapproval now preserves editorial fields. |
| Senior PHP Engineer | Typed validation boundaries, bounded values, immutable results, shared derivative creation and stable errors. |
| REST/API Engineer | Capabilities, owner access, strict requests, bulk validation before mutation, private responses and request schemas. |
| Frontend Engineer | Numeric context values, locale variants, initial authorized view, appeals, request races and bundle generation. |
| UX/UI Designer | Uploader review requests, clear pending states, per-item results and supported sanitation behavior. Basic onboarding/team workflows are implemented in the continuation; comprehensive workflow acceptance remains open. |
| Accessibility Specialist | Labeled appeal controls, keyboard behavior, focus and scoped axe/RTL checks; manual screen-reader acceptance remains open. |
| Trust & Safety Architect | Required evidence, precedence, uncertain outcomes, QR enforcement and recorded moderator rationale. |
| Applied ML / Computer Vision Engineer | Provider evidence, bounded normalized regions and applying actual image masks. Detection quality remains unproven. |
| ML Evaluation Engineer | Finite scores/thresholds and honest null denominators; representative calibration, drift and accuracy acceptance remain open. |
| Application Security Engineer | REST privacy, tenant checks, immutable snapshots, integrity checks and SSRF ranges. |
| File Security Engineer | Mandatory file checks, private snapshots, reconstruction, publication recovery and held document behavior. Bounded PDF processing has native fixtures; Office/archive CDR and deployment/parser acceptance remain open. |
| Privacy / DLP Engineer | Plain-text inspection, measured negative evidence, bounded pattern redaction, no raw persisted text, expiry and temporary-file cleanup. |
| Performance Engineer | Bounded conditions/evidence, batched publication-reference reads, bounded lease recovery and retention continuation. Full load acceptance remains open. |
| SRE / Reliability Engineer | Durable local operation intents, process-death recovery, exhausted leases, transactional outbox and failure visibility. |
| Data Architect | Column/engine verification, immutable network versions, CAS transitions and checked commits. |
| Integrations Engineer | Provider fallback, duplicate identity rejection, extension failure isolation and signed notification semantics. Third-party/offload adapters remain open. |
| QA Engineer | Unit/security/provider, real WordPress regression, concurrency, process-kill and browser evidence. |
| Adversarial Engineer | Type confusion, malformed batches, missing evidence, replaced file paths, stale associations and publication crash boundaries. |
| Observability Engineer | Dead jobs, recovery backlog/errors, unavailable configuration and truthful Site Health status. |
| Release Engineer | Locked dependencies, request-schema drift checking, distributable loading, deterministic archives and checksum verification. |
| Technical Writer | Reconcile operations, privacy, REST, UX, compatibility, architecture and release claims with current behavior. |

## Corrected defects and implemented hardening

| ID | Priority | Before → resulting behavior | Main evidence |
|---|---|---|---|
| PR-01 | P1 | Null settings bypassed type checks → one schema validates persisted/runtime/REST values and supplies consistent defaults. | Configuration/Settings; HardeningTest; integration hardening |
| PR-02 | P1 | A malformed later bulk item could follow successful earlier mutations → validate the entire batch before acting. | REST/Controller; integration hardening |
| PR-03 | P1 | Sensitive GET responses lacked explicit cache prevention → private/no-store headers cover the plugin REST namespace. | REST/Controller; browser response assertion |
| PR-04 | P1 | Preview did not compare its snapshot hash → verify integrity and expiry before decoding/reveal. | REST/Controller; source/static checks |
| PR-05 | P1 | Unknown/null options and malformed/large conditions could be saved → reject unsupported keys, shapes and nonfinite values; bound JSON/nodes. | Policy/Schema, Condition; HardeningTest |
| PR-06 | P1 | Drug, text and custom scanner fields could skip processing/coverage → distinguish trusted context/file fields from scanner evidence. | EvidenceCoverage, Schema; HardeningTest |
| PR-07 | P1 | Missing higher-priority evidence could fall through to ALLOW → unavailable evidence yields REVIEW. | Policy/Engine; HardeningTest |
| PR-08 | P1 | QR modes emitted findings without an enforcement decision → prohibited codes block; configured review codes require review. | Policy/Engine; HardeningTest |
| PR-09 | P1 | Routing stopped after two incomplete results → aggregate category coverage and continue to a capable later provider. | Providers/Router; real three-provider fixture |
| PR-10 | P1 | Fail-open could overwrite required text review → required text remains mandatory. | ScanService; integration hardening |
| PR-11 | P1 | Text routing stopped on the first failure/budget and did not update its breaker → try eligible fallback providers and track circuit outcomes. | Providers/Router; source/static checks |
| PR-12 | P1 | Duplicate provider identities could count as independent consensus → reject duplicate registrations and count distinct successful providers. | Services, Router; source/static checks |
| PR-13 | P1 | Plain text used an image-provider route → inspect bounded UTF-8 text locally and moderate it externally when explicitly required. | ScanService; text DLP integration fixture |
| PR-14 | P1 | SANITIZE could publish unredacted content → shared derivative builder redacts supported text/patterns and located requested image regions; unavailable transformations require review. | DerivativeBuilder, ScanService; redaction integration fixtures |
| PR-15 | P1 | Failed or truncated regex scans looked negative → preserve unknown evidence and refuse uncertain pattern sanitation. | Condition, TextInspector; HardeningTest |
| PR-16 | P1 | No explicit negative DLP result and last OCR result overwrote earlier text → retain measured category negatives and evaluate bounded combined text without persisting it. | TextInspector, ScanService; unit/integration fixtures |
| PR-17 | P1 | Arbitrary confidence casts, regions/model lengths and result payloads were insufficiently validated → finite typed findings/results and bounds at the domain boundary. | Finding, ProviderResult; unit/static checks |
| PR-18 | P2 | NaN or invalid thresholds could produce misleading evaluation → reject nonfinite scores and thresholds. | Analytics/Evaluator; HardeningTest |
| PR-19 | P1 | Reapproval cleared attachment editorial fields → update existing attachments through wp_update_post and preserve title, caption, author and parent. | Publisher; real WordPress editorial fixture |
| PR-20 | P1 | An older scan could publish/withdraw a newer attachment association → attachment locks and latest-scan checks reject obsolete operations. | Publisher, MediaWithdrawal; stale association fixture |
| PR-21 | P1 | Process termination left public orphan files or missing metadata → private durable intents recover before retry and during worker runs. | MediaJournal; real SIGKILL tests before/after commit |
| PR-22 | P1 | Partial withdrawal could not retry after primary removal → persist the complete validated set before deleting; fingerprint each path so recovery cannot delete a replacement file. | MediaWithdrawal; interruption/replacement fixtures |
| PR-23 | P1 | Committed metadata failure had no reliable recovery signal → retain the journal and pending flag until metadata recovery succeeds. | Publisher, MediaJournal; metadata fixture |
| PR-24 | P1 | Repeated expired leases left scans pending permanently → reconcile exhausted leases into visible failed records. | JobRepository, Worker; exhaustion fixture |
| PR-25 | P1 | Terminal publication errors could remain misleadingly allowed → create a review case and withdraw supported local media; unknown job kinds fail explicitly. | Worker; source/static checks |
| PR-26 | P1 | Claim/appeal/retention ignored commit errors and some review changes escaped transactional rationale → check commits and persist rescan notes with enqueue; lock auxiliary review changes. | JobRepository, Retention, ReviewService; rollback/source checks |
| PR-27 | P1 | Cached services could run workers/rescans/appeals/retention against another active blog → validate tenant context at these entry points and privacy export. | Services consumers; expanded multisite fixtures |
| PR-28 | P1 | Updating an enforced network policy reused conflicting versions; CLI imports could create local policy changes → reserved network IDs, monotonic immutable versions and repository-level enforcement. | NetworkPolicyRepository, PolicyRepository; multisite fixtures |
| PR-29 | P1 | Expired held media could retain public derivatives and remain accessible before cleanup → withdraw local held media, reject expired private processing/reveal/republication, and continue full retention batches. | Retention, Publisher, ScanService; expiry fixture |
| PR-30 | P2 | Temporary files were shared across tenant roots and survived crashes/uninstall → tenant work directories, bounded stale cleanup and guarded opt-in tenant removal. | PrivateStorage, uninstall; file-security tests |
| PR-31 | P1 | PHP's reserved-range flag accepted benchmark/documentation/IPv6 transition destinations → additional conservative binary CIDR checks. | UrlGuard; file-security tests and IANA references below |
| PR-32 | P2 | Numeric equality input remained a string and locale variants could break queue rendering → typed context input and normalized Intl locales. | model.ts; frontend tests |
| PR-33 | P2 | Uploaders had an appeal API without an actionable interface and could initially request an unauthorized dashboard → summarized owner review flow and authorized initial view. | admin.tsx; browser appeal fixture |
| PR-34 | P1 | Table existence alone marked migration successful → verify required columns and transactional engines before recording schema status. | Tables; source/static checks and repeat migrations |
| PR-35 | P1 | Webhook enqueue/audit followed commit and extension errors could reverse the apparent result → persist the built-in outbox and decision audit atomically; isolate post-commit listeners; include shadow/enforced action in notifications. | ScanService, WebhookSender; rollback/listener fixtures |
| PR-36 | P2 | Health could report good despite dead work or missing deployment configuration → surface dead jobs, stale workers, recovery intents/errors and safe configuration failures. | Diagnostics, Plugin; browser/API checks |
| PR-37 | P2 | CI lacked package loading/determinism verification and machine-readable requests → generate typed request/response schemas, detect schema drift and verify the distribution without vendor. The current inventory contains 30 routes and 36 schemas. | tools/openapi.py, verify-release.py; CI/package smoke |

Static/source validation is identified explicitly above; it does not imply a dedicated runtime regression for every branch. The existing review's earlier 24 findings remain recorded in CODE-REVIEW.md.

## Validation

Current automated evidence is recorded in RELEASE-REPORT.md. The regression suite includes actual worker process termination after public copy and after database commit, not only simulated exceptions. Recovery tests also cover a file replaced at the same path and a direct publication retry before any cron tick.

Official behavior was checked against [wp_update_post](https://developer.wordpress.org/reference/functions/wp_update_post/), [wp_insert_attachment](https://developer.wordpress.org/reference/functions/wp_insert_attachment/), [attachment file removal](https://developer.wordpress.org/reference/functions/wp_delete_attachment_files/) and [REST post-dispatch](https://developer.wordpress.org/reference/hooks/rest_post_dispatch/). SSRF exclusions were checked against the [IANA IPv4 registry](https://www.iana.org/assignments/iana-ipv4-special-registry/) and [IANA IPv6 registry](https://www.iana.org/assignments/iana-ipv6-special-registry/). The transport deliberately rejects some special-purpose allocations even where an exception has global reachability.

## Workflow, privacy and media continuation

The user's follow-up requested implementation of the remaining work and correction of every guide. This pass completed the following bounded capabilities and fixed the associated interaction defects. The original complete-product contract is preserved; this table does not sign off all statements of a source section.

| ID | Implemented change / corrected defect | Evidence |
|---|---|---|
| PR-38 | Paginated privacy export includes owned review/evidence records and authored records, without private identifiers or raw extracted content. | Integration/privacy |
| PR-39 | Erasure no longer skips rows as the dataset changes; tenant/publication locks, queue cancellation, revision advance and minimal accepted-media stubs protect publication. | Integration/privacy, RecordLifecycle |
| PR-40 | Separate typed retention classes, audit retention/removal policy and checked cleanup failures replace fixed incomplete retention. | SettingsTest, Integration/privacy |
| PR-41 | Schema 2 adds explicit erasure state/index; migrations verify structure under a database/blog lock; required PHP extensions are checked. | Tables, Lifecycle, repeated integration migrations |
| PR-42 | Resumable four-step Setup validates progression, permitted inputs and completion configuration; nested updates preserve customized values. | Integration/workflows, browser Setup |
| PR-43 | Eligible reviewer/team/priority/deadline assignment, stale-edit rejection and bounded overdue escalation. Pending annotations preserve worker revisions. | CaseAssignmentTest, Integration/workflows |
| PR-44 | User/site-scoped typed saved views and modal moderation confirmations with Escape/focus restoration. | Integration/workflows, browser queue |
| PR-45 | Shell-free bounded subprocesses, minimal environment/private temp and live ownership renewal support long work. | ProcessRunnerTest, native suites, lease fixtures |
| PR-46 | All PDF pages are inspected and a fresh image-only PDF is reconstructed with physical dimensions preserved; local text does not count as independent consensus. | Native media and WordPress processing |
| PR-47 | Bounded uniform/scene/adaptive video samples, reduced audio clips and checked full-media reconstruction; output duration/streams/size verified. | Native media and WordPress processing |
| PR-48 | Separate reduced Whisper transcription contract normalizes ephemeral words/language; no raw transcript persistence. | TranscriptionTest, WordPress processing |
| PR-49 | Pinned offline C2PA validates original signature/binding separately from signer trust, AI declarations and absence; page/frame coverage retains original local evidence. | ProvenanceTest, official signed/unsigned fixtures, native media |
| PR-50 | Default-off processor controls/limits, safe health summaries, original-credential explanation and 30-route typed request/response documentation. | Settings/Diagnostics, browser settings/axe, OpenAPI drift check |
| PR-51 | Ordinary saves, legacy galleries/playlists, featured-media changes and scheduled publication use approval checks; unsafe editor content stays as draft with a notice. Direct status writes/custom references remain open. | Integration/publication-gate |
| PR-52 | A dedicated isolated migration fixture proves schema-1-to-2 data preservation, repeatability and competing-connection locking; CLI reports the actual schema constant. | Integration/migrations |
| PR-53 | Real-file simulation shares scan/transform decisions, cleans private work, returns safe normalized timing/cost/risk and never creates a scan/publication job. | Integration/simulation, genuine multipart browser test |
| PR-54 | Authenticated headless upload/status respects WordPress/plugin limits, quotas/suspension and owner access, then uses existing durable scan/publication work. | Integration/headless, genuine multipart browser test |
| PR-55 | Category consensus cannot be faked by transcript-only results, repeated frames or local text; each inspected page/frame requires coverage. Erased stubs are excluded from detail reads. | ConsensusTest, processing/privacy regressions |
| PR-56 | Invalid C2PA binding cannot establish AI-declaration evidence; provenance-only unknown evidence stays local, and native malformed JSON has a specific boundary error. | ProvenanceTest, official tool fixtures |
| PR-57 | Decision/publication transactions verify and renew job ownership; stale workers cannot commit evidence or revoke a committed derivative after acknowledgement failure. | Integration/leases, claim/crash suites |
| PR-58 | Privacy export/erasure explicitly discloses retained administrator-managed suspensions; guides/ledger/OpenAPI links and counts have automated consistency checks; dependency inventory includes both lockfiles. | Integration/privacy, verify-docs/package tools |
| PR-59 | Empty/weak audit keys cannot create predictable signatures; production requires a separate deployment key, and explicitly bad environment keys cannot silently fall back. | Integration/audit-key, services/key boundary |
| PR-60 | Receipt validates active/context tenant before file/policy writes; cached receipt, simulation, headless, onboarding and privacy services have explicit cross-blog tests. | Integration/multisite |
| PR-61 | File simulation honors exact blocklists before paid processing; monitor enforcement and post-action focus are explicit in the UI. | Integration/simulation, browser focus checks |
| PR-62 | A failed transaction start cannot lease work; concurrent-claim testing uses a separate temporary table and verifies the exact expected IDs without acknowledging other fixtures' jobs. | JobRepository, Integration/concurrency |

No independent agents or external auditors were used. These are engineering self-review perspectives. Current executed counts/versions appear only in RELEASE-REPORT.md; earlier counts above describe the initial hardening pass.

## Remaining complete-product release blockers

| Owner roles | Required implementation | Acceptance still needed |
|---|---|---|
| File security, SRE, security | Office/archive reconstruction, broader document redaction and previews. | Maintained isolated Poppler/FFmpeg/malware deployment, adversarial document/parser corpus and runtime resource boundaries. |
| ML, integrations, QA | Temporal redaction/aligned transcripts, authenticity/deepfake models and remaining vendor/category contracts. | Live multilingual/provider accounts, localization and representative whole-asset quality/security fixtures. |
| ML evaluation, Trust & Safety | Calibration/ensemble/drift/anomaly programs and complete measured negative QR/category evidence. | Lawful labeled corpus, measured category precision/recall/uncertainty and regional/model acceptance. |
| WordPress, integrations | Explicit form/community/ecommerce/offload adapters, unresolved raw/custom media references and direct status-write integration. | Real third-party installations, bypass fixtures, CDN/offload revocation and integration contracts. |
| Product, frontend, UX, accessibility | Remaining metadata/integration/network flows, translated catalogs and dynamic bundle code splitting. | Full product flows, manual screen-reader/keyboard and real translated RTL review. |
| Privacy, data, product | Broader provider/offload/core-media coordination where the product contract requires it. | Reviewed retention/disclosure policy, backup/third-party erasure and legal/privacy acceptance; implemented export/erasure is not certification. |
| Enterprise, data, commercial | Central/network analytics, per-site credential policy, agency management, managed credits/licensing/commercial services. | Large-network migration/provisioning, central-account/service contracts and enterprise deployment acceptance. |
| SRE, performance, security, release | Remaining high-scale query/workload instrumentation and deployment-specific serving/recovery integration. | Realistic concurrent million-row workloads, host power-loss/storage/DB failure tests and independent security assessment. |

The journal improves process-restart recovery, but filesystem writes and SQL still span different durability boundaries. Ordinary public uploads remain server-served files; downloaded/CDN copies cannot be revoked by this plugin. Optional native processing is not an OS sandbox. No full-product milestone is signed off by the review or ZIP. RELEASE-STATUS.md distinguishes code gaps from missing external acceptance inputs.
