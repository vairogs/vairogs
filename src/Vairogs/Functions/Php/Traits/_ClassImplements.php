<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Functions\Php\Traits;

use function array_key_exists;
use function class_exists;
use function class_implements;
use function interface_exists;

trait _ClassImplements
{
    public function classImplements(
        string $class,
        string $interface,
    ): bool {
        return class_exists(class: $class) && interface_exists(interface: $interface) && array_key_exists($interface, class_implements(object_or_class: $class));
    }
}
