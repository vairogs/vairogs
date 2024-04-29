<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Local;

use function class_exists;
use function interface_exists;
use function trait_exists;

trait _Exists
{
    public function exists(
        string $class,
    ): bool {
        return class_exists(class: $class) || interface_exists(interface: $class) || trait_exists(trait: $class);
    }
}
