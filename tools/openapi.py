from pathlib import Path
import re,json
source=Path('src/REST/Controller.php').read_text()
paths={}
for path,method,cap,handler in re.findall(r"'(/[^']*)' => \['(GET|POST)', '([^']+)', '([^']+)'\]",source):
    path=path.replace('(?P<id>\\d+)','{id}')
    operation={'operationId':handler,'summary':handler,'security':[{'wordpressAuth':[]}],'x-wordpress-capability':cap,'responses':{'200':{'description':'Authorized response'},'400':{'description':'Stable validation/configuration error'},'403':{'description':'Authorization failure'},'409':{'description':'Stale revision or conflict'}}}
    if '{id}' in path: operation['parameters']=[{'name':'id','in':'path','required':True,'schema':{'type':'integer','minimum':1}}]
    paths.setdefault(path,{})[method.lower()]=operation
result={'openapi':'3.1.0','info':{'title':'Content Firewall REST','version':'0.1.0','description':'Route and capability inventory; complete payload schemas remain outstanding.'},'servers':[{'url':'/wp-json/content-firewall/v1'}],'paths':paths,'components':{'securitySchemes':{'wordpressAuth':{'type':'http','scheme':'basic','description':'WordPress application password or authenticated cookie plus REST nonce'}}}}
Path('docs/openapi.json').write_text(json.dumps(result,indent=2)+'\n')
print(f'Generated {len(paths)} routes from the controller.')
