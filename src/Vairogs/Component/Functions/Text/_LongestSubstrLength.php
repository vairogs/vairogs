<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Text;

use function max;
use function strlen;

trait _LongestSubstrLength
{
    public function longestSubstrLength(string $string): int
    {
        $result = $start = 0;
        $chars = [];

        for ($i = 0, $len = strlen(string: $string); $i < $len; $i++) {
            if (isset($chars[$string[$i]])) {
                $start = max($start, $chars[$string[$i]] + 1);
            }

            $result = max($result, $i - $start + 1);
            $chars[$string[$i]] = $i;
        }

        return $result;
    }
}
