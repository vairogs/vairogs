<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Iteration;

use function array_map;
use function array_unique;

trait _UniqueMap
{
    public function uniqueMap(
        array &$array,
    ): void {
        $array = array_map(callback: 'unserialize', array: array_unique(array: array_map(callback: 'serialize', array: $array)));
    }
}
