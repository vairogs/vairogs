<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Text;

use function mb_strtolower;
use function preg_replace;

trait _SnakeCaseFromCamelCase
{
    public function snakeCaseFromCamelCase(
        string $string,
        string $separator = '_',
    ): string {
        return mb_strtolower(string: (string) preg_replace(pattern: '#(?!^)[[:upper:]]+#', replacement: $separator . '$0', subject: $string));
    }
}
