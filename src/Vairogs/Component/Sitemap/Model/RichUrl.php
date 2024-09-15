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

class RichUrl extends Url
{
    protected array $alternateUrls = [];

    public function addAlternateUrl(
        string $locale,
        string $url,
    ): static {
        $this->alternateUrls[$locale] = $url;

        return $this;
    }

    public function getAlternateUrls(): array
    {
        return $this->alternateUrls;
    }

    public function hasAlternates(): bool
    {
        return [] !== $this->alternateUrls;
    }
}
