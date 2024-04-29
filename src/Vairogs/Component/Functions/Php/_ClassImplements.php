<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Php;

use function class_exists;
use function class_implements;
use function interface_exists;

trait _ClassImplements
{
    public function classImplements(string $class, string $interface): bool
    {
        return class_exists(class: $class) && interface_exists(interface: $interface) && isset(class_implements(object_or_class: $class)[$interface]);
    }
}
