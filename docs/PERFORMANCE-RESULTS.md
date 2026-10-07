# Measured performance

Local run on 2026-10-06. PHP 8.5.8 policy benchmark: 10,000 iterations, p50 0.000583 ms, p95 0.000875 ms, peak memory 4 MiB. This tiny deterministic policy workload excludes hashing, decoding, DB and external services.

MariaDB 11.4.13, WordPress 6.8.3/PHP 8.3.28 isolated Docker environment, synthetic one-tenant scan table, fifty repeated warm-cache queries at each size:

| Scan rows | Filtered scan page p95 ms | Chosen index |
|---|---:|---|
| 100 | 0.308 | queue_view |
| 10,000 | 1.719 | queue_view |
| 100,000 | 6.085 | queue_view |
| 1,000,000 | 0.725 | queue_view |

Query: site/state/id cursor, ordered ID, thirty summary rows. EXPLAIN used a range with index condition. Benchmark peak PHP memory: 32 MiB. These results do not measure the jobs claim query, cold cache, concurrent writers, realistic multi-tenant skew, provider/network latency, full queue joins or production throughput. Timing variation must not be interpreted as a claim that larger datasets are faster.

Admin bundle at the initial benchmark: 16,506 uncompressed bytes (WordPress's runtime is supplied by the host). Later fixes change the exact size; package verification reports final artifact size. Browser loading also includes shared WordPress components, whose cost is separate.

After the 2026-10-07 hardening pass, the same tiny policy benchmark on host PHP 8.5.8 measured 10,000 iterations: p50 0.0015 ms, p95 0.003333 ms, peak memory 4 MiB. The compiled administration script is 20,635 uncompressed bytes. New validation/evidence checks and machine noise affect these numbers; they are neither a controlled regression comparison nor full-pipeline acceptance. The earlier database measurements were not rerun against the final revision. Queue contention, cold caches, realistic tenant skew, parsing, providers and end-to-end throughput still need acceptance workloads.

Final workflow/media build on 2026-10-07: host PHP 8.5.8, 10,000 tiny deterministic policy iterations, p50 0.0015 ms, p95 0.003292 ms, peak memory 4 MiB. Compiled admin script: 36,259 uncompressed bytes. This is the current bundle measure, superseding earlier sizes above; the earlier table remains historical. There is no controlled full-pipeline comparison or final-revision million-row/concurrent workload result.
