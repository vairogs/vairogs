<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\DoctrineTools;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Exception;

class UTCDateTimeImmutable extends DateTimeImmutable
{
    public const string UTC = 'UTC';
    public const string FORMAT = 'Y-m-d H:i:s.u';

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

    /**
     * @throws Exception
     */
    public static function createFromInterface(
        DateTimeInterface $object,
    ): static {
        return new static(datetime: $object->setTimezone(timezone: self::getUTCTimeZone())->format(format: self::FORMAT));
    }

    /**
     * @throws Exception
     */
    public static function createFromFormat(
        string $format,
        string $datetime,
        ?DateTimeZone $timezone = null,
    ): static|false {
        $object = parent::createFromFormat(format: $format, datetime: $datetime, timezone: $timezone ?? self::getUTCTimeZone());

        if (false !== $object) {
            return self::createFromInterface(object: $object);
        }

        return false;
    }
}
