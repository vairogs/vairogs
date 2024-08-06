<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Iteration;

use function in_array;

trait _AddElementIfNotExists
{
    public function addElementIfNotExists(
        ?array &$array,
        mixed $element,
        mixed $key = null,
    ): void {
        $array ??= [];

        if ((null !== $key) && !isset($array[$key])) {
            $array[$key] = $element;

            return;
        }

        if (!in_array(needle: $element, haystack: $array, strict: true)) {
            $array[$key] = $element;
        }
    }
}
