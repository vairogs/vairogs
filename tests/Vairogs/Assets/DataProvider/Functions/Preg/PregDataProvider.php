<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Assets\DataProvider\Functions\Preg;

use function strtoupper;

use const PREG_PATTERN_ORDER;
use const PREG_SET_ORDER;
use const PREG_SPLIT_DELIM_CAPTURE;
use const PREG_SPLIT_NO_EMPTY;

class PregDataProvider
{
    public static function provideMatchAllMethod(): array
    {
        return [
            'test matchAll with simple pattern' => [
                'pattern' => '/test/',
                'subject' => 'test test test',
                'matches' => null,
                'flags' => PREG_PATTERN_ORDER,
                'offset' => 0,
                'expectedResult' => 3,
                'expectedMatches' => [['test', 'test', 'test']],
            ],
            'test matchAll with capturing groups' => [
                'pattern' => '/(\w+)\s+(\w+)/',
                'subject' => 'Hello World, Hello Universe',
                'matches' => null,
                'flags' => PREG_PATTERN_ORDER,
                'offset' => 0,
                'expectedResult' => 2,
                'expectedMatches' => [
                    ['Hello World', 'Hello Universe'],
                    ['Hello', 'Hello'],
                    ['World', 'Universe'],
                ],
            ],
            'test matchAll with set order' => [
                'pattern' => '/(\w+)\s+(\w+)/',
                'subject' => 'Hello World, Hello Universe',
                'matches' => null,
                'flags' => PREG_SET_ORDER,
                'offset' => 0,
                'expectedResult' => 2,
                'expectedMatches' => [
                    ['Hello World', 'Hello', 'World'],
                    ['Hello Universe', 'Hello', 'Universe'],
                ],
            ],
            'test matchAll with offset' => [
                'pattern' => '/test/',
                'subject' => 'test test test',
                'matches' => null,
                'flags' => PREG_PATTERN_ORDER,
                'offset' => 5,
                'expectedResult' => 2,
                'expectedMatches' => [['test', 'test']],
            ],
            'test matchAll with no matches' => [
                'pattern' => '/nonexistent/',
                'subject' => 'This is a test string',
                'matches' => null,
                'flags' => PREG_PATTERN_ORDER,
                'offset' => 0,
                'expectedResult' => 0,
                'expectedMatches' => [[]],
            ],
            'test matchAll with empty subject' => [
                'pattern' => '/test/',
                'subject' => '',
                'matches' => null,
                'flags' => PREG_PATTERN_ORDER,
                'offset' => 0,
                'expectedResult' => 0,
                'expectedMatches' => [[]],
            ],
        ];
    }

    public static function provideMatchMethod(): array
    {
        return [
            'test match with simple pattern' => [
                'pattern' => '/test/',
                'subject' => 'This is a test string',
                'matches' => null,
                'flags' => 0,
                'offset' => 0,
                'expectedResult' => true,
                'expectedMatches' => ['test'],
            ],
            'test match with capturing groups' => [
                'pattern' => '/(\w+)\s+(\w+)/',
                'subject' => 'Hello World',
                'matches' => null,
                'flags' => 0,
                'offset' => 0,
                'expectedResult' => true,
                'expectedMatches' => ['Hello World', 'Hello', 'World'],
            ],
            'test match with offset' => [
                'pattern' => '/test/',
                'subject' => 'This is a test string',
                'matches' => null,
                'flags' => 0,
                'offset' => 10,
                'expectedResult' => true,
                'expectedMatches' => ['test'],
            ],
            'test match with negative offset' => [
                'pattern' => '/test/',
                'subject' => 'This is a test string',
                'matches' => null,
                'flags' => 0,
                'offset' => -1,
                'expectedResult' => false,
                'expectedMatches' => [],
            ],
            'test match with no match' => [
                'pattern' => '/nonexistent/',
                'subject' => 'This is a test string',
                'matches' => null,
                'flags' => 0,
                'offset' => 0,
                'expectedResult' => false,
                'expectedMatches' => [],
            ],
            'test match with empty subject' => [
                'pattern' => '/test/',
                'subject' => '',
                'matches' => null,
                'flags' => 0,
                'offset' => 0,
                'expectedResult' => false,
                'expectedMatches' => [],
            ],
        ];
    }

    public static function provideReplaceCallbackMethod(): array
    {
        return [
            'test replaceCallback with simple pattern' => [
                'pattern' => '/test/',
                'callback' => fn (array $matches) => strtoupper($matches[0]),
                'subject' => 'This is a test string',
                'limit' => -1,
                'count' => null,
                'expectedResult' => 'This is a TEST string',
                'expectedCount' => 1,
            ],
            'test replaceCallback with multiple occurrences' => [
                'pattern' => '/test/',
                'callback' => fn (array $matches) => strtoupper($matches[0]),
                'subject' => 'test test test',
                'limit' => -1,
                'count' => null,
                'expectedResult' => 'TEST TEST TEST',
                'expectedCount' => 3,
            ],
            'test replaceCallback with limit' => [
                'pattern' => '/test/',
                'callback' => fn (array $matches) => strtoupper($matches[0]),
                'subject' => 'test test test',
                'limit' => 2,
                'count' => null,
                'expectedResult' => 'TEST TEST test',
                'expectedCount' => 2,
            ],
            'test replaceCallback with capturing groups' => [
                'pattern' => '/(\w+)\s+(\w+)/',
                'callback' => fn (array $matches) => $matches[2] . ' ' . $matches[1],
                'subject' => 'Hello World',
                'limit' => -1,
                'count' => null,
                'expectedResult' => 'World Hello',
                'expectedCount' => 1,
            ],
            'test replaceCallback with no matches' => [
                'pattern' => '/nonexistent/',
                'callback' => fn (array $matches) => strtoupper($matches[0]),
                'subject' => 'This is a test string',
                'limit' => -1,
                'count' => null,
                'expectedResult' => 'This is a test string',
                'expectedCount' => 0,
            ],
            'test replaceCallback with array pattern' => [
                'pattern' => ['/test/', '/string/'],
                'callback' => fn (array $matches) => strtoupper($matches[0]),
                'subject' => 'This is a test string',
                'limit' => -1,
                'count' => null,
                'expectedResult' => 'This is a TEST STRING',
                'expectedCount' => 2,
            ],
        ];
    }

    public static function provideReplaceMethod(): array
    {
        return [
            'test replace with simple pattern' => [
                'pattern' => '/test/',
                'replacement' => 'example',
                'subject' => 'This is a test string',
                'limit' => -1,
                'count' => null,
                'expectedResult' => 'This is a example string',
                'expectedCount' => 1,
            ],
            'test replace with multiple occurrences' => [
                'pattern' => '/test/',
                'replacement' => 'example',
                'subject' => 'test test test',
                'limit' => -1,
                'count' => null,
                'expectedResult' => 'example example example',
                'expectedCount' => 3,
            ],
            'test replace with limit' => [
                'pattern' => '/test/',
                'replacement' => 'example',
                'subject' => 'test test test',
                'limit' => 2,
                'count' => null,
                'expectedResult' => 'example example test',
                'expectedCount' => 2,
            ],
            'test replace with no matches' => [
                'pattern' => '/nonexistent/',
                'replacement' => 'example',
                'subject' => 'This is a test string',
                'limit' => -1,
                'count' => null,
                'expectedResult' => 'This is a test string',
                'expectedCount' => 0,
            ],
            'test replace with array pattern' => [
                'pattern' => ['/test/', '/string/'],
                'replacement' => 'example',
                'subject' => 'This is a test string',
                'limit' => -1,
                'count' => null,
                'expectedResult' => 'This is a example example',
                'expectedCount' => 2,
            ],
        ];
    }

    public static function provideSplitMethod(): array
    {
        return [
            'test split with simple pattern' => [
                'pattern' => '/\s+/',
                'subject' => 'This is a test',
                'limit' => -1,
                'flags' => 0,
                'expectedResult' => ['This', 'is', 'a', 'test'],
            ],
            'test split with capturing groups' => [
                'pattern' => '/(,\s*)/',
                'subject' => 'one, two, three',
                'limit' => -1,
                'flags' => PREG_SPLIT_DELIM_CAPTURE,
                'expectedResult' => ['one', ', ', 'two', ', ', 'three'],
            ],
            'test split with no empty' => [
                'pattern' => '/[,\s]+/',
                'subject' => 'one, , two,  , three',
                'limit' => -1,
                'flags' => PREG_SPLIT_NO_EMPTY,
                'expectedResult' => ['one', 'two', 'three'],
            ],
            'test split with limit' => [
                'pattern' => '/\s+/',
                'subject' => 'This is a test',
                'limit' => 2,
                'flags' => 0,
                'expectedResult' => ['This', 'is a test'],
            ],
            'test split with empty string' => [
                'pattern' => '/\s+/',
                'subject' => '',
                'limit' => -1,
                'flags' => 0,
                'expectedResult' => [''],
            ],
        ];
    }
}
