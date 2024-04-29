<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Local;

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
