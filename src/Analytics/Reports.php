<?php
declare(strict_types=1);
namespace ContentFirewall\Analytics;
use ContentFirewall\Bootstrap\Services;
final class Reports
{
    public function __construct(private Services $s) {}
    public function dashboard(): array
    {
        $db = $this->s->db; $tables = $this->s->tables;
        return ['states' => $db->get_results($db->prepare('SELECT state,COUNT(*) AS count FROM %i WHERE site_id=%d AND created_at>=%s GROUP BY state', $tables->name('scans'), $this->s->siteId, gmdate('Y-m-d H:i:s', time() - 30 * DAY_IN_SECONDS)), ARRAY_A), 'providers' => $db->get_results($db->prepare('SELECT provider,SUM(requests) AS requests,SUM(failures) AS failures,SUM(cost) AS estimated_cost,SUM(latency_ms)/NULLIF(SUM(requests),0) AS mean_latency_ms FROM %i WHERE day>=%s GROUP BY provider', $tables->name('usage'), gmdate('Y-m-d', time() - 30 * DAY_IN_SECONDS)), ARRAY_A), 'queue' => $this->s->jobs->status(), 'disagreement' => $db->get_results($db->prepare('SELECT category,provider,COUNT(*) AS reviewed,SUM(predicted<>observed) AS changed FROM %i WHERE created_at>=%s GROUP BY category,provider LIMIT 100', $tables->name('evaluations'), gmdate('Y-m-d H:i:s', time() - 30 * DAY_IN_SECONDS)), ARRAY_A)];
    }
}
