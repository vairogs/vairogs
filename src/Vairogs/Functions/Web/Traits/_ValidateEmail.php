<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Functions\Web\Traits;

use function filter_var;

use const FILTER_UNSAFE_RAW;
use const FILTER_VALIDATE_EMAIL;

trait _ValidateEmail
{
    public function validateEmail(
        string $email,
    ): bool {
        return false !== filter_var(value: filter_var(value: $email, filter: FILTER_UNSAFE_RAW), filter: FILTER_VALIDATE_EMAIL);
    }
}
