<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Number;

trait _LeastCommonMultiple
{
    public function leastCommonMultiple(
        int $first,
        int $second,
    ): int {
        return (int) ($first * $second / (new class() {
            use _GreatestCommonDiviser;
        })->greatestCommonDivisor(first: $first, second: $second));
    }
}
