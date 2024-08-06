<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Iteration;

use BackedEnum;

use function array_map;

trait _Cases
{
    public static function getCases(): array
    {
        if (!is_subclass_of(object_or_class: self::class, class: BackedEnum::class)) {
            return [];
        }

        return array_map(callback: static fn (BackedEnum $enum) => $enum->value, array: self::cases());
    }
}
