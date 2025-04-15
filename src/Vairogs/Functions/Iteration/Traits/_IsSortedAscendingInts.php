<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Functions\Iteration\Traits;

use function count;
use function is_int;

trait _IsSortedAscendingInts
{
    public function isSortedAscendingInts(
        array $array,
    ): bool {
        $len = count($array);

        if (0 === $len) {
            return true;
        }

        if (!is_int($array[0])) {
            return false;
        }

        for ($i = 1; $i < $len; $i++) {
            if (!is_int($array[$i]) && $array[$i] < $array[$i - 1]) {
                return false;
            }
        }

        return true;
    }
}
