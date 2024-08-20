<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\Functions\Iteration;

use Vairogs\Component\Functions\Text\_ScalarToString;

use function array_is_list;
use function is_array;
use function substr;

trait _ArrayToString
{
    public static function arrayToString(
        array $value,
    ): string {
        if ([] === $value) {
            return '[]';
        }

        $isHash = !array_is_list($value);
        $str = '[';

        $scalar = new class {
            use _ScalarToString;
        };

        foreach ($value as $k => $v) {
            if ($isHash) {
                $str .= $scalar::scalarToString($k) . ' => ';
            }

            $str .= is_array($v) ? self::arrayToString($v) . ', ' : $scalar::scalarToString($v) . ', ';
        }

        return substr($str, 0, -2) . ']';
    }
}
