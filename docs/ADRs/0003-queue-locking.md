# ADR 0003: Transactional skip-locked queue claims

Context: A real two-process concurrency test exposed deadlocks in ordered UPDATE LIMIT claims. A lone unit test could not reveal this database behavior.

Decision: Require MySQL 8/MariaDB 10.11+, select the due job FOR UPDATE SKIP LOCKED, assign a random lease token inside a short transaction, and retry only recognized transient deadlock/lock-timeout failures within a bounded budget.

Alternatives considered: retain broad update claims with retry; advisory site-wide locks; an external queue dependency.

Trade-offs: higher database minimum and short transaction overhead; workers avoid waiting on each other's selected row. Resource limits still cap retries and batches.

Consequences: activation validates the database version; real concurrency tests remain in CI. SQL query/index behavior must still be measured with realistic priority/due distributions.
