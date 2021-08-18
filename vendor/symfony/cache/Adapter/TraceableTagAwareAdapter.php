<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202108180\Symfony\Component\Cache\Adapter;

use ConfigTransformer202108180\Symfony\Contracts\Cache\TagAwareCacheInterface;
/**
 * @author Robin Chalas <robin.chalas@gmail.com>
 */
class TraceableTagAwareAdapter extends \ConfigTransformer202108180\Symfony\Component\Cache\Adapter\TraceableAdapter implements \ConfigTransformer202108180\Symfony\Component\Cache\Adapter\TagAwareAdapterInterface, \ConfigTransformer202108180\Symfony\Contracts\Cache\TagAwareCacheInterface
{
    public function __construct(\ConfigTransformer202108180\Symfony\Component\Cache\Adapter\TagAwareAdapterInterface $pool)
    {
        parent::__construct($pool);
    }
    /**
     * {@inheritdoc}
     * @param mixed[] $tags
     */
    public function invalidateTags($tags)
    {
        $event = $this->start(__FUNCTION__);
        try {
            return $event->result = $this->pool->invalidateTags($tags);
        } finally {
            $event->end = \microtime(\true);
        }
    }
}
