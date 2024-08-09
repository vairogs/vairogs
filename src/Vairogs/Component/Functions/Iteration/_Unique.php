<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Iteration;

use function array_flip;
use function array_keys;
use function array_unique;

trait _Unique
{
    public function unique(
        array $input,
        bool $keepKeys = false,
    ): array {
        if ($keepKeys) {
            return array_unique(array: $input);
        }

        if ((new class {
            use _IsMultiDimentional;
        })->isMultiDimensional(keys: $input)) {
            return $input;
        }

        return array_keys(array: array_flip(array: $input));
    }
}
