# Requirements traceability

Every source statement is retained below with a stable ID. Related module/test paths indicate partial evidence, not full feature coverage. Current capabilities and limitations are maintained in MEDIA-PROCESSING.md, PRIVACY.md, UX-SPEC.md and RELEASE-STATUS.md. All section acceptance gates remain open until the entire listed behavior is validated. SOURCE-REQUIREMENTS.md preserves the complete user specification. RELEASE-STATUS.md identifies release blockers.

| ID | Feature / source statement | Implementation status | Source module | Tests / evidence | UI | Documentation | Acceptance |
|---|---|---|---|---|---|---|---|
| CF-000-000 | PRIMARY OBJECTIVE | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-000-001 | Build the most comprehensive upload security, content moderation, privacy, Trust & Safety, and file-governance plugin available for WordPress. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-000-002 | The system must inspect uploaded files and determine whether they should be: | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-000-003 | ALLOW | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-000-004 | SANITIZE | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-000-005 | REVIEW | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-000-006 | QUARANTINE | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-000-007 | BLOCK | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-000-008 | The plugin must protect WordPress from unsafe or prohibited uploaded content while maintaining: | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-000-009 | 1. extremely high performance; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-000-010 | 2. minimal CPU and memory usage; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-000-011 | 3. minimal external API cost; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-000-012 | 4. extremely low false-positive rates; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-000-013 | 5. extremely low false-negative rates; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-000-014 | 6. predictable and explainable decisions; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-000-015 | 7. robust security; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-000-016 | 8. excellent reliability; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-000-017 | 9. strong privacy controls; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-000-018 | 10. excellent WordPress-native UI/UX; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-000-019 | 11. extensibility; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-000-020 | 12. large-site scalability; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-000-021 | 13. multisite compatibility; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-000-022 | 14. internationalization and RTL support; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-000-023 | 15. accessibility at WCAG AA or better. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-000-024 | Do not optimize one of these by blindly sacrificing the others. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-000 | HIGH-EFFORT EXECUTION PROTOCOL | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-001 | Because reasoning effort is HIGH rather than XHIGH/MAX, compensate through explicit engineering process. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-002 | Do NOT attempt the project through one undifferentiated implementation pass. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-003 | Follow this cycle continuously: | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-004 | DISCOVER | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-005 | → ARCHITECT | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-006 | → IMPLEMENT | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-007 | → TEST | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-008 | → SECURITY REVIEW | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-009 | → PERFORMANCE REVIEW | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-010 | → ML/ACCURACY REVIEW | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-011 | → UX REVIEW | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-012 | → FIX | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-013 | → REGRESSION TEST | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-014 | → DOCUMENT | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-015 | → NEXT MILESTONE | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-016 | Maintain persistent project artifacts so decisions do not disappear as the implementation grows. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-017 | Create and continuously maintain: | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-018 | docs/REQUIREMENTS-TRACEABILITY.md | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-019 | docs/ARCHITECTURE.md | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-020 | docs/THREAT-MODEL.md | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-021 | docs/PERFORMANCE-BUDGET.md | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-022 | docs/MODERATION-QUALITY.md | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-023 | docs/PRIVACY.md | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-024 | docs/UX-SPEC.md | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-025 | docs/DATA-MODEL.md | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-026 | docs/PROVIDER-MATRIX.md | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-027 | docs/COMPATIBILITY.md | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-028 | docs/OPERATIONS.md | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-029 | docs/ADRs/ | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-030 | CHANGELOG.md | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-031 | Every functional requirement in this prompt must appear in the requirements traceability matrix with: | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-032 | requirement ID; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-033 | feature; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-034 | implementation status; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-035 | source module; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-036 | tests; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-037 | UI exposure where applicable; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-038 | documentation; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-039 | acceptance status. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-040 | Never mark a requirement complete without corresponding implementation and validation. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-041 | Do not expose private chain-of-thought. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-042 | Record engineering decisions as concise ADRs containing: | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-043 | Context | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-044 | Decision | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-045 | Alternatives considered | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-046 | Trade-offs | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-001-047 | Consequences | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-002-000 | CURRENT-DOCUMENTATION REQUIREMENT | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-002-001 | Your internal knowledge may be older than the current environment. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-002-002 | Before making implementation decisions involving: | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-002-003 | current WordPress behavior; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-002-004 | WordPress Media Library; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-002-005 | client-side media processing; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-002-006 | REST APIs; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-002-007 | plugin repository requirements; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-002-008 | PHP support; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-002-009 | browser support; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-002-010 | provider APIs; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-002-011 | AWS; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-002-012 | Google; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-002-013 | Microsoft/Azure; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-002-014 | Sightengine; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-002-015 | Hive; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-002-016 | ClamAV; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-002-017 | C2PA; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-002-018 | WordPress packages; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-002-019 | external dependencies; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-002-020 | use available web/documentation tools to verify current official documentation. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-002-021 | Prefer primary sources. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-002-022 | Do not silently assume an API contract from memory. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-002-023 | Pin external API assumptions in docs/PROVIDER-MATRIX.md. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-003-000 | AUTONOMOUS EXECUTION RULES | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-003-001 | If a repository already exists: | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-003-002 | 1. inspect it first; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-003-003 | 2. understand its architecture; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-003-004 | 3. run its existing tests; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-003-005 | 4. preserve unrelated functionality; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-003-006 | 5. integrate cleanly. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-003-007 | If the repository is empty: | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-003-008 | create the complete plugin architecture. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-003-009 | Do NOT stop after producing a plan. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-003-010 | Do NOT stop after scaffolding. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-003-011 | Do NOT implement only the MVP. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-003-012 | The final goal is implementation of the complete product described here. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-003-013 | Do not repeatedly request permission between milestones. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-003-014 | When external credentials are unavailable: | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-003-015 | implement the provider adapter; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-003-016 | implement configuration; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-003-017 | provide deterministic mocks; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-003-018 | provide contract tests; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-003-019 | provide integration-test instructions; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-003-020 | continue with the rest of the system. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-003-021 | Never hardcode secrets. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-000 | VIRTUAL ENGINEERING ORGANIZATION | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-001 | Throughout implementation you must explicitly perform review passes from the perspectives of all of these roles. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-002 | ## Product Owner / Product Architect | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-003 | Own requirements, behavior and acceptance criteria. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-004 | Reject features that technically exist but do not provide a coherent user experience. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-005 | ## Principal WordPress Architect | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-006 | Ensure proper use of: | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-007 | WordPress lifecycle | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-008 | hooks | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-009 | Media Library | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-010 | REST API | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-011 | roles/capabilities | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-012 | multisite | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-013 | privacy APIs | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-014 | cron/background processing | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-015 | Site Health | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-016 | WP-CLI | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-017 | plugin activation/deactivation/uninstall | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-018 | database upgrades | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-019 | internationalization | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-020 | plugin compatibility | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-021 | ## Senior PHP Engineer | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-022 | Own maintainable, modular and testable server-side code. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-023 | ## REST/API Engineer | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-024 | Own typed schemas, authorization, validation, pagination, versioning and headless use cases. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-025 | ## Frontend Engineer | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-026 | Own performant WordPress-native admin application behavior. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-027 | ## UX/UI Designer | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-028 | Own information architecture, interaction design, onboarding, queue workflows, rule construction and error prevention. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-029 | ## Accessibility Specialist | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-030 | Audit keyboard operation, focus, semantics, contrast, screen readers, reduced motion and accessible status communication. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-031 | ## Trust & Safety Architect | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-032 | Own moderation taxonomy, escalation policy, human review, appeals and safety operations. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-033 | ## Applied ML / Computer Vision Engineer | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-034 | Own classifiers, provider normalization, ensembles, uncertainty and multimodal scanning. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-035 | ## ML Evaluation Engineer | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-036 | Own: | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-037 | precision | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-038 | recall | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-039 | false-positive rate | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-040 | false-negative rate | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-041 | threshold calibration | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-042 | drift | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-043 | provider comparison | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-044 | human disagreement metrics. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-045 | ## Application Security Engineer | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-046 | Assume every uploaded file and request is hostile. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-047 | ## File Security Engineer | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-048 | Own: | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-049 | malware scanning | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-050 | archive inspection | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-051 | SVG sanitization | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-052 | document sanitization | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-053 | PDF security | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-054 | Office security | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-055 | content disarm and reconstruction. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-056 | ## Privacy / DLP Engineer | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-057 | Own: | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-058 | PII | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-059 | redaction | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-060 | data minimization | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-061 | retention | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-062 | data residency | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-063 | external provider exposure. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-064 | ## Performance Engineer | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-065 | Audit CPU, RAM, network, API calls, database queries and browser bundle cost. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-066 | ## SRE / Reliability Engineer | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-067 | Own: | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-068 | timeouts | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-069 | retries | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-070 | queues | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-071 | idempotency | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-072 | circuit breakers | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-073 | backpressure | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-074 | provider failures | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-075 | health monitoring. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-076 | ## Data Architect | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-077 | Own schema design, migrations, indexes, analytics retention and query performance. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-078 | ## Integrations Engineer | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-079 | Own external-provider and WordPress-plugin compatibility. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-080 | ## QA Engineer | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-081 | Require automated evidence rather than assumptions. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-082 | ## Adversarial Engineer | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-083 | Attempt to bypass every safety and security control. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-084 | ## Observability Engineer | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-085 | Ensure the system can explain what happened and why. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-086 | ## Release Engineer | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-087 | Own reproducible builds and dependency security. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-088 | ## Technical Writer | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-004-089 | Make the finished system deployable without reading source code. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-005-000 | NON-NEGOTIABLE ENGINEERING PRINCIPLES | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-005-001 | Use a clean modular architecture. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-005-002 | Avoid a giant service class. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-005-003 | Avoid global mutable state. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-005-004 | Avoid business logic directly inside hooks/controllers. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-005-005 | Avoid excessive static methods. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-005-006 | Avoid loading the entire application on every WordPress request. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-005-007 | Use lazy bootstrapping. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-005-008 | Only initialize functionality necessary for the current request. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-005-009 | Separate: | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-005-010 | Domain | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-005-011 | Application | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-005-012 | Infrastructure | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-005-013 | WordPress integration | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-005-014 | Admin UI | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-005-015 | Providers | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-005-016 | Security | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-005-017 | Persistence | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-005-018 | Queue processing | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-005-019 | REST | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-005-020 | CLI | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-005-021 | Analytics | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-005-022 | Do not perform expensive remote scans unnecessarily. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-005-023 | Do not store huge analytics datasets inside wp_options. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-005-024 | Do not autoload large configuration or transient datasets. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-005-025 | Do not decode enormous images before checking dimensions/resource limits. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-005-026 | Do not trust: | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-005-027 | file names | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-005-028 | extensions | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-005-029 | browser MIME values | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-005-030 | user-controlled URLs | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-005-031 | metadata | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-005-032 | archives | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-005-033 | remote URLs | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-005-034 | provider callbacks | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-005-035 | REST parameters. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-005-036 | Use WordPress APIs where they provide important security or compatibility guarantees. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-006-000 | SUGGESTED PROJECT ARCHITECTURE | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-006-001 | Use a modular structure comparable to: | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-006-002 | plugin.php | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-006-003 | src/ | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-006-004 | src/Bootstrap/ | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-006-005 | src/Domain/ | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-006-006 | src/Application/ | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-006-007 | src/Infrastructure/ | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-006-008 | src/WordPress/ | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-006-009 | src/Upload/ | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-006-010 | src/Policy/ | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-006-011 | src/Moderation/ | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-006-012 | src/Security/ | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-006-013 | src/Privacy/ | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-006-014 | src/Providers/ | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-006-015 | src/Queue/ | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-006-016 | src/Media/ | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-006-017 | src/Analytics/ | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-006-018 | src/Audit/ | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-006-019 | src/REST/ | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-006-020 | src/CLI/ | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-006-021 | src/Multisite/ | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-006-022 | src/Integrations/ | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-006-023 | src/Health/ | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-006-024 | src/Admin/ | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-006-025 | assets/ | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-006-026 | tests/Unit/ | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-006-027 | tests/Integration/ | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-006-028 | tests/Contract/ | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-006-029 | tests/E2E/ | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-006-030 | tests/Security/ | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-006-031 | tests/Performance/ | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-006-032 | docs/ | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-006-033 | Use Composer autoloading and namespacing. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-006-034 | Keep vendor dependencies controlled and auditable. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-006-035 | Avoid bundling duplicate copies of libraries already safely supplied by WordPress when possible. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-007-000 | CORE DOMAIN MODEL | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-007-001 | Define first-class immutable or strongly controlled domain objects for concepts such as: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-007-002 | UploadContext | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-007-003 | FileDescriptor | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-007-004 | ScanRequest | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-007-005 | Finding | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-007-006 | NormalizedFinding | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-007-007 | ProviderResult | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-007-008 | ModerationResult | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-007-009 | RiskScore | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-007-010 | Policy | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-007-011 | PolicyVersion | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-007-012 | Rule | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-007-013 | RuleCondition | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-007-014 | RuleAction | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-007-015 | Decision | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-007-016 | DecisionReason | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-007-017 | QuarantineRecord | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-007-018 | ReviewCase | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-007-019 | Appeal | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-007-020 | AuditEvent | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-007-021 | ProviderCapability | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-007-022 | ScannerHealth | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-007-023 | Fingerprint | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-007-024 | Do not pass unstructured associative arrays throughout the entire application. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-007-025 | Arrays may be used at WordPress boundaries but normalize them immediately. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-008-000 | UPLOAD STATE MACHINE | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-008-001 | Design an explicit state machine. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-008-002 | Suggested states: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-008-003 | RECEIVED | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-008-004 | PREFLIGHT | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-008-005 | SECURITY_SCANNING | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-008-006 | CONTENT_SCANNING | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-008-007 | SANITIZING | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-008-008 | PENDING_PROVIDER | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-008-009 | QUARANTINED | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-008-010 | REVIEW_REQUIRED | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-008-011 | ALLOWED | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-008-012 | SANITIZED | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-008-013 | BLOCKED | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-008-014 | FAILED | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-008-015 | APPEALED | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-008-016 | DELETED | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-008-017 | Transitions must be: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-008-018 | valid | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-008-019 | idempotent | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-008-020 | auditable | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-008-021 | transaction-safe. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-008-022 | Prevent double publication caused by racing workers. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-008-023 | Prevent stale asynchronous responses from overwriting newer decisions. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-009-000 | UPLOAD COVERAGE | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-009-001 | Support and test uploads originating from: | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-009-002 | WordPress Media Library | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-009-003 | Block Editor | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-009-004 | Classic Editor | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-009-005 | featured images | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-009-006 | REST media endpoints | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-009-007 | client-side WordPress media processing | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-009-008 | AJAX uploads | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-009-009 | frontend forms | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-009-010 | avatars | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-009-011 | comment attachments | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-009-012 | custom post types | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-009-013 | sideloaded files | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-009-014 | remote imports | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-009-015 | WooCommerce product media | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-009-016 | community plugins | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-009-017 | marketplace plugins | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-009-018 | multisite | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-009-019 | WP-CLI | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-009-020 | custom integrations. | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-009-021 | Intercept the earliest safe point possible. | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-009-022 | Also provide post-upload verification for files that bypass primary interception. | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-009-023 | Document unavoidable bypass conditions. | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-010-000 | IMAGE CONTENT MODERATION | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-010-001 | Implement configurable detection of: | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-010-002 | explicit nudity | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-010-003 | genital exposure | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-010-004 | breast exposure | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-010-005 | buttock exposure | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-010-006 | sexual activity | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-010-007 | pornographic content | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-010-008 | erotic content | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-010-009 | suggestive poses | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-010-010 | implied nudity | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-010-011 | lingerie | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-010-012 | underwear | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-010-013 | swimwear | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-010-014 | sexual objects | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-010-015 | fetish-related content | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-010-016 | animated/cartoon adult content. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-010-017 | Normalize provider-specific taxonomies into the plugin's internal taxonomy. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-010-018 | Never expose provider-specific semantics directly to the policy engine. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-011-000 | VIOLENCE / GRAPHIC CONTENT | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-011-001 | Support: | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-011-002 | physical violence | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-011-003 | assault | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-011-004 | fights | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-011-005 | torture | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-011-006 | executions | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-011-007 | corpses | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-011-008 | severe injury | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-011-009 | wounds | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-011-010 | exposed organs | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-011-011 | blood | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-011-012 | gore | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-011-013 | accidents | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-011-014 | war imagery | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-011-015 | violent threats | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-011-016 | animal cruelty | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-011-017 | disturbing imagery. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-011-018 | Each category must have independent policy control and confidence thresholds. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-012-000 | WEAPON MODERATION | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-012-001 | Detect and control: | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-012-002 | firearms | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-012-003 | firearms being held | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-012-004 | firearms being aimed | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-012-005 | threatening firearm use | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-012-006 | knives | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-012-007 | swords | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-012-008 | explosives | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-012-009 | ammunition | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-012-010 | realistic weapons | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-012-011 | replica/toy weapons. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-012-012 | Context must be usable by policy rules. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-012-013 | Example: | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-012-014 | knife in kitchen-product category may differ from knife in avatar context. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-013-000 | DRUG / ALCOHOL / TOBACCO MODERATION | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-013-001 | Support: | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-013-002 | cannabis | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-013-003 | recreational drugs | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-013-004 | drug paraphernalia | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-013-005 | pills | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-013-006 | syringes | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-013-007 | prescription medication | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-013-008 | drug use | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-013-009 | alcohol | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-013-010 | alcohol consumption | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-013-011 | tobacco | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-013-012 | cigarettes | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-013-013 | vapes | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-013-014 | smoking. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-014-000 | HATE / EXTREMISM | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-014-001 | Detect: | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-014-002 | hate symbols | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-014-003 | extremist symbols | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-014-004 | racist imagery | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-014-005 | discriminatory imagery | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-014-006 | offensive gestures | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-014-007 | extremist propaganda | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-014-008 | terrorism-related imagery | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-014-009 | hateful textual content within media. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-014-010 | Allow policy context to distinguish editorial/historical use from prohibited UGC. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-015-000 | SELF-HARM | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-015-001 | Support visual/textual indicators of: | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-015-002 | self-inflicted injury | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-015-003 | suicide imagery | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-015-004 | cutting | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-015-005 | hanging | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-015-006 | self-harm scenes | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-015-007 | self-harm-related text. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-015-008 | Do not automatically conflate awareness/educational material with harmful content. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-015-009 | Use policy/context. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-016-000 | OCR | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-016-001 | Implement OCR integration capable of extracting text from: | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-016-002 | screenshots | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-016-003 | memes | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-016-004 | documents | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-016-005 | photos | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-016-006 | posters | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-016-007 | banners | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-016-008 | advertisements | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-016-009 | profile images | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-016-010 | product imagery | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-016-011 | chat screenshots. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-016-012 | Run normalized extracted text through moderation. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-016-013 | Store only necessary extracted text according to retention policy. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-017-000 | TEXT MODERATION | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-017-001 | OCR and document text should support detection of: | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-017-002 | profanity | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-017-003 | sexual language | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-017-004 | hate speech | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-017-005 | bullying | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-017-006 | harassment | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-017-007 | threats | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-017-008 | spam | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-017-009 | scams | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-017-010 | extremism | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-017-011 | drug references | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-017-012 | weapon references | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-017-013 | self-harm content | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-017-014 | forbidden URLs | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-017-015 | forbidden contact information | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-017-016 | custom words/regex/patterns. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-017-017 | Support multilingual text where providers permit. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-018-000 | QR CODE / BARCODE ANALYSIS | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-018-001 | Detect QR codes. | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-018-002 | Decode locally when safely possible. | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-018-003 | Support policies: | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-018-004 | block all QR codes | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-018-005 | allow QR codes | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-018-006 | allow only approved domains | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-018-007 | block external domains | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-018-008 | flag suspicious destinations | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-018-009 | block contact-sharing QR codes | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-018-010 | block payment QR codes. | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-018-011 | Never blindly fetch decoded URLs. | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-018-012 | Any URL inspection must be SSRF-safe. | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-019-000 | PII / DLP | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-019-001 | Detect configurable sensitive information: | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-019-002 | email addresses | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-019-003 | telephone numbers | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-019-004 | postal addresses | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-019-005 | IP addresses | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-019-006 | credit card information | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-019-007 | bank identifiers | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-019-008 | national IDs | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-019-009 | passport numbers | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-019-010 | usernames | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-019-011 | social-media handles | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-019-012 | URLs | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-019-013 | custom identifiers. | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-019-014 | Support detection from: | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-019-015 | images | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-019-016 | OCR text | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-019-017 | PDFs | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-019-018 | documents | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-019-019 | document metadata. | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-020-000 | AUTOMATIC REDACTION | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-020-001 | Provide optional sanitization for: | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-020-002 | faces | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-020-003 | children's faces where supported | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-020-004 | license plates | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-020-005 | emails | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-020-006 | phones | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-020-007 | national identifiers | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-020-008 | account numbers | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-020-009 | profanity | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-020-010 | social handles | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-020-011 | QR codes | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-020-012 | selected sensitive visual regions. | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-020-013 | Never destroy the original unless policy explicitly requests it. | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-020-014 | Prefer transactional creation of sanitized derivatives. | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-021-000 | EXIF / METADATA PRIVACY | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-021-001 | Inspect and optionally remove: | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-021-002 | GPS | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-021-003 | camera model | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-021-004 | capture date/time | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-021-005 | author | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-021-006 | editing software | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-021-007 | comments | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-021-008 | embedded thumbnails | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-021-009 | device information | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-021-010 | other metadata. | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-021-011 | Provide presets: | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-021-012 | Preserve All | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-021-013 | Remove Location | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-021-014 | Privacy Safe | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-021-015 | Strip All | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-021-016 | Preserve Copyright Only. | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-022-000 | TECHNICAL IMAGE VALIDATION | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-022-001 | Implement per-policy rules for: | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-022-002 | minimum width | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-022-003 | maximum width | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-022-004 | minimum height | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-022-005 | maximum height | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-022-006 | minimum megapixels | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-022-007 | maximum megapixels | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-022-008 | file size | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-022-009 | aspect ratio | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-022-010 | orientation | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-022-011 | transparency | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-022-012 | animation | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-022-013 | color space | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-022-014 | frame count | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-022-015 | pixel count | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-022-016 | supported formats | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-022-017 | minimum quality where measurable. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-022-018 | Protect against decompression/pixel bombs before full decoding. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-023-000 | IMAGE QUALITY ANALYSIS | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-023-001 | Detect where possible: | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-023-002 | blur | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-023-003 | extreme darkness | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-023-004 | extreme brightness | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-023-005 | low resolution | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-023-006 | blank imagery | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-023-007 | corruption | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-023-008 | extreme compression | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-023-009 | screenshots | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-023-010 | problematic crops. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-023-011 | Policies may: | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-023-012 | allow | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-023-013 | warn | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-023-014 | review | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-023-015 | block. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-024-000 | TRUE FILE-TYPE VALIDATION | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-024-001 | Do not trust extensions. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-024-002 | Validate: | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-024-003 | extension | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-024-004 | declared MIME | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-024-005 | magic bytes | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-024-006 | actual parser result | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-024-007 | real decoded format. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-024-008 | Protect against: | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-024-009 | double extensions | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-024-010 | extension mismatch | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-024-011 | polyglot files | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-024-012 | renamed executables | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-024-013 | malformed headers | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-024-014 | dangerous filenames | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-024-015 | control characters | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-024-016 | path traversal. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-024-017 | Use WordPress MIME/type validation appropriately and strengthen it where necessary. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-024-018 | Never require ALLOW_UNFILTERED_UPLOADS. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-025-000 | MALWARE SCANNING | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-025-001 | Create an extensible malware scanner interface. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-025-002 | Support at minimum: | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-025-003 | ClamAV/ClamD | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-025-004 | custom scanner endpoint | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-025-005 | commercial scanner adapters. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-025-006 | Detect: | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-025-007 | viruses | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-025-008 | trojans | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-025-009 | worms | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-025-010 | malicious document macros | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-025-011 | malicious archives | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-025-012 | embedded executables | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-025-013 | known malicious signatures. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-025-014 | Results: | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-025-015 | CLEAN | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-025-016 | SUSPICIOUS | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-025-017 | INFECTED | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-025-018 | SCANNER_ERROR. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-026-000 | ARCHIVE SECURITY | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-026-001 | Support safe inspection of allowed archive formats. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-026-002 | Control: | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-026-003 | maximum archive size | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-026-004 | maximum uncompressed size | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-026-005 | compression ratio | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-026-006 | nesting depth | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-026-007 | file count | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-026-008 | contained extensions | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-026-009 | contained MIME types | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-026-010 | encrypted archives | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-026-011 | password-protected archives. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-026-012 | Detect/archive-protect against decompression bombs. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-026-013 | Do not recursively decompress without resource limits. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-027-000 | SVG SECURITY | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-027-001 | Treat SVG as active XML content. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-027-002 | Detect/remove/reject: | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-027-003 | scripts | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-027-004 | event handlers | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-027-005 | unsafe foreign objects | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-027-006 | iframes | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-027-007 | embedded active content | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-027-008 | external references | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-027-009 | dangerous URLs | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-027-010 | XML entities | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-027-011 | unsafe CSS | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-027-012 | oversized DOM trees. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-027-013 | Provide sanitize or reject policies. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-027-014 | Never equate MIME=image/svg+xml with safety. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-028-000 | PDF SECURITY | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-028-001 | Inspect PDFs for: | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-028-002 | JavaScript | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-028-003 | embedded files | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-028-004 | launch actions | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-028-005 | external links | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-028-006 | suspicious actions | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-028-007 | excessive pages | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-028-008 | password protection | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-028-009 | malformed structure | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-028-010 | malware | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-028-011 | PII | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-028-012 | OCR content | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-028-013 | inappropriate images. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-028-014 | Support: | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-028-015 | ALLOW | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-028-016 | SANITIZE | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-028-017 | FLATTEN | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-028-018 | REVIEW | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-028-019 | BLOCK. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-029-000 | OFFICE DOCUMENT SECURITY | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-029-001 | Support DOC/DOCX/XLS/XLSX/PPT/PPTX as configured. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-029-002 | Inspect: | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-029-003 | macros | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-029-004 | embedded executables | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-029-005 | OLE objects | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-029-006 | external references | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-029-007 | malware | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-029-008 | PII | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-029-009 | links | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-029-010 | text | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-029-011 | embedded media. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-030-000 | CONTENT DISARM AND RECONSTRUCTION | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-030-001 | Design a CDR abstraction. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-030-002 | Possible flows: | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-030-003 | image decode → safe re-encode | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-030-004 | SVG parse → sanitize → regenerate | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-030-005 | PDF sanitize/flatten → regenerate | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-030-006 | Office document → remove active content → rebuild. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-030-007 | Allow third-party CDR providers. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-030-008 | Never pretend a simple rename/recompression operation is equivalent to proper document CDR. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-031-000 | EXACT DUPLICATE DETECTION | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-031-001 | Calculate streaming cryptographic hashes such as SHA-256. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-031-002 | Allow: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-031-003 | reject duplicate | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-031-004 | reuse attachment | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-031-005 | warn | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-031-006 | allow. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-031-007 | Cache previous scan results only when validity requirements match: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-031-008 | same file hash | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-031-009 | compatible policy | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-031-010 | compatible provider/model version | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-031-011 | unexpired result. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-032-000 | PERCEPTUAL DUPLICATE DETECTION | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-032-001 | Support perceptual fingerprints for images. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-032-002 | Detect modifications including: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-032-003 | resizing | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-032-004 | recompression | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-032-005 | minor cropping | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-032-006 | brightness modifications | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-032-007 | format conversion | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-032-008 | watermarks. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-032-009 | Use configurable similarity thresholds. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-033-000 | BLOCKED CONTENT FINGERPRINTS | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-033-001 | Moderators may create fingerprints of blocked media. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-033-002 | Use exact and perceptual matching. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-033-003 | A modified version of previously prohibited content can therefore enter REVIEW/BLOCK without paying for every expensive provider scan. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-034-000 | AI-GENERATED CONTENT | Not implemented | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-034-001 | Add provider abstraction for AI-generated-content detection. | Not implemented | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-034-002 | Policies: | Not implemented | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-034-003 | allow | Not implemented | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-034-004 | label | Not implemented | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-034-005 | review | Not implemented | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-034-006 | block. | Not implemented | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-034-007 | Treat AI detection as probabilistic evidence, not incontrovertible proof. | Not implemented | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-035-000 | DEEPFAKE DETECTION | Not implemented | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-035-001 | Support image/video deepfake providers. | Not implemented | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-035-002 | Store: | Not implemented | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-035-003 | provider | Not implemented | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-035-004 | model/version | Not implemented | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-035-005 | confidence | Not implemented | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-035-006 | faces/regions where available. | Not implemented | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-035-007 | Use configurable action thresholds. | Not implemented | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-035-008 | Display uncertainty clearly. | Not implemented | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-036-000 | C2PA / CONTENT CREDENTIALS | Partial; see evidence | src/Authenticity/ContentCredentials.php | tests/Unit/ProvenanceTest.php; tests/Integration/provenance-tools.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-036-001 | Implement Content Credentials inspection using maintained C2PA tooling where technically feasible. | Partial; see evidence | src/Authenticity/ContentCredentials.php | tests/Unit/ProvenanceTest.php; tests/Integration/provenance-tools.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-036-002 | Surface: | Partial; see evidence | src/Authenticity/ContentCredentials.php | tests/Unit/ProvenanceTest.php; tests/Integration/provenance-tools.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-036-003 | credential present | Partial; see evidence | src/Authenticity/ContentCredentials.php | tests/Unit/ProvenanceTest.php; tests/Integration/provenance-tools.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-036-004 | credential absent | Partial; see evidence | src/Authenticity/ContentCredentials.php | tests/Unit/ProvenanceTest.php; tests/Integration/provenance-tools.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-036-005 | signature valid/invalid | Partial; see evidence | src/Authenticity/ContentCredentials.php | tests/Unit/ProvenanceTest.php; tests/Integration/provenance-tools.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-036-006 | issuer | Partial; see evidence | src/Authenticity/ContentCredentials.php | tests/Unit/ProvenanceTest.php; tests/Integration/provenance-tools.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-036-007 | assertions | Partial; see evidence | src/Authenticity/ContentCredentials.php | tests/Unit/ProvenanceTest.php; tests/Integration/provenance-tools.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-036-008 | editing history | Partial; see evidence | src/Authenticity/ContentCredentials.php | tests/Unit/ProvenanceTest.php; tests/Integration/provenance-tools.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-036-009 | AI-generation declarations | Partial; see evidence | src/Authenticity/ContentCredentials.php | tests/Unit/ProvenanceTest.php; tests/Integration/provenance-tools.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-036-010 | provenance data. | Partial; see evidence | src/Authenticity/ContentCredentials.php | tests/Unit/ProvenanceTest.php; tests/Integration/provenance-tools.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-036-011 | Never classify “no credential” as “fake.” | Partial; see evidence | src/Authenticity/ContentCredentials.php | tests/Unit/ProvenanceTest.php; tests/Integration/provenance-tools.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-037-000 | VIDEO MODERATION | Partial; see evidence | src/Media/TemporalMedia.php; src/Providers/OpenAiTranscription.php | tests/Integration/media-tools.php; tests/Integration/processing.php; tests/Contract/TranscriptionTest.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-037-001 | Build asynchronous video processing. | Partial; see evidence | src/Media/TemporalMedia.php; src/Providers/OpenAiTranscription.php | tests/Integration/media-tools.php; tests/Integration/processing.php; tests/Contract/TranscriptionTest.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-037-002 | Support: | Partial; see evidence | src/Media/TemporalMedia.php; src/Providers/OpenAiTranscription.php | tests/Integration/media-tools.php; tests/Integration/processing.php; tests/Contract/TranscriptionTest.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-037-003 | frame sampling | Partial; see evidence | src/Media/TemporalMedia.php; src/Providers/OpenAiTranscription.php | tests/Integration/media-tools.php; tests/Integration/processing.php; tests/Contract/TranscriptionTest.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-037-004 | adaptive sampling | Partial; see evidence | src/Media/TemporalMedia.php; src/Providers/OpenAiTranscription.php | tests/Integration/media-tools.php; tests/Integration/processing.php; tests/Contract/TranscriptionTest.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-037-005 | scene-change sampling | Partial; see evidence | src/Media/TemporalMedia.php; src/Providers/OpenAiTranscription.php | tests/Integration/media-tools.php; tests/Integration/processing.php; tests/Contract/TranscriptionTest.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-037-006 | visual moderation | Partial; see evidence | src/Media/TemporalMedia.php; src/Providers/OpenAiTranscription.php | tests/Integration/media-tools.php; tests/Integration/processing.php; tests/Contract/TranscriptionTest.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-037-007 | OCR | Partial; see evidence | src/Media/TemporalMedia.php; src/Providers/OpenAiTranscription.php | tests/Integration/media-tools.php; tests/Integration/processing.php; tests/Contract/TranscriptionTest.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-037-008 | QR detection | Partial; see evidence | src/Media/TemporalMedia.php; src/Providers/OpenAiTranscription.php | tests/Integration/media-tools.php; tests/Integration/processing.php; tests/Contract/TranscriptionTest.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-037-009 | weapons | Partial; see evidence | src/Media/TemporalMedia.php; src/Providers/OpenAiTranscription.php | tests/Integration/media-tools.php; tests/Integration/processing.php; tests/Contract/TranscriptionTest.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-037-010 | nudity | Partial; see evidence | src/Media/TemporalMedia.php; src/Providers/OpenAiTranscription.php | tests/Integration/media-tools.php; tests/Integration/processing.php; tests/Contract/TranscriptionTest.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-037-011 | violence | Partial; see evidence | src/Media/TemporalMedia.php; src/Providers/OpenAiTranscription.php | tests/Integration/media-tools.php; tests/Integration/processing.php; tests/Contract/TranscriptionTest.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-037-012 | drugs | Partial; see evidence | src/Media/TemporalMedia.php; src/Providers/OpenAiTranscription.php | tests/Integration/media-tools.php; tests/Integration/processing.php; tests/Contract/TranscriptionTest.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-037-013 | hate | Partial; see evidence | src/Media/TemporalMedia.php; src/Providers/OpenAiTranscription.php | tests/Integration/media-tools.php; tests/Integration/processing.php; tests/Contract/TranscriptionTest.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-037-014 | self-harm | Partial; see evidence | src/Media/TemporalMedia.php; src/Providers/OpenAiTranscription.php | tests/Integration/media-tools.php; tests/Integration/processing.php; tests/Contract/TranscriptionTest.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-037-015 | logos | Partial; see evidence | src/Media/TemporalMedia.php; src/Providers/OpenAiTranscription.php | tests/Integration/media-tools.php; tests/Integration/processing.php; tests/Contract/TranscriptionTest.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-037-016 | AI/deepfake checks. | Partial; see evidence | src/Media/TemporalMedia.php; src/Providers/OpenAiTranscription.php | tests/Integration/media-tools.php; tests/Integration/processing.php; tests/Contract/TranscriptionTest.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-037-017 | Configurable maximum duration and file size. | Partial; see evidence | src/Media/TemporalMedia.php; src/Providers/OpenAiTranscription.php | tests/Integration/media-tools.php; tests/Integration/processing.php; tests/Contract/TranscriptionTest.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-038-000 | VIDEO AUDIO MODERATION | Partial; see evidence | src/Media/TemporalMedia.php; src/Providers/OpenAiTranscription.php | tests/Integration/media-tools.php; tests/Integration/processing.php; tests/Contract/TranscriptionTest.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-038-001 | Extract or process audio safely. | Partial; see evidence | src/Media/TemporalMedia.php; src/Providers/OpenAiTranscription.php | tests/Integration/media-tools.php; tests/Integration/processing.php; tests/Contract/TranscriptionTest.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-038-002 | Pipeline: | Partial; see evidence | src/Media/TemporalMedia.php; src/Providers/OpenAiTranscription.php | tests/Integration/media-tools.php; tests/Integration/processing.php; tests/Contract/TranscriptionTest.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-038-003 | audio | Partial; see evidence | src/Media/TemporalMedia.php; src/Providers/OpenAiTranscription.php | tests/Integration/media-tools.php; tests/Integration/processing.php; tests/Contract/TranscriptionTest.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-038-004 | → transcription | Partial; see evidence | src/Media/TemporalMedia.php; src/Providers/OpenAiTranscription.php | tests/Integration/media-tools.php; tests/Integration/processing.php; tests/Contract/TranscriptionTest.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-038-005 | → language detection | Partial; see evidence | src/Media/TemporalMedia.php; src/Providers/OpenAiTranscription.php | tests/Integration/media-tools.php; tests/Integration/processing.php; tests/Contract/TranscriptionTest.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-038-006 | → text moderation. | Partial; see evidence | src/Media/TemporalMedia.php; src/Providers/OpenAiTranscription.php | tests/Integration/media-tools.php; tests/Integration/processing.php; tests/Contract/TranscriptionTest.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-038-007 | Combine audio and visual findings into the same normalized result. | Partial; see evidence | src/Media/TemporalMedia.php; src/Providers/OpenAiTranscription.php | tests/Integration/media-tools.php; tests/Integration/processing.php; tests/Contract/TranscriptionTest.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-039-000 | AUDIO MODERATION | Partial; see evidence | src/Media/TemporalMedia.php; src/Providers/OpenAiTranscription.php | tests/Integration/media-tools.php; tests/Integration/processing.php; tests/Contract/TranscriptionTest.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-039-001 | Support allowed formats such as: | Partial; see evidence | src/Media/TemporalMedia.php; src/Providers/OpenAiTranscription.php | tests/Integration/media-tools.php; tests/Integration/processing.php; tests/Contract/TranscriptionTest.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-039-002 | MP3 | Partial; see evidence | src/Media/TemporalMedia.php; src/Providers/OpenAiTranscription.php | tests/Integration/media-tools.php; tests/Integration/processing.php; tests/Contract/TranscriptionTest.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-039-003 | WAV | Partial; see evidence | src/Media/TemporalMedia.php; src/Providers/OpenAiTranscription.php | tests/Integration/media-tools.php; tests/Integration/processing.php; tests/Contract/TranscriptionTest.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-039-004 | M4A | Partial; see evidence | src/Media/TemporalMedia.php; src/Providers/OpenAiTranscription.php | tests/Integration/media-tools.php; tests/Integration/processing.php; tests/Contract/TranscriptionTest.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-039-005 | OGG | Partial; see evidence | src/Media/TemporalMedia.php; src/Providers/OpenAiTranscription.php | tests/Integration/media-tools.php; tests/Integration/processing.php; tests/Contract/TranscriptionTest.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-039-006 | according to environment capabilities. | Partial; see evidence | src/Media/TemporalMedia.php; src/Providers/OpenAiTranscription.php | tests/Integration/media-tools.php; tests/Integration/processing.php; tests/Contract/TranscriptionTest.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-039-007 | Provide: | Partial; see evidence | src/Media/TemporalMedia.php; src/Providers/OpenAiTranscription.php | tests/Integration/media-tools.php; tests/Integration/processing.php; tests/Contract/TranscriptionTest.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-039-008 | speech transcription | Partial; see evidence | src/Media/TemporalMedia.php; src/Providers/OpenAiTranscription.php | tests/Integration/media-tools.php; tests/Integration/processing.php; tests/Contract/TranscriptionTest.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-039-009 | text moderation | Partial; see evidence | src/Media/TemporalMedia.php; src/Providers/OpenAiTranscription.php | tests/Integration/media-tools.php; tests/Integration/processing.php; tests/Contract/TranscriptionTest.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-039-010 | optional audio event classification adapters. | Partial; see evidence | src/Media/TemporalMedia.php; src/Providers/OpenAiTranscription.php | tests/Integration/media-tools.php; tests/Integration/processing.php; tests/Contract/TranscriptionTest.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-040-000 | CONTEXT-AWARE POLICY ENGINE | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-040-001 | The Policy Engine is the heart of the system. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-040-002 | AI scanners provide signals. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-040-003 | The Policy Engine makes decisions. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-040-004 | Rules must be able to use: | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-040-005 | content category | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-040-006 | confidence | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-040-007 | file type | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-040-008 | MIME | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-040-009 | file size | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-040-010 | dimensions | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-040-011 | upload context | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-040-012 | post type | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-040-013 | taxonomy/category | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-040-014 | user | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-040-015 | role | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-040-016 | trust level | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-040-017 | site ID | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-040-018 | network ID | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-040-019 | scanner result | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-040-020 | malware result | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-040-021 | PII findings | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-040-022 | OCR text | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-040-023 | URL/domain findings | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-040-024 | AI-generated score | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-040-025 | deepfake score | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-040-026 | C2PA state | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-040-027 | duplicate state | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-040-028 | custom signals. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-041-000 | RULE BUILDER | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-041-001 | Support: | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-041-002 | AND | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-041-003 | OR | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-041-004 | NOT | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-041-005 | nested groups | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-041-006 | comparison operators | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-041-007 | numeric ranges | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-041-008 | set inclusion | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-041-009 | regex where safe | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-041-010 | domain matches | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-041-011 | roles | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-041-012 | contexts. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-041-013 | Example semantic rule: | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-041-014 | IF | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-041-015 | explicit_nudity &gt;= 0.85 | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-041-016 | AND | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-041-017 | context = avatar | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-041-018 | THEN | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-041-019 | BLOCK | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-041-020 | AND NOTIFY | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-041-021 | Rules need: | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-041-022 | stable IDs | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-041-023 | priority | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-041-024 | enabled state | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-041-025 | description | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-041-026 | version | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-041-027 | test fixtures. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-042-000 | POLICY DECISIONS | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-042-001 | Core decision actions: | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-042-002 | ALLOW | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-042-003 | WARN | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-042-004 | SANITIZE | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-042-005 | REVIEW | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-042-006 | QUARANTINE | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-042-007 | BLOCK | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-042-008 | NOTIFY | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-042-009 | RATE_LIMIT | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-042-010 | DISABLE_UPLOAD_PRIVILEGE | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-042-011 | CREATE_FINGERPRINT | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-042-012 | UNPUBLISH_ASSOCIATED_CONTENT | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-042-013 | ESCALATE. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-042-014 | Dangerous/destructive actions must be explicitly configurable. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-043-000 | CONFIDENCE BANDS | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-043-001 | Do not treat classifiers as binary. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-043-002 | Support category-specific bands. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-043-003 | Example: | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-043-004 | ALLOW band | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-043-005 | REVIEW uncertainty band | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-043-006 | BLOCK band. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-043-007 | Thresholds must be configurable per: | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-043-008 | provider | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-043-009 | content category | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-043-010 | policy | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-043-011 | upload context | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-043-012 | site. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-044-000 | POLICY PRESETS | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-044-001 | Provide professionally designed initial presets: | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-044-002 | Family Friendly | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-044-003 | Corporate | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-044-004 | Community | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-044-005 | Forum | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-044-006 | Marketplace | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-044-007 | Classifieds | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-044-008 | Dating | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-044-009 | Gaming | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-044-010 | News / Editorial | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-044-011 | Education | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-044-012 | Healthcare | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-044-013 | Strict UGC | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-044-014 | Security Only | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-044-015 | Monitor Only | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-044-016 | Custom. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-044-017 | Presets must be editable copies rather than immutable magic. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-045-000 | ROLE-BASED POLICIES | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-045-001 | Policies may differ for: | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-045-002 | Administrator | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-045-003 | Editor | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-045-004 | Author | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-045-005 | Contributor | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-045-006 | Subscriber | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-045-007 | Guest | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-045-008 | custom roles. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-045-009 | Never bypass malware/file-security checks merely because an administrator uploads a file. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-046-000 | USER TRUST LEVELS | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-046-001 | Provide configurable trust tiers: | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-046-002 | new | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-046-003 | normal | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-046-004 | trusted | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-046-005 | restricted. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-046-006 | Trust may modify content-policy behavior. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-046-007 | Security controls remain independent. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-047-000 | POST-TYPE / TAXONOMY POLICIES | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-047-001 | Policies may target: | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-047-002 | posts | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-047-003 | pages | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-047-004 | products | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-047-005 | reviews | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-047-006 | listings | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-047-007 | forum topics | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-047-008 | forum replies | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-047-009 | support tickets | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-047-010 | profiles | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-047-011 | custom post types | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-047-012 | taxonomies | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-047-013 | WooCommerce categories | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-047-014 | other contextual metadata. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-048-000 | MONITOR / SHADOW MODE | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-048-001 | Implement a no-enforcement mode. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-048-002 | Record what WOULD have happened. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-048-003 | Dashboard example: | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-048-004 | 10,000 scanned | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-048-005 | 91 would be blocked | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-048-006 | 183 would be reviewed | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-048-007 | 9,726 would be allowed. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-048-008 | This must support safe policy rollout. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-049-000 | POLICY SIMULATOR | Partial; see evidence | src/Application/FileSimulator.php; src/Application/ScanService.php; assets/src/simulation.tsx | tests/Integration/simulation.php; tests/E2E/admin.spec.ts | API / deployment / module | docs/REST.md | OPEN |
| CF-049-001 | Provide interactive policy testing. | Partial; see evidence | src/Application/FileSimulator.php; src/Application/ScanService.php; assets/src/simulation.tsx | tests/Integration/simulation.php; tests/E2E/admin.spec.ts | API / deployment / module | docs/REST.md | OPEN |
| CF-049-002 | Input a sample file. | Partial; see evidence | src/Application/FileSimulator.php; src/Application/ScanService.php; assets/src/simulation.tsx | tests/Integration/simulation.php; tests/E2E/admin.spec.ts | API / deployment / module | docs/REST.md | OPEN |
| CF-049-003 | Show: | Partial; see evidence | src/Application/FileSimulator.php; src/Application/ScanService.php; assets/src/simulation.tsx | tests/Integration/simulation.php; tests/E2E/admin.spec.ts | API / deployment / module | docs/REST.md | OPEN |
| CF-049-004 | findings | Partial; see evidence | src/Application/FileSimulator.php; src/Application/ScanService.php; assets/src/simulation.tsx | tests/Integration/simulation.php; tests/E2E/admin.spec.ts | API / deployment / module | docs/REST.md | OPEN |
| CF-049-005 | normalized findings | Partial; see evidence | src/Application/FileSimulator.php; src/Application/ScanService.php; assets/src/simulation.tsx | tests/Integration/simulation.php; tests/E2E/admin.spec.ts | API / deployment / module | docs/REST.md | OPEN |
| CF-049-006 | provider results | Partial; see evidence | src/Application/FileSimulator.php; src/Application/ScanService.php; assets/src/simulation.tsx | tests/Integration/simulation.php; tests/E2E/admin.spec.ts | API / deployment / module | docs/REST.md | OPEN |
| CF-049-007 | risk score | Partial; see evidence | src/Application/FileSimulator.php; src/Application/ScanService.php; assets/src/simulation.tsx | tests/Integration/simulation.php; tests/E2E/admin.spec.ts | API / deployment / module | docs/REST.md | OPEN |
| CF-049-008 | decision | Partial; see evidence | src/Application/FileSimulator.php; src/Application/ScanService.php; assets/src/simulation.tsx | tests/Integration/simulation.php; tests/E2E/admin.spec.ts | API / deployment / module | docs/REST.md | OPEN |
| CF-049-009 | rule(s) triggered | Partial; see evidence | src/Application/FileSimulator.php; src/Application/ScanService.php; assets/src/simulation.tsx | tests/Integration/simulation.php; tests/E2E/admin.spec.ts | API / deployment / module | docs/REST.md | OPEN |
| CF-049-010 | latency | Partial; see evidence | src/Application/FileSimulator.php; src/Application/ScanService.php; assets/src/simulation.tsx | tests/Integration/simulation.php; tests/E2E/admin.spec.ts | API / deployment / module | docs/REST.md | OPEN |
| CF-049-011 | provider cost estimate. | Partial; see evidence | src/Application/FileSimulator.php; src/Application/ScanService.php; assets/src/simulation.tsx | tests/Integration/simulation.php; tests/E2E/admin.spec.ts | API / deployment / module | docs/REST.md | OPEN |
| CF-049-012 | Never publish simulator files. | Partial; see evidence | src/Application/FileSimulator.php; src/Application/ScanService.php; assets/src/simulation.tsx | tests/Integration/simulation.php; tests/E2E/admin.spec.ts | API / deployment / module | docs/REST.md | OPEN |
| CF-049-013 | Clean them safely. | Partial; see evidence | src/Application/FileSimulator.php; src/Application/ScanService.php; assets/src/simulation.tsx | tests/Integration/simulation.php; tests/E2E/admin.spec.ts | API / deployment / module | docs/REST.md | OPEN |
| CF-050-000 | HISTORICAL POLICY SIMULATION | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-050-001 | Allow administrators to evaluate a proposed policy against previous scan records where sufficient retained signals exist. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-050-002 | Do not unnecessarily re-send original media. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-050-003 | Show: | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-050-004 | allow delta | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-050-005 | review delta | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-050-006 | block delta | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-050-007 | estimated false-positive impact | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-050-008 | estimated cost. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-051-000 | QUARANTINE | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-051-001 | Quarantine storage must be private. | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-051-002 | Do not place quarantined files at guessable public URLs. | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-051-003 | Support: | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-051-004 | private filesystem | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-051-005 | private object storage | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-051-006 | integration adapter. | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-051-007 | Enforce access using capability-checked authenticated retrieval. | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-051-008 | Automatically expire according to retention policy. | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-052-000 | MODERATION QUEUE | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-052-001 | Create a professional Trust & Safety queue. | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-052-002 | Views: | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-052-003 | Pending | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-052-004 | High Risk | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-052-005 | Quarantined | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-052-006 | Assigned to Me | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-052-007 | Unassigned | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-052-008 | Approved | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-052-009 | Rejected | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-052-010 | Appealed | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-052-011 | Scanner Error | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-052-012 | SLA Risk. | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-052-013 | Each case should expose relevant metadata without visual overload. | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-053-000 | SAFE MODERATOR PREVIEW | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-053-001 | Potentially disturbing content must be hidden by default where configured. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-053-002 | Provide: | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-053-003 | blurred preview | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-053-004 | content warning | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-053-005 | explicit Reveal action | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-053-006 | video autoplay disabled | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-053-007 | audio muted | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-053-008 | keyboard accessible reveal. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-053-009 | Moderator preferences can control behavior. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-053-010 | Never rely solely on color to indicate risk. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-054-000 | MODERATOR ACTIONS | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-054-001 | Support: | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-054-002 | approve | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-054-003 | reject | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-054-004 | delete | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-054-005 | quarantine | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-054-006 | sanitize | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-054-007 | redact | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-054-008 | rescan | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-054-009 | change classification | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-054-010 | override decision | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-054-011 | add fingerprint | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-054-012 | request resubmission | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-054-013 | escalate | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-054-014 | assign | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-054-015 | add note | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-054-016 | suspend upload capability where policy allows. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-054-017 | Require reasons for sensitive overrides where appropriate. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-055-000 | BULK MODERATION | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-055-001 | Bulk: | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-055-002 | approve | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-055-003 | reject | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-055-004 | rescan | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-055-005 | quarantine | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-055-006 | delete | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-055-007 | assign | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-055-008 | export metadata | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-055-009 | change classification. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-055-010 | Protect against accidental destructive operations. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-056-000 | INTERNAL NOTES | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-056-001 | Provide audit-trailed moderator notes. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-056-002 | Notes must have author and timestamp. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-056-003 | Do not expose them publicly. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-057-000 | ASSIGNMENT / ESCALATION / SLA | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-057-001 | Support: | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-057-002 | case owner | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-057-003 | team | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-057-004 | priority | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-057-005 | SLA deadline | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-057-006 | escalation | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-057-007 | queue reassignment. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-057-008 | Avoid building an unnecessarily huge ticketing platform, but provide adequate enterprise workflow primitives. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-058-000 | APPEALS | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-058-001 | Blocked users may be allowed to request manual review. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-058-002 | Track: | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-058-003 | original decision | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-058-004 | appeal reason | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-058-005 | reviewer | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-058-006 | final decision | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-058-007 | timestamps | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-058-008 | decision reason. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-059-000 | USER-FACING ERRORS | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-059-001 | Create configurable messages. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-059-002 | Support: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-059-003 | generic safety messages | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-059-004 | specific policy messages | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-059-005 | custom translation | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-059-006 | per-rule override. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-059-007 | Never expose sensitive provider internals or security detection details that would help attackers evade controls. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-060-000 | AUTOMATIC MEDIA REPAIR | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-060-001 | Provide safe repair operations where possible: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-060-002 | orientation correction | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-060-003 | resize | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-060-004 | recompression | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-060-005 | format conversion | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-060-006 | metadata stripping | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-060-007 | CMYK→RGB | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-060-008 | animation removal | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-060-009 | dimension reduction. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-060-010 | Use WordPress image abstraction where suitable. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-060-011 | Do not modify approved originals unexpectedly. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-061-000 | PROVIDER ABSTRACTION | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-061-001 | Create capability-driven provider interfaces. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-061-002 | Potential adapters include: | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-061-003 | AWS Rekognition | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-061-004 | Google Cloud | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-061-005 | Microsoft/Azure services where relevant | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-061-006 | Sightengine | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-061-007 | Hive | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-061-008 | OpenAI moderation where current capabilities match requirements | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-061-009 | ClamAV | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-061-010 | custom HTTP scanner | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-061-011 | self-hosted scanner | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-061-012 | CDR provider. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-061-013 | Do not require all providers. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-062-000 | NORMALIZED TAXONOMY | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-062-001 | Provider labels must map into stable internal taxonomy IDs. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-062-002 | Example: | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-062-003 | sexual.explicit | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-062-004 | sexual.suggestive | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-062-005 | violence.graphic | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-062-006 | weapon.firearm | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-062-007 | drug.recreational | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-062-008 | hate.symbol | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-062-009 | self_harm.graphic | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-062-010 | pii.phone | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-062-011 | The UI and policies depend on internal taxonomy, not vendor strings. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-063-000 | PROVIDER CAPABILITY REGISTRY | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-063-001 | Every adapter declares capabilities such as: | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-063-002 | image moderation | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-063-003 | video | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-063-004 | OCR | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-063-005 | PII | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-063-006 | QR | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-063-007 | AI detection | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-063-008 | deepfake | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-063-009 | async jobs | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-063-010 | binary upload | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-063-011 | URL upload | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-063-012 | supported formats | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-063-013 | regions | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-063-014 | cost metadata | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-063-015 | batch support. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-063-016 | Routing uses capabilities rather than if provider == ... throughout the codebase. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-064-000 | BYO API KEY | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-064-001 | Support customer-owned credentials. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-064-002 | Secrets must be: | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-064-003 | masked | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-064-004 | capability protected | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-064-005 | excluded from logs | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-064-006 | excluded from support exports. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-064-007 | Support environment/wp-config configuration. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-065-000 | MANAGED CREDITS ARCHITECTURE | Not implemented | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-065-001 | Design a provider gateway abstraction that can later support a commercial SaaS credit system. | Not implemented | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-065-002 | Do not tightly couple core plugin security to licensing infrastructure. | Not implemented | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-066-000 | MULTI-PROVIDER ROUTING | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-066-001 | Optimize accuracy/cost. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-066-002 | Example: | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-066-003 | cheap/local checks | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-066-004 | → cached fingerprint | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-066-005 | → first provider | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-066-006 | → confident? | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-066-007 | YES → decision | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-066-008 | NO → secondary provider | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-066-009 | → consensus/review. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-066-010 | Do not send every upload to every provider by default. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-067-000 | PROVIDER CONSENSUS | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-067-001 | Support configurable ensemble policies. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-067-002 | Example: | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-067-003 | two-provider agreement | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-067-004 | majority vote | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-067-005 | weighted confidence | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-067-006 | uncertainty → human review. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-067-007 | Record individual signals for explainability. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-068-000 | PROVIDER FALLBACK | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-068-001 | Implement: | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-068-002 | timeouts | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-068-003 | fallback order | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-068-004 | circuit breakers | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-068-005 | health state | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-068-006 | exponential backoff with jitter | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-068-007 | rate-limit handling. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-068-008 | Do not retry permanent failures. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-069-000 | FAILURE MODES | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-069-001 | Administrators choose: | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-069-002 | FAIL OPEN | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-069-003 | FAIL CLOSED | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-069-004 | QUARANTINE. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-069-005 | Allow different failure policy by context. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-069-006 | Security/malware may use stricter behavior than low-risk moderation. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-070-000 | PROVIDER COST CONTROL | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-070-001 | Track: | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-070-002 | requests | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-070-003 | tokens/units if relevant | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-070-004 | estimated monetary cost | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-070-005 | cache savings | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-070-006 | provider latency | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-070-007 | failures. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-070-008 | Support: | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-070-009 | monthly request caps | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-070-010 | monthly budget | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-070-011 | warnings | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-070-012 | provider disable threshold | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-070-013 | per-user limits | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-070-014 | per-site limits. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-071-000 | SCAN CACHE | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-071-001 | Cache by safe composite key such as: | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-071-002 | content fingerprint | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-071-003 | scanner family | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-071-004 | provider/model | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-071-005 | taxonomy version | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-071-006 | policy-relevant signal version. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-071-007 | Policy decisions and scan results are different concepts. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-071-008 | A policy change should not require rescanning if retained normalized findings remain valid. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-072-000 | SMART IMAGE PREPARATION | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-072-001 | Perform cheap local processing before remote moderation. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-072-002 | Do not send a 30 MB image if a safe reduced derivative provides equivalent moderation value. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-072-003 | Use: | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-072-004 | temporary copy | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-072-005 | metadata stripping | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-072-006 | safe decode/re-encode where required | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-072-007 | dimension reduction | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-072-008 | provider-supported format conversion. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-072-009 | Never unexpectedly degrade the user's accepted original. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-073-000 | SYNCHRONOUS / ASYNCHRONOUS ROUTING | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-073-001 | Use synchronous processing for small/latency-sensitive cases where feasible. | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-073-002 | Use asynchronous processing for: | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-073-003 | video | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-073-004 | large PDFs | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-073-005 | audio | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-073-006 | archives | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-073-007 | expensive multi-provider checks | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-073-008 | bulk historical scans. | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-073-009 | Async uploads remain private/quarantined until approved. | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-074-000 | BACKGROUND QUEUE | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-074-001 | Implement a robust queue abstraction. | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-074-002 | Requirements: | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-074-003 | persistent jobs | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-074-004 | idempotency keys | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-074-005 | leases/locks | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-074-006 | timeouts | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-074-007 | retries | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-074-008 | dead-letter state | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-074-009 | priority | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-074-010 | concurrency control | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-074-011 | backpressure | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-074-012 | progress. | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-074-013 | Support a standalone database-backed default. | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-074-014 | Allow adapters for established schedulers where appropriate. | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-074-015 | WP-Cron may trigger jobs on ordinary sites but must not be treated as a guaranteed real-time scheduler. | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-074-016 | Provide WP-CLI/system-cron worker execution for high-scale sites. | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-075-000 | EXISTING MEDIA LIBRARY SCANNER | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-075-001 | Scan: | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-075-002 | all media | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-075-003 | selected media | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-075-004 | specific dates | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-075-005 | specific authors | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-075-006 | specific MIME types | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-075-007 | specific post types | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-075-008 | unscanned items | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-075-009 | previously flagged items. | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-075-010 | Use paginated/batched jobs. | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-075-011 | Must resume safely after failure. | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-076-000 | SCHEDULED RESCAN | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-076-001 | Support: | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-076-002 | daily | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-076-003 | weekly | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-076-004 | monthly | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-076-005 | custom schedule. | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-076-006 | Re-evaluate when: | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-076-007 | provider models change | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-076-008 | policies change | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-076-009 | block fingerprints change | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-076-010 | security intelligence changes. | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-076-011 | Avoid unnecessary external rescans. | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-077-000 | POLICY CHANGE RE-EVALUATION | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-077-001 | When policy changes, determine whether existing normalized signals are sufficient. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-077-002 | If yes: | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-077-003 | re-run policy only. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-077-004 | If no: | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-077-005 | schedule rescan. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-077-006 | Explain expected cost before large rescans. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-078-000 | MEDIA LIBRARY INTEGRATION | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-078-001 | Add useful columns/filtering: | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-078-002 | Moderation Status | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-078-003 | Risk | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-078-004 | Security Status | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-078-005 | Policy | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-078-006 | Last Scan. | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-078-007 | Avoid slowing normal Media Library queries. | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-078-008 | Use indexed data and lazy details. | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-079-000 | ATTACHMENT DETAILS | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-079-001 | Display: | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-079-002 | overall state | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-079-003 | risk | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-079-004 | primary findings | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-079-005 | malware status | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-079-006 | privacy status | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-079-007 | metadata action | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-079-008 | policy | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-079-009 | scan date | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-079-010 | provider summary | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-079-011 | review link. | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-079-012 | Do not dump raw provider JSON into ordinary UI. | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-079-013 | Provide advanced technical details separately. | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-080-000 | ANALYTICS | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-080-001 | Dashboard metrics: | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-080-002 | uploads | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-080-003 | scans | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-080-004 | allowed | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-080-005 | sanitized | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-080-006 | reviewed | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-080-007 | quarantined | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-080-008 | blocked | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-080-009 | appeals | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-080-010 | overrides | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-080-011 | violations by type | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-080-012 | risk distribution | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-080-013 | provider usage | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-080-014 | provider cost | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-080-015 | provider latency | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-080-016 | failure rate | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-080-017 | queue depth | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-080-018 | review time | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-080-019 | upload source | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-080-020 | policy | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-080-021 | site | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-080-022 | user trust group. | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-081-000 | FALSE-POSITIVE / FALSE-NEGATIVE ANALYTICS | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-081-001 | Track human disagreement. | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-081-002 | Examples: | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-081-003 | AI BLOCK → HUMAN APPROVE | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-081-004 | AI ALLOW → LATER MODERATOR REMOVE. | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-081-005 | Produce per-category and per-provider metrics. | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-081-006 | Never claim a false-negative rate that cannot be measured from an appropriate labeled sample. | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-082-000 | MODERATION QUALITY PROGRAM | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-082-001 | Create benchmark infrastructure. | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-082-002 | Metrics must include at minimum: | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-082-003 | precision | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-082-004 | recall | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-082-005 | F1 where useful | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-082-006 | false-positive rate | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-082-007 | false-negative rate | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-082-008 | coverage | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-082-009 | uncertainty rate | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-082-010 | human escalation rate. | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-082-011 | Evaluate per category. | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-082-012 | Do NOT use one generic “accuracy” number. | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-082-013 | For automatic hard-blocking, prioritize very high precision. | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-082-014 | Initial design target: | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-082-015 | critical hard-block categories should aim for &gt;=99.5% precision on a representative validated benchmark before broad automatic enforcement. | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-082-016 | If the benchmark cannot establish that level: | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-082-017 | send uncertain cases to REVIEW rather than pretending certainty. | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-082-018 | For critical content, configure review bands to maximize recall. | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-082-019 | These are engineering targets, not marketing claims. | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-083-000 | CALIBRATION | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-083-001 | Confidence values from different providers are not automatically comparable. | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-083-002 | Build per-provider/per-category calibration support. | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-083-003 | Persist calibration version. | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-083-004 | Support threshold tuning through benchmark results. | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-084-000 | HUMAN FEEDBACK | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-084-001 | Store human overrides as evaluation evidence. | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-084-002 | Do NOT automatically train or modify classifiers from user content. | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-084-003 | Feedback may inform: | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-084-004 | threshold recommendations | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-084-005 | policy tuning | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-084-006 | provider evaluation. | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-085-000 | MODEL DRIFT | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-085-001 | Track changes by: | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-085-002 | provider | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-085-003 | model version | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-085-004 | category | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-085-005 | time. | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-085-006 | Detect meaningful movement in: | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-085-007 | block rate | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-085-008 | review rate | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-085-009 | human disagreement | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-085-010 | confidence distributions. | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-085-011 | Alert administrators when appropriate. | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-086-000 | MODERATOR ANALYTICS | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-086-001 | Enterprise metrics: | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-086-002 | review throughput | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-086-003 | median review duration | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-086-004 | queue backlog | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-086-005 | SLA violations | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-086-006 | override rate | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-086-007 | escalation rate. | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-086-008 | Do not encourage harmful worker surveillance; focus metrics on operational queue health. | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-087-000 | ABUSE ANALYTICS | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-087-001 | Detect patterns such as: | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-087-002 | repeated prohibited uploads | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-087-003 | duplicate prohibited content | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-087-004 | new-account bursts | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-087-005 | high rejection rate | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-087-006 | API-cost abuse | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-087-007 | provider probing | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-087-008 | repeated borderline content. | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-087-009 | Policies may rate-limit offenders. | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-088-000 | ANOMALY ALERTS | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-088-001 | Example: | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-088-002 | sexual-content violation volume increased 800% within 30 minutes. | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-088-003 | Use robust thresholds and avoid notification spam. | Not implemented | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-089-000 | NOTIFICATIONS | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-089-001 | Support: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-089-002 | WordPress admin | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-089-003 | email | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-089-004 | webhook | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-089-005 | Slack-compatible webhook | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-089-006 | Mattermost-compatible webhook | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-089-007 | Discord-compatible webhook. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-089-008 | Events: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-089-009 | high-risk content | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-089-010 | malware | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-089-011 | provider outage | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-089-012 | queue backlog | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-089-013 | budget threshold | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-089-014 | repeated offender | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-089-015 | SLA breach. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-090-000 | WEBHOOKS | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-090-001 | Provide signed outgoing webhooks. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-090-002 | Events should be versioned. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-090-003 | Implement retries and idempotent event IDs. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-090-004 | Do not send raw prohibited media in webhook payloads. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-091-000 | REST API | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-091-001 | Provide versioned REST endpoints for appropriate operations: | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-091-002 | policies | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-091-003 | queue | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-091-004 | scan results | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-091-005 | analytics | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-091-006 | health | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-091-007 | provider status | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-091-008 | approve | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-091-009 | reject | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-091-010 | rescan | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-091-011 | simulation. | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-091-012 | Use controller classes. | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-091-013 | Every endpoint requires appropriate permission_callback. | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-091-014 | Validate and sanitize request arguments. | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-091-015 | Do not use nonces as authorization. | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-092-000 | WP-CLI | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-092-001 | Implement useful commands: | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-092-002 | scan attachment | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-092-003 | scan library | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-092-004 | rescan policy | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-092-005 | worker run | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-092-006 | queue status | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-092-007 | provider test | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-092-008 | health | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-092-009 | policy export/import | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-092-010 | database status | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-092-011 | diagnostics. | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-092-012 | Support script-friendly exit codes. | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-093-000 | DEVELOPER EXTENSIBILITY | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-093-001 | Provide documented actions/filters/interfaces for: | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-093-002 | scanner registration | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-093-003 | provider registration | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-093-004 | taxonomy extension | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-093-005 | context resolution | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-093-006 | policy signals | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-093-007 | decision modification where safe | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-093-008 | notifications | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-093-009 | quarantine backends | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-093-010 | custom actions. | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-093-011 | Keep hooks stable and versioned. | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-094-000 | CUSTOM MODERATION RULES | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-094-001 | Allow businesses to define custom forbidden signals such as: | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-094-002 | competitor brand names | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-094-003 | Telegram usernames | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-094-004 | telephone numbers | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-094-005 | specific domains | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-094-006 | custom OCR phrases | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-094-007 | logo presence | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-094-008 | custom provider result. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-095-000 | WORDPRESS ECOSYSTEM INTEGRATIONS | Not implemented | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-095-001 | Design explicit adapters/tests where practical for major systems including: | Not implemented | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-095-002 | BuddyPress | Not implemented | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-095-003 | BuddyBoss | Not implemented | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-095-004 | bbPress | Not implemented | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-095-005 | PeepSo | Not implemented | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-095-006 | WooCommerce | Not implemented | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-095-007 | Dokan | Not implemented | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-095-008 | WCFM | Not implemented | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-095-009 | Gravity Forms | Not implemented | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-095-010 | WPForms | Not implemented | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-095-011 | Contact Form 7 | Not implemented | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-095-012 | Formidable Forms | Not implemented | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-095-013 | Fluent Forms | Not implemented | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-095-014 | Ninja Forms | Not implemented | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-095-015 | Elementor Forms | Not implemented | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-095-016 | ACF | Not implemented | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-095-017 | Meta Box | Not implemented | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-095-018 | popular media-offload solutions | Not implemented | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-095-019 | remote import flows. | Not implemented | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-095-020 | Do not activate heavy compatibility code unless corresponding plugins exist. | Not implemented | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-096-000 | MULTISITE | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-096-001 | Support: | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-096-002 | network defaults | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-096-003 | network-enforced policies | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-096-004 | site-specific policies | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-096-005 | network analytics | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-096-006 | per-site provider credentials where allowed | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-096-007 | centralized audit | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-096-008 | site isolation. | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-096-009 | Prevent cross-blog data leakage. | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-097-000 | AGENCY / CENTRAL MANAGEMENT | Not implemented | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-097-001 | Architect optional central-control capabilities: | Not implemented | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-097-002 | multiple sites | Not implemented | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-097-003 | health state | Not implemented | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-097-004 | pending moderation counts | Not implemented | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-097-005 | budget state | Not implemented | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-097-006 | provider failures | Not implemented | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-097-007 | policy distribution | Not implemented | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-097-008 | configuration templates. | Not implemented | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-097-009 | Do not make basic standalone installations depend on cloud control. | Not implemented | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-098-000 | AUDIT LOG | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-098-001 | Audit important operations: | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-098-002 | upload receipt | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-098-003 | scanner invocation | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-098-004 | findings | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-098-005 | decision | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-098-006 | rule trigger | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-098-007 | quarantine | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-098-008 | publication | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-098-009 | human override | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-098-010 | assignment | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-098-011 | policy modification | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-098-012 | provider credential modification | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-098-013 | settings change | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-098-014 | appeal decision. | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-098-015 | Include: | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-098-016 | actor | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-098-017 | timestamp | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-098-018 | object | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-098-019 | event | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-098-020 | metadata | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-098-021 | policy version. | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-098-022 | Protect audit integrity. | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-099-000 | POLICY VERSIONING | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-099-001 | Policies are versioned immutable snapshots after activation. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-099-002 | Editing creates a new version. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-099-003 | Every decision records the version used. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-099-004 | Provide compare/diff. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-100-000 | PROVIDER / MODEL VERSION TRACKING | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-100-001 | Record provider and model/schema version wherever available. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-100-002 | Avoid caching incompatible old results indefinitely. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-101-000 | PRIVACY CONTROLS | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-101-001 | Allow control of data sent externally: | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-101-002 | original file | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-101-003 | resized derivative | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-101-004 | metadata-stripped derivative | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-101-005 | filename | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-101-006 | user identifier | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-101-007 | site identifier. | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-101-008 | Default to data minimization. | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-101-009 | Never transmit information unrelated to scanning. | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-102-000 | RETENTION | Partial; see evidence | src/Privacy/RecordLifecycle.php; src/WordPress/PrivacyTools.php; src/Application/Retention.php | tests/Integration/privacy.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-102-001 | Configurable retention per data class: | Partial; see evidence | src/Privacy/RecordLifecycle.php; src/WordPress/PrivacyTools.php; src/Application/Retention.php | tests/Integration/privacy.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-102-002 | safe scan metadata | Partial; see evidence | src/Privacy/RecordLifecycle.php; src/WordPress/PrivacyTools.php; src/Application/Retention.php | tests/Integration/privacy.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-102-003 | blocked scan metadata | Partial; see evidence | src/Privacy/RecordLifecycle.php; src/WordPress/PrivacyTools.php; src/Application/Retention.php | tests/Integration/privacy.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-102-004 | OCR text | Partial; see evidence | src/Privacy/RecordLifecycle.php; src/WordPress/PrivacyTools.php; src/Application/Retention.php | tests/Integration/privacy.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-102-005 | quarantine files | Partial; see evidence | src/Privacy/RecordLifecycle.php; src/WordPress/PrivacyTools.php; src/Application/Retention.php | tests/Integration/privacy.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-102-006 | audit events | Partial; see evidence | src/Privacy/RecordLifecycle.php; src/WordPress/PrivacyTools.php; src/Application/Retention.php | tests/Integration/privacy.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-102-007 | analytics | Partial; see evidence | src/Privacy/RecordLifecycle.php; src/WordPress/PrivacyTools.php; src/Application/Retention.php | tests/Integration/privacy.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-102-008 | provider raw responses. | Partial; see evidence | src/Privacy/RecordLifecycle.php; src/WordPress/PrivacyTools.php; src/Application/Retention.php | tests/Integration/privacy.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-102-009 | Default to not retaining prohibited media longer than operationally necessary. | Partial; see evidence | src/Privacy/RecordLifecycle.php; src/WordPress/PrivacyTools.php; src/Application/Retention.php | tests/Integration/privacy.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-102-010 | Implement scheduled cleanup. | Partial; see evidence | src/Privacy/RecordLifecycle.php; src/WordPress/PrivacyTools.php; src/Application/Retention.php | tests/Integration/privacy.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-103-000 | WORDPRESS PRIVACY TOOLS | Partial; see evidence | src/Privacy/RecordLifecycle.php; src/WordPress/PrivacyTools.php; src/Application/Retention.php | tests/Integration/privacy.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-103-001 | Integrate with WordPress privacy export/erasure mechanisms where applicable. | Partial; see evidence | src/Privacy/RecordLifecycle.php; src/WordPress/PrivacyTools.php; src/Application/Retention.php | tests/Integration/privacy.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-103-002 | Clearly distinguish audit/security retention obligations. | Partial; see evidence | src/Privacy/RecordLifecycle.php; src/WordPress/PrivacyTools.php; src/Application/Retention.php | tests/Integration/privacy.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-104-000 | DATA RESIDENCY | Not implemented | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-104-001 | Represent supported processing regions in provider capability metadata. | Not implemented | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-104-002 | Allow enterprise policies requiring specific region. | Not implemented | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-104-003 | Do not claim residency guarantees unsupported by a provider. | Not implemented | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-105-000 | PRIVACY DISCLOSURE | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-105-001 | Provide administrator guidance for privacy-policy disclosures regarding third-party scanning. | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-105-002 | Generate a suggested disclosure. | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-105-003 | Do not present generated text as legal advice. | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-106-000 | SECRET MANAGEMENT | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-106-001 | Prefer environment / wp-config.php secrets for advanced production deployments. | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-106-002 | If database storage is supported: | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-106-003 | protect access | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-106-004 | mask output | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-106-005 | avoid logs | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-106-006 | use defensible encryption/key derivation | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-106-007 | document limitations. | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-106-008 | Never place credentials in JavaScript. | Partial; see evidence | src/Privacy | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-107-000 | RBAC | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-107-001 | Create granular capabilities such as: | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-107-002 | manage_content_firewall | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-107-003 | manage_content_firewall_policies | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-107-004 | manage_content_firewall_providers | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-107-005 | review_content_firewall_queue | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-107-006 | reveal_sensitive_content | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-107-007 | view_content_firewall_audit | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-107-008 | view_content_firewall_analytics | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-107-009 | manage_content_firewall_integrations. | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-107-010 | Do not check hardcoded role names when a capability check is appropriate. | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-108-000 | RATE LIMITING | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-108-001 | Support limits by: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-108-002 | user | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-108-003 | IP where appropriate | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-108-004 | role | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-108-005 | site | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-108-006 | API client | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-108-007 | time window. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-108-008 | Use scalable storage. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-108-009 | Protect external provider budgets. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-109-000 | COST-ABUSE PROTECTION | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-109-001 | A malicious uploader must not be able to consume unlimited paid API quota. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-109-002 | Use: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-109-003 | preflight checks | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-109-004 | authentication | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-109-005 | rate limits | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-109-006 | per-user quota | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-109-007 | file limits | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-109-008 | duplicate cache | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-109-009 | cheap-first processing | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-109-010 | provider budgets. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-110-000 | RESOURCE-EXHAUSTION PROTECTION | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-110-001 | Enforce limits BEFORE expensive processing: | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-110-002 | input bytes | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-110-003 | image pixels | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-110-004 | PDF pages | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-110-005 | video duration | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-110-006 | archive uncompressed bytes | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-110-007 | archive nesting | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-110-008 | SVG nodes | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-110-009 | OCR size | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-110-010 | document object counts where practical. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-110-011 | Fail safely. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-111-000 | SYSTEM HEALTH | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-111-001 | Add Site Health integration and dedicated dashboard. | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-111-002 | Show: | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-111-003 | database status | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-111-004 | queue health | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-111-005 | worker age | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-111-006 | provider health | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-111-007 | malware scanner | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-111-008 | quarantine | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-111-009 | cron | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-111-010 | filesystem | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-111-011 | ImageMagick/GD | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-111-012 | temporary directory | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-111-013 | REST availability | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-111-014 | webhook health | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-111-015 | current latency | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-111-016 | error rate. | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-112-000 | SELF-DIAGNOSTICS | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-112-001 | Provide safe buttons/tools for: | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-112-002 | provider test | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-112-003 | malware scanner test | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-112-004 | quarantine test | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-112-005 | queue test | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-112-006 | webhook test | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-112-007 | image-processing test | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-112-008 | database integrity test. | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-112-009 | Tests must not leak secrets. | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-113-000 | DIAGNOSTIC EXPORT | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-113-001 | Generate support bundle containing: | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-113-002 | WordPress version | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-113-003 | PHP version | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-113-004 | database type/version | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-113-005 | plugin version | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-113-006 | enabled modules | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-113-007 | provider names | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-113-008 | queue metrics | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-113-009 | feature flags | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-113-010 | relevant non-sensitive configuration | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-113-011 | recent sanitized errors. | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-113-012 | Exclude: | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-113-013 | credentials | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-113-014 | PII | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-113-015 | OCR text | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-113-016 | raw uploads | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-113-017 | prohibited images. | Partial; see evidence | src/WordPress | tests/Integration/run.php | Admin console | docs/COMPATIBILITY.md | OPEN |
| CF-114-000 | CONFIG IMPORT / EXPORT | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | Admin console | docs/MODERATION-QUALITY.md | OPEN |
| CF-114-001 | Allow policies/configuration to be exported as versioned JSON. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | Admin console | docs/MODERATION-QUALITY.md | OPEN |
| CF-114-002 | Validate schemas. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | Admin console | docs/MODERATION-QUALITY.md | OPEN |
| CF-114-003 | Do not import secrets by default. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | Admin console | docs/MODERATION-QUALITY.md | OPEN |
| CF-115-000 | ENVIRONMENT AWARENESS | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-115-001 | Support: | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-115-002 | development | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-115-003 | staging | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-115-004 | production. | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-115-005 | Example: | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-115-006 | development → provider mocks | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-115-007 | staging → monitor mode | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-115-008 | production → enforcement. | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-115-009 | Do not infer environment solely from domain name. | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-115-010 | Use WordPress environment mechanisms/configuration. | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-116-000 | CHILD-SAFETY INTEGRATIONS | Not implemented | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-116-001 | Treat this as a specialized enterprise integration domain. | Not implemented | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-116-002 | Do not claim ordinary nudity classifiers can legally determine CSAM. | Not implemented | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-116-003 | Allow adapters to approved/specialized services and hash systems when lawfully available. | Not implemented | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-116-004 | Use: | Not implemented | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-116-005 | restricted moderator capability | Not implemented | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-116-006 | strict audit | Not implemented | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-116-007 | special retention | Not implemented | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-116-008 | special escalation. | Not implemented | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-116-009 | Never bundle illegal material as test fixtures. | Not implemented | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-116-010 | Never create unsafe datasets. | Not implemented | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-117-000 | COPYRIGHT / KNOWN-CONTENT FINGERPRINTS | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-117-001 | Allow organization-maintained: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-117-002 | exact hash lists | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-117-003 | perceptual hash lists | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-117-004 | known prohibited content lists. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-117-005 | Respect licensing/legal requirements of external databases. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-118-000 | LOGO / BRAND DETECTION | Not implemented | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-118-001 | Provide provider abstraction for: | Not implemented | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-118-002 | logos | Not implemented | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-118-003 | brands | Not implemented | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-118-004 | competitors | Not implemented | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-118-005 | organization marks. | Not implemented | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-118-006 | Policies may review/block. | Not implemented | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-119-000 | WATERMARK / CONTACT DETECTION | Not implemented | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-119-001 | Combine OCR + image analysis to find: | Not implemented | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-119-002 | website names | Not implemented | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-119-003 | telephone numbers | Not implemented | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-119-004 | social handles | Not implemented | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-119-005 | WhatsApp/Telegram identifiers | Not implemented | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-119-006 | competitor marks | Not implemented | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-119-007 | watermarks. | Not implemented | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-119-008 | Useful for marketplaces/classifieds. | Not implemented | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-120-000 | CORRECTIVE UX | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-120-001 | Where policy allows, prefer helpful remediation over unexplained rejection. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-120-002 | Example: | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-120-003 | “We detected a telephone number in this listing image.” | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-120-004 | Actions: | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-120-005 | Replace image | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-120-006 | Automatically redact | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-120-007 | Request review. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-121-000 | FRONTEND SCAN STATUS | Partial; see evidence | src/Application/HeadlessUpload.php; src/REST/Controller.php | tests/Integration/headless.php; tests/E2E/admin.spec.ts | API / deployment / module | docs/REST.md | OPEN |
| CF-121-001 | Expose accessible upload progress/status: | Partial; see evidence | src/Application/HeadlessUpload.php; src/REST/Controller.php | tests/Integration/headless.php; tests/E2E/admin.spec.ts | API / deployment / module | docs/REST.md | OPEN |
| CF-121-002 | Uploading | Partial; see evidence | src/Application/HeadlessUpload.php; src/REST/Controller.php | tests/Integration/headless.php; tests/E2E/admin.spec.ts | API / deployment / module | docs/REST.md | OPEN |
| CF-121-003 | Security check | Partial; see evidence | src/Application/HeadlessUpload.php; src/REST/Controller.php | tests/Integration/headless.php; tests/E2E/admin.spec.ts | API / deployment / module | docs/REST.md | OPEN |
| CF-121-004 | Content check | Partial; see evidence | src/Application/HeadlessUpload.php; src/REST/Controller.php | tests/Integration/headless.php; tests/E2E/admin.spec.ts | API / deployment / module | docs/REST.md | OPEN |
| CF-121-005 | Pending review | Partial; see evidence | src/Application/HeadlessUpload.php; src/REST/Controller.php | tests/Integration/headless.php; tests/E2E/admin.spec.ts | API / deployment / module | docs/REST.md | OPEN |
| CF-121-006 | Approved | Partial; see evidence | src/Application/HeadlessUpload.php; src/REST/Controller.php | tests/Integration/headless.php; tests/E2E/admin.spec.ts | API / deployment / module | docs/REST.md | OPEN |
| CF-121-007 | Rejected. | Partial; see evidence | src/Application/HeadlessUpload.php; src/REST/Controller.php | tests/Integration/headless.php; tests/E2E/admin.spec.ts | API / deployment / module | docs/REST.md | OPEN |
| CF-121-008 | Do not expose detailed bypass-helping signals to untrusted uploaders. | Partial; see evidence | src/Application/HeadlessUpload.php; src/REST/Controller.php | tests/Integration/headless.php; tests/E2E/admin.spec.ts | API / deployment / module | docs/REST.md | OPEN |
| CF-122-000 | ATTACHMENT STATUS DATA | Partial; see evidence | src/Application/HeadlessUpload.php; src/REST/Controller.php | tests/Integration/headless.php; tests/E2E/admin.spec.ts | API / deployment / module | docs/REST.md | OPEN |
| CF-122-001 | Expose a stable summarized state for integrations. | Partial; see evidence | src/Application/HeadlessUpload.php; src/REST/Controller.php | tests/Integration/headless.php; tests/E2E/admin.spec.ts | API / deployment / module | docs/REST.md | OPEN |
| CF-122-002 | Potential fields: | Partial; see evidence | src/Application/HeadlessUpload.php; src/REST/Controller.php | tests/Integration/headless.php; tests/E2E/admin.spec.ts | API / deployment / module | docs/REST.md | OPEN |
| CF-122-003 | moderation state | Partial; see evidence | src/Application/HeadlessUpload.php; src/REST/Controller.php | tests/Integration/headless.php; tests/E2E/admin.spec.ts | API / deployment / module | docs/REST.md | OPEN |
| CF-122-004 | security state | Partial; see evidence | src/Application/HeadlessUpload.php; src/REST/Controller.php | tests/Integration/headless.php; tests/E2E/admin.spec.ts | API / deployment / module | docs/REST.md | OPEN |
| CF-122-005 | risk level | Partial; see evidence | src/Application/HeadlessUpload.php; src/REST/Controller.php | tests/Integration/headless.php; tests/E2E/admin.spec.ts | API / deployment / module | docs/REST.md | OPEN |
| CF-122-006 | policy ID/version | Partial; see evidence | src/Application/HeadlessUpload.php; src/REST/Controller.php | tests/Integration/headless.php; tests/E2E/admin.spec.ts | API / deployment / module | docs/REST.md | OPEN |
| CF-122-007 | scan timestamp. | Partial; see evidence | src/Application/HeadlessUpload.php; src/REST/Controller.php | tests/Integration/headless.php; tests/E2E/admin.spec.ts | API / deployment / module | docs/REST.md | OPEN |
| CF-122-008 | Avoid storing huge raw results in attachment postmeta. | Partial; see evidence | src/Application/HeadlessUpload.php; src/REST/Controller.php | tests/Integration/headless.php; tests/E2E/admin.spec.ts | API / deployment / module | docs/REST.md | OPEN |
| CF-123-000 | PUBLICATION GATE | Partial; see evidence | src/WordPress/PublicationGate.php | tests/Integration/publication-gate.php; tests/Integration/hardening.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-123-001 | If content references unapproved attachments, optionally prevent publication until scan completion. | Partial; see evidence | src/WordPress/PublicationGate.php | tests/Integration/publication-gate.php; tests/Integration/hardening.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-123-002 | Return understandable errors. | Partial; see evidence | src/WordPress/PublicationGate.php | tests/Integration/publication-gate.php; tests/Integration/hardening.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-123-003 | Handle autosaves safely. | Partial; see evidence | src/WordPress/PublicationGate.php | tests/Integration/publication-gate.php; tests/Integration/hardening.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-124-000 | LATER RECLASSIFICATION | Not implemented | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-124-001 | If future rescanning changes an attachment from approved to prohibited: | Not implemented | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-124-002 | configurable responses: | Not implemented | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-124-003 | notify only | Not implemented | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-124-004 | quarantine media | Not implemented | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-124-005 | replace media | Not implemented | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-124-006 | unpublish related content | Not implemented | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-124-007 | escalate. | Not implemented | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-124-008 | Never silently remove large amounts of public content without explicit policy. | Not implemented | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-125-000 | ALLOWLISTS / BLOCKLISTS | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-125-001 | Support: | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-125-002 | hash allowlist | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-125-003 | hash blocklist | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-125-004 | domain allowlist | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-125-005 | domain blocklist | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-125-006 | user moderation exemptions | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-125-007 | taxonomy exceptions | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-125-008 | MIME allowlist. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-125-009 | Security/malware scanning must not be disabled merely because an uploader is trusted. | Partial; see evidence | src/Policy | tests/Unit/PolicyTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-126-000 | COMPOSITE RISK SCORE | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-126-001 | Provide an optional normalized risk score. | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-126-002 | The score may include: | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-126-003 | moderation confidence | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-126-004 | security findings | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-126-005 | PII | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-126-006 | user trust | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-126-007 | duplicate risk | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-126-008 | QR/URL findings | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-126-009 | provider disagreement. | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-126-010 | Do not hide actual rule decisions behind one opaque number. | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-126-011 | Rules remain explainable. | Partial; see evidence | src/Analytics | tests/Unit/PrivacyAndQualityTest.php | API / deployment / module | docs/MODERATION-QUALITY.md | OPEN |
| CF-127-000 | EXPLAINABILITY | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-127-001 | Every moderator/admin decision view must explain: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-127-002 | decision | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-127-003 | reason(s) | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-127-004 | detected category | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-127-005 | confidence | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-127-006 | rule | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-127-007 | policy/version | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-127-008 | provider/model | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-127-009 | security findings | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-127-010 | relevant contextual factors. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-127-011 | Example: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-127-012 | BLOCKED | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-127-013 | Explicit sexual content: 0.94 | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-127-014 | Rule: SEXUAL-AVATAR-001 | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-127-015 | Policy: Community v7 | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-127-016 | Provider: ExampleProvider / model X | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-127-017 | Timestamp: ... | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-128-000 | DATABASE DESIGN | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-128-001 | Design dedicated tables for high-volume operational data rather than overusing postmeta/options. | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-128-002 | Expected logical datasets include: | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-128-003 | scans | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-128-004 | findings | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-128-005 | decisions | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-128-006 | policies | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-128-007 | policy versions | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-128-008 | rules | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-128-009 | queue jobs | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-128-010 | quarantine records | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-128-011 | moderation cases | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-128-012 | appeals | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-128-013 | audit events | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-128-014 | provider usage | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-128-015 | fingerprints | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-128-016 | notifications/events | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-128-017 | accuracy/evaluation data. | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-128-018 | Use WordPress table prefix. | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-128-019 | Support multisite appropriately. | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-128-020 | Use deliberate indexes for: | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-128-021 | attachment/object | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-128-022 | status | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-128-023 | created_at | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-128-024 | policy | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-128-025 | user | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-128-026 | site | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-128-027 | queue due time | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-128-028 | provider | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-128-029 | hash | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-128-030 | risk | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-128-031 | assignment. | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-128-032 | Use schema versioning and safe migrations. | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-128-033 | Avoid table scans in normal admin screens. | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-129-000 | DATABASE PERFORMANCE RULES | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-129-001 | Before merging each major query: | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-129-002 | inspect query plan when possible. | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-129-003 | Do not use: | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-129-004 | unbounded result sets | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-129-005 | SELECT * unnecessarily | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-129-006 | N+1 admin queries | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-129-007 | huge IN clauses without consideration | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-129-008 | unindexed queue polling. | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-129-009 | Use keyset pagination where helpful for very large tables. | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-129-010 | Do not load thousands of records merely to display summary counts. | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-130-000 | PERFORMANCE BUDGET | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-130-001 | Create benchmarkable budgets. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-130-002 | Suggested starting targets, subject to real measurement: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-130-003 | Local lightweight upload preflight: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-130-004 | p95 &lt; 50 ms for ordinary files. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-130-005 | Plugin routing/decision overhead excluding external services: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-130-006 | p95 &lt; 100 ms. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-130-007 | Synchronous ordinary image moderation: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-130-008 | target p95 additional user-visible latency &lt;= 1.5 seconds where provider/network permits. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-130-009 | Asynchronous upload/quarantine acknowledgement: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-130-010 | target p95 &lt; 250 ms after upload storage completes. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-130-011 | Common admin REST reads: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-130-012 | p95 server processing &lt; 300 ms. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-130-013 | Large-table filtered queue query: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-130-014 | target &lt; 500 ms at 1M+ operational records with realistic indexes. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-130-015 | Do not falsify compliance if external network conditions make a target impossible. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-130-016 | Report separately: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-130-017 | plugin CPU time | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-130-018 | provider latency | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-130-019 | network latency | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-130-020 | queue delay. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-131-000 | MEMORY PERFORMANCE | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-131-001 | Before decoding an image, estimate memory/resource impact from dimensions and format. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-131-002 | Reject dangerous pixel counts before expensive operations. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-131-003 | Stream hashing and file copies. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-131-004 | Do not load entire large files into PHP strings unless required. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-131-005 | Clean temporary files deterministically. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-131-006 | Test low-memory hosting environments. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-132-000 | COST-EFFICIENT SCAN PIPELINE | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-132-001 | Recommended conceptual ordering: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-132-002 | 1. request authorization/rate limit | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-132-003 | 2. filename/basic metadata | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-132-004 | 3. file size/resource bounds | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-132-005 | 4. true file type | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-132-006 | 5. hash/cache lookup | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-132-007 | 6. local security preflight | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-132-008 | 7. inexpensive local rules | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-132-009 | 8. safe derivative generation | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-132-010 | 9. primary moderation provider | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-132-011 | 10. uncertainty evaluation | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-132-012 | 11. secondary provider only if required | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-132-013 | 12. policy engine | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-132-014 | 13. sanitize/quarantine/publish | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-132-015 | 14. audit/metrics. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-132-016 | Short-circuit safely. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-133-000 | RELIABILITY ENGINEERING | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-133-001 | Implement: | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-133-002 | provider timeouts | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-133-003 | connection timeouts | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-133-004 | retry classification | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-133-005 | exponential backoff | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-133-006 | jitter | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-133-007 | circuit breakers | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-133-008 | bulkheads | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-133-009 | idempotency | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-133-010 | job locks | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-133-011 | dead-letter jobs | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-133-012 | health checks. | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-133-013 | A provider outage must not take down WordPress. | Partial; see evidence | src/Queue | tests/Integration/run.php | API / deployment / module | docs/OPERATIONS.md | OPEN |
| CF-134-000 | ADMIN UI INFORMATION ARCHITECTURE | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-134-001 | Build a high-quality admin product. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-134-002 | Primary navigation: | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-134-003 | Dashboard | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-134-004 | Moderation Queue | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-134-005 | Policies | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-134-006 | Media Scanner | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-134-007 | Providers | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-134-008 | Analytics | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-134-009 | Audit Log | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-134-010 | Integrations | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-134-011 | System Health | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-134-012 | Settings | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-134-013 | Developer Tools. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-134-014 | Avoid dozens of unrelated WordPress submenu screens. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-135-000 | ONBOARDING UX | Partial; see evidence | src/Application/Onboarding.php; assets/src/workflows.tsx | tests/Integration/workflows.php; tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-135-001 | First-run wizard: | Partial; see evidence | src/Application/Onboarding.php; assets/src/workflows.tsx | tests/Integration/workflows.php; tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-135-002 | Welcome | Partial; see evidence | src/Application/Onboarding.php; assets/src/workflows.tsx | tests/Integration/workflows.php; tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-135-003 | Choose use case/preset | Partial; see evidence | src/Application/Onboarding.php; assets/src/workflows.tsx | tests/Integration/workflows.php; tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-135-004 | Choose providers | Partial; see evidence | src/Application/Onboarding.php; assets/src/workflows.tsx | tests/Integration/workflows.php; tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-135-005 | Connect/test provider | Partial; see evidence | src/Application/Onboarding.php; assets/src/workflows.tsx | tests/Integration/workflows.php; tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-135-006 | Choose failure mode | Partial; see evidence | src/Application/Onboarding.php; assets/src/workflows.tsx | tests/Integration/workflows.php; tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-135-007 | Choose privacy settings | Partial; see evidence | src/Application/Onboarding.php; assets/src/workflows.tsx | tests/Integration/workflows.php; tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-135-008 | Choose enforcement mode | Partial; see evidence | src/Application/Onboarding.php; assets/src/workflows.tsx | tests/Integration/workflows.php; tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-135-009 | Run sample test | Partial; see evidence | src/Application/Onboarding.php; assets/src/workflows.tsx | tests/Integration/workflows.php; tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-135-010 | Optional existing-library scan | Partial; see evidence | src/Application/Onboarding.php; assets/src/workflows.tsx | tests/Integration/workflows.php; tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-135-011 | Review configuration | Partial; see evidence | src/Application/Onboarding.php; assets/src/workflows.tsx | tests/Integration/workflows.php; tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-135-012 | Activate. | Partial; see evidence | src/Application/Onboarding.php; assets/src/workflows.tsx | tests/Integration/workflows.php; tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-135-013 | Allow skipping and resuming. | Partial; see evidence | src/Application/Onboarding.php; assets/src/workflows.tsx | tests/Integration/workflows.php; tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-136-000 | DASHBOARD UX | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-136-001 | Show meaningful operational information, not decorative charts. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-136-002 | Recommended areas: | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-136-003 | system health | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-136-004 | recent violations | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-136-005 | moderation state | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-136-006 | queue backlog | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-136-007 | provider health | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-136-008 | provider spend | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-136-009 | accuracy alerts | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-136-010 | top categories | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-136-011 | recent critical events. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-136-012 | Use progressive disclosure. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-137-000 | POLICY BUILDER UX | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-137-001 | The rule builder is mission-critical. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-137-002 | Requirements: | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-137-003 | human-readable conditions | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-137-004 | nested AND/OR groups | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-137-005 | clear action | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-137-006 | inline validation | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-137-007 | rule priority | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-137-008 | conflict warnings | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-137-009 | test rule | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-137-010 | simulate rule | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-137-011 | duplicate rule | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-137-012 | disable rule | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-137-013 | version changes | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-137-014 | change summary. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-137-015 | Users should not need programming knowledge. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-138-000 | MODERATION QUEUE UX | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-138-001 | Optimize for repeated professional work. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-138-002 | Requirements: | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-138-003 | fast keyboard navigation | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-138-004 | saved filters | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-138-005 | bulk selection | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-138-006 | assignment | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-138-007 | safe previews | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-138-008 | clear confidence | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-138-009 | rule reason | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-138-010 | context | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-138-011 | previous uploader behavior where authorized | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-138-012 | one-click approve/reject | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-138-013 | required rationale where configured | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-138-014 | next-item navigation. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-139-000 | ADMIN UI TECHNOLOGY | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-139-001 | Prefer WordPress-native UI packages and components where they provide good functionality. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-139-002 | Use WordPress-supplied React where appropriate rather than bundling redundant React runtimes. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-139-003 | Use TypeScript for substantial admin application code. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-139-004 | Use code splitting. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-139-005 | Do not enqueue admin assets on unrelated WordPress pages. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-139-006 | Minimize JavaScript bundle size. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-140-000 | UI DESIGN QUALITY | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-140-001 | The interface must feel like a mature security/SaaS product integrated into WordPress. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-140-002 | Prioritize: | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-140-003 | clarity | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-140-004 | density without clutter | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-140-005 | hierarchy | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-140-006 | predictable interactions | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-140-007 | good empty states | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-140-008 | good loading states | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-140-009 | good failure states | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-140-010 | action confirmations | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-140-011 | undo where safe | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-140-012 | responsive layouts. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-140-013 | Avoid “settings-page syndrome” consisting of hundreds of checkboxes. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-141-000 | ACCESSIBILITY | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-141-001 | Target WCAG AA. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-141-002 | Test: | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-141-003 | keyboard | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-141-004 | focus management | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-141-005 | screen readers | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-141-006 | contrast | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-141-007 | forms | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-141-008 | dialog accessibility | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-141-009 | table navigation | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-141-010 | status announcements | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-141-011 | reduced motion. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-141-012 | Never communicate: | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-141-013 | safe | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-141-014 | warning | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-141-015 | blocked | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-141-016 | using color alone. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-142-000 | I18N / RTL | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-142-001 | All user-facing text must be translatable. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-142-002 | No string concatenation that prevents translation. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-142-003 | Support RTL layouts. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-142-004 | Test at least: | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-142-005 | English LTR | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-142-006 | one RTL locale. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-142-007 | Dates/numbers should respect WordPress locale. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-143-000 | SECURITY BASELINE | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-143-001 | Apply: | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-143-002 | sanitize early | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-143-003 | validate strictly | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-143-004 | escape late | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-143-005 | prepared SQL | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-143-006 | capability checks | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-143-007 | REST permission callbacks | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-143-008 | nonce validation for CSRF when relevant | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-143-009 | safe paths | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-143-010 | safe filenames | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-143-011 | secure temporary files | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-143-012 | secure object access. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-143-013 | Remember: | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-143-014 | nonce != authorization. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-144-000 | SSRF DEFENSE | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-144-001 | Any feature that examines: | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-144-002 | QR URLs | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-144-003 | remote imports | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-144-004 | external media | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-144-005 | webhooks | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-144-006 | remote scanner callbacks | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-144-007 | must be reviewed for SSRF. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-144-008 | Defend against: | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-144-009 | localhost | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-144-010 | loopback | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-144-011 | private ranges | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-144-012 | link-local | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-144-013 | metadata services | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-144-014 | IPv6 private/local | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-144-015 | DNS rebinding | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-144-016 | redirect chains | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-144-017 | alternative IP representations. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-144-018 | Prefer not fetching arbitrary destinations unless essential. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-145-000 | WEBHOOK SECURITY | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-145-001 | Incoming callbacks require: | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-145-002 | signature validation | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-145-003 | timestamp/replay protection | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-145-004 | event ID | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-145-005 | idempotency | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-145-006 | strict parsing. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-145-007 | Outgoing hooks should be signed. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-146-000 | QUARANTINE SECURITY | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-146-001 | Quarantine file access: | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-146-002 | must require authorization. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-146-003 | Do not expose raw path. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-146-004 | Prevent traversal. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-146-005 | Prevent guessing. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-146-006 | Consider secure streaming or server-assisted private delivery. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-147-000 | MULTISITE TENANT ISOLATION | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-147-001 | Test that one site cannot: | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-147-002 | read another site's quarantine | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-147-003 | read another site's audit data | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-147-004 | modify policies without network permission | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-147-005 | use another site's credentials unexpectedly. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-148-000 | UNINSTALL / DEACTIVATION | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-148-001 | Deactivation: | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-148-002 | stop schedules/workers cleanly but preserve data. | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-148-003 | Uninstall: | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-148-004 | offer explicit data-removal behavior. | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-148-005 | Do not unexpectedly delete audit/quarantine data simply because plugin is temporarily deactivated. | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-149-000 | MODERATION TEST DATA | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-149-001 | Never bundle illegal material. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-149-002 | Never bundle CSAM. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-149-003 | Use: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-149-004 | provider official test fixtures | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-149-005 | synthetic fixtures | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-149-006 | licensed evaluation datasets | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-149-007 | carefully constructed harmless adversarial files | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-149-008 | mock provider responses. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-149-009 | For sensitive moderation quality evaluation, document how an organization may supply its own lawful validation corpus without committing it to the repository. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-150-000 | TEST STRATEGY | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-150-001 | Implement: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-150-002 | PHP unit tests | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-150-003 | WordPress integration tests | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-150-004 | database migration tests | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-150-005 | REST tests | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-150-006 | provider contract tests | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-150-007 | queue concurrency tests | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-150-008 | frontend unit tests | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-150-009 | component tests | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-150-010 | E2E browser tests | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-150-011 | accessibility tests | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-150-012 | security tests | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-150-013 | performance tests | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-150-014 | failure/chaos tests | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-150-015 | multisite tests | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-150-016 | RTL tests. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-151-000 | REQUIRED ADVERSARIAL FILE TESTS | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-151-001 | Test safely against: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-151-002 | wrong MIME | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-151-003 | wrong extension | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-151-004 | double extension | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-151-005 | truncated image | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-151-006 | huge dimensions | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-151-007 | tiny compressed huge-pixel image | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-151-008 | polyglot-style safe fixtures | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-151-009 | deeply nested archive | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-151-010 | high compression ratio archive | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-151-011 | malformed SVG | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-151-012 | SVG script attempt | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-151-013 | SVG external resource | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-151-014 | malformed PDF | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-151-015 | macro-enabled test document | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-151-016 | corrupt image | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-151-017 | zero-byte file | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-151-018 | extremely long filename | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-151-019 | Unicode filename | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-151-020 | path traversal filename | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-151-021 | duplicate file | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-151-022 | near duplicate | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-151-023 | provider timeout | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-151-024 | provider 429 | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-151-025 | provider 500 | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-151-026 | malformed provider response. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-152-000 | SECURITY TESTS | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-152-001 | Test for: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-152-002 | CSRF | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-152-003 | XSS | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-152-004 | stored XSS | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-152-005 | REST authorization | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-152-006 | IDOR | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-152-007 | SQL injection | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-152-008 | SSRF | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-152-009 | path traversal | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-152-010 | unsafe deserialization | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-152-011 | credential leakage | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-152-012 | log injection | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-152-013 | webhook replay | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-152-014 | privilege escalation | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-152-015 | multisite isolation | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-152-016 | rate-limit bypass | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-152-017 | queue race conditions. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-153-000 | ML / POLICY TESTS | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-153-001 | Build deterministic mocked provider responses covering: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-153-002 | clear safe | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-153-003 | clear block | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-153-004 | threshold boundary | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-153-005 | provider disagreement | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-153-006 | unknown category | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-153-007 | missing confidence | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-153-008 | provider timeout | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-153-009 | provider schema change | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-153-010 | multiple findings | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-153-011 | context-specific decisions | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-153-012 | review band. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-153-013 | Policy tests must prove exact rule evaluation. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-154-000 | PERFORMANCE TESTS | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-154-001 | Benchmark: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-154-002 | 100 media records | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-154-003 | 10K | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-154-004 | 100K | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-154-005 | 1M+ scan records. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-154-006 | Measure: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-154-007 | DB query time | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-154-008 | REST latency | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-154-009 | memory | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-154-010 | worker throughput | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-154-011 | hashing speed | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-154-012 | image preparation | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-154-013 | cache effectiveness | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-154-014 | admin UI rendering. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-154-015 | Prevent performance regression with CI thresholds where practical. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-155-000 | PROVIDER CONTRACT TESTS | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-155-001 | Each provider adapter must test: | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-155-002 | authentication format | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-155-003 | request generation | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-155-004 | supported media | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-155-005 | response parser | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-155-006 | error mapping | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-155-007 | rate limiting | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-155-008 | timeouts | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-155-009 | model/version handling. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-155-010 | Mock by default. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-155-011 | Enable live contract suite only when credentials are supplied. | Partial; see evidence | src/Providers | tests/Contract/ProviderTest.php | API / deployment / module | docs/PROVIDER-MATRIX.md | OPEN |
| CF-156-000 | FRONTEND E2E TESTS | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-156-001 | Cover: | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-156-002 | onboarding | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-156-003 | policy creation | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-156-004 | policy simulation | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-156-005 | moderation review | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-156-006 | bulk actions | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-156-007 | provider failure | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-156-008 | appeals | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-156-009 | system health | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-156-010 | media attachment panel | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-156-011 | existing-library scan. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-157-000 | ACCESSIBILITY AUTOMATION | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-157-001 | Use automated accessibility testing where possible, but also document manual checks for: | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-157-002 | screen reader flow | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-157-003 | keyboard-only usage | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-157-004 | focus restoration | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-157-005 | sensitive preview reveal. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-158-000 | STATIC ANALYSIS / CODE QUALITY | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-158-001 | Configure appropriate tools such as: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-158-002 | PHP_CodeSniffer with WordPress standards | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-158-003 | PHPStan/Psalm where appropriate | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-158-004 | ESLint | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-158-005 | TypeScript strictness | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-158-006 | style checks | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-158-007 | test coverage. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-158-008 | Do not mechanically obey a style rule if doing so creates incorrect code; document justified exceptions. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-159-000 | CI/CD | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-159-001 | Create CI pipeline covering: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-159-002 | Composer validation | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-159-003 | PHP matrix | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-159-004 | supported WordPress matrix | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-159-005 | lint | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-159-006 | coding standards | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-159-007 | static analysis | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-159-008 | PHPUnit | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-159-009 | frontend tests | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-159-010 | build | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-159-011 | E2E where feasible | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-159-012 | security/dependency scanning | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-159-013 | package verification. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-159-014 | Create reproducible release package. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-159-015 | Exclude development files. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-160-000 | DEPENDENCY SECURITY | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-160-001 | Minimize dependencies. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-160-002 | Pin/lock appropriately. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-160-003 | Monitor vulnerabilities. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-160-004 | Generate dependency inventory/SBOM if practical. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-160-005 | Avoid abandoned parsing libraries for untrusted file formats. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-161-000 | WORDPRESS PLUGIN REVIEW COMPATIBILITY | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-161-001 | Audit against current WordPress plugin-directory requirements if public distribution is intended. | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-161-002 | Use WordPress uploader APIs appropriately. | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-161-003 | Do not require unsafe global constants such as unfiltered upload enablement. | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-161-004 | Do not ship telemetry without transparent consent/policy. | Partial; see evidence | src/WordPress | tests/Integration/run.php | API / deployment / module | docs/COMPATIBILITY.md | OPEN |
| CF-162-000 | PRIVACY-FIRST TELEMETRY | Partial; see evidence | src/Privacy/RecordLifecycle.php; src/WordPress/PrivacyTools.php; src/Application/Retention.php | tests/Integration/privacy.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-162-001 | If product telemetry is implemented: | Partial; see evidence | src/Privacy/RecordLifecycle.php; src/WordPress/PrivacyTools.php; src/Application/Retention.php | tests/Integration/privacy.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-162-002 | opt in where required | Partial; see evidence | src/Privacy/RecordLifecycle.php; src/WordPress/PrivacyTools.php; src/Application/Retention.php | tests/Integration/privacy.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-162-003 | document exactly what is sent | Partial; see evidence | src/Privacy/RecordLifecycle.php; src/WordPress/PrivacyTools.php; src/Application/Retention.php | tests/Integration/privacy.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-162-004 | never send uploaded file content unless specifically part of configured moderation provider behavior | Partial; see evidence | src/Privacy/RecordLifecycle.php; src/WordPress/PrivacyTools.php; src/Application/Retention.php | tests/Integration/privacy.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-162-005 | never send PII accidentally. | Partial; see evidence | src/Privacy/RecordLifecycle.php; src/WordPress/PrivacyTools.php; src/Application/Retention.php | tests/Integration/privacy.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-162-006 | Core plugin must function without product analytics telemetry. | Partial; see evidence | src/Privacy/RecordLifecycle.php; src/WordPress/PrivacyTools.php; src/Application/Retention.php | tests/Integration/privacy.php | API / deployment / module | docs/PRIVACY.md | OPEN |
| CF-163-000 | OBSERVABILITY | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-163-001 | Provide structured logs. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-163-002 | Useful dimensions: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-163-003 | request/scan ID | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-163-004 | job ID | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-163-005 | policy | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-163-006 | rule | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-163-007 | provider | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-163-008 | duration | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-163-009 | result | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-163-010 | retry | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-163-011 | site ID. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-163-012 | Do not log: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-163-013 | credentials | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-163-014 | raw PII | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-163-015 | full extracted sensitive text | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-163-016 | raw prohibited media. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-164-000 | CORRELATION IDs | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-164-001 | Every upload lifecycle gets a stable correlation identifier. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-164-002 | Allow support engineers to trace: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-164-003 | upload | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-164-004 | queue jobs | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-164-005 | provider calls | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-164-006 | policy decision | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-164-007 | human review | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-164-008 | notifications. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-165-000 | ERROR MODEL | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-165-001 | Create stable internal error codes. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-165-002 | Example categories: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-165-003 | VALIDATION | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-165-004 | SECURITY | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-165-005 | PROVIDER | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-165-006 | QUEUE | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-165-007 | STORAGE | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-165-008 | POLICY | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-165-009 | DATABASE | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-165-010 | CONFIGURATION. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-165-011 | User-facing messages should not depend directly on raw exception strings. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-166-000 | FEATURE FLAGS | Partial; see evidence | src/Configuration/Settings.php; src/Bootstrap/Services.php | tests/Unit/SettingsTest.php; tests/Integration/processing.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-166-001 | All major modules should support controlled rollout. | Partial; see evidence | src/Configuration/Settings.php; src/Bootstrap/Services.php | tests/Unit/SettingsTest.php; tests/Integration/processing.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-166-002 | Examples: | Partial; see evidence | src/Configuration/Settings.php; src/Bootstrap/Services.php | tests/Unit/SettingsTest.php; tests/Integration/processing.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-166-003 | video | Partial; see evidence | src/Configuration/Settings.php; src/Bootstrap/Services.php | tests/Unit/SettingsTest.php; tests/Integration/processing.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-166-004 | audio | Partial; see evidence | src/Configuration/Settings.php; src/Bootstrap/Services.php | tests/Unit/SettingsTest.php; tests/Integration/processing.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-166-005 | CDR | Partial; see evidence | src/Configuration/Settings.php; src/Bootstrap/Services.php | tests/Unit/SettingsTest.php; tests/Integration/processing.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-166-006 | deepfake | Partial; see evidence | src/Configuration/Settings.php; src/Bootstrap/Services.php | tests/Unit/SettingsTest.php; tests/Integration/processing.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-166-007 | C2PA | Partial; see evidence | src/Configuration/Settings.php; src/Bootstrap/Services.php | tests/Unit/SettingsTest.php; tests/Integration/processing.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-166-008 | advanced analytics | Partial; see evidence | src/Configuration/Settings.php; src/Bootstrap/Services.php | tests/Unit/SettingsTest.php; tests/Integration/processing.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-166-009 | agency features. | Partial; see evidence | src/Configuration/Settings.php; src/Bootstrap/Services.php | tests/Unit/SettingsTest.php; tests/Integration/processing.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-166-010 | Feature flags are operational controls, not substitutes for unfinished implementation. | Partial; see evidence | src/Configuration/Settings.php; src/Bootstrap/Services.php | tests/Unit/SettingsTest.php; tests/Integration/processing.php | API / deployment / module | docs/MEDIA-PROCESSING.md | OPEN |
| CF-167-000 | COMMERCIAL READINESS | Not implemented | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-167-001 | Architect licensing separately from security logic. | Not implemented | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-167-002 | Never make an expired license silently disable mandatory security and allow unsafe content. | Not implemented | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-167-003 | If premium scanning becomes unavailable, enter a defined safe failure mode and alert the administrator. | Not implemented | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-168-000 | DOCUMENTATION | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-168-001 | Produce: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-168-002 | installation guide | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-168-003 | quick-start | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-168-004 | provider guides | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-168-005 | policy guide | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-168-006 | moderation guide | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-168-007 | security architecture | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-168-008 | privacy guide | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-168-009 | developer guide | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-168-010 | hooks/reference | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-168-011 | REST API documentation | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-168-012 | WP-CLI reference | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-168-013 | database schema | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-168-014 | operations/runbook | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-168-015 | troubleshooting | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-168-016 | performance tuning | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-168-017 | multisite guide | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-168-018 | provider outage guide | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-168-019 | migration guide. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-169-000 | DEVELOPER API DOCUMENTATION | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-169-001 | Generate examples for: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-169-002 | adding a scanner | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-169-003 | adding a taxonomy category | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-169-004 | adding a custom policy condition | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-169-005 | adding a decision action | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-169-006 | listening to scan completion | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-169-007 | changing quarantine storage | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-169-008 | querying moderation state. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-170-000 | OPENAPI / API SCHEMAS | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-170-001 | Document REST API with machine-readable schema where practical. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-170-002 | Ensure implementation and documentation remain synchronized. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-171-000 | RELEASE MIGRATIONS | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-171-001 | Database upgrades must be: | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-171-002 | versioned | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-171-003 | repeatable | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-171-004 | safe on failure where possible | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-171-005 | tested from multiple previous versions. | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-171-006 | Do not run huge blocking migrations during ordinary frontend traffic. | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-171-007 | Large transformations should use background batches. | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-172-000 | BACKWARD COMPATIBILITY | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-172-001 | Establish a public API stability policy. | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-172-002 | Do not break stored policies silently. | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-172-003 | Migrate schemas explicitly. | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-172-004 | Deprecate hooks/interfaces before removal. | Partial; see evidence | src/Persistence | tests/Integration/run.php | API / deployment / module | docs/DATA-MODEL.md | OPEN |
| CF-173-000 | PRODUCT PERFORMANCE PRINCIPLE | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-173-001 | Performance is a product feature. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-173-002 | At every milestone ask: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-173-003 | Can this operation happen later? | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-173-004 | Can it be cached? | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-173-005 | Can it be skipped? | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-173-006 | Can it use an existing result? | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-173-007 | Can it process a smaller derivative? | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-173-008 | Can it be batched? | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-173-009 | Can a query use an index? | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-173-010 | Can browser code be lazy-loaded? | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-173-011 | Can a provider call be avoided? | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-174-000 | MODERATION ACCURACY PRINCIPLE | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-174-001 | Minimizing errors is more important than creating the appearance of automation. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-174-002 | Never force uncertain content directly into BLOCK merely to make the system look decisive. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-174-003 | Use: | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-174-004 | confidence bands | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-174-005 | context | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-174-006 | secondary provider checks | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-174-007 | calibration | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-174-008 | human review. | Partial; see evidence | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-175-000 | UX PRINCIPLE | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-175-001 | Administrators should understand: | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-175-002 | what happened | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-175-003 | why it happened | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-175-004 | what they can do | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-175-005 | what the consequences are. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-175-006 | Avoid exposing 500 low-level settings at once. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-175-007 | Use: | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-175-008 | presets | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-175-009 | progressive disclosure | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-175-010 | sensible defaults | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-175-011 | advanced sections | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-175-012 | simulation. | Partial; see evidence | src/Admin; assets/src | tests/E2E/admin.spec.ts | Admin console | docs/UX-SPEC.md | OPEN |
| CF-176-000 | SECURITY PRINCIPLE | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-176-001 | The content scanning engine itself processes malicious input. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-176-002 | Therefore the scanner pipeline is part of the attack surface. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-176-003 | Prefer isolation for dangerous parsers. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-176-004 | Set: | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-176-005 | resource limits | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-176-006 | timeouts | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-176-007 | process boundaries where appropriate. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-176-008 | Do not trust third-party parsing libraries merely because they are popular. | Partial; see evidence | src/Security | tests/Security/FileSecurityTest.php | API / deployment / module | docs/THREAT-MODEL.md | OPEN |
| CF-177-000 | IMPLEMENTATION MILESTONES | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-001 | Execute sequentially. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-002 | ## Milestone 0 — Discovery and Foundations | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-003 | Inspect repository. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-004 | Research current official APIs. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-005 | Create traceability matrix. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-006 | Create architecture. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-007 | Create threat model. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-008 | Choose support matrix. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-009 | Set up CI/testing/static analysis. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-010 | ## Milestone 1 — Upload Gateway | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-011 | Implement interception. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-012 | File descriptor. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-013 | Contexts. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-014 | State machine. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-015 | MIME/type validation. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-016 | Resource limits. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-017 | Basic persistence. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-018 | ## Milestone 2 — Policy Engine | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-019 | Implement taxonomy. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-020 | Rules. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-021 | Conditions. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-022 | Decisions. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-023 | Policy versions. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-024 | Simulation engine. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-025 | ## Milestone 3 — Image Moderation | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-026 | Implement provider architecture. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-027 | Primary image providers. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-028 | Normalization. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-029 | Thresholds. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-030 | Caching. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-031 | Image preparation. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-032 | ## Milestone 4 — Quarantine and Human Review | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-033 | Private quarantine. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-034 | Queue. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-035 | Moderation UI. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-036 | Assignments. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-037 | Overrides. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-038 | Appeals. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-039 | Audit. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-040 | ## Milestone 5 — OCR / PII / QR / Privacy | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-041 | OCR. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-042 | Text moderation. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-043 | PII. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-044 | QR. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-045 | redaction. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-046 | metadata stripping. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-047 | ## Milestone 6 — File Security | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-048 | ClamAV. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-049 | archives. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-050 | SVG. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-051 | PDF. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-052 | Office. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-053 | CDR abstraction. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-054 | ## Milestone 7 — Authenticity / Fingerprinting | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-055 | exact hashes. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-056 | perceptual hashes. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-057 | known-content lists. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-058 | AI-generated detection. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-059 | deepfake. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-060 | C2PA. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-061 | ## Milestone 8 — Video / Audio | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-062 | async video. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-063 | frames. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-064 | audio extraction. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-065 | transcription. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-066 | multimodal aggregation. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-067 | ## Milestone 9 — Analytics / Accuracy | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-068 | dashboards. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-069 | provider analytics. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-070 | false-positive evaluation. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-071 | calibration. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-072 | drift. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-073 | abuse analytics. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-074 | ## Milestone 10 — Integration Platform | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-075 | REST. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-076 | webhooks. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-077 | WP-CLI. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-078 | developer hooks. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-079 | WooCommerce/community/form adapters. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-080 | ## Milestone 11 — Multisite / Agency / Enterprise | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-081 | network policies. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-082 | central management primitives. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-083 | data residency. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-084 | SLA workflow. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-085 | advanced DLP. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-086 | ## Milestone 12 — Hardening and Release | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-087 | performance benchmarks. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-088 | security audit. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-089 | adversarial testing. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-090 | accessibility audit. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-091 | RTL. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-092 | migration testing. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-093 | packaging. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-094 | documentation. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-177-095 | release candidate. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-178-000 | MILESTONE EXIT GATE | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-178-001 | A milestone is not complete unless: | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-178-002 | implementation exists | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-178-003 | unit tests pass | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-178-004 | integration tests pass | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-178-005 | security review completed | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-178-006 | performance reviewed | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-178-007 | UX reviewed where relevant | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-178-008 | documentation updated | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-178-009 | traceability updated | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-178-010 | no known P0/P1 defect remains. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-178-011 | Do not postpone critical issues to “later cleanup.” | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-179-000 | REVIEW PASSES AFTER EVERY MILESTONE | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-179-001 | Run these separate reviews. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-179-002 | ## WordPress Architecture Review | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-179-003 | Check hooks, lifecycle, compatibility, APIs. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-179-004 | ## Security Review | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-179-005 | Attempt bypass and privilege escalation. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-179-006 | ## Performance Review | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-179-007 | Inspect memory, queries, remote calls. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-179-008 | ## ML Quality Review | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-179-009 | Inspect normalization, thresholds, uncertainty. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-179-010 | ## UX Review | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-179-011 | Inspect flow, cognitive load, errors. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-179-012 | ## Accessibility Review | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-179-013 | Inspect AA requirements. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-179-014 | ## QA Review | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-179-015 | Find missing edge cases. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-179-016 | Fix discovered issues before proceeding. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-180-000 | FINAL SYSTEM ACCEPTANCE | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-180-001 | Before claiming completion, demonstrate: | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-180-002 | all requirements mapped | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-180-003 | all modules implemented | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-180-004 | all migrations tested | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-180-005 | all tests passing | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-180-006 | supported WordPress versions tested | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-180-007 | supported PHP versions tested | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-180-008 | no critical static-analysis failures | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-180-009 | no known critical/high security vulnerability | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-180-010 | performance benchmark report | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-180-011 | moderation benchmark framework | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-180-012 | provider failure behavior | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-180-013 | quarantine security | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-180-014 | multisite isolation | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-180-015 | accessible admin workflows | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-180-016 | RTL rendering | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-180-017 | documentation | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-180-018 | release artifact. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-181-000 | FINAL OUTPUT PACKAGE | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-181-001 | Deliver: | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-181-002 | production plugin source | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-181-003 | release ZIP | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-181-004 | Composer files | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-181-005 | frontend package files | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-181-006 | CI configuration | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-181-007 | database schema/migrations | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-181-008 | automated tests | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-181-009 | architecture documentation | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-181-010 | ADRs | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-181-011 | threat model | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-181-012 | privacy model | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-181-013 | provider capability matrix | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-181-014 | performance benchmark report | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-181-015 | moderation-quality report | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-181-016 | UX specification | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-181-017 | REST documentation | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-181-018 | developer hooks documentation | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-181-019 | WP-CLI documentation | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-181-020 | operator runbook | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-181-021 | installation documentation | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-181-022 | upgrade documentation | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-181-023 | release notes. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-182-000 | FINAL REPORT | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-182-001 | At completion provide a concise engineering release report containing: | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-182-002 | Implemented features | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-182-003 | Known limitations | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-182-004 | Supported environments | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-182-005 | Providers implemented | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-182-006 | Security review result | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-182-007 | Performance results | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-182-008 | Moderation-quality methodology | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-182-009 | Accessibility status | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-182-010 | Test summary | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-182-011 | Database migration status | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-182-012 | Operational requirements | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-182-013 | Recommended production configuration | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-182-014 | Remaining non-blocking future improvements. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-182-015 | Do not claim perfection. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-182-016 | Clearly distinguish: | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-182-017 | tested | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-182-018 | implemented but environment-dependent | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-182-019 | requires external provider credentials | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-182-020 | future optional enhancement. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-183-000 | WORKING BEHAVIOR | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-183-001 | Do not repeatedly narrate trivial actions. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-183-002 | Surface important findings when discovered. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-183-003 | Examples: | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-183-004 | architectural incompatibility | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-183-005 | security vulnerability | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-183-006 | performance bottleneck | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-183-007 | provider limitation | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-183-008 | WordPress compatibility issue | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-183-009 | false-positive problem. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-183-010 | Fix issues instead of merely documenting them when correction is within project scope. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-184-000 | PRIORITY ORDER WHEN TRADE-OFFS CONFLICT | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-184-001 | Use this ordering: | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-184-002 | 1. Security / prevention of unsafe execution | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-184-003 | 2. Data integrity | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-184-004 | 3. Privacy | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-184-005 | 4. Moderation correctness | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-184-006 | 5. Reliability | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-184-007 | 6. User safety | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-184-008 | 7. Performance | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-184-009 | 8. User experience | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-184-010 | 9. Cost efficiency | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-184-011 | 10. Developer convenience | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-184-012 | However, do not use this order as justification for obviously poor UX or inefficient architecture. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-184-013 | Seek designs that satisfy multiple goals simultaneously. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-185-000 | START NOW | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-185-001 | Begin with: | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-185-002 | 1. repository inspection; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-185-003 | 2. environment inventory; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-185-004 | 3. current official documentation verification; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-185-005 | 4. requirements traceability file; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-185-006 | 5. architectural baseline; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-185-007 | 6. threat model; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-185-008 | 7. support matrix; | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-185-009 | 8. implementation. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-185-010 | Do not stop after writing the architecture. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
| CF-185-011 | Continue through the milestones systematically until the production-ready plugin is complete. | Process / release obligation; open | src/Domain | tests/Unit/PolicyTest.php | API / deployment / module | docs/ARCHITECTURE.md | OPEN |
