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

trait _MakeMultiDimensional
{
    public function makeMultiDimensional(
        array $array,
    ): array {
        if ((new class {
            use _IsMultiDimentional;
        })->isMultiDimensional(keys: $array)) {
            return $array;
        }

        return array_map(callback: static fn ($item) => [$item], array: array_values(array: $array));
    }
}
