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

use function get_object_vars;
use function number_format;

class Url
{
    protected ?string $changefreq = null;
    protected array $images = [];
    protected ?DateTimeInterface $lastmod = null;
    protected string $loc;
    protected float $priority = 0.5;
    protected array $videos = [];

    public function addImage(
        Image $image,
    ): static {
        $this->images[] = $image;

        return $this;
    }

    public function addVideo(
        Video $video,
    ): static {
        $this->videos[] = $video;

        return $this;
    }

    public function getChangefreq(): ?string
    {
        return $this->changefreq;
    }

    public function getImages(): array
    {
        return $this->images;
    }

    public function getLastmod(): ?string
    {
        return $this->lastmod?->format(DateTimeInterface::ATOM);
    }

    public function getLoc(): string
    {
        return $this->loc;
    }

    public function getPriority(): string
    {
        return number_format($this->priority, decimals: 2);
    }

    public function getVideos(): array
    {
        return $this->videos;
    }

    public function hasImages(): bool
    {
        return [] !== $this->images;
    }

    public function hasVideos(): bool
    {
        return [] !== $this->videos;
    }

    public function setChangefreq(
        ?string $changefreq,
    ): static {
        $this->changefreq = $changefreq;

        return $this;
    }

    public function setImages(
        array $images,
    ): static {
        $this->images = $images;

        return $this;
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

    public function setPriority(
        float $priority,
    ): static {
        $this->priority = $priority;

        return $this;
    }

    public function setVideos(
        array $videos,
    ): static {
        $this->videos = $videos;

        return $this;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
