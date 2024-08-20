<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\Functions\Number;

use Vairogs\Component\Functions\Preg\_Match;

use function array_fill;
use function array_key_exists;
use function implode;

trait _IsPrimal
{
    public function isPrimal(
        int $number,
    ): bool {
        (new class {
            use _Match;
        })::match(pattern: '#^1?$|^(11+?)\1+$#', subject: implode(separator: '1', array: array_fill(start_index: 0, count: $number, value: null)), matches: $matches);

        return array_key_exists(1, $matches);
    }
}
