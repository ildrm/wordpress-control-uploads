from pathlib import Path
import re,json,sys
ref=lambda name:{'\u0024ref':'#/components/schemas/'+name}
obj=lambda properties,required=():{'type':'object','properties':properties,'required':list(required)}
integer={'type':'integer','minimum':0}
action={'type':'string','enum':['ALLOW','SANITIZE','REVIEW','QUARANTINE','BLOCK']}
reason={'type':'string','minLength':3,'maxLength':2000,'description':'At least three non-whitespace characters.'}
identifier={'type':'string','pattern':'^[a-zA-Z0-9_-]{1,64}$'}
schemas={
 'ActionRequest':obj({'revision':integer,'action':{'type':'string','enum':['approve','reject','quarantine','delete','rescan','fingerprint','assign','note','escalate']},'reason':reason,'owner_id':integer,'confirm':{'type':'boolean','description':'Must be true for delete.'}},['revision','action','reason']),
 'AppealRequest':obj({'reason':reason},['reason']),
 'Finding':obj({'category':{'type':'string','pattern':'^[a-z][a-z0-9_.-]{1,95}$'},'confidence':{'type':'number','minimum':0,'maximum':1},'provider':{'type':'string','pattern':'^[a-z][a-z0-9_-]{0,63}$'},'model':{'type':'string','minLength':1,'maxLength':120},'hard_security':{'type':'boolean'},'scale':{'type':'string','enum':['probability','ordinal','severity','deterministic']},'region':{'type':['array','null'],'items':{'type':'number','minimum':0,'maximum':1},'minItems':4,'maxItems':4,'description':'Normalized x,y,width,height entirely inside the image.'}},['category','confidence']),
 'Condition':{'oneOf':[obj({'group':{'type':'string','enum':['AND','OR','NOT']},'children':{'type':'array','items':ref('Condition'),'minItems':1,'maxItems':32}},['group','children']),obj({'field':{'type':'string','pattern':'^[a-z][a-z0-9_.-]{0,95}$'},'op':{'type':'string','enum':['eq','ne','gt','gte','lt','lte','in','contains','between','exists','domain','regex']},'value':{'type':['string','number','boolean','null','array'],'maxLength':512,'maxItems':100,'items':{'type':['string','number','boolean','null']}}},['field','op'])],'description':'Depth <=8; <=256 nodes and <=16 KiB per condition. NOT has one child. Only exists omits value; numeric comparisons require finite numbers; between requires an ordered pair.'},
 'Rule':obj({'id':identifier,'priority':{'type':'integer','minimum':-1000000,'maximum':1000000},'enabled':{'type':'boolean'},'condition':ref('Condition'),'action':action,'effects':{'type':'array','maxItems':0}},['id','condition','action']),
 'Band':obj({'review':{'type':'number','minimum':0,'maximum':1},'block':{'type':'number','minimum':0,'maximum':1},'calibrated':{'type':'boolean'}},['review','block']),
 'Options':obj({'requires_content':{'type':'boolean'},'requires_text':{'type':'boolean'},'consensus':{'type':'boolean'},'failure_mode':{'type':'string','enum':['QUARANTINE','FAIL_OPEN','FAIL_CLOSED']},'metadata':{'type':'string','enum':['Privacy Safe']},'qr_mode':{'type':'string','enum':['allow','review','block-all']},'region':{'type':'string','maxLength':80},'patterns':{'type':'object','maxProperties':32,'additionalProperties':{'type':'string','maxLength':512}},'domains':{'type':'array','maxItems':100,'items':{'type':'string'}}}),
 'Policy':obj({'schema':{'const':1},'id':identifier,'version':{'type':'integer','minimum':1},'name':{'type':'string','minLength':1,'maxLength':160},'rules':{'type':'array','maxItems':128,'items':ref('Rule')},'default':action,'shadow':{'type':'boolean'},'bands':{'type':'object','maxProperties':128,'additionalProperties':ref('Band')},'options':ref('Options')},['schema','id','name','rules']),
 'Settings':obj({**{name:{'type':'boolean'} for name in ['require_malware','delete_on_uninstall','publication_gate']},**{name:{'type':'integer','minimum':1,'maximum':maximum} for name,maximum in {'max_bytes':104857600,'max_pixels':24000000,'monthly_cap':1000000,'upload_per_hour':100000}.items()},'allowed_extensions':{'type':'array','minItems':1,'maxItems':20,'items':{'type':'string','enum':['jpg','jpeg','png','webp','gif','avif','svg','pdf','txt','zip','docx','xlsx','pptx','mp3','wav','ogg','m4a','mp4','webm']}}}),
}
for name in ['Policy','Rule','Options','Settings']: schemas[name]['additionalProperties']=False
schemas['Retention']=obj({name:{'type':'integer','minimum':1,'maximum':3650} for name in ['private_files_days','safe_metadata_days','blocked_metadata_days','audit_days','analytics_days','job_days']})
schemas['Retention']['additionalProperties']=False
schemas['Settings']['properties'].update({name:{'type':'boolean'} for name in ['privacy_retain_audit','onboarding_complete','enable_documents','enable_temporal','enable_provenance']})
schemas['Settings']['properties'].update({'sla_hours':{'type':'integer','minimum':1,'maximum':8760},'retention':ref('Retention')})
schemas['Processing']=obj({**{key:{'type':'integer','minimum':1,'maximum':limit} for key,limit in {'max_duration':600,'max_frames':32,'max_pages':100}.items()},'sampling':{'type':'string','enum':['uniform','scene','adaptive']}})
schemas['Processing']['additionalProperties']=False
schemas['Settings']['properties']['processing']=ref('Processing')
schemas['Assignment']=obj({'team':{'type':'string','pattern':'^[a-zA-Z0-9 _.-]{0,64}$'},'priority':{'type':'integer','minimum':0,'maximum':1000},'sla_at':{'type':['string','null'],'description':'UTC YYYY-MM-DD HH:MM:SS, from now through 366 days.'}})
schemas['Assignment']['additionalProperties']=False
schemas['ActionRequest']['properties']['assignment']=ref('Assignment')
schemas['QueueView']=obj({'id':{'type':'string','pattern':'^[a-z0-9-]{1,64}$'},'name':{'type':'string','minLength':1,'maxLength':80},'state':{'type':'string'},'owner':{'type':'integer','minimum':-1},'team':{'type':'string','pattern':'^[a-zA-Z0-9 _.-]{0,64}$'},'overdue':{'type':'boolean'}},['id','name','state','owner','team','overdue'])
schemas['QueueView']['additionalProperties']=False
schemas['QueueViewsRequest']=obj({'views':{'type':'array','maxItems':10,'items':ref('QueueView')}},['views'])
schemas['QueueViewsRequest']['additionalProperties']=False
schemas['OnboardingRequest']=obj({'step':{'type':'integer','minimum':0,'maximum':3},'preset':{'type':'string'},'settings':ref('Settings'),'complete':{'type':'boolean'}},['step'])
schemas['OnboardingRequest']['additionalProperties']=False
db_integer={'oneOf':[integer,{'type':'string','pattern':'^[0-9]+$'}]}
utc={'type':'string','pattern':'^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$'}
array=lambda item:{'type':'array','items':item}
schemas['Decision']=obj({'action':action,'reasons':array({'type':'string'}),'rules':array({'type':'string'}),'policy_id':{'type':'string'},'policy_version':integer,'risk':{'type':'number','minimum':0,'maximum':1},'shadow':{'type':'boolean'},'effects':array({'type':'string'})},['action','reasons','rules','policy_id','policy_version','risk','shadow'])
schemas['ScanSummary']=obj({**{name:db_integer for name in ['id','attachment_id','user_id','revision','bytes','policy_version']},**{name:{'type':'string'} for name in ['correlation','state','file_name','mime','policy_id']},'risk':{'type':['number','string']},'created_at':utc,'updated_at':utc,'owner_id':{'type':['integer','string','null']},'team':{'type':['string','null']},'priority':{'type':['integer','string','null']},'sla_at':{'type':['string','null']}},['id','state','revision'])
schemas['Note']=obj({'actor_id':db_integer,'action':{'type':'string'},'reason':{'type':'string','maxLength':2000},'created_at':utc})
schemas['Appeal']=obj({'id':db_integer,'reason':{'type':'string','maxLength':2000},'status':{'type':'string'},'resolution':{'type':'string','maxLength':2000},'created_at':utc,'resolved_at':{'type':['string','null']}})
schemas['Case']=obj({'owner_id':db_integer,'team':{'type':'string'},'priority':db_integer,'sla_at':{'type':['string','null']}})
schemas['ScanDetail']={'allOf':[ref('ScanSummary'),obj({'site_id':db_integer,'context_json':{'type':'string'},'signals_json':{'type':'string'},'expires_at':utc,'metadata_erased':db_integer,'findings':array(ref('Finding')),'decision':ref('Decision'),'notes':array(ref('Note')),'appeals':array(ref('Appeal')),'case':{'oneOf':[ref('Case'),{'type':'null'}]}})]}
schemas['OwnerScan']=obj({'id':db_integer,'state':{'type':'string'},'attachment_id':db_integer,'created_at':utc,'updated_at':utc})
schemas['PolicySummary']=obj({'id':db_integer,'policy_id':{'type':'string'},'version':db_integer,'name':{'type':'string'},'created_at':utc})
schemas['ActionResult']=obj({'id':integer,'state':{'type':'string'},'error':{'type':'string'}},['id'])
schemas['Provider']=obj({'id':{'type':'string'},'capabilities':obj({'features':array({'type':'string'}),'mimes':array({'type':'string'}),'regions':array({'type':'string'}),'model':{'type':'string'},'cacheable':{'type':'boolean'}}),'health':obj({'failures':integer,'until':integer})})
schemas['QueueCount']=obj({'status':{'type':'string'},'count':db_integer})
schemas['Health']=obj({'plugin':{'type':'string'},'wordpress':{'type':'string'},'php':{'type':'string'},'database':{'type':'string'},'schema':integer,'environment':{'type':'string'},'site_id':integer,'processors':{'type':'object','additionalProperties':obj({'enabled':{'type':'boolean'},'configured':{'type':'boolean'},'executable':{'type':'boolean'}})},'queue':array(ref('QueueCount')),'worker_last_run':integer,'recovery_operations':integer,'issues':array({'type':'string'}),'providers':array(ref('Provider')),'extensions':{'type':'object','additionalProperties':{'type':'boolean'}},'malware_configured':{'type':'boolean'},'malware_required':{'type':'boolean'},'persistent_private_storage':{'type':'boolean'},'cron_enabled':{'type':'boolean'}})
schemas['Onboarding']=obj({'step':{'type':'integer','minimum':0,'maximum':3},'complete':{'type':'boolean'},'network_enforced':{'type':'boolean'},'policy':ref('Policy'),'settings':ref('Settings'),'health':ref('Health')})
schemas['Audit']=obj({'id':db_integer,'actor_id':db_integer,'object_id':db_integer,'event':{'type':'string'},'metadata':{'type':'string'},'created_at':utc})
schemas['Analytics']=obj({'states':array(obj({'state':{'type':'string'},'count':db_integer})),'providers':array(obj({'provider':{'type':'string'},'requests':db_integer,'failures':db_integer,'estimated_cost':{'type':['number','string']},'mean_latency_ms':{'type':['number','string','null']}})),'queue':array(ref('QueueCount')),'disagreement':array(obj({'category':{'type':'string'},'provider':{'type':'string'},'reviewed':db_integer,'changed':db_integer}))})
schemas['Error']=obj({'code':{'type':'string'},'message':{'type':'string'},'data':obj({'status':{'type':'integer'},'code':{'type':'string'}})},['code','message','data'])
schemas['BulkRequest']=obj({key:value for key,value in schemas['ActionRequest']['properties'].items() if key!='revision'}|{'items':{'type':'array','minItems':1,'maxItems':50,'items':obj({'id':{'type':'integer','minimum':1},'revision':integer},['id','revision'])}},['action','reason','items'])
schemas['SimulationRequest']=obj({'policy':ref('Policy'),'signals':{'type':'object'},'findings':{'type':'array','maxItems':256,'items':ref('Finding')}},['policy'])
schemas['HistoryRequest']=obj({'policy':ref('Policy'),'after':integer},['policy'])
request_schemas={'act':'ActionRequest','bulk':'BulkRequest','appeal':'AppealRequest','savePolicy':'Policy','networkPolicy':'Policy','saveSettings':'Settings','simulate':'SimulationRequest','simulateHistory':'HistoryRequest'}
request_schemas.update({'saveQueueViews':'QueueViewsRequest','saveOnboarding':'OnboardingRequest'})
response_schemas={'scans':array(ref('ScanSummary')),'ownScans':array(ref('OwnerScan')),'scan':ref('ScanDetail'),'act':ref('ActionResult'),'bulk':array(ref('ActionResult')),'appeal':obj({'accepted':{'const':True}}),'preview':obj({'mime':{'type':'string'},'content':{'type':'string','contentEncoding':'base64'}}),'policies':array(ref('PolicySummary')),'policy':ref('Policy'),'savePolicy':ref('Policy'),'networkPolicy':ref('Policy'),'presets':array(ref('Policy')),'simulate':ref('Decision'),'simulateHistory':obj({'counts':{'type':'object','additionalProperties':integer},'after':integer,'external_requests':{'const':0},'limitations':array({'type':'string'})}),'analytics':ref('Analytics'),'health':ref('Health'),'providers':array(ref('Provider')),'audit':array(ref('Audit')),'library':obj({'queued':{'const':True},'batch':{'type':'string'}}),'worker':obj({'completed':integer,'failed':integer}),'settings':ref('Settings'),'saveSettings':ref('Settings'),'reviewers':array(obj({'id':integer,'name':{'type':'string'}})),'queueViews':array(ref('QueueView')),'saveQueueViews':array(ref('QueueView')),'onboarding':ref('Onboarding'),'saveOnboarding':ref('Onboarding')}
schemas['UploadStatus']=obj({'id':integer,'state':{'type':'string'},'stage':{'type':'string','enum':['uploading','security_check','content_check','pending_publication','approved','pending_review','rejected','failed','expired','held','superseded']},'attachment_id':integer,'updated_at':utc,'review_available':{'type':'boolean'}},['id','state','stage','attachment_id','updated_at','review_available'])
schemas['FileSimulation']=obj({'decision':ref('Decision'),'findings':array(ref('Finding')),'providers':array(obj({'provider':{'type':'string'},'model':{'type':'string'},'error':{'type':['string','null']},'duration_ms':{'type':'number','minimum':0},'estimated_cost':{'type':'number','minimum':0},'language':{'type':'string'}})),'signals':{'type':'object'},'duration_ms':{'type':'number','minimum':0},'estimated_cost':{'type':'number','minimum':0},'published':{'const':False}},['decision','findings','providers','signals','duration_ms','estimated_cost','published'])
response_schemas.update({'upload':ref('UploadStatus'),'uploadStatus':ref('UploadStatus'),'simulateFile':ref('FileSimulation')})
source=Path('src/REST/Controller.php').read_text()
paths={}
for path,method,cap,handler in re.findall(r"'(/[^']*)' => \['(GET|POST)', '([^']+)', '([^']+)'\]",source):
    path=path.replace('(?P<id>\\d+)','{id}')
    operation={'operationId':handler,'summary':handler,'security':[{'wordpressAuth':[]}],'x-wordpress-capability':cap,'responses':{'200':{'description':'Authorized response'},'400':{'description':'Stable validation/configuration error'},'403':{'description':'Authorization failure'},'409':{'description':'Stale revision or conflict'},'404':{'description':'Record not found'}}}
    if '{id}' in path: operation['parameters']=[{'name':'id','in':'path','required':True,'schema':{'type':'integer','minimum':1}}]
    if handler in request_schemas: operation['requestBody']={'required':True,'description':'JSON body <=256 KiB; server also validates semantic constraints.','content':{'application/json':{'schema':ref(request_schemas[handler])}}}
    if handler in ['upload','simulateFile']:
        operation['requestBody']={'required':True,'description':'One genuine multipart uploaded file; PHP/WordPress/plugin limits apply. No local path parameters.','content':{'multipart/form-data':{'schema':obj({'file':{'type':'string','format':'binary'},**({'policy':{'type':'string','maxLength':262144,'description':'Optional schema-1 Policy JSON; otherwise active policy.'}} if handler=='simulateFile' else {})},['file'])}}}
    if handler in response_schemas: operation['responses']['200']['content']={'application/json':{'schema':response_schemas[handler]}}
    for status in ['400','403','409','404']: operation['responses'][status]['content']={'application/json':{'schema':ref('Error')}}
    if handler in ['scans','ownScans','policies','audit','reviewers']:
        parameters=[{'name':'after','in':'query','schema':integer}]
        if handler in ['scans','ownScans']: parameters.append({'name':'limit','in':'query','schema':{'type':'integer','minimum':1,'maximum':100,'default':30}})
        if handler=='scans': parameters.extend([{'name':'state','in':'query','schema':{'type':'string'}},{'name':'owner','in':'query','schema':integer},{'name':'team','in':'query','schema':{'type':'string','maxLength':64}},{'name':'overdue','in':'query','schema':{'type':'boolean'}}])
        operation.setdefault('parameters',[]).extend(parameters)
    operation['responses']['200']['headers']={'Cache-Control':{'schema':{'type':'string','const':'private, no-store, max-age=0'}}}
    paths.setdefault(path,{})[method.lower()]=operation
result={'openapi':'3.1.0','info':{'title':'Content Firewall REST','version':'0.1.0','description':'Generated route/capability inventory, typed requests and implemented response DTOs. UTC dates and database numeric strings are explicit; semantic validation remains enforced by the server.'},'servers':[{'url':'/wp-json/content-firewall/v1'}],'paths':paths,'components':{'schemas':schemas,'securitySchemes':{'wordpressAuth':{'type':'http','scheme':'basic','description':'WordPress application password or authenticated cookie plus REST nonce'}}}}
serialized=json.dumps(result,indent=2)+'\n'; target=Path('docs/openapi.json')
if '--check' in sys.argv:
    if not target.exists() or target.read_text()!=serialized: raise SystemExit('OpenAPI drift: run python3 tools/openapi.py')
else: target.write_text(serialized)
print(f'Verified {len(paths)} routes and {len(schemas)} request/domain schemas.')
