<?php declare(strict_types = 1);

namespace Vairogs\Component\DoctrineTools;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Exception;

class UTCDateTimeImmutable extends DateTimeImmutable
{
    public const string UTC = 'UTC';

    /**
     * @throws Exception
     */
    public function __construct(
        string $datetime = 'now',
    ) {
        parent::__construct(datetime: $datetime, timezone: self::getUTCTimeZone());
    }

    public static function getUTCTimeZone(): DateTimeZone
    {
        return new DateTimeZone(timezone: self::UTC);
    }

    public static function createFromInterface(
        DateTimeInterface $object,
    ): self {
        /* @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::createFromInterface(object: $object)->setTimezone(timezone: self::getUTCTimeZone());
    }
}
