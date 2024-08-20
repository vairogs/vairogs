<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\PhpCsFixerCustomFixers\PhpCsFixer\Analyzer\Element;

/**
 * @internal
 */
final readonly class Argument
{
    public function __construct(
        private int $startIndex,
        private int $endIndex,
        private bool $isConstant,
    ) {
    }

    public function getEndIndex(): int
    {
        return $this->endIndex;
    }

    public function getStartIndex(): int
    {
        return $this->startIndex;
    }

    public function isConstant(): bool
    {
        return $this->isConstant;
    }
}
