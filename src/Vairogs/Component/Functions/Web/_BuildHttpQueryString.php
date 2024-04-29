<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Web;

use ReflectionException;

use function http_build_query;

trait _BuildHttpQueryString
{
    /**
     * @throws ReflectionException
     */
    public function buildHttpQueryString(
        object $object,
    ): string {
        return http_build_query(data: (new class() {
            use _BuildHttpQueryArray;
        })->buildHttpQueryArray(input: $object));
    }
}
