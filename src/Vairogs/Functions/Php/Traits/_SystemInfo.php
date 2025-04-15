<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Functions\Php\Traits;

use RuntimeException;

use function php_uname;
use function str_contains;
use function strtolower;

use const PHP_OS_FAMILY;

trait _SystemInfo
{
    public function systemInfo(): array
    {
        $architecture = strtolower(php_uname('m'));

        $normalizedOs = match (strtolower(PHP_OS_FAMILY)) {
            'windows' => 'windows',
            'darwin' => 'darwin',
            'linux' => 'linux',
            default => throw new RuntimeException('unsupported OS'),
        };

        $normalizedArch = match (true) {
            str_contains($architecture, 'amd64') || str_contains($architecture, 'x86_64') => 'amd64',
            str_contains($architecture, 'arm64') || str_contains($architecture, 'aarch64') => 'arm64',
            str_contains($architecture, 'i386') || str_contains($architecture, 'i686') => '386',
            default => throw new RuntimeException('unsupported architecture'),
        };

        return [
            'os' => $normalizedOs,
            'arch' => $normalizedArch,
            'extension' => 'windows' === $normalizedOs ? '.exe' : '',
        ];
    }
}
