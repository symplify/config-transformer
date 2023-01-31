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
use ConfigTransformerPrefix202301\Symfony\Component\Cache\CacheItem;
use ConfigTransformerPrefix202301\Symfony\Contracts\Cache\CacheInterface;
/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class NullAdapter implements AdapterInterface, CacheInterface
{
    private static $createCacheItem;
    public function __construct()
    {
        self::$createCacheItem = self::$createCacheItem ?? \Closure::bind(static function ($key) {
            $item = new CacheItem();
            $item->key = $key;
            $item->isHit = \false;
            return $item;
        }, null, CacheItem::class);
    }
    /**
     * @return mixed
     */
    public function get(string $key, callable $callback, float $beta = null, array &$metadata = null)
    {
        $save = \true;
        return $callback((self::$createCacheItem)($key), $save);
    }
    /**
     * @param mixed $key
     */
    public function getItem($key) : \ConfigTransformerPrefix202301\Psr\Cache\CacheItemInterface
    {
        return (self::$createCacheItem)($key);
    }
    public function getItems(array $keys = []) : iterable
    {
        return $this->generateItems($keys);
    }
    /**
     * @param mixed $key
     */
    public function hasItem($key) : bool
    {
        return \false;
    }
    public function clear(string $prefix = '') : bool
    {
        return \true;
    }
    /**
     * @param mixed $key
     */
    public function deleteItem($key) : bool
    {
        return \true;
    }
    public function deleteItems(array $keys) : bool
    {
        return \true;
    }
    public function save(CacheItemInterface $item) : bool
    {
        return \true;
    }
    public function saveDeferred(CacheItemInterface $item) : bool
    {
        return \true;
    }
    public function commit() : bool
    {
        return \true;
    }
    public function delete(string $key) : bool
    {
        return $this->deleteItem($key);
    }
    private function generateItems(array $keys) : \Generator
    {
        $f = self::$createCacheItem;
        foreach ($keys as $key) {
            (yield $key => $f($key));
        }
    }
}
