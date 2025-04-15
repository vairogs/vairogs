<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Functions\Number\Traits;

use function is_numeric;

trait _IsFloat
{
    public function isFloat(
        mixed $value,
    ): bool {
        return is_numeric(value: $value) && !ctype_digit(text: (string) $value);
    }
}
