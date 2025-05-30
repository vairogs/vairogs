<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Functions\Text\Traits;

use Vairogs\Functions\Text\Functions;

use function mb_convert_encoding;
use function str_replace;
use function strip_tags;

trait _CleanText
{
    public function cleanText(
        string $text,
    ): string {
        static $_helper = null;

        if (null === $_helper) {
            $_helper = new class {
                use _HtmlEntityDecode;
                use _OneSpace;
            };
        }

        return $_helper->htmlEntityDecode(text: $_helper->oneSpace(text: str_replace(search: ' ?', replace: '', subject: mb_convert_encoding(string: strip_tags(string: $text), to_encoding: Functions::UTF8, from_encoding: Functions::UTF8))));
    }
}
