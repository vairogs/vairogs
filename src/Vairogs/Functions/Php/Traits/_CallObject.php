<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Functions\Php\Traits;

use function array_unshift;

trait _CallObject
{
    public function callObject(
        mixed $value,
        object $object,
        string $function,
        ...$arguments,
    ): mixed {
        array_unshift($arguments, $value);

        static $_helper = null;

        if (null === $_helper) {
            $_helper = new class {
                use _ReturnObject;
            };
        }

        return $_helper->returnObject($object, $function, ...$arguments);
    }
}
