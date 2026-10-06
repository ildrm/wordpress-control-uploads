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
