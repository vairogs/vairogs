<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Functions\Queue;

use Countable;

use function array_shift;
use function count;
use function current;
use function in_array;

/**
 * @template T
 */
final class Queue implements Countable
{
    public function __construct(
        /** @var array<T> */
        private array $items = [],
    ) {
    }

    public function clear(): void
    {
        $this->items = [];
    }

    public function contains(
        mixed $item,
    ): bool {
        return in_array(needle: $item, haystack: $this->items, strict: true);
    }

    public function count(): int
    {
        return count(value: $this->items);
    }

    public function isEmpty(): bool
    {
        return [] === $this->items;
    }

    public function peek(): mixed
    {
        return current(array: $this->items);
    }

    public function pop(): mixed
    {
        if ($this->isEmpty()) {
            return false;
        }

        return array_shift(array: $this->items);
    }

    public function push(
        mixed $item,
    ): void {
        if (null !== $item) {
            $this->items[] = $item;
        }
    }
}
