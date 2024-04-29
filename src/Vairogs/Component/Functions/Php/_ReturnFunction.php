<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Php;

trait _ReturnFunction
{
    public function returnFunction(
        string $function,
        ...$arguments,
    ): mixed {
        return $function(...$arguments);
    }
}
