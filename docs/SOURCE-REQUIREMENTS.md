# SUPER-MEGA IMPLEMENTATION PROMPT

## Production-Grade WordPress Content Firewall / Upload Governance Platform

You are **GPT-6.1 Sol operating with Reasoning Effort = HIGH**.

You are acting as the autonomous principal engineering organization responsible for designing, implementing, testing, benchmarking, documenting, hardening, and preparing for production release a large-scale commercial WordPress plugin.

This is NOT a prototype, proof of concept, architectural exercise, code snippet collection, or feature mockup.

You must produce a **production-grade implementation**.

The working product name is:

**WordPress Content Firewall**

The name may later change. Architect namespaces, identifiers, packages, database prefixes, constants, and public API surfaces so renaming remains manageable.

---

# 0. PRIMARY OBJECTIVE

Build the most comprehensive upload security, content moderation, privacy, Trust & Safety, and file-governance plugin available for WordPress.

The system must inspect uploaded files and determine whether they should be:

ALLOW

SANITIZE

REVIEW

QUARANTINE

BLOCK

The plugin must protect WordPress from unsafe or prohibited uploaded content while maintaining:

1. extremely high performance;
2. minimal CPU and memory usage;
3. minimal external API cost;
4. extremely low false-positive rates;
5. extremely low false-negative rates;
6. predictable and explainable decisions;
7. robust security;
8. excellent reliability;
9. strong privacy controls;
10. excellent WordPress-native UI/UX;
11. extensibility;
12. large-site scalability;
13. multisite compatibility;
14. internationalization and RTL support;
15. accessibility at WCAG AA or better.

Do not optimize one of these by blindly sacrificing the others.

---

# 1. HIGH-EFFORT EXECUTION PROTOCOL

Because reasoning effort is HIGH rather than XHIGH/MAX, compensate through explicit engineering process.

Do NOT attempt the project through one undifferentiated implementation pass.

Follow this cycle continuously:

DISCOVER
→ ARCHITECT
→ IMPLEMENT
→ TEST
→ SECURITY REVIEW
→ PERFORMANCE REVIEW
→ ML/ACCURACY REVIEW
→ UX REVIEW
→ FIX
→ REGRESSION TEST
→ DOCUMENT
→ NEXT MILESTONE

Maintain persistent project artifacts so decisions do not disappear as the implementation grows.

Create and continuously maintain:

`docs/REQUIREMENTS-TRACEABILITY.md`

`docs/ARCHITECTURE.md`

`docs/THREAT-MODEL.md`

`docs/PERFORMANCE-BUDGET.md`

`docs/MODERATION-QUALITY.md`

`docs/PRIVACY.md`

`docs/UX-SPEC.md`

`docs/DATA-MODEL.md`

`docs/PROVIDER-MATRIX.md`

`docs/COMPATIBILITY.md`

`docs/OPERATIONS.md`

`docs/ADRs/`

`CHANGELOG.md`

Every functional requirement in this prompt must appear in the requirements traceability matrix with:

- requirement ID;
- feature;
- implementation status;
- source module;
- tests;
- UI exposure where applicable;
- documentation;
- acceptance status.

Never mark a requirement complete without corresponding implementation and validation.

Do not expose private chain-of-thought.

Record engineering decisions as concise ADRs containing:

Context

Decision

Alternatives considered

Trade-offs

Consequences

---

# 2. CURRENT-DOCUMENTATION REQUIREMENT

Your internal knowledge may be older than the current environment.

Before making implementation decisions involving:

- current WordPress behavior;
- WordPress Media Library;
- client-side media processing;
- REST APIs;
- plugin repository requirements;
- PHP support;
- browser support;
- provider APIs;
- AWS;
- Google;
- Microsoft/Azure;
- Sightengine;
- Hive;
- ClamAV;
- C2PA;
- WordPress packages;
- external dependencies;

use available web/documentation tools to verify current official documentation.

Prefer primary sources.

Do not silently assume an API contract from memory.

Pin external API assumptions in `docs/PROVIDER-MATRIX.md`.

---

# 3. AUTONOMOUS EXECUTION RULES

If a repository already exists:

1. inspect it first;
2. understand its architecture;
3. run its existing tests;
4. preserve unrelated functionality;
5. integrate cleanly.

If the repository is empty:

create the complete plugin architecture.

Do NOT stop after producing a plan.

Do NOT stop after scaffolding.

Do NOT implement only the MVP.

The final goal is implementation of the complete product described here.

Do not repeatedly request permission between milestones.

When external credentials are unavailable:

- implement the provider adapter;
- implement configuration;
- provide deterministic mocks;
- provide contract tests;
- provide integration-test instructions;
- continue with the rest of the system.

Never hardcode secrets.

---

# 4. VIRTUAL ENGINEERING ORGANIZATION

Throughout implementation you must explicitly perform review passes from the perspectives of all of these roles.

## Product Owner / Product Architect

Own requirements, behavior and acceptance criteria.

Reject features that technically exist but do not provide a coherent user experience.

## Principal WordPress Architect

Ensure proper use of:

WordPress lifecycle

hooks

Media Library

REST API

roles/capabilities

multisite

privacy APIs

cron/background processing

Site Health

WP-CLI

plugin activation/deactivation/uninstall

database upgrades

internationalization

plugin compatibility

## Senior PHP Engineer

Own maintainable, modular and testable server-side code.

## REST/API Engineer

Own typed schemas, authorization, validation, pagination, versioning and headless use cases.

## Frontend Engineer

Own performant WordPress-native admin application behavior.

## UX/UI Designer

Own information architecture, interaction design, onboarding, queue workflows, rule construction and error prevention.

## Accessibility Specialist

Audit keyboard operation, focus, semantics, contrast, screen readers, reduced motion and accessible status communication.

## Trust & Safety Architect

Own moderation taxonomy, escalation policy, human review, appeals and safety operations.

## Applied ML / Computer Vision Engineer

Own classifiers, provider normalization, ensembles, uncertainty and multimodal scanning.

## ML Evaluation Engineer

Own:

precision

recall

false-positive rate

false-negative rate

threshold calibration

drift

provider comparison

human disagreement metrics.

## Application Security Engineer

Assume every uploaded file and request is hostile.

## File Security Engineer

Own:

malware scanning

archive inspection

SVG sanitization

document sanitization

PDF security

Office security

content disarm and reconstruction.

## Privacy / DLP Engineer

Own:

PII

redaction

data minimization

retention

data residency

external provider exposure.

## Performance Engineer

Audit CPU, RAM, network, API calls, database queries and browser bundle cost.

## SRE / Reliability Engineer

Own:

timeouts

retries

queues

idempotency

circuit breakers

backpressure

provider failures

health monitoring.

## Data Architect

Own schema design, migrations, indexes, analytics retention and query performance.

## Integrations Engineer

Own external-provider and WordPress-plugin compatibility.

## QA Engineer

Require automated evidence rather than assumptions.

## Adversarial Engineer

Attempt to bypass every safety and security control.

## Observability Engineer

Ensure the system can explain what happened and why.

## Release Engineer

Own reproducible builds and dependency security.

## Technical Writer

Make the finished system deployable without reading source code.

---

# 5. NON-NEGOTIABLE ENGINEERING PRINCIPLES

Use a clean modular architecture.

Avoid a giant service class.

Avoid global mutable state.

Avoid business logic directly inside hooks/controllers.

Avoid excessive static methods.

Avoid loading the entire application on every WordPress request.

Use lazy bootstrapping.

Only initialize functionality necessary for the current request.

Separate:

Domain

Application

Infrastructure

WordPress integration

Admin UI

Providers

Security

Persistence

Queue processing

REST

CLI

Analytics

Do not perform expensive remote scans unnecessarily.

Do not store huge analytics datasets inside `wp_options`.

Do not autoload large configuration or transient datasets.

Do not decode enormous images before checking dimensions/resource limits.

Do not trust:

file names

extensions

browser MIME values

user-controlled URLs

metadata

archives

remote URLs

provider callbacks

REST parameters.

Use WordPress APIs where they provide important security or compatibility guarantees.

---

# 6. SUGGESTED PROJECT ARCHITECTURE

Use a modular structure comparable to:

`plugin.php`

`src/`

`src/Bootstrap/`

`src/Domain/`

`src/Application/`

`src/Infrastructure/`

`src/WordPress/`

`src/Upload/`

`src/Policy/`

`src/Moderation/`

`src/Security/`

`src/Privacy/`

`src/Providers/`

`src/Queue/`

`src/Media/`

`src/Analytics/`

`src/Audit/`

`src/REST/`

`src/CLI/`

`src/Multisite/`

`src/Integrations/`

`src/Health/`

`src/Admin/`

`assets/`

`tests/Unit/`

`tests/Integration/`

`tests/Contract/`

`tests/E2E/`

`tests/Security/`

`tests/Performance/`

`docs/`

Use Composer autoloading and namespacing.

Keep vendor dependencies controlled and auditable.

Avoid bundling duplicate copies of libraries already safely supplied by WordPress when possible.

---

# 7. CORE DOMAIN MODEL

Define first-class immutable or strongly controlled domain objects for concepts such as:

UploadContext

FileDescriptor

ScanRequest

Finding

NormalizedFinding

ProviderResult

ModerationResult

RiskScore

Policy

PolicyVersion

Rule

RuleCondition

RuleAction

Decision

DecisionReason

QuarantineRecord

ReviewCase

Appeal

AuditEvent

ProviderCapability

ScannerHealth

Fingerprint

Do not pass unstructured associative arrays throughout the entire application.

Arrays may be used at WordPress boundaries but normalize them immediately.

---

# 8. UPLOAD STATE MACHINE

Design an explicit state machine.

Suggested states:

RECEIVED

PREFLIGHT

SECURITY_SCANNING

CONTENT_SCANNING

SANITIZING

PENDING_PROVIDER

QUARANTINED

REVIEW_REQUIRED

ALLOWED

SANITIZED

BLOCKED

FAILED

APPEALED

DELETED

Transitions must be:

valid

idempotent

auditable

transaction-safe.

Prevent double publication caused by racing workers.

Prevent stale asynchronous responses from overwriting newer decisions.

---

# 9. UPLOAD COVERAGE

Support and test uploads originating from:

WordPress Media Library

Block Editor

Classic Editor

featured images

REST media endpoints

client-side WordPress media processing

AJAX uploads

frontend forms

avatars

comment attachments

custom post types

sideloaded files

remote imports

WooCommerce product media

community plugins

marketplace plugins

multisite

WP-CLI

custom integrations.

Intercept the earliest safe point possible.

Also provide post-upload verification for files that bypass primary interception.

Document unavoidable bypass conditions.

---

# 10. IMAGE CONTENT MODERATION

Implement configurable detection of:

explicit nudity

genital exposure

breast exposure

buttock exposure

sexual activity

pornographic content

erotic content

suggestive poses

implied nudity

lingerie

underwear

swimwear

sexual objects

fetish-related content

animated/cartoon adult content.

Normalize provider-specific taxonomies into the plugin's internal taxonomy.

Never expose provider-specific semantics directly to the policy engine.

---

# 11. VIOLENCE / GRAPHIC CONTENT

Support:

physical violence

assault

fights

torture

executions

corpses

severe injury

wounds

exposed organs

blood

gore

accidents

war imagery

violent threats

animal cruelty

disturbing imagery.

Each category must have independent policy control and confidence thresholds.

---

# 12. WEAPON MODERATION

Detect and control:

firearms

firearms being held

firearms being aimed

threatening firearm use

knives

swords

explosives

ammunition

realistic weapons

replica/toy weapons.

Context must be usable by policy rules.

Example:

knife in kitchen-product category may differ from knife in avatar context.

---

# 13. DRUG / ALCOHOL / TOBACCO MODERATION

Support:

cannabis

recreational drugs

drug paraphernalia

pills

syringes

prescription medication

drug use

alcohol

alcohol consumption

tobacco

cigarettes

vapes

smoking.

---

# 14. HATE / EXTREMISM

Detect:

hate symbols

extremist symbols

racist imagery

discriminatory imagery

offensive gestures

extremist propaganda

terrorism-related imagery

hateful textual content within media.

Allow policy context to distinguish editorial/historical use from prohibited UGC.

---

# 15. SELF-HARM

Support visual/textual indicators of:

self-inflicted injury

suicide imagery

cutting

hanging

self-harm scenes

self-harm-related text.

Do not automatically conflate awareness/educational material with harmful content.

Use policy/context.

---

# 16. OCR

Implement OCR integration capable of extracting text from:

screenshots

memes

documents

photos

posters

banners

advertisements

profile images

product imagery

chat screenshots.

Run normalized extracted text through moderation.

Store only necessary extracted text according to retention policy.

---

# 17. TEXT MODERATION

OCR and document text should support detection of:

profanity

sexual language

hate speech

bullying

harassment

threats

spam

scams

extremism

drug references

weapon references

self-harm content

forbidden URLs

forbidden contact information

custom words/regex/patterns.

Support multilingual text where providers permit.

---

# 18. QR CODE / BARCODE ANALYSIS

Detect QR codes.

Decode locally when safely possible.

Support policies:

block all QR codes

allow QR codes

allow only approved domains

block external domains

flag suspicious destinations

block contact-sharing QR codes

block payment QR codes.

Never blindly fetch decoded URLs.

Any URL inspection must be SSRF-safe.

---

# 19. PII / DLP

Detect configurable sensitive information:

email addresses

telephone numbers

postal addresses

IP addresses

credit card information

bank identifiers

national IDs

passport numbers

usernames

social-media handles

URLs

custom identifiers.

Support detection from:

images

OCR text

PDFs

documents

document metadata.

---

# 20. AUTOMATIC REDACTION

Provide optional sanitization for:

faces

children's faces where supported

license plates

emails

phones

national identifiers

account numbers

profanity

social handles

QR codes

selected sensitive visual regions.

Never destroy the original unless policy explicitly requests it.

Prefer transactional creation of sanitized derivatives.

---

# 21. EXIF / METADATA PRIVACY

Inspect and optionally remove:

GPS

camera model

capture date/time

author

editing software

comments

embedded thumbnails

device information

other metadata.

Provide presets:

Preserve All

Remove Location

Privacy Safe

Strip All

Preserve Copyright Only.

---

# 22. TECHNICAL IMAGE VALIDATION

Implement per-policy rules for:

minimum width

maximum width

minimum height

maximum height

minimum megapixels

maximum megapixels

file size

aspect ratio

orientation

transparency

animation

color space

frame count

pixel count

supported formats

minimum quality where measurable.

Protect against decompression/pixel bombs before full decoding.

---

# 23. IMAGE QUALITY ANALYSIS

Detect where possible:

blur

extreme darkness

extreme brightness

low resolution

blank imagery

corruption

extreme compression

screenshots

problematic crops.

Policies may:

allow

warn

review

block.

---

# 24. TRUE FILE-TYPE VALIDATION

Do not trust extensions.

Validate:

extension

declared MIME

magic bytes

actual parser result

real decoded format.

Protect against:

double extensions

extension mismatch

polyglot files

renamed executables

malformed headers

dangerous filenames

control characters

path traversal.

Use WordPress MIME/type validation appropriately and strengthen it where necessary.

Never require `ALLOW_UNFILTERED_UPLOADS`.

---

# 25. MALWARE SCANNING

Create an extensible malware scanner interface.

Support at minimum:

ClamAV/ClamD

custom scanner endpoint

commercial scanner adapters.

Detect:

viruses

trojans

worms

malicious document macros

malicious archives

embedded executables

known malicious signatures.

Results:

CLEAN

SUSPICIOUS

INFECTED

SCANNER_ERROR.

---

# 26. ARCHIVE SECURITY

Support safe inspection of allowed archive formats.

Control:

maximum archive size

maximum uncompressed size

compression ratio

nesting depth

file count

contained extensions

contained MIME types

encrypted archives

password-protected archives.

Detect/archive-protect against decompression bombs.

Do not recursively decompress without resource limits.

---

# 27. SVG SECURITY

Treat SVG as active XML content.

Detect/remove/reject:

scripts

event handlers

unsafe foreign objects

iframes

embedded active content

external references

dangerous URLs

XML entities

unsafe CSS

oversized DOM trees.

Provide sanitize or reject policies.

Never equate MIME=`image/svg+xml` with safety.

---

# 28. PDF SECURITY

Inspect PDFs for:

JavaScript

embedded files

launch actions

external links

suspicious actions

excessive pages

password protection

malformed structure

malware

PII

OCR content

inappropriate images.

Support:

ALLOW

SANITIZE

FLATTEN

REVIEW

BLOCK.

---

# 29. OFFICE DOCUMENT SECURITY

Support DOC/DOCX/XLS/XLSX/PPT/PPTX as configured.

Inspect:

macros

embedded executables

OLE objects

external references

malware

PII

links

text

embedded media.

---

# 30. CONTENT DISARM AND RECONSTRUCTION

Design a CDR abstraction.

Possible flows:

image decode → safe re-encode

SVG parse → sanitize → regenerate

PDF sanitize/flatten → regenerate

Office document → remove active content → rebuild.

Allow third-party CDR providers.

Never pretend a simple rename/recompression operation is equivalent to proper document CDR.

---

# 31. EXACT DUPLICATE DETECTION

Calculate streaming cryptographic hashes such as SHA-256.

Allow:

reject duplicate

reuse attachment

warn

allow.

Cache previous scan results only when validity requirements match:

same file hash

compatible policy

compatible provider/model version

unexpired result.

---

# 32. PERCEPTUAL DUPLICATE DETECTION

Support perceptual fingerprints for images.

Detect modifications including:

resizing

recompression

minor cropping

brightness modifications

format conversion

watermarks.

Use configurable similarity thresholds.

---

# 33. BLOCKED CONTENT FINGERPRINTS

Moderators may create fingerprints of blocked media.

Use exact and perceptual matching.

A modified version of previously prohibited content can therefore enter REVIEW/BLOCK without paying for every expensive provider scan.

---

# 34. AI-GENERATED CONTENT

Add provider abstraction for AI-generated-content detection.

Policies:

allow

label

review

block.

Treat AI detection as probabilistic evidence, not incontrovertible proof.

---

# 35. DEEPFAKE DETECTION

Support image/video deepfake providers.

Store:

provider

model/version

confidence

faces/regions where available.

Use configurable action thresholds.

Display uncertainty clearly.

---

# 36. C2PA / CONTENT CREDENTIALS

Implement Content Credentials inspection using maintained C2PA tooling where technically feasible.

Surface:

credential present

credential absent

signature valid/invalid

issuer

assertions

editing history

AI-generation declarations

provenance data.

Never classify “no credential” as “fake.”

---

# 37. VIDEO MODERATION

Build asynchronous video processing.

Support:

frame sampling

adaptive sampling

scene-change sampling

visual moderation

OCR

QR detection

weapons

nudity

violence

drugs

hate

self-harm

logos

AI/deepfake checks.

Configurable maximum duration and file size.

---

# 38. VIDEO AUDIO MODERATION

Extract or process audio safely.

Pipeline:

audio
→ transcription
→ language detection
→ text moderation.

Combine audio and visual findings into the same normalized result.

---

# 39. AUDIO MODERATION

Support allowed formats such as:

MP3

WAV

M4A

OGG

according to environment capabilities.

Provide:

speech transcription

text moderation

optional audio event classification adapters.

---

# 40. CONTEXT-AWARE POLICY ENGINE

The Policy Engine is the heart of the system.

AI scanners provide signals.

The Policy Engine makes decisions.

Rules must be able to use:

content category

confidence

file type

MIME

file size

dimensions

upload context

post type

taxonomy/category

user

role

trust level

site ID

network ID

scanner result

malware result

PII findings

OCR text

URL/domain findings

AI-generated score

deepfake score

C2PA state

duplicate state

custom signals.

---

# 41. RULE BUILDER

Support:

AND

OR

NOT

nested groups

comparison operators

numeric ranges

set inclusion

regex where safe

domain matches

roles

contexts.

Example semantic rule:

IF
explicit_nudity >= 0.85
AND
context = avatar
THEN
BLOCK
AND NOTIFY

Rules need:

stable IDs

priority

enabled state

description

version

test fixtures.

---

# 42. POLICY DECISIONS

Core decision actions:

ALLOW

WARN

SANITIZE

REVIEW

QUARANTINE

BLOCK

NOTIFY

RATE_LIMIT

DISABLE_UPLOAD_PRIVILEGE

CREATE_FINGERPRINT

UNPUBLISH_ASSOCIATED_CONTENT

ESCALATE.

Dangerous/destructive actions must be explicitly configurable.

---

# 43. CONFIDENCE BANDS

Do not treat classifiers as binary.

Support category-specific bands.

Example:

ALLOW band

REVIEW uncertainty band

BLOCK band.

Thresholds must be configurable per:

provider

content category

policy

upload context

site.

---

# 44. POLICY PRESETS

Provide professionally designed initial presets:

Family Friendly

Corporate

Community

Forum

Marketplace

Classifieds

Dating

Gaming

News / Editorial

Education

Healthcare

Strict UGC

Security Only

Monitor Only

Custom.

Presets must be editable copies rather than immutable magic.

---

# 45. ROLE-BASED POLICIES

Policies may differ for:

Administrator

Editor

Author

Contributor

Subscriber

Guest

custom roles.

Never bypass malware/file-security checks merely because an administrator uploads a file.

---

# 46. USER TRUST LEVELS

Provide configurable trust tiers:

new

normal

trusted

restricted.

Trust may modify content-policy behavior.

Security controls remain independent.

---

# 47. POST-TYPE / TAXONOMY POLICIES

Policies may target:

posts

pages

products

reviews

listings

forum topics

forum replies

support tickets

profiles

custom post types

taxonomies

WooCommerce categories

other contextual metadata.

---

# 48. MONITOR / SHADOW MODE

Implement a no-enforcement mode.

Record what WOULD have happened.

Dashboard example:

10,000 scanned

91 would be blocked

183 would be reviewed

9,726 would be allowed.

This must support safe policy rollout.

---

# 49. POLICY SIMULATOR

Provide interactive policy testing.

Input a sample file.

Show:

findings

normalized findings

provider results

risk score

decision

rule(s) triggered

latency

provider cost estimate.

Never publish simulator files.

Clean them safely.

---

# 50. HISTORICAL POLICY SIMULATION

Allow administrators to evaluate a proposed policy against previous scan records where sufficient retained signals exist.

Do not unnecessarily re-send original media.

Show:

allow delta

review delta

block delta

estimated false-positive impact

estimated cost.

---

# 51. QUARANTINE

Quarantine storage must be private.

Do not place quarantined files at guessable public URLs.

Support:

private filesystem

private object storage

integration adapter.

Enforce access using capability-checked authenticated retrieval.

Automatically expire according to retention policy.

---

# 52. MODERATION QUEUE

Create a professional Trust & Safety queue.

Views:

Pending

High Risk

Quarantined

Assigned to Me

Unassigned

Approved

Rejected

Appealed

Scanner Error

SLA Risk.

Each case should expose relevant metadata without visual overload.

---

# 53. SAFE MODERATOR PREVIEW

Potentially disturbing content must be hidden by default where configured.

Provide:

blurred preview

content warning

explicit Reveal action

video autoplay disabled

audio muted

keyboard accessible reveal.

Moderator preferences can control behavior.

Never rely solely on color to indicate risk.

---

# 54. MODERATOR ACTIONS

Support:

approve

reject

delete

quarantine

sanitize

redact

rescan

change classification

override decision

add fingerprint

request resubmission

escalate

assign

add note

suspend upload capability where policy allows.

Require reasons for sensitive overrides where appropriate.

---

# 55. BULK MODERATION

Bulk:

approve

reject

rescan

quarantine

delete

assign

export metadata

change classification.

Protect against accidental destructive operations.

---

# 56. INTERNAL NOTES

Provide audit-trailed moderator notes.

Notes must have author and timestamp.

Do not expose them publicly.

---

# 57. ASSIGNMENT / ESCALATION / SLA

Support:

case owner

team

priority

SLA deadline

escalation

queue reassignment.

Avoid building an unnecessarily huge ticketing platform, but provide adequate enterprise workflow primitives.

---

# 58. APPEALS

Blocked users may be allowed to request manual review.

Track:

original decision

appeal reason

reviewer

final decision

timestamps

decision reason.

---

# 59. USER-FACING ERRORS

Create configurable messages.

Support:

generic safety messages

specific policy messages

custom translation

per-rule override.

Never expose sensitive provider internals or security detection details that would help attackers evade controls.

---

# 60. AUTOMATIC MEDIA REPAIR

Provide safe repair operations where possible:

orientation correction

resize

recompression

format conversion

metadata stripping

CMYK→RGB

animation removal

dimension reduction.

Use WordPress image abstraction where suitable.

Do not modify approved originals unexpectedly.

---

# 61. PROVIDER ABSTRACTION

Create capability-driven provider interfaces.

Potential adapters include:

AWS Rekognition

Google Cloud

Microsoft/Azure services where relevant

Sightengine

Hive

OpenAI moderation where current capabilities match requirements

ClamAV

custom HTTP scanner

self-hosted scanner

CDR provider.

Do not require all providers.

---

# 62. NORMALIZED TAXONOMY

Provider labels must map into stable internal taxonomy IDs.

Example:

`sexual.explicit`

`sexual.suggestive`

`violence.graphic`

`weapon.firearm`

`drug.recreational`

`hate.symbol`

`self_harm.graphic`

`pii.phone`

The UI and policies depend on internal taxonomy, not vendor strings.

---

# 63. PROVIDER CAPABILITY REGISTRY

Every adapter declares capabilities such as:

image moderation

video

OCR

PII

QR

AI detection

deepfake

async jobs

binary upload

URL upload

supported formats

regions

cost metadata

batch support.

Routing uses capabilities rather than `if provider == ...` throughout the codebase.

---

# 64. BYO API KEY

Support customer-owned credentials.

Secrets must be:

masked

capability protected

excluded from logs

excluded from support exports.

Support environment/wp-config configuration.

---

# 65. MANAGED CREDITS ARCHITECTURE

Design a provider gateway abstraction that can later support a commercial SaaS credit system.

Do not tightly couple core plugin security to licensing infrastructure.

---

# 66. MULTI-PROVIDER ROUTING

Optimize accuracy/cost.

Example:

cheap/local checks
→ cached fingerprint
→ first provider
→ confident?
YES → decision
NO → secondary provider
→ consensus/review.

Do not send every upload to every provider by default.

---

# 67. PROVIDER CONSENSUS

Support configurable ensemble policies.

Example:

two-provider agreement

majority vote

weighted confidence

uncertainty → human review.

Record individual signals for explainability.

---

# 68. PROVIDER FALLBACK

Implement:

timeouts

fallback order

circuit breakers

health state

exponential backoff with jitter

rate-limit handling.

Do not retry permanent failures.

---

# 69. FAILURE MODES

Administrators choose:

FAIL OPEN

FAIL CLOSED

QUARANTINE.

Allow different failure policy by context.

Security/malware may use stricter behavior than low-risk moderation.

---

# 70. PROVIDER COST CONTROL

Track:

requests

tokens/units if relevant

estimated monetary cost

cache savings

provider latency

failures.

Support:

monthly request caps

monthly budget

warnings

provider disable threshold

per-user limits

per-site limits.

---

# 71. SCAN CACHE

Cache by safe composite key such as:

content fingerprint

scanner family

provider/model

taxonomy version

policy-relevant signal version.

Policy decisions and scan results are different concepts.

A policy change should not require rescanning if retained normalized findings remain valid.

---

# 72. SMART IMAGE PREPARATION

Perform cheap local processing before remote moderation.

Do not send a 30 MB image if a safe reduced derivative provides equivalent moderation value.

Use:

temporary copy

metadata stripping

safe decode/re-encode where required

dimension reduction

provider-supported format conversion.

Never unexpectedly degrade the user's accepted original.

---

# 73. SYNCHRONOUS / ASYNCHRONOUS ROUTING

Use synchronous processing for small/latency-sensitive cases where feasible.

Use asynchronous processing for:

video

large PDFs

audio

archives

expensive multi-provider checks

bulk historical scans.

Async uploads remain private/quarantined until approved.

---

# 74. BACKGROUND QUEUE

Implement a robust queue abstraction.

Requirements:

persistent jobs

idempotency keys

leases/locks

timeouts

retries

dead-letter state

priority

concurrency control

backpressure

progress.

Support a standalone database-backed default.

Allow adapters for established schedulers where appropriate.

WP-Cron may trigger jobs on ordinary sites but must not be treated as a guaranteed real-time scheduler.

Provide WP-CLI/system-cron worker execution for high-scale sites.

---

# 75. EXISTING MEDIA LIBRARY SCANNER

Scan:

all media

selected media

specific dates

specific authors

specific MIME types

specific post types

unscanned items

previously flagged items.

Use paginated/batched jobs.

Must resume safely after failure.

---

# 76. SCHEDULED RESCAN

Support:

daily

weekly

monthly

custom schedule.

Re-evaluate when:

provider models change

policies change

block fingerprints change

security intelligence changes.

Avoid unnecessary external rescans.

---

# 77. POLICY CHANGE RE-EVALUATION

When policy changes, determine whether existing normalized signals are sufficient.

If yes:

re-run policy only.

If no:

schedule rescan.

Explain expected cost before large rescans.

---

# 78. MEDIA LIBRARY INTEGRATION

Add useful columns/filtering:

Moderation Status

Risk

Security Status

Policy

Last Scan.

Avoid slowing normal Media Library queries.

Use indexed data and lazy details.

---

# 79. ATTACHMENT DETAILS

Display:

overall state

risk

primary findings

malware status

privacy status

metadata action

policy

scan date

provider summary

review link.

Do not dump raw provider JSON into ordinary UI.

Provide advanced technical details separately.

---

# 80. ANALYTICS

Dashboard metrics:

uploads

scans

allowed

sanitized

reviewed

quarantined

blocked

appeals

overrides

violations by type

risk distribution

provider usage

provider cost

provider latency

failure rate

queue depth

review time

upload source

policy

site

user trust group.

---

# 81. FALSE-POSITIVE / FALSE-NEGATIVE ANALYTICS

Track human disagreement.

Examples:

AI BLOCK → HUMAN APPROVE

AI ALLOW → LATER MODERATOR REMOVE.

Produce per-category and per-provider metrics.

Never claim a false-negative rate that cannot be measured from an appropriate labeled sample.

---

# 82. MODERATION QUALITY PROGRAM

Create benchmark infrastructure.

Metrics must include at minimum:

precision

recall

F1 where useful

false-positive rate

false-negative rate

coverage

uncertainty rate

human escalation rate.

Evaluate per category.

Do NOT use one generic “accuracy” number.

For automatic hard-blocking, prioritize very high precision.

Initial design target:

critical hard-block categories should aim for >=99.5% precision on a representative validated benchmark before broad automatic enforcement.

If the benchmark cannot establish that level:

send uncertain cases to REVIEW rather than pretending certainty.

For critical content, configure review bands to maximize recall.

These are engineering targets, not marketing claims.

---

# 83. CALIBRATION

Confidence values from different providers are not automatically comparable.

Build per-provider/per-category calibration support.

Persist calibration version.

Support threshold tuning through benchmark results.

---

# 84. HUMAN FEEDBACK

Store human overrides as evaluation evidence.

Do NOT automatically train or modify classifiers from user content.

Feedback may inform:

threshold recommendations

policy tuning

provider evaluation.

---

# 85. MODEL DRIFT

Track changes by:

provider

model version

category

time.

Detect meaningful movement in:

block rate

review rate

human disagreement

confidence distributions.

Alert administrators when appropriate.

---

# 86. MODERATOR ANALYTICS

Enterprise metrics:

review throughput

median review duration

queue backlog

SLA violations

override rate

escalation rate.

Do not encourage harmful worker surveillance; focus metrics on operational queue health.

---

# 87. ABUSE ANALYTICS

Detect patterns such as:

repeated prohibited uploads

duplicate prohibited content

new-account bursts

high rejection rate

API-cost abuse

provider probing

repeated borderline content.

Policies may rate-limit offenders.

---

# 88. ANOMALY ALERTS

Example:

sexual-content violation volume increased 800% within 30 minutes.

Use robust thresholds and avoid notification spam.

---

# 89. NOTIFICATIONS

Support:

WordPress admin

email

webhook

Slack-compatible webhook

Mattermost-compatible webhook

Discord-compatible webhook.

Events:

high-risk content

malware

provider outage

queue backlog

budget threshold

repeated offender

SLA breach.

---

# 90. WEBHOOKS

Provide signed outgoing webhooks.

Events should be versioned.

Implement retries and idempotent event IDs.

Do not send raw prohibited media in webhook payloads.

---

# 91. REST API

Provide versioned REST endpoints for appropriate operations:

policies

queue

scan results

analytics

health

provider status

approve

reject

rescan

simulation.

Use controller classes.

Every endpoint requires appropriate `permission_callback`.

Validate and sanitize request arguments.

Do not use nonces as authorization.

---

# 92. WP-CLI

Implement useful commands:

scan attachment

scan library

rescan policy

worker run

queue status

provider test

health

policy export/import

database status

diagnostics.

Support script-friendly exit codes.

---

# 93. DEVELOPER EXTENSIBILITY

Provide documented actions/filters/interfaces for:

scanner registration

provider registration

taxonomy extension

context resolution

policy signals

decision modification where safe

notifications

quarantine backends

custom actions.

Keep hooks stable and versioned.

---

# 94. CUSTOM MODERATION RULES

Allow businesses to define custom forbidden signals such as:

competitor brand names

Telegram usernames

telephone numbers

specific domains

custom OCR phrases

logo presence

custom provider result.

---

# 95. WORDPRESS ECOSYSTEM INTEGRATIONS

Design explicit adapters/tests where practical for major systems including:

BuddyPress

BuddyBoss

bbPress

PeepSo

WooCommerce

Dokan

WCFM

Gravity Forms

WPForms

Contact Form 7

Formidable Forms

Fluent Forms

Ninja Forms

Elementor Forms

ACF

Meta Box

popular media-offload solutions

remote import flows.

Do not activate heavy compatibility code unless corresponding plugins exist.

---

# 96. MULTISITE

Support:

network defaults

network-enforced policies

site-specific policies

network analytics

per-site provider credentials where allowed

centralized audit

site isolation.

Prevent cross-blog data leakage.

---

# 97. AGENCY / CENTRAL MANAGEMENT

Architect optional central-control capabilities:

multiple sites

health state

pending moderation counts

budget state

provider failures

policy distribution

configuration templates.

Do not make basic standalone installations depend on cloud control.

---

# 98. AUDIT LOG

Audit important operations:

upload receipt

scanner invocation

findings

decision

rule trigger

quarantine

publication

human override

assignment

policy modification

provider credential modification

settings change

appeal decision.

Include:

actor

timestamp

object

event

metadata

policy version.

Protect audit integrity.

---

# 99. POLICY VERSIONING

Policies are versioned immutable snapshots after activation.

Editing creates a new version.

Every decision records the version used.

Provide compare/diff.

---

# 100. PROVIDER / MODEL VERSION TRACKING

Record provider and model/schema version wherever available.

Avoid caching incompatible old results indefinitely.

---

# 101. PRIVACY CONTROLS

Allow control of data sent externally:

original file

resized derivative

metadata-stripped derivative

filename

user identifier

site identifier.

Default to data minimization.

Never transmit information unrelated to scanning.

---

# 102. RETENTION

Configurable retention per data class:

safe scan metadata

blocked scan metadata

OCR text

quarantine files

audit events

analytics

provider raw responses.

Default to not retaining prohibited media longer than operationally necessary.

Implement scheduled cleanup.

---

# 103. WORDPRESS PRIVACY TOOLS

Integrate with WordPress privacy export/erasure mechanisms where applicable.

Clearly distinguish audit/security retention obligations.

---

# 104. DATA RESIDENCY

Represent supported processing regions in provider capability metadata.

Allow enterprise policies requiring specific region.

Do not claim residency guarantees unsupported by a provider.

---

# 105. PRIVACY DISCLOSURE

Provide administrator guidance for privacy-policy disclosures regarding third-party scanning.

Generate a suggested disclosure.

Do not present generated text as legal advice.

---

# 106. SECRET MANAGEMENT

Prefer environment / `wp-config.php` secrets for advanced production deployments.

If database storage is supported:

protect access

mask output

avoid logs

use defensible encryption/key derivation

document limitations.

Never place credentials in JavaScript.

---

# 107. RBAC

Create granular capabilities such as:

`manage_content_firewall`

`manage_content_firewall_policies`

`manage_content_firewall_providers`

`review_content_firewall_queue`

`reveal_sensitive_content`

`view_content_firewall_audit`

`view_content_firewall_analytics`

`manage_content_firewall_integrations`.

Do not check hardcoded role names when a capability check is appropriate.

---

# 108. RATE LIMITING

Support limits by:

user

IP where appropriate

role

site

API client

time window.

Use scalable storage.

Protect external provider budgets.

---

# 109. COST-ABUSE PROTECTION

A malicious uploader must not be able to consume unlimited paid API quota.

Use:

preflight checks

authentication

rate limits

per-user quota

file limits

duplicate cache

cheap-first processing

provider budgets.

---

# 110. RESOURCE-EXHAUSTION PROTECTION

Enforce limits BEFORE expensive processing:

input bytes

image pixels

PDF pages

video duration

archive uncompressed bytes

archive nesting

SVG nodes

OCR size

document object counts where practical.

Fail safely.

---

# 111. SYSTEM HEALTH

Add Site Health integration and dedicated dashboard.

Show:

database status

queue health

worker age

provider health

malware scanner

quarantine

cron

filesystem

ImageMagick/GD

temporary directory

REST availability

webhook health

current latency

error rate.

---

# 112. SELF-DIAGNOSTICS

Provide safe buttons/tools for:

provider test

malware scanner test

quarantine test

queue test

webhook test

image-processing test

database integrity test.

Tests must not leak secrets.

---

# 113. DIAGNOSTIC EXPORT

Generate support bundle containing:

WordPress version

PHP version

database type/version

plugin version

enabled modules

provider names

queue metrics

feature flags

relevant non-sensitive configuration

recent sanitized errors.

Exclude:

credentials

PII

OCR text

raw uploads

prohibited images.

---

# 114. CONFIG IMPORT / EXPORT

Allow policies/configuration to be exported as versioned JSON.

Validate schemas.

Do not import secrets by default.

---

# 115. ENVIRONMENT AWARENESS

Support:

development

staging

production.

Example:

development → provider mocks

staging → monitor mode

production → enforcement.

Do not infer environment solely from domain name.

Use WordPress environment mechanisms/configuration.

---

# 116. CHILD-SAFETY INTEGRATIONS

Treat this as a specialized enterprise integration domain.

Do not claim ordinary nudity classifiers can legally determine CSAM.

Allow adapters to approved/specialized services and hash systems when lawfully available.

Use:

restricted moderator capability

strict audit

special retention

special escalation.

Never bundle illegal material as test fixtures.

Never create unsafe datasets.

---

# 117. COPYRIGHT / KNOWN-CONTENT FINGERPRINTS

Allow organization-maintained:

exact hash lists

perceptual hash lists

known prohibited content lists.

Respect licensing/legal requirements of external databases.

---

# 118. LOGO / BRAND DETECTION

Provide provider abstraction for:

logos

brands

competitors

organization marks.

Policies may review/block.

---

# 119. WATERMARK / CONTACT DETECTION

Combine OCR + image analysis to find:

website names

telephone numbers

social handles

WhatsApp/Telegram identifiers

competitor marks

watermarks.

Useful for marketplaces/classifieds.

---

# 120. CORRECTIVE UX

Where policy allows, prefer helpful remediation over unexplained rejection.

Example:

“We detected a telephone number in this listing image.”

Actions:

Replace image

Automatically redact

Request review.

---

# 121. FRONTEND SCAN STATUS

Expose accessible upload progress/status:

Uploading

Security check

Content check

Pending review

Approved

Rejected.

Do not expose detailed bypass-helping signals to untrusted uploaders.

---

# 122. ATTACHMENT STATUS DATA

Expose a stable summarized state for integrations.

Potential fields:

moderation state

security state

risk level

policy ID/version

scan timestamp.

Avoid storing huge raw results in attachment postmeta.

---

# 123. PUBLICATION GATE

If content references unapproved attachments, optionally prevent publication until scan completion.

Return understandable errors.

Handle autosaves safely.

---

# 124. LATER RECLASSIFICATION

If future rescanning changes an attachment from approved to prohibited:

configurable responses:

notify only

quarantine media

replace media

unpublish related content

escalate.

Never silently remove large amounts of public content without explicit policy.

---

# 125. ALLOWLISTS / BLOCKLISTS

Support:

hash allowlist

hash blocklist

domain allowlist

domain blocklist

user moderation exemptions

taxonomy exceptions

MIME allowlist.

Security/malware scanning must not be disabled merely because an uploader is trusted.

---

# 126. COMPOSITE RISK SCORE

Provide an optional normalized risk score.

The score may include:

moderation confidence

security findings

PII

user trust

duplicate risk

QR/URL findings

provider disagreement.

Do not hide actual rule decisions behind one opaque number.

Rules remain explainable.

---

# 127. EXPLAINABILITY

Every moderator/admin decision view must explain:

decision

reason(s)

detected category

confidence

rule

policy/version

provider/model

security findings

relevant contextual factors.

Example:

BLOCKED

Explicit sexual content: 0.94

Rule: SEXUAL-AVATAR-001

Policy: Community v7

Provider: ExampleProvider / model X

Timestamp: ...

---

# 128. DATABASE DESIGN

Design dedicated tables for high-volume operational data rather than overusing postmeta/options.

Expected logical datasets include:

scans

findings

decisions

policies

policy versions

rules

queue jobs

quarantine records

moderation cases

appeals

audit events

provider usage

fingerprints

notifications/events

accuracy/evaluation data.

Use WordPress table prefix.

Support multisite appropriately.

Use deliberate indexes for:

attachment/object

status

created_at

policy

user

site

queue due time

provider

hash

risk

assignment.

Use schema versioning and safe migrations.

Avoid table scans in normal admin screens.

---

# 129. DATABASE PERFORMANCE RULES

Before merging each major query:

inspect query plan when possible.

Do not use:

unbounded result sets

`SELECT *` unnecessarily

N+1 admin queries

huge `IN` clauses without consideration

unindexed queue polling.

Use keyset pagination where helpful for very large tables.

Do not load thousands of records merely to display summary counts.

---

# 130. PERFORMANCE BUDGET

Create benchmarkable budgets.

Suggested starting targets, subject to real measurement:

Local lightweight upload preflight:

p95 < 50 ms for ordinary files.

Plugin routing/decision overhead excluding external services:

p95 < 100 ms.

Synchronous ordinary image moderation:

target p95 additional user-visible latency <= 1.5 seconds where provider/network permits.

Asynchronous upload/quarantine acknowledgement:

target p95 < 250 ms after upload storage completes.

Common admin REST reads:

p95 server processing < 300 ms.

Large-table filtered queue query:

target < 500 ms at 1M+ operational records with realistic indexes.

Do not falsify compliance if external network conditions make a target impossible.

Report separately:

plugin CPU time

provider latency

network latency

queue delay.

---

# 131. MEMORY PERFORMANCE

Before decoding an image, estimate memory/resource impact from dimensions and format.

Reject dangerous pixel counts before expensive operations.

Stream hashing and file copies.

Do not load entire large files into PHP strings unless required.

Clean temporary files deterministically.

Test low-memory hosting environments.

---

# 132. COST-EFFICIENT SCAN PIPELINE

Recommended conceptual ordering:

1. request authorization/rate limit
2. filename/basic metadata
3. file size/resource bounds
4. true file type
5. hash/cache lookup
6. local security preflight
7. inexpensive local rules
8. safe derivative generation
9. primary moderation provider
10. uncertainty evaluation
11. secondary provider only if required
12. policy engine
13. sanitize/quarantine/publish
14. audit/metrics.

Short-circuit safely.

---

# 133. RELIABILITY ENGINEERING

Implement:

provider timeouts

connection timeouts

retry classification

exponential backoff

jitter

circuit breakers

bulkheads

idempotency

job locks

dead-letter jobs

health checks.

A provider outage must not take down WordPress.

---

# 134. ADMIN UI INFORMATION ARCHITECTURE

Build a high-quality admin product.

Primary navigation:

Dashboard

Moderation Queue

Policies

Media Scanner

Providers

Analytics

Audit Log

Integrations

System Health

Settings

Developer Tools.

Avoid dozens of unrelated WordPress submenu screens.

---

# 135. ONBOARDING UX

First-run wizard:

Welcome

Choose use case/preset

Choose providers

Connect/test provider

Choose failure mode

Choose privacy settings

Choose enforcement mode

Run sample test

Optional existing-library scan

Review configuration

Activate.

Allow skipping and resuming.

---

# 136. DASHBOARD UX

Show meaningful operational information, not decorative charts.

Recommended areas:

system health

recent violations

moderation state

queue backlog

provider health

provider spend

accuracy alerts

top categories

recent critical events.

Use progressive disclosure.

---

# 137. POLICY BUILDER UX

The rule builder is mission-critical.

Requirements:

human-readable conditions

nested AND/OR groups

clear action

inline validation

rule priority

conflict warnings

test rule

simulate rule

duplicate rule

disable rule

version changes

change summary.

Users should not need programming knowledge.

---

# 138. MODERATION QUEUE UX

Optimize for repeated professional work.

Requirements:

fast keyboard navigation

saved filters

bulk selection

assignment

safe previews

clear confidence

rule reason

context

previous uploader behavior where authorized

one-click approve/reject

required rationale where configured

next-item navigation.

---

# 139. ADMIN UI TECHNOLOGY

Prefer WordPress-native UI packages and components where they provide good functionality.

Use WordPress-supplied React where appropriate rather than bundling redundant React runtimes.

Use TypeScript for substantial admin application code.

Use code splitting.

Do not enqueue admin assets on unrelated WordPress pages.

Minimize JavaScript bundle size.

---

# 140. UI DESIGN QUALITY

The interface must feel like a mature security/SaaS product integrated into WordPress.

Prioritize:

clarity

density without clutter

hierarchy

predictable interactions

good empty states

good loading states

good failure states

action confirmations

undo where safe

responsive layouts.

Avoid “settings-page syndrome” consisting of hundreds of checkboxes.

---

# 141. ACCESSIBILITY

Target WCAG AA.

Test:

keyboard

focus management

screen readers

contrast

forms

dialog accessibility

table navigation

status announcements

reduced motion.

Never communicate:

safe

warning

blocked

using color alone.

---

# 142. I18N / RTL

All user-facing text must be translatable.

No string concatenation that prevents translation.

Support RTL layouts.

Test at least:

English LTR

one RTL locale.

Dates/numbers should respect WordPress locale.

---

# 143. SECURITY BASELINE

Apply:

sanitize early

validate strictly

escape late

prepared SQL

capability checks

REST permission callbacks

nonce validation for CSRF when relevant

safe paths

safe filenames

secure temporary files

secure object access.

Remember:

nonce != authorization.

---

# 144. SSRF DEFENSE

Any feature that examines:

QR URLs

remote imports

external media

webhooks

remote scanner callbacks

must be reviewed for SSRF.

Defend against:

localhost

loopback

private ranges

link-local

metadata services

IPv6 private/local

DNS rebinding

redirect chains

alternative IP representations.

Prefer not fetching arbitrary destinations unless essential.

---

# 145. WEBHOOK SECURITY

Incoming callbacks require:

signature validation

timestamp/replay protection

event ID

idempotency

strict parsing.

Outgoing hooks should be signed.

---

# 146. QUARANTINE SECURITY

Quarantine file access:

must require authorization.

Do not expose raw path.

Prevent traversal.

Prevent guessing.

Consider secure streaming or server-assisted private delivery.

---

# 147. MULTISITE TENANT ISOLATION

Test that one site cannot:

read another site's quarantine

read another site's audit data

modify policies without network permission

use another site's credentials unexpectedly.

---

# 148. UNINSTALL / DEACTIVATION

Deactivation:

stop schedules/workers cleanly but preserve data.

Uninstall:

offer explicit data-removal behavior.

Do not unexpectedly delete audit/quarantine data simply because plugin is temporarily deactivated.

---

# 149. MODERATION TEST DATA

Never bundle illegal material.

Never bundle CSAM.

Use:

provider official test fixtures

synthetic fixtures

licensed evaluation datasets

carefully constructed harmless adversarial files

mock provider responses.

For sensitive moderation quality evaluation, document how an organization may supply its own lawful validation corpus without committing it to the repository.

---

# 150. TEST STRATEGY

Implement:

PHP unit tests

WordPress integration tests

database migration tests

REST tests

provider contract tests

queue concurrency tests

frontend unit tests

component tests

E2E browser tests

accessibility tests

security tests

performance tests

failure/chaos tests

multisite tests

RTL tests.

---

# 151. REQUIRED ADVERSARIAL FILE TESTS

Test safely against:

wrong MIME

wrong extension

double extension

truncated image

huge dimensions

tiny compressed huge-pixel image

polyglot-style safe fixtures

deeply nested archive

high compression ratio archive

malformed SVG

SVG script attempt

SVG external resource

malformed PDF

macro-enabled test document

corrupt image

zero-byte file

extremely long filename

Unicode filename

path traversal filename

duplicate file

near duplicate

provider timeout

provider 429

provider 500

malformed provider response.

---

# 152. SECURITY TESTS

Test for:

CSRF

XSS

stored XSS

REST authorization

IDOR

SQL injection

SSRF

path traversal

unsafe deserialization

credential leakage

log injection

webhook replay

privilege escalation

multisite isolation

rate-limit bypass

queue race conditions.

---

# 153. ML / POLICY TESTS

Build deterministic mocked provider responses covering:

clear safe

clear block

threshold boundary

provider disagreement

unknown category

missing confidence

provider timeout

provider schema change

multiple findings

context-specific decisions

review band.

Policy tests must prove exact rule evaluation.

---

# 154. PERFORMANCE TESTS

Benchmark:

100 media records

10K

100K

1M+ scan records.

Measure:

DB query time

REST latency

memory

worker throughput

hashing speed

image preparation

cache effectiveness

admin UI rendering.

Prevent performance regression with CI thresholds where practical.

---

# 155. PROVIDER CONTRACT TESTS

Each provider adapter must test:

authentication format

request generation

supported media

response parser

error mapping

rate limiting

timeouts

model/version handling.

Mock by default.

Enable live contract suite only when credentials are supplied.

---

# 156. FRONTEND E2E TESTS

Cover:

onboarding

policy creation

policy simulation

moderation review

bulk actions

provider failure

appeals

system health

media attachment panel

existing-library scan.

---

# 157. ACCESSIBILITY AUTOMATION

Use automated accessibility testing where possible, but also document manual checks for:

screen reader flow

keyboard-only usage

focus restoration

sensitive preview reveal.

---

# 158. STATIC ANALYSIS / CODE QUALITY

Configure appropriate tools such as:

PHP_CodeSniffer with WordPress standards

PHPStan/Psalm where appropriate

ESLint

TypeScript strictness

style checks

test coverage.

Do not mechanically obey a style rule if doing so creates incorrect code; document justified exceptions.

---

# 159. CI/CD

Create CI pipeline covering:

Composer validation

PHP matrix

supported WordPress matrix

lint

coding standards

static analysis

PHPUnit

frontend tests

build

E2E where feasible

security/dependency scanning

package verification.

Create reproducible release package.

Exclude development files.

---

# 160. DEPENDENCY SECURITY

Minimize dependencies.

Pin/lock appropriately.

Monitor vulnerabilities.

Generate dependency inventory/SBOM if practical.

Avoid abandoned parsing libraries for untrusted file formats.

---

# 161. WORDPRESS PLUGIN REVIEW COMPATIBILITY

Audit against current WordPress plugin-directory requirements if public distribution is intended.

Use WordPress uploader APIs appropriately.

Do not require unsafe global constants such as unfiltered upload enablement.

Do not ship telemetry without transparent consent/policy.

---

# 162. PRIVACY-FIRST TELEMETRY

If product telemetry is implemented:

opt in where required

document exactly what is sent

never send uploaded file content unless specifically part of configured moderation provider behavior

never send PII accidentally.

Core plugin must function without product analytics telemetry.

---

# 163. OBSERVABILITY

Provide structured logs.

Useful dimensions:

request/scan ID

job ID

policy

rule

provider

duration

result

retry

site ID.

Do not log:

credentials

raw PII

full extracted sensitive text

raw prohibited media.

---

# 164. CORRELATION IDs

Every upload lifecycle gets a stable correlation identifier.

Allow support engineers to trace:

upload

queue jobs

provider calls

policy decision

human review

notifications.

---

# 165. ERROR MODEL

Create stable internal error codes.

Example categories:

VALIDATION

SECURITY

PROVIDER

QUEUE

STORAGE

POLICY

DATABASE

CONFIGURATION.

User-facing messages should not depend directly on raw exception strings.

---

# 166. FEATURE FLAGS

All major modules should support controlled rollout.

Examples:

video

audio

CDR

deepfake

C2PA

advanced analytics

agency features.

Feature flags are operational controls, not substitutes for unfinished implementation.

---

# 167. COMMERCIAL READINESS

Architect licensing separately from security logic.

Never make an expired license silently disable mandatory security and allow unsafe content.

If premium scanning becomes unavailable, enter a defined safe failure mode and alert the administrator.

---

# 168. DOCUMENTATION

Produce:

installation guide

quick-start

provider guides

policy guide

moderation guide

security architecture

privacy guide

developer guide

hooks/reference

REST API documentation

WP-CLI reference

database schema

operations/runbook

troubleshooting

performance tuning

multisite guide

provider outage guide

migration guide.

---

# 169. DEVELOPER API DOCUMENTATION

Generate examples for:

adding a scanner

adding a taxonomy category

adding a custom policy condition

adding a decision action

listening to scan completion

changing quarantine storage

querying moderation state.

---

# 170. OPENAPI / API SCHEMAS

Document REST API with machine-readable schema where practical.

Ensure implementation and documentation remain synchronized.

---

# 171. RELEASE MIGRATIONS

Database upgrades must be:

versioned

repeatable

safe on failure where possible

tested from multiple previous versions.

Do not run huge blocking migrations during ordinary frontend traffic.

Large transformations should use background batches.

---

# 172. BACKWARD COMPATIBILITY

Establish a public API stability policy.

Do not break stored policies silently.

Migrate schemas explicitly.

Deprecate hooks/interfaces before removal.

---

# 173. PRODUCT PERFORMANCE PRINCIPLE

Performance is a product feature.

At every milestone ask:

Can this operation happen later?

Can it be cached?

Can it be skipped?

Can it use an existing result?

Can it process a smaller derivative?

Can it be batched?

Can a query use an index?

Can browser code be lazy-loaded?

Can a provider call be avoided?

---

# 174. MODERATION ACCURACY PRINCIPLE

Minimizing errors is more important than creating the appearance of automation.

Never force uncertain content directly into BLOCK merely to make the system look decisive.

Use:

confidence bands

context

secondary provider checks

calibration

human review.

---

# 175. UX PRINCIPLE

Administrators should understand:

what happened

why it happened

what they can do

what the consequences are.

Avoid exposing 500 low-level settings at once.

Use:

presets

progressive disclosure

sensible defaults

advanced sections

simulation.

---

# 176. SECURITY PRINCIPLE

The content scanning engine itself processes malicious input.

Therefore the scanner pipeline is part of the attack surface.

Prefer isolation for dangerous parsers.

Set:

resource limits

timeouts

process boundaries where appropriate.

Do not trust third-party parsing libraries merely because they are popular.

---

# 177. IMPLEMENTATION MILESTONES

Execute sequentially.

## Milestone 0 — Discovery and Foundations

Inspect repository.

Research current official APIs.

Create traceability matrix.

Create architecture.

Create threat model.

Choose support matrix.

Set up CI/testing/static analysis.

## Milestone 1 — Upload Gateway

Implement interception.

File descriptor.

Contexts.

State machine.

MIME/type validation.

Resource limits.

Basic persistence.

## Milestone 2 — Policy Engine

Implement taxonomy.

Rules.

Conditions.

Decisions.

Policy versions.

Simulation engine.

## Milestone 3 — Image Moderation

Implement provider architecture.

Primary image providers.

Normalization.

Thresholds.

Caching.

Image preparation.

## Milestone 4 — Quarantine and Human Review

Private quarantine.

Queue.

Moderation UI.

Assignments.

Overrides.

Appeals.

Audit.

## Milestone 5 — OCR / PII / QR / Privacy

OCR.

Text moderation.

PII.

QR.

redaction.

metadata stripping.

## Milestone 6 — File Security

ClamAV.

archives.

SVG.

PDF.

Office.

CDR abstraction.

## Milestone 7 — Authenticity / Fingerprinting

exact hashes.

perceptual hashes.

known-content lists.

AI-generated detection.

deepfake.

C2PA.

## Milestone 8 — Video / Audio

async video.

frames.

audio extraction.

transcription.

multimodal aggregation.

## Milestone 9 — Analytics / Accuracy

dashboards.

provider analytics.

false-positive evaluation.

calibration.

drift.

abuse analytics.

## Milestone 10 — Integration Platform

REST.

webhooks.

WP-CLI.

developer hooks.

WooCommerce/community/form adapters.

## Milestone 11 — Multisite / Agency / Enterprise

network policies.

central management primitives.

data residency.

SLA workflow.

advanced DLP.

## Milestone 12 — Hardening and Release

performance benchmarks.

security audit.

adversarial testing.

accessibility audit.

RTL.

migration testing.

packaging.

documentation.

release candidate.

---

# 178. MILESTONE EXIT GATE

A milestone is not complete unless:

implementation exists

unit tests pass

integration tests pass

security review completed

performance reviewed

UX reviewed where relevant

documentation updated

traceability updated

no known P0/P1 defect remains.

Do not postpone critical issues to “later cleanup.”

---

# 179. REVIEW PASSES AFTER EVERY MILESTONE

Run these separate reviews.

## WordPress Architecture Review

Check hooks, lifecycle, compatibility, APIs.

## Security Review

Attempt bypass and privilege escalation.

## Performance Review

Inspect memory, queries, remote calls.

## ML Quality Review

Inspect normalization, thresholds, uncertainty.

## UX Review

Inspect flow, cognitive load, errors.

## Accessibility Review

Inspect AA requirements.

## QA Review

Find missing edge cases.

Fix discovered issues before proceeding.

---

# 180. FINAL SYSTEM ACCEPTANCE

Before claiming completion, demonstrate:

all requirements mapped

all modules implemented

all migrations tested

all tests passing

supported WordPress versions tested

supported PHP versions tested

no critical static-analysis failures

no known critical/high security vulnerability

performance benchmark report

moderation benchmark framework

provider failure behavior

quarantine security

multisite isolation

accessible admin workflows

RTL rendering

documentation

release artifact.

---

# 181. FINAL OUTPUT PACKAGE

Deliver:

production plugin source

release ZIP

Composer files

frontend package files

CI configuration

database schema/migrations

automated tests

architecture documentation

ADRs

threat model

privacy model

provider capability matrix

performance benchmark report

moderation-quality report

UX specification

REST documentation

developer hooks documentation

WP-CLI documentation

operator runbook

installation documentation

upgrade documentation

release notes.

---

# 182. FINAL REPORT

At completion provide a concise engineering release report containing:

Implemented features

Known limitations

Supported environments

Providers implemented

Security review result

Performance results

Moderation-quality methodology

Accessibility status

Test summary

Database migration status

Operational requirements

Recommended production configuration

Remaining non-blocking future improvements.

Do not claim perfection.

Clearly distinguish:

tested

implemented but environment-dependent

requires external provider credentials

future optional enhancement.

---

# 183. WORKING BEHAVIOR

Do not repeatedly narrate trivial actions.

Surface important findings when discovered.

Examples:

architectural incompatibility

security vulnerability

performance bottleneck

provider limitation

WordPress compatibility issue

false-positive problem.

Fix issues instead of merely documenting them when correction is within project scope.

---

# 184. PRIORITY ORDER WHEN TRADE-OFFS CONFLICT

Use this ordering:

1. Security / prevention of unsafe execution
2. Data integrity
3. Privacy
4. Moderation correctness
5. Reliability
6. User safety
7. Performance
8. User experience
9. Cost efficiency
10. Developer convenience

However, do not use this order as justification for obviously poor UX or inefficient architecture.

Seek designs that satisfy multiple goals simultaneously.

---

# 185. START NOW

Begin with:

1. repository inspection;
2. environment inventory;
3. current official documentation verification;
4. requirements traceability file;
5. architectural baseline;
6. threat model;
7. support matrix;
8. implementation.

Do not stop after writing the architecture.

Continue through the milestones systematically until the production-ready plugin is complete.