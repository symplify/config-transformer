<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformerPrefix202301\Symfony\Component\Cache\Adapter;

use ConfigTransformerPrefix202301\Psr\Cache\CacheItemInterface;
use ConfigTransformerPrefix202301\Psr\Cache\CacheItemPoolInterface;
use ConfigTransformerPrefix202301\Symfony\Component\Cache\CacheItem;
use ConfigTransformerPrefix202301\Symfony\Component\Cache\PruneableInterface;
use ConfigTransformerPrefix202301\Symfony\Component\Cache\ResettableInterface;
use ConfigTransformerPrefix202301\Symfony\Component\Cache\Traits\ContractsTrait;
use ConfigTransformerPrefix202301\Symfony\Component\Cache\Traits\ProxyTrait;
use ConfigTransformerPrefix202301\Symfony\Contracts\Cache\CacheInterface;
/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class ProxyAdapter implements AdapterInterface, CacheInterface, PruneableInterface, ResettableInterface
{
    use ContractsTrait;
    use ProxyTrait;
    /**
     * @var string
     */
    private $namespace = '';
    /**
     * @var int
     */
    private $namespaceLen;
    /**
     * @var string
     */
    private $poolHash;
    /**
     * @var int
     */
    private $defaultLifetime;
    /**
     * @var \Closure
     */
    private static $createCacheItem;
    /**
     * @var \Closure
     */
    private static $setInnerItem;
    public function __construct(CacheItemPoolInterface $pool, string $namespace = '', int $defaultLifetime = 0)
    {
        $this->pool = $pool;
        $this->poolHash = \spl_object_hash($pool);
        if ('' !== $namespace) {
            \assert('' !== CacheItem::validateKey($namespace));
            $this->namespace = $namespace;
        }
        $this->namespaceLen = \strlen($namespace);
        $this->defaultLifetime = $defaultLifetime;
        self::$createCacheItem = self::$createCacheItem ?? \Closure::bind(static function ($key, $innerItem, $poolHash) {
            $item = new CacheItem();
            $item->key = $key;
            if (null === $innerItem) {
                return $item;
            }
            $item->value = $innerItem->get();
            $item->isHit = $innerItem->isHit();
            $item->innerItem = $innerItem;
            $item->poolHash = $poolHash;
            if (!$item->unpack() && $innerItem instanceof CacheItem) {
                $item->metadata = $innerItem->metadata;
            }
            $innerItem->set(null);
            return $item;
        }, null, CacheItem::class);
        self::$setInnerItem = self::$setInnerItem ?? \Closure::bind(static function (CacheItemInterface $innerItem, CacheItem $item, $expiry = null) {
            $innerItem->set($item->pack());
            $innerItem->expiresAt($expiry ?? $item->expiry ? \DateTimeImmutable::createFromFormat('U.u', \sprintf('%.6F', $expiry ?? $item->expiry)) : null);
        }, null, CacheItem::class);
    }
    /**
     * @return mixed
     */
    public function get(string $key, callable $callback, float $beta = null, array &$metadata = null)
    {
        if (!$this->pool instanceof CacheInterface) {
            return $this->doGet($this, $key, $callback, $beta, $metadata);
        }
        return $this->pool->get($this->getId($key), function ($innerItem, bool &$save) use($key, $callback) {
            $item = (self::$createCacheItem)($key, $innerItem, $this->poolHash);
            $item->set($value = $callback($item, $save));
            (self::$setInnerItem)($innerItem, $item);
            return $value;
        }, $beta, $metadata);
    }
    /**
     * @param mixed $key
     */
    public function getItem($key) : \ConfigTransformerPrefix202301\Psr\Cache\CacheItemInterface
    {
        $item = $this->pool->getItem($this->getId($key));
        return (self::$createCacheItem)($key, $item, $this->poolHash);
    }
    public function getItems(array $keys = []) : iterable
    {
        if ($this->namespaceLen) {
            foreach ($keys as $i => $key) {
                $keys[$i] = $this->getId($key);
            }
        }
        return $this->generateItems($this->pool->getItems($keys));
    }
    /**
     * @param mixed $key
     */
    public function hasItem($key) : bool
    {
        return $this->pool->hasItem($this->getId($key));
    }
    public function clear(string $prefix = '') : bool
    {
        if ($this->pool instanceof AdapterInterface) {
            return $this->pool->clear($this->namespace . $prefix);
        }
        return $this->pool->clear();
    }
    /**
     * @param mixed $key
     */
    public function deleteItem($key) : bool
    {
        return $this->pool->deleteItem($this->getId($key));
    }
    public function deleteItems(array $keys) : bool
    {
        if ($this->namespaceLen) {
            foreach ($keys as $i => $key) {
                $keys[$i] = $this->getId($key);
            }
        }
        return $this->pool->deleteItems($keys);
    }
    public function save(CacheItemInterface $item) : bool
    {
        return $this->doSave($item, __FUNCTION__);
    }
    public function saveDeferred(CacheItemInterface $item) : bool
    {
        return $this->doSave($item, __FUNCTION__);
    }
    public function commit() : bool
    {
        return $this->pool->commit();
    }
    private function doSave(CacheItemInterface $item, string $method) : bool
    {
        if (!$item instanceof CacheItem) {
            return \false;
        }
        $castItem = (array) $item;
        if (null === $castItem["\x00*\x00expiry"] && 0 < $this->defaultLifetime) {
            $castItem["\x00*\x00expiry"] = \microtime(\true) + $this->defaultLifetime;
        }
        if ($castItem["\x00*\x00poolHash"] === $this->poolHash && $castItem["\x00*\x00innerItem"]) {
            $innerItem = $castItem["\x00*\x00innerItem"];
        } elseif ($this->pool instanceof AdapterInterface) {
            // this is an optimization specific for AdapterInterface implementations
            // so we can save a round-trip to the backend by just creating a new item
            $innerItem = (self::$createCacheItem)($this->namespace . $castItem["\x00*\x00key"], null, $this->poolHash);
        } else {
            $innerItem = $this->pool->getItem($this->namespace . $castItem["\x00*\x00key"]);
        }
        (self::$setInnerItem)($innerItem, $item, $castItem["\x00*\x00expiry"]);
        return $this->pool->{$method}($innerItem);
    }
    private function generateItems(iterable $items) : \Generator
    {
        $f = self::$createCacheItem;
        foreach ($items as $key => $item) {
            if ($this->namespaceLen) {
                $key = \substr($key, $this->namespaceLen);
            }
            (yield $key => $f($key, $item, $this->poolHash));
        }
    }
    /**
     * @param mixed $key
     */
    private function getId($key) : string
    {
        \assert('' !== CacheItem::validateKey($key));
        return $this->namespace . $key;
    }
}
