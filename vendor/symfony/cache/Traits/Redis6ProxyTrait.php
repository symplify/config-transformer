<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformerPrefix202501\Symfony\Component\Cache\Traits;

if (\version_compare(\phpversion('redis'), '6.1.0-dev', '>=')) {
    /**
     * @internal
     */
    trait Redis6ProxyTrait
    {
        /**
         * @return \Redis|string|false
         */
        public function dump($key)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->dump(...\func_get_args());
        }
        /**
         * @return \Redis|mixed[]|string|false
         */
        public function hRandField($key, $options = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hRandField(...\func_get_args());
        }
        /**
         * @return \Redis|false|int
         */
        public function hSet($key, ...$fields_and_vals)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hSet(...\func_get_args());
        }
        /**
         * @return \Redis|mixed[]|false
         */
        public function mget($keys)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->mget(...\func_get_args());
        }
        /**
         * @return mixed
         */
        public function sRandMember($key, $count = 0)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->sRandMember(...\func_get_args());
        }
        /**
         * @return \Redis|mixed[]|false
         */
        public function waitaof($numlocal, $numreplicas, $timeout)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->waitaof(...\func_get_args());
        }
    }
} else {
    /**
     * @internal
     */
    trait Redis6ProxyTrait
    {
        /**
         * @return \Redis|string
         */
        public function dump($key)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->dump(...\func_get_args());
        }
        /**
         * @return \Redis|mixed[]|string
         */
        public function hRandField($key, $options = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hRandField(...\func_get_args());
        }
        /**
         * @return \Redis|false|int
         */
        public function hSet($key, $member, $value)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hSet(...\func_get_args());
        }
        /**
         * @return \Redis|mixed[]
         */
        public function mget($keys)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->mget(...\func_get_args());
        }
        /**
         * @return \Redis|mixed[]|false|string
         */
        public function sRandMember($key, $count = 0)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->sRandMember(...\func_get_args());
        }
    }
}
