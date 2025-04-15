<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Functions\Iteration\Traits;

use function array_key_exists;

trait _FirstMatchAsString
{
    public function firstMatchAsString(
        array $keys,
        array $haystack,
    ): ?string {
        foreach ($keys as $key) {
            if (array_key_exists($key, $haystack)) {
                return (string) $haystack[$key];
            }
        }

        return null;
    }
}
