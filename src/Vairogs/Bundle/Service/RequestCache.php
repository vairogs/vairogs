<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Bundle\Service;

use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Vairogs\Bundle\Collection\SimpleArrayCollection;
use Vairogs\Bundle\Collection\SimpleObjectCollection;
use Vairogs\Bundle\Contracts\SimpleCollection;

#[Autoconfigure(public: true)]
final class RequestCache
{
    private SimpleCollection $cache;

    public function __construct(
        private readonly bool $useObject = true,
    ) {
        $this->cache = $this->new();
    }

    public function cache(
        string $cacheContext,
    ): SimpleCollection {
        if (!$this->cache->containsKey($cacheContext)) {
            $this->cache->set($cacheContext, $this->new());
        }

        return $this->cache->get($cacheContext);
    }

    public function get(
        string $cacheContext,
        string $key,
        callable $callback,
    ): mixed {
        $cache = $this->cache($cacheContext);

        if (!$cache->containsKey($key)) {
            $cache->set($key, $callback());
        }

        return $cache->get($key);
    }

    private function new(): SimpleCollection
    {
        return $this->useObject ? new SimpleObjectCollection() : new SimpleArrayCollection();
    }
}
