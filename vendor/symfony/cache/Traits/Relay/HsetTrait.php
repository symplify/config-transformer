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
    trait HsetTrait
    {
        /**
         * @return \Relay\Relay|false|int
         */
        public function hset($key, ...$keys_and_vals)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hset(...\func_get_args());
        }
    }
} else {
    /**
     * @internal
     */
    trait HsetTrait
    {
        /**
         * @return \Relay\Relay|false|int
         */
        public function hset($key, $mem, $val, ...$kvals)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hset(...\func_get_args());
        }
    }
}
