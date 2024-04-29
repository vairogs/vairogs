<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Sort;

use function count;

trait _BubbleSort
{
    public function bubbleSort(
        array &$array,
    ): void {
        $count = count(value: $array);
        for ($foo = 0; $foo < $count; $foo++) {
            for ($bar = 0; $bar < $count - 1; $bar++) {
                if ($bar < $count && $array[$bar] > $array[$bar + 1]) {
                    (new class() {
                        use _SwapArray;
                    })->swapArray(array: $array, foo: $bar, bar: $bar + 1);
                }
            }
        }
    }
}
