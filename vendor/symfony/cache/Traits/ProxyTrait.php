<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202201159\Symfony\Component\Cache\Traits;

use ConfigTransformer202201159\Symfony\Component\Cache\PruneableInterface;
use ConfigTransformer202201159\Symfony\Contracts\Service\ResetInterface;
/**
 * @author Nicolas Grekas <p@tchwork.com>
 *
 * @internal
 */
trait ProxyTrait
{
    private object $pool;
    /**
     * {@inheritdoc}
     */
    public function prune() : bool
    {
        return $this->pool instanceof \ConfigTransformer202201159\Symfony\Component\Cache\PruneableInterface && $this->pool->prune();
    }
    /**
     * {@inheritdoc}
     */
    public function reset()
    {
        if ($this->pool instanceof \ConfigTransformer202201159\Symfony\Contracts\Service\ResetInterface) {
            $this->pool->reset();
        }
    }
}
