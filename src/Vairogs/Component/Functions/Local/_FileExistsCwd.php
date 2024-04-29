<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Local;

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
