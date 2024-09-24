<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\Sitemap\Contracts;

interface Builder
{
    public function build(
        &$buffer,
    ): void;

    public function end(
        &$buffer,
    ): void;

    public function getType(): string;

    public function start(
        &$buffer,
    ): void;
}