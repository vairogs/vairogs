<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Iteration;

use InvalidArgumentException;

use function array_values;

trait _ArrayValuesFiltered
{
    /**
     * @throws InvalidArgumentException
     */
    public function arrayValuesFiltered(
        array $input,
        string $with,
        bool $start = true,
    ): array {
        return match ($start) {
            true => array_values(array: (new class {
                use _FilterKeyStartsWith;
            })->filterKeyStartsWith(input: $input, startsWith: $with)),
            false => array_values(array: (new class {
                use _FilterKeyEndsWith;
            })->filterKeyEndsWith(input: $input, endsWith: $with)),
        };
    }
}
