# Provider contracts

Official documentation was checked on 2026-10-06. Live credentials were not supplied; deterministic contract tests validate request generation and normalization, not actual service availability.

The 2026-10-07 pass tightened normalized finding/result bounds, rejected duplicate provider identities, accumulated category evidence across more than two providers and repaired text fallback/circuit handling. The continuation adds a deterministic Whisper transcription contract and pinned offline C2PA validation; neither establishes live-account/accuracy acceptance. Negative evidence is only trusted where explicitly measured; sanitation without a supported transformation is held for review.

| Adapter | API / authentication | Implemented capability | Important limit |
|---|---|---|---|
| AWS Rekognition | DetectModerationLabels; Signature V4 | JPEG/PNG image moderation | Records returned model version; request bytes ≤5 MiB |
| Google Vision | v1 images:annotate; OAuth bearer token | SafeSearch and OCR | Likelihoods are ordinal; access token refresh is deployment responsibility |
| Azure Content Safety | image:analyze 2024-09-01; subscription header | Hate/self-harm/sexual/violence severity | Severity is not probability; configured endpoint/region |
| Sightengine | 1.0/check.json multipart; API user/secret | nudity-2.1 and gore-2.0 | Other vendor models require separate mappings/validation |
| OpenAI | v1/moderations; bearer token | Supported omni-moderation image categories | Unsupported image categories are omitted, not recorded as safe |
| OpenAI transcription | v1/audio/transcriptions; separate bearer key | Reduced MP3, whisper-1 verbose JSON text/language | No live multilingual benchmark, timestamp redaction or residency assertion |
| Custom scanner | Versioned JSON/base64; bearer | Declared capabilities and normalized findings/OCR/codes | Organization-owned contract; explicit HTTPS endpoint |
| ClamD | local Unix INSTREAM | Malware verdict | Fresh signatures and scanner resource configuration required |
| Hive | Official contract researched | Not yet implemented | V2 enterprise contract vs V3 demo restrictions must be pinned |

Sources: [AWS API](https://docs.aws.amazon.com/rekognition/latest/APIReference/API_DetectModerationLabels.html), [AWS signing](https://docs.aws.amazon.com/IAM/latest/UserGuide/reference_sigv-create-signed-request.html), [Google SafeSearch](https://docs.cloud.google.com/vision/docs/detecting-safe-search), [Azure REST](https://learn.microsoft.com/en-us/azure/ai-services/content-safety/quickstart-image?pivots=programming-language-rest), [Sightengine](https://sightengine.com/docs/), [OpenAI moderation](https://developers.openai.com/api/docs/guides/moderation), [ClamAV](https://docs.clamav.net/manual/Usage/Scanning.html), [Hive overview](https://docs.thehive.ai/docs/visual-content-moderation).

Provider selection is ordered, capability-driven and cached. Region metadata is not a residency guarantee. Account-specific prices are not hardcoded; displayed costs are estimates and must not be treated as invoices. Cached results expire within 24 hours; unknown/changing vendor models need stronger deployment pins before production enforcement.

Mutable vendor model aliases/API versions do not prove model compatibility; these adapters do not reuse cached evidence. The custom contract declares a pinned model and rejects mismatched response models, permitting compatible signal caching. Stable-model adapters may explicitly declare `cacheable`; a cache hit still short-circuits only if policy evidence is sufficiently confident. OCR and QR payloads are never cached.

Native Poppler PDF, FFmpeg video/audio and offline `c2patool 0.28.1` paths are described in MEDIA-PROCESSING.md. They are local tooling rather than additional HTTP moderation adapters. C2PA verifies original credentials/signature binding; it is not an AI/deepfake detector. The transcription request uses reduced clips and a constant filename; words are discarded after policy evaluation. See [OpenAI transcription API](https://developers.openai.com/api/reference/resources/audio/subresources/transcriptions/methods/create).
