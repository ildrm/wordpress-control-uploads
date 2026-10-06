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
| SSRF / redirect credential leak | HTTPS-only, DNS/IP validation, DNS pinning, disabled redirect/proxy | IP tests; live transport contract remains environment dependent |
| Provider schema drift | Strict normalization, stable failure codes, review bands | Provider contract tests |
| CSRF / stored XSS | WordPress REST authentication; escaped PHP output; React text rendering | Coding-standard checks; browser tests |
| Audit edits | HMAC-signed events, key outside DB | Integration signature check; cannot prove deleted/missing events |
| Paid API abuse | Atomic upload quotas, provider caps, cache, bounded input | Queue/limiter tests; budget policy must be configured |

Document files are not declared safe by token matching. PDF/Office CDR and safe preview require an isolated, vetted parser/provider. Mandatory malware errors hold content privately. An ordinary nudity detector cannot identify CSAM; no illegal fixtures are bundled.

Security reviews must include authorization, shadow-mode bypass, stale response races, publication recovery, archive members, multitenant lookups and secret-bearing payloads. This document is not an independent security certification.
