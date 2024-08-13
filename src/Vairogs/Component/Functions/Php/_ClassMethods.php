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

use function array_diff;
use function get_class_methods;

trait _ClassMethods
{
    public function classMethods(
        string $class,
        ?string $parent = null,
    ): array {
        $methods = get_class_methods(object_or_class: $class);
        if (null !== $parent) {
            return array_diff($methods, get_class_methods(object_or_class: $parent));
        }

        return $methods;
    }
}
