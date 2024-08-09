<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\Functions\Web;

use function count;
use function explode;
use function is_numeric;

trait _IsCIDR
{
    public function isCIDR(
        string $cidr,
    ): bool {
        $parts = explode(separator: '/', string: $cidr);

        if (2 === count(value: $parts) && is_numeric(value: $parts[1]) && 32 >= (int) $parts[1]) {
            return (new class {
                use _ValidateIPAddress;
            })->validateIPAddress(ipAddress: $parts[0], deny: false);
        }

        return false;
    }
}
