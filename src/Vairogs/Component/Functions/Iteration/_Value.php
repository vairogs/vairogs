<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Iteration;

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
