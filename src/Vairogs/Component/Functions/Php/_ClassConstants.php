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

use BadFunctionCallException;
use Exception;
use InvalidArgumentException;
use ReflectionClass;
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
        try {
            return (new ReflectionClass(objectOrClass: $class))->getConstants(filter: ReflectionClassConstant::IS_PUBLIC);
        } catch (Exception $e) {
            throw new BadFunctionCallException(message: $e->getMessage(), code: $e->getCode(), previous: $e);
        }
    }
}
