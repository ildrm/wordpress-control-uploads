from pathlib import Path
import re,json
strings=set()
for file in list(Path('src').rglob('*.php'))+[Path('plugin.php')]:
    strings.update(re.findall(r"(?:__|esc_html__|esc_attr__)\('([^'\\]*(?:\\.[^'\\]*)*)',\s*'content-firewall'",file.read_text()))
for file in Path('assets/src').rglob('*.tsx'):
    strings.update(re.findall(r"__\('([^'\\]*(?:\\.[^'\\]*)*)'\)",file.read_text()))
output='msgid ""\nmsgstr ""\n"Project-Id-Version: content-firewall 0.1.0\\n"\n"Content-Type: text/plain; charset=UTF-8\\n"\n"Content-Transfer-Encoding: 8bit\\n"\n\n'
for value in sorted(strings): output+='msgid '+json.dumps(value.replace("\\'","'"),ensure_ascii=False)+'\nmsgstr ""\n\n'
Path('languages').mkdir(exist_ok=True);Path('languages/content-firewall.pot').write_text(output)
print(f'{len(strings)} extractable interface messages; dynamic labels still need localization acceptance.')
