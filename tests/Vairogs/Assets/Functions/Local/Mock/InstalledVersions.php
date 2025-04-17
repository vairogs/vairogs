<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Assets\Functions\Local\Mock;

use function array_key_exists;
use function phpversion;

class InstalledVersions
{
    private static array $installed = [];
    private static array $rootPackage = [];

    public static function getRootPackage(): array
    {
        return self::$rootPackage;
    }

    public static function isInstalled(
        string $packageName,
        bool $includeDevRequirements = true,
    ): bool {
        if (false !== phpversion($packageName)) {
            return true;
        }

        if (!array_key_exists($packageName, self::$installed)) {
            return false;
        }

        if (!$includeDevRequirements) {
            return 'prod' === self::$installed[$packageName];
        }

        return true;
    }

    public static function setMockInstalled(
        array $installed,
    ): void {
        self::$installed = $installed;
    }

    public static function setMockRootPackage(
        array $rootPackage,
    ): void {
        self::$rootPackage = $rootPackage;
    }
}
