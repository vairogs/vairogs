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
final readonly class ArrayElement
{
    public function __construct(
        private ?int $keyStartIndex,
        private ?int $keyEndIndex,
        private int $valueStartIndex,
        private int $valueEndIndex,
    ) {
    }

    public function getKeyEndIndex(): ?int
    {
        return $this->keyEndIndex;
    }

    public function getKeyStartIndex(): ?int
    {
        return $this->keyStartIndex;
    }

    public function getValueEndIndex(): int
    {
        return $this->valueEndIndex;
    }

    public function getValueStartIndex(): int
    {
        return $this->valueStartIndex;
    }
}
