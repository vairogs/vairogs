<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Assets\PhpCsFixerCustomFixers\Fixer\DataProvider;

class IssetToArrayKeyExistsFixerDataProvider
{
    public static function provideFixCases(): iterable
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
            '<?php isset($array1["key1"], $array2["key2"]);',
            '<?php isset($array1["key1"], $array2["key2"]);',
        ];

        yield 'nested array access' => [
            '<?php isset($array["key"]["subkey"]);',
            '<?php isset($array["key"]["subkey"]);',
        ];

        yield 'variable as key' => [
            '<?php is_array($array) ? array_key_exists($key, $array) : isset($array[$key]);',
            '<?php isset($array[$key]);',
        ];

        yield 'object property access' => [
            '<?php isset($object->property["key"]);',
            '<?php isset($object->property["key"]);',
        ];

        yield 'method call' => [
            '<?php isset($object->getArray()["key"]);',
            '<?php isset($object->getArray()["key"]);',
        ];

        yield 'static property access' => [
            '<?php isset(MyClass::$array["key"]);',
            '<?php isset(MyClass::$array["key"]);',
        ];
    }
}
