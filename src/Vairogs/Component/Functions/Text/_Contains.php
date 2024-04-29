<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Text;

use function strpbrk;

trait _Contains
{
    public function contains(string $haystack, string $needle): bool
    {
        return false !== strpbrk(string: $haystack, characters: $needle);
    }
}
