<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202112086\Symfony\Component\Cache\Adapter;

use ConfigTransformer202112086\Psr\Cache\CacheItemPoolInterface;
use ConfigTransformer202112086\Symfony\Component\Cache\CacheItem;
// Help opcache.preload discover always-needed symbols
\class_exists(\ConfigTransformer202112086\Symfony\Component\Cache\CacheItem::class);
/**
 * Interface for adapters managing instances of Symfony's CacheItem.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
interface AdapterInterface extends \ConfigTransformer202112086\Psr\Cache\CacheItemPoolInterface
{
    /**
     * {@inheritdoc}
     */
    public function getItem(mixed $key) : \ConfigTransformer202112086\Symfony\Component\Cache\CacheItem;
    /**
     * {@inheritdoc}
     *
     * @return iterable<string, CacheItem>
     */
    public function getItems(array $keys = []) : iterable;
    /**
     * {@inheritdoc}
     */
    public function clear(string $prefix = '') : bool;
}
