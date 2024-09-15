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

use Vairogs\Component\Functions\Preg;

use function str_replace;

trait _Sanitize
{
    public function sanitize(
        string $text,
    ): string {
        static $_helper = null;

        if (null === $_helper) {
            $_helper = new class {
                use Preg\_Replace;
            };
        }

        return str_replace(search: ["'", '"'], replace: ['&#39;', '&#34;'], subject: $_helper->replace(pattern: '/\x00|<[^>]*>?/', replacement: '', subject: $text));
    }
}
