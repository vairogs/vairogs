<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Text;

use Vairogs\Component\Functions\Text;

use function str_replace;

trait _LatinToCyrillic
{
    public function latinToCyrillic(
        string $text,
        array $search = Text::MAP_LATIN,
        array $replace = Text::MAP_CYRILLIC,
    ): string {
        return str_replace(search: $search, replace: $replace, subject: $text);
    }
}
