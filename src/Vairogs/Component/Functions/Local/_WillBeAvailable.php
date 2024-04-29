<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Local;

use Composer\InstalledVersions;
use LogicException;

use function class_exists;
use function sprintf;

trait _WillBeAvailable
{
    public function willBeAvailable(
        string $package,
        string $class,
        array $parentPackages,
        string $rootPackageCheck = 'vairogs/vairogs',
    ): bool {
        if (!class_exists(class: InstalledVersions::class)) {
            throw new LogicException(message: sprintf('Calling "%s" when dependencies have been installed with Composer 1 is not supported. Consider upgrading to Composer 2.', __METHOD__));
        }

        if (!(new class() {
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
