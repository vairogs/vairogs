<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Number;

use function function_exists;
use function gmp_prob_prime;

trait _IsPrimeGmp
{
    public function isPrimeGmp(
        int $number,
        bool $override = false,
    ): ?bool {
        if (!$override && function_exists(function: 'gmp_prob_prime')) {
            return match (gmp_prob_prime(num: (string) $number)) {
                0 => false,
                2 => true,
                default => null,
            };
        }

        return null;
    }
}
