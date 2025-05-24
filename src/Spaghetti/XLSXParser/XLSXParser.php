<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spaghetti;

use Spaghetti\XLSXParser\Contracts\XLSXInterface;
use Spaghetti\XLSXParser\Contracts\XLSXParserInterface;

final class XLSXParser implements XLSXParserInterface
{
    public function open(
        string $path,
    ): XLSXInterface {
        return new XLSXParser\XLSX(
            archive: new XLSXParser\Archive(archivePath: $path),
        );
    }
}
