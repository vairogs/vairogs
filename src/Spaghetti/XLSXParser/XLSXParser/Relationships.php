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

use function basename;

/**
 * @internal
 */
final class Relationships extends AbstractXMLResource
{
    private const ID = 'Id';
    private const RELATIONSHIP = 'Relationship';
    private const SHARED_STRINGS = 'sharedStrings';
    private const STYLES = 'styles';
    private const TARGET = 'Target';
    private const TYPE = 'Type';
    private const WORKSHEET = 'worksheet';
    private string $sharedStringPath = '';
    private string $stylePath = '';

    private array $workSheetPaths = [];

    public function __construct(
        string $path,
    ) {
        parent::__construct(path: $path);
        $xml = $this->getXMLReader();

        while ($xml->read()) {
            if (XMLReader::ELEMENT === $xml->nodeType && self::RELATIONSHIP === $xml->name) {
                $target = 'xl/' . $xml->getAttribute(name: self::TARGET);

                match (basename(path: (string) $xml->getAttribute(name: self::TYPE))) {
                    self::WORKSHEET => $this->workSheetPaths[$xml->getAttribute(name: self::ID)] = $target,
                    self::STYLES => $this->stylePath = $target,
                    self::SHARED_STRINGS => $this->sharedStringPath = $target,
                    default => null,
                };
            }
        }

        $this->closeXMLReader();
    }

    public function getSharedStringsPath(): string
    {
        return $this->sharedStringPath;
    }

    public function getStylesPath(): string
    {
        return $this->stylePath;
    }

    public function getWorksheetPath(
        string $rId,
    ): string {
        return $this->workSheetPaths[$rId];
    }
}
