<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Text;

use function mb_strlen;
use function mb_substr;
use function rtrim;

trait _LimitChars
{
    public function limitChars(string $text, int $length = 100, string $append = '...'): string
    {
        if ($length >= mb_strlen(string: $text)) {
            return $text;
        }

        return rtrim(string: mb_substr(string: $text, start: 0, length: $length)) . $append;
    }
}
