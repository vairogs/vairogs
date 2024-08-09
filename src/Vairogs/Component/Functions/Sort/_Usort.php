<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Sort;

use Closure;
use Vairogs\Component\Functions\Php;

trait _Usort
{
    public function usort(
        string $parameter,
        string $order,
    ): Closure {
        return static function (array|object $first, array|object $second) use ($parameter, $order): int {
            $anon = new class {
                use Php\_Parameter;
            };
            if (($firstSort = $anon->parameter(variable: $first, key: $parameter)) === ($secondSort = $anon->parameter(variable: $second, key: $parameter))) {
                return 0;
            }

            $flip = 'DESC' === $order ? -1 : 1;

            if ($firstSort > $secondSort) {
                return $flip;
            }

            return -1 * $flip;
        };
    }
}
