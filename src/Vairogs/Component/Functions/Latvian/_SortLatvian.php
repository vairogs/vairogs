<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Latvian;

use function call_user_func;
use function usort;

trait _SortLatvian
{
    public function sortLatvian(
        array &$names,
        string|int $field,
        ?array $callback = null,
    ): bool {
        $callback ??= [new class() {
            use _Compare;
        }, 'compare'];

        return usort(array: $names, callback: fn ($a, $b) => call_user_func($callback, $a, $b, $field));
    }
}
