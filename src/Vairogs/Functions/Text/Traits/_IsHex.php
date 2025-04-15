<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Functions\Text\Traits;

use Vairogs\Functions\Preg;

trait _IsHex
{
    public function isHex(
        string $string,
    ): bool {
        static $_helper = null;

        if (null === $_helper) {
            $_helper = new class {
                use Preg\Traits\_Match;
            };
        }

        return $_helper->match('/^(?:0x)?[0-9a-f]*$/', $string);
    }
}
