<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Php;

use InvalidArgumentException;
use RuntimeException;

use function array_values;

trait _ClassConstantsValues
{
    /**
     * @throws RuntimeException
     * @throws InvalidArgumentException
     */
    public function classConstantsValues(string $class): array
    {
        return array_values(array: (new class() {
            use _ClassConstants;
        })->classConstants(class: $class));
    }
}
