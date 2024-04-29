<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Php;

trait _VoidFunction
{
    public function voidFunction(
        string $function,
        mixed ...$arguments,
    ): void {
        $function(...$arguments);
    }
}
