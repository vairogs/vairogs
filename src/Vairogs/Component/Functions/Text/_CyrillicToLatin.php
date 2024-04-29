<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Text;

use Vairogs\Component\Functions\Text;

use function str_replace;

trait _CyrillicToLatin
{
    public function cyrillicToLatin(
        string $text,
        array $search = Text::MAP_CYRILLIC,
        array $replace = Text::MAP_LATIN,
    ): string {
        return str_replace(search: $search, replace: $replace, subject: $text);
    }
}
