<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
