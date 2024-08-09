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

use function array_combine;
use function array_keys;
use function array_map;
use function bin2hex;
use function parse_str;
use function preg_replace_callback;
use function urldecode;

trait _ArrayFromQueryString
{
    public function arrayFromQueryString(
        string $query,
    ): array {
        parse_str(string: (string) preg_replace_callback(pattern: '#(?:^|(?<=&))[^=[]+#', callback: static fn ($match) => bin2hex(string: urldecode(string: $match[0])), subject: $query), result: $values);

        return array_combine(keys: array_map(callback: 'hex2bin', array: array_keys(array: $values)), values: $values);
    }
}
