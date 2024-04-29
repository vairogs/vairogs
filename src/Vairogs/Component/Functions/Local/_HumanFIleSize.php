<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Local;

use function floor;
use function sprintf;
use function strlen;

trait _HumanFIleSize
{
    public function humanFileSize(
        int $bytes,
        int $decimals = 2,
    ): string {
        $units = ['B', 'K', 'M', 'G', 'T', 'P', 'E', 'Z', 'Y'];
        $bytesAsString = (string) $bytes;
        $factor = (int) floor(num: (strlen(string: $bytesAsString) - 1) / 3);

        return sprintf("%.{$decimals}f", $bytesAsString / (1024 ** $factor)) . $units[$factor];
    }
}
