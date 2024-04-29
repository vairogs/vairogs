<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Iteration;

use function array_map;
use function property_exists;

trait _Cases
{
    public static function getCases(): array
    {
        if (!property_exists(object_or_class: self::class, property: 'value')) {
            return [];
        }

        return array_map(callback: static fn ($enum) => $enum->value, array: self::cases());
    }
}
