<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Php;

trait _VoidObject
{
    public function voidObject(
        object $object,
        string $function,
        mixed ...$arguments,
    ): void {
        (new class {
            use _Void;
        })->void(fn () => $object->{$function}(...$arguments), $object, ...$arguments);
    }
}
