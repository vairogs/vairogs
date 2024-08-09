<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\Functions\Web;

use CURLFile;
use ReflectionException;

use function array_merge;
use function is_array;
use function is_object;

trait _Result
{
    /**
     * @throws ReflectionException
     */
    public function result(
        array $result,
        string $key,
        mixed $value,
    ): array {
        if (!$value instanceof CURLFile && (is_array(value: $value) || is_object(value: $value))) {
            return array_merge($result, (new class {
                use _BuildHttpQueryArray;
            })->buildHttpQueryArray(input: $value, parent: $key));
        }

        $result[$key] = $value;

        return $result;
    }
}
