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

trait _FormatDate
{
    public function formatDate(
        string $string,
        string $format = Date::FORMAT,
    ): string|bool {
        if (($date = DateTimeImmutable::createFromFormat(format: '!' . $format, datetime: $string)) instanceof DateTimeImmutable) {
            return $date->format(format: Date::FORMAT);
        }

        return false;
    }
}
