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

if (\version_compare(\phpversion('relay'), '0.22.0', '>=')) {
    /**
     * @internal
     */
    trait Relay22Trait
    {
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function jsonStrAppend($key, $value, $path = null, $fpha = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->jsonStrAppend(...\func_get_args());
        }
    }
} else {
    /**
     * @internal
     */
    trait Relay22Trait
    {
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function jsonStrAppend($key, $value, $path = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->jsonStrAppend(...\func_get_args());
        }
    }
}
