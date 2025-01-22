<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformerPrefix202501\Symfony\Component\Cache\Adapter;

use ConfigTransformerPrefix202501\Psr\Log\LoggerAwareInterface;
use ConfigTransformerPrefix202501\Psr\Log\LoggerInterface;
use ConfigTransformerPrefix202501\Symfony\Component\Cache\CacheItem;
use ConfigTransformerPrefix202501\Symfony\Component\Cache\Exception\InvalidArgumentException;
use ConfigTransformerPrefix202501\Symfony\Component\Cache\ResettableInterface;
use ConfigTransformerPrefix202501\Symfony\Component\Cache\Traits\AbstractAdapterTrait;
use ConfigTransformerPrefix202501\Symfony\Component\Cache\Traits\ContractsTrait;
use ConfigTransformerPrefix202501\Symfony\Contracts\Cache\CacheInterface;
/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
abstract class AbstractAdapter implements AdapterInterface, CacheInterface, LoggerAwareInterface, ResettableInterface
{
    use AbstractAdapterTrait;
    use ContractsTrait;
    /**
     * @internal
     */
    protected const NS_SEPARATOR = ':';
    /**
     * @var bool
     */
    private static $apcuSupported;
    protected function __construct(string $namespace = '', int $defaultLifetime = 0)
    {
        $this->namespace = '' === $namespace ? '' : CacheItem::validateKey($namespace) . static::NS_SEPARATOR;
        $this->defaultLifetime = $defaultLifetime;
        if (null !== $this->maxIdLength && \strlen($namespace) > $this->maxIdLength - 24) {
            throw new InvalidArgumentException(\sprintf('Namespace must be %d chars max, %d given ("%s").', $this->maxIdLength - 24, \strlen($namespace), $namespace));
        }
        self::$createCacheItem = self::$createCacheItem ?? \Closure::bind(static function ($key, $value, $isHit) {
            $item = new CacheItem();
            $item->key = $key;
            $item->value = $value;
            $item->isHit = $isHit;
            $item->unpack();
            return $item;
        }, null, CacheItem::class);
        self::$mergeByLifetime = self::$mergeByLifetime ?? \Closure::bind(static function ($deferred, $namespace, &$expiredIds, $getId, $defaultLifetime) {
            $byLifetime = [];
            $now = \microtime(\true);
            $expiredIds = [];
            foreach ($deferred as $key => $item) {
                $key = (string) $key;
                if (null === $item->expiry) {
                    $ttl = 0 < $defaultLifetime ? $defaultLifetime : 0;
                } elseif (!$item->expiry) {
                    $ttl = 0;
                } elseif (0 >= ($ttl = (int) (0.1 + $item->expiry - $now))) {
                    $expiredIds[] = $getId($key);
                    continue;
                }
                $byLifetime[$ttl][$getId($key)] = $item->pack();
            }
            return $byLifetime;
        }, null, CacheItem::class);
    }
    /**
     * Returns the best possible adapter that your runtime supports.
     *
     * Using ApcuAdapter makes system caches compatible with read-only filesystems.
     */
    public static function createSystemCache(string $namespace, int $defaultLifetime, string $version, string $directory, ?LoggerInterface $logger = null) : AdapterInterface
    {
        $opcache = new PhpFilesAdapter($namespace, $defaultLifetime, $directory, \true);
        if (null !== $logger) {
            $opcache->setLogger($logger);
        }
        if (!(self::$apcuSupported = self::$apcuSupported ?? ApcuAdapter::isSupported())) {
            return $opcache;
        }
        if ('cli' === \PHP_SAPI && !\filter_var(\ini_get('apc.enable_cli'), \FILTER_VALIDATE_BOOL)) {
            return $opcache;
        }
        $apcu = new ApcuAdapter($namespace, \intdiv($defaultLifetime, 5), $version);
        if (null !== $logger) {
            $apcu->setLogger($logger);
        }
        return new ChainAdapter([$apcu, $opcache]);
    }
    /**
     * @return mixed
     */
    public static function createConnection(string $dsn, array $options = [])
    {
        if (\strncmp($dsn, 'redis:', \strlen('redis:')) === 0 || \strncmp($dsn, 'rediss:', \strlen('rediss:')) === 0) {
            return RedisAdapter::createConnection($dsn, $options);
        }
        if (\strncmp($dsn, 'memcached:', \strlen('memcached:')) === 0) {
            return MemcachedAdapter::createConnection($dsn, $options);
        }
        if (\strncmp($dsn, 'couchbase:', \strlen('couchbase:')) === 0) {
            if (CouchbaseBucketAdapter::isSupported()) {
                return CouchbaseBucketAdapter::createConnection($dsn, $options);
            }
            return CouchbaseCollectionAdapter::createConnection($dsn, $options);
        }
        throw new InvalidArgumentException('Unsupported DSN: it does not start with "redis[s]:", "memcached:" nor "couchbase:".');
    }
    public function commit() : bool
    {
        $ok = \true;
        $byLifetime = (self::$mergeByLifetime)($this->deferred, $this->namespace, $expiredIds, \Closure::fromCallable([$this, 'getId']), $this->defaultLifetime);
        $retry = $this->deferred = [];
        if ($expiredIds) {
            try {
                $this->doDelete($expiredIds);
            } catch (\Exception $e) {
                $ok = \false;
                CacheItem::log($this->logger, 'Failed to delete expired items: ' . $e->getMessage(), ['exception' => $e, 'cache-adapter' => \get_debug_type($this)]);
            }
        }
        foreach ($byLifetime as $lifetime => $values) {
            try {
                $e = $this->doSave($values, $lifetime);
            } catch (\Exception $e) {
            }
            if (\true === $e || [] === $e) {
                continue;
            }
            if (\is_array($e) || 1 === \count($values)) {
                foreach (\is_array($e) ? $e : \array_keys($values) as $id) {
                    $ok = \false;
                    $v = $values[$id];
                    $type = \get_debug_type($v);
                    $message = \sprintf('Failed to save key "{key}" of type %s%s', $type, $e instanceof \Exception ? ': ' . $e->getMessage() : '.');
                    CacheItem::log($this->logger, $message, ['key' => \substr($id, \strlen($this->namespace)), 'exception' => $e instanceof \Exception ? $e : null, 'cache-adapter' => \get_debug_type($this)]);
                }
            } else {
                foreach ($values as $id => $v) {
                    $retry[$lifetime][] = $id;
                }
            }
        }
        // When bulk-save failed, retry each item individually
        foreach ($retry as $lifetime => $ids) {
            foreach ($ids as $id) {
                try {
                    $v = $byLifetime[$lifetime][$id];
                    $e = $this->doSave([$id => $v], $lifetime);
                } catch (\Exception $e) {
                }
                if (\true === $e || [] === $e) {
                    continue;
                }
                $ok = \false;
                $type = \get_debug_type($v);
                $message = \sprintf('Failed to save key "{key}" of type %s%s', $type, $e instanceof \Exception ? ': ' . $e->getMessage() : '.');
                CacheItem::log($this->logger, $message, ['key' => \substr($id, \strlen($this->namespace)), 'exception' => $e instanceof \Exception ? $e : null, 'cache-adapter' => \get_debug_type($this)]);
            }
        }
        return $ok;
    }
}
