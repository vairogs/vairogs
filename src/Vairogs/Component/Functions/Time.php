<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions;

use Symfony\Component\TypeInfo\TypeIdentifier;

use function floor;
use function round;
use function trim;

final class Time
{
    public const int HOUR = 60 * self::MIN;
    public const int MIN = 60 * self::SEC;
    public const int MS = 1;
    public const int SEC = 1000 * self::MS;

    public const array TIME = [
        'hour' => self::HOUR,
        'minute' => self::MIN,
        'second' => self::SEC,
        'micro' => self::MS,
    ];

    public function format(int|float $timestamp, bool $asArray = false): array|string
    {
        $timestamp = round(num: $timestamp * 1000);
        $result = $asArray ? [] : '';
        $type = get_debug_type(value: $result);

        foreach (self::TIME as $unit => $value) {
            if ($timestamp >= $value) {
                $time = (int) floor(num: $timestamp / $value);
                if ($time > 0) {
                    match ($type) {
                        TypeIdentifier::ARRAY => $result[$unit] = $time,
                        default => $result .= $time . ' ' . $unit . (1 === $time ? '' : 's') . ' ',
                    };
                }

                $timestamp -= $time * $value;
            }
        }

        return match ($type) {
            TypeIdentifier::ARRAY => $result,
            default => trim(string: $result),
        };
    }
}
