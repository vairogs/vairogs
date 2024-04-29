<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Date;

use DateTimeImmutable;
use DateTimeInterface;

trait _DateNullable
{
    public function dateNullable(
        ?string $dateString = null,
        ?string $format = null,
    ): ?DateTimeInterface {
        if (null === $dateString || null === $format || !$date = DateTimeImmutable::createFromFormat(format: '!' . $format, datetime: $dateString)) {
            return null;
        }

        return $date;
    }
}
