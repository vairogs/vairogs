<?php declare(strict_types = 1);

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
