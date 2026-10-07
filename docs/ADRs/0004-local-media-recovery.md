# ADR 0004: Durable local media operation intents

Context: publication/withdrawal cross database and filesystem boundaries. A row transaction cannot roll back a deleted file; process death can leave an uncommitted public derivative or incomplete metadata. Retrying after the primary file disappears previously failed.

Decision: write and fsync a bounded intent in tenant-private operations storage before local public writes/removal. Rename the intent atomically. Serialize publication by scan and existing attachment; validate the latest attachment association. Withdrawal records the complete relative path set and hashes, validates it before deletion, and resumes missing paths. Publication retry first reconciles its previous intent. Workers reconcile orphan derivatives and finish committed attachment metadata. Public names carry a random operation prefix so cleanup covers generated companions without sweeping unrelated media.

Alternatives considered: database flags alone; ordinary try/finally cleanup; deleting the attachment record; an infrastructure-specific private object-serving layer.

Trade-offs: recovery requires persistent private storage and workers. Unknown/malformed/changed paths fail with an operational error. Metadata extensions can still fail repeatedly. Private work files from terminated processes expire through bounded cleanup after 24 hours.

Consequences: actual SIGKILL tests exercise copy-before-commit and commit-before-metadata. A direct retry removes an orphan before replacing its intent. Metadata recovery preserves accepted files, including core's scaled-file naming. Intent fsync/atomic rename is process-restart protection, not a complete cross-system power-loss guarantee; server-level private delivery and deployment-specific durability tests remain release gates. The checkpoint hook is internal test instrumentation, not a stable extension API.
