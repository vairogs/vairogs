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

use Vairogs\Functions\Preg;

use function html_entity_decode;

trait _HtmlEntityDecode
{
    public function htmlEntityDecode(
        string $text,
    ): string {
        static $_helper = null;

        if (null === $_helper) {
            $_helper = new class {
                use Preg\Traits\_Replace;
            };
        }

        return $_helper->replace(pattern: '#\R+#', replacement: '', subject: html_entity_decode(string: $text));
    }
}
