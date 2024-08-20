<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\Functions\Text;

use Vairogs\Component\Functions\Iteration\_ArrayToString;

use function is_array;

trait _ToString
{
    public static function toString(
        mixed $value,
    ): string {
        return is_array($value) ? (new class {
            use _ArrayToString;
        })::arrayToString($value) : (new class {
            use _ScalarToString;
        })::scalarToString($value);
    }
}
