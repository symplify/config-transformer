<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformerPrefix202501\Symfony\Component\Cache\Traits;

if (\version_compare(\phpversion('relay'), '0.8.1', '>=')) {
    /**
     * @internal
     */
    trait RelayProxyTrait
    {
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function jsonArrAppend($key, $value_or_array, $path = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->jsonArrAppend(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function jsonArrIndex($key, $path, $value, $start = 0, $stop = -1)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->jsonArrIndex(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function jsonArrInsert($key, $path, $index, $value, ...$other_values)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->jsonArrInsert(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function jsonArrLen($key, $path = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->jsonArrLen(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function jsonArrPop($key, $path = null, $index = -1)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->jsonArrPop(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function jsonArrTrim($key, $path, $start, $stop)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->jsonArrTrim(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|false|int
         */
        public function jsonClear($key, $path = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->jsonClear(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|false|int
         */
        public function jsonDebug($command, $key, $path = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->jsonDebug(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|false|int
         */
        public function jsonDel($key, $path = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->jsonDel(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|false|int
         */
        public function jsonForget($key, $path = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->jsonForget(...\func_get_args());
        }
        /**
         * @return mixed
         */
        public function jsonGet($key, $options = [], ...$paths)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->jsonGet(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|bool
         */
        public function jsonMerge($key, $path, $value)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->jsonMerge(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function jsonMget($key_or_array, $path)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->jsonMget(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|bool
         */
        public function jsonMset($key, $path, $value, ...$other_triples)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->jsonMset(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function jsonNumIncrBy($key, $path, $value)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->jsonNumIncrBy(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function jsonNumMultBy($key, $path, $value)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->jsonNumMultBy(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function jsonObjKeys($key, $path = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->jsonObjKeys(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function jsonObjLen($key, $path = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->jsonObjLen(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false|int|string
         */
        public function jsonResp($key, $path = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->jsonResp(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|bool
         */
        public function jsonSet($key, $path, $value, $condition = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->jsonSet(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function jsonStrAppend($key, $value, $path = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->jsonStrAppend(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function jsonStrLen($key, $path = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->jsonStrLen(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function jsonToggle($key, $path)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->jsonToggle(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function jsonType($key, $path = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->jsonType(...\func_get_args());
        }
    }
} else {
    /**
     * @internal
     */
    trait RelayProxyTrait
    {
    }
}
