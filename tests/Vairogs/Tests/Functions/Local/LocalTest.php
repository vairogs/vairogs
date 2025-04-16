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

use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use UnexpectedValueException;
use Vairogs\Assets\DataProvider\Functions\Local\LocalDataProvider;
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
                private string $mockOutput,
                private bool $isSuccessful,
            ) {
            }

            public function getCurlUserAgent(): string
            {
                $process = new class(['curl', '--version'], $this->mockOutput, $this->isSuccessful) extends Process {
                    private bool $started = false;

                    public function __construct(
                        array $command,
                        private string $mockOutput,
                        private bool $isSuccessful,
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

                $process->run();

                if (!$process->isSuccessful()) {
                    throw new ProcessFailedException($process);
                }

                $output = trim(explode("\n", $process->getOutput(), 2)[0]);

                if (preg_match('/curl\s([\d.]+(?:-DEV)?)/', $output, $matches)) {
                    return 'curl/' . $matches[1];
                }

                return $output;
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
        $object = new class {
            use _WillBeAvailable;
        };

        // Test helper reuse by calling twice
        if ('Vairogs\Functions\Local\Traits\_Exists' === $class && empty($parentPackages) && 'vairogs/vairogs' === $rootPackageCheck) {
            $object->willBeAvailable($package, $class, $parentPackages, $rootPackageCheck);
        }

        self::assertSame($expected, $object->willBeAvailable($package, $class, $parentPackages, $rootPackageCheck));
    }
}
