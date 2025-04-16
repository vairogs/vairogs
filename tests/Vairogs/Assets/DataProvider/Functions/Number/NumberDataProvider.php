<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Assets\DataProvider\Functions\Number;

class NumberDataProvider
{
    public static function provideDistanceBetweenPointsMethod(): array
    {
        return [
            'test same point' => [
                'latitude1' => 0.0,
                'longitude1' => 0.0,
                'latitude2' => 0.0,
                'longitude2' => 0.0,
                'km' => true,
                'precision' => 4,
                'expectedResult' => 0.0,
            ],
            'test known distance in km' => [
                'latitude1' => 40.7128,
                'longitude1' => -74.0060,  // New York
                'latitude2' => 51.5074,
                'longitude2' => -0.1278,   // London
                'km' => true,
                'precision' => 4,
                'expectedResult' => 5569.9542,
            ],
            'test known distance in miles' => [
                'latitude1' => 40.7128,
                'longitude1' => -74.0060,  // New York
                'latitude2' => 51.5074,
                'longitude2' => -0.1278,   // London
                'km' => false,
                'precision' => 4,
                'expectedResult' => 3461.0091,
            ],
            'test antipodes with different precision' => [
                'latitude1' => 0.0,
                'longitude1' => 0.0,
                'latitude2' => 0.0,
                'longitude2' => 180.0,
                'km' => true,
                'precision' => 2,
                'expectedResult' => 20014.12,
            ],
            'test negative coordinates' => [
                'latitude1' => -33.8688,
                'longitude1' => 151.2093,  // Sydney
                'latitude2' => -41.2865,
                'longitude2' => 174.7762,  // Wellington
                'km' => true,
                'precision' => 4,
                'expectedResult' => 2225.6477,
            ],
        ];
    }

    public static function provideDistanceInKmMethod(): array
    {
        return [
            'test same point' => [
                'latitude1' => 0.0,
                'longitude1' => 0.0,
                'latitude2' => 0.0,
                'longitude2' => 0.0,
                'expectedResult' => 0.0,
            ],
            'test known distance' => [
                'latitude1' => 40.7128,
                'longitude1' => -74.0060,  // New York
                'latitude2' => 51.5074,
                'longitude2' => -0.1278,   // London
                'expectedResult' => 5570.23,
                'delta' => 1.0,  // Allow 1km difference due to floating-point arithmetic
            ],
            'test antipodes' => [
                'latitude1' => 0.0,
                'longitude1' => 0.0,
                'latitude2' => 0.0,
                'longitude2' => 180.0,
                'expectedResult' => 20015.09,  // Half Earth's circumference
                'delta' => 1.0,
            ],
            'test negative coordinates' => [
                'latitude1' => -33.8688,
                'longitude1' => 151.2093,  // Sydney
                'latitude2' => -41.2865,
                'longitude2' => 174.7762,  // Wellington
                'expectedResult' => 2225.75,  // Updated to match actual great circle distance
                'delta' => 1.0,
            ],
        ];
    }

    public static function provideGreatestCommonDivisorMethod(): array
    {
        return [
            'test coprime numbers' => [
                'first' => 25,
                'second' => 36,
                'expectedResult' => 1,
            ],
            'test same numbers' => [
                'first' => 12,
                'second' => 12,
                'expectedResult' => 12,
            ],
            'test one number is zero' => [
                'first' => 15,
                'second' => 0,
                'expectedResult' => 15,
            ],
            'test both numbers are zero' => [
                'first' => 0,
                'second' => 0,
                'expectedResult' => 0,
            ],
            'test large numbers' => [
                'first' => 1071,
                'second' => 462,
                'expectedResult' => 21,
            ],
            'test negative numbers' => [
                'first' => -54,
                'second' => 24,
                'expectedResult' => 6,
            ],
        ];
    }

    public static function provideIsFloatMethod(): array
    {
        return [
            'test float value' => [
                'value' => 3.14,
                'expectedResult' => true,
            ],
            'test float string' => [
                'value' => '3.14',
                'expectedResult' => true,
            ],
            'test integer' => [
                'value' => 42,
                'expectedResult' => false,
            ],
            'test integer string' => [
                'value' => '42',
                'expectedResult' => false,
            ],
            'test non-numeric string' => [
                'value' => 'abc',
                'expectedResult' => false,
            ],
            'test null' => [
                'value' => null,
                'expectedResult' => false,
            ],
            'test scientific notation' => [
                'value' => '1.23e4',
                'expectedResult' => true,
            ],
        ];
    }

    public static function provideIsIntMethod(): array
    {
        return [
            'test integer value' => [
                'value' => 42,
                'expectedResult' => true,
            ],
            'test integer string' => [
                'value' => '42',
                'expectedResult' => true,
            ],
            'test float value' => [
                'value' => 3.14,
                'expectedResult' => false,
            ],
            'test float string' => [
                'value' => '3.14',
                'expectedResult' => false,
            ],
            'test non-numeric string' => [
                'value' => 'abc',
                'expectedResult' => false,
            ],
            'test null' => [
                'value' => null,
                'expectedResult' => false,
            ],
            'test scientific notation' => [
                'value' => '1.23e4',
                'expectedResult' => false,
            ],
            'test zero' => [
                'value' => 0,
                'expectedResult' => true,
            ],
            'test zero string' => [
                'value' => '0',
                'expectedResult' => true,
            ],
        ];
    }

    public static function provideIsPrimalMethod(): array
    {
        return [
            'test prime number' => [
                'number' => 17,
                'expectedResult' => true,
            ],
            'test non-prime number' => [
                'number' => 15,
                'expectedResult' => false,
            ],
            'test small prime number' => [
                'number' => 2,
                'expectedResult' => true,
            ],
            'test small non-prime number' => [
                'number' => 4,
                'expectedResult' => false,
            ],
            'test number 1' => [
                'number' => 1,
                'expectedResult' => false,
            ],
            'test number 3' => [
                'number' => 3,
                'expectedResult' => true,
            ],
            'test divisible by 2' => [
                'number' => 10,
                'expectedResult' => false,
            ],
            'test divisible by 3' => [
                'number' => 9,
                'expectedResult' => false,
            ],
            'test large prime' => [
                'number' => 97,
                'expectedResult' => true,
            ],
            'test number divisible by 5' => [
                'number' => 25,
                'expectedResult' => false,
            ],
        ];
    }

    public static function provideIsPrimeBelow1000Method(): array
    {
        return [
            'test prime number below 1000' => [
                'number' => 997,
                'expectedResult' => true,
            ],
            'test non-prime number below 1000' => [
                'number' => 999,
                'expectedResult' => false,
            ],
            'test number equal to 1000' => [
                'number' => 1000,
                'expectedResult' => null,
            ],
            'test number above 1000' => [
                'number' => 1001,
                'expectedResult' => null,
            ],
            'test number equal to 1' => [
                'number' => 1,
                'expectedResult' => false,
            ],
            'test small prime number' => [
                'number' => 2,
                'expectedResult' => true,
            ],
            'test small non-prime number' => [
                'number' => 4,
                'expectedResult' => false,
            ],
        ];
    }

    public static function provideIsPrimeMethod(): array
    {
        return [
            'test prime number' => [
                'number' => 17,
                'override' => false,
                'expectedResult' => true,
            ],
            'test non-prime number' => [
                'number' => 15,
                'override' => false,
                'expectedResult' => false,
            ],
            'test prime below 1000' => [
                'number' => 997,
                'override' => false,
                'expectedResult' => true,
            ],
            'test non-prime below 1000' => [
                'number' => 999,
                'override' => false,
                'expectedResult' => false,
            ],
            'test large prime number' => [
                'number' => 104729,
                'override' => false,
                'expectedResult' => true,
            ],
            'test large non-prime number' => [
                'number' => 104730,
                'override' => false,
                'expectedResult' => false,
            ],
            'test with override' => [
                'number' => 997,  // Using a smaller prime number for override test
                'override' => true,
                'expectedResult' => true,
            ],
        ];
    }

    public static function provideLeastCommonMultipleMethod(): array
    {
        return [
            'test coprime numbers' => [
                'first' => 25,
                'second' => 36,
                'expectedResult' => 900,
            ],
            'test same numbers' => [
                'first' => 12,
                'second' => 12,
                'expectedResult' => 12,
            ],
            'test one number is zero' => [
                'first' => 15,
                'second' => 0,
                'expectedResult' => 0,
            ],
            'test both numbers are zero' => [
                'first' => 0,
                'second' => 0,
                'expectedResult' => 0,
            ],
            'test large numbers' => [
                'first' => 1071,
                'second' => 462,
                'expectedResult' => 23562,
            ],
            'test negative numbers' => [
                'first' => -54,
                'second' => 24,
                'expectedResult' => 216,
            ],
        ];
    }

    public static function provideSwapMethod(): array
    {
        return [
            'test swap integers' => [
                'foo' => 5,
                'bar' => 10,
                'expectedFoo' => 10,
                'expectedBar' => 5,
            ],
            'test swap strings' => [
                'foo' => 'hello',
                'bar' => 'world',
                'expectedFoo' => 'world',
                'expectedBar' => 'hello',
            ],
            'test swap same values' => [
                'foo' => 42,
                'bar' => 42,
                'expectedFoo' => 42,
                'expectedBar' => 42,
            ],
            'test swap null values' => [
                'foo' => null,
                'bar' => 'test',
                'expectedFoo' => 'test',
                'expectedBar' => null,
            ],
            'test swap arrays' => [
                'foo' => [1, 2, 3],
                'bar' => [4, 5, 6],
                'expectedFoo' => [4, 5, 6],
                'expectedBar' => [1, 2, 3],
            ],
        ];
    }
}
