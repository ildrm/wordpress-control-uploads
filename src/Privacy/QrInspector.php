<?php
declare(strict_types=1);
namespace ContentFirewall\Privacy;
use ContentFirewall\Domain\Finding;
final class QrInspector
{
    /** Decoded payloads are evaluated locally and never fetched. @return list<Finding> */
    public function inspect(array $codes, string $mode = 'review', array $domains = []): array
    {
        if (count($codes) > 100) { throw new \RuntimeException('VALIDATION.QR_LIMIT'); }
        $findings = [];
        foreach ($codes as $code) {
            if (!is_string($code) || strlen($code) > 4096) { throw new \RuntimeException('VALIDATION.QR'); }
            $category = 'qr.present';
            if (preg_match('/^(BEGIN:VCARD|MECARD:|mailto:|tel:)/i', $code)) { $category = 'qr.contact'; }
            elseif (preg_match('/^(bitcoin:|ethereum:|upi:|payto:|000201)/i', $code)) { $category = 'qr.payment'; }
            elseif (filter_var($code, FILTER_VALIDATE_URL)) {
                $host = strtolower((string)parse_url($code, PHP_URL_HOST));
                $approved = false; foreach ($domains as $domain) { if (\ContentFirewall\Policy\Condition::domain($code, $domain)) { $approved = true; } }
                if (!$approved) { $category = 'qr.external_domain'; }
                if (filter_var($host, FILTER_VALIDATE_IP) && !\ContentFirewall\Security\UrlGuard::publicIp($host)) { $category = 'qr.suspicious'; }
            }
            if ($mode !== 'allow') { $findings[] = new Finding($mode === 'block-all' ? 'qr.prohibited' : $category, 1, 'local-qr', '1', false, 'deterministic'); }
        }
        return $findings;
    }
}
