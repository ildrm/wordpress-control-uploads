# ADR 0002: Preserve evidence semantics

Context: Vendor categories and scores have incompatible semantics. A severity or likelihood value is not a calibrated posterior probability.

Decision: Use stable taxonomy IDs and typed scale metadata; confidence presets default to review. Malware/security evidence is independent of uploader trust and shadow mode.

Alternatives considered: mapping every vendor value to a purported probability; automatically blocking all high scores.

Trade-offs: more human review until category-specific validation; limited vendor taxonomies cannot satisfy all requested detection categories.

Consequences: software contract tests and actual ML evaluation remain separate acceptance gates.
