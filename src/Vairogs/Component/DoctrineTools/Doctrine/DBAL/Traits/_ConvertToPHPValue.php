<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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

        $tz = UTCDateTimeImmutable::getUTCTimeZone();

        $dateTime = $object::createFromFormat(
            format: $prefix . $platform->getDateTimeFormatString(),
            datetime: $value,
            timezone: $tz,
        ) ?: $function(datetime: $value, timezone: $tz);

        if (false === $dateTime) {
            throw InvalidFormat::new(value: $value, toType: $object::class, expectedFormat: $prefix . $platform->getDateTimeFormatString());
        }

        return $dateTime;
    }
}
