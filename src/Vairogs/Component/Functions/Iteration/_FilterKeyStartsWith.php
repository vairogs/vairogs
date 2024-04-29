<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Iteration;

use function array_filter;

use const ARRAY_FILTER_USE_KEY;

trait _FilterKeyStartsWith
{
    public function filterKeyStartsWith(
        array $input,
        string $startsWith,
    ): array {
        return array_filter(array: $input, callback: static fn ($key) => str_starts_with(haystack: (string) $key, needle: $startsWith), mode: ARRAY_FILTER_USE_KEY);
    }
}
