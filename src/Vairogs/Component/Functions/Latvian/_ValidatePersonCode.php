<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Latvian;

use Vairogs\Component\Functions\Date;

use function substr;

trait _ValidatePersonCode
{
    public function validatePersonCode(
        string $personCode,
    ): bool {
        $personCode = (new class() {
            use _CleanPersonCode;
        })->cleanPersonCode(personCode: $personCode);

        if (32 === (int) substr(string: $personCode, offset: 0, length: 2)) {
            if (!(new class() {
                use _ValidatePersonCodeNew;
            })->validateNewPersonCode(personCode: $personCode)) {
                return false;
            }
        } elseif (!(new class() {
            use _ValidatePersonCodeOld;
        })->validateOldPersonCode(personCode: $personCode) && !(new class() {
            use Date\_ValidateDate;
        })->validateDate(date: $personCode)) {
            return false;
        }

        return true;
    }
}
