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

use XMLReader;

use function strtr;
use function trim;

/**
 * @internal
 */
final class SharedStrings extends AbstractXMLDictionary
{
    private const INDEX = 'si';
    private const VALUE = 't';

    private int $currentIndex = -1;

    protected function readNext(): void
    {
        $xml = $this->getXMLReader();

        while ($xml->read()) {
            if (XMLReader::ELEMENT === $xml->nodeType) {
                $this->process(xml: $xml);
            }
        }

        $this->valid = false;
        $this->closeXMLReader();
    }

    private function process(
        XMLReader $xml,
    ): void {
        match ($xml->name) {
            self::INDEX => $this->currentIndex++,
            self::VALUE => $this->values[$this->currentIndex][] = trim(string: strtr($xml->readString(), ["\u{a0}" => ' ']), characters: ' '),
            default => null,
        };
    }
}
