# Moderation quality

Presets use review bands without automatic hard blocking. Administrators may calibrate probability-based categories using a representative, lawfully supplied labeled corpus. Google likelihood enums and Azure severity values remain ordinal/severity evidence and never qualify for probability-band automatic blocking.

Use `Analytics/Evaluator` for per-category precision, recall, F1, false-positive/negative rates, coverage and unknown rate. Undefined denominators are null. Human override rates are disagreement evidence, not a population false-positive or false-negative estimate.

Aim for ≥99.5% precision for critical automatic blocking only after a representative benchmark establishes it with adequate statistical uncertainty. Synthetic provider fixtures validate software behavior; they do not validate ML accuracy. No achieved accuracy or detection coverage is claimed.

Dataset inputs remain outside the repository. Record category, independent label, provider/model, calibration version, context, collection date, lawful provenance and score. Evaluate subgroup/context behavior and disagreement. Never commit illegal material or personal data. No automatic retraining uses uploads.

Unknown categories, missing confidence, timeout, schema change and incompatible models must be evaluated as missing evidence. Future drift monitoring needs a defined reference cohort and enough observations; a dashboard alone does not establish drift detection.
