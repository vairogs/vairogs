<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Functions\Latvian\Traits;

use Vairogs\Functions\Date;

use function substr;

trait _ValidatePersonCode
{
    public function validatePersonCode(
        string $personCode,
    ): bool {
        static $_helper = null;

        if (null === $_helper) {
            $_helper = new class {
                use _CleanPersonCode;
                use _ValidatePersonCodeNew;
                use _ValidatePersonCodeOld;
                use Date\Traits\_ValidateDate;
            };
        }

        $personCode = $_helper->cleanPersonCode(personCode: $personCode);

        if (32 === (int) substr(string: $personCode, offset: 0, length: 2)) {
            if (!$_helper->validateNewPersonCode(personCode: $personCode)) {
                return false;
            }
        } elseif (!$_helper->validateOldPersonCode(personCode: $personCode) && !$_helper->validateDate(date: $personCode)) {
            return false;
        }

        return true;
    }
}
