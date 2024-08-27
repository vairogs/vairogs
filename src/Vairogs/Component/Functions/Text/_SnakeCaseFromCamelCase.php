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

use Vairogs\Component\Functions\Preg\_Replace;

use function mb_strtolower;

trait _SnakeCaseFromCamelCase
{
    public function snakeCaseFromCamelCase(
        string $string,
        string $separator = '_',
    ): string {
        static $_helper = null;

        if (null === $_helper) {
            $_helper = new class {
                use _Replace;
            };
        }

        return mb_strtolower(string: $_helper->replace(pattern: '#(?!^)[[:upper:]]+#', replacement: $separator . '$0', subject: $string));
    }
}
