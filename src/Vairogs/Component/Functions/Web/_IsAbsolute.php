<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Web;

use function preg_match;

trait _IsAbsolute
{
    public function isAbsolute(
        string $path,
    ): bool {
        return str_starts_with(haystack: $path, needle: '//') || preg_match(pattern: '#^[a-z-]{3,}://#i', subject: $path);
    }
}
