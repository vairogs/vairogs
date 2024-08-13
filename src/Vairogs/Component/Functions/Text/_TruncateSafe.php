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

use function mb_strrpos;
use function mb_substr;

trait _TruncateSafe
{
    public function truncateSafe(
        string $text,
        int $length,
        string $append = '...',
    ): string {
        $result = mb_substr(string: $text, start: 0, length: $length);
        $lastSpace = mb_strrpos(haystack: $result, needle: ' ');

        if (false !== $lastSpace && $text !== $result) {
            $result = mb_substr(string: $result, start: 0, length: $lastSpace);
        }

        if ($text !== $result) {
            $result .= $append;
        }

        return $result;
    }
}
