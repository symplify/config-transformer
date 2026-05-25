<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformerPrefix202605\Symfony\Component\Cache\Traits;

if (\version_compare(\phpversion('redis'), '6.2.0', '>=')) {
    /**
     * @internal
     */
    trait RedisCluster62ProxyTrait
    {
        /**
         * @return \Redis|false|int
         */
        public function expiremember($key, $field, $ttl, $unit = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->expiremember(...\func_get_args());
        }
        /**
         * @return \Redis|false|int
         */
        public function expirememberat($key, $field, $timestamp)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->expirememberat(...\func_get_args());
        }
        /**
         * @return mixed
         */
        public function getdel($key)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->getdel(...\func_get_args());
        }
        /**
         * @return \RedisCluster|mixed[]|false
         */
        public function getWithMeta($key)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->getWithMeta(...\func_get_args());
        }
    }
} else {
    /**
     * @internal
     */
    trait RedisCluster62ProxyTrait
    {
    }
}
