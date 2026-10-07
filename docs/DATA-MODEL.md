# Data model

Schema version 2 maintains dedicated InnoDB tables under the WordPress blog table prefix: `cf_scans`, `cf_findings`, `cf_policies`, `cf_jobs`, `cf_cases`, `cf_case_notes`, `cf_appeals`, `cf_audit`, `cf_usage`, `cf_fingerprints`, `cf_cache`, `cf_events`, `cf_limits`, `cf_evaluations`.

The current migration verifies required columns and InnoDB engines as well as table existence. Version 2 adds `scans.metadata_erased` and the metadata expiry index; an advisory database/blog lock serializes dbDelta and required-column/engine verification. Local media operation intents live in private filesystem storage; they are not an additional database table. Network policy edits use reserved IDs and a network-wide monotonic sequence; skipped versions after a failed option write are harmless. Existing pinned snapshots remain immutable.

Scans store a correlation ID, site/uploader/attachment, private storage identifier, hash, state/revision, pinned policy ID/version, bounded context/signals/decision summaries, risk, expiry and metadata-erasure state. Findings store normalized category/provider/model/confidence and bounded structured payload. No raw provider response or OCR text is retained. Policies are immutable versioned JSON snapshots.

Jobs have unique `(site_id,idempotency)`, due time, priority, attempts, status, lease expiry and unpredictable ownership token. Scans index site/state/id, attachment, hash, user and expiry. Usage aggregates per provider/day. Rate-limit buckets support conditional atomic increments.

Cases contain reviewer/team assignment, priority, UTC deadline and legacy bounded notes; append-only rationale is in case_notes. Appeals record original scan, uploader reason, reviewer and outcome. Audit events are individually signed using a separate production deployment key; signatures do not prove chain completeness. Evaluation rows retain disagreement provenance.

Migration uses WordPress dbDelta and only updates the stored schema version after table verification. Repeat activation is tested. There is no previous released schema to upgrade; prototype schema 1 to 2 and repeat migrations have fixtures, while historical/mass migration and rollback acceptance remain open. Large transformations must be background batches. SQL identifier placeholders require the chosen WordPress minimum.

Repositories capture their blog table prefix at construction so a later switch_to_blog cannot redirect a cached service to another tenant's tables. Publishing and moderation also validate the active blog. Queue-completed signals include an internal queue_revision marker for retry provenance; it contains no extracted content. Rescans atomically replace the pinned policy/version and enqueue work. Case rationale is append-only; human approvals commit rationale with publication authorization.

Retention classes are stored in validated `cf_settings.retention`; processor flags/limits use `processing` and explicit booleans. `cf_onboarding_step` stores resumable setup progress. Saved views use per-user/per-site `cf_queue_views_{site_id}` metadata and are included in privacy cleanup/uninstall. Private original expiry is fixed at receipt; metadata expiry uses scan creation time and current class limits. See PRIVACY.md for preserved accepted stubs, audit-retention choice and separate core media.

The administrator/integration-managed `cf_upload_suspended` control is global WordPress user metadata. Privacy export discloses it; erasure reports retention instead of silently unbanning an account. It has no automatic plugin expiry and needs an operator policy distinct from per-site audit/scan retention. Editor publication notices are short-lived per-user/per-blog transients; they contain only translated safe messages.
