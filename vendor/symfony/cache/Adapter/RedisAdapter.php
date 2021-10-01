<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202110013\Symfony\Component\Cache\Adapter;

use ConfigTransformer202110013\Symfony\Component\Cache\Marshaller\MarshallerInterface;
use ConfigTransformer202110013\Symfony\Component\Cache\Traits\RedisClusterProxy;
use ConfigTransformer202110013\Symfony\Component\Cache\Traits\RedisProxy;
use ConfigTransformer202110013\Symfony\Component\Cache\Traits\RedisTrait;
class RedisAdapter extends \ConfigTransformer202110013\Symfony\Component\Cache\Adapter\AbstractAdapter
{
    use RedisTrait;
    /**
     * @param \Redis|\RedisArray|\RedisCluster|\Predis\ClientInterface|RedisProxy|RedisClusterProxy $redis           The redis client
     * @param string                                                                                $namespace       The default namespace
     * @param int                                                                                   $defaultLifetime The default lifetime
     */
    public function __construct($redis, string $namespace = '', int $defaultLifetime = 0, \ConfigTransformer202110013\Symfony\Component\Cache\Marshaller\MarshallerInterface $marshaller = null)
    {
        $this->init($redis, $namespace, $defaultLifetime, $marshaller);
    }
}
