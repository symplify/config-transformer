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

if (\version_compare(\phpversion('relay'), '0.12.1', '>=')) {
    /**
     * @internal
     */
    trait Relay121Trait
    {
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function hgetWithMeta($hash, $member)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hgetWithMeta(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|bool|string
         */
        public function select($db)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->select(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|bool|string
         */
        public function watch($key, ...$other_keys)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->watch(...\func_get_args());
        }
    }
} else {
    /**
     * @internal
     */
    trait Relay121Trait
    {
        /**
         * @return \Relay\Relay|bool
         */
        public function select($db)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->select(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|bool
         */
        public function watch($key, ...$other_keys)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->watch(...\func_get_args());
        }
    }
}
