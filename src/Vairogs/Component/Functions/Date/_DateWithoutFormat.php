<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Date;

use DateTimeImmutable;
use DateTimeInterface;
use Vairogs\Component\Functions\Date;
use Vairogs\Component\Functions\Php;

use function array_merge;

trait _DateWithoutFormat
{
    public function dateWithoutFormat(
        string $date,
        array $guesses = [],
    ): DateTimeInterface|string {
        $formats = array_merge((new class {
            use Php\_ClassConstantsValues;
        })->classConstantsValues(class: DateTimeImmutable::class), Date::EXTRA_FORMATS, $guesses);

        foreach ($formats as $format) {
            $datetime = DateTimeImmutable::createFromFormat(format: '!' . $format, datetime: $date);

            if ($datetime instanceof DateTimeInterface) {
                return $datetime;
            }
        }

        return $date;
    }
}
