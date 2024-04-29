<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Web;

use function array_map;
use function explode;
use function long2ip;

trait _CIDRRange
{
    public function CIDRRange(
        string $cidr,
        bool $int = true,
    ): array {
        if (!(new class() {
            use _IsCIDR;
        })->isCIDR(cidr: $cidr)) {
            return ['0', '0'];
        }

        [$base, $bits,] = explode(separator: '/', string: $cidr);
        $bits = (int) $bits;
        [$part1, $part2, $part3, $part4,] = array_map('intval', explode(separator: '.', string: $base));
        $sum = ($part1 << 24) + ($part2 << 16) + ($part3 << 8) + $part4;
        $mask = (0 === $bits) ? 0 : (~0 << (32 - $bits));

        $low = $sum & $mask;
        $high = $sum | (~$mask & 0xFFFFFFFF);

        if ($int) {
            return [(string) $low, (string) $high];
        }

        return [long2ip(ip: $low), long2ip(ip: $high)];
    }
}
