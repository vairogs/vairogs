<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\Functions\Iteration;

use function ltrim;

use const PHP_INT_MAX;

trait _MakeOneDimension
{
    public function makeOneDimension(
        array $array,
        string $base = '',
        string $separator = '.',
        bool $onlyLast = false,
        int $depth = 0,
        int $maxDepth = PHP_INT_MAX,
        array $result = [],
        bool $allowList = false,
    ): array {
        if ($depth <= $maxDepth) {
            foreach ($array as $key => $value) {
                $key = ltrim(string: $base . '.' . $key, characters: '.');

                if ((new class {
                    use _IsAssociative;
                })->isAssociative(array: $value, allowList: $allowList)) {
                    $result = $this->makeOneDimension(array: $value, base: $key, separator: $separator, onlyLast: $onlyLast, depth: $depth + 1, maxDepth: $maxDepth, result: $result, allowList: $allowList);

                    if ($onlyLast) {
                        continue;
                    }
                }

                $result[$key] = $value;
            }
        }

        return $result;
    }
}
