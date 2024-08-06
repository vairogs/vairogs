<?php declare(strict_types = 1);

namespace Vairogs\Component\DoctrineTools\Doctrine\DBAL\Traits;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Exception\InvalidFormat;
use Vairogs\Component\DoctrineTools\UTCDateTimeImmutable;

trait _ConvertToPHPValue
{
    /**
     * @throws ConversionException
     */
    private function convertToPHPValueForType(
        $value,
        AbstractPlatform $platform,
        DateTimeInterface $object,
        string $function,
        string $prefix = '',
    ): DateTime|DateTimeImmutable|null {
        if (null === $value || $value instanceof DateTimeImmutable) {
            return $value;
        }

        $dateTime = $object::createFromFormat(
            format: $prefix . $platform->getDateTimeFormatString(),
            datetime: $value,
            timezone: UTCDateTimeImmutable::getUTCTimeZone(),
        ) ?: $function(datetime: $value, timezone: UTCDateTimeImmutable::getUTCTimeZone());

        if (false === $dateTime) {
            throw InvalidFormat::new(value: $value, toType: $object::class, expectedFormat: $prefix . $platform->getDateTimeFormatString());
        }

        return $dateTime;
    }
}
