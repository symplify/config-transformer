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
class Redis6Proxy extends \Redis implements ResetInterface, LazyObjectInterface
{
    use Redis6ProxyTrait;
    use LazyProxyTrait {
        resetLazyObject as reset;
    }
    private const LAZY_OBJECT_PROPERTY_SCOPES = [];
    public function __construct($options = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->__construct(...\func_get_args());
    }
    public function _compress($value) : string
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->_compress(...\func_get_args());
    }
    public function _uncompress($value) : string
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->_uncompress(...\func_get_args());
    }
    public function _prefix($key) : string
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->_prefix(...\func_get_args());
    }
    public function _serialize($value) : string
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
    /**
     * @return mixed
     */
    public function acl($subcmd, ...$args)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->acl(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function append($key, $value)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->append(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function auth($credentials)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->auth(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function bgSave()
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->bgSave(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function bgrewriteaof()
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->bgrewriteaof(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function bitcount($key, $start = 0, $end = -1, $bybit = \false)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->bitcount(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function bitop($operation, $deskey, $srckey, ...$other_keys)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->bitop(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function bitpos($key, $bit, $start = 0, $end = -1, $bybit = \false)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->bitpos(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|false|null
     */
    public function blPop($key_or_keys, $timeout_or_key, ...$extra_args)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->blPop(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|false|null
     */
    public function brPop($key_or_keys, $timeout_or_key, ...$extra_args)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->brPop(...\func_get_args());
    }
    /**
     * @return \Redis|false|string
     */
    public function brpoplpush($src, $dst, $timeout)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->brpoplpush(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|false
     */
    public function bzPopMax($key, $timeout_or_key, ...$extra_args)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->bzPopMax(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|false
     */
    public function bzPopMin($key, $timeout_or_key, ...$extra_args)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->bzPopMin(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|false|null
     */
    public function bzmpop($timeout, $keys, $from, $count = 1)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->bzmpop(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|false|null
     */
    public function zmpop($keys, $from, $count = 1)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zmpop(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|false|null
     */
    public function blmpop($timeout, $keys, $from, $count = 1)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->blmpop(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|false|null
     */
    public function lmpop($keys, $from, $count = 1)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->lmpop(...\func_get_args());
    }
    public function clearLastError() : bool
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->clearLastError(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function client($opt, ...$args)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->client(...\func_get_args());
    }
    public function close() : bool
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->close(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function command($opt = null, ...$args)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->command(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function config($operation, $key_or_settings = null, $value = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->config(...\func_get_args());
    }
    public function connect($host, $port = 6379, $timeout = 0, $persistent_id = null, $retry_interval = 0, $read_timeout = 0, $context = null) : bool
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->connect(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function copy($src, $dst, $options = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->copy(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function dbSize()
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->dbSize(...\func_get_args());
    }
    /**
     * @return \Redis|string
     */
    public function debug($key)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->debug(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function decr($key, $by = 1)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->decr(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function decrBy($key, $value)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->decrBy(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function del($key, ...$other_keys)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->del(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function delete($key, ...$other_keys)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->delete(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function discard()
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->discard(...\func_get_args());
    }
    /**
     * @return \Redis|false|string
     */
    public function echo($str)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->echo(...\func_get_args());
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
    public function eval_ro($script_sha, $args = [], $num_keys = 0)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->eval_ro(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function evalsha($sha1, $args = [], $num_keys = 0)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->evalsha(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function evalsha_ro($sha1, $args = [], $num_keys = 0)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->evalsha_ro(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|false
     */
    public function exec()
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->exec(...\func_get_args());
    }
    /**
     * @return \Redis|bool|int
     */
    public function exists($key, ...$other_keys)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->exists(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function expire($key, $timeout, $mode = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->expire(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function expireAt($key, $timestamp, $mode = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->expireAt(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function failover($to = null, $abort = \false, $timeout = 0)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->failover(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function expiretime($key)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->expiretime(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function pexpiretime($key)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->pexpiretime(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function fcall($fn, $keys = [], $args = [])
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->fcall(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function fcall_ro($fn, $keys = [], $args = [])
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->fcall_ro(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function flushAll($sync = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->flushAll(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function flushDB($sync = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->flushDB(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|bool|string
     */
    public function function($operation, ...$args)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->function(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function geoadd($key, $lng, $lat, $member, ...$other_triples_and_options)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->geoadd(...\func_get_args());
    }
    /**
     * @return \Redis|false|float
     */
    public function geodist($key, $src, $dst, $unit = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->geodist(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|false
     */
    public function geohash($key, $member, ...$other_members)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->geohash(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|false
     */
    public function geopos($key, $member, ...$other_members)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->geopos(...\func_get_args());
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
    public function georadius_ro($key, $lng, $lat, $radius, $unit, $options = [])
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->georadius_ro(...\func_get_args());
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
    public function geosearch($key, $position, $shape, $unit, $options = []) : array
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->geosearch(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|false|int
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
    public function getAuth()
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->getAuth(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function getBit($key, $idx)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->getBit(...\func_get_args());
    }
    /**
     * @return \Redis|bool|string
     */
    public function getEx($key, $options = [])
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->getEx(...\func_get_args());
    }
    public function getDBNum() : int
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->getDBNum(...\func_get_args());
    }
    /**
     * @return \Redis|bool|string
     */
    public function getDel($key)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->getDel(...\func_get_args());
    }
    public function getHost() : string
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->getHost(...\func_get_args());
    }
    public function getLastError() : ?string
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->getLastError(...\func_get_args());
    }
    public function getMode() : int
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->getMode(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function getOption($option)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->getOption(...\func_get_args());
    }
    public function getPersistentID() : ?string
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->getPersistentID(...\func_get_args());
    }
    public function getPort() : int
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->getPort(...\func_get_args());
    }
    /**
     * @return \Redis|false|string
     */
    public function getRange($key, $start, $end)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->getRange(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|false|int|string
     */
    public function lcs($key1, $key2, $options = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->lcs(...\func_get_args());
    }
    public function getReadTimeout() : float
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->getReadTimeout(...\func_get_args());
    }
    /**
     * @return \Redis|false|string
     */
    public function getset($key, $value)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->getset(...\func_get_args());
    }
    /**
     * @return float|false
     */
    public function getTimeout()
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->getTimeout(...\func_get_args());
    }
    public function getTransferredBytes() : array
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->getTransferredBytes(...\func_get_args());
    }
    public function clearTransferredBytes() : void
    {
        ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->clearTransferredBytes(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function hDel($key, $field, ...$other_fields)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hDel(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function hExists($key, $field)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hExists(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function hGet($key, $member)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hGet(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|false
     */
    public function hGetAll($key)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hGetAll(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function hIncrBy($key, $field, $value)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hIncrBy(...\func_get_args());
    }
    /**
     * @return \Redis|false|float
     */
    public function hIncrByFloat($key, $field, $value)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hIncrByFloat(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|false
     */
    public function hKeys($key)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hKeys(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function hLen($key)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hLen(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|false
     */
    public function hMget($key, $fields)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hMget(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function hMset($key, $fieldvals)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hMset(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function hSetNx($key, $field, $value)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hSetNx(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function hStrLen($key, $field)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hStrLen(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|false
     */
    public function hVals($key)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hVals(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|bool
     */
    public function hscan($key, &$iterator, $pattern = null, $count = 0)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->hscan($key, $iterator, ...\array_slice(\func_get_args(), 2));
    }
    /**
     * @return \Redis|false|int
     */
    public function incr($key, $by = 1)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->incr(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function incrBy($key, $value)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->incrBy(...\func_get_args());
    }
    /**
     * @return \Redis|false|float
     */
    public function incrByFloat($key, $value)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->incrByFloat(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|false
     */
    public function info(...$sections)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->info(...\func_get_args());
    }
    public function isConnected() : bool
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->isConnected(...\func_get_args());
    }
    public function keys($pattern)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->keys(...\func_get_args());
    }
    public function lInsert($key, $pos, $pivot, $value)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->lInsert(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function lLen($key)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->lLen(...\func_get_args());
    }
    /**
     * @return \Redis|false|string
     */
    public function lMove($src, $dst, $wherefrom, $whereto)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->lMove(...\func_get_args());
    }
    /**
     * @return \Redis|false|string
     */
    public function blmove($src, $dst, $wherefrom, $whereto, $timeout)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->blmove(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|bool|string
     */
    public function lPop($key, $count = 0)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->lPop(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|bool|int|null
     */
    public function lPos($key, $value, $options = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->lPos(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function lPush($key, ...$elements)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->lPush(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function rPush($key, ...$elements)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->rPush(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function lPushx($key, $value)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->lPushx(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function rPushx($key, $value)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->rPushx(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function lSet($key, $index, $value)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->lSet(...\func_get_args());
    }
    public function lastSave() : int
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->lastSave(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function lindex($key, $index)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->lindex(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|false
     */
    public function lrange($key, $start, $end)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->lrange(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function lrem($key, $value, $count = 0)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->lrem(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function ltrim($key, $start, $end)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->ltrim(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function migrate($host, $port, $key, $dstdb, $timeout, $copy = \false, $replace = \false, $credentials = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->migrate(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function move($key, $index)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->move(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function mset($key_values)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->mset(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function msetnx($key_values)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->msetnx(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function multi($value = \Redis::MULTI)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->multi(...\func_get_args());
    }
    /**
     * @return \Redis|false|int|string
     */
    public function object($subcommand, $key)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->object(...\func_get_args());
    }
    public function open($host, $port = 6379, $timeout = 0, $persistent_id = null, $retry_interval = 0, $read_timeout = 0, $context = null) : bool
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->open(...\func_get_args());
    }
    public function pconnect($host, $port = 6379, $timeout = 0, $persistent_id = null, $retry_interval = 0, $read_timeout = 0, $context = null) : bool
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->pconnect(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function persist($key)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->persist(...\func_get_args());
    }
    public function pexpire($key, $timeout, $mode = null) : bool
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->pexpire(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function pexpireAt($key, $timestamp, $mode = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->pexpireAt(...\func_get_args());
    }
    /**
     * @return \Redis|int
     */
    public function pfadd($key, $elements)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->pfadd(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function pfcount($key_or_keys)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->pfcount(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function pfmerge($dst, $srckeys)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->pfmerge(...\func_get_args());
    }
    /**
     * @return \Redis|bool|string
     */
    public function ping($message = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->ping(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function pipeline()
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->pipeline(...\func_get_args());
    }
    public function popen($host, $port = 6379, $timeout = 0, $persistent_id = null, $retry_interval = 0, $read_timeout = 0, $context = null) : bool
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->popen(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function psetex($key, $expire, $value)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->psetex(...\func_get_args());
    }
    public function psubscribe($patterns, $cb) : bool
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->psubscribe(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function pttl($key)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->pttl(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function publish($channel, $message)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->publish(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function pubsub($command, $arg = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->pubsub(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|bool
     */
    public function punsubscribe($patterns)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->punsubscribe(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|bool|string
     */
    public function rPop($key, $count = 0)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->rPop(...\func_get_args());
    }
    /**
     * @return \Redis|false|string
     */
    public function randomKey()
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->randomKey(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function rawcommand($command, ...$args)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->rawcommand(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function rename($old_name, $new_name)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->rename(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function renameNx($key_src, $key_dst)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->renameNx(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function restore($key, $ttl, $value, $options = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->restore(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function role()
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->role(...\func_get_args());
    }
    /**
     * @return \Redis|false|string
     */
    public function rpoplpush($srckey, $dstkey)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->rpoplpush(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function sAdd($key, $value, ...$other_values)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->sAdd(...\func_get_args());
    }
    public function sAddArray($key, $values) : int
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->sAddArray(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|false
     */
    public function sDiff($key, ...$other_keys)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->sDiff(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function sDiffStore($dst, $key, ...$other_keys)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->sDiffStore(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|false
     */
    public function sInter($key, ...$other_keys)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->sInter(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function sintercard($keys, $limit = -1)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->sintercard(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function sInterStore($key, ...$other_keys)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->sInterStore(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|false
     */
    public function sMembers($key)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->sMembers(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|false
     */
    public function sMisMember($key, $member, ...$other_members)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->sMisMember(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function sMove($src, $dst, $value)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->sMove(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|false|string
     */
    public function sPop($key, $count = 0)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->sPop(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|false
     */
    public function sUnion($key, ...$other_keys)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->sUnion(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function sUnionStore($dst, $key, ...$other_keys)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->sUnionStore(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function save()
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->save(...\func_get_args());
    }
    /**
     * @return mixed[]|false
     */
    public function scan(&$iterator, $pattern = null, $count = 0, $type = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->scan($iterator, ...\array_slice(\func_get_args(), 1));
    }
    /**
     * @return \Redis|false|int
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
     * @return \Redis|bool
     */
    public function select($db)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->select(...\func_get_args());
    }
    /**
     * @return \Redis|bool|string
     */
    public function set($key, $value, $options = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->set(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function setBit($key, $idx, $value)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->setBit(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function setRange($key, $index, $value)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->setRange(...\func_get_args());
    }
    public function setOption($option, $value) : bool
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->setOption(...\func_get_args());
    }
    public function setex($key, $expire, $value)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->setex(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function setnx($key, $value)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->setnx(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function sismember($key, $value)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->sismember(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function slaveof($host = null, $port = 6379)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->slaveof(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function replicaof($host = null, $port = 6379)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->replicaof(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function touch($key_or_array, ...$more_keys)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->touch(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function slowlog($operation, $length = 0)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->slowlog(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function sort($key, $options = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->sort(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function sort_ro($key, $options = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->sort_ro(...\func_get_args());
    }
    public function sortAsc($key, $pattern = null, $get = null, $offset = -1, $count = -1, $store = null) : array
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->sortAsc(...\func_get_args());
    }
    public function sortAscAlpha($key, $pattern = null, $get = null, $offset = -1, $count = -1, $store = null) : array
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->sortAscAlpha(...\func_get_args());
    }
    public function sortDesc($key, $pattern = null, $get = null, $offset = -1, $count = -1, $store = null) : array
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->sortDesc(...\func_get_args());
    }
    public function sortDescAlpha($key, $pattern = null, $get = null, $offset = -1, $count = -1, $store = null) : array
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->sortDescAlpha(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function srem($key, $value, ...$other_values)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->srem(...\func_get_args());
    }
    /**
     * @return mixed[]|false
     */
    public function sscan($key, &$iterator, $pattern = null, $count = 0)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->sscan($key, $iterator, ...\array_slice(\func_get_args(), 2));
    }
    public function ssubscribe($channels, $cb) : bool
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->ssubscribe(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function strlen($key)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->strlen(...\func_get_args());
    }
    public function subscribe($channels, $cb) : bool
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->subscribe(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|bool
     */
    public function sunsubscribe($channels)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->sunsubscribe(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function swapdb($src, $dst)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->swapdb(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]
     */
    public function time()
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->time(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function ttl($key)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->ttl(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function type($key)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->type(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function unlink($key, ...$other_keys)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->unlink(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|bool
     */
    public function unsubscribe($channels)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->unsubscribe(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function unwatch()
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->unwatch(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function watch($key, ...$other_keys)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->watch(...\func_get_args());
    }
    /**
     * @return int|false
     */
    public function wait($numreplicas, $timeout)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->wait(...\func_get_args());
    }
    /**
     * @return int|false
     */
    public function xack($key, $group, $ids)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->xack(...\func_get_args());
    }
    /**
     * @return \Redis|false|string
     */
    public function xadd($key, $id, $values, $maxlen = 0, $approx = \false, $nomkstream = \false)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->xadd(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|bool
     */
    public function xautoclaim($key, $group, $consumer, $min_idle, $start, $count = -1, $justid = \false)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->xautoclaim(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|bool
     */
    public function xclaim($key, $group, $consumer, $min_idle, $ids, $options)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->xclaim(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function xdel($key, $ids)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->xdel(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function xgroup($operation, $key = null, $group = null, $id_or_consumer = null, $mkstream = \false, $entries_read = -2)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->xgroup(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function xinfo($operation, $arg1 = null, $arg2 = null, $count = -1)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->xinfo(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function xlen($key)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->xlen(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|false
     */
    public function xpending($key, $group, $start = null, $end = null, $count = -1, $consumer = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->xpending(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|bool
     */
    public function xrange($key, $start, $end, $count = -1)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->xrange(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|bool
     */
    public function xread($streams, $count = -1, $block = -1)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->xread(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|bool
     */
    public function xreadgroup($group, $consumer, $streams, $count = 1, $block = 1)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->xreadgroup(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|bool
     */
    public function xrevrange($key, $end, $start, $count = -1)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->xrevrange(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function xtrim($key, $threshold, $approx = \false, $minid = \false, $limit = -1)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->xtrim(...\func_get_args());
    }
    /**
     * @return \Redis|false|float|int
     */
    public function zAdd($key, $score_or_options, ...$more_scores_and_mems)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zAdd(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function zCard($key)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zCard(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function zCount($key, $start, $end)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zCount(...\func_get_args());
    }
    /**
     * @return \Redis|false|float
     */
    public function zIncrBy($key, $value, $member)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zIncrBy(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function zLexCount($key, $min, $max)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zLexCount(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|false
     */
    public function zMscore($key, $member, ...$other_members)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zMscore(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|false
     */
    public function zPopMax($key, $count = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zPopMax(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|false
     */
    public function zPopMin($key, $count = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zPopMin(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|false
     */
    public function zRange($key, $start, $end, $options = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zRange(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|false
     */
    public function zRangeByLex($key, $min, $max, $offset = -1, $count = -1)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zRangeByLex(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|false
     */
    public function zRangeByScore($key, $start, $end, $options = [])
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zRangeByScore(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function zrangestore($dstkey, $srckey, $start, $end, $options = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zrangestore(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|string
     */
    public function zRandMember($key, $options = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zRandMember(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function zRank($key, $member)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zRank(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function zRem($key, $member, ...$other_members)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zRem(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function zRemRangeByLex($key, $min, $max)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zRemRangeByLex(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function zRemRangeByRank($key, $start, $end)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zRemRangeByRank(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function zRemRangeByScore($key, $start, $end)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zRemRangeByScore(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|false
     */
    public function zRevRange($key, $start, $end, $scores = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zRevRange(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|false
     */
    public function zRevRangeByLex($key, $max, $min, $offset = -1, $count = -1)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zRevRangeByLex(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|false
     */
    public function zRevRangeByScore($key, $max, $min, $options = [])
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zRevRangeByScore(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function zRevRank($key, $member)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zRevRank(...\func_get_args());
    }
    /**
     * @return \Redis|false|float
     */
    public function zScore($key, $member)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zScore(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|false
     */
    public function zdiff($keys, $options = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zdiff(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function zdiffstore($dst, $keys)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zdiffstore(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|false
     */
    public function zinter($keys, $weights = null, $options = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zinter(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function zintercard($keys, $limit = -1)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zintercard(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function zinterstore($dst, $keys, $weights = null, $aggregate = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zinterstore(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|false
     */
    public function zscan($key, &$iterator, $pattern = null, $count = 0)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zscan($key, $iterator, ...\array_slice(\func_get_args(), 2));
    }
    /**
     * @return \Redis|mixed[]|false
     */
    public function zunion($keys, $weights = null, $options = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zunion(...\func_get_args());
    }
    /**
     * @return \Redis|false|int
     */
    public function zunionstore($dst, $keys, $weights = null, $aggregate = null)
    {
        return ($this->lazyObjectState->realInstance = $this->lazyObjectState->realInstance ?? ($this->lazyObjectState->initializer)())->zunionstore(...\func_get_args());
    }
}
