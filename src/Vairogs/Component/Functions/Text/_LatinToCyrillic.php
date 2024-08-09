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
