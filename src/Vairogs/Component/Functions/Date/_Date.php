<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Date;

use DateTimeImmutable;
use DateTimeInterface;
use InvalidArgumentException;

trait _Date
{
    /**
     * @throws InvalidArgumentException
     */
    public function date(
        ?string $dateString = null,
        ?string $format = null,
    ): DateTimeInterface {
        if (null === $dateString || !$date = DateTimeImmutable::createFromFormat(format: '!' . $format, datetime: $dateString)) {
            throw new InvalidArgumentException(message: 'Invalid date string');
        }

        return $date;
    }
}
