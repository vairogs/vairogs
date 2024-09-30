<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\Functions\Php;

use Exception;
use ReflectionMethod;
use Vairogs\Component\Functions\Text;

trait _FilteredMethods
{
    public function definition(
        string $class,
        string $name,
        bool $isStatic = false,
    ): array {
        if ($isStatic) {
            return [$class, $name, ];
        }

        return [new $class(), $name, ];
    }

    public function filteredMethods(
        string $class,
        ?string $filterClass = null,
    ): array {
        static $_helper = null;

        if (null === $_helper) {
            $_helper = new class {
                use _AttributeExists;
                use _FilteredMethods;
                use _GetReflection;
                use Text\_SnakeCaseFromCamelCase;
            };
        }

        try {
            $methods = $_helper->getReflection($class)->getMethods(filter: ReflectionMethod::IS_PUBLIC);
        } catch (Exception) {
            return [];
        }

        $filtered = [];

        foreach ($methods as $method) {
            if (null === $filterClass || $_helper->attributeExists(reflectionMethod: $method, filterClass: $filterClass)) {
                $filtered[$_helper->snakeCaseFromCamelCase(string: $name = $method->getName())] = $_helper->definition(class: $class, name: $name, isStatic: $method->isStatic());
            }
        }

        return $filtered;
    }
}
