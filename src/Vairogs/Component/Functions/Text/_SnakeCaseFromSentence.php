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
use function str_replace;

trait _SnakeCaseFromSentence
{
    public function snakeCaseFromSentence(
        string $string,
        bool $skipCamel = false,
    ): string {
        static $_helper = null;

        if (null === $_helper) {
            $_helper = new class {
                use _CamelCase;
                use _Replace;
            };
        }

        $string = $_helper->replace(pattern: [
            '#([A-Z\d]+)([A-Z][a-z])#',
            '#([a-z\d])([A-Z])#',
        ], replacement: '\1_\2', subject: $skipCamel ? $string : $_helper->camelCase(string: $string));

        return mb_strtolower(string: str_replace(search: '-', replace: '_', subject: (string) $string));
    }
}
