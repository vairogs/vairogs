<?php declare(strict_types = 1);

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
