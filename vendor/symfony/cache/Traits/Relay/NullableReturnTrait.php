<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformerPrefix202501\Symfony\Component\Cache\Traits\Relay;

if (\version_compare(\phpversion('relay'), '0.9.0', '>=')) {
    /**
     * @internal
     */
    trait NullableReturnTrait
    {
        /**
         * @return \Relay\Relay|false|string|null
         */
        public function dump($key)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->dump(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|false|float|null
         */
        public function geodist($key, $src, $dst, $unit = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->geodist(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false|string|null
         */
        public function hrandfield($hash, $options = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hrandfield(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|false|string|null
         */
        public function xadd($key, $id, $values, $maxlen = 0, $approx = \false, $nomkstream = \false)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->xadd(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false|int|null
         */
        public function zrank($key, $rank, $withscore = \false)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zrank(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false|int|null
         */
        public function zrevrank($key, $rank, $withscore = \false)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zrevrank(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|false|float|null
         */
        public function zscore($key, $member)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zscore(...\func_get_args());
        }
    }
} else {
    /**
     * @internal
     */
    trait NullableReturnTrait
    {
        /**
         * @return \Relay\Relay|false|string
         */
        public function dump($key)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->dump(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|false|float
         */
        public function geodist($key, $src, $dst, $unit = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->geodist(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false|string
         */
        public function hrandfield($hash, $options = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hrandfield(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|false|string
         */
        public function xadd($key, $id, $values, $maxlen = 0, $approx = \false, $nomkstream = \false)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->xadd(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false|int
         */
        public function zrank($key, $rank, $withscore = \false)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zrank(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false|int
         */
        public function zrevrank($key, $rank, $withscore = \false)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zrevrank(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|false|float
         */
        public function zscore($key, $member)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zscore(...\func_get_args());
        }
    }
}
