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

use function mb_strlen;
use function mb_substr;
use function rtrim;

trait _LimitChars
{
    public function limitChars(
        string $text,
        int $length = 100,
        string $append = '...',
    ): string {
        if ($length >= mb_strlen(string: $text)) {
            return $text;
        }

        return rtrim(string: mb_substr(string: $text, start: 0, length: $length)) . $append;
    }
}
