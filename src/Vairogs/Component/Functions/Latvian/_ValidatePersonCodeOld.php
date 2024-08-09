<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Latvian;

use function floor;
use function substr;

trait _ValidatePersonCodeOld
{
    public function validatePersonCodeOld(
        string $personCode,
    ): bool {
        $personCode = (new class {
            use _CleanPersonCode;
        })->cleanPersonCode(personCode: $personCode);

        $check = '01060307091005080402';
        $checksum = 1;

        for ($i = 0; $i < 10; $i++) {
            $checksum -= (int) $personCode[$i] * (int) substr(string: $check, offset: $i * 2, length: 2);
        }

        return (int) ($checksum - floor(num: $checksum / 11) * 11) === (int) $personCode[10];
    }
}
