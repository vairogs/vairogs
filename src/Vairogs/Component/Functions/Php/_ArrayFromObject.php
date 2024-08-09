<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Php;

use ReflectionObject;

trait _ArrayFromObject
{
    public function arrayFromObject(object $object): array
    {
        $input = [];

        foreach ((new ReflectionObject(object: $object))->getProperties() as $reflectionProperty) {
            $input[$name = $reflectionProperty->getName()] = (new class {
                use _Get;
            })->get(object: $object, property: $name);
        }

        return $input;
    }
}
