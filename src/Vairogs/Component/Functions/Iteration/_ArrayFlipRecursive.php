<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\Functions\Iteration;

use InvalidArgumentException;

use function array_replace;
use function gettype;

trait _ArrayFlipRecursive
{
    /**
     * @throws InvalidArgumentException
     */
    public function arrayFlipRecursive(
        array $input = [],
    ): array {
        $result = [[]];

        foreach ($input as $key => $element) {
            $result[] = match (gettype(value: $element)) {
                'array', 'object' => [$key => $element, ],
                'integer', 'string' => [$element => $key, ],
                default => throw new InvalidArgumentException(message: 'Value should be array, object, string or integer'),
            };
        }

        return array_replace(...$result);
    }
}
