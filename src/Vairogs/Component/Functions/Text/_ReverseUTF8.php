<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Text;

use Vairogs\Component\Functions\Text;

use function array_reverse;
use function implode;
use function mb_str_split;

trait _ReverseUTF8
{
    public function reverseUTF8(string $text): string
    {
        return implode(separator: '', array: array_reverse(array: mb_str_split(string: $text, encoding: Text::UTF8)));
    }
}
