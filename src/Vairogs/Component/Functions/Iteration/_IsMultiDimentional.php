<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Iteration;

use function is_array;

trait _IsMultiDimentional
{
    public function isMultiDimensional(
        array $keys = [],
    ): bool {
        foreach ($keys as $key) {
            if (is_array(value: $key)) {
                return true;
            }
        }

        return false;
    }
}
