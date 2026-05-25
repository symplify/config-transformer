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

if (\version_compare(\phpversion('relay'), '0.20.0', '>=')) {
    /**
     * @internal
     */
    trait Relay20Trait
    {
        public function _digest($value) : string
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->_digest(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|false|int
         */
        public function delex($key, $options = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->delex(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|false|string|null
         */
        public function digest($key)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->digest(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|false|int
         */
        public function msetex($kvals, $ttl = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->msetx(...\func_get_args());
        }
    }
} else {
    /**
     * @internal
     */
    trait Relay20Trait
    {
    }
}
