<?php declare(strict_types = 1);

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
        return (new DateTimeImmutable())->setTimestamp(timestamp: $timestamp)->format(format: $format ?? Date::FORMAT);
    }
}
