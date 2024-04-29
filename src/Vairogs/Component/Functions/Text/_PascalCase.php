<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Text;

use function mb_strtolower;
use function preg_replace;
use function str_replace;
use function ucfirst;
use function ucwords;

trait _PascalCase
{
    public function pascalCase(
        string $string,
    ): string {
        return (string) preg_replace(pattern: '#\s+#', replacement: '', subject: ucfirst(string: ucwords(string: mb_strtolower(string: str_replace(search: '_', replace: ' ', subject: $string)))));
    }
}
