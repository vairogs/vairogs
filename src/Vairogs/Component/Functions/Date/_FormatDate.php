<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Date;

use DateTimeImmutable;
use Vairogs\Component\Functions\Date;

trait _FormatDate
{
    public function formatDate(
        string $string,
        string $format = Date::FORMAT,
    ): string|bool {
        if (($date = DateTimeImmutable::createFromFormat(format: '!' . $format, datetime: $string)) instanceof DateTimeImmutable) {
            return $date->format(format: Date::FORMAT);
        }

        return false;
    }
}
