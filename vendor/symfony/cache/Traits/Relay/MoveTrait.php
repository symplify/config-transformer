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
    trait MoveTrait
    {
        /**
         * @return mixed
         */
        public function blmove($srckey, $dstkey, $srcpos, $dstpos, $timeout)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->blmove(...\func_get_args());
        }
        /**
         * @return mixed
         */
        public function lmove($srckey, $dstkey, $srcpos, $dstpos)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->lmove(...\func_get_args());
        }
    }
} else {
    /**
     * @internal
     */
    trait MoveTrait
    {
        /**
         * @return \Relay\Relay|false|null|string
         */
        public function blmove($srckey, $dstkey, $srcpos, $dstpos, $timeout)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->blmove(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|false|null|string
         */
        public function lmove($srckey, $dstkey, $srcpos, $dstpos)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->lmove(...\func_get_args());
        }
    }
}
