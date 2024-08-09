<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
