<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Php;

use Exception;
use InvalidArgumentException;
use ReflectionProperty;

use function sprintf;

trait _GetNonStatic
{
    /**
     * @throws InvalidArgumentException
     */
    public function getNonStatic(
        object $object,
        string $property,
        mixed ...$arguments,
    ): mixed {
        try {
            if ((new ReflectionProperty(class: $object, property: $property))->isStatic()) {
                throw new InvalidArgumentException(message: 'non static property');
            }
        } catch (Exception) {
            throw new InvalidArgumentException(message: sprintf('Property "%s" is static', $property));
        }

        return (new class() {
            use _Return;
        })->return(fn () => $object->{$property}, $object, ...$arguments);
    }
}
