<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformerPrefix202507\Symfony\Component\Cache\Traits;

if (\version_compare(\phpversion('redis'), '6.1.0-dev', '>')) {
    /**
     * @internal
     */
    trait RedisCluster6ProxyTrait
    {
        /**
         * @return \RedisCluster|string|false
         */
        public function getex($key, $options = [])
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->getex(...\func_get_args());
        }
        /**
         * @return \RedisCluster|bool|int
         */
        public function publish($channel, $message)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->publish(...\func_get_args());
        }
        /**
         * @return \RedisCluster|mixed[]|false
         */
        public function waitaof($key_or_address, $numlocal, $numreplicas, $timeout)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->waitaof(...\func_get_args());
        }
    }
} else {
    /**
     * @internal
     */
    trait RedisCluster6ProxyTrait
    {
        /**
         * @return \RedisCluster|bool
         */
        public function publish($channel, $message)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->publish(...\func_get_args());
        }
    }
}
