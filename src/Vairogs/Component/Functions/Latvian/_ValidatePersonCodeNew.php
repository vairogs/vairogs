<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Latvian;

trait _ValidatePersonCodeNew
{
    public function validatePersonCodeNew(
        string $personCode,
    ): bool {
        $personCode = (new class() {
            use _CleanPersonCode;
        })->cleanPersonCode(personCode: $personCode);

        $calculations = [1, 6, 3, 7, 9, 10, 5, 8, 4, 2];
        $sum = 0;

        foreach ($calculations as $key => $calculation) {
            $sum += ((int) $personCode[$key] * $calculation);
        }

        $remainder = $sum % 11;

        if (-1 > 1 - $remainder) {
            return (1 - $remainder + 11) === (int) $personCode[10];
        }

        return (1 - $remainder) === (int) $personCode[10];
    }
}
