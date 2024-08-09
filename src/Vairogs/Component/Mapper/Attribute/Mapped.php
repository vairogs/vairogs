<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\Mapper\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final readonly class Mapped
{
    public function __construct(
        public string $mapsTo,
        public ?string $reverse = null,
    ) {
    }
}
