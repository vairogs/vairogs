<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spaghetti\XLSXParser\Transformer;

use DateTimeImmutable;
use Spaghetti\XLSXParser\SharedStrings;
use Spaghetti\XLSXParser\Styles;

use function filter_var;
use function trim;

use const FILTER_VALIDATE_BOOL;

/**
 * @internal
 */
final class Value
{
    private const BOOL = 'b';
    private const EMPTY = '';
    private const NUMBER = 'n';
    private const SHARED_STRING = 's';

    private readonly Date $dateTransformer;

    public function __construct(
        private readonly SharedStrings $sharedStrings,
        private readonly Styles $styles,
        ?Date $dateTransformer = null,
    ) {
        $this->dateTransformer = $dateTransformer ?? new Date();
    }

    public function transform(
        string $value,
        string $type,
        string $style,
    ): bool|DateTimeImmutable|float|int|string {
        return match ($type) {
            self::BOOL => filter_var(value: $value, filter: FILTER_VALIDATE_BOOL),
            self::SHARED_STRING => trim(string: $this->sharedStrings->get(index: (int) $value)),
            self::EMPTY, self::NUMBER => $this->transformNumber(style: $style, value: $value),
            default => trim(string: $value),
        };
    }

    private function transformNumber(
        string $style,
        mixed $value,
    ): DateTimeImmutable|float|int {
        return match (true) {
            $style && Styles::FORMAT_DATE === $this->styles->get(index: (int) $style) => $this->dateTransformer->transform(value: (int) $value),
            default => preg_match(pattern: '/^\d+\.\d+$/', subject: $value) ? (float) $value : (int) $value,
        };
    }
}
