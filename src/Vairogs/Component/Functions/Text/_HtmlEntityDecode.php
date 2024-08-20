<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\Functions\Text;

use Vairogs\Component\Functions\Preg\_Replace;

use function html_entity_decode;

trait _HtmlEntityDecode
{
    public function htmlEntityDecode(
        string $text,
    ): string {
        return (new class {
            use _Replace;
        })::replace(pattern: '#\R+#', replacement: '', subject: html_entity_decode(string: $text));
    }
}
