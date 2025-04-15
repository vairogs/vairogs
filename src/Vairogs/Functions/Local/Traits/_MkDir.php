<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Functions\Local\Traits;

use UnexpectedValueException;

use function is_dir;
use function mkdir;
use function sprintf;

trait _MkDir
{
    public function mkdir(
        string $dir,
    ): bool {
        if (!is_dir(filename: $dir)) {
            @mkdir(directory: $dir, recursive: true);

            if (!is_dir(filename: $dir)) {
                throw new UnexpectedValueException(message: sprintf('Directory "%s" was not created', $dir));
            }
        }

        return is_dir(filename: $dir);
    }
}
