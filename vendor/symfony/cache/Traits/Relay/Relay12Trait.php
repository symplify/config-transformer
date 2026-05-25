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

if (\version_compare(\phpversion('relay'), '0.12.0', '>=')) {
    /**
     * @internal
     */
    trait Relay12Trait
    {
        /**
         * @return \Relay\Relay|false|int
         */
        public function delifeq($key, $value)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->delifeq(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|false|int
         */
        public function vadd($key, $values, $element, $options = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->vadd(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|false|int
         */
        public function vcard($key)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->vcard(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|false|int
         */
        public function vdim($key)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->vdim(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function vemb($key, $element, $raw = \false)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->vemb(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false|string
         */
        public function vgetattr($key, $element, $raw = \false)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->vgetattr(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function vinfo($key)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->vinfo(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|bool
         */
        public function vismember($key, $element)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->vismember(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function vlinks($key, $element, $withscores)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->vlinks(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false|string
         */
        public function vrandmember($key, $count = 0)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->vrandmember(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function vrange($key, $min, $max, $count = -1)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->vrange(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|false|int
         */
        public function vrem($key, $element)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->vrem(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|false|int
         */
        public function vsetattr($key, $element, $attributes)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->vsetattr(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function vsim($key, $member, $options = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->vsim(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function xdelex($key, $ids, $mode = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->xdelex(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function xackdel($key, $group, $ids, $mode = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->xackdel(...\func_get_args());
        }
    }
} else {
    /**
     * @internal
     */
    trait Relay12Trait
    {
    }
}
