<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\Functions\Php;

use Exception;
use InvalidArgumentException;
use ReflectionProperty;

use function sprintf;

trait _SetStatic
{
    /**
     * @throws InvalidArgumentException
     */
    public function setStatic(
        object $object,
        string $property,
        mixed $value,
    ): object {
        try {
            if ((new ReflectionProperty(class: $object, property: $property))->isStatic()) {
                (new class {
                    use _Void;
                })->void(function: static function () use ($object, $property, $value): void {
                    $object::${$property} = $value;
                }, clone: $object);

                return $object;
            }
        } catch (Exception) {
            // exception === unable to get object property
        }

        throw new InvalidArgumentException(message: sprintf('Property "%s" is not static', $property));
    }
}
