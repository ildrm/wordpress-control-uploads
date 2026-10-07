# Changelog

## 0.1.0 — unreleased engineering build

### Workflow, privacy and media implementation (2026-10-07)

- Add resumable Setup, typed privacy/operating limits, reviewer/team/priority/deadline assignment, overdue escalation, saved views and explicit decision confirmations.
- Implement paginated WordPress privacy export/erasure, accepted-media state stubs, audit-retention policy and separate retention classes; upgrade schema to version 2 with a migration lock.
- Add bounded native PDF page inspection/image-only reconstruction, sampled video/audio processing, reduced Whisper transcription and offline pinned C2PA verification, all behind explicit default-off flags.
- Renew owned leases during long work, preserve PDF dimensions, keep local provenance in per-page/frame coverage, and exclude local text/duplicate frames from consensus.
- Hold unsupported document/temporal redaction; validate reconstructed stream/duration/size and keep original credentials distinct from public derivatives.
- Add shared real-file policy simulation with private cleanup/no publication jobs, and authenticated owner-safe headless uploads through the durable worker.
- Extend approval checks to ordinary saves, classic galleries/playlists, featured-media changes and scheduled posts; preserve held editorial content as draft.
- Require independent consensus per requested category and inspected page/frame; keep erased stubs out of detail responses.
- Validate signing-key strength/length and require a separate production audit key; stale worker ownership cannot revoke committed media.
- Reject failed queue transaction starts; isolate concurrent claim fixtures from unrelated jobs and make standalone fixtures select the intended multisite blog.
- Expand request/response OpenAPI schemas and regression/CI coverage; correct current guides, test scopes and remaining implementation/acceptance gates.

### Production review hardening (2026-10-07)

- Validate settings, policy shapes, provider results and complete bulk batches; prohibit caching of sensitive API responses.
- Preserve unknown evidence, enforce QR modes, continue incomplete provider coverage and keep required text controls effective during outages.
- Add local text DLP, bounded pattern redaction, located raster masks and conservative review for unavailable transforms.
- Preserve attachment editorial metadata, reject obsolete scan associations and recover local publication/withdrawal after actual worker process termination.
- Reconcile exhausted leases, check commits, audit decisions/outbox atomically, isolate extension notification failures and expose operational issues.
- Enforce tenant context and immutable network policy updates; strengthen SSRF CIDR checks, private expiry and tenant work cleanup.
- Add uploader appeals, typed numeric context input, locale normalization, request schemas and deterministic distribution smoke checks.
- Maintain explicit full-product release blockers; this remains unreleased.

Added upload preflight, private snapshots, policy/state models, moderation queue, provider adapters, database/queue infrastructure, REST/admin/CLI integrations, privacy-aware diagnostics and test tooling. This version has outstanding complete-product acceptance requirements; it is not a certified production release.

### Review fixes (2026-10-06)

- Preserve hard security blocks and fingerprint decisions in queued work.
- Make scan attempts retryable without stale revisions; pin current policies on rescans.
- Remove local public derivatives on held decisions; reconstruct reapproved attachments.
- Validate publication revisions, preserve committed files after metadata failures, and complete gateway sanitation states.
- Require content-category coverage and required consensus; validate calibration and policy options.
- Pin tenant table prefixes, batch Media Library summaries, bound HTTP headers, and close publication-gate gaps.
- Report individual bulk failures, clear stale selections/previews, and guard asynchronous UI responses.
- Add role-based regression checks and reject unimplemented rule effects.
