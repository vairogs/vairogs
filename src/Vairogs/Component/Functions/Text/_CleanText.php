<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Text;

use Vairogs\Component\Functions\Text;

use function mb_convert_encoding;
use function str_replace;
use function strip_tags;

trait _CleanText
{
    public function cleanText(string $text): string
    {
        return (new class {
            use _HtmlEntityDecode;
        })->htmlEntityDecode(text: (new class {
            use _OneSpace;
        })->oneSpace(text: str_replace(search: ' ?', replace: '', subject: mb_convert_encoding(string: strip_tags(string: $text), to_encoding: Text::UTF8, from_encoding: Text::UTF8))));
    }
}
