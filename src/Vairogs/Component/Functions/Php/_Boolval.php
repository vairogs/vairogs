<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Php;

use function filter_var;
use function is_bool;
use function strtolower;

trait _Boolval
{
    public function boolval(mixed $value): bool
    {
        if (is_bool(value: $value)) {
            return $value;
        }

        $value = strtolower(string: (string) $value);

        return match ($value) {
            'y' => true,
            'n' => false,
            default => filter_var(value: $value, filter: FILTER_VALIDATE_BOOL),
        };
    }
}
