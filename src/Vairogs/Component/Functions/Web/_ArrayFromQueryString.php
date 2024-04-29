<?php declare(strict_types = 1);

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
