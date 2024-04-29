<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Php;

use Exception;
use ReflectionClass;

trait _ShortName
{
    public function shortName(string $class): string
    {
        try {
            return (new ReflectionClass(objectOrClass: $class))->getShortName();
        } catch (Exception) {
            // exception === can't get short name
        }

        return $class;
    }
}
