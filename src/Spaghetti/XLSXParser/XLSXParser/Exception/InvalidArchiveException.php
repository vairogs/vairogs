<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spaghetti\XLSXParser\Exception;

use ReflectionClass;
use ReflectionProperty;
use RuntimeException;
use Throwable;
use ZipArchive;

use function array_flip;
use function array_key_exists;
use function sprintf;

final class InvalidArchiveException extends RuntimeException
{
    public function __construct(
        int $code,
        ?Throwable $previous = null,
    ) {
        parent::__construct(message: 'Error opening file: ' . $this->getErrorMessage(errorCode: $code), previous: $previous);
    }

    private function getErrorMessage(
        int $errorCode,
    ): string {
        return sprintf('An error has occured: %s::%s (%d)', ZipArchive::class, $this->getZipErrorString(value: $errorCode), $errorCode);
    }

    private function getZipErrorString(
        int $value,
    ): string {
        $map = array_flip(array: (new ReflectionClass(objectOrClass: ZipArchive::class))->getConstants(filter: ReflectionProperty::IS_PUBLIC));

        return array_key_exists(key: $value, array: $map) ? $map[$value] : 'UNKNOWN';
    }
}
