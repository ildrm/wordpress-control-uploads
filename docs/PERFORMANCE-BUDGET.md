# Performance budget

Targets, not claims: ordinary preflight p95 <50 ms; local routing/policy p95 <100 ms; ordinary synchronous provider moderation additional p95 ≤1.5 s; async acknowledgement after storage p95 <250 ms; admin REST processing p95 <300 ms; indexed queue reads at 1M records <500 ms.

Streaming file hashes/copies, bounded image decoding, cheap-first rules, per-provider cache keys, keyset pagination and leased batches constrain work. Provider latency and database latency must be reported independently. No huge analytics datasets are placed in autoloaded options.

Run `php tests/Performance/benchmark.php` for local CPU measurements. Run the real database benchmark in the isolated WordPress environment for 100, 10K, 100K and 1M rows. Synthetic workloads must identify their schema, distributions and query plans. The local benchmark does not establish network/provider or large-site latency.

Measure build bytes using `wc -c assets/admin.js`. Memory and upload size limits are deployment-specific; test low-memory configurations before rollout. Admin evidence must include the Media Library query count and aggregation plans.
