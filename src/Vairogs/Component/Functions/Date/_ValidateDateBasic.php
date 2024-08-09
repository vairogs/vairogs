<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\Functions\Date;

use DateTimeImmutable;
use Vairogs\Component\Functions\Date;

trait _ValidateDateBasic
{
    public function validateDateBasic(
        mixed $date,
        string $format = Date::FORMAT,
    ): bool {
        $object = DateTimeImmutable::createFromFormat(format: '!' . $format, datetime: $date);

        return $object && $date === $object->format(format: $format);
    }
}
