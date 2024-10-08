<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\Mapper\Service;

use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Vairogs\Component\Functions\Collection\Contracts\SimpleCollection;
use Vairogs\Component\Functions\Collection\SimpleArrayCollection;
use Vairogs\Component\Functions\Collection\SimpleObjectCollection;
use Vairogs\Component\Mapper\Constants\Context;

#[Autoconfigure(public: true)]
final readonly class RequestCache
{
    private SimpleCollection $cache;

    public function __construct(
        private bool $useObject = false,
    ) {
        $this->cache = $this->new();
    }

    public function cache(
        Context $cacheContext,
    ): SimpleCollection {
        if (!$this->cache->containsKey($cacheContext->value)) {
            $this->cache->set($cacheContext->value, $this->new());
        }

        return $this->cache->get($cacheContext->value);
    }

    public function get(
        Context $cacheContext,
        int|string $key,
        callable $callback,
        string ...$subKeys,
    ): mixed {
        $cache = $this->cache($cacheContext);

        $currentKey = $key;

        foreach ($subKeys as $subKey) {
            if (!$cache->containsKey($currentKey)) {
                $cache->set($currentKey, $this->new());
            }

            $cache = $cache->get($currentKey);
            $currentKey = $subKey;
        }

        if (!$cache->containsKey($currentKey)) {
            $cache->set($currentKey, $callback());
        }

        return $cache->get($currentKey);
    }

    public function getValue(
        Context $cacheContext,
        int|string $key,
        mixed $default = null,
        string ...$subKeys,
    ): mixed {
        $cache = $this->cache($cacheContext);

        $currentKey = $key;

        foreach ($subKeys as $subKey) {
            if (!$cache->containsKey($currentKey)) {
                return $default;
            }

            $cache = $cache->get($currentKey);
            $currentKey = $subKey;
        }

        return $cache->containsKey($currentKey) ? $cache->get($currentKey) : $default;
    }

    private function new(): SimpleCollection
    {
        return match ($this->useObject) {
            false => new SimpleArrayCollection(),
            true => new SimpleObjectCollection(),
        };
    }
}
