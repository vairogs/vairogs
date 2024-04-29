<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Iteration;

use function array_diff;

trait _RemoveFromArray
{
    public function removeFromArray(
        array &$input,
        mixed $value,
    ): void {
        $input = array_diff($input, [$value]);
    }
}
