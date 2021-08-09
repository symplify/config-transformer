<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202108098\Symfony\Component\Cache\Adapter;

use ConfigTransformer202108098\Psr\SimpleCache\CacheInterface;
use ConfigTransformer202108098\Symfony\Component\Cache\PruneableInterface;
use ConfigTransformer202108098\Symfony\Component\Cache\ResettableInterface;
use ConfigTransformer202108098\Symfony\Component\Cache\Traits\ProxyTrait;
/**
 * Turns a PSR-16 cache into a PSR-6 one.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
class Psr16Adapter extends \ConfigTransformer202108098\Symfony\Component\Cache\Adapter\AbstractAdapter implements \ConfigTransformer202108098\Symfony\Component\Cache\PruneableInterface, \ConfigTransformer202108098\Symfony\Component\Cache\ResettableInterface
{
    use ProxyTrait;
    /**
     * @internal
     */
    protected const NS_SEPARATOR = '_';
    private $miss;
    public function __construct(\ConfigTransformer202108098\Psr\SimpleCache\CacheInterface $pool, string $namespace = '', int $defaultLifetime = 0)
    {
        parent::__construct($namespace, $defaultLifetime);
        $this->pool = $pool;
        $this->miss = new \stdClass();
    }
    /**
     * {@inheritdoc}
     * @param mixed[] $ids
     */
    protected function doFetch($ids)
    {
        foreach ($this->pool->getMultiple($ids, $this->miss) as $key => $value) {
            if ($this->miss !== $value) {
                (yield $key => $value);
            }
        }
    }
    /**
     * {@inheritdoc}
     * @param string $id
     */
    protected function doHave($id)
    {
        return $this->pool->has($id);
    }
    /**
     * {@inheritdoc}
     * @param string $namespace
     */
    protected function doClear($namespace)
    {
        return $this->pool->clear();
    }
    /**
     * {@inheritdoc}
     * @param mixed[] $ids
     */
    protected function doDelete($ids)
    {
        return $this->pool->deleteMultiple($ids);
    }
    /**
     * {@inheritdoc}
     * @param mixed[] $values
     * @param int $lifetime
     */
    protected function doSave($values, $lifetime)
    {
        return $this->pool->setMultiple($values, 0 === $lifetime ? null : $lifetime);
    }
}
