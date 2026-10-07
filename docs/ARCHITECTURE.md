# Architecture

The 2026-10-07 hardening pass adds a shared Configuration/Settings boundary, Media/DerivativeBuilder, immutable Persistence/NetworkPolicyRepository and Application/MediaJournal. See ADR 0004 for the local filesystem/database recovery protocol and PRODUCTION-REVIEW.md for remaining full-product gates. Built-in decision audit/webhook outbox rows commit with the decision; public extension notifications occur afterward and cannot revoke it by throwing.

`ContentFirewall` is the stable engineering namespace; the product display name and text domain are centralized at integration boundaries. PHP 8.2+ enums and immutable domain values keep decisions separate from WordPress arrays.

The main plugin registers lifecycle hooks and a small loader. Frontend requests register upload hooks without creating the database/provider graph. `Services` is constructed lazily for the current blog and rebuilt when validated settings change. Tables use the current `$wpdb->prefix` and scan/queue access additionally checks the current site ID.

Upload flow: authorization and atomic quota → filename/size/type/header validation → streaming SHA-256 → private immutable snapshot → security inspection → policy → optional asynchronous provider job → review or checked derivative publication. Unknown scanner evidence and malformed responses must not become negative findings. Security blocks cannot be relaxed by monitor mode or trusted roles.

The public WordPress uploads directory only receives accepted derivatives through covered upload hooks. An asynchronous upload returns a private case reference; it does not create a public placeholder attachment. Files written directly by third-party code bypass these hooks; post-insertion verification is compensating detection and cannot eliminate an earlier public exposure window.

`ScanRepository` uses revision comparisons. `JobRepository` uses SKIP LOCKED transactional claims, rejects a failed transaction start, checks commits, renews atomic lease ownership during long native/provider work, and uses bounded deadlock retries and idempotency keys. `Publisher` uses a database advisory lock and a database transaction to avoid duplicate attachment creation. Filesystem changes cannot participate in a MySQL transaction; cleanup and crash recovery are explicit operational concerns.

Remote evidence is normalized before policy evaluation. Credentials are deployment configuration and never appear in JavaScript or support exports. Remote HTTP uses HTTPS, public DNS validation, pinned resolved addresses, bounded response size, and no redirects. QR destinations are never fetched.

The administrative application uses WordPress's React runtime, with a strict TypeScript source and a small build. Assets load only on the plugin screen. REST endpoints authorize with capabilities; WordPress handles cookie/nonce CSRF validation.

The requirements ledger is the acceptance authority. The existence of an interface, feature flag, or submenu is not evidence that a complete requirement is fulfilled.

The workflow/privacy/media pass adds Application/Onboarding and CaseAssignment, Privacy/RecordLifecycle, Infrastructure/ProcessRunner, Media/DocumentMedia/TemporalMedia/ImagePdf/ResultAccumulator and Authenticity/ContentCredentials. Schema 2 adds explicit metadata-erasure state and an expiry index; migrations are serialized per database/blog. Retention and erasure share guarded lifecycle cleanup. Accepted erased records keep only minimal attachment publication eligibility; their deleted private originals cannot be reapproved.

Optional default-off processing resolves deployment-owned absolute tools and uses private workspaces. PDF pages and sampled frames use existing image providers; reduced audio uses transcription adapters. Global provenance is combined with per-part evidence; local text and repeated frames do not supply independent consensus. Process execution is bounded and shell-free but is not an OS sandbox. See MEDIA-PROCESSING.md for deployment isolation and unavailable transformations.

Setup and review APIs store typed settings, tenant-scoped saved views and case assignments. Unresolved overdue cases escalate in worker batches. The UI keeps sensitive previews explicit and uses modal confirmation/focus restoration for consequential review actions. Source modules are separated; dynamic bundle code splitting and full product/accessibility acceptance are still open.
