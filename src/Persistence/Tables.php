<?php
declare(strict_types=1);
namespace ContentFirewall\Persistence;
final class Tables
{
    public const VERSION = 2;
    private string $prefix;
    public function __construct(private \wpdb $db) { $this->prefix = $db->prefix; }
    public function name(string $suffix): string
    {
        if (!in_array($suffix, ['scans', 'findings', 'policies', 'jobs', 'cases', 'case_notes', 'appeals', 'audit', 'usage', 'fingerprints', 'cache', 'events', 'limits', 'evaluations'], true) || !preg_match('/^[a-zA-Z0-9_]+$/D', $this->prefix)) { throw new \RuntimeException('DATABASE.TABLE'); }
        return $this->prefix . 'cf_' . $suffix;
    }
    public function migrate(): void
    {
        $database = $this->db->get_var('SELECT DATABASE()');
        if (!is_string($database) || $database === '') { throw new \RuntimeException('DATABASE.MIGRATION'); }
        $lock = 'cf_schema_' . substr(hash('sha256', $database . ':' . $this->prefix), 0, 40);
        if ((int)$this->db->get_var($this->db->prepare('SELECT GET_LOCK(%s,10)', $lock)) !== 1) { throw new \RuntimeException('DATABASE.MIGRATION_BUSY'); }
        try { $this->migrateLocked(); } finally { $this->db->get_var($this->db->prepare('SELECT RELEASE_LOCK(%s)', $lock)); }
    }
    private function migrateLocked(): void
    {
        $version = (string)$this->db->get_var('SELECT VERSION()');
        $minimum = stripos($version, 'MariaDB') !== false ? '10.11' : '8.0';
        if (version_compare($this->db->db_version(), $minimum, '<')) { throw new \RuntimeException('CONFIGURATION.DATABASE_VERSION'); }
        require_once ABSPATH . 'wp-admin/includes/upgrade.php'; $charset = $this->db->get_charset_collate();
        $definitions = [
            'case_notes' => "id bigint unsigned NOT NULL AUTO_INCREMENT,\nscan_id bigint unsigned NOT NULL,\nactor_id bigint unsigned NOT NULL,\naction varchar(32) NOT NULL,\nreason text NOT NULL,\ncreated_at datetime NOT NULL,\nPRIMARY KEY  (id),\nKEY scan (scan_id,id)",
            'scans' => "id bigint unsigned NOT NULL AUTO_INCREMENT,\nsite_id bigint unsigned NOT NULL,\ncorrelation char(32) NOT NULL,\nattachment_id bigint unsigned NOT NULL DEFAULT 0,\nuser_id bigint unsigned NOT NULL DEFAULT 0,\nstate varchar(32) NOT NULL,\nrevision int unsigned NOT NULL DEFAULT 0,\nmetadata_erased int unsigned NOT NULL DEFAULT 0,\nsha256 char(64) NOT NULL,\nfile_name varchar(240) NOT NULL,\nmime varchar(120) NOT NULL,\nbytes bigint unsigned NOT NULL,\nprivate_key char(64) NOT NULL DEFAULT '',\npolicy_id varchar(64) NOT NULL,\npolicy_version int unsigned NOT NULL,\nrisk decimal(6,5) NOT NULL DEFAULT 0,\ncontext_json longtext NOT NULL,\nsignals_json longtext NOT NULL,\ndecision_json longtext NOT NULL,\ncreated_at datetime NOT NULL,\nupdated_at datetime NOT NULL,\nexpires_at datetime NOT NULL,\nPRIMARY KEY  (id),\nUNIQUE KEY correlation (site_id,correlation),\nKEY attachment (site_id,attachment_id,id),\nKEY queue_view (site_id,state,id),\nKEY hash_lookup (site_id,sha256,id),\nKEY user_lookup (site_id,user_id,id),\nKEY expiry (expires_at,id),\nKEY metadata_expiry (site_id,metadata_erased,created_at,id),\nKEY risk_view (site_id,risk,id),\nKEY timeline (site_id,created_at,state)",
            'findings' => "id bigint unsigned NOT NULL AUTO_INCREMENT,\nscan_id bigint unsigned NOT NULL,\ncategory varchar(96) NOT NULL,\nprovider varchar(64) NOT NULL,\nmodel varchar(120) NOT NULL,\nconfidence decimal(6,5) NOT NULL,\npayload longtext NOT NULL,\nPRIMARY KEY  (id),\nKEY scan (scan_id),\nKEY category_provider (category,provider,id)",
            'policies' => "id bigint unsigned NOT NULL AUTO_INCREMENT,\npolicy_id varchar(64) NOT NULL,\nversion int unsigned NOT NULL,\nname varchar(160) NOT NULL,\npayload longtext NOT NULL,\ncreated_at datetime NOT NULL,\nactor_id bigint unsigned NOT NULL,\nPRIMARY KEY  (id),\nUNIQUE KEY snapshot (policy_id,version)",
            'jobs' => "id bigint unsigned NOT NULL AUTO_INCREMENT,\nsite_id bigint unsigned NOT NULL,\nidempotency char(64) NOT NULL,\nkind varchar(32) NOT NULL,\npayload longtext NOT NULL,\nstatus varchar(16) NOT NULL DEFAULT 'ready',\npriority int NOT NULL DEFAULT 0,\nattempts int unsigned NOT NULL DEFAULT 0,\navailable_at datetime NOT NULL,\nlease_until datetime DEFAULT NULL,\nlease_token char(32) DEFAULT NULL,\nerror_code varchar(80) NOT NULL DEFAULT '',\ncreated_at datetime NOT NULL,\nPRIMARY KEY  (id),\nUNIQUE KEY idempotency (site_id,idempotency),\nKEY due (site_id,status,available_at,priority,id),\nKEY lease (site_id,status,lease_until)",
            'cases' => "scan_id bigint unsigned NOT NULL,\nowner_id bigint unsigned NOT NULL DEFAULT 0,\nteam varchar(64) NOT NULL DEFAULT '',\npriority int NOT NULL DEFAULT 0,\nsla_at datetime DEFAULT NULL,\nnotes_json longtext NOT NULL,\nPRIMARY KEY  (scan_id),\nKEY owner (owner_id,priority,scan_id),\nKEY sla (sla_at,scan_id)",
            'appeals' => "id bigint unsigned NOT NULL AUTO_INCREMENT,\nscan_id bigint unsigned NOT NULL,\nuser_id bigint unsigned NOT NULL,\nreason text NOT NULL,\nstatus varchar(16) NOT NULL DEFAULT 'pending',\nreviewer_id bigint unsigned NOT NULL DEFAULT 0,\nresolution text NOT NULL,\ncreated_at datetime NOT NULL,\nresolved_at datetime DEFAULT NULL,\nPRIMARY KEY  (id),\nKEY scan (scan_id,status),\nKEY user (user_id,id)",
            'audit' => "id bigint unsigned NOT NULL AUTO_INCREMENT,\nsite_id bigint unsigned NOT NULL,\nactor_id bigint unsigned NOT NULL,\nobject_id bigint unsigned NOT NULL,\nevent varchar(80) NOT NULL,\nmetadata longtext NOT NULL,\nintegrity char(64) NOT NULL,\ncreated_at datetime NOT NULL,\nPRIMARY KEY  (id),\nKEY object_events (site_id,object_id,id),\nKEY timeline (site_id,created_at,id)",
            'usage' => "id bigint unsigned NOT NULL AUTO_INCREMENT,\nprovider varchar(64) NOT NULL,\nday date NOT NULL,\nrequests bigint unsigned NOT NULL DEFAULT 0,\nfailures bigint unsigned NOT NULL DEFAULT 0,\nlatency_ms double NOT NULL DEFAULT 0,\ncost decimal(16,6) NOT NULL DEFAULT 0,\nPRIMARY KEY  (id),\nUNIQUE KEY provider_day (provider,day)",
            'fingerprints' => "id bigint unsigned NOT NULL AUTO_INCREMENT,\nsha256 char(64) NOT NULL,\nperceptual char(16) NOT NULL DEFAULT '',\naction varchar(16) NOT NULL,\nlabel varchar(160) NOT NULL,\ncreated_at datetime NOT NULL,\nPRIMARY KEY  (id),\nUNIQUE KEY hash (sha256),\nKEY perceptual (perceptual)",
            'cache' => "cache_key char(64) NOT NULL,\npayload longtext NOT NULL,\nexpires_at datetime NOT NULL,\nPRIMARY KEY  (cache_key),\nKEY expiry (expires_at)",
            'events' => "event_id char(32) NOT NULL,\nreceived_at datetime NOT NULL,\nPRIMARY KEY  (event_id),\nKEY expiry (received_at)",
            'limits' => "bucket char(64) NOT NULL,\nuses bigint unsigned NOT NULL DEFAULT 0,\nexpires_at datetime NOT NULL,\nPRIMARY KEY  (bucket),\nKEY expiry (expires_at)",
            'evaluations' => "id bigint unsigned NOT NULL AUTO_INCREMENT,\nscan_id bigint unsigned NOT NULL,\ncategory varchar(96) NOT NULL,\npredicted varchar(16) NOT NULL,\nobserved varchar(16) NOT NULL,\nprovider varchar(64) NOT NULL,\nmodel varchar(120) NOT NULL,\nactor_id bigint unsigned NOT NULL,\ncreated_at datetime NOT NULL,\nPRIMARY KEY  (id),\nKEY scan (scan_id),\nKEY cohort (category,provider,model,id)",
        ];
        foreach ($definitions as $suffix => $definition) {
            dbDelta('CREATE TABLE ' . $this->name($suffix) . " (\n" . $definition . "\n) ENGINE=InnoDB " . $charset . ';');
            $exists = $this->db->get_var($this->db->prepare('SHOW TABLES LIKE %s', $this->db->esc_like($this->name($suffix))));
            if ($exists !== $this->name($suffix) || $this->db->last_error) { throw new \RuntimeException('DATABASE.MIGRATION'); }
            $columns = $this->db->get_col($this->db->prepare('SHOW COLUMNS FROM %i', $this->name($suffix)));
            preg_match_all('/^([a-z_]+) (?:bigint|int|char|varchar|decimal|longtext|text|datetime|date|double)/m', $definition, $expected);
            if (array_diff($expected[1], $columns)) { throw new \RuntimeException('DATABASE.MIGRATION'); }
            $engine = $this->db->get_var($this->db->prepare('SELECT ENGINE FROM information_schema.TABLES WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME=%s', $this->name($suffix)));
            if (strtoupper((string)$engine) !== 'INNODB') { throw new \RuntimeException('CONFIGURATION.TRANSACTIONAL_TABLES_REQUIRED'); }
        }
        update_option('cf_schema_version', self::VERSION, false);
    }
}
