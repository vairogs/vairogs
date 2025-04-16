<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Assets\DataProvider\Functions\Local;

use stdClass;

class LocalDataProvider
{
    public static function provideCurlUAMethod(): array
    {
        return [
            'standard curl version' => [
                'curl 7.74.0 (x86_64-pc-linux-gnu) libcurl/7.74.0 OpenSSL/1.1.1n zlib/1.2.11 brotli/1.0.9 libidn2/2.3.0 libpsl/0.21.0 (+libidn2/2.3.0) libssh2/1.9.0 nghttp2/1.43.0 librtmp/2.3',
                true,
                'curl/7.74.0',
            ],
            'curl dev version' => [
                'curl 8.4.0-DEV (x86_64-pc-linux-gnu) libcurl/8.4.0-DEV OpenSSL/3.0.2 zlib/1.2.11',
                true,
                'curl/8.4.0-DEV',
            ],
            'unexpected output format' => [
                'Some unexpected curl version output',
                true,
                'Some unexpected curl version output',
            ],
            'process failure' => [
                'error output',
                false,
                '',
            ],
        ];
    }

    public static function provideExistsMethod(): array
    {
        return [
            'test existing class as string' => [stdClass::class, true],
            'test non-existing class as string' => ['NonExistentClass', false],
            'test object instance' => [new stdClass(), true],
        ];
    }

    public static function provideFileExistsCwdMethod(): array
    {
        return [
            'test existing file' => ['composer.json', true],
            'test non-existing file' => ['nonexistent.txt', false],
        ];
    }

    public static function provideGetEnvMethod(): array
    {
        return [
            'test existing env var' => ['PATH', true, getenv('PATH')],
            'test non-existing env var' => ['NONEXISTENT_VAR_TEST', true, 'NONEXISTENT_VAR_TEST'],
            'test with local only false' => ['PATH', false, getenv('PATH')],
        ];
    }

    public static function provideHumanFileSizeMethod(): array
    {
        return [
            'test bytes' => [1024, 2, '1.00K'],
            'test kilobytes' => [1048576, 2, '1.00M'],
            'test megabytes' => [1073741824, 2, '1.00G'],
            'test small bytes' => [100, 2, '100.00B'],
            'test with different decimals' => [1024, 0, '1K'],
            'test large number' => [1125899906842624, 2, '1.00P'],
        ];
    }

    public static function provideIsInstalledMethod(): array
    {
        return [
            'test installed package' => [['vairogs/vairogs'], false, true],
            'test non-installed package' => [['nonexistent/package'], false, false],
            'test with dev requirements' => [['vairogs/vairogs'], true, true],
            'test PHP extension' => [['json'], false, true],
            'test non-existent PHP extension' => [['nonexistent_ext'], false, false],
        ];
    }

    public static function provideMkDirMethod(): array
    {
        return [
            'test create directory' => ['/tmp/test_dir_' . uniqid(), true],
            'test existing directory' => ['/tmp', true],
            'test nested directory' => ['/tmp/test_dir_' . uniqid() . '/nested', true],
            'test directory with special chars' => ['/tmp/test_dir_' . uniqid() . '/special@#$', true],
            'test invalid directory' => ['/nonexistent/root/dir_' . uniqid(), false],
        ];
    }

    public static function provideRmDirMethod(): array
    {
        return [
            'test remove directory' => ['/tmp/test_dir_' . uniqid(), true],
            'test non-existent directory' => ['/tmp/nonexistent_' . uniqid(), true],
        ];
    }

    public static function provideWillBeAvailableMethod(): array
    {
        return [
            'test available package' => [
                'vairogs/vairogs',
                'Vairogs\Functions\Local\Traits\_Exists',
                ['Vairogs\Functions\Local\Traits'],
                'vairogs/vairogs',
                true,
            ],
            'test non-available package' => [
                'nonexistent/package',
                'NonExistent\Class',
                ['NonExistent'],
                'vairogs/vairogs',
                false,
            ],
            'test non-existent class' => [
                'vairogs/vairogs',
                'NonExistent\Class',
                ['Vairogs\Functions\Local\Traits'],
                'vairogs/vairogs',
                false,
            ],
            'test installed package with dev requirements' => [
                'phpunit/phpunit',
                'PHPUnit\Framework\TestCase',
                ['phpunit/phpunit'],
                'vairogs/vairogs',
                true,
            ],
            'test with matching root package' => [
                'vairogs/vairogs',
                'Vairogs\Functions\Local\Traits\_Exists',
                ['Vairogs\Functions\Local\Traits'],
                'vairogs/vairogs',
                true,
            ],
            'test with different root package' => [
                'vairogs/vairogs',
                'Vairogs\Functions\Local\Traits\_Exists',
                ['Vairogs\Functions\Local\Traits'],
                'different/package',
                true,
            ],
            'test with parent package installed' => [
                'vairogs/vairogs',
                'Vairogs\Functions\Local\Traits\_Exists',
                ['phpunit/phpunit'],
                'different/package',
                true,
            ],
            'test with no matching conditions' => [
                'nonexistent/package',
                'NonExistent\Class',
                ['nonexistent/parent'],
                'different/package',
                false,
            ],
            'test with composer 1 simulation' => [
                'vairogs/vairogs',
                'NonExistent\ComposerVersions',
                ['Vairogs\Functions\Local\Traits'],
                'vairogs/vairogs',
                false,
            ],
            'test with installed package in dev' => [
                'vairogs/vairogs',
                'Vairogs\Functions\Local\Traits\_Exists',
                [],
                'different/package',
                true,
            ],
            'test with root package match' => [
                'vairogs/vairogs',
                'Vairogs\Functions\Local\Traits\_Exists',
                [],
                'vairogs/vairogs',
                true,
            ],
            'test with non-installed package and empty parent packages' => [
                'nonexistent/package',
                'NonExistent\Class',
                [],
                'different/package',
                false,
            ],
            'test with installed package and no dev requirements' => [
                'vairogs/vairogs',
                'Vairogs\Functions\Local\Traits\_Exists',
                [],
                'different/package',
                true,
            ],
            'test with installed package and dev requirements' => [
                'vairogs/vairogs',
                'Vairogs\Functions\Local\Traits\_Exists',
                [],
                'different/package',
                true,
            ],
            'test with parent package installed in dev' => [
                'vairogs/vairogs',
                'Vairogs\Functions\Local\Traits\_Exists',
                ['phpunit/phpunit'],
                'different/package',
                true,
            ],
            'test with multiple parent packages' => [
                'vairogs/vairogs',
                'Vairogs\Functions\Local\Traits\_Exists',
                ['nonexistent/package', 'phpunit/phpunit'],
                'different/package',
                true,
            ],
            'test with all parent packages non-existent' => [
                'vairogs/vairogs',
                'Vairogs\Functions\Local\Traits\_Exists',
                ['nonexistent/package1', 'nonexistent/package2'],
                'different/package',
                true,
            ],
            'test with root package without name' => [
                'vairogs/vairogs',
                'Vairogs\Functions\Local\Traits\_Exists',
                [],
                'vairogs/vairogs',
                true,
            ],
            'test with helper reuse' => [
                'vairogs/vairogs',
                'Vairogs\Functions\Local\Traits\_Exists',
                [],
                'vairogs/vairogs',
                true,
            ],
        ];
    }
}
