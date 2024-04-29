<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Text;

use function preg_replace;
use function str_replace;

trait _Sanitize
{
    public function sanitize(string $text): string
    {
        return str_replace(search: ["'", '"'], replace: ['&#39;', '&#34;'], subject: (string) preg_replace(pattern: '/\x00|<[^>]*>?/', replacement: '', subject: $text));
    }
}
