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

use function is_numeric;
use function str_contains;

trait _NormalizedValue
{
    public function normalizedValue(
        string $value,
        string $delimiter = '.',
    ): string|int|float {
        if (is_numeric(value: $value)) {
            return str_contains(haystack: (string) $value, needle: $delimiter) ? (float) $value : (int) $value;
        }

        return $value;
    }
}
