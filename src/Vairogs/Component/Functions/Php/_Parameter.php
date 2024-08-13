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

use function is_array;

trait _Parameter
{
    public function parameter(
        array|object $variable,
        mixed $key,
    ): mixed {
        if (is_array(value: $variable)) {
            return $variable[$key];
        }

        return (new class {
            use _Get;
        })->get(object: $variable, property: $key);
    }
}
