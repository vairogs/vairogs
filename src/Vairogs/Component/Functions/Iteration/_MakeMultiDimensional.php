<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Iteration;

trait _MakeMultiDimensional
{
    public function makeMultiDimensional(
        array $array,
    ): array {
        if ((new class() {
            use _IsMultiDimentional;
        })->isMultiDimensional(keys: $array)) {
            return $array;
        }

        $result = [];

        /* @noinspection MissUsingForeachInspection */
        foreach ($array as $item) {
            $result[][] = $item;
        }

        return $result;
    }
}
