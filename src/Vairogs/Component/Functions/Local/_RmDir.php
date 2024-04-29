<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Local;

use function array_map;
use function glob;
use function is_dir;
use function rmdir;
use function unlink;

use const GLOB_NOSORT;

trait _RmDir
{
    public function rmdir(
        string $directory,
    ): bool {
        array_map(callback: fn (string $file) => is_dir(filename: $file) ? $this->rmdir(directory: $file) : unlink(filename: $file), array: glob(pattern: $directory . '/*', flags: GLOB_NOSORT));

        return !is_dir(filename: $directory) || rmdir(directory: $directory);
    }
}
