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

use function array_values;

trait _ArrayValuesFiltered
{
    /**
     * @throws InvalidArgumentException
     */
    public function arrayValuesFiltered(
        array $input,
        string $with,
        bool $start = true,
    ): array {
        static $_helper = null;

        if (null === $_helper) {
            $_helper = new class {
                use _FilterKeyEndsWith;
                use _FilterKeyStartsWith;
            };
        }

        return match ($start) {
            true => array_values(array: $_helper->filterKeyStartsWith(input: $input, startsWith: $with)),
            false => array_values(array: $_helper->filterKeyEndsWith(input: $input, endsWith: $with)),
        };
    }
}
