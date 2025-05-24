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

/**
 * @internal
 */
final class Worksheet extends AbstractXMLResource
{
    private const ID = 'id';
    private const NAME = 'name';
    private const SHEET = 'sheet';

    public function getWorksheetPaths(
        Relationships $relationships,
    ): array {
        $xml = $this->getXMLReader();
        $paths = [];

        while ($xml->read()) {
            if (XMLReader::ELEMENT === $xml->nodeType && self::SHEET === $xml->name) {
                $rId = $xml->getAttributeNs(name: self::ID, namespace: 'http://schemas.openxmlformats.org/officeDocument/2006/relationships');
                $paths[$xml->getAttribute(name: self::NAME)] = $relationships->getWorksheetPath(rId: $rId);
            }
        }

        return $paths;
    }
}
