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
    public function toString(
        mixed $value,
    ): string {
        static $_helper = null;

        if (null === $_helper) {
            $_helper = new class {
                use _ArrayToString;
                use _ScalarToString;
            };
        }

        return is_array($value) ? $_helper->arrayToString($value) : $_helper->scalarToString($value);
    }
}
