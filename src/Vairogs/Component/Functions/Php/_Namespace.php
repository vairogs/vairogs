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
use ReflectionClass;

trait _Namespace
{
    public function namespace(
        string $class,
    ): string {
        try {
            return (new ReflectionClass(objectOrClass: $class))->getNamespaceName();
        } catch (Exception) {
            return '\\';
        }
    }
}
