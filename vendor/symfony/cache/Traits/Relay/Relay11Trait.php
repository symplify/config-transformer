<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformerPrefix202605\Symfony\Component\Cache\Traits\Relay;

if (\version_compare(\phpversion('relay'), '0.11.0', '>=')) {
    /**
     * @internal
     */
    trait Relay11Trait
    {
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function cmsIncrBy($key, $field, $value, ...$fields_and_values)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->cmsIncrBy(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function cmsInfo($key)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->cmsInfo(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|bool
         */
        public function cmsInitByDim($key, $width, $depth)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->cmsInitByDim(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|bool
         */
        public function cmsInitByProb($key, $error, $probability)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->cmsInitByProb(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|bool
         */
        public function cmsMerge($dstkey, $keys, $weights = [])
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->cmsMerge(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function cmsQuery($key, ...$fields)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->cmsQuery(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|bool|int
         */
        public function commandlog($subcmd, ...$args)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->commandlog(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function hexpire($hash, $ttl, $fields, $mode = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hexpire(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function hexpireat($hash, $ttl, $fields, $mode = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hexpireat(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function hexpiretime($hash, $fields)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hexpiretime(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function hgetdel($key, $fields)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hgetdel(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function hgetex($hash, $fields, $expiry = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hgetex(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function hpersist($hash, $fields)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hpersist(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function hpexpire($hash, $ttl, $fields, $mode = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hpexpire(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function hpexpireat($hash, $ttl, $fields, $mode = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hpexpireat(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function hpexpiretime($hash, $fields)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hpexpiretime(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function hpttl($hash, $fields)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hpttl(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|false|int
         */
        public function hsetex($key, $fields, $expiry = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hsetex(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function httl($hash, $fields)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->httl(...\func_get_args());
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
    trait Relay11Trait
    {
    }
}
