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

if (\version_compare(\phpversion('relay'), '0.9.0', '>=')) {
    /**
     * @internal
     */
    trait FtTrait
    {
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function ftAggregate($index, $query, $options = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->ftAggregate(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|bool
         */
        public function ftAliasAdd($index, $alias)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->ftAliasAdd(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|bool
         */
        public function ftAliasDel($alias)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->ftAliasDel(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|bool
         */
        public function ftAliasUpdate($index, $alias)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->ftAliasUpdate(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|bool
         */
        public function ftAlter($index, $schema, $skipinitialscan = \false)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->ftAlter(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|bool
         */
        public function ftConfig($operation, $option, $value = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->ftConfig(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|bool
         */
        public function ftCreate($index, $schema, $options = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->ftCreate(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|bool
         */
        public function ftCursor($operation, $index, $cursor, $options = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->ftCursor(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|false|int
         */
        public function ftDictAdd($dict, $term, ...$other_terms)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->ftDictAdd(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|false|int
         */
        public function ftDictDel($dict, $term, ...$other_terms)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->ftDictDel(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function ftDictDump($dict)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->ftDictDump(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|bool
         */
        public function ftDropIndex($index, $dd = \false)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->ftDropIndex(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|false|string
         */
        public function ftExplain($index, $query, $dialect = 0)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->ftExplain(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function ftExplainCli($index, $query, $dialect = 0)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->ftExplainCli(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function ftInfo($index)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->ftInfo(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function ftProfile($index, $command, $query, $limited = \false)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->ftProfile(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function ftSearch($index, $query, $options = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->ftSearch(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function ftSpellCheck($index, $query, $options = null)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->ftSpellCheck(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function ftSynDump($index)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->ftSynDump(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|bool
         */
        public function ftSynUpdate($index, $synonym, $term_or_terms, $skipinitialscan = \false)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->ftSynUpdate(...\func_get_args());
        }
        /**
         * @return \Relay\Relay|mixed[]|false
         */
        public function ftTagVals($index, $tag)
        {
            return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->ftTagVals(...\func_get_args());
        }
    }
} else {
    /**
     * @internal
     */
    trait FtTrait
    {
    }
}
