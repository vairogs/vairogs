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
final readonly class SwitchElement
{
    public function __construct(
        private int $casesStart,
        private int $casesEnd,
        private array $cases,
    ) {
    }

    public function getCases(): array
    {
        return $this->cases;
    }

    public function getCasesEnd(): int
    {
        return $this->casesEnd;
    }

    public function getCasesStart(): int
    {
        return $this->casesStart;
    }
}
