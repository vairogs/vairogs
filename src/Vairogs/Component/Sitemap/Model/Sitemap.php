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

use function method_exists;

class Sitemap
{
    /**
     * @var Url[]
     */
    protected array $urls = [];

    public function addUrl(
        Url $url,
    ): static {
        $this->urls[] = $url;

        return $this;
    }

    public function getUrls(): array
    {
        return $this->urls;
    }

    public function hasAlternates(): bool
    {
        foreach ($this->urls as $url) {
            if (method_exists($url, 'hasAlternates') && $url->hasAlternates()) {
                return true;
            }
        }

        return false;
    }

    public function hasImages(): bool
    {
        foreach ($this->urls as $url) {
            if ($url->hasImages()) {
                return true;
            }
        }

        return false;
    }

    public function hasVideos(): bool
    {
        foreach ($this->urls as $url) {
            if ($url->hasVideos()) {
                return true;
            }
        }

        return false;
    }

    public function setUrls(
        array $urls,
    ): static {
        $this->urls = $urls;

        return $this;
    }
}
