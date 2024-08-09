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
