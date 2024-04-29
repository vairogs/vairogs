<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Php;

use BadFunctionCallException;
use Exception;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionClassConstant;
use RuntimeException;

trait _ClassConstants
{
    /**
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function classConstants(string $class): array
    {
        try {
            return (new ReflectionClass(objectOrClass: $class))->getConstants(filter: ReflectionClassConstant::IS_PUBLIC);
        } catch (Exception $e) {
            throw new BadFunctionCallException(message: $e->getMessage(), code: $e->getCode(), previous: $e);
        }
    }
}
