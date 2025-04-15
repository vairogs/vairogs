<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Functions\Iteration\Traits;

use RuntimeException;
use Symfony\Component\PropertyAccess\PropertyAccess;

use function is_object;
use function sprintf;

trait _Value
{
    public function value(
        array|object $objectOrArray,
        string|int $field,
        bool $throw = true,
    ): mixed {
        if (is_object(value: $objectOrArray)) {
            $result = PropertyAccess::createPropertyAccessor()->getValue(objectOrArray: $objectOrArray, propertyPath: $field);
        } else {
            $result = $objectOrArray[$field] ?? null;
        }

        if (null === $result && $throw) {
            throw new RuntimeException(message: sprintf('Field "%s" does not exist', $field));
        }

        return $result;
    }
}
