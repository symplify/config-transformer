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

if (\version_compare(\phpversion('relay'), '0.8.1', '>=')) {
    /**
     * @internal
     */
    trait CopyTrait
    {
        /**
         * @return \Relay\Relay|bool
         */
        public function copy($src, $dst, $options = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->copy(...\func_get_args());
        }
    }
} else {
    /**
     * @internal
     */
    trait CopyTrait
    {
        /**
         * @return \Relay\Relay|false|int
         */
        public function copy($src, $dst, $options = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->copy(...\func_get_args());
        }
    }
}
