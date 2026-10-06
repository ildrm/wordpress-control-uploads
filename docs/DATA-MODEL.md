# Data model

Schema version 1 creates dedicated InnoDB tables under the WordPress blog table prefix: `cf_scans`, `cf_findings`, `cf_policies`, `cf_jobs`, `cf_cases`, `cf_case_notes`, `cf_appeals`, `cf_audit`, `cf_usage`, `cf_fingerprints`, `cf_cache`, `cf_events`, `cf_limits`, `cf_evaluations`.

Scans store a correlation ID, site/uploader/attachment, private storage identifier, hash, state/revision, pinned policy ID/version, bounded context/signals/decision summaries, risk and expiry. Findings store normalized category/provider/model/confidence and bounded structured payload. No raw provider response or OCR text is retained. Policies are immutable versioned JSON snapshots.

Jobs have unique `(site_id,idempotency)`, due time, priority, attempts, status, lease expiry and unpredictable ownership token. Scans index site/state/id, attachment, hash, user and expiry. Usage aggregates per provider/day. Rate-limit buckets support conditional atomic increments.

Cases contain assignment, priority, deadline and bounded notes. Appeals record original scan, uploader reason, reviewer and outcome. Audit events are individually signed; signatures do not prove chain completeness. Evaluation rows retain disagreement provenance.

Migration uses WordPress dbDelta and only updates the stored schema version after table verification. Repeat activation is tested. There is no previous released schema to upgrade; multi-version migrations remain a later acceptance obligation. Large transformations must be background batches. SQL identifier placeholders require the chosen WordPress minimum.

Repositories capture their blog table prefix at construction so a later switch_to_blog cannot redirect a cached service to another tenant's tables. Publishing and moderation also validate the active blog. Queue-completed signals include an internal queue_revision marker for retry provenance; it contains no extracted content. Rescans atomically replace the pinned policy/version and enqueue work. Case rationale is append-only; human approvals commit rationale with publication authorization.
