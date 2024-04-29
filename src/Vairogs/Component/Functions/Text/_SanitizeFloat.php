<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Text;

use function filter_var;

use const FILTER_FLAG_ALLOW_FRACTION;
use const FILTER_SANITIZE_NUMBER_FLOAT;

trait _SanitizeFloat
{
    public function sanitizeFloat(
        string $string,
    ): float {
        return (float) filter_var(value: $string, filter: FILTER_SANITIZE_NUMBER_FLOAT, options: FILTER_FLAG_ALLOW_FRACTION);
    }
}
