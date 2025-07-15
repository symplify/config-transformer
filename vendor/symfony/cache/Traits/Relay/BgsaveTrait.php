<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformerPrefix202507\Symfony\Component\Cache\Traits\Relay;

if (\version_compare(\phpversion('relay'), '0.11', '>=')) {
    /**
     * @internal
     */
    trait BgsaveTrait
    {
        /**
         * @return \Relay\Relay|bool
         */
        public function bgsave($arg = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->bgsave(...\func_get_args());
        }
    }
} else {
    /**
     * @internal
     */
    trait BgsaveTrait
    {
        /**
         * @return \Relay\Relay|bool
         */
        public function bgsave($schedule = \false)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->bgsave(...\func_get_args());
        }
    }
}
