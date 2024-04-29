<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Iteration;

use function array_filter;

use const ARRAY_FILTER_USE_KEY;

trait _FilterKeyEndsWith
{
    public function filterKeyEndsWith(
        array $input,
        string $endsWith,
    ): array {
        return array_filter(array: $input, callback: static fn ($key) => str_ends_with(haystack: $key, needle: $endsWith), mode: ARRAY_FILTER_USE_KEY);
    }
}
