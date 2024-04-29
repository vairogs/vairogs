<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Number;

trait _IsPrimeBelow1000
{
    public function isPrimeBelow1000(
        int $number,
    ): ?bool {
        if (1000 <= $number) {
            return null;
        }

        for ($x = 2; $x < $number; $x++) {
            if (0 === $number % $x) {
                return false;
            }
        }

        return 1 !== $number;
    }
}
