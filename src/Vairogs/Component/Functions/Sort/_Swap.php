<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Sort;

trait _Swap
{
    public function swap(
        mixed &$foo,
        mixed &$bar,
    ): void {
        if ($foo === $bar) {
            return;
        }

        $tmp = $foo;
        $foo = $bar;
        $bar = $tmp;
    }
}
