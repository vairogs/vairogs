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

trait _Void
{
    public function void(
        callable $function,
        object $clone,
        mixed ...$arguments,
    ): void {
        (new class {
            use _Bind;
        })->bind(function: $function, clone: $clone)(...$arguments);
    }
}
