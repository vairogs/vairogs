<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Assets\Functions\Handler\DataProvider;

class HandlerDataProvider
{
    public static function provideChainOperations(): array
    {
        return [
            'test string transformations' => [
                'initialValue' => 'test',
                'operations' => [
                    fn ($x) => strtoupper($x),
                    fn ($x) => strrev($x),
                ],
                'expectedResult' => 'TSET',
            ],
            'test number operations' => [
                'initialValue' => 5,
                'operations' => [
                    fn ($x) => $x * 2,
                    fn ($x) => $x + 1,
                ],
                'expectedResult' => 11,
            ],
            'test mixed operations' => [
                'initialValue' => '42',
                'operations' => [
                    fn ($x) => (int) $x,
                    fn ($x) => $x * 2,
                    fn ($x) => (string) $x,
                ],
                'expectedResult' => '84',
            ],
        ];
    }

    public static function provideFunctionHandlerGlobalFunctions(): array
    {
        return [
            'test strtoupper' => [
                'function' => 'strtoupper',
                'input' => 'test',
                'expectedResult' => 'TEST',
            ],
            'test strrev' => [
                'function' => 'strrev',
                'input' => 'test',
                'expectedResult' => 'tset',
            ],
            'test trim' => [
                'function' => 'trim',
                'input' => '  test  ',
                'expectedResult' => 'test',
            ],
            'test strlen' => [
                'function' => 'strlen',
                'input' => 'test',
                'expectedResult' => 4,
            ],
        ];
    }
}
