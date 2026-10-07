from pathlib import Path
import zipfile, hashlib, json, re
root=Path(__file__).resolve().parents[1]
output=root/'dist'; output.mkdir(exist_ok=True)
main=root/'content-firewall.php'
version=re.search(r'^\s*\* Version: ([0-9.]+)\s*$',main.read_text(),re.M).group(1)
paths=[main,root/'uninstall.php',root/'readme.txt',root/'LICENSE',root/'README.md',root/'CHANGELOG.md',root/'composer.json',root/'composer.lock',root/'package.json',root/'package-lock.json',root/'tsconfig.json',root/'tools/build.mjs']
# Explicit source types prevent caches, archives and local exports entering a release.
for directory,suffixes in [('src',{'.php'}),('includes',{'.php'}),('docs',{'.md','.json'}),('languages',{'.pot','.po','.mo','.json'}),('assets/src',{'.ts','.tsx'})]:
    paths.extend(p for p in (root/directory).rglob('*') if p.is_file() and p.suffix in suffixes)
paths.extend([root/'assets/js/admin.js',root/'assets/css/admin.css'])
archive=output/f'content-firewall-{version}.zip'
with zipfile.ZipFile(archive,'w',compression=zipfile.ZIP_DEFLATED,compresslevel=9) as zipped:
    for path in sorted(set(paths)):
        if path.is_symlink(): raise RuntimeError('Symlinks cannot enter the release')
        info=zipfile.ZipInfo('content-firewall/'+path.relative_to(root).as_posix(),date_time=(2026,1,1,0,0,0)); info.compress_type=zipfile.ZIP_DEFLATED; info.external_attr=0o100644<<16
        zipped.writestr(info,path.read_bytes())
checksum=hashlib.sha256(archive.read_bytes()).hexdigest()
(output/'SHA256SUMS').write_text(checksum+'  '+archive.name+'\n')
(output/'sbom.json').write_text(json.dumps({'schema':1,'product':'content-firewall','version':version,'license':'GPL-2.0-or-later','bundled_third_party_runtime_dependencies':[],'host_supplied_dependencies':['WordPress','PHP','React (WordPress supplied)'],'optional_deployment_tools':['ClamD','Poppler pdfinfo/pdftoppm/pdftotext','FFmpeg/FFprobe','c2patool 0.28.1'],'development_dependency_inventory':{'composer':[{'name':p['name'],'version':p['version'],'license':p.get('license',[])} for p in json.loads((root/'composer.lock').read_text()).get('packages-dev',[])],'npm':[{'name':name.removeprefix('node_modules/'),'version':p.get('version',''),'license':p.get('license','')} for name,p in json.loads((root/'package-lock.json').read_text()).get('packages',{}).items() if name]},'development_dependencies':'See composer.lock and package-lock.json','release_sha256':checksum},indent=2)+'\n')
print(f'{archive.name}: {archive.stat().st_size} bytes; SHA-256 {checksum}')
