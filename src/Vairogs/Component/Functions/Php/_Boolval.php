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

use function filter_var;
use function is_bool;
use function strtolower;

trait _Boolval
{
    public function boolval(
        mixed $value,
    ): bool {
        if (is_bool(value: $value)) {
            return $value;
        }

        $value = strtolower(string: (string) $value);

        return match ($value) {
            'y', '1', 'true' => true,
            'n', '0', 'false' => false,
            default => filter_var(value: $value, filter: FILTER_VALIDATE_BOOL),
        };
    }
}
