<?php declare(strict_types = 1);

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
