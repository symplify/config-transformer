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
    trait Redis62ProxyTrait
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
         * @return \Redis|mixed[]|false
         */
        public function getWithMeta($key)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->getWithMeta(...\func_get_args());
        }
        /**
         * @return string|false
         */
        public function serverName()
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->serverName(...\func_get_args());
        }
        /**
         * @return string|false
         */
        public function serverVersion()
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->serverVersion(...\func_get_args());
        }
    }
} else {
    /**
     * @internal
     */
    trait Redis62ProxyTrait
    {
    }
}
