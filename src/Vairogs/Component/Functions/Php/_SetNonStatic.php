<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Php;

use Exception;
use InvalidArgumentException;
use ReflectionProperty;

use function sprintf;

trait _SetNonStatic
{
    /**
     * @throws InvalidArgumentException
     */
    public function setNonStatic(
        object $object,
        string $property,
        mixed $value,
    ): object {
        try {
            if ((new ReflectionProperty(class: $object, property: $property))->isStatic()) {
                throw new InvalidArgumentException(message: 'non static property');
            }
        } catch (Exception) {
            throw new InvalidArgumentException(message: sprintf('Property "%s" is static', $property));
        }

        (new class {
            use _Void;
        })->void(function: function () use ($object, $property, $value): void {
            $object->{$property} = $value;
        }, clone: $object);

        return $object;
    }
}
