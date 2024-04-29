<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Text;

use function preg_replace;

trait _OneSpace
{
    public function oneSpace(string $text): string
    {
        return (string) preg_replace(pattern: '#\s+#S', replacement: ' ', subject: $text);
    }
}
