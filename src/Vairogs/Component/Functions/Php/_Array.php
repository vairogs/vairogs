<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Php;

use function is_object;

trait _Array
{
    public function array(array|object $input): array
    {
        if (is_object(value: $input)) {
            return (new class {
                use _ArrayFromObject;
            })->arrayFromObject(object: $input);
        }

        return $input;
    }
}
