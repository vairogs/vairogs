<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Php;

trait _ReturnObject
{
    public function returnObject(
        object $object,
        string $function,
        mixed ...$arguments,
    ): mixed {
        return (new class() {
            use _Return;
        })->return(fn () => $object->{$function}(...$arguments), $object, ...$arguments);
    }
}
