<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202301\Symfony\Component\Cache\Traits;

use ConfigTransformer202301\Symfony\Component\VarExporter\LazyObjectInterface;
use ConfigTransformer202301\Symfony\Component\VarExporter\LazyProxyTrait;
use ConfigTransformer202301\Symfony\Contracts\Service\ResetInterface;
// Help opcache.preload discover always-needed symbols
\class_exists(\ConfigTransformer202301\Symfony\Component\VarExporter\Internal\Hydrator::class);
\class_exists(\ConfigTransformer202301\Symfony\Component\VarExporter\Internal\LazyObjectRegistry::class);
\class_exists(\ConfigTransformer202301\Symfony\Component\VarExporter\Internal\LazyObjectState::class);
/**
 * @internal
 */
class RedisCluster6Proxy extends \RedisCluster implements ResetInterface, LazyObjectInterface
{
    use LazyProxyTrait {
        resetLazyObject as reset;
    }
    private const LAZY_OBJECT_PROPERTY_SCOPES = ['lazyObjectReal' => [self::class, 'lazyObjectReal', null], "\x00" . self::class . "\x00lazyObjectReal" => [self::class, 'lazyObjectReal', null]];
    public function __construct($name, $seeds = null, $timeout = 0, $read_timeout = 0, $persistent = \false, #[\SensitiveParameter] $auth = null, $context = null)
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
    /**
     * @return bool|string
     */
    public function _serialize($value)
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
     * @return bool|string
     */
    public function _prefix($key)
    {
        return $this->lazyObjectReal->_prefix(...\func_get_args());
    }
    public function _masters() : array
    {
        return $this->lazyObjectReal->_masters(...\func_get_args());
    }
    public function _redir() : ?string
    {
        return $this->lazyObjectReal->_redir(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function acl($key_or_address, $subcmd, ...$args)
    {
        return $this->lazyObjectReal->acl(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool|int
     */
    public function append($key, $value)
    {
        return $this->lazyObjectReal->append(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool
     */
    public function bgrewriteaof($key_or_address)
    {
        return $this->lazyObjectReal->bgrewriteaof(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool
     */
    public function bgsave($key_or_address)
    {
        return $this->lazyObjectReal->bgsave(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool|int
     */
    public function bitcount($key, $start = 0, $end = -1, $bybit = \false)
    {
        return $this->lazyObjectReal->bitcount(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool|int
     */
    public function bitop($operation, $deskey, $srckey, ...$otherkeys)
    {
        return $this->lazyObjectReal->bitop(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function bitpos($key, $bit, $start = 0, $end = -1, $bybit = \false)
    {
        return $this->lazyObjectReal->bitpos(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|true|null
     */
    public function blpop($key, $timeout_or_key, ...$extra_args)
    {
        return $this->lazyObjectReal->blpop(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|true|null
     */
    public function brpop($key, $timeout_or_key, ...$extra_args)
    {
        return $this->lazyObjectReal->brpop(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function brpoplpush($srckey, $deskey, $timeout)
    {
        return $this->lazyObjectReal->brpoplpush(...\func_get_args());
    }
    /**
     * @return \Redis|true|string
     */
    public function lmove($src, $dst, $wherefrom, $whereto)
    {
        return $this->lazyObjectReal->lmove(...\func_get_args());
    }
    /**
     * @return \Redis|true|string
     */
    public function blmove($src, $dst, $wherefrom, $whereto, $timeout)
    {
        return $this->lazyObjectReal->blmove(...\func_get_args());
    }
    public function bzpopmax($key, $timeout_or_key, ...$extra_args) : array
    {
        return $this->lazyObjectReal->bzpopmax(...\func_get_args());
    }
    public function bzpopmin($key, $timeout_or_key, ...$extra_args) : array
    {
        return $this->lazyObjectReal->bzpopmin(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|true|null
     */
    public function bzmpop($timeout, $keys, $from, $count = 1)
    {
        return $this->lazyObjectReal->bzmpop(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|true|null
     */
    public function zmpop($keys, $from, $count = 1)
    {
        return $this->lazyObjectReal->zmpop(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|true|null
     */
    public function blmpop($timeout, $keys, $from, $count = 1)
    {
        return $this->lazyObjectReal->blmpop(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|true|null
     */
    public function lmpop($keys, $from, $count = 1)
    {
        return $this->lazyObjectReal->lmpop(...\func_get_args());
    }
    public function clearlasterror() : bool
    {
        return $this->lazyObjectReal->clearlasterror(...\func_get_args());
    }
    /**
     * @return mixed[]|bool|string
     */
    public function client($key_or_address, $subcommand, $arg = null)
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
    public function cluster($key_or_address, $command, ...$extra_args)
    {
        return $this->lazyObjectReal->cluster(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function command(...$extra_args)
    {
        return $this->lazyObjectReal->command(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function config($key_or_address, $subcommand, ...$extra_args)
    {
        return $this->lazyObjectReal->config(...\func_get_args());
    }
    /**
     * @return \RedisCluster|int
     */
    public function dbsize($key_or_address)
    {
        return $this->lazyObjectReal->dbsize(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool
     */
    public function copy($src, $dst, $options = null)
    {
        return $this->lazyObjectReal->copy(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function decr($key, $by = 1)
    {
        return $this->lazyObjectReal->decr(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function decrby($key, $value)
    {
        return $this->lazyObjectReal->decrby(...\func_get_args());
    }
    public function decrbyfloat($key, $value) : float
    {
        return $this->lazyObjectReal->decrbyfloat(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function del($key, ...$other_keys)
    {
        return $this->lazyObjectReal->del(...\func_get_args());
    }
    public function discard() : bool
    {
        return $this->lazyObjectReal->discard(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|string
     */
    public function dump($key)
    {
        return $this->lazyObjectReal->dump(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|string
     */
    public function echo($key_or_address, $msg)
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
    public function eval_ro($script, $args = [], $num_keys = 0)
    {
        return $this->lazyObjectReal->eval_ro(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function evalsha($script_sha, $args = [], $num_keys = 0)
    {
        return $this->lazyObjectReal->evalsha(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function evalsha_ro($script_sha, $args = [], $num_keys = 0)
    {
        return $this->lazyObjectReal->evalsha_ro(...\func_get_args());
    }
    /**
     * @return mixed[]|true
     */
    public function exec()
    {
        return $this->lazyObjectReal->exec(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool|int
     */
    public function exists($key, ...$other_keys)
    {
        return $this->lazyObjectReal->exists(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool|int
     */
    public function touch($key, ...$other_keys)
    {
        return $this->lazyObjectReal->touch(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool
     */
    public function expire($key, $timeout, $mode = null)
    {
        return $this->lazyObjectReal->expire(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool
     */
    public function expireat($key, $timestamp, $mode = null)
    {
        return $this->lazyObjectReal->expireat(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function expiretime($key)
    {
        return $this->lazyObjectReal->expiretime(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function pexpiretime($key)
    {
        return $this->lazyObjectReal->pexpiretime(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool
     */
    public function flushall($key_or_address, $async = \false)
    {
        return $this->lazyObjectReal->flushall(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool
     */
    public function flushdb($key_or_address, $async = \false)
    {
        return $this->lazyObjectReal->flushdb(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function geoadd($key, $lng, $lat, $member, ...$other_triples_and_options)
    {
        return $this->lazyObjectReal->geoadd(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|float
     */
    public function geodist($key, $src, $dest, $unit = null)
    {
        return $this->lazyObjectReal->geodist(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|true
     */
    public function geohash($key, $member, ...$other_members)
    {
        return $this->lazyObjectReal->geohash(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|true
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
    /**
     * @return \RedisCluster|mixed[]
     */
    public function geosearch($key, $position, $shape, $unit, $options = [])
    {
        return $this->lazyObjectReal->geosearch(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|true|int
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
     * @return \RedisCluster|true|int
     */
    public function getbit($key, $value)
    {
        return $this->lazyObjectReal->getbit(...\func_get_args());
    }
    public function getlasterror() : ?string
    {
        return $this->lazyObjectReal->getlasterror(...\func_get_args());
    }
    public function getmode() : int
    {
        return $this->lazyObjectReal->getmode(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function getoption($option)
    {
        return $this->lazyObjectReal->getoption(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|string
     */
    public function getrange($key, $start, $end)
    {
        return $this->lazyObjectReal->getrange(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|true|int|string
     */
    public function lcs($key1, $key2, $options = null)
    {
        return $this->lazyObjectReal->lcs(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool|string
     */
    public function getset($key, $value)
    {
        return $this->lazyObjectReal->getset(...\func_get_args());
    }
    /**
     * @return mixed[]|true
     */
    public function gettransferredbytes()
    {
        return $this->lazyObjectReal->gettransferredbytes(...\func_get_args());
    }
    public function cleartransferredbytes() : void
    {
        $this->lazyObjectReal->cleartransferredbytes(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function hdel($key, $member, ...$other_members)
    {
        return $this->lazyObjectReal->hdel(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool
     */
    public function hexists($key, $member)
    {
        return $this->lazyObjectReal->hexists(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function hget($key, $member)
    {
        return $this->lazyObjectReal->hget(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|true
     */
    public function hgetall($key)
    {
        return $this->lazyObjectReal->hgetall(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function hincrby($key, $member, $value)
    {
        return $this->lazyObjectReal->hincrby(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|float
     */
    public function hincrbyfloat($key, $member, $value)
    {
        return $this->lazyObjectReal->hincrbyfloat(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|true
     */
    public function hkeys($key)
    {
        return $this->lazyObjectReal->hkeys(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function hlen($key)
    {
        return $this->lazyObjectReal->hlen(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|true
     */
    public function hmget($key, $keys)
    {
        return $this->lazyObjectReal->hmget(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool
     */
    public function hmset($key, $key_values)
    {
        return $this->lazyObjectReal->hmset(...\func_get_args());
    }
    /**
     * @return mixed[]|bool
     */
    public function hscan($key, &$iterator, $pattern = null, $count = 0)
    {
        return $this->lazyObjectReal->hscan(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|string
     */
    public function hrandfield($key, $options = null)
    {
        return $this->lazyObjectReal->hrandfield(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function hset($key, $member, $value)
    {
        return $this->lazyObjectReal->hset(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool
     */
    public function hsetnx($key, $member, $value)
    {
        return $this->lazyObjectReal->hsetnx(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function hstrlen($key, $field)
    {
        return $this->lazyObjectReal->hstrlen(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|true
     */
    public function hvals($key)
    {
        return $this->lazyObjectReal->hvals(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function incr($key, $by = 1)
    {
        return $this->lazyObjectReal->incr(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function incrby($key, $value)
    {
        return $this->lazyObjectReal->incrby(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|float
     */
    public function incrbyfloat($key, $value)
    {
        return $this->lazyObjectReal->incrbyfloat(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|true
     */
    public function info($key_or_address, ...$sections)
    {
        return $this->lazyObjectReal->info(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|true
     */
    public function keys($pattern)
    {
        return $this->lazyObjectReal->keys(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function lastsave($key_or_address)
    {
        return $this->lazyObjectReal->lastsave(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool|string
     */
    public function lget($key, $index)
    {
        return $this->lazyObjectReal->lget(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function lindex($key, $index)
    {
        return $this->lazyObjectReal->lindex(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function linsert($key, $pos, $pivot, $value)
    {
        return $this->lazyObjectReal->linsert(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool|int
     */
    public function llen($key)
    {
        return $this->lazyObjectReal->llen(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|bool|string
     */
    public function lpop($key, $count = 0)
    {
        return $this->lazyObjectReal->lpop(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|bool|int|null
     */
    public function lpos($key, $value, $options = null)
    {
        return $this->lazyObjectReal->lpos(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool|int
     */
    public function lpush($key, $value, ...$other_values)
    {
        return $this->lazyObjectReal->lpush(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool|int
     */
    public function lpushx($key, $value)
    {
        return $this->lazyObjectReal->lpushx(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|true
     */
    public function lrange($key, $start, $end)
    {
        return $this->lazyObjectReal->lrange(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool|int
     */
    public function lrem($key, $value, $count = 0)
    {
        return $this->lazyObjectReal->lrem(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool
     */
    public function lset($key, $index, $value)
    {
        return $this->lazyObjectReal->lset(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool
     */
    public function ltrim($key, $start, $end)
    {
        return $this->lazyObjectReal->ltrim(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|true
     */
    public function mget($keys)
    {
        return $this->lazyObjectReal->mget(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool
     */
    public function mset($key_values)
    {
        return $this->lazyObjectReal->mset(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|true
     */
    public function msetnx($key_values)
    {
        return $this->lazyObjectReal->msetnx(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool
     */
    public function multi($value = \Redis::MULTI)
    {
        return $this->lazyObjectReal->multi(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int|string
     */
    public function object($subcommand, $key)
    {
        return $this->lazyObjectReal->object(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool
     */
    public function persist($key)
    {
        return $this->lazyObjectReal->persist(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool
     */
    public function pexpire($key, $timeout, $mode = null)
    {
        return $this->lazyObjectReal->pexpire(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool
     */
    public function pexpireat($key, $timestamp, $mode = null)
    {
        return $this->lazyObjectReal->pexpireat(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool
     */
    public function pfadd($key, $elements)
    {
        return $this->lazyObjectReal->pfadd(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function pfcount($key)
    {
        return $this->lazyObjectReal->pfcount(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool
     */
    public function pfmerge($key, $keys)
    {
        return $this->lazyObjectReal->pfmerge(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function ping($key_or_address, $message = null)
    {
        return $this->lazyObjectReal->ping(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool
     */
    public function psetex($key, $timeout, $value)
    {
        return $this->lazyObjectReal->psetex(...\func_get_args());
    }
    public function psubscribe($patterns, $callback) : void
    {
        $this->lazyObjectReal->psubscribe(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function pttl($key)
    {
        return $this->lazyObjectReal->pttl(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool
     */
    public function publish($channel, $message)
    {
        return $this->lazyObjectReal->publish(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function pubsub($key_or_address, ...$values)
    {
        return $this->lazyObjectReal->pubsub(...\func_get_args());
    }
    /**
     * @return mixed[]|bool
     */
    public function punsubscribe($pattern, ...$other_patterns)
    {
        return $this->lazyObjectReal->punsubscribe(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool|string
     */
    public function randomkey($key_or_address)
    {
        return $this->lazyObjectReal->randomkey(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function rawcommand($key_or_address, $command, ...$args)
    {
        return $this->lazyObjectReal->rawcommand(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool
     */
    public function rename($key_src, $key_dst)
    {
        return $this->lazyObjectReal->rename(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool
     */
    public function renamenx($key, $newkey)
    {
        return $this->lazyObjectReal->renamenx(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool
     */
    public function restore($key, $timeout, $value, $options = null)
    {
        return $this->lazyObjectReal->restore(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function role($key_or_address)
    {
        return $this->lazyObjectReal->role(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|bool|string
     */
    public function rpop($key, $count = 0)
    {
        return $this->lazyObjectReal->rpop(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool|string
     */
    public function rpoplpush($src, $dst)
    {
        return $this->lazyObjectReal->rpoplpush(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function rpush($key, ...$elements)
    {
        return $this->lazyObjectReal->rpush(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool|int
     */
    public function rpushx($key, $value)
    {
        return $this->lazyObjectReal->rpushx(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function sadd($key, $value, ...$other_values)
    {
        return $this->lazyObjectReal->sadd(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool|int
     */
    public function saddarray($key, $values)
    {
        return $this->lazyObjectReal->saddarray(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool
     */
    public function save($key_or_address)
    {
        return $this->lazyObjectReal->save(...\func_get_args());
    }
    /**
     * @return mixed[]|bool
     */
    public function scan(&$iterator, $key_or_address, $pattern = null, $count = 0)
    {
        return $this->lazyObjectReal->scan(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function scard($key)
    {
        return $this->lazyObjectReal->scard(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function script($key_or_address, ...$args)
    {
        return $this->lazyObjectReal->script(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|true
     */
    public function sdiff($key, ...$other_keys)
    {
        return $this->lazyObjectReal->sdiff(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function sdiffstore($dst, $key, ...$other_keys)
    {
        return $this->lazyObjectReal->sdiffstore(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool|string
     */
    public function set($key, $value, $options = null)
    {
        return $this->lazyObjectReal->set(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function setbit($key, $offset, $onoff)
    {
        return $this->lazyObjectReal->setbit(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool
     */
    public function setex($key, $expire, $value)
    {
        return $this->lazyObjectReal->setex(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool
     */
    public function setnx($key, $value)
    {
        return $this->lazyObjectReal->setnx(...\func_get_args());
    }
    public function setoption($option, $value) : bool
    {
        return $this->lazyObjectReal->setoption(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function setrange($key, $offset, $value)
    {
        return $this->lazyObjectReal->setrange(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|true
     */
    public function sinter($key, ...$other_keys)
    {
        return $this->lazyObjectReal->sinter(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function sintercard($keys, $limit = -1)
    {
        return $this->lazyObjectReal->sintercard(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function sinterstore($key, ...$other_keys)
    {
        return $this->lazyObjectReal->sinterstore(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool
     */
    public function sismember($key, $value)
    {
        return $this->lazyObjectReal->sismember(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|true
     */
    public function smismember($key, $member, ...$other_members)
    {
        return $this->lazyObjectReal->smismember(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function slowlog($key_or_address, ...$args)
    {
        return $this->lazyObjectReal->slowlog(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|true
     */
    public function smembers($key)
    {
        return $this->lazyObjectReal->smembers(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool
     */
    public function smove($src, $dst, $member)
    {
        return $this->lazyObjectReal->smove(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|bool|int|string
     */
    public function sort($key, $options = null)
    {
        return $this->lazyObjectReal->sort(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|bool|int|string
     */
    public function sort_ro($key, $options = null)
    {
        return $this->lazyObjectReal->sort_ro(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|true|string
     */
    public function spop($key, $count = 0)
    {
        return $this->lazyObjectReal->spop(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|true|string
     */
    public function srandmember($key, $count = 0)
    {
        return $this->lazyObjectReal->srandmember(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
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
    /**
     * @return \RedisCluster|true|int
     */
    public function strlen($key)
    {
        return $this->lazyObjectReal->strlen(...\func_get_args());
    }
    public function subscribe($channels, $cb) : void
    {
        $this->lazyObjectReal->subscribe(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|bool
     */
    public function sunion($key, ...$other_keys)
    {
        return $this->lazyObjectReal->sunion(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function sunionstore($dst, $key, ...$other_keys)
    {
        return $this->lazyObjectReal->sunionstore(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|bool
     */
    public function time($key_or_address)
    {
        return $this->lazyObjectReal->time(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function ttl($key)
    {
        return $this->lazyObjectReal->ttl(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function type($key)
    {
        return $this->lazyObjectReal->type(...\func_get_args());
    }
    /**
     * @return mixed[]|bool
     */
    public function unsubscribe($channels)
    {
        return $this->lazyObjectReal->unsubscribe(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function unlink($key, ...$other_keys)
    {
        return $this->lazyObjectReal->unlink(...\func_get_args());
    }
    public function unwatch() : bool
    {
        return $this->lazyObjectReal->unwatch(...\func_get_args());
    }
    /**
     * @return \RedisCluster|bool
     */
    public function watch($key, ...$other_keys)
    {
        return $this->lazyObjectReal->watch(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function xack($key, $group, $ids)
    {
        return $this->lazyObjectReal->xack(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|string
     */
    public function xadd($key, $id, $values, $maxlen = 0, $approx = \false)
    {
        return $this->lazyObjectReal->xadd(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|true|string
     */
    public function xclaim($key, $group, $consumer, $min_iddle, $ids, $options)
    {
        return $this->lazyObjectReal->xclaim(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
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
     * @return \RedisCluster|mixed[]|bool
     */
    public function xautoclaim($key, $group, $consumer, $min_idle, $start, $count = -1, $justid = \false)
    {
        return $this->lazyObjectReal->xautoclaim(...\func_get_args());
    }
    /**
     * @return mixed
     */
    public function xinfo($operation, $arg1 = null, $arg2 = null, $count = -1)
    {
        return $this->lazyObjectReal->xinfo(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function xlen($key)
    {
        return $this->lazyObjectReal->xlen(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|true
     */
    public function xpending($key, $group, $start = null, $end = null, $count = -1, $consumer = null)
    {
        return $this->lazyObjectReal->xpending(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|bool
     */
    public function xrange($key, $start, $end, $count = -1)
    {
        return $this->lazyObjectReal->xrange(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|bool
     */
    public function xread($streams, $count = -1, $block = -1)
    {
        return $this->lazyObjectReal->xread(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|bool
     */
    public function xreadgroup($group, $consumer, $streams, $count = 1, $block = 1)
    {
        return $this->lazyObjectReal->xreadgroup(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|bool
     */
    public function xrevrange($key, $start, $end, $count = -1)
    {
        return $this->lazyObjectReal->xrevrange(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function xtrim($key, $maxlen, $approx = \false, $minid = \false, $limit = -1)
    {
        return $this->lazyObjectReal->xtrim(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function zadd($key, $score_or_options, ...$more_scores_and_mems)
    {
        return $this->lazyObjectReal->zadd(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function zcard($key)
    {
        return $this->lazyObjectReal->zcard(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function zcount($key, $start, $end)
    {
        return $this->lazyObjectReal->zcount(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|float
     */
    public function zincrby($key, $value, $member)
    {
        return $this->lazyObjectReal->zincrby(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function zinterstore($dst, $keys, $weights = null, $aggregate = null)
    {
        return $this->lazyObjectReal->zinterstore(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function zintercard($keys, $limit = -1)
    {
        return $this->lazyObjectReal->zintercard(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function zlexcount($key, $min, $max)
    {
        return $this->lazyObjectReal->zlexcount(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|bool
     */
    public function zpopmax($key, $value = null)
    {
        return $this->lazyObjectReal->zpopmax(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|bool
     */
    public function zpopmin($key, $value = null)
    {
        return $this->lazyObjectReal->zpopmin(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|bool
     */
    public function zrange($key, $start, $end, $options = null)
    {
        return $this->lazyObjectReal->zrange(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function zrangestore($dstkey, $srckey, $start, $end, $options = null)
    {
        return $this->lazyObjectReal->zrangestore(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|string
     */
    public function zrandmember($key, $options = null)
    {
        return $this->lazyObjectReal->zrandmember(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|true
     */
    public function zrangebylex($key, $min, $max, $offset = -1, $count = -1)
    {
        return $this->lazyObjectReal->zrangebylex(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|true
     */
    public function zrangebyscore($key, $start, $end, $options = [])
    {
        return $this->lazyObjectReal->zrangebyscore(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function zrank($key, $member)
    {
        return $this->lazyObjectReal->zrank(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function zrem($key, $value, ...$other_values)
    {
        return $this->lazyObjectReal->zrem(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function zremrangebylex($key, $min, $max)
    {
        return $this->lazyObjectReal->zremrangebylex(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function zremrangebyrank($key, $min, $max)
    {
        return $this->lazyObjectReal->zremrangebyrank(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function zremrangebyscore($key, $min, $max)
    {
        return $this->lazyObjectReal->zremrangebyscore(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|bool
     */
    public function zrevrange($key, $min, $max, $options = null)
    {
        return $this->lazyObjectReal->zrevrange(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|bool
     */
    public function zrevrangebylex($key, $min, $max, $options = null)
    {
        return $this->lazyObjectReal->zrevrangebylex(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|bool
     */
    public function zrevrangebyscore($key, $min, $max, $options = null)
    {
        return $this->lazyObjectReal->zrevrangebyscore(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function zrevrank($key, $member)
    {
        return $this->lazyObjectReal->zrevrank(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|bool
     */
    public function zscan($key, &$iterator, $pattern = null, $count = 0)
    {
        return $this->lazyObjectReal->zscan(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|float
     */
    public function zscore($key, $member)
    {
        return $this->lazyObjectReal->zscore(...\func_get_args());
    }
    /**
     * @return \Redis|mixed[]|true
     */
    public function zmscore($key, $member, ...$other_members)
    {
        return $this->lazyObjectReal->zmscore(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function zunionstore($dst, $keys, $weights = null, $aggregate = null)
    {
        return $this->lazyObjectReal->zunionstore(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|true
     */
    public function zinter($keys, $weights = null, $options = null)
    {
        return $this->lazyObjectReal->zinter(...\func_get_args());
    }
    /**
     * @return \RedisCluster|true|int
     */
    public function zdiffstore($dst, $keys)
    {
        return $this->lazyObjectReal->zdiffstore(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|true
     */
    public function zunion($keys, $weights = null, $options = null)
    {
        return $this->lazyObjectReal->zunion(...\func_get_args());
    }
    /**
     * @return \RedisCluster|mixed[]|true
     */
    public function zdiff($keys, $options = null)
    {
        return $this->lazyObjectReal->zdiff(...\func_get_args());
    }
}
