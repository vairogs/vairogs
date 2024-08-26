<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\Functions\Local;

use Composer\InstalledVersions;
use LogicException;
use Vairogs\Component\Functions\Vairogs;

use function class_exists;
use function sprintf;

trait _WillBeAvailable
{
    public function willBeAvailable(
        string $package,
        string $class,
        array $parentPackages,
        string $rootPackageCheck = Vairogs::VAIROGS . '/' . Vairogs::VAIROGS,
    ): bool {
        if (!class_exists(class: InstalledVersions::class)) {
            throw new LogicException(message: sprintf('Calling "%s" when dependencies have been installed with Composer 1 is not supported. Consider upgrading to Composer 2.', __METHOD__));
        }

        if (!(new class {
            use _Exists;
        })->exists(class: $class)) {
            return false;
        }

        if (!InstalledVersions::isInstalled(packageName: $package) || InstalledVersions::isInstalled(packageName: $package, includeDevRequirements: false)) {
            return true;
        }

        $rootPackage = InstalledVersions::getRootPackage()['name'] ?? '';

        if ($rootPackageCheck === $rootPackage) {
            return true;
        }

        foreach ($parentPackages as $parentPackage) {
            if ($rootPackage === $parentPackage || (InstalledVersions::isInstalled(packageName: $parentPackage) && !InstalledVersions::isInstalled(packageName: $parentPackage, includeDevRequirements: false))) {
                return true;
            }
        }

        return false;
    }
}
