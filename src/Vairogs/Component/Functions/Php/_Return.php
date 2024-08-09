<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Php;

trait _Return
{
    public function return(
        callable $function,
        object $clone,
        mixed ...$arguments,
    ): mixed {
        return (new class {
            use _Bind;
        })->bind(function: $function, clone: $clone)(...$arguments);
    }
}
