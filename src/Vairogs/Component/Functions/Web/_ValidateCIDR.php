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

use function explode;
use function ip2long;

trait _ValidateCIDR
{
    public function validateCIDR(
        string $cidr,
    ): bool {
        if (!(new class {
            use _IsCIDR;
        })->isCIDR(cidr: $cidr)) {
            return false;
        }

        return (int) (new class {
            use _CIDRRange;
        })->CIDRRange(cidr: $cidr)[0] === ip2long(ip: explode(separator: '/', string: $cidr, limit: 2)[0]);
    }
}
