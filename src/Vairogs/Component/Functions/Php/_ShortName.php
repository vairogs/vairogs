<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\Functions\Php;

use Exception;

trait _ShortName
{
    public function shortName(
        string $class,
    ): string {
        static $_helper = null;

        if (null === $_helper) {
            $_helper = new class {
                use _GetReflection;
            };
        }

        try {
            return $_helper->getReflection($class)->getShortName();
        } catch (Exception) {
            // exception === can't get short name
        }

        return $class;
    }
}
