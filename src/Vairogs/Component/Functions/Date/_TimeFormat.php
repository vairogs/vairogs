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

use Vairogs\Component\Functions\Date;

use function floor;
use function round;
use function trim;

trait _TimeFormat
{
    public function format(
        int|float $timestamp,
        bool $asArray = false,
    ): array|string {
        $timestamp = round(num: $timestamp * 1000);
        $result = $asArray ? [] : '';

        foreach (Date::TIME as $unit => $value) {
            if ($timestamp >= $value) {
                $time = (int) floor(num: $timestamp / $value);
                if ($time > 0) {
                    match ($asArray) {
                        true => $result[$unit] = $time,
                        false => $result .= $time . ' ' . $unit . (1 === $time ? '' : 's') . ' ',
                    };
                }

                $timestamp -= $time * $value;
            }
        }

        return match ($asArray) {
            true => $result,
            false => trim(string: $result),
        };
    }
}
