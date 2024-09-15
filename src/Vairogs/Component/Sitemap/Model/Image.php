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

class Image
{
    protected ?string $caption = null;
    protected ?string $geoLocation = null;
    protected ?string $license = null;
    protected string $loc;
    protected ?string $title = null;

    public function getCaption(): ?string
    {
        return $this->caption;
    }

    public function getGeoLocation(): ?string
    {
        return $this->geoLocation;
    }

    public function getLicense(): ?string
    {
        return $this->license;
    }

    public function getLoc(): string
    {
        return $this->loc;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setCaption(
        ?string $caption,
    ): static {
        $this->caption = $caption;

        return $this;
    }

    public function setGeoLocation(
        ?string $geoLocation,
    ): static {
        $this->geoLocation = $geoLocation;

        return $this;
    }

    public function setLicense(
        ?string $license,
    ): static {
        $this->license = $license;

        return $this;
    }

    public function setLoc(
        string $loc,
    ): static {
        $this->loc = $loc;

        return $this;
    }

    public function setTitle(
        ?string $title,
    ): static {
        $this->title = $title;

        return $this;
    }
}
