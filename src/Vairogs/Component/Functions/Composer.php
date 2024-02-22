<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions;

use Composer\InstalledVersions;
use LogicException;

use function class_exists;
use function getenv;
use function interface_exists;
use function phpversion;
use function sprintf;
use function trait_exists;

final class Composer
{
    public function isInstalled(array $packages, bool $incDevReq = false): bool
    {
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

    public function exists(string $class): bool
    {
        return class_exists(class: $class) || interface_exists(interface: $class) || trait_exists(trait: $class);
    }

    public function getenv(string $name, bool $localOnly = true): mixed
    {
        return getenv($name, local_only: $localOnly) ?: ($_ENV[$name] ?? $name);
    }

    public function willBeAvailable(string $package, string $class, array $parentPackages, string $rootPackageCheck = 'vairogs/vairogs'): bool
    {
        if (!class_exists(class: InstalledVersions::class)) {
            throw new LogicException(message: sprintf('Calling "%s" when dependencies have been installed with Composer 1 is not supported. Consider upgrading to Composer 2.', __METHOD__));
        }

        if (!$this->exists(class: $class)) {
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
