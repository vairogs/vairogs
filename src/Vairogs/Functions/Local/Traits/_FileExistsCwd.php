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

use function getcwd;
use function is_file;

use const DIRECTORY_SEPARATOR;

trait _FileExistsCwd
{
    public function fileExistsCwd(
        string $filename,
    ): bool {
        return is_file(filename: getcwd() . DIRECTORY_SEPARATOR . $filename);
    }
}
