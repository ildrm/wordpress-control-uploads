# Changelog

## 0.1.0 — unreleased engineering build

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
