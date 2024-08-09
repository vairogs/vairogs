<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Latvian;

use function usort;

trait _SortLatvian
{
    public function sortLatvian(
        array &$names,
        string|int $field,
        ?array $callback = null,
    ): bool {
        $callback ??= [new class {
            use _Compare;
        }, 'compare'];

        return usort(array: $names, callback: static fn ($a, $b) => $callback($a, $b, $field));
    }
}
