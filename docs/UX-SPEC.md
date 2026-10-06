# UX specification

One WordPress admin screen contains Dashboard, Moderation Queue, Policies, Media Scanner, Providers, Analytics, Audit Log, Integrations, System Health, Settings and Developer Tools. Non-moderator users see only their summarized uploads. Capability checks apply both to navigation and API requests.

Queue workflow: filter → select case → inspect normalized evidence and rule reason → explicitly reveal optional sensitive preview → enter required rationale → approve/reject/rescan/escalate. Preview is absent until Reveal, does not autoplay, and is a bounded raster derivative. Bulk processing reports item outcomes rather than assuming all succeeded.

Policy workflow: choose editable preset → adjust context/AND/OR/NOT groups and priorities → simulate synthetic signals → save an immutable version. Confidence bands explain calibration. Security checks apply in monitor mode. Failure mode is visible near moderation configuration.

WCAG AA is a target. Use semantic labels, captions, keyboard controls, focus outlines/restoration, live status messages and text states. Layout uses logical CSS properties and adapts to narrow screens. Automated axe and keyboard/RTL tests supplement, rather than replace, manual screen-reader and locale review.

Outstanding complete-product UX acceptance includes resumable onboarding, saved filters, assignment/team/SLA screens, uploader appeals UI, safe file simulation, action confirmations, fuller localized labels and application code splitting.
