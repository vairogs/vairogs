<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Sort;

use function array_slice;
use function count;
use function round;

trait _MergeSort
{
    public function mergeSort(
        array $array,
    ): array {
        if (1 >= count(value: $array)) {
            return $array;
        }

        $middle = (int) round(num: count(value: $array) / 2);
        $left = array_slice(array: $array, offset: 0, length: $middle);
        $right = array_slice(array: $array, offset: $middle);

        $left = $this->mergeSort(array: $left);
        $right = $this->mergeSort(array: $right);

        return $this->merge(left: $left, right: $right);
    }

    private function merge(
        array $left,
        array $right,
    ): array {
        $result = [];
        $i = $j = 0;

        $leftCount = count(value: $left);
        $rightCount = count(value: $right);

        while ($i < $leftCount && $j < $rightCount) {
            if ($left[$i] > $right[$j]) {
                $result[] = $right[$j];
                $j++;
            } else {
                $result[] = $left[$i];
                $i++;
            }
        }

        while ($i < $leftCount) {
            $result[] = $left[$i];
            $i++;
        }

        while ($j < $rightCount) {
            $result[] = $right[$j];
            $j++;
        }

        return $result;
    }
}
