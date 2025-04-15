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

use Doctrine\Persistence\Proxy;
use ReflectionClass;
use ReflectionException;

use function interface_exists;

trait _GetReflection
{
    /**
     * @throws ReflectionException
     */
    public function getReflection(
        object|string $objectOrClass,
    ): ReflectionClass {
        $reflection = new ReflectionClass($objectOrClass);

        if (interface_exists(Proxy::class) && $objectOrClass instanceof Proxy) {
            $reflection = $reflection->getParentClass();
        }

        return $reflection;
    }
}
