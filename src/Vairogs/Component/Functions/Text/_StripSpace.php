<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Text;

use function preg_replace;

trait _StripSpace
{
    public function stripSpace(string $text): string
    {
        return (string) preg_replace(pattern: '#\s+#', replacement: '', subject: $text);
    }
}
