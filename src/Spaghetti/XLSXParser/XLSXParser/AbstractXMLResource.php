<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spaghetti\XLSXParser;

use Spaghetti\XLSXParser\Exception\InvalidXLSXFileException;
use Throwable;
use XMLReader;

/**
 * @internal
 */
abstract class AbstractXMLResource
{
    private ?XMLReader $xml = null;

    public function __construct(
        private readonly string $path,
    ) {
    }

    public function __destruct()
    {
        $this->closeXMLReader();
    }

    protected function closeXMLReader(): void
    {
        $this->xml?->close();
        $this->xml = null;
    }

    protected function createXMLReader(): XMLReader
    {
        return $this->validateXMLReader(xml: new XMLReader());
    }

    protected function getXMLReader(): XMLReader
    {
        return $this->xml ??= $this->createXMLReader();
    }

    private function validateXMLReader(
        XMLReader $xml,
    ): XMLReader {
        try {
            @$xml->open(uri: $this->path);
            $xml->read();
        } catch (Throwable $throwable) {
            throw new InvalidXLSXFileException(path: $this->path, previous: $throwable);
        }

        return $xml;
    }
}
