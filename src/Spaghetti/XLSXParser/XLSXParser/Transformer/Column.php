<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spaghetti\XLSXParser\Transformer;

use function ord;
use function str_split;

/**
 * @internal
 */
final class Column
{
    public function transform(
        string $name,
    ): int {
        $number = -1;

        foreach (str_split(string: $name) as $char) {
            $digit = ord(character: $char) - 65;

            if ($digit < 0) {
                break;
            }

            $number = ($number + 1) * 26 + $digit;
        }

        return $number;
    }
}
