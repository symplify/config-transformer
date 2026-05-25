<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformerPrefix202605\Symfony\Component\Cache;

use ConfigTransformerPrefix202605\Psr\Log\LoggerInterface;
use ConfigTransformerPrefix202605\Symfony\Contracts\Cache\CacheInterface;
use ConfigTransformerPrefix202605\Symfony\Contracts\Cache\ItemInterface;
/**
 * LockRegistry is used internally by existing adapters to protect against cache stampede.
 *
 * It does so by wrapping the computation of items in a pool of locks.
 * Foreach each apps, there can be at most 20 concurrent processes that
 * compute items at the same time and only one per cache-key.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
final class LockRegistry
{
    /**
     * @var mixed[]
     */
    private static $openedFiles = [];
    /**
     * @var mixed[]|null
     */
    private static $lockedFiles;
    /**
     * @var \Exception
     */
    private static $signalingException;
    /**
     * @var \Closure
     */
    private static $signalingCallback;
    /**
     * The number of items in this list controls the max number of concurrent processes.
     * @var mixed[]
     */
    private static $files = [__DIR__ . \DIRECTORY_SEPARATOR . 'Adapter' . \DIRECTORY_SEPARATOR . 'AbstractAdapter.php', __DIR__ . \DIRECTORY_SEPARATOR . 'Adapter' . \DIRECTORY_SEPARATOR . 'AbstractTagAwareAdapter.php', __DIR__ . \DIRECTORY_SEPARATOR . 'Adapter' . \DIRECTORY_SEPARATOR . 'AdapterInterface.php', __DIR__ . \DIRECTORY_SEPARATOR . 'Adapter' . \DIRECTORY_SEPARATOR . 'ApcuAdapter.php', __DIR__ . \DIRECTORY_SEPARATOR . 'Adapter' . \DIRECTORY_SEPARATOR . 'ArrayAdapter.php', __DIR__ . \DIRECTORY_SEPARATOR . 'Adapter' . \DIRECTORY_SEPARATOR . 'ChainAdapter.php', __DIR__ . \DIRECTORY_SEPARATOR . 'Adapter' . \DIRECTORY_SEPARATOR . 'CouchbaseBucketAdapter.php', __DIR__ . \DIRECTORY_SEPARATOR . 'Adapter' . \DIRECTORY_SEPARATOR . 'CouchbaseCollectionAdapter.php', __DIR__ . \DIRECTORY_SEPARATOR . 'Adapter' . \DIRECTORY_SEPARATOR . 'DoctrineDbalAdapter.php', __DIR__ . \DIRECTORY_SEPARATOR . 'Adapter' . \DIRECTORY_SEPARATOR . 'FilesystemAdapter.php', __DIR__ . \DIRECTORY_SEPARATOR . 'Adapter' . \DIRECTORY_SEPARATOR . 'FilesystemTagAwareAdapter.php', __DIR__ . \DIRECTORY_SEPARATOR . 'Adapter' . \DIRECTORY_SEPARATOR . 'MemcachedAdapter.php', __DIR__ . \DIRECTORY_SEPARATOR . 'Adapter' . \DIRECTORY_SEPARATOR . 'NullAdapter.php', __DIR__ . \DIRECTORY_SEPARATOR . 'Adapter' . \DIRECTORY_SEPARATOR . 'ParameterNormalizer.php', __DIR__ . \DIRECTORY_SEPARATOR . 'Adapter' . \DIRECTORY_SEPARATOR . 'PdoAdapter.php', __DIR__ . \DIRECTORY_SEPARATOR . 'Adapter' . \DIRECTORY_SEPARATOR . 'PhpArrayAdapter.php', __DIR__ . \DIRECTORY_SEPARATOR . 'Adapter' . \DIRECTORY_SEPARATOR . 'PhpFilesAdapter.php', __DIR__ . \DIRECTORY_SEPARATOR . 'Adapter' . \DIRECTORY_SEPARATOR . 'ProxyAdapter.php', __DIR__ . \DIRECTORY_SEPARATOR . 'Adapter' . \DIRECTORY_SEPARATOR . 'Psr16Adapter.php', __DIR__ . \DIRECTORY_SEPARATOR . 'Adapter' . \DIRECTORY_SEPARATOR . 'RedisAdapter.php', __DIR__ . \DIRECTORY_SEPARATOR . 'Adapter' . \DIRECTORY_SEPARATOR . 'RedisTagAwareAdapter.php', __DIR__ . \DIRECTORY_SEPARATOR . 'Adapter' . \DIRECTORY_SEPARATOR . 'TagAwareAdapter.php', __DIR__ . \DIRECTORY_SEPARATOR . 'Adapter' . \DIRECTORY_SEPARATOR . 'TagAwareAdapterInterface.php', __DIR__ . \DIRECTORY_SEPARATOR . 'Adapter' . \DIRECTORY_SEPARATOR . 'TraceableAdapter.php', __DIR__ . \DIRECTORY_SEPARATOR . 'Adapter' . \DIRECTORY_SEPARATOR . 'TraceableTagAwareAdapter.php'];
    /**
     * Defines a set of existing files that will be used as keys to acquire locks.
     *
     * @param list<string> $files A list of existing files
     *
     * @return list<string> The previously defined set of files
     */
    public static function setFiles(array $files) : array
    {
        $previousFiles = self::$files;
        self::$files = \array_values($files);
        foreach (self::$openedFiles as $file) {
            if ($file) {
                \flock($file, \LOCK_UN);
                \fclose($file);
            }
        }
        self::$openedFiles = self::$lockedFiles = [];
        return $previousFiles;
    }
    /**
     * @return mixed
     */
    public static function compute(callable $callback, ItemInterface $item, bool &$save, CacheInterface $pool, ?\Closure $setMetadata = null, ?LoggerInterface $logger = null, ?float $beta = null)
    {
        if ('\\' === \DIRECTORY_SEPARATOR && null === self::$lockedFiles) {
            // disable locking on Windows by default
            self::$files = self::$lockedFiles = [];
        }
        $key = self::$files ? \abs(\crc32($item->getKey())) % \count(self::$files) : -1;
        if ($key < 0 || self::$lockedFiles || !($lock = self::open($key))) {
            return $callback($item, $save);
        }
        self::$signalingException = self::$signalingException ?? \unserialize("O:9:\"Exception\":1:{s:16:\"\x00Exception\x00trace\";a:0:{}}");
        self::$signalingCallback = self::$signalingCallback ?? static function () {
            throw self::$signalingException;
        };
        while (\true) {
            try {
                // race to get the lock in non-blocking mode
                $locked = \flock($lock, \LOCK_EX | \LOCK_NB, $wouldBlock);
                if ($locked || !$wouldBlock) {
                    ($nullsafeVariable1 = $logger) ? $nullsafeVariable1->info(\sprintf('Lock %s, now computing item "{key}"', $locked ? 'acquired' : 'not supported'), ['key' => $item->getKey()]) : null;
                    self::$lockedFiles[$key] = \true;
                    $value = $callback($item, $save);
                    if ($save) {
                        if ($setMetadata) {
                            $setMetadata($item);
                        }
                        $pool->save($item->set($value));
                        $save = \false;
                    }
                    return $value;
                }
                // if we failed the race, retry locking in blocking mode to wait for the winner
                ($nullsafeVariable2 = $logger) ? $nullsafeVariable2->info('Item "{key}" is locked, waiting for it to be released', ['key' => $item->getKey()]) : null;
                $deadline = \microtime(\true) + 30.0;
                $acquired = \false;
                do {
                    if ($acquired = \flock($lock, \LOCK_SH | \LOCK_NB)) {
                        break;
                    }
                    \usleep(100000);
                } while (\microtime(\true) < $deadline);
                if (!$acquired) {
                    ($nullsafeVariable3 = $logger) ? $nullsafeVariable3->warning('Lock on item "{key}" timed out, evicting slot', ['key' => $item->getKey()]) : null;
                    unset(self::$files[$key]);
                    self::setFiles(self::$files);
                    $lock = null;
                    return self::compute($callback, $item, $save, $pool, $setMetadata, $logger, $beta);
                }
                if (\INF === $beta) {
                    ($nullsafeVariable4 = $logger) ? $nullsafeVariable4->info('Force-recomputing item "{key}"', ['key' => $item->getKey()]) : null;
                    continue;
                }
            } finally {
                if ($lock) {
                    \flock($lock, \LOCK_UN);
                }
                unset(self::$lockedFiles[$key]);
            }
            try {
                $value = $pool->get($item->getKey(), self::$signalingCallback, 0);
                ($nullsafeVariable5 = $logger) ? $nullsafeVariable5->info('Item "{key}" retrieved after lock was released', ['key' => $item->getKey()]) : null;
                $save = \false;
                return $value;
            } catch (\Exception $e) {
                if (self::$signalingException !== $e) {
                    throw $e;
                }
                ($nullsafeVariable6 = $logger) ? $nullsafeVariable6->info('Item "{key}" not found while lock was released, now retrying', ['key' => $item->getKey()]) : null;
            }
        }
        return null;
    }
    /**
     * @return resource|false
     */
    private static function open(int $key)
    {
        if (null !== ($h = self::$openedFiles[$key] ?? null)) {
            return $h;
        }
        \set_error_handler(static function () {
            return null;
        });
        try {
            $h = \fopen(self::$files[$key], 'r+');
        } finally {
            \restore_error_handler();
        }
        return self::$openedFiles[$key] = $h ?: @\fopen(self::$files[$key], 'r');
    }
}
