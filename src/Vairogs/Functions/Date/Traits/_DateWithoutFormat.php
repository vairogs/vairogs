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
use DateTimeInterface;
use Vairogs\Functions\Date\Functions;
use Vairogs\Functions\Php;

use function array_merge;

trait _DateWithoutFormat
{
    public function dateWithoutFormat(
        string $date,
        array $guesses = [],
    ): DateTimeInterface|string {
        static $_helper = null;

        if (null === $_helper) {
            $_helper = new class {
                use Php\Traits\_ClassConstantsValues;
            };
        }

        $formats = array_merge($_helper->classConstantsValues(class: DateTimeImmutable::class), Functions::EXTRA_FORMATS, $guesses);

        foreach ($formats as $format) {
            $datetime = DateTimeImmutable::createFromFormat(format: '!' . $format, datetime: $date);

            if ($datetime instanceof DateTimeInterface) {
                return $datetime;
            }
        }

        return $date;
    }
}
