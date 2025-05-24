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

final class InvalidIndexException extends InvalidArgumentException
{
    public function __construct(
        string $name,
        ?Throwable $previous = null,
    ) {
        parent::__construct(message: sprintf('Invalid name: "%s"', $name), previous: $previous);
    }
}
