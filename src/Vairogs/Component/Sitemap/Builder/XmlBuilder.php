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

use Symfony\Component\PropertyInfo\Type;

class XmlBuilder extends AbstractBuilder
{
    public function getType(): string
    {
        return Type::BUILTIN_TYPE_STRING;
    }

    protected function write(
        &$buffer,
        string $text,
    ): void {
        $buffer .= $text;
    }
}
