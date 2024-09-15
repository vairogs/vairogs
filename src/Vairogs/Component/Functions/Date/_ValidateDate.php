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
use Vairogs\Component\Functions\Text;

use function substr;

trait _ValidateDate
{
    public function validateDate(
        string $date,
    ): bool {
        static $_helper = null;

        if (null === $_helper) {
            $_helper = new class {
                use Text\_KeepNumeric;
            };
        }

        $date = $_helper->keepNumeric(text: $date);
        $day = (int) substr(string: $date, offset: 0, length: 2);
        $month = (int) substr(string: $date, offset: 2, length: 2);

        if (1 > $month || 12 < $month) {
            return false;
        }

        $daysInMonth = [
            Date::JAN,
            Date::FEB,
            Date::MAR,
            Date::APR,
            Date::MAY,
            Date::JUN,
            Date::JUL,
            Date::AUG,
            Date::SEP,
            Date::OCT,
            Date::NOV,
            Date::DEC,
        ];

        if (0 === (int) substr(string: $date, offset: 4, length: 2) % 4) {
            $daysInMonth[1] = Date::FEB_LONG;
        }

        return 0 < $day && $daysInMonth[$month - 1] >= $day;
    }
}
