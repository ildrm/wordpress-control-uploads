# Architecture

`ContentFirewall` is the stable engineering namespace; the product display name and text domain are centralized at integration boundaries. PHP 8.2+ enums and immutable domain values keep decisions separate from WordPress arrays.

The main plugin registers lifecycle hooks and a small loader. Frontend requests register upload hooks without creating the database/provider graph. `Services` is constructed lazily for the current blog. Tables use the current `$wpdb->prefix` and scan/queue access additionally checks the current site ID.

Upload flow: authorization and atomic quota → filename/size/type/header validation → streaming SHA-256 → private immutable snapshot → security inspection → policy → optional asynchronous provider job → review or checked derivative publication. Unknown scanner evidence and malformed responses must not become negative findings. Security blocks cannot be relaxed by monitor mode or trusted roles.

The public WordPress uploads directory only receives accepted derivatives through covered upload hooks. An asynchronous upload returns a private case reference; it does not create a public placeholder attachment. Files written directly by third-party code bypass these hooks; post-insertion verification is compensating detection and cannot eliminate an earlier public exposure window.

`ScanRepository` uses revision comparisons. `JobRepository` uses SKIP LOCKED transactional claims, atomic lease ownership, bounded deadlock retries and idempotency keys. `Publisher` uses a database advisory lock and a database transaction to avoid duplicate attachment creation. Filesystem changes cannot participate in a MySQL transaction; cleanup and crash recovery are explicit operational concerns.

Remote evidence is normalized before policy evaluation. Credentials are deployment configuration and never appear in JavaScript or support exports. Remote HTTP uses HTTPS, public DNS validation, pinned resolved addresses, bounded response size, and no redirects. QR destinations are never fetched.

The administrative application uses WordPress's React runtime, with a strict TypeScript source and a small build. Assets load only on the plugin screen. REST endpoints authorize with capabilities; WordPress handles cookie/nonce CSRF validation.

The requirements ledger is the acceptance authority. The existence of an interface, feature flag, or submenu is not evidence that a complete requirement is fulfilled.
