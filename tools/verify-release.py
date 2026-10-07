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
main = root / "content-firewall.php"
header_pairs = re.findall(r'^\s*\*\s*([A-Za-z][A-Za-z ]+):\s*(.+)$', main.read_text(), re.M)
header = dict(header_pairs)
if len(header) != len(header_pairs):
    raise SystemExit("Duplicate plugin header fields")
expected = {"Plugin Name": "Content Firewall", "Text Domain": "content-firewall", "Domain Path": "/languages", "License": "GPL-2.0-or-later", "License URI": "https://www.gnu.org/licenses/gpl-2.0.html"}
if any(header.get(key) != value for key, value in expected.items()) or not all(header.get(key) for key in ["Description", "Version", "Author", "Requires at least", "Requires PHP"]):
    raise SystemExit("Missing or inconsistent WordPress plugin metadata")
if sorted(p.name for p in root.glob("*.php")) != ["content-firewall.php", "uninstall.php"]:
    raise SystemExit("Only the plugin bootstrap and uninstall entry belong at the PHP root")
version = header["Version"]
readme = (root / "readme.txt").read_text()
if not readme.startswith("=== " + header["Plugin Name"] + " ===") or not re.search(r'^Stable tag: ' + re.escape(version) + r'\s*$', readme, re.M):
    raise SystemExit("Plugin header and readme name/version disagree")
composer = json.loads((root / "composer.json").read_text())
if composer.get("type") != "wordpress-plugin" or composer.get("extra", {}).get("installer-name") != "content-firewall":
    raise SystemExit("Composer installation metadata must preserve the WordPress slug")
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
    required = {"content-firewall/content-firewall.php", "content-firewall/includes/autoload.php", "content-firewall/uninstall.php", "content-firewall/assets/js/admin.js", "content-firewall/assets/css/admin.css", "content-firewall/readme.txt", "content-firewall/LICENSE", "content-firewall/tools/build.mjs", "content-firewall/package.json", "content-firewall/package-lock.json", "content-firewall/tsconfig.json"}
    required.update("content-firewall/" + p.relative_to(root).as_posix() for p in (root / "src").rglob("*.php"))
    required.update("content-firewall/" + p.relative_to(root).as_posix() for p in (root / "assets/src").rglob("*") if p.suffix in {".ts", ".tsx"})
    if not required.issubset(names):
        raise SystemExit("Package is missing runtime files")
    with tempfile.TemporaryDirectory(prefix="cf-package-") as temporary:
        zipped.extractall(temporary)
        extracted = Path(temporary) / "content-firewall"
        headers = [p for p in extracted.glob("*.php") if re.search(r'^\s*\*?\s*Plugin Name:', p.read_text(), re.M)]
        if headers != [extracted / "content-firewall.php"] or sorted(p.name for p in extracted.glob("*.php")) != ["content-firewall.php", "uninstall.php"]:
            raise SystemExit("Distribution needs one slug-named bootstrap; helper PHP belongs in subdirectories")
        smoke = subprocess.run(["php", str(root / "tools/verify-package.php"), str(extracted)], cwd=root, check=True, capture_output=True, text=True)
        result = json.loads(smoke.stdout)
        # Reuse the locked checkout's development dependencies only for this rebuild.
        # They are not ZIP entries, and the runtime smoke test above does not need them.
        (extracted / "node_modules").symlink_to(root / "node_modules", target_is_directory=True)
        subprocess.run(["node", str(extracted / "tools/build.mjs")], cwd=extracted, check=True, capture_output=True, text=True)
        if (extracted / "assets/js/admin.js").read_bytes() != zipped.read("content-firewall/assets/js/admin.js"):
            raise SystemExit("Packaged source/build script does not reproduce the compiled JavaScript")
if (root / "dist/SHA256SUMS").read_text().split()[0] != first:
    raise SystemExit("Package checksum mismatch")
if json.loads((root / "dist/sbom.json").read_text())["release_sha256"] != first:
    raise SystemExit("Dependency inventory checksum mismatch")
print(json.dumps({"archive": archive.name, "sha256": first, "deterministic": True, "packaged_source_rebuild": "passed", **result}, indent=2))
