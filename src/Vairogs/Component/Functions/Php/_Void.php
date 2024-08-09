<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Php;

trait _Void
{
    public function void(
        callable $function,
        object $clone,
        mixed ...$arguments,
    ): void {
        (new class {
            use _Bind;
        })->bind(function: $function, clone: $clone)(...$arguments);
    }
}
