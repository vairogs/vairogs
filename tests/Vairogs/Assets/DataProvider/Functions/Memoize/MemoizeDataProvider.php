<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Assets\DataProvider\Functions\Memoize;

use Vairogs\Assets\Enum\Functions\Memoize\MemoizeContext;

class MemoizeDataProvider
{
    public static function provideMemoizeMethod(): array
    {
        return [
            'test memoize method with simple callback' => [
                'context' => MemoizeContext::TEST,
                'key' => 'test_key',
                'callback' => fn () => 'test_value',
                'refresh' => false,
                'subKeys' => [],
                'expectedResult' => 'test_value',
                'expectedSecondCallResult' => 'test_value',
            ],
            'test memoize method with refresh' => [
                'context' => MemoizeContext::TEST,
                'key' => 'refresh_key',
                'callback' => fn () => uniqid('test_', true),
                'refresh' => true,
                'subKeys' => [],
                'expectedResult' => null, // Will be different each time
                'expectedSecondCallResult' => null, // Will be different from first call
            ],
            'test memoize method with subkeys' => [
                'context' => MemoizeContext::OTHER,
                'key' => 'parent_key',
                'callback' => fn () => 'subkey_value',
                'refresh' => false,
                'subKeys' => ['child_key'],
                'expectedResult' => 'subkey_value',
                'expectedSecondCallResult' => 'subkey_value',
            ],
        ];
    }

    public static function provideValueMethod(): array
    {
        return [
            'test value method with existing value' => [
                'context' => MemoizeContext::TEST,
                'key' => 'value_key',
                'callback' => fn () => 'stored_value',
                'refresh' => false,
                'subKeys' => [],
                'expectedResult' => 'stored_value',
                'expectedSecondCallResult' => 'stored_value',
                'defaultValue' => 'default_value',
            ],
            'test value method with non-existing value' => [
                'context' => MemoizeContext::TEST,
                'key' => 'non_existing_key',
                'callback' => null,
                'refresh' => false,
                'subKeys' => [],
                'expectedResult' => 'default_value',
                'expectedSecondCallResult' => 'default_value',
                'defaultValue' => 'default_value',
            ],
            'test value method with subkeys' => [
                'context' => MemoizeContext::OTHER,
                'key' => 'parent_value_key',
                'callback' => fn () => 'subkey_stored_value',
                'refresh' => false,
                'subKeys' => ['child_value_key'],
                'expectedResult' => 'subkey_stored_value',
                'expectedSecondCallResult' => 'subkey_stored_value',
                'defaultValue' => 'default_value',
            ],
            'test value method with wrong subkey' => [
                'context' => MemoizeContext::WRONG,
                'key' => 'parent_value_key',
                'callback' => null,
                'refresh' => false,
                'subKeys' => ['wrong_key', 'child_value_key'],
                'expectedResult' => 'default_value',
                'expectedSecondCallResult' => 'default_value',
                'defaultValue' => 'default_value',
            ],
            'test value method with non-existent last subkey' => [
                'context' => MemoizeContext::OTHER,
                'key' => 'existing_parent_key',
                'callback' => null,
                'refresh' => false,
                'subKeys' => ['existing_child_key', 'non_existent_key'],
                'expectedResult' => 'default_value',
                'expectedSecondCallResult' => 'default_value',
                'defaultValue' => 'default_value',
            ],
        ];
    }
}
