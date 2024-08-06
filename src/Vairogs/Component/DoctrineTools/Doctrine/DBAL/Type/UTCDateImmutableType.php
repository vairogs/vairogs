<?php declare(strict_types = 1);

namespace Vairogs\Component\DoctrineTools\Doctrine\DBAL\Type;

use DateTimeImmutable;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\DateTimeImmutableType;
use Vairogs\Component\DoctrineTools\Doctrine\DBAL\Traits;
use Vairogs\Component\DoctrineTools\UTCDateTimeImmutable;

class UTCDateImmutableType extends DateTimeImmutableType
{
    use Traits\_ConvertToDatabaseValue;
    use Traits\_ConvertToPHPValue;

    /**
     * @throws ConversionException
     */
    public function convertToPHPValue(
        $value,
        AbstractPlatform $platform,
    ): ?DateTimeImmutable {
        return $this->convertToPHPValueForType(value: $value, platform: $platform, object: new UTCDateTimeImmutable(), function: 'date_create_immutable', prefix: '!');
    }
}
