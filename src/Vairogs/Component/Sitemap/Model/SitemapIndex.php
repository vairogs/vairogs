<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\Sitemap\Model;

use DateTimeInterface;

class SitemapIndex
{
    protected ?DateTimeInterface $lastmod = null;
    protected string $loc;

    public function getLastmod(): ?DateTimeInterface
    {
        return $this->lastmod;
    }

    public function getLoc(): string
    {
        return $this->loc;
    }

    public function setLastmod(
        ?DateTimeInterface $lastmod,
    ): static {
        $this->lastmod = $lastmod;

        return $this;
    }

    public function setLoc(
        string $loc,
    ): static {
        $this->loc = $loc;

        return $this;
    }
}
