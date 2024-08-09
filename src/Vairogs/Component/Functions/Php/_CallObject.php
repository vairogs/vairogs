<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Php;

use function array_unshift;

trait _CallObject
{
    public function callObject(mixed $value, object $object, string $function, ...$arguments): mixed
    {
        array_unshift($arguments, $value);

        return (new class {
            use _ReturnObject;
        })->returnObject($object, $function, ...$arguments);
    }
}
