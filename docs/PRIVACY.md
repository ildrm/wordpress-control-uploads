# Privacy and data handling

No product telemetry is implemented. Provider scanning is explicitly configured by the site operator using environment variables or wp-config.php constants. Uploaded originals, raw OCR, QR payloads and credential values are excluded from diagnostics, audit metadata and notifications.

Small images are re-encoded into private reduced derivatives before remote scanning. Those derivatives omit metadata. Uploaded originals are retained privately for operational review (initial expiry: seven days), while public accepted images are independently re-encoded. This changes metadata and may flatten animation; obtain site policy approval and disclose it to uploaders.

Local DLP findings store categories and scores, never matched values. OCR text is used only in memory during policy evaluation. Notes and appeals can contain sensitive user-entered information and require reviewer access. Do not place secrets or raw prohibited content in notes.

Provider credentials are supplied outside the database. No encryption key is shipped. Production audit signing should use a dedicated `CF_AUDIT_KEY`; fallback uses WordPress salts, so salt rotation changes verifiability.

WordPress privacy export returns user-owned summarized scans. Erasure explains retained security records; it does not silently delete evidence. Per-class configurable metadata retention and reviewed user erasure require further acceptance work.

Suggested disclosure: “We inspect uploads to enforce our file security and content policies. Depending on our configuration, privacy-reduced media may be processed by the scanning providers listed in our privacy policy. Files awaiting review are stored privately and retained for the stated review period. Contact us to appeal an upload decision or request access to your records.” Adjust to actual providers, residency, retention and applicable obligations.
