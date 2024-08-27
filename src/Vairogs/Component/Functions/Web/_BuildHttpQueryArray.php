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

use ReflectionException;
use Vairogs\Component\Functions\Php;

use function sprintf;

trait _BuildHttpQueryArray
{
    /**
     * @throws ReflectionException
     */
    public function buildHttpQueryArray(
        array|object $input,
        ?string $parent = null,
    ): array {
        $result = [];

        static $_helper = null;

        if (null === $_helper) {
            $_helper = new class {
                use _Result;
                use Php\_Array;
            };
        }

        foreach ($_helper->array(input: $input) as $key => $value) {
            $newKey = match ($parent) {
                null => $key,
                default => sprintf('%s[%s]', $parent, $key),
            };

            $result = $_helper->result(result: $result, key: $newKey, value: $value);
        }

        return $result;
    }
}
