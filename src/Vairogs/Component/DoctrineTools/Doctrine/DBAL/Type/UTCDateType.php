<?php declare(strict_types = 1);

namespace Vairogs\Component\DoctrineTools\Doctrine\DBAL\Type;

use DateTime;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\DateTimeType;
use Vairogs\Component\DoctrineTools\Doctrine\DBAL\Traits;

class UTCDateType extends DateTimeType
{
    use Traits\_ConvertToDatabaseValue;
    use Traits\_ConvertToPHPValue;

    /**
     * @throws ConversionException
     */
    public function convertToPHPValue(
        $value,
        AbstractPlatform $platform,
    ): ?DateTime {
        return $this->convertToPHPValueForType(value: $value, platform: $platform, object: new DateTime(), function: 'date_create', prefix: '!');
    }
}
