"""Generate an exhaustive source ledger; implementation evidence is curated separately."""
from pathlib import Path
import re, json, sys

source = Path(sys.argv[1]).read_text()
Path('docs/SOURCE-REQUIREMENTS.md').write_text(source)
sections = re.split(r'^# (\d+)\. (.+)$', source, flags=re.M)
mapping = {
    'domain': ('src/Domain', 'tests/Unit/PolicyTest.php', 'docs/ARCHITECTURE.md'),
    'policy': ('src/Policy', 'tests/Unit/PolicyTest.php', 'docs/MODERATION-QUALITY.md'),
    'security': ('src/Security', 'tests/Security/FileSecurityTest.php', 'docs/THREAT-MODEL.md'),
    'provider': ('src/Providers', 'tests/Contract/ProviderTest.php', 'docs/PROVIDER-MATRIX.md'),
    'privacy': ('src/Privacy', 'tests/Unit/PrivacyAndQualityTest.php', 'docs/PRIVACY.md'),
    'queue': ('src/Queue', 'tests/Integration/run.php', 'docs/OPERATIONS.md'),
    'wordpress': ('src/WordPress', 'tests/Integration/run.php', 'docs/COMPATIBILITY.md'),
    'ui': ('src/Admin; assets/src', 'tests/E2E/admin.spec.ts', 'docs/UX-SPEC.md'),
    'data': ('src/Persistence', 'tests/Integration/run.php', 'docs/DATA-MODEL.md'),
    'analytics': ('src/Analytics', 'tests/Unit/PrivacyAndQualityTest.php', 'docs/MODERATION-QUALITY.md'),
}
unimplemented = {34,35,65,82,83,85,87,88,95,97,104,116,118,119,124,167}
rows=[]
for i in range(1,len(sections),3):
    number,title,body=int(sections[i]),sections[i+1],sections[i+2]
    group='domain'
    if 40<=number<=50 or number in {77,94,99,114,125}: group='policy'
    if 22<=number<=30 or 143<=number<=147 or number in {110,176}: group='security'
    if 10<=number<=17 or 34<=number<=39 or 61<=number<=72 or number in {100,104,118,155}: group='provider'
    if 18<=number<=21 or 101<=number<=106 or number in {102,103,162}: group='privacy'
    if 51<=number<=58 or 73<=number<=76 or number in {133}: group='queue'
    if number in {9,78,79,91,92,93,95,96,107,111,112,113,115,121,122,123,124,148,161}: group='wordpress'
    if 134<=number<=142 or number in {53,54,55,56,57,58,120,156,157,175}: group='ui'
    if 128<=number<=129 or number in {98,171,172}: group='data'
    if 80<=number<=88 or number in {126}: group='analytics'
    module,tests,docs=mapping[group]
    if number == 49: module,tests,docs='src/Application/FileSimulator.php; src/Application/ScanService.php; assets/src/simulation.tsx','tests/Integration/simulation.php; tests/E2E/admin.spec.ts','docs/REST.md'
    if number in {121,122}: module,tests,docs='src/Application/HeadlessUpload.php; src/REST/Controller.php','tests/Integration/headless.php; tests/E2E/admin.spec.ts','docs/REST.md'
    if number == 123: module,tests,docs='src/WordPress/PublicationGate.php','tests/Integration/publication-gate.php; tests/Integration/hardening.php','docs/OPERATIONS.md'
    if number == 36: module,tests,docs='src/Authenticity/ContentCredentials.php','tests/Unit/ProvenanceTest.php; tests/Integration/provenance-tools.php','docs/MEDIA-PROCESSING.md'
    if number in {37,38,39}: module,tests,docs='src/Media/TemporalMedia.php; src/Providers/OpenAiTranscription.php','tests/Integration/media-tools.php; tests/Integration/processing.php; tests/Contract/TranscriptionTest.php','docs/MEDIA-PROCESSING.md'
    if number == 135: module,tests,docs='src/Application/Onboarding.php; assets/src/workflows.tsx','tests/Integration/workflows.php; tests/E2E/admin.spec.ts','docs/UX-SPEC.md'
    if number in {102,103,162}: module,tests,docs='src/Privacy/RecordLifecycle.php; src/WordPress/PrivacyTools.php; src/Application/Retention.php','tests/Integration/privacy.php','docs/PRIVACY.md'
    if number == 166: module,tests,docs='src/Configuration/Settings.php; src/Bootstrap/Services.php','tests/Unit/SettingsTest.php; tests/Integration/processing.php','docs/MEDIA-PROCESSING.md'
    status='Not implemented' if number in unimplemented else 'Partial; see evidence'
    if number<7 or number>=177: status='Process / release obligation; open'
    ui='Admin console' if group=='ui' or number in {91,111,112,113,114} else 'API / deployment / module'
    items=[line.strip().lstrip('- ').replace('|','/') for line in body.splitlines() if line.strip() and line.strip()!='---']
    # One section-level row plus each original statement/item; no claims inferred from headings.
    for j,feature in enumerate([title]+items):
        rows.append({'id':f'CF-{number:03d}-{j:03d}','section':number,'feature':feature,'status':status,'source':module,'tests':tests,'ui':ui,'documentation':docs,'acceptance':'OPEN'})
header='# Requirements traceability\n\nEvery source statement is retained below with a stable ID. Related module/test paths indicate partial evidence, not full feature coverage. Current capabilities and limitations are maintained in MEDIA-PROCESSING.md, PRIVACY.md, UX-SPEC.md and RELEASE-STATUS.md. All section acceptance gates remain open until the entire listed behavior is validated. SOURCE-REQUIREMENTS.md preserves the complete user specification. RELEASE-STATUS.md identifies release blockers.\n\n'
header+='| ID | Feature / source statement | Implementation status | Source module | Tests / evidence | UI | Documentation | Acceptance |\n|---|---|---|---|---|---|---|---|\n'
for row in rows:
    feature=row['feature'].replace('`','').replace('<','&lt;').replace('>','&gt;')
    header+=f"| {row['id']} | {feature} | {row['status']} | {row['source']} | {row['tests']} | {row['ui']} | {row['documentation']} | OPEN |\n"
Path('docs/REQUIREMENTS-TRACEABILITY.md').write_text(header)
Path('docs/requirements.json').write_text(json.dumps(rows,indent=2,ensure_ascii=False)+'\n')
print(f'Indexed {len(rows)} statements across {(len(sections)-1)//3} sections; no completion claims.')
