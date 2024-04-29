<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Sort;

trait _SwapArray
{
    public function swapArray(
        array &$array,
        mixed $foo,
        mixed $bar,
    ): void {
        if ($array[$foo] === $array[$bar]) {
            return;
        }

        $tmp = $array[$foo];
        $array[$foo] = $array[$bar];
        $array[$bar] = $tmp;
    }
}
