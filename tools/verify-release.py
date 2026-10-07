"""Verify the distributable without Composer/vendor and detect non-deterministic packaging."""
from pathlib import Path
import hashlib
import json
import re
import subprocess
import sys
import tempfile
import zipfile

root = Path(__file__).resolve().parents[1]
version = re.search(r"\* Version: ([0-9.]+)", (root / "plugin.php").read_text()).group(1)
archive = root / "dist" / f"content-firewall-{version}.zip"
subprocess.run([sys.executable, str(root / "tools/package.py")], cwd=root, check=True)
first = hashlib.sha256(archive.read_bytes()).hexdigest()
subprocess.run([sys.executable, str(root / "tools/package.py")], cwd=root, check=True)
if hashlib.sha256(archive.read_bytes()).hexdigest() != first:
    raise SystemExit("Release archive is not deterministic")
with zipfile.ZipFile(archive) as zipped:
    names = zipped.namelist()
    if len(names) != len(set(names)):
        raise SystemExit("Duplicate ZIP entries")
    for name in names:
        path = Path(name)
        if path.is_absolute() or ".." in path.parts or path.parts[0] != "content-firewall" or any(part in {"vendor", "node_modules", "tests", ".git", ".env", ".runtime"} for part in path.parts):
            raise SystemExit(f"Invalid/development package entry: {name}")
    required = {"content-firewall/plugin.php", "content-firewall/autoload.php", "content-firewall/uninstall.php", "content-firewall/assets/admin.js", "content-firewall/assets/admin.css", "content-firewall/readme.txt"}
    required.update("content-firewall/" + p.relative_to(root).as_posix() for p in (root / "src").rglob("*.php"))
    if not required.issubset(names):
        raise SystemExit("Package is missing runtime files")
    with tempfile.TemporaryDirectory(prefix="cf-package-") as temporary:
        zipped.extractall(temporary)
        smoke = subprocess.run(["php", str(root / "tools/verify-package.php"), str(Path(temporary) / "content-firewall")], cwd=root, check=True, capture_output=True, text=True)
        result = json.loads(smoke.stdout)
if (root / "dist/SHA256SUMS").read_text().split()[0] != first:
    raise SystemExit("Package checksum mismatch")
if json.loads((root / "dist/sbom.json").read_text())["release_sha256"] != first:
    raise SystemExit("Dependency inventory checksum mismatch")
print(json.dumps({"archive": archive.name, "sha256": first, "deterministic": True, **result}, indent=2))
