<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Text;

use Vairogs\Component\Functions\Text;

use function mb_strlen;
use function mb_strpos;
use function mb_strtolower;
use function mb_substr;

trait _Compare
{
    public function compare(
        string $first,
        string $second,
        string $haystack = Text::EN_LOWERCASE,
    ): int {
        $first = mb_strtolower(string: $first);
        $second = mb_strtolower(string: $second);
        $haystack = mb_strtolower(string: $haystack);

        for ($i = 0, $len = mb_strlen(string: $first); $i < $len; $i++) {
            if (($charFirst = mb_substr(string: $first, start: $i, length: 1)) === ($charSecond = mb_substr(string: $second, start: $i, length: 1))) {
                continue;
            }

            if ($i > mb_strlen(string: $second) || mb_strpos(haystack: $haystack, needle: $charFirst) > mb_strpos(haystack: $haystack, needle: $charSecond)) {
                return 1;
            }

            return -1;
        }

        return 0;
    }
}
