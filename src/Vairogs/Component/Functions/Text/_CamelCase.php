<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Text;

use function lcfirst;
use function mb_strtolower;
use function preg_replace;
use function str_replace;
use function ucwords;

trait _CamelCase
{
    public function camelCase(
        string $string,
    ): string {
        return (string) preg_replace(pattern: '#\s+#', replacement: '', subject: lcfirst(string: ucwords(string: mb_strtolower(string: str_replace(search: '_', replace: ' ', subject: $string)))));
    }
}
