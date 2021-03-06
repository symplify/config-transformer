<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202107130\Symfony\Component\Cache\Adapter;

use ConfigTransformer202107130\Psr\Cache\CacheItemPoolInterface;
use ConfigTransformer202107130\Symfony\Component\Cache\CacheItem;
// Help opcache.preload discover always-needed symbols
\class_exists(\ConfigTransformer202107130\Symfony\Component\Cache\CacheItem::class);
/**
 * Interface for adapters managing instances of Symfony's CacheItem.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
interface AdapterInterface extends \ConfigTransformer202107130\Psr\Cache\CacheItemPoolInterface
{
    /**
     * {@inheritdoc}
     *
     * @return CacheItem
     */
    public function getItem($key);
    /**
     * {@inheritdoc}
     *
     * @return \Traversable|CacheItem[]
     * @param mixed[] $keys
     */
    public function getItems($keys = []);
    /**
     * {@inheritdoc}
     *
     * @return bool
     * @param string $prefix
     */
    public function clear($prefix = '');
}
