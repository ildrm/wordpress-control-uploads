<?php
declare(strict_types=1);
namespace ContentFirewall\Privacy;
use ContentFirewall\Domain\Finding;
final class TextInspector
{
    private const PATTERNS = ['pii.email' => '/\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\b/i', 'pii.phone' => '/(?<!\d)\+?\d[\d ()-]{7,18}\d(?!\d)/', 'pii.ip' => '/\b(?:\d{1,3}\.){3}\d{1,3}\b/', 'pii.social_handle' => '/(?<![\w.])@[\p{L}\p{N}_]{3,32}/u', 'pii.url' => '~https?://[^\s<>]{1,2048}~i', 'pii.bank' => '/\b[A-Z]{2}\d{2}[A-Z0-9]{11,30}\b/'];
    public function categories(): array { return array_merge(array_keys(self::PATTERNS), ['pii.credit_card']); }
    /** @return list<Finding> */
    public function inspect(string $text, array $custom = []): array
    {
        if (strlen($text) > 65536 || !mb_check_encoding($text, 'UTF-8')) { throw new \RuntimeException('VALIDATION.TEXT_LIMIT'); }
        $findings = []; $patterns = self::PATTERNS;
        foreach ($patterns as $category => $regex) { $findings[] = new Finding($category, preg_match($regex, $text) === 1 ? 0.9 : 0, 'local-dlp', '1', false, 'deterministic'); }
        preg_match_all('/(?<!\d)(?:\d[ -]?){13,19}(?!\d)/', $text, $numbers);
        $card = false;
        foreach ($numbers[0] as $number) { if (self::luhn(preg_replace('/\D/', '', $number))) { $card = true; break; } }
        $findings[] = new Finding('pii.credit_card', $card ? 0.99 : 0, 'local-dlp', '1', false, 'deterministic');
        foreach ($custom as $category => $expression) {
            // A partial text match cannot establish negative evidence for the full input.
            if (strlen($text) > 16384) { throw new \RuntimeException('VALIDATION.TEXT_LIMIT'); }
            $match = (new \ContentFirewall\Policy\Condition(['field' => 'text', 'op' => 'regex', 'value' => $expression]))->evaluateEvidence(['text' => $text]);
            if ($match === null) { throw new \RuntimeException('PRIVACY.PATTERN_UNCERTAIN'); }
            $findings[] = new Finding($category, $match ? 1 : 0, 'local-patterns', '1', false, 'deterministic');
        }
        return $findings;
    }
    public static function luhn(string $number): bool
    {
        if (strlen($number) < 13 || strlen($number) > 19 || !ctype_digit($number) || count(array_unique(str_split($number))) === 1) { return false; }
        $sum = 0; $double = false;
        for ($i = strlen($number) - 1; $i >= 0; $i--) { $n = (int)$number[$i]; if ($double) { $n *= 2; if ($n > 9) { $n -= 9; } } $sum += $n; $double = !$double; }
        return $sum % 10 === 0;
    }
    public function redact(string $text, array $patterns): string
    {
        if (strlen($text) > 16384) { throw new \RuntimeException('VALIDATION.TEXT_LIMIT'); }
        foreach ($patterns as $pattern) { new \ContentFirewall\Policy\Condition(['field' => 'text', 'op' => 'regex', 'value' => $pattern]); $text = preg_replace('~(*LIMIT_MATCH=10000)(*LIMIT_DEPTH=100)' . str_replace('~', '\\~', $pattern) . '~u', '[REDACTED]', $text); if ($text === null) { throw new \RuntimeException('PRIVACY.REDACTION'); } }
        return $text;
    }
    public function sanitize(string $text, array $custom = []): string
    {
        if (strlen($text) > 16384 || !mb_check_encoding($text, 'UTF-8')) { throw new \RuntimeException('VALIDATION.TEXT_LIMIT'); }
        $text = preg_replace_callback('/(?<!\d)(?:\d[ -]?){13,19}(?!\d)/', static fn(array $match): string => self::luhn(preg_replace('/\D/', '', $match[0])) ? '[REDACTED]' : $match[0], $text);
        if ($text === null) { throw new \RuntimeException('PRIVACY.REDACTION'); }
        foreach (self::PATTERNS as $pattern) { $text = preg_replace($pattern, '[REDACTED]', $text); if ($text === null) { throw new \RuntimeException('PRIVACY.REDACTION'); } }
        return $this->redact($text, array_values($custom));
    }
}
