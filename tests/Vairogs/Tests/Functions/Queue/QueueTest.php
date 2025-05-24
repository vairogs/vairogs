<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Tests\Functions\Queue;

use PHPUnit\Framework\TestCase;
use Vairogs\Functions\Queue\Queue;

class QueueTest extends TestCase
{
    public function testQueue(): void
    {
        $queue = new Queue();

        $this->assertCount(expectedCount: 0, haystack: $queue);
        $this->assertTrue(condition: $queue->isEmpty());

        $queue->push(item: 1);
        $queue->push(item: 2);
        $queue->push(item: 3);

        $this->assertCount(expectedCount: 3, haystack: $queue);
        $this->assertFalse(condition: $queue->isEmpty());
        $this->assertTrue(condition: $queue->contains(item: 1));

        $queue->pop();

        $this->assertCount(expectedCount: 2, haystack: $queue);
        $this->assertEquals(expected: 2, actual: $queue->peek());

        $queue->clear();
        $this->assertCount(expectedCount: 0, haystack: $queue);

        $this->assertFalse(condition: $queue->pop());
    }
}
