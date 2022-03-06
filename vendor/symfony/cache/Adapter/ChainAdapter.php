<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202203065\Symfony\Component\Cache\Adapter;

use ConfigTransformer202203065\Psr\Cache\CacheItemInterface;
use ConfigTransformer202203065\Psr\Cache\CacheItemPoolInterface;
use ConfigTransformer202203065\Symfony\Component\Cache\CacheItem;
use ConfigTransformer202203065\Symfony\Component\Cache\Exception\InvalidArgumentException;
use ConfigTransformer202203065\Symfony\Component\Cache\PruneableInterface;
use ConfigTransformer202203065\Symfony\Component\Cache\ResettableInterface;
use ConfigTransformer202203065\Symfony\Component\Cache\Traits\ContractsTrait;
use ConfigTransformer202203065\Symfony\Contracts\Cache\CacheInterface;
use ConfigTransformer202203065\Symfony\Contracts\Service\ResetInterface;
/**
 * Chains several adapters together.
 *
 * Cached items are fetched from the first adapter having them in its data store.
 * They are saved and deleted in all adapters at once.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class ChainAdapter implements \ConfigTransformer202203065\Symfony\Component\Cache\Adapter\AdapterInterface, \ConfigTransformer202203065\Symfony\Contracts\Cache\CacheInterface, \ConfigTransformer202203065\Symfony\Component\Cache\PruneableInterface, \ConfigTransformer202203065\Symfony\Component\Cache\ResettableInterface
{
    use ContractsTrait;
    private array $adapters = [];
    private int $adapterCount;
    private int $defaultLifetime;
    private static \Closure $syncItem;
    /**
     * @param CacheItemPoolInterface[] $adapters        The ordered list of adapters used to fetch cached items
     * @param int                      $defaultLifetime The default lifetime of items propagated from lower adapters to upper ones
     */
    public function __construct(array $adapters, int $defaultLifetime = 0)
    {
        if (!$adapters) {
            throw new \ConfigTransformer202203065\Symfony\Component\Cache\Exception\InvalidArgumentException('At least one adapter must be specified.');
        }
        foreach ($adapters as $adapter) {
            if (!$adapter instanceof \ConfigTransformer202203065\Psr\Cache\CacheItemPoolInterface) {
                throw new \ConfigTransformer202203065\Symfony\Component\Cache\Exception\InvalidArgumentException(\sprintf('The class "%s" does not implement the "%s" interface.', \get_debug_type($adapter), \ConfigTransformer202203065\Psr\Cache\CacheItemPoolInterface::class));
            }
            if (\in_array(\PHP_SAPI, ['cli', 'phpdbg'], \true) && $adapter instanceof \ConfigTransformer202203065\Symfony\Component\Cache\Adapter\ApcuAdapter && !\filter_var(\ini_get('apc.enable_cli'), \FILTER_VALIDATE_BOOLEAN)) {
                continue;
                // skip putting APCu in the chain when the backend is disabled
            }
            if ($adapter instanceof \ConfigTransformer202203065\Symfony\Component\Cache\Adapter\AdapterInterface) {
                $this->adapters[] = $adapter;
            } else {
                $this->adapters[] = new \ConfigTransformer202203065\Symfony\Component\Cache\Adapter\ProxyAdapter($adapter);
            }
        }
        $this->adapterCount = \count($this->adapters);
        $this->defaultLifetime = $defaultLifetime;
        self::$syncItem ?? (self::$syncItem = \Closure::bind(static function ($sourceItem, $item, $defaultLifetime, $sourceMetadata = null) {
            $sourceItem->isTaggable = \false;
            $sourceMetadata = $sourceMetadata ?? $sourceItem->metadata;
            unset($sourceMetadata[\ConfigTransformer202203065\Symfony\Component\Cache\CacheItem::METADATA_TAGS]);
            $item->value = $sourceItem->value;
            $item->isHit = $sourceItem->isHit;
            $item->metadata = $item->newMetadata = $sourceItem->metadata = $sourceMetadata;
            if (isset($item->metadata[\ConfigTransformer202203065\Symfony\Component\Cache\CacheItem::METADATA_EXPIRY])) {
                $item->expiresAt(\DateTime::createFromFormat('U.u', \sprintf('%.6F', $item->metadata[\ConfigTransformer202203065\Symfony\Component\Cache\CacheItem::METADATA_EXPIRY])));
            } elseif (0 < $defaultLifetime) {
                $item->expiresAfter($defaultLifetime);
            }
            return $item;
        }, null, \ConfigTransformer202203065\Symfony\Component\Cache\CacheItem::class));
    }
    /**
     * {@inheritdoc}
     */
    public function get(string $key, callable $callback, float $beta = null, array &$metadata = null) : mixed
    {
        $lastItem = null;
        $i = 0;
        $wrap = function (\ConfigTransformer202203065\Symfony\Component\Cache\CacheItem $item = null) use($key, $callback, $beta, &$wrap, &$i, &$lastItem, &$metadata) {
            $adapter = $this->adapters[$i];
            if (isset($this->adapters[++$i])) {
                $callback = $wrap;
                $beta = \INF === $beta ? \INF : 0;
            }
            if ($adapter instanceof \ConfigTransformer202203065\Symfony\Contracts\Cache\CacheInterface) {
                $value = $adapter->get($key, $callback, $beta, $metadata);
            } else {
                $value = $this->doGet($adapter, $key, $callback, $beta, $metadata);
            }
            if (null !== $item) {
                (self::$syncItem)($lastItem = $lastItem ?? $item, $item, $this->defaultLifetime, $metadata);
            }
            return $value;
        };
        return $wrap();
    }
    /**
     * {@inheritdoc}
     */
    public function getItem(mixed $key) : \ConfigTransformer202203065\Symfony\Component\Cache\CacheItem
    {
        $syncItem = self::$syncItem;
        $misses = [];
        foreach ($this->adapters as $i => $adapter) {
            $item = $adapter->getItem($key);
            if ($item->isHit()) {
                while (0 <= --$i) {
                    $this->adapters[$i]->save($syncItem($item, $misses[$i], $this->defaultLifetime));
                }
                return $item;
            }
            $misses[$i] = $item;
        }
        return $item;
    }
    /**
     * {@inheritdoc}
     */
    public function getItems(array $keys = []) : iterable
    {
        return $this->generateItems($this->adapters[0]->getItems($keys), 0);
    }
    private function generateItems(iterable $items, int $adapterIndex) : \Generator
    {
        $missing = [];
        $misses = [];
        $nextAdapterIndex = $adapterIndex + 1;
        $nextAdapter = $this->adapters[$nextAdapterIndex] ?? null;
        foreach ($items as $k => $item) {
            if (!$nextAdapter || $item->isHit()) {
                (yield $k => $item);
            } else {
                $missing[] = $k;
                $misses[$k] = $item;
            }
        }
        if ($missing) {
            $syncItem = self::$syncItem;
            $adapter = $this->adapters[$adapterIndex];
            $items = $this->generateItems($nextAdapter->getItems($missing), $nextAdapterIndex);
            foreach ($items as $k => $item) {
                if ($item->isHit()) {
                    $adapter->save($syncItem($item, $misses[$k], $this->defaultLifetime));
                }
                (yield $k => $item);
            }
        }
    }
    /**
     * {@inheritdoc}
     */
    public function hasItem(mixed $key) : bool
    {
        foreach ($this->adapters as $adapter) {
            if ($adapter->hasItem($key)) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * {@inheritdoc}
     */
    public function clear(string $prefix = '') : bool
    {
        $cleared = \true;
        $i = $this->adapterCount;
        while ($i--) {
            if ($this->adapters[$i] instanceof \ConfigTransformer202203065\Symfony\Component\Cache\Adapter\AdapterInterface) {
                $cleared = $this->adapters[$i]->clear($prefix) && $cleared;
            } else {
                $cleared = $this->adapters[$i]->clear() && $cleared;
            }
        }
        return $cleared;
    }
    /**
     * {@inheritdoc}
     */
    public function deleteItem(mixed $key) : bool
    {
        $deleted = \true;
        $i = $this->adapterCount;
        while ($i--) {
            $deleted = $this->adapters[$i]->deleteItem($key) && $deleted;
        }
        return $deleted;
    }
    /**
     * {@inheritdoc}
     */
    public function deleteItems(array $keys) : bool
    {
        $deleted = \true;
        $i = $this->adapterCount;
        while ($i--) {
            $deleted = $this->adapters[$i]->deleteItems($keys) && $deleted;
        }
        return $deleted;
    }
    /**
     * {@inheritdoc}
     */
    public function save(\ConfigTransformer202203065\Psr\Cache\CacheItemInterface $item) : bool
    {
        $saved = \true;
        $i = $this->adapterCount;
        while ($i--) {
            $saved = $this->adapters[$i]->save($item) && $saved;
        }
        return $saved;
    }
    /**
     * {@inheritdoc}
     */
    public function saveDeferred(\ConfigTransformer202203065\Psr\Cache\CacheItemInterface $item) : bool
    {
        $saved = \true;
        $i = $this->adapterCount;
        while ($i--) {
            $saved = $this->adapters[$i]->saveDeferred($item) && $saved;
        }
        return $saved;
    }
    /**
     * {@inheritdoc}
     */
    public function commit() : bool
    {
        $committed = \true;
        $i = $this->adapterCount;
        while ($i--) {
            $committed = $this->adapters[$i]->commit() && $committed;
        }
        return $committed;
    }
    /**
     * {@inheritdoc}
     */
    public function prune() : bool
    {
        $pruned = \true;
        foreach ($this->adapters as $adapter) {
            if ($adapter instanceof \ConfigTransformer202203065\Symfony\Component\Cache\PruneableInterface) {
                $pruned = $adapter->prune() && $pruned;
            }
        }
        return $pruned;
    }
    /**
     * {@inheritdoc}
     */
    public function reset()
    {
        foreach ($this->adapters as $adapter) {
            if ($adapter instanceof \ConfigTransformer202203065\Symfony\Contracts\Service\ResetInterface) {
                $adapter->reset();
            }
        }
    }
}
