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

if (\version_compare(\phpversion('redis'), '6.3.0', '>=')) {
    /**
     * @internal
     */
    trait RedisCluster63ProxyTrait
    {
        /**
         * @return \RedisCluster|int|false
         */
        public function delifeq($key, $value)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->delifeq(...\func_get_args());
        }
        /**
         * @return \RedisCluster|mixed[]|false
         */
        public function hexpire($key, $ttl, $fields, $mode = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hexpire(...\func_get_args());
        }
        /**
         * @return \RedisCluster|mixed[]|false
         */
        public function hexpireat($key, $time, $fields, $mode = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hexpireat(...\func_get_args());
        }
        /**
         * @return \RedisCluster|mixed[]|false
         */
        public function hexpiretime($key, $fields)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hexpiretime(...\func_get_args());
        }
        /**
         * @return \RedisCluster|mixed[]|false
         */
        public function hgetdel($key, $fields)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hgetdel(...\func_get_args());
        }
        /**
         * @return \RedisCluster|mixed[]|false
         */
        public function hgetex($key, $fields, $expiry = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hgetex(...\func_get_args());
        }
        /**
         * @return mixed
         */
        public function hgetWithMeta($key, $member)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hgetWithMeta(...\func_get_args());
        }
        /**
         * @return \RedisCluster|mixed[]|false
         */
        public function hpersist($key, $fields)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hpersist(...\func_get_args());
        }
        /**
         * @return \RedisCluster|mixed[]|false
         */
        public function hpexpire($key, $ttl, $fields, $mode = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hpexpire(...\func_get_args());
        }
        /**
         * @return \RedisCluster|mixed[]|false
         */
        public function hpexpireat($key, $mstime, $fields, $mode = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hpexpireat(...\func_get_args());
        }
        /**
         * @return \RedisCluster|mixed[]|false
         */
        public function hpexpiretime($key, $fields)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hpexpiretime(...\func_get_args());
        }
        /**
         * @return \RedisCluster|mixed[]|false
         */
        public function hpttl($key, $fields)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hpttl(...\func_get_args());
        }
        /**
         * @return \RedisCluster|int|false
         */
        public function hsetex($key, $fields, $expiry = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hsetex(...\func_get_args());
        }
        /**
         * @return \RedisCluster|mixed[]|false
         */
        public function httl($key, $fields)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->httl(...\func_get_args());
        }
        /**
         * @return \RedisCluster|int|false
         */
        public function vadd($key, $values, $element, $options = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->vadd(...\func_get_args());
        }
        /**
         * @return \RedisCluster|int|false
         */
        public function vcard($key)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->vcard(...\func_get_args());
        }
        /**
         * @return \RedisCluster|int|false
         */
        public function vdim($key)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->vdim(...\func_get_args());
        }
        /**
         * @return \RedisCluster|mixed[]|false
         */
        public function vemb($key, $member, $raw = \false)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->vemb(...\func_get_args());
        }
        /**
         * @return \RedisCluster|mixed[]|string|false
         */
        public function vgetattr($key, $member, $decode = \true)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->vgetattr(...\func_get_args());
        }
        /**
         * @return \RedisCluster|mixed[]|false
         */
        public function vinfo($key)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->vinfo(...\func_get_args());
        }
        /**
         * @return \RedisCluster|bool
         */
        public function vismember($key, $member)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->vismember(...\func_get_args());
        }
        /**
         * @return \RedisCluster|mixed[]|false
         */
        public function vlinks($key, $member, $withscores = \false)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->vlinks(...\func_get_args());
        }
        /**
         * @return \RedisCluster|mixed[]|string|false
         */
        public function vrandmember($key, $count = 0)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->vrandmember(...\func_get_args());
        }
        /**
         * @return \RedisCluster|mixed[]|false
         */
        public function vrange($key, $min, $max, $count = -1)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->vrange(...\func_get_args());
        }
        /**
         * @return \RedisCluster|int|false
         */
        public function vrem($key, $member)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->vrem(...\func_get_args());
        }
        /**
         * @return \RedisCluster|int|false
         */
        public function vsetattr($key, $member, $attributes)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->vsetattr(...\func_get_args());
        }
        /**
         * @return \RedisCluster|mixed[]|false
         */
        public function vsim($key, $member, $options = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->vsim(...\func_get_args());
        }
    }
} else {
    /**
     * @internal
     */
    trait RedisCluster63ProxyTrait
    {
    }
}
