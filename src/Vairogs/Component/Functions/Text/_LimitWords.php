<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Text;

use function array_key_exists;
use function mb_strlen;
use function preg_match;
use function rtrim;

trait _LimitWords
{
    public function limitWords(string $text, int $limit = 100, string $append = '...'): string
    {
        preg_match(pattern: '/^\s*+(?:\S++\s*+){1,' . $limit . '}/u', subject: $text, matches: $matches);
        if (!array_key_exists(key: 0, array: $matches) || mb_strlen(string: $text) === mb_strlen(string: $matches[0])) {
            return $text;
        }

        return rtrim(string: $matches[0]) . $append;
    }
}
