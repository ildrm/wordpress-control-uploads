# Developer API

Namespace: `ContentFirewall`. Hook prefix: `cf_`. REST namespace: `content-firewall/v1`. Version these independently of display branding. Public interfaces require additive changes and an announced deprecation before removal; stored policy schemas must be explicitly migrated.

`cf_scan_completed` fires after the decision and built-in outbox commit. Exceptions from extension listeners are audited and isolated; listeners must handle their own durable delivery/idempotency. Provider registrations require unique bounded IDs; results/findings/text/regions are validated and bounded. The publication checkpoint hook is internal test instrumentation and is not a stable supported API.

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

Custom scanner contract: HTTPS POST with bearer authorization, JSON `{schema:1,sha256,mime,content}` where content is bounded base64. Response `{schema:1,model,findings:[{category,confidence,scale,region?}],text?,codes?,language?}`. Hard-security trust cannot be self-asserted by arbitrary content-provider responses. Write request, error, timeout and schema-change fixtures for every new adapter.

`Security\ContentReconstructor` defines separate derivative creation. Raster and SVG implementations decode/parse and regenerate approved formats. DocumentMedia implements bounded PDF rasterization and fresh image-only reconstruction; TemporalMedia handles bounded native media. Office/archive reconstruction is unavailable. The interface alone does not establish safety; deployment parser isolation, malware, security corpus and output acceptance remain required. See MEDIA-PROCESSING.md.

ProviderResult may include an ISO two/three-letter lowercase language code; it must remain empty when not measured. Router aggregates distinct successful identities; ResultAccumulator merges frame/page findings while preserving normalized regions and combines bounded ephemeral text/codes. Native processors receive a ProcessRunner which pulses the owned lease. New providers/reconstructors must preserve these bounds and hold unknown/unsupported output.

Privacy/RecordLifecycle is the shared tenant-locked erasure boundary. Do not remove an accepted attachment gate record without preserving its minimal state. Core public media is separate from plugin private records. Settings changes must pass Configuration/Settings and deep-merge nested groups; do not stash secret values in REST settings or user preferences.

Use authenticated multipart `/uploads` for headless receipt, then poll its owner-safe status route. Do not bypass this with filesystem/offload writes or directly publish the original. Security Only headless receipts also enqueue normal scan work so processing/publication has durable retry provenance. WordPress MIME/size/network quota checks apply in addition to plugin limits.

Application/FileSimulator shares ScanService's ephemeral analysis and publication-transform checks, creates no scan/publication job, and sanitizes its returned provider summaries. Its internal analysis results can contain transient text and must not be serialized directly; the REST report explicitly projects safe fields. Multipart boundaries accept actual PHP uploads only. Register integration reference extraction separately for unsupported custom/raw media references; the optional publication gate covers standard save and schedule paths, not direct wp_publish_post/SQL writes.
