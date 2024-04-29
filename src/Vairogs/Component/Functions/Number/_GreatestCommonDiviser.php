<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Number;

trait _GreatestCommonDiviser
{
    public function greatestCommonDivisor(
        int $first,
        int $second,
    ): int {
        if (0 === $second) {
            return $first;
        }

        return $this->greatestCommonDivisor(first: $second, second: $first % $second);
    }
}
