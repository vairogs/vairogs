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

trait _ReturnObject
{
    public function returnObject(
        object $object,
        string $function,
        mixed ...$arguments,
    ): mixed {
        static $_helper = null;

        if (null === $_helper) {
            $_helper = new class {
                use _Return;
            };
        }

        return $_helper->return(fn () => $object->{$function}(...$arguments), $object, ...$arguments);
    }
}
