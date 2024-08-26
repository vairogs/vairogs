<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\Functions\Local;

use function class_exists;
use function interface_exists;
use function is_object;
use function trait_exists;

trait _Exists
{
    public function exists(
        string|object $class,
    ): bool {
        if (is_object($class)) {
            $class = $class::class;
        }

        return class_exists(class: $class) || interface_exists(interface: $class) || trait_exists(trait: $class);
    }
}
