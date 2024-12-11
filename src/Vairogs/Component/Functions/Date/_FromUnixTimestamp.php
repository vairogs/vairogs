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
use Exception;
use Vairogs\Component\Functions\Date;

trait _FromUnixTimestamp
{
    /**
     * @throws Exception
     */
    public function fromUnixTimestamp(
        int $timestamp = 0,
        ?string $format = null,
    ): string {
        return new DateTimeImmutable()->setTimestamp(timestamp: $timestamp)->format(format: $format ?? Date::FORMAT);
    }
}
