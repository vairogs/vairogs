<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Assets\DataProvider;

final class PhpCsFixerCustomFixersDataProvider
{
    public static function provideIssetToArrayKeyExistsFixerCases(): iterable
    {
        yield 'simple array' => [
            '<?php is_array($array) ? array_key_exists("key", $array) : isset($array["key"]);',
            '<?php isset($array["key"]);',
        ];

        yield 'array object' => [
            '<?php isset($arrayObject["key"]);',
            '<?php isset($arrayObject["key"]);',
        ];

        yield 'multiple isset arguments' => [
            '<?php isset($array["key"], $array["key2"]);',
            '<?php isset($array["key"], $array["key2"]);',
        ];

        yield 'nested array access' => [
            '<?php isset($array["first"]["second"]);',
            '<?php isset($array["first"]["second"]);',
        ];

        yield 'variable as key' => [
            '<?php is_array($array) ? array_key_exists($key, $array) : isset($array[$key]);',
            '<?php isset($array[$key]);',
        ];

        yield 'object property access' => [
            '<?php isset($object->property["key"]);',
            '<?php isset($object->property["key"]);',
        ];

        yield 'array object instantiation' => [
            '<?php isset((new \ArrayObject([]))["key"]);',
            '<?php isset((new \ArrayObject([]))["key"]);',
        ];

        yield 'array object variable' => [
            '<?php isset($arrayObject["key"]);',
            '<?php isset($arrayObject["key"]);',
        ];

        yield 'array object with namespace' => [
            '<?php isset($obj["key"]); isset(\ArrayObject["key"]);',
            '<?php isset($obj["key"]); isset(\ArrayObject["key"]);',
        ];
    }
}
