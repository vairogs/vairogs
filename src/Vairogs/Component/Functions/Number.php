<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions;

use function is_numeric;

final class Number
{
    public function isInt(mixed $value): bool
    {
        return is_numeric(value: $value) && ctype_digit(text: (string) $value);
    }

    public function isFloat(mixed $value): bool
    {
        return is_numeric(value: $value) && !ctype_digit(text: (string) $value);
    }

    public function greatestCommonDivisor(int $first, int $second): int
    {
        if (0 === $second) {
            return $first;
        }

        return $this->greatestCommonDivisor(first: $second, second: $first % $second);
    }

    public function leastCommonMultiple(int $first, int $second): int
    {
        return (int) ($first * $second / $this->greatestCommonDivisor(first: $first, second: $second));
    }
}
