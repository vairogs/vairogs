<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Php;

use Exception;
use ReflectionClass;
use ReflectionMethod;
use Vairogs\Component\Functions\Text;

trait _FilteredMethods
{
    public function filteredMethods(string $class, ?string $filterClass = null): array
    {
        try {
            $methods = (new ReflectionClass(objectOrClass: $class))->getMethods(filter: ReflectionMethod::IS_PUBLIC);
        } catch (Exception) {
            return [];
        }

        $filtered = [];

        foreach ($methods as $method) {
            if (null === $filterClass || (new class {
                use _AttributeExists;
            })->attributeExists(reflectionMethod: $method, filterClass: $filterClass)) {
                $filtered[(new class {
                    use Text\_SnakeCaseFromCamelCase;
                })->snakeCaseFromCamelCase(string: $name = $method->getName())] = $this->definition(class: $class, name: $name, isStatic: $method->isStatic());
            }
        }

        return $filtered;
    }

    public function definition(string $class, string $name, bool $isStatic = false): array
    {
        if ($isStatic) {
            return [$class, $name, ];
        }

        return [new $class(), $name, ];
    }
}
