<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Latvian;

use InvalidArgumentException;
use Vairogs\Component\Functions\Text;

use function str_replace;
use function strlen;

trait _CleanPersonCode
{
    public function cleanPersonCode(
        string $personCode,
    ): string {
        $personCode = (new class() {
            use Text\_KeepNumeric;
        })->keepNumeric(text: $personCode);
        $personCode = str_replace(search: '-', replace: '', subject: $personCode);

        if (11 !== strlen(string: $personCode)) {
            throw new InvalidArgumentException(message: sprintf('Invalid person code: "%s"', $personCode));
        }

        return $personCode;
    }
}
