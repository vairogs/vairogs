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

trait _Return
{
    public function return(
        callable $function,
        object $clone,
        mixed ...$arguments,
    ): mixed {
        static $_helper = null;

        if (null === $_helper) {
            $_helper = new class {
                use _Bind;
            };
        }

        return $_helper->bind(function: $function, clone: $clone)(...$arguments);
    }
}
