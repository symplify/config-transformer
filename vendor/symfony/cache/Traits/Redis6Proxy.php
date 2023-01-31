<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformerPrefix202301\Symfony\Component\Cache\Traits;

use ConfigTransformerPrefix202301\Symfony\Component\VarExporter\LazyObjectInterface;
use ConfigTransformerPrefix202301\Symfony\Component\VarExporter\LazyProxyTrait;
use ConfigTransformerPrefix202301\Symfony\Contracts\Service\ResetInterface;
// Help opcache.preload discover always-needed symbols
\class_exists(\ConfigTransformerPrefix202301\Symfony\Component\VarExporter\Internal\Hydrator::class);
\class_exists(\ConfigTransformerPrefix202301\Symfony\Component\VarExporter\Internal\LazyObjectRegistry::class);
\class_exists(\ConfigTransformerPrefix202301\Symfony\Component\VarExporter\Internal\LazyObjectState::class);
/**
 * @internal
 */
class Redis6Proxy extends \Redis implements ResetInterface, LazyObjectInterface
{
    use LazyProxyTrait {
        resetLazyObject as reset;
    }
    private const LAZY_OBJECT_PROPERTY_SCOPES = ['lazyObjectReal' => [self::class, 'lazyObjectReal', null], "\x00" . self::class . "\x00lazyObjectReal" => [self::class, 'lazyObjectReal', null]];
    public function __construct($options = null)
    {
        return $this->lazyObjectReal->__construct(...\func_get_args());
    }
    public function _compress($value) : string
    {
        return $this->lazyObjectReal->_compress(...\func_get_args());
    }
    public function _uncompress($value) : string
    {
        return $this->lazyObjectReal->_uncompress(...\func_get_args());
    }
    public function _prefix($key) : string
    {
        return $this->lazyObjectReal->_prefix(...\func_get_args());
    }
    public function _serialize($value) : string
    {
        return $this->lazyObjectReal->_serialize(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function _unserialize($value)
    {
        return $this->lazyObjectReal->_unserialize(...\func_get_args());
    }
    public function _pack($value) : string
    {
        return $this->lazyObjectReal->_pack(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function _unpack($value)
    {
        return $this->lazyObjectReal->_unpack(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function acl($subcmd, ...$args)
    {
        return $this->lazyObjectReal->acl(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function append($key, $value)
    {
        return $this->lazyObjectReal->append(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function auth($credentials)
    {
        return $this->lazyObjectReal->auth(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function bgSave()
    {
        return $this->lazyObjectReal->bgSave(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function bgrewriteaof()
    {
        return $this->lazyObjectReal->bgrewriteaof(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function bitcount($key, $start = 0, $end = -1, $bybit = \false)
    {
        return $this->lazyObjectReal->bitcount(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function bitop($operation, $deskey, $srckey, ...$other_keys)
    {
        return $this->lazyObjectReal->bitop(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function bitpos($key, $bit, $start = 0, $end = -1, $bybit = \false)
    {
        return $this->lazyObjectReal->bitpos(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true|null
     */
    public function blPop($key_or_keys, $timeout_or_key, ...$extra_args)
    {
        return $this->lazyObjectReal->blPop(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true|null
     */
    public function brPop($key_or_keys, $timeout_or_key, ...$extra_args)
    {
        return $this->lazyObjectReal->brPop(...\func_get_args());
    }
    /**
     * @return \Redis|true|string
     */
    public function brpoplpush($src, $dst, $timeout)
    {
        return $this->lazyObjectReal->brpoplpush(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true
     */
    public function bzPopMax($key, $timeout_or_key, ...$extra_args)
    {
        return $this->lazyObjectReal->bzPopMax(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true
     */
    public function bzPopMin($key, $timeout_or_key, ...$extra_args)
    {
        return $this->lazyObjectReal->bzPopMin(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true|null
     */
    public function bzmpop($timeout, $keys, $from, $count = 1)
    {
        return $this->lazyObjectReal->bzmpop(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true|null
     */
    public function zmpop($keys, $from, $count = 1)
    {
        return $this->lazyObjectReal->zmpop(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true|null
     */
    public function blmpop($timeout, $keys, $from, $count = 1)
    {
        return $this->lazyObjectReal->blmpop(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true|null
     */
    public function lmpop($keys, $from, $count = 1)
    {
        return $this->lazyObjectReal->lmpop(...\func_get_args());
    }
    public function clearLastError() : bool
    {
        return $this->lazyObjectReal->clearLastError(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function client($opt, ...$args)
    {
        return $this->lazyObjectReal->client(...\func_get_args());
    }
    public function close() : bool
    {
        return $this->lazyObjectReal->close(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function command($opt = null, ...$args)
    {
        return $this->lazyObjectReal->command(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function config($operation, $key_or_settings = null, $value = null)
    {
        return $this->lazyObjectReal->config(...\func_get_args());
    }
    public function connect($host, $port = 6379, $timeout = 0.0, $persistent_id = null, $retry_interval = 0, $read_timeout = 0.0, $context = null) : bool
    {
        return $this->lazyObjectReal->connect(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function copy($src, $dst, $options = null)
    {
        return $this->lazyObjectReal->copy(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function dbSize()
    {
        return $this->lazyObjectReal->dbSize(...\func_get_args());
    }
    /**
     * @return \Redis|string
     */
    public function debug($key)
    {
        return $this->lazyObjectReal->debug(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function decr($key, $by = 1)
    {
        return $this->lazyObjectReal->decr(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function decrBy($key, $value)
    {
        return $this->lazyObjectReal->decrBy(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function del($key, ...$other_keys)
    {
        return $this->lazyObjectReal->del(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function delete($key, ...$other_keys)
    {
        return $this->lazyObjectReal->delete(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function discard()
    {
        return $this->lazyObjectReal->discard(...\func_get_args());
    }
    /**
     * @return \Redis|string
     */
    public function dump($key)
    {
        return $this->lazyObjectReal->dump(...\func_get_args());
    }
    /**
     * @return \Redis|true|string
     */
    public function echo($str)
    {
        return $this->lazyObjectReal->echo(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function eval($script, $args = [], $num_keys = 0)
    {
        return $this->lazyObjectReal->eval(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function eval_ro($script_sha, $args = [], $num_keys = 0)
    {
        return $this->lazyObjectReal->eval_ro(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function evalsha($sha1, $args = [], $num_keys = 0)
    {
        return $this->lazyObjectReal->evalsha(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function evalsha_ro($sha1, $args = [], $num_keys = 0)
    {
        return $this->lazyObjectReal->evalsha_ro(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true
     */
    public function exec()
    {
        return $this->lazyObjectReal->exec(...\func_get_args());
    }
    /**
     * @return \Redis|bool|int
     */
    public function exists($key, ...$other_keys)
    {
        return $this->lazyObjectReal->exists(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function expire($key, $timeout, $mode = null)
    {
        return $this->lazyObjectReal->expire(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function expireAt($key, $timestamp, $mode = null)
    {
        return $this->lazyObjectReal->expireAt(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function failover($to = null, $abort = \false, $timeout = 0)
    {
        return $this->lazyObjectReal->failover(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function expiretime($key)
    {
        return $this->lazyObjectReal->expiretime(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function pexpiretime($key)
    {
        return $this->lazyObjectReal->pexpiretime(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function flushAll($sync = null)
    {
        return $this->lazyObjectReal->flushAll(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function flushDB($sync = null)
    {
        return $this->lazyObjectReal->flushDB(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function geoadd($key, $lng, $lat, $member, ...$other_triples_and_options)
    {
        return $this->lazyObjectReal->geoadd(...\func_get_args());
    }
    /**
     * @return \Redis|true|float
     */
    public function geodist($key, $src, $dst, $unit = null)
    {
        return $this->lazyObjectReal->geodist(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true
     */
    public function geohash($key, $member, ...$other_members)
    {
        return $this->lazyObjectReal->geohash(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true
     */
    public function geopos($key, $member, ...$other_members)
    {
        return $this->lazyObjectReal->geopos(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function georadius($key, $lng, $lat, $radius, $unit, $options = [])
    {
        return $this->lazyObjectReal->georadius(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function georadius_ro($key, $lng, $lat, $radius, $unit, $options = [])
    {
        return $this->lazyObjectReal->georadius_ro(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function georadiusbymember($key, $member, $radius, $unit, $options = [])
    {
        return $this->lazyObjectReal->georadiusbymember(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function georadiusbymember_ro($key, $member, $radius, $unit, $options = [])
    {
        return $this->lazyObjectReal->georadiusbymember_ro(...\func_get_args());
    }
    public function geosearch($key, $position, $shape, $unit, $options = []) : array
    {
        return $this->lazyObjectReal->geosearch(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true|int
     */
    public function geosearchstore($dst, $src, $position, $shape, $unit, $options = [])
    {
        return $this->lazyObjectReal->geosearchstore(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function get($key)
    {
        return $this->lazyObjectReal->get(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function getAuth()
    {
        return $this->lazyObjectReal->getAuth(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function getBit($key, $idx)
    {
        return $this->lazyObjectReal->getBit(...\func_get_args());
    }
    /**
     * @return \Redis|bool|string
     */
    public function getEx($key, $options = [])
    {
        return $this->lazyObjectReal->getEx(...\func_get_args());
    }
    public function getDBNum() : int
    {
        return $this->lazyObjectReal->getDBNum(...\func_get_args());
    }
    /**
     * @return \Redis|bool|string
     */
    public function getDel($key)
    {
        return $this->lazyObjectReal->getDel(...\func_get_args());
    }
    public function getHost() : string
    {
        return $this->lazyObjectReal->getHost(...\func_get_args());
    }
    public function getLastError() : ?string
    {
        return $this->lazyObjectReal->getLastError(...\func_get_args());
    }
    public function getMode() : int
    {
        return $this->lazyObjectReal->getMode(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function getOption($option)
    {
        return $this->lazyObjectReal->getOption(...\func_get_args());
    }
    public function getPersistentID() : ?string
    {
        return $this->lazyObjectReal->getPersistentID(...\func_get_args());
    }
    public function getPort() : int
    {
        return $this->lazyObjectReal->getPort(...\func_get_args());
    }
    /**
     * @return \Redis|true|string
     */
    public function getRange($key, $start, $end)
    {
        return $this->lazyObjectReal->getRange(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true|int|string
     */
    public function lcs($key1, $key2, $options = null)
    {
        return $this->lazyObjectReal->lcs(...\func_get_args());
    }
    public function getReadTimeout() : float
    {
        return $this->lazyObjectReal->getReadTimeout(...\func_get_args());
    }
    /**
     * @return \Redis|true|string
     */
    public function getset($key, $value)
    {
        return $this->lazyObjectReal->getset(...\func_get_args());
    }
    /**
     * @return true|float
     */
    public function getTimeout()
    {
        return $this->lazyObjectReal->getTimeout(...\func_get_args());
    }
    public function getTransferredBytes() : array
    {
        return $this->lazyObjectReal->getTransferredBytes(...\func_get_args());
    }
    public function clearTransferredBytes() : void
    {
        $this->lazyObjectReal->clearTransferredBytes(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function hDel($key, $field, ...$other_fields)
    {
        return $this->lazyObjectReal->hDel(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function hExists($key, $field)
    {
        return $this->lazyObjectReal->hExists(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function hGet($key, $member)
    {
        return $this->lazyObjectReal->hGet(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true
     */
    public function hGetAll($key)
    {
        return $this->lazyObjectReal->hGetAll(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function hIncrBy($key, $field, $value)
    {
        return $this->lazyObjectReal->hIncrBy(...\func_get_args());
    }
    /**
     * @return \Redis|true|float
     */
    public function hIncrByFloat($key, $field, $value)
    {
        return $this->lazyObjectReal->hIncrByFloat(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true
     */
    public function hKeys($key)
    {
        return $this->lazyObjectReal->hKeys(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function hLen($key)
    {
        return $this->lazyObjectReal->hLen(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true
     */
    public function hMget($key, $fields)
    {
        return $this->lazyObjectReal->hMget(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function hMset($key, $fieldvals)
    {
        return $this->lazyObjectReal->hMset(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|string
     */
    public function hRandField($key, $options = null)
    {
        return $this->lazyObjectReal->hRandField(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function hSet($key, $member, $value)
    {
        return $this->lazyObjectReal->hSet(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function hSetNx($key, $field, $value)
    {
        return $this->lazyObjectReal->hSetNx(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function hStrLen($key, $field)
    {
        return $this->lazyObjectReal->hStrLen(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true
     */
    public function hVals($key)
    {
        return $this->lazyObjectReal->hVals(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|bool
     */
    public function hscan($key, &$iterator, $pattern = null, $count = 0)
    {
        return $this->lazyObjectReal->hscan(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function incr($key, $by = 1)
    {
        return $this->lazyObjectReal->incr(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function incrBy($key, $value)
    {
        return $this->lazyObjectReal->incrBy(...\func_get_args());
    }
    /**
     * @return \Redis|true|float
     */
    public function incrByFloat($key, $value)
    {
        return $this->lazyObjectReal->incrByFloat(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true
     */
    public function info(...$sections)
    {
        return $this->lazyObjectReal->info(...\func_get_args());
    }
    public function isConnected() : bool
    {
        return $this->lazyObjectReal->isConnected(...\func_get_args());
    }
    public function keys($pattern)
    {
        return $this->lazyObjectReal->keys(...\func_get_args());
    }
    public function lInsert($key, $pos, $pivot, $value)
    {
        return $this->lazyObjectReal->lInsert(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function lLen($key)
    {
        return $this->lazyObjectReal->lLen(...\func_get_args());
    }
    /**
     * @return \Redis|true|string
     */
    public function lMove($src, $dst, $wherefrom, $whereto)
    {
        return $this->lazyObjectReal->lMove(...\func_get_args());
    }
    /**
     * @return \Redis|true|string
     */
    public function blmove($src, $dst, $wherefrom, $whereto, $timeout)
    {
        return $this->lazyObjectReal->blmove(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|bool|string
     */
    public function lPop($key, $count = 0)
    {
        return $this->lazyObjectReal->lPop(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|bool|int|null
     */
    public function lPos($key, $value, $options = null)
    {
        return $this->lazyObjectReal->lPos(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function lPush($key, ...$elements)
    {
        return $this->lazyObjectReal->lPush(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function rPush($key, ...$elements)
    {
        return $this->lazyObjectReal->rPush(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function lPushx($key, $value)
    {
        return $this->lazyObjectReal->lPushx(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function rPushx($key, $value)
    {
        return $this->lazyObjectReal->rPushx(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function lSet($key, $index, $value)
    {
        return $this->lazyObjectReal->lSet(...\func_get_args());
    }
    public function lastSave() : int
    {
        return $this->lazyObjectReal->lastSave(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function lindex($key, $index)
    {
        return $this->lazyObjectReal->lindex(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true
     */
    public function lrange($key, $start, $end)
    {
        return $this->lazyObjectReal->lrange(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function lrem($key, $value, $count = 0)
    {
        return $this->lazyObjectReal->lrem(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function ltrim($key, $start, $end)
    {
        return $this->lazyObjectReal->ltrim(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]
     */
    public function mget($keys)
    {
        return $this->lazyObjectReal->mget(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function migrate($host, $port, $key, $dstdb, $timeout, $copy = \false, $replace = \false, $credentials = null)
    {
        return $this->lazyObjectReal->migrate(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function move($key, $index)
    {
        return $this->lazyObjectReal->move(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function mset($key_values)
    {
        return $this->lazyObjectReal->mset(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function msetnx($key_values)
    {
        return $this->lazyObjectReal->msetnx(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function multi($value = \Redis::MULTI)
    {
        return $this->lazyObjectReal->multi(...\func_get_args());
    }
    /**
     * @return \Redis|true|int|string
     */
    public function object($subcommand, $key)
    {
        return $this->lazyObjectReal->object(...\func_get_args());
    }
    public function open($host, $port = 6379, $timeout = 0.0, $persistent_id = null, $retry_interval = 0, $read_timeout = 0.0, $context = null) : bool
    {
        return $this->lazyObjectReal->open(...\func_get_args());
    }
    public function pconnect($host, $port = 6379, $timeout = 0.0, $persistent_id = null, $retry_interval = 0, $read_timeout = 0.0, $context = null) : bool
    {
        return $this->lazyObjectReal->pconnect(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function persist($key)
    {
        return $this->lazyObjectReal->persist(...\func_get_args());
    }
    public function pexpire($key, $timeout, $mode = null) : bool
    {
        return $this->lazyObjectReal->pexpire(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function pexpireAt($key, $timestamp, $mode = null)
    {
        return $this->lazyObjectReal->pexpireAt(...\func_get_args());
    }
    /**
     * @return \Redis|int
     */
    public function pfadd($key, $elements)
    {
        return $this->lazyObjectReal->pfadd(...\func_get_args());
    }
    /**
     * @return \Redis|int
     */
    public function pfcount($key)
    {
        return $this->lazyObjectReal->pfcount(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function pfmerge($dst, $srckeys)
    {
        return $this->lazyObjectReal->pfmerge(...\func_get_args());
    }
    /**
     * @return \Redis|bool|string
     */
    public function ping($message = null)
    {
        return $this->lazyObjectReal->ping(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function pipeline()
    {
        return $this->lazyObjectReal->pipeline(...\func_get_args());
    }
    public function popen($host, $port = 6379, $timeout = 0.0, $persistent_id = null, $retry_interval = 0, $read_timeout = 0.0, $context = null) : bool
    {
        return $this->lazyObjectReal->popen(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function psetex($key, $expire, $value)
    {
        return $this->lazyObjectReal->psetex(...\func_get_args());
    }
    public function psubscribe($patterns, $cb) : bool
    {
        return $this->lazyObjectReal->psubscribe(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function pttl($key)
    {
        return $this->lazyObjectReal->pttl(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function publish($channel, $message)
    {
        return $this->lazyObjectReal->publish(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function pubsub($command, $arg = null)
    {
        return $this->lazyObjectReal->pubsub(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|bool
     */
    public function punsubscribe($patterns)
    {
        return $this->lazyObjectReal->punsubscribe(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|bool|string
     */
    public function rPop($key, $count = 0)
    {
        return $this->lazyObjectReal->rPop(...\func_get_args());
    }
    /**
     * @return \Redis|true|string
     */
    public function randomKey()
    {
        return $this->lazyObjectReal->randomKey(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function rawcommand($command, ...$args)
    {
        return $this->lazyObjectReal->rawcommand(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function rename($old_name, $new_name)
    {
        return $this->lazyObjectReal->rename(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function renameNx($key_src, $key_dst)
    {
        return $this->lazyObjectReal->renameNx(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function restore($key, $ttl, $value, $options = null)
    {
        return $this->lazyObjectReal->restore(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function role()
    {
        return $this->lazyObjectReal->role(...\func_get_args());
    }
    /**
     * @return \Redis|true|string
     */
    public function rpoplpush($srckey, $dstkey)
    {
        return $this->lazyObjectReal->rpoplpush(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function sAdd($key, $value, ...$other_values)
    {
        return $this->lazyObjectReal->sAdd(...\func_get_args());
    }
    public function sAddArray($key, $values) : int
    {
        return $this->lazyObjectReal->sAddArray(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true
     */
    public function sDiff($key, ...$other_keys)
    {
        return $this->lazyObjectReal->sDiff(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function sDiffStore($dst, $key, ...$other_keys)
    {
        return $this->lazyObjectReal->sDiffStore(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true
     */
    public function sInter($key, ...$other_keys)
    {
        return $this->lazyObjectReal->sInter(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function sintercard($keys, $limit = -1)
    {
        return $this->lazyObjectReal->sintercard(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function sInterStore($key, ...$other_keys)
    {
        return $this->lazyObjectReal->sInterStore(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true
     */
    public function sMembers($key)
    {
        return $this->lazyObjectReal->sMembers(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true
     */
    public function sMisMember($key, $member, ...$other_members)
    {
        return $this->lazyObjectReal->sMisMember(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function sMove($src, $dst, $value)
    {
        return $this->lazyObjectReal->sMove(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true|string
     */
    public function sPop($key, $count = 0)
    {
        return $this->lazyObjectReal->sPop(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true|string
     */
    public function sRandMember($key, $count = 0)
    {
        return $this->lazyObjectReal->sRandMember(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true
     */
    public function sUnion($key, ...$other_keys)
    {
        return $this->lazyObjectReal->sUnion(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function sUnionStore($dst, $key, ...$other_keys)
    {
        return $this->lazyObjectReal->sUnionStore(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function save()
    {
        return $this->lazyObjectReal->save(...\func_get_args());
    }
    /**
     * @return mixed[]|true
     */
    public function scan(&$iterator, $pattern = null, $count = 0, $type = null)
    {
        return $this->lazyObjectReal->scan(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function scard($key)
    {
        return $this->lazyObjectReal->scard(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function script($command, ...$args)
    {
        return $this->lazyObjectReal->script(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function select($db)
    {
        return $this->lazyObjectReal->select(...\func_get_args());
    }
    /**
     * @return \Redis|bool|string
     */
    public function set($key, $value, $options = null)
    {
        return $this->lazyObjectReal->set(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function setBit($key, $idx, $value)
    {
        return $this->lazyObjectReal->setBit(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function setRange($key, $index, $value)
    {
        return $this->lazyObjectReal->setRange(...\func_get_args());
    }
    public function setOption($option, $value) : bool
    {
        return $this->lazyObjectReal->setOption(...\func_get_args());
    }
    public function setex($key, $expire, $value)
    {
        return $this->lazyObjectReal->setex(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function setnx($key, $value)
    {
        return $this->lazyObjectReal->setnx(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function sismember($key, $value)
    {
        return $this->lazyObjectReal->sismember(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function slaveof($host = null, $port = 6379)
    {
        return $this->lazyObjectReal->slaveof(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function replicaof($host = null, $port = 6379)
    {
        return $this->lazyObjectReal->replicaof(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function touch($key_or_array, ...$more_keys)
    {
        return $this->lazyObjectReal->touch(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function slowlog($operation, $length = 0)
    {
        return $this->lazyObjectReal->slowlog(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function sort($key, $options = null)
    {
        return $this->lazyObjectReal->sort(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function sort_ro($key, $options = null)
    {
        return $this->lazyObjectReal->sort_ro(...\func_get_args());
    }
    public function sortAsc($key, $pattern = null, $get = null, $offset = -1, $count = -1, $store = null) : array
    {
        return $this->lazyObjectReal->sortAsc(...\func_get_args());
    }
    public function sortAscAlpha($key, $pattern = null, $get = null, $offset = -1, $count = -1, $store = null) : array
    {
        return $this->lazyObjectReal->sortAscAlpha(...\func_get_args());
    }
    public function sortDesc($key, $pattern = null, $get = null, $offset = -1, $count = -1, $store = null) : array
    {
        return $this->lazyObjectReal->sortDesc(...\func_get_args());
    }
    public function sortDescAlpha($key, $pattern = null, $get = null, $offset = -1, $count = -1, $store = null) : array
    {
        return $this->lazyObjectReal->sortDescAlpha(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function srem($key, $value, ...$other_values)
    {
        return $this->lazyObjectReal->srem(...\func_get_args());
    }
    /**
     * @return mixed[]|true
     */
    public function sscan($key, &$iterator, $pattern = null, $count = 0)
    {
        return $this->lazyObjectReal->sscan(...\func_get_args());
    }
    public function ssubscribe($channels, $cb) : bool
    {
        return $this->lazyObjectReal->ssubscribe(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function strlen($key)
    {
        return $this->lazyObjectReal->strlen(...\func_get_args());
    }
    public function subscribe($channels, $cb) : bool
    {
        return $this->lazyObjectReal->subscribe(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|bool
     */
    public function sunsubscribe($channels)
    {
        return $this->lazyObjectReal->sunsubscribe(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function swapdb($src, $dst)
    {
        return $this->lazyObjectReal->swapdb(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]
     */
    public function time()
    {
        return $this->lazyObjectReal->time(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function ttl($key)
    {
        return $this->lazyObjectReal->ttl(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function type($key)
    {
        return $this->lazyObjectReal->type(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function unlink($key, ...$other_keys)
    {
        return $this->lazyObjectReal->unlink(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|bool
     */
    public function unsubscribe($channels)
    {
        return $this->lazyObjectReal->unsubscribe(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function unwatch()
    {
        return $this->lazyObjectReal->unwatch(...\func_get_args());
    }
    /**
     * @return \Redis|bool
     */
    public function watch($key, ...$other_keys)
    {
        return $this->lazyObjectReal->watch(...\func_get_args());
    }
    /**
     * @return true|int
     */
    public function wait($numreplicas, $timeout)
    {
        return $this->lazyObjectReal->wait(...\func_get_args());
    }
    /**
     * @return true|int
     */
    public function xack($key, $group, $ids)
    {
        return $this->lazyObjectReal->xack(...\func_get_args());
    }
    /**
     * @return \Redis|true|string
     */
    public function xadd($key, $id, $values, $maxlen = 0, $approx = \false, $nomkstream = \false)
    {
        return $this->lazyObjectReal->xadd(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|bool
     */
    public function xautoclaim($key, $group, $consumer, $min_idle, $start, $count = -1, $justid = \false)
    {
        return $this->lazyObjectReal->xautoclaim(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|bool
     */
    public function xclaim($key, $group, $consumer, $min_idle, $ids, $options)
    {
        return $this->lazyObjectReal->xclaim(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function xdel($key, $ids)
    {
        return $this->lazyObjectReal->xdel(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function xgroup($operation, $key = null, $group = null, $id_or_consumer = null, $mkstream = \false, $entries_read = -2)
    {
        return $this->lazyObjectReal->xgroup(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function xinfo($operation, $arg1 = null, $arg2 = null, $count = -1)
    {
        return $this->lazyObjectReal->xinfo(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function xlen($key)
    {
        return $this->lazyObjectReal->xlen(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true
     */
    public function xpending($key, $group, $start = null, $end = null, $count = -1, $consumer = null)
    {
        return $this->lazyObjectReal->xpending(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|bool
     */
    public function xrange($key, $start, $end, $count = -1)
    {
        return $this->lazyObjectReal->xrange(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|bool
     */
    public function xread($streams, $count = -1, $block = -1)
    {
        return $this->lazyObjectReal->xread(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|bool
     */
    public function xreadgroup($group, $consumer, $streams, $count = 1, $block = 1)
    {
        return $this->lazyObjectReal->xreadgroup(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|bool
     */
    public function xrevrange($key, $end, $start, $count = -1)
    {
        return $this->lazyObjectReal->xrevrange(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function xtrim($key, $threshold, $approx = \false, $minid = \false, $limit = -1)
    {
        return $this->lazyObjectReal->xtrim(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function zAdd($key, $score_or_options, ...$more_scores_and_mems)
    {
        return $this->lazyObjectReal->zAdd(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function zCard($key)
    {
        return $this->lazyObjectReal->zCard(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function zCount($key, $start, $end)
    {
        return $this->lazyObjectReal->zCount(...\func_get_args());
    }
    /**
     * @return \Redis|true|float
     */
    public function zIncrBy($key, $value, $member)
    {
        return $this->lazyObjectReal->zIncrBy(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function zLexCount($key, $min, $max)
    {
        return $this->lazyObjectReal->zLexCount(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true
     */
    public function zMscore($key, $member, ...$other_members)
    {
        return $this->lazyObjectReal->zMscore(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true
     */
    public function zPopMax($key, $count = null)
    {
        return $this->lazyObjectReal->zPopMax(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true
     */
    public function zPopMin($key, $count = null)
    {
        return $this->lazyObjectReal->zPopMin(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true
     */
    public function zRange($key, $start, $end, $options = null)
    {
        return $this->lazyObjectReal->zRange(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true
     */
    public function zRangeByLex($key, $min, $max, $offset = -1, $count = -1)
    {
        return $this->lazyObjectReal->zRangeByLex(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true
     */
    public function zRangeByScore($key, $start, $end, $options = [])
    {
        return $this->lazyObjectReal->zRangeByScore(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function zrangestore($dstkey, $srckey, $start, $end, $options = null)
    {
        return $this->lazyObjectReal->zrangestore(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|string
     */
    public function zRandMember($key, $options = null)
    {
        return $this->lazyObjectReal->zRandMember(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function zRank($key, $member)
    {
        return $this->lazyObjectReal->zRank(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function zRem($key, $member, ...$other_members)
    {
        return $this->lazyObjectReal->zRem(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function zRemRangeByLex($key, $min, $max)
    {
        return $this->lazyObjectReal->zRemRangeByLex(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function zRemRangeByRank($key, $start, $end)
    {
        return $this->lazyObjectReal->zRemRangeByRank(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function zRemRangeByScore($key, $start, $end)
    {
        return $this->lazyObjectReal->zRemRangeByScore(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true
     */
    public function zRevRange($key, $start, $end, $scores = null)
    {
        return $this->lazyObjectReal->zRevRange(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true
     */
    public function zRevRangeByLex($key, $max, $min, $offset = -1, $count = -1)
    {
        return $this->lazyObjectReal->zRevRangeByLex(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true
     */
    public function zRevRangeByScore($key, $max, $min, $options = [])
    {
        return $this->lazyObjectReal->zRevRangeByScore(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function zRevRank($key, $member)
    {
        return $this->lazyObjectReal->zRevRank(...\func_get_args());
    }
    /**
     * @return \Redis|true|float
     */
    public function zScore($key, $member)
    {
        return $this->lazyObjectReal->zScore(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true
     */
    public function zdiff($keys, $options = null)
    {
        return $this->lazyObjectReal->zdiff(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function zdiffstore($dst, $keys)
    {
        return $this->lazyObjectReal->zdiffstore(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true
     */
    public function zinter($keys, $weights = null, $options = null)
    {
        return $this->lazyObjectReal->zinter(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function zintercard($keys, $limit = -1)
    {
        return $this->lazyObjectReal->zintercard(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function zinterstore($dst, $keys, $weights = null, $aggregate = null)
    {
        return $this->lazyObjectReal->zinterstore(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true
     */
    public function zscan($key, &$iterator, $pattern = null, $count = 0)
    {
        return $this->lazyObjectReal->zscan(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true
     */
    public function zunion($keys, $weights = null, $options = null)
    {
        return $this->lazyObjectReal->zunion(...\func_get_args());
    }
    /**
     * @return \Redis|true|int
     */
    public function zunionstore($dst, $keys, $weights = null, $aggregate = null)
    {
        return $this->lazyObjectReal->zunionstore(...\func_get_args());
    }
}
