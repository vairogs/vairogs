<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Functions\Sort\Traits;

use InvalidArgumentException;
use Vairogs\Functions\Iteration;

use function count;
use function current;
use function usort;

trait _SortByParameter
{
    /**
     * @throws InvalidArgumentException
     */
    public function sortByParameter(
        array|object $data,
        string $parameter,
        string $order = 'ASC',
    ): object|array {
        if (count(value: $data) < 2) {
            return $data;
        }

        static $_helper = null;

        if (null === $_helper) {
            $_helper = new class {
                use _Usort;
                use Iteration\Traits\_IsSortable;
            };
        }

        $data = (array) $data;

        if (!$_helper->isSortable(item: current(array: $data), field: $parameter)) {
            throw new InvalidArgumentException(message: "Sorting parameter doesn't exist in sortable variable");
        }

        usort(array: $data, callback: $_helper->usort(parameter: $parameter, order: $order));

        return $data;
    }
}
