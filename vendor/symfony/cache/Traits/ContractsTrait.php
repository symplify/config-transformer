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

use ConfigTransformerPrefix202501\Psr\Log\LoggerInterface;
use ConfigTransformerPrefix202501\Symfony\Component\Cache\Adapter\AdapterInterface;
use ConfigTransformerPrefix202501\Symfony\Component\Cache\CacheItem;
use ConfigTransformerPrefix202501\Symfony\Component\Cache\Exception\InvalidArgumentException;
use ConfigTransformerPrefix202501\Symfony\Component\Cache\LockRegistry;
use ConfigTransformerPrefix202501\Symfony\Contracts\Cache\CacheInterface;
use ConfigTransformerPrefix202501\Symfony\Contracts\Cache\CacheTrait;
use ConfigTransformerPrefix202501\Symfony\Contracts\Cache\ItemInterface;
/**
 * @author Nicolas Grekas <p@tchwork.com>
 *
 * @internal
 */
trait ContractsTrait
{
    use CacheTrait {
        doGet as private contractsGet;
    }
    /**
     * @var \Closure
     */
    private $callbackWrapper;
    /**
     * @var mixed[]
     */
    private $computing = [];
    /**
     * Wraps the callback passed to ->get() in a callable.
     *
     * @return callable the previous callback wrapper
     */
    public function setCallbackWrapper(?callable $callbackWrapper) : callable
    {
        if (!isset($this->callbackWrapper)) {
            $this->callbackWrapper = \Closure::fromCallable([LockRegistry::class, 'compute']);
            if (\in_array(\PHP_SAPI, ['cli', 'phpdbg', 'embed'], \true)) {
                $this->setCallbackWrapper(null);
            }
        }
        if (null !== $callbackWrapper && !$callbackWrapper instanceof \Closure) {
            $callbackWrapper = \Closure::fromCallable($callbackWrapper);
        }
        $previousWrapper = $this->callbackWrapper;
        $this->callbackWrapper = $callbackWrapper ?? static function (callable $callback, ItemInterface $item, bool &$save, CacheInterface $pool, \Closure $setMetadata, ?LoggerInterface $logger) {
            return $callback($item, $save);
        };
        return $previousWrapper;
    }
    /**
     * @return mixed
     */
    private function doGet(AdapterInterface $pool, string $key, callable $callback, ?float $beta, ?array &$metadata = null)
    {
        if (0 > ($beta = $beta ?? 1.0)) {
            throw new InvalidArgumentException(\sprintf('Argument "$beta" provided to "%s::get()" must be a positive number, %f given.', static::class, $beta));
        }
        static $setMetadata;
        $setMetadata = $setMetadata ?? \Closure::bind(static function (CacheItem $item, float $startTime, ?array &$metadata) {
            if ($item->expiry > ($endTime = \microtime(\true))) {
                $item->newMetadata[CacheItem::METADATA_EXPIRY] = $metadata[CacheItem::METADATA_EXPIRY] = $item->expiry;
                $item->newMetadata[CacheItem::METADATA_CTIME] = $metadata[CacheItem::METADATA_CTIME] = (int) \ceil(1000 * ($endTime - $startTime));
            } else {
                unset($metadata[CacheItem::METADATA_EXPIRY], $metadata[CacheItem::METADATA_CTIME], $metadata[CacheItem::METADATA_TAGS]);
            }
        }, null, CacheItem::class);
        $this->callbackWrapper = $this->callbackWrapper ?? \Closure::fromCallable([LockRegistry::class, 'compute']);
        return $this->contractsGet($pool, $key, function (CacheItem $item, bool &$save) use($pool, $callback, $setMetadata, &$metadata, $key) {
            // don't wrap nor save recursive calls
            if (isset($this->computing[$key])) {
                $value = $callback($item, $save);
                $save = \false;
                return $value;
            }
            $this->computing[$key] = $key;
            $startTime = \microtime(\true);
            if (!isset($this->callbackWrapper)) {
                $this->setCallbackWrapper($this->setCallbackWrapper(null));
            }
            try {
                $value = ($this->callbackWrapper)($callback, $item, $save, $pool, function (CacheItem $item) use($setMetadata, $startTime, &$metadata) {
                    $setMetadata($item, $startTime, $metadata);
                }, $this->logger ?? null);
                $setMetadata($item, $startTime, $metadata);
                return $value;
            } finally {
                unset($this->computing[$key]);
            }
        }, $beta, $metadata, $this->logger ?? null);
    }
}
