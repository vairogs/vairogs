<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Php;

use Exception;
use InvalidArgumentException;
use ReflectionException;
use ReflectionProperty;

use function sprintf;

trait _Get
{
    /**
     * @throws InvalidArgumentException
     */
    public function get(
        object $object,
        string $property,
        bool $throwOnUnInitialized = false,
        mixed ...$arguments,
    ): mixed {
        try {
            $reflectionProperty = (new ReflectionProperty(class: $object, property: $property));
        } catch (ReflectionException) {
            throw new InvalidArgumentException(message: sprintf('Unable to get property "%s" of object %s', $property, $object::class));
        }

        if (!$reflectionProperty->isInitialized(object: $object)) {
            if ($throwOnUnInitialized) {
                throw new InvalidArgumentException(message: sprintf('%s::%s must not be accessed before initialization', $object::class, $property));
            }

            return null;
        }

        try {
            return (new class() {
                use _GetNonStatic;
            })->getNonStatic($object, $property, ...$arguments);
        } catch (Exception) {
            // exception === unable to get object property
        }

        return (new class() {
            use _GetStatic;
        })->getStatic($object, $property, ...$arguments);
    }
}
