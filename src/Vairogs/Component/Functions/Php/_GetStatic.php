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
use InvalidArgumentException;
use ReflectionProperty;

use function sprintf;

trait _GetStatic
{
    /**
     * @throws InvalidArgumentException
     */
    public function getStatic(
        object $object,
        string $property,
        mixed ...$arguments,
    ): mixed {
        try {
            if ((new ReflectionProperty(class: $object, property: $property))->isStatic()) {
                return (new class {
                    use _Return;
                })->return(static fn () => $object::${$property}, $object, ...$arguments);
            }
        } catch (Exception) {
            // exception === unable to get object property
        }

        throw new InvalidArgumentException(message: sprintf('Property "%s" is not static', $property));
    }
}
