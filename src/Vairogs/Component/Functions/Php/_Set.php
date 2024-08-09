<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Php;

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

        try {
            return (new class {
                use _SetNonStatic;
            })->setNonStatic(object: $object, property: $property, value: $value);
        } catch (Exception) {
            // exception === unable to get object property
        }

        return (new class {
            use _SetStatic;
        })->setStatic(object: $object, property: $property, value: $value);
    }
}
