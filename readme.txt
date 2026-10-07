=== WordPress Content Firewall ===
Contributors: ildrm
Tags: upload, moderation, privacy, security
Requires at least: 6.8
Requires PHP: 8.2
Stable tag: 0.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Private upload governance with explainable policies and moderation review.

== Description ==

This is an unreleased engineering build. Complete-product production acceptance is outstanding. Read docs/RELEASE-STATUS.md before any deployment.

Uploads through the covered WordPress gateway receive file validation and private review where required. Images are reconstructed before acceptance. Optional local tools reconstruct PDFs and video/audio; sampled content inspection has explicit limits. Setup, assignments, retention and WordPress privacy tools are available. Provider integrations are optional and use operator-owned credentials. No product telemetry is included.

External services: optional AWS Rekognition, Google Vision, Azure Content Safety, Sightengine, OpenAI moderation/transcription and an operator-owned custom scanner. Configured scanners receive privacy-reduced media to perform the requested checks. Read docs/PROVIDER-MATRIX.md and your provider's terms/privacy policy before enabling external processing. No provider calls occur without configuration.

== Installation ==

1. Install in wp-content/plugins/content-firewall.
2. Set CF_PRIVATE_DIR to a persistent private directory outside served roots, owned by PHP with mode 0700.
3. Activate; begin with Security Only and synthetic testing.
4. Configure a separate strong CF_AUDIT_KEY, providers and required ClamD scanning using deployment constants/environment variables.
5. Review all release gates and run staging acceptance before production use.

== Frequently Asked Questions ==

= Does this identify every prohibited category or certify files as malware-free? =
No. Detection depends on configured, validated scanners. PDFs can use configured image-only reconstruction. Unsupported Office/archive reconstruction and document/temporal redaction remain held. No ML accuracy or comprehensive production-readiness claim is made.

= Are pending uploads public? =
Uploads intercepted before the WordPress public move remain private. Third-party direct filesystem/offload paths need explicit integration.

== Changelog ==

= 0.1.0 =
Initial engineering implementation. See CHANGELOG.md and docs/RELEASE-STATUS.md.
