<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Iteration;

use function array_intersect_key;
use function array_keys;
use function is_array;

trait _ArrayIntersectKeyRecursive
{
    public function arrayIntersectKeyRecursive(
        array $first = [],
        array $second = [],
    ): array {
        $result = array_intersect_key($first, $second);

        foreach (array_keys(array: $result) as $key) {
            if (is_array(value: $first[$key]) && is_array(value: $second[$key])) {
                $result[$key] = $this->arrayIntersectKeyRecursive(first: $first[$key], second: $second[$key]);
            }
        }

        return $result;
    }
}
