<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\Functions\Php;

use function array_unshift;

trait _Call
{
    public function call(
        mixed $value,
        string $function,
        ...$arguments,
    ): mixed {
        array_unshift($arguments, $value);

        return (new class {
            use _ReturnFunction;
        })->returnFunction($function, ...$arguments);
    }
}
