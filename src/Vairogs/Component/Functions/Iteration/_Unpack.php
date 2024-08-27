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

use function array_key_exists;
use function explode;

trait _Unpack
{
    public function unpack(
        array $oneDimension,
    ): array {
        $multiDimension = [];

        foreach ($oneDimension as $key => $value) {
            $path = explode(separator: '.', string: $key);
            $temp = &$multiDimension;

            foreach ($path as $segment) {
                if (!array_key_exists($segment, $temp)) {
                    $temp[$segment] = [];
                }
                $temp = &$temp[$segment];
            }

            $temp = $value;
        }

        return $multiDimension;
    }
}
