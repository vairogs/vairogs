<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Php;

use Closure;

trait _Bind
{
    public function bind(
        callable $function,
        object $clone,
    ): ?Closure {
        return Closure::bind(closure: $function, newThis: $clone, newScope: $clone::class);
    }
}
