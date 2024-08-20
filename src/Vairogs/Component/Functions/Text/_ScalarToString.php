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

use function var_export;

trait _ScalarToString
{
    public static function scalarToString(
        mixed $value,
    ): string {
        return (new class {
            use _Replace;
        })::replace('/\bNULL\b/', 'null', var_export($value, true));
    }
}