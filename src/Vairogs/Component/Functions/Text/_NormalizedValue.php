<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Text;

use function is_numeric;
use function str_contains;

trait _NormalizedValue
{
    public function normalizedValue(string $value, string $delimiter = '.'): string|int|float
    {
        if (is_numeric(value: $value)) {
            return str_contains(haystack: (string) $value, needle: $delimiter) ? (float) $value : (int) $value;
        }

        return $value;
    }
}
