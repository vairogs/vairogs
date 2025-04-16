<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Tests\Functions\Number;

use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;
use Vairogs\Assets\DataProvider\Functions\Number\NumberDataProvider;
use Vairogs\Functions\Number\Traits\_DistanceBetweenPoints;
use Vairogs\Functions\Number\Traits\_DistanceInKm;
use Vairogs\Functions\Number\Traits\_GreatestCommonDiviser;
use Vairogs\Functions\Number\Traits\_IsFloat;
use Vairogs\Functions\Number\Traits\_IsInt;
use Vairogs\Functions\Number\Traits\_IsPrimal;
use Vairogs\Functions\Number\Traits\_IsPrime;
use Vairogs\Functions\Number\Traits\_IsPrimeBelow1000;
use Vairogs\Functions\Number\Traits\_LeastCommonMultiple;
use Vairogs\Functions\Number\Traits\_Swap;

class NumberTest extends TestCase
{
    #[DataProviderExternal(NumberDataProvider::class, 'provideDistanceBetweenPointsMethod')]
    public function testDistanceBetweenPoints(
        float $latitude1,
        float $longitude1,
        float $latitude2,
        float $longitude2,
        bool $km,
        int $precision,
        float $expectedResult,
    ): void {
        $result = new class {
            use _DistanceBetweenPoints;
        }->distanceBetweenPoints($latitude1, $longitude1, $latitude2, $longitude2, $km, $precision);
        $this->assertEqualsWithDelta($expectedResult, $result, 0.5);
    }

    #[DataProviderExternal(NumberDataProvider::class, 'provideDistanceInKmMethod')]
    public function testDistanceInKm(
        float $latitude1,
        float $longitude1,
        float $latitude2,
        float $longitude2,
        float $expectedResult,
        ?float $delta = null,
    ): void {
        $result = new class {
            use _DistanceInKm;
        }->distanceInKm($latitude1, $longitude1, $latitude2, $longitude2);

        if (null !== $delta) {
            $this->assertEqualsWithDelta($expectedResult, $result, $delta);
        } else {
            $this->assertSame($expectedResult, $result);
        }
    }

    #[DataProviderExternal(NumberDataProvider::class, 'provideGreatestCommonDivisorMethod')]
    public function testGreatestCommonDivisor(
        int $first,
        int $second,
        int $expectedResult,
    ): void {
        $result = new class {
            use _GreatestCommonDiviser;
        }->greatestCommonDivisor($first, $second);
        $this->assertSame($expectedResult, $result);
    }

    #[DataProviderExternal(NumberDataProvider::class, 'provideIsFloatMethod')]
    public function testIsFloatValue(
        mixed $value,
        bool $expectedResult,
    ): void {
        $result = new class {
            use _IsFloat;
        }->isFloat($value);
        $this->assertSame($expectedResult, $result);
    }

    #[DataProviderExternal(NumberDataProvider::class, 'provideIsIntMethod')]
    public function testIsIntValue(
        mixed $value,
        bool $expectedResult,
    ): void {
        $result = new class {
            use _IsInt;
        }->isInt($value);
        $this->assertSame($expectedResult, $result);
    }

    #[DataProviderExternal(NumberDataProvider::class, 'provideIsPrimalMethod')]
    public function testIsPrimal(
        int $number,
        bool $expectedResult,
    ): void {
        $result = new class {
            use _IsPrimal;
        }->isPrimal($number);
        $this->assertSame($expectedResult, $result);
    }

    #[DataProviderExternal(NumberDataProvider::class, 'provideIsPrimeMethod')]
    public function testIsPrime(
        int $number,
        bool $override,
        bool $expectedResult,
    ): void {
        $result = new class {
            use _IsPrime;
        }->isPrime($number, $override);
        $this->assertSame($expectedResult, $result);
    }

    #[DataProviderExternal(NumberDataProvider::class, 'provideIsPrimeBelow1000Method')]
    public function testIsPrimeBelow1000(
        int $number,
        ?bool $expectedResult,
    ): void {
        $result = new class {
            use _IsPrimeBelow1000;
        }->isPrimeBelow1000($number);
        $this->assertSame($expectedResult, $result);
    }

    #[DataProviderExternal(NumberDataProvider::class, 'provideLeastCommonMultipleMethod')]
    public function testLeastCommonMultiple(
        int $first,
        int $second,
        int $expectedResult,
    ): void {
        $result = new class {
            use _LeastCommonMultiple;
        }->leastCommonMultiple($first, $second);
        $this->assertSame($expectedResult, $result);
    }

    #[DataProviderExternal(NumberDataProvider::class, 'provideSwapMethod')]
    public function testSwap(
        mixed $foo,
        mixed $bar,
        mixed $expectedFoo,
        mixed $expectedBar,
    ): void {
        new class {
            use _Swap;
        }->swap($foo, $bar);
        $this->assertSame($expectedFoo, $foo);
        $this->assertSame($expectedBar, $bar);
    }
}
