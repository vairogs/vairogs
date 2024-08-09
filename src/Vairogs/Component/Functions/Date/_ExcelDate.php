<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\Functions\Date;

use Vairogs\Component\Functions\Date;

use function gmdate;

trait _ExcelDate
{
    public function excelDate(
        int $timestamp,
        string $format = Date::FORMAT,
    ): string {
        $base = 25569;

        if ($timestamp >= $base) {
            $unix = ($timestamp - $base) * 86400;
            $date = gmdate(format: $format, timestamp: $unix);

            if ((new class {
                use _ValidateDateBasic;
            })->validateDateBasic(date: $date, format: $format)) {
                return $date;
            }
        }

        return (string) $timestamp;
    }
}
