<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Php;

use Exception;
use InvalidArgumentException;
use ReflectionProperty;

use function sprintf;

trait _GetStatic
{
    /**
     * @throws InvalidArgumentException
     */
    public function getStatic(
        object $object,
        string $property,
        mixed ...$arguments,
    ): mixed {
        try {
            if ((new ReflectionProperty(class: $object, property: $property))->isStatic()) {
                return (new class {
                    use _Return;
                })->return(static fn () => $object::${$property}, $object, ...$arguments);
            }
        } catch (Exception) {
            // exception === unable to get object property
        }

        throw new InvalidArgumentException(message: sprintf('Property "%s" is not static', $property));
    }
}
