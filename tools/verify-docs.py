"""Check repository documentation links, schema counts and requirement evidence paths."""
from pathlib import Path
import json
import re
import sys
from urllib.parse import unquote

root = Path(__file__).resolve().parents[1]
errors = []
documents = sorted(root.glob("*.md")) + sorted((root / "docs").rglob("*.md"))
for document in documents:
    for target in re.findall(r"\[[^\]]*\]\(([^)]+)\)", document.read_text()):
        target = target.strip().strip("<>")
        if re.match(r"[a-zA-Z][a-zA-Z0-9+.-]*:", target) or target.startswith("#"):
            continue
        path = unquote(target.split("#", 1)[0])
        if path and not (document.parent / path).exists():
            errors.append(f"{document.relative_to(root)}: missing link {path}")

ledger = json.loads((root / "docs/requirements.json").read_text())
if len(ledger) != 2577 or len({row["id"] for row in ledger}) != len(ledger) or len({row["section"] for row in ledger}) != 186:
    errors.append("Requirement ledger lost source statements, sections or unique IDs")
for row in ledger:
    for key in ["source", "tests", "documentation"]:
        for path in row[key].split(";"):
            if not (root / path.strip()).exists():
                errors.append(f"{row['id']}: missing {key} evidence {path.strip()}")

api = json.loads((root / "docs/openapi.json").read_text())
schemas = api["components"]["schemas"]
def references(value):
    if isinstance(value, dict):
        if "$ref" in value:
            reference = value["$ref"]
            if reference.startswith("#/components/schemas/") and reference.rsplit("/", 1)[1] not in schemas:
                errors.append(f"OpenAPI unresolved reference: {reference}")
        for child in value.values():
            references(child)
    elif isinstance(value, list):
        for child in value:
            references(child)
references(api)
counts = re.search(r"(\d+) request/domain/response schemas across (\d+) routes", (root / "docs/REST.md").read_text())
if not counts or tuple(map(int, counts.groups())) != (len(schemas), len(api["paths"])):
    errors.append("REST guide schema/route counts disagree with OpenAPI")
schema = re.search(r"const VERSION = (\d+)", (root / "src/Persistence/Tables.php").read_text()).group(1)
if not re.search(r"Schema version " + schema + r"\b", (root / "docs/DATA-MODEL.md").read_text()):
    errors.append("Data-model guide disagrees with the database schema version")
if errors:
    print("\n".join(errors), file=sys.stderr)
    raise SystemExit(1)
print(json.dumps({"documents": len(documents), "requirement_statements": len(ledger), "routes": len(api["paths"]), "schemas": len(schemas), "database_schema": int(schema)}))
