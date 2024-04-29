<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Iteration;

use function is_array;

trait _IsEmpty
{
    public function isEmpty(
        mixed $variable,
        bool $result = true,
    ): bool {
        if (is_array(value: $variable) && [] !== $variable) {
            foreach ($variable as $item) {
                $result = $this->isEmpty(variable: $item, result: $result);
            }

            return $result;
        }

        return empty($variable);
    }
}
