<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Functions\Local\Traits;

use Composer\InstalledVersions;

use function phpversion;

trait _IsInstalled
{
    public function isInstalled(
        array $packages,
        bool $incDevReq = false,
    ): bool {
        foreach ($packages as $packageName) {
            if (false !== phpversion(extension: $packageName)) {
                continue;
            }

            if (!InstalledVersions::isInstalled(packageName: $packageName, includeDevRequirements: $incDevReq)) {
                return false;
            }
        }

        return true;
    }
}
