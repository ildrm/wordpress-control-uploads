# UX specification

One WordPress admin screen contains Setup, Dashboard, Moderation Queue, Policies, Media Scanner, Providers, Analytics, Audit Log, Integrations, System Health, Settings and Developer Tools. Non-moderator users see only their summarized uploads. Capability checks apply both to navigation and API requests.

Queue workflow: filter → select case → inspect normalized evidence and rule reason → explicitly reveal optional sensitive preview → enter required rationale → approve/reject/rescan/escalate. Preview is absent until Reveal, does not autoplay, and is a bounded raster derivative. Bulk processing reports item outcomes rather than assuming all succeeded.

Policy workflow: choose editable preset → adjust context/AND/OR/NOT groups and priorities → simulate synthetic signals → save an immutable version. Confidence bands explain calibration. Security checks apply in monitor mode. Failure mode is visible near moderation configuration.

WCAG AA is a target. Use semantic labels, captions, keyboard controls, focus outlines/restoration, live status messages and text states. Layout uses logical CSS properties and adapts to narrow screens. Automated axe and keyboard/RTL tests supplement, rather than replace, manual screen-reader and locale review.

Setup resumes saved steps through environment, policy, privacy/limits and completion. Queue supports reviewer/team/deadline filters, user-scoped saved views, assignment/priority/deadlines and overdue escalation. Approve/reject/quarantine/delete opens a native confirmation dialog; Escape/cancel restores focus without mutation. Retention classes, processor flags and bounded sampling limits have labeled settings. Original Content Credentials are explained separately from signature trust and public reconstructed media.

Policies also accepts a real sample file and an unsaved policy. It explains configured provider processing/cost, never publishes the sample and reports normalized evidence, risk, decision/rules, latency and estimates. Samples and extracted words are discarded; limited audit/usage/cache can remain.

Outstanding product UX includes remaining integration/metadata/network/enterprise flows, translated catalogs and dynamic application code splitting. Manual screen-reader and real translated RTL acceptance remain open.

Uploader appeals UI is now implemented in My Uploads: summarized owned records → Request review → required reason → submit → status acknowledgement. Internal notes/findings remain moderator-only. Initial navigation selects an authorized view. Basic onboarding, assignment/team/SLA and saved views are implemented; comprehensive product and manual accessibility acceptance remain open.
