<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Iteration;

trait _MakeMultiDimensional
{
    public function makeMultiDimensional(
        array $array,
    ): array {
        if ((new class {
            use _IsMultiDimentional;
        })->isMultiDimensional(keys: $array)) {
            return $array;
        }

        return array_map(callback: static fn ($item) => [$item], array: array_values(array: $array));
    }
}
