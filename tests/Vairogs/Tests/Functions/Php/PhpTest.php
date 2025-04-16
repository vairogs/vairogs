<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Tests\Functions\Php;

use Closure;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;
use Vairogs\Assets\DataProvider\Functions\Php\PhpDataProvider;
use Vairogs\Functions\Php\Traits\_Bind;
use Vairogs\Functions\Php\Traits\_Get;
use Vairogs\Functions\Php\Traits\_GetNonStatic;
use Vairogs\Functions\Php\Traits\_GetStatic;
use Vairogs\Functions\Php\Traits\_Return;
use Vairogs\Functions\Php\Traits\_Set;
use Vairogs\Functions\Php\Traits\_SetNonStatic;
use Vairogs\Functions\Php\Traits\_SetStatic;

use function sprintf;

class PhpTest extends TestCase
{
    #[DataProviderExternal(PhpDataProvider::class, 'provideBindMethod')]
    public function testBind(
        callable $function,
        object $clone,
        mixed $expected,
    ): void {
        $closure = new class {
            use _Bind;
        }->bind($function, $clone);
        $this->assertInstanceOf(Closure::class, $closure);
        $this->assertSame($expected, $closure());
    }

    #[DataProviderExternal(PhpDataProvider::class, 'provideGetMethod')]
    public function testGet(
        object $object,
        string $property,
        bool $throwOnUnInitialized,
        mixed $expected,
        bool $expectException,
    ): void {
        if ($expectException) {
            $this->expectException(InvalidArgumentException::class);
        }

        $result = new class {
            use _Get;
        }->get($object, $property, $throwOnUnInitialized);

        if (!$expectException) {
            $this->assertSame($expected, $result);
        }
    }

    #[DataProviderExternal(PhpDataProvider::class, 'provideGetNonStaticMethod')]
    public function testGetNonStatic(
        object $object,
        string $property,
        mixed $expected,
        bool $expectException,
    ): void {
        if ($expectException) {
            $this->expectException(InvalidArgumentException::class);
            $this->expectExceptionMessage(sprintf('Property "%s" is static', $property));
        }

        $result = new class {
            use _GetNonStatic;
        }->getNonStatic($object, $property);

        if (!$expectException) {
            $this->assertSame($expected, $result);
        }
    }

    #[DataProviderExternal(PhpDataProvider::class, 'provideGetStaticMethod')]
    public function testGetStatic(
        object $object,
        string $property,
        mixed $expected,
        bool $expectException,
    ): void {
        if ($expectException) {
            $this->expectException(InvalidArgumentException::class);
            $this->expectExceptionMessage(sprintf('Property "%s" is not static', $property));
        }

        $result = new class {
            use _GetStatic;
        }->getStatic($object, $property);

        if (!$expectException) {
            $this->assertSame($expected, $result);
        }
    }

    #[DataProviderExternal(PhpDataProvider::class, 'provideReturnMethod')]
    public function testReturn(
        callable $function,
        object $clone,
        array $arguments,
        mixed $expected,
    ): void {
        $result = new class {
            use _Return;
        }->return($function, $clone, ...$arguments);
        $this->assertSame($expected, $result);
    }

    #[DataProviderExternal(PhpDataProvider::class, 'provideSetMethod')]
    public function testSet(
        object $object,
        string $property,
        mixed $value,
        bool $expectException,
    ): void {
        if ($expectException) {
            $this->expectException(InvalidArgumentException::class);
        }

        new class {
            use _Set;
        }->set($object, $property, $value);

        if (!$expectException) {
            $result = new class {
                use _Get;
            }->get($object, $property);
            $this->assertSame($value, $result);
        }
    }

    #[DataProviderExternal(PhpDataProvider::class, 'provideSetNonStaticMethod')]
    public function testSetNonStatic(
        object $object,
        string $property,
        mixed $value,
        bool $expectException,
    ): void {
        if ($expectException) {
            $this->expectException(InvalidArgumentException::class);
            $this->expectExceptionMessage(sprintf('Property "%s" is static', $property));
        }

        new class {
            use _SetNonStatic;
        }->setNonStatic($object, $property, $value);

        if (!$expectException) {
            $this->assertSame($value, new class {
                use _GetNonStatic;
            }->getNonStatic($object, $property));
        }
    }

    #[DataProviderExternal(PhpDataProvider::class, 'provideSetStaticMethod')]
    public function testSetStatic(
        object $object,
        string $property,
        mixed $value,
        bool $expectException,
    ): void {
        if ($expectException) {
            $this->expectException(InvalidArgumentException::class);
            $this->expectExceptionMessage(sprintf('Property "%s" is not static', $property));
        }

        new class {
            use _SetStatic;
        }->setStatic($object, $property, $value);

        if (!$expectException) {
            $result = new class {
                use _GetStatic;
            }->getStatic($object, $property);
            $this->assertSame($value, $result);
        }
    }
}
