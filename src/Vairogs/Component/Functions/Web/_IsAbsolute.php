<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\Functions\Web;

use function preg_match;

trait _IsAbsolute
{
    public function isAbsolute(
        string $path,
    ): bool {
        return str_starts_with(haystack: $path, needle: '//') || preg_match(pattern: '#^[a-z-]{3,}://#i', subject: $path);
    }
}
