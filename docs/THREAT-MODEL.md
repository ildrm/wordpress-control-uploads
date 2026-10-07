# Threat model

Assets: public file integrity, private originals, moderator privacy, credentials, tenant records, policy snapshots, provider budgets, queue integrity and review evidence.

Attackers: anonymous uploaders; authenticated low-privilege accounts; malicious files and embedded links; forged provider/webhook responses; compromised provider contracts. Arbitrary PHP plugins, root administrators and a fully compromised hosting account are outside the enforceable plugin boundary.

| Threat | Control | Evidence / limit |
|---|---|---|
| Executable/polyglot upload | Extension/MIME/header checks; image re-encoding | FileSecurityTest; accepted images strip trailers |
| Pixel/archive/XML bombs | Input/pixel/ratio/member/node limits; no recursive extraction or entities | FileSecurityTest; GD remains an in-process parser |
| Private file exposure | Outside-public-root storage, 0700 directories, 0600 files, random IDs, tenant checks | Storage unit tests; explicit persistent path recommended |
| Unauthorized moderation / IDOR | Granular REST capability and blog-scoped repositories | Real WordPress integration tests |
| Stale worker / double publish | CAS revisions; lease tokens; transaction/advisory publication lock | Integration tests; more crash/concurrency scenarios required |
| Interrupted publication / withdrawal | Private durable intent precedes public I/O; worker/direct-retry recovery; random output families; withdrawal hashes guard replaced paths | Actual SIGKILL fixtures, partial-withdrawal/replacement regressions; filesystem/SQL and host power-loss durability remain separate |
| Missing or malformed moderation evidence | Required category coverage, review on unknown evidence, finite typed findings/results and bounded conditions | Unit/contract/WordPress fixtures; provider accuracy and full negative-evidence coverage remain unproven |
| Private REST cache disclosure | Namespace-scoped private/no-store headers and authentication variation | Real browser response assertion; infrastructure must respect headers |
| SSRF / redirect credential leak | HTTPS-only, DNS/IP validation, DNS pinning, disabled redirect/proxy | IP tests; live transport contract remains environment dependent |
| Provider schema drift | Strict normalization, stable failure codes, review bands | Provider contract tests |
| CSRF / stored XSS | WordPress REST authentication; escaped PHP output; React text rendering | Coding-standard checks; browser tests |
| Audit edits | HMAC-signed events; dedicated bounded deployment key required in production | Signature/tamper/weak-key fixtures; nonproduction salt fallback can depend on DB material; signatures cannot prove deleted/missing events |
| Native parser abuse | Explicit executable paths, argv without shell, minimal environment, deadlines/output/type/page/frame/duration limits, file/pipe-only FFmpeg, offline C2PA | Native benign fixtures and process tests; total OS resource/network isolation and adversarial parser corpus remain deployment acceptance |
| Privacy-erasure races | Tenant/publication locks, revision advance, queued work cancellation and accepted-media stub | Privacy fixtures; backups/core/offload/provider erasure remain separate |
| Paid API abuse | Atomic upload quotas, provider caps, cache, bounded input | Queue/limiter tests; budget policy must be configured |

Document files are not declared safe by token matching. Optional PDF rasterization/reconstruction has bounded fixtures and requires isolated, maintained native tools; Office/archive CDR and non-raster previews remain unavailable. Mandatory malware errors hold content privately. An ordinary nudity detector cannot identify CSAM; no illegal fixtures are bundled.

Security reviews must include authorization, shadow-mode bypass, stale response races, publication recovery, archive members, multitenant lookups and secret-bearing payloads. This document is not an independent security certification.
