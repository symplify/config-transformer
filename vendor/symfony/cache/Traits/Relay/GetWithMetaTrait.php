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

if (\version_compare(\phpversion('relay'), '0.10.1', '>=')) {
    /**
     * @internal
     */
    trait GetWithMetaTrait
    {
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function getWithMeta($key)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->getWithMeta(...\func_get_args());
        }
    }
} else {
    /**
     * @internal
     */
    trait GetWithMetaTrait
    {
    }
}
