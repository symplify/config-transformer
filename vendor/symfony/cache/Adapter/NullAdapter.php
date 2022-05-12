<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202205122\Symfony\Component\Cache\Adapter;

use ConfigTransformer202205122\Psr\Cache\CacheItemInterface;
use ConfigTransformer202205122\Symfony\Component\Cache\CacheItem;
use ConfigTransformer202205122\Symfony\Contracts\Cache\CacheInterface;
/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class NullAdapter implements \ConfigTransformer202205122\Symfony\Component\Cache\Adapter\AdapterInterface, \ConfigTransformer202205122\Symfony\Contracts\Cache\CacheInterface
{
    private static $createCacheItem;
    public function __construct()
    {
        self::$createCacheItem ?? (self::$createCacheItem = \Closure::bind(static function ($key) {
            $item = new \ConfigTransformer202205122\Symfony\Component\Cache\CacheItem();
            $item->key = $key;
            $item->isHit = \false;
            return $item;
        }, null, \ConfigTransformer202205122\Symfony\Component\Cache\CacheItem::class));
    }
    /**
     * {@inheritdoc}
     */
    public function get(string $key, callable $callback, float $beta = null, array &$metadata = null) : mixed
    {
        $save = \true;
        return $callback((self::$createCacheItem)($key), $save);
    }
    /**
     * {@inheritdoc}
     */
    public function getItem(mixed $key) : \ConfigTransformer202205122\Symfony\Component\Cache\CacheItem
    {
        return (self::$createCacheItem)($key);
    }
    /**
     * {@inheritdoc}
     */
    public function getItems(array $keys = []) : iterable
    {
        return $this->generateItems($keys);
    }
    /**
     * {@inheritdoc}
     */
    public function hasItem(mixed $key) : bool
    {
        return \false;
    }
    /**
     * {@inheritdoc}
     */
    public function clear(string $prefix = '') : bool
    {
        return \true;
    }
    /**
     * {@inheritdoc}
     */
    public function deleteItem(mixed $key) : bool
    {
        return \true;
    }
    /**
     * {@inheritdoc}
     */
    public function deleteItems(array $keys) : bool
    {
        return \true;
    }
    /**
     * {@inheritdoc}
     */
    public function save(\ConfigTransformer202205122\Psr\Cache\CacheItemInterface $item) : bool
    {
        return \true;
    }
    /**
     * {@inheritdoc}
     */
    public function saveDeferred(\ConfigTransformer202205122\Psr\Cache\CacheItemInterface $item) : bool
    {
        return \true;
    }
    /**
     * {@inheritdoc}
     */
    public function commit() : bool
    {
        return \true;
    }
    /**
     * {@inheritdoc}
     */
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
