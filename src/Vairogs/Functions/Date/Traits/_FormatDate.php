<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Functions\Date\Traits;

use DateTimeImmutable;
use Vairogs\Functions\Date\Functions;

trait _FormatDate
{
    public function formatDate(
        string $string,
        string $format = Functions::FORMAT,
    ): string|bool {
        if (($date = DateTimeImmutable::createFromFormat(format: '!' . $format, datetime: $string)) instanceof DateTimeImmutable) {
            return $date->format(format: Functions::FORMAT);
        }

        return false;
    }
}
