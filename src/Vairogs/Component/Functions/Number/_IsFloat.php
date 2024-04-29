<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Number;

use function is_numeric;

trait _IsFloat
{
    public function isFloat(
        mixed $value,
    ): bool {
        return is_numeric(value: $value) && !ctype_digit(text: (string) $value);
    }
}
