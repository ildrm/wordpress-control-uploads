<?php
declare(strict_types=1);
namespace ContentFirewall\Domain;
final class Taxonomy
{
    public const VERSION = 1;
    public const PARENTS = ['sexual.activity' => 'sexual.explicit', 'sexual.genital' => 'sexual.explicit', 'sexual.breast' => 'sexual.explicit', 'sexual.buttock' => 'sexual.explicit', 'sexual.pornographic' => 'sexual.explicit', 'sexual.cartoon' => 'sexual.explicit', 'sexual.erotic' => 'sexual.suggestive', 'sexual.lingerie' => 'sexual.suggestive', 'sexual.underwear' => 'sexual.suggestive', 'sexual.swimwear' => 'sexual.suggestive', 'violence.gore' => 'violence.graphic', 'violence.organs' => 'violence.graphic', 'violence.execution' => 'violence.graphic', 'weapon.aimed' => 'weapon.threatening', 'hate.extremist' => 'hate.symbol'];
    /** Conservative propagation to broader parent categories. No fabricated child-category evidence. */
    public function expand(array $signals): array
    {
        foreach (self::PARENTS as $child => $parent) { if (isset($signals[$child]) && is_numeric($signals[$child])) { $signals[$parent] = max($signals[$parent] ?? 0, $signals[$child]); } }
        return $signals;
    }
}
