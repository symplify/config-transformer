<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer2021090710\Symfony\Component\Cache\Adapter;

use ConfigTransformer2021090710\Psr\Cache\CacheItemInterface;
use ConfigTransformer2021090710\Symfony\Component\Cache\CacheItem;
use ConfigTransformer2021090710\Symfony\Contracts\Cache\CacheInterface;
/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class NullAdapter implements \ConfigTransformer2021090710\Symfony\Component\Cache\Adapter\AdapterInterface, \ConfigTransformer2021090710\Symfony\Contracts\Cache\CacheInterface
{
    private static $createCacheItem;
    public function __construct()
    {
        self::$createCacheItem ?? (self::$createCacheItem = \Closure::bind(static function ($key) {
            $item = new \ConfigTransformer2021090710\Symfony\Component\Cache\CacheItem();
            $item->key = $key;
            $item->isHit = \false;
            return $item;
        }, null, \ConfigTransformer2021090710\Symfony\Component\Cache\CacheItem::class));
    }
    /**
     * {@inheritdoc}
     * @param string $key
     * @param callable $callback
     * @param float|null $beta
     * @param mixed[]|null $metadata
     */
    public function get($key, $callback, $beta = null, &$metadata = null)
    {
        $save = \true;
        return $callback((self::$createCacheItem)($key), $save);
    }
    /**
     * {@inheritdoc}
     */
    public function getItem($key)
    {
        return (self::$createCacheItem)($key);
    }
    /**
     * {@inheritdoc}
     * @param mixed[] $keys
     */
    public function getItems($keys = [])
    {
        return $this->generateItems($keys);
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function hasItem($key)
    {
        return \false;
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     * @param string $prefix
     */
    public function clear($prefix = '')
    {
        return \true;
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function deleteItem($key)
    {
        return \true;
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     * @param mixed[] $keys
     */
    public function deleteItems($keys)
    {
        return \true;
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     * @param \Psr\Cache\CacheItemInterface $item
     */
    public function save($item)
    {
        return \true;
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     * @param \Psr\Cache\CacheItemInterface $item
     */
    public function saveDeferred($item)
    {
        return \true;
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function commit()
    {
        return \true;
    }
    /**
     * {@inheritdoc}
     * @param string $key
     */
    public function delete($key) : bool
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
