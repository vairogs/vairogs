<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Latvian;

use Vairogs\Component\Functions\Iteration;
use Vairogs\Component\Functions\Text;

trait _Compare
{
    public function compare(
        array|object $first,
        array|object $second,
        string|int $field,
    ): int {
        $value = new class() {
            use Iteration\_Value;
        };

        return (new class() {
            use Text\_Compare;
        })->compare(first: $value->value(objectOrArray: $first, field: $field), second: $value->value(objectOrArray: $second, field: $field), haystack: Text::LV_LOWERCASE);
    }
}
