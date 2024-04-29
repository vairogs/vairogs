<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Iteration;

use function array_intersect;

trait _HaveCommonElements
{
    public function haveCommonElements(
        array $array1,
        array $array2,
    ): bool {
        return [] !== array_intersect($array1, $array2);
    }
}
