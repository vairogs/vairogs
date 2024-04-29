<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Sort;

use InvalidArgumentException;

use function count;
use function current;
use function usort;

trait _Sort
{
    /**
     * @throws InvalidArgumentException
     */
    public function sort(
        array|object $data,
        string $parameter,
        string $order = 'ASC',
    ): object|array {
        if (count(value: $data) < 2) {
            return $data;
        }

        $data = (array) $data;
        if (!(new class() {
            use _IsSortable;
        })->isSortable(item: current(array: $data), field: $parameter)) {
            throw new InvalidArgumentException(message: "Sorting parameter doesn't exist in sortable variable");
        }

        usort(array: $data, callback: (new class() {
            use _Usort;
        })->usort(parameter: $parameter, order: $order));

        return $data;
    }
}
