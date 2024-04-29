<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Date;

use DateTimeImmutable;
use Vairogs\Component\Functions\Date;

trait _ValidateDateBasic
{
    public function validateDateBasic(
        mixed $date,
        string $format = Date::FORMAT,
    ): bool {
        $object = DateTimeImmutable::createFromFormat(format: '!' . $format, datetime: $date);

        return $object && $date === $object->format(format: $format);
    }
}
