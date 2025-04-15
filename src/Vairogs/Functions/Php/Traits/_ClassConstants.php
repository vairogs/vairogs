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

use BadFunctionCallException;
use Exception;
use InvalidArgumentException;
use ReflectionClassConstant;
use RuntimeException;

trait _ClassConstants
{
    /**
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function classConstants(
        string $class,
    ): array {
        static $_helper = null;

        if (null === $_helper) {
            $_helper = new class {
                use _GetReflection;
            };
        }

        try {
            return $_helper->getReflection($class)->getConstants(filter: ReflectionClassConstant::IS_PUBLIC);
        } catch (Exception $e) {
            throw new BadFunctionCallException(message: $e->getMessage(), code: $e->getCode(), previous: $e);
        }
    }
}
