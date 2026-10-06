# Operator runbook

Set `CF_PRIVATE_DIR` to a persistent absolute directory outside WordPress, the web-server document root and public uploads. Its owner must match PHP/worker users; mode 0700 with contained files mode 0600. The temporary default is useful for development but is not a production retention guarantee. Back up the private directory together with operational tables; never publish it via a media-offload plugin.

Configure ClamD with current signatures and resource limits; set `CF_CLAMD_SOCKET` to a local Unix socket and require malware scanning in Settings. Do not expose unauthenticated ClamD TCP. Configure needed provider credentials and disclosure; no external provider is required for security-only operation.

Run `wp content-firewall worker run --limit=20 --seconds=25` every minute using system cron. WP-Cron is a trigger, not a realtime guarantee. Watch ready/dead/leased counts, last worker run, provider failure counts and oldest pending work. During outages use private hold; avoid automatic fail-open for mandatory controls.

Restore interrupted jobs through their leases. Preserve correlation/scan IDs for support. Do not include raw uploads or OCR in incident logs. Retry transport/429/5xx failures with backoff; permanent schema/auth errors need configuration or adapter fixes.

Roll out with Security Only, then monitor-mode content policies and lawful evaluation. Validate category/provider coverage before adding automatic enforcement. Audit override reasons. Expired licenses must never relax security; licensing is currently not implemented.

Deactivate preserves records and stops schedules. Uninstall requires explicit delete-on-uninstall for database removal. Private originals need reviewed storage cleanup before removing tables; review the uninstall acceptance notes before deployment.

Troubleshooting: permission/root errors → verify private directory; provider unavailable → verify deployment credentials and account region; pending backlog → run CLI worker and inspect dead letters; unsupported PDF/Office → configure vetted CDR rather than overriding a security certification gap.

Review fixes: a rescan request pins the current policy and commits its queue job with the new revision. Workers can resume publication after a committed result. Terminal scanning failures are shown as FAILED; inspect the stable error and request a new rescan after correcting the cause. Retryable publication failures retain the decision so the next attempt does not repeat provider calls.

Reject/quarantine/delete and held library decisions remove local attachment originals, sizes, source companions and image-edit backups. Reapproval reconstructs from the retained private original and preserves the attachment ID, with a new derivative URL. Cached/CDN copies, offload storage, external links and previously downloaded files require deployment-specific removal. Unsupported or shared local file locations return an error. Review privacy expiry before withdrawing an original that may be needed for reapproval.

Only Privacy Safe metadata reconstruction is supported. Rule effects that have no executor are rejected when saving a policy. Do not advertise privilege suspension, content unpublication or notifications as functioning rule effects. Missing content-category evidence and incomplete required consensus go to human review.
