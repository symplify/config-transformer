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

use ConfigTransformerPrefix202501\Symfony\Component\Cache\Traits\Relay\CopyTrait;
use ConfigTransformerPrefix202501\Symfony\Component\Cache\Traits\Relay\GeosearchTrait;
use ConfigTransformerPrefix202501\Symfony\Component\Cache\Traits\Relay\GetrangeTrait;
use ConfigTransformerPrefix202501\Symfony\Component\Cache\Traits\Relay\HsetTrait;
use ConfigTransformerPrefix202501\Symfony\Component\Cache\Traits\Relay\MoveTrait;
use ConfigTransformerPrefix202501\Symfony\Component\Cache\Traits\Relay\NullableReturnTrait;
use ConfigTransformerPrefix202501\Symfony\Component\Cache\Traits\Relay\PfcountTrait;
use ConfigTransformerPrefix202501\Symfony\Component\VarExporter\LazyObjectInterface;
use ConfigTransformerPrefix202501\Symfony\Component\VarExporter\LazyProxyTrait;
use ConfigTransformerPrefix202501\Symfony\Contracts\Service\ResetInterface;
// Help opcache.preload discover always-needed symbols
\class_exists(\ConfigTransformerPrefix202501\Symfony\Component\VarExporter\Internal\Hydrator::class);
\class_exists(\ConfigTransformerPrefix202501\Symfony\Component\VarExporter\Internal\LazyObjectRegistry::class);
\class_exists(\ConfigTransformerPrefix202501\Symfony\Component\VarExporter\Internal\LazyObjectState::class);
/**
 * @internal
 */
class RelayProxy extends \ConfigTransformerPrefix202501\Relay\Relay implements ResetInterface, LazyObjectInterface
{
    use CopyTrait;
    use GeosearchTrait;
    use GetrangeTrait;
    use HsetTrait;
    use LazyProxyTrait {
        resetLazyObject as reset;
    }
    use MoveTrait;
    use NullableReturnTrait;
    use PfcountTrait;
    use RelayProxyTrait;
    private const LAZY_OBJECT_PROPERTY_SCOPES = [];
    public function __construct($host = null, $port = 6379, $connect_timeout = 0.0, $command_timeout = 0.0, $context = [], $database = 0)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->__construct(...\func_get_args());
    }
    public function connect($host, $port = 6379, $timeout = 0.0, $persistent_id = null, $retry_interval = 0, $read_timeout = 0.0, $context = [], $database = 0) : bool
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->connect(...\func_get_args());
    }
    public function pconnect($host, $port = 6379, $timeout = 0.0, $persistent_id = null, $retry_interval = 0, $read_timeout = 0.0, $context = [], $database = 0) : bool
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->pconnect(...\func_get_args());
    }
    public function close() : bool
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->close(...\func_get_args());
    }
    public function pclose() : bool
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->pclose(...\func_get_args());
    }
    public function listen($callback) : bool
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->listen(...\func_get_args());
    }
    public function onFlushed($callback) : bool
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->onFlushed(...\func_get_args());
    }
    public function onInvalidated($callback, $pattern = null) : bool
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->onInvalidated(...\func_get_args());
    }
    /**
     * @return int|false
     */
    public function dispatchEvents()
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->dispatchEvents(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function getOption($option)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->getOption(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function option($option, $value = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->option(...\func_get_args());
    }
    public function setOption($option, $value) : bool
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->setOption(...\func_get_args());
    }
    public function addIgnorePatterns(...$pattern) : int
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->addIgnorePatterns(...\func_get_args());
    }
    public function addAllowPatterns(...$pattern) : int
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->addAllowPatterns(...\func_get_args());
    }
    /**
     * @return float|false
     */
    public function getTimeout()
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->getTimeout(...\func_get_args());
    }
    /**
     * @return float|false
     */
    public function timeout()
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->timeout(...\func_get_args());
    }
    /**
     * @return float|false
     */
    public function getReadTimeout()
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->getReadTimeout(...\func_get_args());
    }
    /**
     * @return float|false
     */
    public function readTimeout()
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->readTimeout(...\func_get_args());
    }
    public function getBytes() : array
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->getBytes(...\func_get_args());
    }
    public function bytes() : array
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->bytes(...\func_get_args());
    }
    /**
     * @return string|false
     */
    public function getHost()
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->getHost(...\func_get_args());
    }
    public function isConnected() : bool
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->isConnected(...\func_get_args());
    }
    /**
     * @return int|false
     */
    public function getPort()
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->getPort(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function getAuth()
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->getAuth(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function getDbNum()
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->getDbNum(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function _serialize($value)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->_serialize(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function _unserialize($value)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->_unserialize(...\func_get_args());
    }
    public function _compress($value) : string
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->_compress(...\func_get_args());
    }
    public function _uncompress($value) : string
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->_uncompress(...\func_get_args());
    }
    public function _pack($value) : string
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->_pack(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function _unpack($value)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->_unpack(...\func_get_args());
    }
    public function _prefix($value) : string
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->_prefix(...\func_get_args());
    }
    public function getLastError() : ?string
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->getLastError(...\func_get_args());
    }
    public function clearLastError() : bool
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->clearLastError(...\func_get_args());
    }
    /**
     * @return string|false
     */
    public function endpointId()
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->endpointId(...\func_get_args());
    }
    /**
     * @return string|false
     */
    public function getPersistentID()
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->getPersistentID(...\func_get_args());
    }
    /**
     * @return string|false
     */
    public function socketId()
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->socketId(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function rawCommand($cmd, ...$args)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->rawCommand(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool
     */
    public function select($db)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->select(...\func_get_args());
    }
    public function auth($auth) : bool
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->auth(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false
     */
    public function info(...$sections)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->info(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool
     */
    public function flushdb($sync = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->flushdb(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool
     */
    public function flushall($sync = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->flushall(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function fcall($name, $keys = [], $argv = [], $handler = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->fcall(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function fcall_ro($name, $keys = [], $argv = [], $handler = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->fcall_ro(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function function($op, ...$args)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->function(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function dbsize()
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->dbsize(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool
     */
    public function replicaof($host = null, $port = 0)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->replicaof(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false
     */
    public function waitaof($numlocal, $numremote, $timeout)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->waitaof(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool
     */
    public function restore($key, $ttl, $value, $options = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->restore(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool
     */
    public function migrate($host, $port, $key, $dstdb, $timeout, $copy = \false, $replace = \false, $credentials = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->migrate(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool|string
     */
    public function echo($arg)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->echo(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool|string
     */
    public function ping($arg = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->ping(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function idleTime()
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->idleTime(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool|null|string
     */
    public function randomkey()
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->randomkey(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false
     */
    public function time()
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->time(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool
     */
    public function bgrewriteaof()
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->bgrewriteaof(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function lastsave()
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->lastsave(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function lcs($key1, $key2, $options = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->lcs(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool
     */
    public function bgsave($schedule = \false)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->bgsave(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool
     */
    public function save()
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->save(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false
     */
    public function role()
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->role(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function ttl($key)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->ttl(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function pttl($key)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->pttl(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool|int
     */
    public function exists(...$keys)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->exists(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function eval($script, $args = [], $num_keys = 0)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->eval(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function eval_ro($script, $args = [], $num_keys = 0)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->eval_ro(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function evalsha($sha, $args = [], $num_keys = 0)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->evalsha(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function evalsha_ro($sha, $args = [], $num_keys = 0)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->evalsha_ro(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function client($operation, ...$args)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->client(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function geoadd($key, $lng, $lat, $member, ...$other_triples_and_options)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->geoadd(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false
     */
    public function geohash($key, $member, ...$other_members)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->geohash(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function georadius($key, $lng, $lat, $radius, $unit, $options = [])
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->georadius(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function georadiusbymember($key, $member, $radius, $unit, $options = [])
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->georadiusbymember(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function georadiusbymember_ro($key, $member, $radius, $unit, $options = [])
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->georadiusbymember_ro(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function georadius_ro($key, $lng, $lat, $radius, $unit, $options = [])
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->georadius_ro(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function geosearchstore($dst, $src, $position, $shape, $unit, $options = [])
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->geosearchstore(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function get($key)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->get(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function getset($key, $value)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->getset(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function setrange($key, $start, $value)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->setrange(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function getbit($key, $pos)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->getbit(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function bitcount($key, $start = 0, $end = -1, $by_bit = \false)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->bitcount(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false
     */
    public function bitfield($key, ...$args)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->bitfield(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|bool
     */
    public function config($operation, $key = null, $value = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->config(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false|int
     */
    public function command(...$args)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->command(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function bitop($operation, $dstkey, $srckey, ...$other_keys)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->bitop(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function bitpos($key, $bit, $start = null, $end = null, $bybit = \false)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->bitpos(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function setbit($key, $pos, $val)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->setbit(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function acl($cmd, ...$args)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->acl(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function append($key, $value)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->append(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function set($key, $value, $options = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->set(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function getex($key, $options = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->getex(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function getdel($key)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->getdel(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool
     */
    public function setex($key, $seconds, $value)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->setex(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function pfadd($key, $elements)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->pfadd(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool
     */
    public function pfmerge($dst, $srckeys)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->pfmerge(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool
     */
    public function psetex($key, $milliseconds, $value)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->psetex(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function publish($channel, $message)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->publish(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function pubsub($operation, ...$args)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->pubsub(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function spublish($channel, $message)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->spublish(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool
     */
    public function setnx($key, $value)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->setnx(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false
     */
    public function mget($keys)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->mget(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function move($key, $db)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->move(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool
     */
    public function mset($kvals)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->mset(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool
     */
    public function msetnx($kvals)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->msetnx(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool
     */
    public function rename($key, $newkey)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->rename(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool
     */
    public function renamenx($key, $newkey)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->renamenx(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool|int
     */
    public function del(...$keys)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->del(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function unlink(...$keys)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->unlink(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool
     */
    public function expire($key, $seconds, $mode = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->expire(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool
     */
    public function pexpire($key, $milliseconds)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->pexpire(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool
     */
    public function expireat($key, $timestamp)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->expireat(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function expiretime($key)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->expiretime(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool
     */
    public function pexpireat($key, $timestamp_ms)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->pexpireat(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function pexpiretime($key)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->pexpiretime(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool
     */
    public function persist($key)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->persist(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool|int|string
     */
    public function type($key)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->type(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false
     */
    public function lrange($key, $start, $stop)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->lrange(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function lpush($key, $mem, ...$mems)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->lpush(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function rpush($key, $mem, ...$mems)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->rpush(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function lpushx($key, $mem, ...$mems)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->lpushx(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function rpushx($key, $mem, ...$mems)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->rpushx(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool
     */
    public function lset($key, $index, $mem)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->lset(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function lpop($key, $count = 1)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->lpop(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false|int|null
     */
    public function lpos($key, $value, $options = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->lpos(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function rpop($key, $count = 1)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->rpop(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function rpoplpush($source, $dest)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->rpoplpush(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function brpoplpush($source, $dest, $timeout)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->brpoplpush(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false|null
     */
    public function blpop($key, $timeout_or_key, ...$extra_args)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->blpop(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false|null
     */
    public function blmpop($timeout, $keys, $from, $count = 1)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->blmpop(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false|null
     */
    public function bzmpop($timeout, $keys, $from, $count = 1)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->bzmpop(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false|null
     */
    public function lmpop($keys, $from, $count = 1)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->lmpop(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false|null
     */
    public function zmpop($keys, $from, $count = 1)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zmpop(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false|null
     */
    public function brpop($key, $timeout_or_key, ...$extra_args)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->brpop(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false|null
     */
    public function bzpopmax($key, $timeout_or_key, ...$extra_args)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->bzpopmax(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false|null
     */
    public function bzpopmin($key, $timeout_or_key, ...$extra_args)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->bzpopmin(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function object($op, $key)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->object(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false
     */
    public function geopos($key, ...$members)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->geopos(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function lrem($key, $mem, $count = 0)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->lrem(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function lindex($key, $index)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->lindex(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function linsert($key, $op, $pivot, $element)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->linsert(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool
     */
    public function ltrim($key, $start, $end)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->ltrim(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function hget($hash, $member)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hget(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function hstrlen($hash, $member)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hstrlen(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false
     */
    public function hgetall($hash)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hgetall(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false
     */
    public function hkeys($hash)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hkeys(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false
     */
    public function hvals($hash)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hvals(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false
     */
    public function hmget($hash, $members)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hmget(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool
     */
    public function hmset($hash, $members)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hmset(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool
     */
    public function hexists($hash, $member)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hexists(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool
     */
    public function hsetnx($hash, $member, $value)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hsetnx(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function hdel($key, $mem, ...$mems)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hdel(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function hincrby($key, $mem, $value)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hincrby(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool|float
     */
    public function hincrbyfloat($key, $mem, $value)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hincrbyfloat(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function incr($key, $by = 1)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->incr(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function decr($key, $by = 1)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->decr(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function incrby($key, $value)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->incrby(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function decrby($key, $value)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->decrby(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|float
     */
    public function incrbyfloat($key, $value)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->incrbyfloat(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false
     */
    public function sdiff($key, ...$other_keys)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->sdiff(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function sdiffstore($key, ...$other_keys)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->sdiffstore(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false
     */
    public function sinter($key, ...$other_keys)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->sinter(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function sintercard($keys, $limit = -1)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->sintercard(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function sinterstore($key, ...$other_keys)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->sinterstore(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false
     */
    public function sunion($key, ...$other_keys)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->sunion(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function sunionstore($key, ...$other_keys)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->sunionstore(...\func_get_args());
    }
    public function subscribe($channels, $callback) : bool
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->subscribe(...\func_get_args());
    }
    public function unsubscribe($channels = []) : bool
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->unsubscribe(...\func_get_args());
    }
    public function psubscribe($patterns, $callback) : bool
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->psubscribe(...\func_get_args());
    }
    public function punsubscribe($patterns = []) : bool
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->punsubscribe(...\func_get_args());
    }
    public function ssubscribe($channels, $callback) : bool
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->ssubscribe(...\func_get_args());
    }
    public function sunsubscribe($channels = []) : bool
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->sunsubscribe(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function touch($key_or_array, ...$more_keys)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->touch(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool
     */
    public function pipeline()
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->pipeline(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool
     */
    public function multi($mode = 0)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->multi(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|bool
     */
    public function exec()
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->exec(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function wait($replicas, $timeout)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->wait(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool
     */
    public function watch($key, ...$other_keys)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->watch(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool
     */
    public function unwatch()
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->unwatch(...\func_get_args());
    }
    public function discard() : bool
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->discard(...\func_get_args());
    }
    public function getMode($masked = \false) : int
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->getMode(...\func_get_args());
    }
    public function clearBytes() : void
    {
        ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->clearBytes(...\func_get_args());
    }
    /**
     * @return mixed[]|false
     */
    public function scan(&$iterator, $match = null, $count = 0, $type = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->scan($iterator, ...\array_slice(\func_get_args(), 1));
    }
    /**
     * @return mixed[]|false
     */
    public function hscan($key, &$iterator, $match = null, $count = 0)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hscan($key, $iterator, ...\array_slice(\func_get_args(), 2));
    }
    /**
     * @return mixed[]|false
     */
    public function sscan($key, &$iterator, $match = null, $count = 0)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->sscan($key, $iterator, ...\array_slice(\func_get_args(), 2));
    }
    /**
     * @return mixed[]|false
     */
    public function zscan($key, &$iterator, $match = null, $count = 0)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zscan($key, $iterator, ...\array_slice(\func_get_args(), 2));
    }
    /**
     * @return \Relay\Relay|mixed[]|false
     */
    public function keys($pattern)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->keys(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|bool|int
     */
    public function slowlog($operation, ...$extra_args)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->slowlog(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false
     */
    public function smembers($set)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->smembers(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool
     */
    public function sismember($set, $member)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->sismember(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false
     */
    public function smismember($set, ...$members)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->smismember(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function srem($set, $member, ...$members)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->srem(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function sadd($set, $member, ...$members)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->sadd(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false|int
     */
    public function sort($key, $options = [])
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->sort(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false
     */
    public function sort_ro($key, $options = [])
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->sort_ro(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|bool
     */
    public function smove($srcset, $dstset, $member)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->smove(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function spop($set, $count = 1)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->spop(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function srandmember($set, $count = 1)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->srandmember(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function scard($key)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->scard(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function script($command, ...$args)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->script(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function strlen($key)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->strlen(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function hlen($key)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hlen(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function llen($key)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->llen(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function xack($key, $group, $ids)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->xack(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|bool
     */
    public function xclaim($key, $group, $consumer, $min_idle, $ids, $options)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->xclaim(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|bool
     */
    public function xautoclaim($key, $group, $consumer, $min_idle, $start, $count = -1, $justid = \false)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->xautoclaim(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function xlen($key)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->xlen(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function xgroup($operation, $key = null, $group = null, $id_or_consumer = null, $mkstream = \false, $entries_read = -2)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->xgroup(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function xdel($key, $ids)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->xdel(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function xinfo($operation, $arg1 = null, $arg2 = null, $count = -1)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->xinfo(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false
     */
    public function xpending($key, $group, $start = null, $end = null, $count = -1, $consumer = null, $idle = 0)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->xpending(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false
     */
    public function xrange($key, $start, $end, $count = -1)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->xrange(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|bool
     */
    public function xrevrange($key, $end, $start, $count = -1)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->xrevrange(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|bool|null
     */
    public function xread($streams, $count = -1, $block = -1)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->xread(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|bool|null
     */
    public function xreadgroup($group, $consumer, $streams, $count = 1, $block = 1)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->xreadgroup(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function xtrim($key, $threshold, $approx = \false, $minid = \false, $limit = -1)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->xtrim(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function zadd($key, ...$args)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zadd(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function zrandmember($key, $options = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zrandmember(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false
     */
    public function zrange($key, $start, $end, $options = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zrange(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false
     */
    public function zrevrange($key, $start, $end, $options = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zrevrange(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false
     */
    public function zrangebyscore($key, $start, $end, $options = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zrangebyscore(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false
     */
    public function zrevrangebyscore($key, $start, $end, $options = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zrevrangebyscore(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function zrangestore($dst, $src, $start, $end, $options = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zrangestore(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false
     */
    public function zrangebylex($key, $min, $max, $offset = -1, $count = -1)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zrangebylex(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false
     */
    public function zrevrangebylex($key, $max, $min, $offset = -1, $count = -1)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zrevrangebylex(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function zrem($key, ...$args)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zrem(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function zremrangebylex($key, $min, $max)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zremrangebylex(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function zremrangebyrank($key, $start, $end)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zremrangebyrank(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function zremrangebyscore($key, $min, $max)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zremrangebyscore(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function zcard($key)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zcard(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function zcount($key, $min, $max)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zcount(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false
     */
    public function zdiff($keys, $options = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zdiff(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function zdiffstore($dst, $keys)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zdiffstore(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|float
     */
    public function zincrby($key, $score, $mem)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zincrby(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function zlexcount($key, $min, $max)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zlexcount(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false
     */
    public function zmscore($key, ...$mems)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zmscore(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false
     */
    public function zinter($keys, $weights = null, $options = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zinter(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function zintercard($keys, $limit = -1)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zintercard(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function zinterstore($dst, $keys, $weights = null, $options = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zinterstore(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false
     */
    public function zunion($keys, $weights = null, $options = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zunion(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|false|int
     */
    public function zunionstore($dst, $keys, $weights = null, $options = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zunionstore(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false
     */
    public function zpopmin($key, $count = 1)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zpopmin(...\func_get_args());
    }
    /**
     * @return \Relay\Relay|mixed[]|false
     */
    public function zpopmax($key, $count = 1)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zpopmax(...\func_get_args());
    }
    public function _getKeys()
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->_getKeys(...\func_get_args());
    }
}
