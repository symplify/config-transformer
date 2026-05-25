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

if (\version_compare(\phpversion('relay'), '0.21.0', '>=')) {
    /**
     * @internal
     */
    trait Relay21Trait
    {
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function gcra($key, $maxBurst, $requestsPerPeriod, $period, $tokens = 0)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->gcra(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|bool
         */
        public function hotkeys($subcmd, $args = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hotkeys(...\func_get_args());
        }
    }
} else {
    /**
     * @internal
     */
    trait Relay21Trait
    {
    }
}
