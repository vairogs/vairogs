<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Text;

use function html_entity_decode;
use function preg_replace;

trait _HtmlEntityDecode
{
    public function htmlEntityDecode(string $text): string
    {
        return preg_replace(pattern: '#\R+#', replacement: '', subject: html_entity_decode(string: $text));
    }
}
