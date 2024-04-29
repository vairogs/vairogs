<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Iteration;

trait _FirstMatchAsString
{
    public function firstMatchAsString(
        array $keys,
        array $haystack,
    ): ?string {
        foreach ($keys as $key) {
            if (isset($haystack[$key])) {
                return (string) $haystack[$key];
            }
        }

        return null;
    }
}
