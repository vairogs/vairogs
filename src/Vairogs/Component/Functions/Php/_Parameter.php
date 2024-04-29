<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Php;

use function is_array;

trait _Parameter
{
    public function parameter(array|object $variable, mixed $key): mixed
    {
        if (is_array(value: $variable)) {
            return $variable[$key];
        }

        return (new class() {
            use _Get;
        })->get(object: $variable, property: $key);
    }
}
