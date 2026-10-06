# Developer API

Namespace: `ContentFirewall`. Hook prefix: `cf_`. REST namespace: `content-firewall/v1`. Version these independently of display branding. Public interfaces require additive changes and an announced deprecation before removal; stored policy schemas must be explicitly migrated.

Register a scanner implementing `Providers\Provider` (id, capabilities, scan) through `cf_register_providers`. Return `Domain\ProviderResult` with normalized `Finding` values and a stable model/version. Missing evidence is an error, never a fabricated clean result. Provider category probabilities and ordinal/severity scores must retain their scale.

```php
add_filter('cf_register_providers', static function (array $providers): array {
    $providers[] = new OrganizationScanner(); // Implements Provider; supplies its own audited transport.
    return $providers;
});
add_action('cf_scan_completed', static function (int $scanId, \ContentFirewall\Domain\Decision $decision): void {
    // Send minimal event metadata through an authorized integration.
}, 10, 2);
```

`cf_upload_context` receives a typed immutable UploadContext plus a WordPress file boundary. Derive trusted roles/user/site from server state; never accept an uploader's self-reported trust or policy exemptions. All security scanners remain mandatory regardless of context.

Stable summarized attachment state is available through `ScanRepository::latest()` and moderator REST reads. Do not put full provider results into postmeta or expose internal security reasons to uploaders. `_cf_scan_id` links an attachment to its operational record; raw file paths and storage keys are not a public API.

Taxonomy parent propagation is conservative: a specific finding may contribute to its broader parent; a parent never invents child signals. Adding arbitrary custom conditions/actions/quarantine backends is not yet a complete supported extension API; do not claim those interfaces exist merely because classes can be replaced.

Custom scanner contract: HTTPS POST with bearer authorization, JSON `{schema:1,sha256,mime,content}` where content is bounded base64. Response `{schema:1,model,findings:[{category,confidence,scale,region?}],text?,codes?}`. Hard-security trust cannot be self-asserted by arbitrary content-provider responses. Write request, error, timeout and schema-change fixtures for every new adapter.

`Security\ContentReconstructor` defines separate derivative creation. Raster and SVG implementations decode/parse and regenerate approved formats. This interface is not document CDR: no local PDF/Office transformer is presented as safe. Integrating a document reconstructor requires separate parser isolation, malware, schema and output validation gates.
