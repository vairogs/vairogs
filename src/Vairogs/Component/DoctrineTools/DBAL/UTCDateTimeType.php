<?php declare(strict_types = 1);

namespace Vairogs\Component\DoctrineTools\DBAL;

use DateTime;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\DateTimeType;

class UTCDateTimeType extends DateTimeType
{
    use Traits\ConvertToDatabaseValue;
    use Traits\ConvertToPHPValue;

    /**
     * @throws ConversionException
     */
    public function convertToPHPValue(
        $value,
        AbstractPlatform $platform,
    ): ?DateTime {
        return $this->convertToPHPValueForType(value: $value, platform: $platform, object: new DateTime(), function: 'date_create');
    }
}
