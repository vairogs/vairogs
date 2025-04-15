<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Assets\DataProvider\Functions\Sort;

use InvalidArgumentException;

class TestObject
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
    ) {
    }
}

class SortDataProvider
{
    public static function provideBubbleSortMethod(): array
    {
        return [
            'test bubbleSort with integers' => [
                'array' => [3, 1, 4, 1, 5, 9, 2, 6, 5],
                'expectedResult' => [1, 1, 2, 3, 4, 5, 5, 6, 9],
            ],
            'test bubbleSort with strings' => [
                'array' => ['banana', 'apple', 'cherry', 'date'],
                'expectedResult' => ['apple', 'banana', 'cherry', 'date'],
            ],
            'test bubbleSort with empty array' => [
                'array' => [],
                'expectedResult' => [],
            ],
            'test bubbleSort with single element' => [
                'array' => [1],
                'expectedResult' => [1],
            ],
            'test bubbleSort with duplicate elements' => [
                'array' => [3, 3, 3, 1, 1],
                'expectedResult' => [1, 1, 3, 3, 3],
            ],
        ];
    }

    public static function provideMergeSortMethod(): array
    {
        return [
            'test mergeSort with integers' => [
                'array' => [3, 1, 4, 1, 5, 9, 2, 6, 5],
                'expectedResult' => [1, 1, 2, 3, 4, 5, 5, 6, 9],
            ],
            'test mergeSort with strings' => [
                'array' => ['banana', 'apple', 'cherry', 'date'],
                'expectedResult' => ['apple', 'banana', 'cherry', 'date'],
            ],
            'test mergeSort with empty array' => [
                'array' => [],
                'expectedResult' => [],
            ],
            'test mergeSort with single element' => [
                'array' => [1],
                'expectedResult' => [1],
            ],
            'test mergeSort with duplicate elements' => [
                'array' => [3, 3, 3, 1, 1],
                'expectedResult' => [1, 1, 3, 3, 3],
            ],
        ];
    }

    public static function provideSortByParameterMethod(): array
    {
        return [
            'test sortByParameter with array of arrays' => [
                'data' => [
                    ['id' => 3, 'name' => 'Charlie'],
                    ['id' => 1, 'name' => 'Alice'],
                    ['id' => 2, 'name' => 'Bob'],
                ],
                'parameter' => 'name',
                'order' => 'ASC',
                'expectedResult' => [
                    ['id' => 1, 'name' => 'Alice'],
                    ['id' => 2, 'name' => 'Bob'],
                    ['id' => 3, 'name' => 'Charlie'],
                ],
                'expectedException' => null,
            ],
            'test sortByParameter with array of objects' => [
                'data' => [
                    self::createTestObject(3, 'Charlie'),
                    self::createTestObject(1, 'Alice'),
                    self::createTestObject(2, 'Bob'),
                ],
                'parameter' => 'name',
                'order' => 'ASC',
                'expectedResult' => [
                    self::createTestObject(1, 'Alice'),
                    self::createTestObject(2, 'Bob'),
                    self::createTestObject(3, 'Charlie'),
                ],
                'expectedException' => null,
            ],
            'test sortByParameter with DESC order' => [
                'data' => [
                    ['id' => 3, 'name' => 'Charlie'],
                    ['id' => 1, 'name' => 'Alice'],
                    ['id' => 2, 'name' => 'Bob'],
                ],
                'parameter' => 'name',
                'order' => 'DESC',
                'expectedResult' => [
                    ['id' => 3, 'name' => 'Charlie'],
                    ['id' => 2, 'name' => 'Bob'],
                    ['id' => 1, 'name' => 'Alice'],
                ],
                'expectedException' => null,
            ],
            'test sortByParameter with single element' => [
                'data' => [['id' => 1, 'name' => 'Alice']],
                'parameter' => 'name',
                'order' => 'ASC',
                'expectedResult' => [['id' => 1, 'name' => 'Alice']],
                'expectedException' => null,
            ],
            'test sortByParameter with empty array' => [
                'data' => [],
                'parameter' => 'name',
                'order' => 'ASC',
                'expectedResult' => [],
                'expectedException' => null,
            ],
            'test sortByParameter with invalid parameter' => [
                'data' => [
                    ['id' => 1, 'name' => 'Alice'],
                    ['id' => 2, 'name' => 'Bob'],
                ],
                'parameter' => 'nonexistent',
                'order' => 'ASC',
                'expectedResult' => null,
                'expectedException' => InvalidArgumentException::class,
            ],
        ];
    }

    public static function provideStableSortMethod(): array
    {
        return [
            'test stableSort with simple array' => [
                'elements' => [3, 1, 4, 1, 5],
                'getComparedValue' => fn ($x) => $x,
                'compareValues' => fn ($a, $b) => $a <=> $b,
                'expectedResult' => [1, 1, 3, 4, 5],
            ],
            'test stableSort with objects' => [
                'elements' => [
                    ['value' => 3, 'name' => 'Charlie'],
                    ['value' => 1, 'name' => 'Alice'],
                    ['value' => 1, 'name' => 'Bob'],
                ],
                'getComparedValue' => fn ($x) => $x['value'],
                'compareValues' => fn ($a, $b) => $a <=> $b,
                'expectedResult' => [
                    ['value' => 1, 'name' => 'Alice'],
                    ['value' => 1, 'name' => 'Bob'],
                    ['value' => 3, 'name' => 'Charlie'],
                ],
            ],
            'test stableSort with empty array' => [
                'elements' => [],
                'getComparedValue' => fn ($x) => $x,
                'compareValues' => fn ($a, $b) => $a <=> $b,
                'expectedResult' => [],
            ],
            'test stableSort with single element' => [
                'elements' => [1],
                'getComparedValue' => fn ($x) => $x,
                'compareValues' => fn ($a, $b) => $a <=> $b,
                'expectedResult' => [1],
            ],
        ];
    }

    public static function provideUsortMethod(): array
    {
        return [
            'test usort with ASC order' => [
                'parameter' => 'name',
                'order' => 'ASC',
                'first' => ['id' => 1, 'name' => 'Alice'],
                'second' => ['id' => 2, 'name' => 'Bob'],
                'expectedResult' => -1,
            ],
            'test usort with DESC order' => [
                'parameter' => 'name',
                'order' => 'DESC',
                'first' => ['id' => 1, 'name' => 'Alice'],
                'second' => ['id' => 2, 'name' => 'Bob'],
                'expectedResult' => 1,
            ],
            'test usort with equal values' => [
                'parameter' => 'name',
                'order' => 'ASC',
                'first' => ['id' => 1, 'name' => 'Alice'],
                'second' => ['id' => 2, 'name' => 'Alice'],
                'expectedResult' => 0,
            ],
        ];
    }

    private static function createTestObject(int $id, string $name): TestObject
    {
        return new TestObject($id, $name);
    }
} 