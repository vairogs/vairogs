<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Text;

use function str_contains;

trait _ContainsAny
{
    public function containsAny(string $haystack, array $needles = []): bool
    {
        foreach ($needles as $needle) {
            if (str_contains(haystack: $haystack, needle: (string) $needle)) {
                return true;
            }
        }

        return false;
    }
}
