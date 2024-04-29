<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Php;

use ReflectionMethod;

trait _AttributeExists
{
    public function attributeExists(ReflectionMethod $reflectionMethod, string $filterClass): bool
    {
        return [] !== $reflectionMethod->getAttributes(name: $filterClass);
    }
}
