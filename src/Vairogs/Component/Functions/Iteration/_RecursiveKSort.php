<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Iteration;

use function is_array;
use function ksort;

use const SORT_REGULAR;

trait _RecursiveKSort
{
    public function recursiveKSort(
        array &$array,
        int $flags = SORT_REGULAR,
    ): true {
        foreach ($array as &$v) {
            if (is_array($v)) {
                $this->recursiveKSort($v, $flags);
            }
        }
        unset($v);

        return ksort($array, $flags);
    }
}
