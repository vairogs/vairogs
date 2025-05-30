<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Functions\Php\Traits;

use Exception;
use InvalidArgumentException;
use ReflectionException;
use ReflectionProperty;

use function sprintf;

trait _Set
{
    /**
     * @throws InvalidArgumentException
     */
    public function set(
        object $object,
        string $property,
        mixed $value,
    ): object {
        try {
            new ReflectionProperty(class: $object, property: $property);
        } catch (ReflectionException) {
            throw new InvalidArgumentException(message: sprintf('Unable to set property "%s" of object %s', $property, $object::class));
        }

        static $_helper = null;

        if (null === $_helper) {
            $_helper = new class {
                use _SetNonStatic;
                use _SetStatic;
            };
        }

        try {
            return $_helper->setNonStatic(object: $object, property: $property, value: $value);
        } catch (Exception) {
            // exception === unable to get object property
        }

        return $_helper->setStatic(object: $object, property: $property, value: $value);
    }
}
