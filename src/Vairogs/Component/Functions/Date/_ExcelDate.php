<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Date;

use Vairogs\Component\Functions\Date;

use function gmdate;

trait _ExcelDate
{
    public function excelDate(
        int $timestamp,
        string $format = Date::FORMAT,
    ): string {
        $base = 25569;

        if ($timestamp >= $base) {
            /** @noinspection SummerTimeUnsafeTimeManipulationInspection */
            $unix = ($timestamp - $base) * 86400;
            $date = gmdate(format: $format, timestamp: $unix);

            if ((new class() {
                use _ValidateDateBasic;
            })->validateDateBasic(date: $date, format: $format)) {
                return $date;
            }
        }

        return (string) $timestamp;
    }
}
