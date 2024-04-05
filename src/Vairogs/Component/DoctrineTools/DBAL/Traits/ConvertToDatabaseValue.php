<?php declare(strict_types = 1);

namespace Vairogs\Component\DoctrineTools\DBAL\Traits;

use DateTimeInterface;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Exception\InvalidType;
use Vairogs\Component\DoctrineTools\UTCDateTimeImmutable;

trait ConvertToDatabaseValue
{
    /**
     * @throws InvalidType
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value instanceof DateTimeInterface) {
            $value = $value->setTimezone(timezone: UTCDateTimeImmutable::getUTCTimeZone());
        }

        return parent::convertToDatabaseValue(value: $value, platform: $platform);
    }
}
