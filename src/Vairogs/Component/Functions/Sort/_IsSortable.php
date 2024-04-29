<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Sort;

use function array_key_exists;
use function is_array;
use function is_object;
use function property_exists;

trait _IsSortable
{
    public function isSortable(
        mixed $item,
        int|string $field,
    ): bool {
        if (is_array(value: $item)) {
            return array_key_exists(key: $field, array: $item);
        }

        if (is_object(value: $item)) {
            return isset($item->{$field}) || property_exists(object_or_class: $item, property: $field);
        }

        return false;
    }
}
