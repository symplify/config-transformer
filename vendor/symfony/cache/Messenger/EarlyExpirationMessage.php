<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformerPrefix202501\Symfony\Component\Cache\Messenger;

use ConfigTransformerPrefix202501\Symfony\Component\Cache\Adapter\AdapterInterface;
use ConfigTransformerPrefix202501\Symfony\Component\Cache\CacheItem;
use ConfigTransformerPrefix202501\Symfony\Component\DependencyInjection\ReverseContainer;
/**
 * Conveys a cached value that needs to be computed.
 */
final class EarlyExpirationMessage
{
    /**
     * @var \Symfony\Component\Cache\CacheItem
     */
    private $item;
    /**
     * @var string
     */
    private $pool;
    /**
     * @var mixed[]|string
     */
    private $callback;
    public static function create(ReverseContainer $reverseContainer, callable $callback, CacheItem $item, AdapterInterface $pool) : ?self
    {
        try {
            $item = clone $item;
            $item->set(null);
        } catch (\Exception $exception) {
            return null;
        }
        $pool = $reverseContainer->getId($pool);
        if (\is_object($callback)) {
            if (null === ($id = $reverseContainer->getId($callback))) {
                return null;
            }
            $callback = '@' . $id;
        } elseif (!\is_array($callback)) {
            $callback = (string) $callback;
        } elseif (!\is_object($callback[0])) {
            $callback = [(string) $callback[0], (string) $callback[1]];
        } else {
            if (null === ($id = $reverseContainer->getId($callback[0]))) {
                return null;
            }
            $callback = ['@' . $id, (string) $callback[1]];
        }
        return new self($item, $pool, $callback);
    }
    public function getItem() : CacheItem
    {
        return $this->item;
    }
    public function getPool() : string
    {
        return $this->pool;
    }
    /**
     * @return string|string[]
     */
    public function getCallback()
    {
        return $this->callback;
    }
    public function findPool(ReverseContainer $reverseContainer) : AdapterInterface
    {
        return $reverseContainer->getService($this->pool);
    }
    public function findCallback(ReverseContainer $reverseContainer) : callable
    {
        if (\is_string($callback = $this->callback)) {
            return '@' === $callback[0] ? $reverseContainer->getService(\substr($callback, 1)) : $callback;
        }
        if ('@' === $callback[0][0]) {
            $callback[0] = $reverseContainer->getService(\substr($callback[0], 1));
        }
        return $callback;
    }
    /**
     * @param string|mixed[] $callback
     */
    private function __construct(CacheItem $item, string $pool, $callback)
    {
        $this->item = $item;
        $this->pool = $pool;
        $this->callback = $callback;
    }
}
