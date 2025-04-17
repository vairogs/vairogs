<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Assets\Functions\Pagination\DataProvider;

use InvalidArgumentException;

class PaginationDataProvider
{
    public static function providePaginateMethod(): array
    {
        return [
            'test normal pagination (total <= visible)' => [
                'visible' => 10,
                'total' => 5,
                'current' => 3,
                'indicator' => -1,
                'expectedResult' => [1, 2, 3, 4, 5],
                'expectedException' => null,
            ],
            'test normal pagination (total = visible)' => [
                'visible' => 5,
                'total' => 5,
                'current' => 3,
                'indicator' => -1,
                'expectedResult' => [1, 2, 3, 4, 5],
                'expectedException' => null,
            ],
            'test single omitted near last' => [
                'visible' => 5,
                'total' => 10,
                'current' => 2,
                'indicator' => 0,
                'expectedResult' => [1, 2, 3, 0, 10],
                'expectedException' => null,
            ],
            'test single omitted near start' => [
                'visible' => 5,
                'total' => 10,
                'current' => 9,
                'indicator' => 0,
                'expectedResult' => [1, 0, 8, 9, 10],
                'expectedException' => null,
            ],
            'test two omitted sections' => [
                'visible' => 5,
                'total' => 20,
                'current' => 10,
                'indicator' => 0,
                'expectedResult' => [1.0, 0, 10.0, 0, 20.0],
                'expectedException' => null,
            ],
            'test two omitted sections (current in first half)' => [
                'visible' => 5,
                'total' => 20,
                'current' => 5,
                'indicator' => 0,
                'expectedResult' => [1.0, 0, 5.0, 0, 20.0],
                'expectedException' => null,
            ],
            'test invalid visible (less than minimum)' => [
                'visible' => 4,
                'total' => 10,
                'current' => 5,
                'indicator' => -1,
                'expectedResult' => null,
                'expectedException' => InvalidArgumentException::class,
            ],
            'test invalid total (less than 1)' => [
                'visible' => 5,
                'total' => 0,
                'current' => 1,
                'indicator' => -1,
                'expectedResult' => null,
                'expectedException' => InvalidArgumentException::class,
            ],
            'test invalid current (less than 1)' => [
                'visible' => 5,
                'total' => 10,
                'current' => 0,
                'indicator' => -1,
                'expectedResult' => null,
                'expectedException' => InvalidArgumentException::class,
            ],
            'test invalid current (greater than total)' => [
                'visible' => 5,
                'total' => 10,
                'current' => 11,
                'indicator' => -1,
                'expectedResult' => null,
                'expectedException' => InvalidArgumentException::class,
            ],
            'test invalid indicator (between 1 and total)' => [
                'visible' => 5,
                'total' => 10,
                'current' => 5,
                'indicator' => 5,
                'expectedResult' => null,
                'expectedException' => InvalidArgumentException::class,
            ],
        ];
    }
}
