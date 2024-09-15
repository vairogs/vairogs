<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\Sitemap\Builder;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Vairogs\Component\Sitemap\Contracts\Builder;
use Vairogs\Component\Sitemap\Model\RichUrl;
use Vairogs\Component\Sitemap\Model\Sitemap;
use Vairogs\Component\Sitemap\Model\Url;

use function sprintf;

abstract class AbstractBuilder implements Builder
{
    public function __construct(
        protected Sitemap $sitemap,
    ) {
    }

    public function build(
        &$buffer,
    ): void {
        foreach ($this->sitemap->getUrls() as $url) {
            $alternates = [];
            $urlArray = $url->toArray();

            if ($url instanceof RichUrl) {
                $alternates = $url->getAlternateUrls();
                unset($urlArray['alternateUrls']);
            }

            $this->write($buffer, '<url>' . "\n");

            $this->writeUrls($buffer, $url, $urlArray);
            $this->writeAlternates($buffer, $alternates);

            $this->write($buffer, '</url>' . "\n");
        }
    }

    public function end(
        &$buffer,
    ): void {
        $this->write($buffer, '</urlset>' . "\n");
    }

    public function start(
        &$buffer,
    ): void {
        $this->write(
            $buffer,
            '<?xml version="1.0" encoding="UTF-8"?>' .
            "\n" .
            '<urlset ' .
            "\n\t" .
            'xmlns="https://www.sitemaps.org/schemas/sitemap/0.9" ' .
            "\n\t" .
            'xmlns:xsi="https://www.w3.org/2001/XMLSchema-instance" ' .
            "\n\t" .
            'xsi:schemaLocation="https://www.sitemaps.org/schemas/sitemap/0.9 https://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"',
        );

        if ($this->sitemap->hasAlternates()) {
            $this->write($buffer, "\n\t" . 'xmlns:xhtml="http://www.w3.org/1999/xhtml" ');
        }

        if ($this->sitemap->hasVideos()) {
            $this->write($buffer, "\n\t" . 'xmlns:video="https://www.google.com/schemas/sitemap-video/1.1"');
        }

        if ($this->sitemap->hasImages()) {
            $this->write($buffer, "\n\t" . 'xmlns:image="https://www.google.com/schemas/sitemap-image/1.1"');
        }

        $this->write($buffer, '>' . "\n");
    }

    abstract protected function write(
        &$buffer,
        string $text,
    ): void;

    protected function getBufferValue(
        Url $url,
        string $key,
    ): string {
        if ($getter = $this->getGetterValue($url, $key)) {
            return "\t" . sprintf('<%s>', $key) . $getter . sprintf('</%s>', $key) . "\n";
        }

        return '';
    }

    protected function getGetterValue(
        Url $url,
        string $key,
    ): ?string {
        static $_helper = null;

        if (null === $_helper) {
            $_helper = PropertyAccess::createPropertyAccessor();
        }

        if ($_helper->isReadable($url, $key)) {
            return (string) $_helper->getValue($url, $key);
        }

        return null;
    }

    private function writeAlternates(
        &$buffer,
        array $alternates = [],
    ): void {
        foreach ($alternates as $locale => $alternate) {
            $this->write($buffer, "\t" . '<xhtml:link rel="alternate" hreflang="' . $locale . '" href="' . $alternate . '" />' . "\n");
        }
    }

    private function writeUrls(
        &$buffer,
        Url|RichUrl $url,
        array $urlArray = [],
    ): void {
        foreach (array_keys($urlArray) as $key) {
            $this->write($buffer, $this->getBufferValue($url, $key));
        }
    }
}
