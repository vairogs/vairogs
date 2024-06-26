<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Web;

use function filter_var;

use const FILTER_FLAG_NO_PRIV_RANGE;
use const FILTER_FLAG_NO_RES_RANGE;
use const FILTER_FLAG_NONE;
use const FILTER_VALIDATE_IP;

trait _ValidateIPAddress
{
    public function validateIPAddress(
        string $ipAddress,
        bool $deny = true,
    ): bool {
        return false !== filter_var(value: $ipAddress, filter: FILTER_VALIDATE_IP, options: $deny ? FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE : FILTER_FLAG_NONE);
    }
}
