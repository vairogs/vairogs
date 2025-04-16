<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Tests\Functions\Local;

use LogicException;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use UnexpectedValueException;
use Vairogs\Assets\DataProvider\Functions\Local\LocalDataProvider;
use Vairogs\Assets\Mock\Functions\Local\InstalledVersions as MockInstalledVersions;
use Vairogs\Functions\Local\Traits\_CurlUA;
use Vairogs\Functions\Local\Traits\_Exists;
use Vairogs\Functions\Local\Traits\_FileExistsCwd;
use Vairogs\Functions\Local\Traits\_GetEnv;
use Vairogs\Functions\Local\Traits\_HumanFIleSize;
use Vairogs\Functions\Local\Traits\_IsInstalled;
use Vairogs\Functions\Local\Traits\_MkDir;
use Vairogs\Functions\Local\Traits\_RmDir;
use Vairogs\Functions\Local\Traits\_WillBeAvailable;

use function sprintf;

class_alias(MockInstalledVersions::class, 'Composer\\InstalledVersions');

class LocalTest extends TestCase
{
    #[DataProviderExternal(LocalDataProvider::class, 'provideCurlUAMethod')]
    public function testCurlUA(
        string $output,
        bool $isSuccessful,
        string $expected,
    ): void {
        $object = new class($output, $isSuccessful) {
            use _CurlUA;

            public function __construct(
                private readonly string $mockOutput,
                private readonly bool $isSuccessful,
            ) {
            }

            protected function createProcess(
                array $command,
            ): Process {
                return new class($command, $this->mockOutput, $this->isSuccessful) extends Process {
                    private bool $started = false;

                    public function __construct(
                        array $command,
                        private readonly string $mockOutput,
                        private readonly bool $isSuccessful,
                    ) {
                        parent::__construct($command);
                    }

                    public function isSuccessful(): bool
                    {
                        return $this->isSuccessful;
                    }

                    public function getOutput(): string
                    {
                        return $this->mockOutput;
                    }

                    public function getErrorOutput(): string
                    {
                        return $this->mockOutput;
                    }

                    public function run(
                        ?callable $callback = null,
                        array $env = [],
                    ): int {
                        $this->started = true;

                        if (!$this->isSuccessful) {
                            throw new ProcessFailedException($this);
                        }

                        return 0;
                    }

                    public function isStarted(): bool
                    {
                        return $this->started;
                    }
                };
            }
        };

        if (!$isSuccessful) {
            $this->expectException(ProcessFailedException::class);
        }

        $result = $object->getCurlUserAgent();

        if ($isSuccessful) {
            $this->assertIsString($result);
            $this->assertSame($expected, $result);
        }
    }

    public function testCurlUAWithRealProcess(): void
    {
        $object = new class {
            use _CurlUA;

            public function test(): array
            {
                return ['test'];
            }
        };

        $command = $object->test();

        self::assertIsArray($command);
        self::assertSame(['test'], $command);

        $result = $object->getCurlUserAgent();
        $this->assertIsString($result);
        $this->assertMatchesRegularExpression('/^curl\/[\d.]+(?:-(?:DEV|alpha\d+|beta\d+|rc\d+|[A-Za-z0-9#]+))?$/', $result);
    }

    #[DataProviderExternal(LocalDataProvider::class, 'provideExistsMethod')]
    public function testExists(
        string|object $class,
        bool $expected,
    ): void {
        $object = new class {
            use _Exists;
        };

        self::assertSame($expected, $object->exists($class));
    }

    #[DataProviderExternal(LocalDataProvider::class, 'provideFileExistsCwdMethod')]
    public function testFileExistsCwd(
        string $file,
        bool $expected,
    ): void {
        $object = new class {
            use _FileExistsCwd;
        };

        self::assertSame($expected, $object->fileExistsCwd($file));
    }

    #[DataProviderExternal(LocalDataProvider::class, 'provideGetEnvMethod')]
    public function testGetEnv(
        string $var,
        bool $localOnly,
        string $expected,
    ): void {
        $object = new class {
            use _GetEnv;
        };

        self::assertSame($expected, $object->getenv($var, $localOnly));
    }

    #[DataProviderExternal(LocalDataProvider::class, 'provideHumanFileSizeMethod')]
    public function testHumanFileSize(
        int $bytes,
        int $decimals,
        string $expected,
    ): void {
        $object = new class {
            use _HumanFIleSize;
        };

        self::assertSame($expected, $object->humanFileSize($bytes, $decimals));
    }

    #[DataProviderExternal(LocalDataProvider::class, 'provideIsInstalledMethod')]
    public function testIsInstalled(
        array $packages,
        bool $dev,
        bool $expected,
    ): void {
        MockInstalledVersions::setMockInstalled([
            'vairogs/vairogs' => 'prod',
            'json' => 'prod',
        ]);

        $object = new class {
            use _IsInstalled;
        };

        self::assertSame($expected, $object->isInstalled($packages, $dev));
    }

    #[DataProviderExternal(LocalDataProvider::class, 'provideMkDirMethod')]
    public function testMkDir(
        string $dir,
        bool $expected,
    ): void {
        $object = new class {
            use _MkDir;
        };

        if (!$expected) {
            $this->expectException(UnexpectedValueException::class);
            $this->expectExceptionMessage(sprintf('Directory "%s" was not created', $dir));
        }

        self::assertSame($expected, $object->mkdir($dir));
    }

    #[DataProviderExternal(LocalDataProvider::class, 'provideRmDirMethod')]
    public function testRmDir(
        string $dir,
        bool $expected,
    ): void {
        $object = new class {
            use _RmDir;
        };

        self::assertSame($expected, $object->rmdir($dir));
    }

    #[DataProviderExternal(LocalDataProvider::class, 'provideWillBeAvailableMethod')]
    public function testWillBeAvailable(
        string $package,
        string $class,
        array $parentPackages,
        string $rootPackageCheck,
        bool $expected,
    ): void {
        MockInstalledVersions::setMockInstalled([
            'vairogs/functions-local' => 'prod',
            'vairogs/functions' => 'prod',
            'vairogs/vairogs' => 'dev',
            'phpunit/phpunit' => 'dev',
        ]);
        MockInstalledVersions::setMockRootPackage([
            'name' => 'vairogs/vairogs',
        ]);

        $object = new class {
            use _WillBeAvailable;
        };

        self::assertSame($expected, $object->willBeAvailable($package, $class, $parentPackages, $rootPackageCheck));
    }

    public function testWillBeAvailableComposer1(): void
    {
        $object = new class {
            use _WillBeAvailable;

            protected function classExists(
                string $class,
            ): bool {
                return false;
            }
        };

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Calling "Vairogs\Functions\Local\Traits\_WillBeAvailable::willBeAvailable" when dependencies have been installed with Composer 1 is not supported. Consider upgrading to Composer 2.');
        $object->willBeAvailable('test/package', 'TestClass', [], 'test/package');
    }
}
