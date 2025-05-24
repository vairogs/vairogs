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

use InvalidArgumentException;
use Throwable;

use function sprintf;

final class InvalidXLSXFileException extends InvalidArgumentException
{
    public function __construct(
        string $path,
        ?Throwable $previous = null,
    ) {
        parent::__construct(message: sprintf('Not a XLSX file: %s', $path), previous: $previous);
    }
}
