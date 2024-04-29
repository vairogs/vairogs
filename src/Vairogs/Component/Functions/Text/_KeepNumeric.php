<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Text;

use function preg_replace;

trait _KeepNumeric
{
    public function keepNumeric(string $text): string
    {
        return (string) preg_replace(pattern: '#\D#', replacement: '', subject: $text);
    }
}
