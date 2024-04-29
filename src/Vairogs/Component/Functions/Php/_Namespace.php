<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Php;

use Exception;
use ReflectionClass;

trait _Namespace
{
    public function namespace(string $class): string
    {
        try {
            return (new ReflectionClass(objectOrClass: $class))->getNamespaceName();
        } catch (Exception) {
            return '\\';
        }
    }
}
