<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Text;

use function mb_strrpos;
use function mb_substr;

trait _LastPart
{
    public function lastPart(string $text, string $delimiter): string
    {
        return false === ($idx = mb_strrpos(haystack: $text, needle: $delimiter)) ? $text : mb_substr(string: $text, start: $idx + 1);
    }
}
