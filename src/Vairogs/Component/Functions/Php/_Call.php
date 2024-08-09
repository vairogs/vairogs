<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Php;

use function array_unshift;

trait _Call
{
    public function call(mixed $value, string $function, ...$arguments): mixed
    {
        array_unshift($arguments, $value);

        return (new class {
            use _ReturnFunction;
        })->returnFunction($function, ...$arguments);
    }
}
