<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Functions\Web\Traits;

use ReflectionException;

use function parse_str;

trait _BuildArrayFromObject
{
    /**
     * @throws ReflectionException
     */
    public function buildArrayFromObject(
        object $object,
    ): array {
        static $_helper = null;

        if (null === $_helper) {
            $_helper = new class {
                use _BuildHttpQueryString;
            };
        }

        parse_str(string: $_helper->buildHttpQueryString(object: $object), result: $result);

        return $result;
    }
}
