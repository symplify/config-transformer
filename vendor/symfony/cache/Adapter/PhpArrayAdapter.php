<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202109116\Symfony\Component\Cache\Adapter;

use ConfigTransformer202109116\Psr\Cache\CacheItemInterface;
use ConfigTransformer202109116\Psr\Cache\CacheItemPoolInterface;
use ConfigTransformer202109116\Symfony\Component\Cache\CacheItem;
use ConfigTransformer202109116\Symfony\Component\Cache\Exception\InvalidArgumentException;
use ConfigTransformer202109116\Symfony\Component\Cache\PruneableInterface;
use ConfigTransformer202109116\Symfony\Component\Cache\ResettableInterface;
use ConfigTransformer202109116\Symfony\Component\Cache\Traits\ContractsTrait;
use ConfigTransformer202109116\Symfony\Component\Cache\Traits\ProxyTrait;
use ConfigTransformer202109116\Symfony\Component\VarExporter\VarExporter;
use ConfigTransformer202109116\Symfony\Contracts\Cache\CacheInterface;
/**
 * Caches items at warm up time using a PHP array that is stored in shared memory by OPCache since PHP 7.0.
 * Warmed up items are read-only and run-time discovered items are cached using a fallback adapter.
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 * @author Nicolas Grekas <p@tchwork.com>
 */
class PhpArrayAdapter implements \ConfigTransformer202109116\Symfony\Component\Cache\Adapter\AdapterInterface, \ConfigTransformer202109116\Symfony\Contracts\Cache\CacheInterface, \ConfigTransformer202109116\Symfony\Component\Cache\PruneableInterface, \ConfigTransformer202109116\Symfony\Component\Cache\ResettableInterface
{
    use ContractsTrait;
    use ProxyTrait;
    private $file;
    private $keys;
    private $values;
    private static $createCacheItem;
    private static $valuesCache = [];
    /**
     * @param string           $file         The PHP file were values are cached
     * @param AdapterInterface $fallbackPool A pool to fallback on when an item is not hit
     */
    public function __construct(string $file, \ConfigTransformer202109116\Symfony\Component\Cache\Adapter\AdapterInterface $fallbackPool)
    {
        $this->file = $file;
        $this->pool = $fallbackPool;
        self::$createCacheItem ?? (self::$createCacheItem = \Closure::bind(static function ($key, $value, $isHit) {
            $item = new \ConfigTransformer202109116\Symfony\Component\Cache\CacheItem();
            $item->key = $key;
            $item->value = $value;
            $item->isHit = $isHit;
            return $item;
        }, null, \ConfigTransformer202109116\Symfony\Component\Cache\CacheItem::class));
    }
    /**
     * This adapter takes advantage of how PHP stores arrays in its latest versions.
     *
     * @param string                 $file         The PHP file were values are cached
     * @param CacheItemPoolInterface $fallbackPool A pool to fallback on when an item is not hit
     *
     * @return CacheItemPoolInterface
     */
    public static function create($file, $fallbackPool)
    {
        if (!$fallbackPool instanceof \ConfigTransformer202109116\Symfony\Component\Cache\Adapter\AdapterInterface) {
            $fallbackPool = new \ConfigTransformer202109116\Symfony\Component\Cache\Adapter\ProxyAdapter($fallbackPool);
        }
        return new static($file, $fallbackPool);
    }
    /**
     * {@inheritdoc}
     * @param string $key
     * @param callable $callback
     * @param float|null $beta
     * @param mixed[]|null $metadata
     */
    public function get($key, $callback, $beta = null, &$metadata = null)
    {
        if (null === $this->values) {
            $this->initialize();
        }
        if (!isset($this->keys[$key])) {
            get_from_pool:
            if ($this->pool instanceof \ConfigTransformer202109116\Symfony\Contracts\Cache\CacheInterface) {
                return $this->pool->get($key, $callback, $beta, $metadata);
            }
            return $this->doGet($this->pool, $key, $callback, $beta, $metadata);
        }
        $value = $this->values[$this->keys[$key]];
        if ('N;' === $value) {
            return null;
        }
        try {
            if ($value instanceof \Closure) {
                return $value();
            }
        } catch (\Throwable $e) {
            unset($this->keys[$key]);
            goto get_from_pool;
        }
        return $value;
    }
    /**
     * {@inheritdoc}
     */
    public function getItem($key)
    {
        if (!\is_string($key)) {
            throw new \ConfigTransformer202109116\Symfony\Component\Cache\Exception\InvalidArgumentException(\sprintf('Cache key must be string, "%s" given.', \get_debug_type($key)));
        }
        if (null === $this->values) {
            $this->initialize();
        }
        if (!isset($this->keys[$key])) {
            return $this->pool->getItem($key);
        }
        $value = $this->values[$this->keys[$key]];
        $isHit = \true;
        if ('N;' === $value) {
            $value = null;
        } elseif ($value instanceof \Closure) {
            try {
                $value = $value();
            } catch (\Throwable $e) {
                $value = null;
                $isHit = \false;
            }
        }
        return (self::$createCacheItem)($key, $value, $isHit);
    }
    /**
     * {@inheritdoc}
     * @param mixed[] $keys
     */
    public function getItems($keys = [])
    {
        foreach ($keys as $key) {
            if (!\is_string($key)) {
                throw new \ConfigTransformer202109116\Symfony\Component\Cache\Exception\InvalidArgumentException(\sprintf('Cache key must be string, "%s" given.', \get_debug_type($key)));
            }
        }
        if (null === $this->values) {
            $this->initialize();
        }
        return $this->generateItems($keys);
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function hasItem($key)
    {
        if (!\is_string($key)) {
            throw new \ConfigTransformer202109116\Symfony\Component\Cache\Exception\InvalidArgumentException(\sprintf('Cache key must be string, "%s" given.', \get_debug_type($key)));
        }
        if (null === $this->values) {
            $this->initialize();
        }
        return isset($this->keys[$key]) || $this->pool->hasItem($key);
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function deleteItem($key)
    {
        if (!\is_string($key)) {
            throw new \ConfigTransformer202109116\Symfony\Component\Cache\Exception\InvalidArgumentException(\sprintf('Cache key must be string, "%s" given.', \get_debug_type($key)));
        }
        if (null === $this->values) {
            $this->initialize();
        }
        return !isset($this->keys[$key]) && $this->pool->deleteItem($key);
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     * @param mixed[] $keys
     */
    public function deleteItems($keys)
    {
        $deleted = \true;
        $fallbackKeys = [];
        foreach ($keys as $key) {
            if (!\is_string($key)) {
                throw new \ConfigTransformer202109116\Symfony\Component\Cache\Exception\InvalidArgumentException(\sprintf('Cache key must be string, "%s" given.', \get_debug_type($key)));
            }
            if (isset($this->keys[$key])) {
                $deleted = \false;
            } else {
                $fallbackKeys[] = $key;
            }
        }
        if (null === $this->values) {
            $this->initialize();
        }
        if ($fallbackKeys) {
            $deleted = $this->pool->deleteItems($fallbackKeys) && $deleted;
        }
        return $deleted;
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     * @param \Psr\Cache\CacheItemInterface $item
     */
    public function save($item)
    {
        if (null === $this->values) {
            $this->initialize();
        }
        return !isset($this->keys[$item->getKey()]) && $this->pool->save($item);
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     * @param \Psr\Cache\CacheItemInterface $item
     */
    public function saveDeferred($item)
    {
        if (null === $this->values) {
            $this->initialize();
        }
        return !isset($this->keys[$item->getKey()]) && $this->pool->saveDeferred($item);
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function commit()
    {
        return $this->pool->commit();
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     * @param string $prefix
     */
    public function clear($prefix = '')
    {
        $this->keys = $this->values = [];
        $cleared = @\unlink($this->file) || !\file_exists($this->file);
        unset(self::$valuesCache[$this->file]);
        if ($this->pool instanceof \ConfigTransformer202109116\Symfony\Component\Cache\Adapter\AdapterInterface) {
            return $this->pool->clear($prefix) && $cleared;
        }
        return $this->pool->clear() && $cleared;
    }
    /**
     * Store an array of cached values.
     *
     * @param array $values The cached values
     *
     * @return string[] A list of classes to preload on PHP 7.4+
     */
    public function warmUp($values)
    {
        if (\file_exists($this->file)) {
            if (!\is_file($this->file)) {
                throw new \ConfigTransformer202109116\Symfony\Component\Cache\Exception\InvalidArgumentException(\sprintf('Cache path exists and is not a file: "%s".', $this->file));
            }
            if (!\is_writable($this->file)) {
                throw new \ConfigTransformer202109116\Symfony\Component\Cache\Exception\InvalidArgumentException(\sprintf('Cache file is not writable: "%s".', $this->file));
            }
        } else {
            $directory = \dirname($this->file);
            if (!\is_dir($directory) && !@\mkdir($directory, 0777, \true)) {
                throw new \ConfigTransformer202109116\Symfony\Component\Cache\Exception\InvalidArgumentException(\sprintf('Cache directory does not exist and cannot be created: "%s".', $directory));
            }
            if (!\is_writable($directory)) {
                throw new \ConfigTransformer202109116\Symfony\Component\Cache\Exception\InvalidArgumentException(\sprintf('Cache directory is not writable: "%s".', $directory));
            }
        }
        $preload = [];
        $dumpedValues = '';
        $dumpedMap = [];
        $dump = <<<'EOF'
<?php

// This file has been auto-generated by the Symfony Cache Component.

return [[


EOF;
        foreach ($values as $key => $value) {
            \ConfigTransformer202109116\Symfony\Component\Cache\CacheItem::validateKey(\is_int($key) ? (string) $key : $key);
            $isStaticValue = \true;
            if (null === $value) {
                $value = "'N;'";
            } elseif (\is_object($value) || \is_array($value)) {
                try {
                    $value = \ConfigTransformer202109116\Symfony\Component\VarExporter\VarExporter::export($value, $isStaticValue, $preload);
                } catch (\Exception $e) {
                    throw new \ConfigTransformer202109116\Symfony\Component\Cache\Exception\InvalidArgumentException(\sprintf('Cache key "%s" has non-serializable "%s" value.', $key, \get_debug_type($value)), 0, $e);
                }
            } elseif (\is_string($value)) {
                // Wrap "N;" in a closure to not confuse it with an encoded `null`
                if ('N;' === $value) {
                    $isStaticValue = \false;
                }
                $value = \var_export($value, \true);
            } elseif (!\is_scalar($value)) {
                throw new \ConfigTransformer202109116\Symfony\Component\Cache\Exception\InvalidArgumentException(\sprintf('Cache key "%s" has non-serializable "%s" value.', $key, \get_debug_type($value)));
            } else {
                $value = \var_export($value, \true);
            }
            if (!$isStaticValue) {
                $value = \str_replace("\n", "\n    ", $value);
                $value = "static function () {\n    return {$value};\n}";
            }
            $hash = \hash('md5', $value);
            if (null === ($id = $dumpedMap[$hash] ?? null)) {
                $id = $dumpedMap[$hash] = \count($dumpedMap);
                $dumpedValues .= "{$id} => {$value},\n";
            }
            $dump .= \var_export($key, \true) . " => {$id},\n";
        }
        $dump .= "\n], [\n\n{$dumpedValues}\n]];\n";
        $tmpFile = \uniqid($this->file, \true);
        \file_put_contents($tmpFile, $dump);
        @\chmod($tmpFile, 0666 & ~\umask());
        unset($serialized, $value, $dump);
        @\rename($tmpFile, $this->file);
        unset(self::$valuesCache[$this->file]);
        $this->initialize();
        return $preload;
    }
    /**
     * Load the cache file.
     */
    private function initialize()
    {
        if (isset(self::$valuesCache[$this->file])) {
            $values = self::$valuesCache[$this->file];
        } elseif (!\is_file($this->file)) {
            $this->keys = $this->values = [];
            return;
        } else {
            $values = self::$valuesCache[$this->file] = (include $this->file) ?: [[], []];
        }
        if (2 !== \count($values) || !isset($values[0], $values[1])) {
            $this->keys = $this->values = [];
        } else {
            [$this->keys, $this->values] = $values;
        }
    }
    private function generateItems(array $keys) : \Generator
    {
        $f = self::$createCacheItem;
        $fallbackKeys = [];
        foreach ($keys as $key) {
            if (isset($this->keys[$key])) {
                $value = $this->values[$this->keys[$key]];
                if ('N;' === $value) {
                    (yield $key => $f($key, null, \true));
                } elseif ($value instanceof \Closure) {
                    try {
                        (yield $key => $f($key, $value(), \true));
                    } catch (\Throwable $e) {
                        (yield $key => $f($key, null, \false));
                    }
                } else {
                    (yield $key => $f($key, $value, \true));
                }
            } else {
                $fallbackKeys[] = $key;
            }
        }
        if ($fallbackKeys) {
            yield from $this->pool->getItems($fallbackKeys);
        }
    }
}
