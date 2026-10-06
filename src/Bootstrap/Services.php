<?php
declare(strict_types=1);
namespace ContentFirewall\Bootstrap;
use ContentFirewall\Persistence\{AuditRepository, Limiter, PolicyRepository, ScanRepository, SignalCache, Tables};
use ContentFirewall\Security\{ClamD, FileInspector, PrivateStorage, UrlGuard};
use ContentFirewall\Infrastructure\PinnedHttpClient;
use ContentFirewall\Providers\{AwsRekognition, AzureSafety, CustomScanner, GoogleVision, OpenAiModeration, Provider, Router, Sightengine};
use ContentFirewall\Application\{ScanService, SecurityPipeline};
use ContentFirewall\Queue\JobRepository;
final class Services
{
    public readonly Tables $tables;
    public readonly ScanRepository $scans;
    public readonly PolicyRepository $policies;
    public readonly AuditRepository $audit;
    public readonly PrivateStorage $storage;
    public readonly FileInspector $inspector;
    public readonly SecurityPipeline $security;
    public readonly JobRepository $jobs;
    public readonly Limiter $limiter;
    public readonly Router $router;
    public readonly ScanService $scanner;
    public readonly int $siteId;
    public readonly array $settings;
    public function __construct(public readonly \wpdb $db)
    {
        $this->siteId = get_current_blog_id(); $this->settings = get_option('cf_settings', []);
        $this->tables = new Tables($db); $this->scans = new ScanRepository($db, $this->tables, $this->siteId); $this->policies = new PolicyRepository($db, $this->tables);
        $this->audit = new AuditRepository($db, $this->tables, $this->siteId, defined('CF_AUDIT_KEY') ? CF_AUDIT_KEY : wp_salt('auth'));
        $root = defined('CF_PRIVATE_DIR') ? CF_PRIVATE_DIR : sys_get_temp_dir() . '/cf-private-' . substr(hash_hmac('sha256', ABSPATH, wp_salt('auth')), 0, 16);
        $uploads = wp_upload_dir(null, false);
        $this->storage = new PrivateStorage($root, [ABSPATH, $_SERVER['DOCUMENT_ROOT'] ?? ABSPATH, $uploads['basedir']]);
        $this->inspector = new FileInspector((int)($this->settings['max_bytes'] ?? 52428800), (int)($this->settings['max_pixels'] ?? 24000000), $this->settings['allowed_extensions'] ?? ['jpg', 'jpeg', 'png', 'webp', 'gif', 'avif', 'pdf', 'txt']);
        $socket = self::secret('CF_CLAMD_SOCKET');
        $this->security = new SecurityPipeline($socket !== '' ? new ClamD($socket) : null, (bool)($this->settings['require_malware'] ?? false));
        $this->jobs = new JobRepository($db, $this->tables, $this->siteId); $this->limiter = new Limiter($db, $this->tables);
        $providers = []; $http = new PinnedHttpClient(new UrlGuard());
        if (self::secret('CF_OPENAI_KEY') !== '') { $providers[] = new OpenAiModeration($http, self::secret('CF_OPENAI_KEY'), ''); }
        if (self::secret('CF_GOOGLE_TOKEN') !== '') { $providers[] = new GoogleVision($http, self::secret('CF_GOOGLE_TOKEN'), ''); }
        if (self::secret('CF_SIGHTENGINE_USER') !== '') { $providers[] = new Sightengine($http, self::secret('CF_SIGHTENGINE_USER'), self::secret('CF_SIGHTENGINE_SECRET')); }
        if (self::secret('CF_AWS_ACCESS_KEY') !== '') { $providers[] = new AwsRekognition($http, self::secret('CF_AWS_ACCESS_KEY'), self::secret('CF_AWS_SECRET_KEY'), self::secret('CF_AWS_REGION') ?: 'us-east-1', self::secret('CF_AWS_SESSION_TOKEN')); }
        if (self::secret('CF_AZURE_KEY') !== '') { $providers[] = new AzureSafety($http, self::secret('CF_AZURE_KEY'), self::secret('CF_AZURE_ENDPOINT')); }
        if (self::secret('CF_CUSTOM_ENDPOINT') !== '') { $providers[] = new CustomScanner($http, self::secret('CF_CUSTOM_KEY'), self::secret('CF_CUSTOM_ENDPOINT')); }
        $providers = apply_filters('cf_register_providers', $providers);
        foreach ($providers as $provider) { if (!$provider instanceof Provider) { throw new \RuntimeException('CONFIGURATION.PROVIDER'); } }
        $this->router = new Router($providers, new SignalCache($db, $this->tables), $this->limiter, $this->audit, $db, $this->tables, (int)($this->settings['monthly_cap'] ?? 10000));
        $this->scanner = new ScanService($this->inspector, $this->security, $this->storage, $this->scans, $this->policies, $this->audit, $this->router, $this->jobs, $this->siteId);
    }
    public static function secret(string $name): string { $value = defined($name) ? constant($name) : getenv($name); return is_string($value) ? $value : ''; }
}
