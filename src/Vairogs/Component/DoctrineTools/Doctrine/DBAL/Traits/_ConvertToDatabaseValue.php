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

use DateTimeInterface;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Exception\InvalidType;
use Vairogs\Component\DoctrineTools\UTCDateTimeImmutable;

trait _ConvertToDatabaseValue
{
    /**
     * @throws InvalidType
     */
    public function convertToDatabaseValue(
        $value,
        AbstractPlatform $platform,
    ): ?string {
        if ($value instanceof DateTimeInterface) {
            $value = $value->setTimezone(timezone: UTCDateTimeImmutable::getUTCTimeZone());
        }

        return parent::convertToDatabaseValue(value: $value, platform: $platform);
    }
}
