<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Assets\Functions\Local\DataProvider;

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
            'curl version with beta tag' => [
                'curl 8.5.0-beta1 (x86_64-pc-linux-gnu) libcurl/8.5.0-beta1',
                true,
                'curl/8.5.0-beta1',
            ],
            'curl version with rc tag' => [
                'curl 8.5.0-rc2 (x86_64-pc-linux-gnu) libcurl/8.5.0-rc2',
                true,
                'curl/8.5.0-rc2',
            ],
            'curl version with multiple lines' => [
                "curl 7.74.0 (x86_64-pc-linux-gnu)\nFeatures: SSL",
                true,
                'curl/7.74.0',
            ],
            'curl version without parentheses' => [
                'curl 7.74.0 libcurl/7.74.0',
                true,
                'curl/7.74.0',
            ],
            'empty output' => [
                '',
                true,
                '',
            ],
            'whitespace output' => [
                '   ',
                true,
                '',
            ],
            'process failure with empty error' => [
                '',
                false,
                '',
            ],
            'curl version with alpha tag' => [
                'curl 8.5.0-alpha1 (x86_64-pc-linux-gnu) libcurl/8.5.0-alpha1',
                true,
                'curl/8.5.0-alpha1',
            ],
            'curl version with patch number' => [
                'curl 7.74.1 (x86_64-pc-linux-gnu) libcurl/7.74.1',
                true,
                'curl/7.74.1',
            ],
            'curl version with only major and minor' => [
                'curl 7.74 (x86_64-pc-linux-gnu) libcurl/7.74',
                true,
                'curl/7.74',
            ],
            'curl version with special characters' => [
                'curl 7.74.0-XYZ#123 (x86_64-pc-linux-gnu)',
                true,
                'curl/7.74.0-XYZ#123',
            ],
            'curl version with leading spaces' => [
                '    curl 7.74.0 (x86_64-pc-linux-gnu)',
                true,
                'curl/7.74.0',
            ],
            'curl version with trailing spaces' => [
                'curl 7.74.0 (x86_64-pc-linux-gnu)    ',
                true,
                'curl/7.74.0',
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
            'test non-existent class' => [
                'vairogs/vairogs',
                'NonExistent\Class',
                [],
                'vairogs/vairogs',
                false,
            ],
            'test package not installed' => [
                'nonexistent/package',
                'stdClass',
                [],
                'vairogs/vairogs',
                true,
            ],
            'test package installed but not in dev' => [
                'vairogs/vairogs',
                'stdClass',
                [],
                'different/package',
                false,
            ],
            'test root package match' => [
                'vairogs/vairogs',
                'stdClass',
                [],
                'vairogs/vairogs',
                true,
            ],
            'test parent package match' => [
                'vairogs/vairogs',
                'stdClass',
                ['phpunit/phpunit'],
                'different/package',
                true,
            ],
            'test no conditions match' => [
                'vairogs/vairogs',
                'stdClass',
                ['nonexistent/package'],
                'different/package',
                false,
            ],
            'test helper reuse' => [
                'vairogs/vairogs',
                'Vairogs\Functions\Local\Traits\_Exists',
                [],
                'vairogs/vairogs',
                true,
            ],
            'test package installed in dev only' => [
                'vairogs/vairogs',
                'stdClass',
                [],
                'different/package',
                false,
            ],
            'test multiple parent packages with one match' => [
                'vairogs/vairogs',
                'stdClass',
                ['nonexistent/package', 'phpunit/phpunit', 'another/nonexistent'],
                'different/package',
                true,
            ],
            'test root package null' => [
                'vairogs/vairogs',
                'stdClass',
                [],
                'different/package',
                false,
            ],
            'test empty parent packages array' => [
                'vairogs/vairogs',
                'stdClass',
                [],
                'different/package',
                false,
            ],
            'test parent package installed in dev only' => [
                'vairogs/vairogs',
                'stdClass',
                ['phpunit/phpunit'],
                'different/package',
                true,
            ],
            'test package installed in prod' => [
                'vairogs/vairogs',
                'stdClass',
                [],
                'different/package',
                false,
            ],
            'test package installed in dev with root package match' => [
                'vairogs/vairogs',
                'stdClass',
                [],
                'vairogs/vairogs',
                true,
            ],
            'test package installed in dev with parent package match' => [
                'vairogs/vairogs',
                'stdClass',
                ['phpunit/phpunit'],
                'different/package',
                true,
            ],
            'test package not installed in any mode' => [
                'vairogs/vairogs',
                'stdClass',
                [],
                'different/package',
                false,
            ],
            'test root package without name key' => [
                'vairogs/vairogs',
                'stdClass',
                [],
                'different/package',
                false,
            ],
        ];
    }
}
