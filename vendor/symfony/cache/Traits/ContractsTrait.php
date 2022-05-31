<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202205316\Symfony\Component\Cache\Traits;

use ConfigTransformer202205316\Psr\Log\LoggerInterface;
use ConfigTransformer202205316\Symfony\Component\Cache\Adapter\AdapterInterface;
use ConfigTransformer202205316\Symfony\Component\Cache\CacheItem;
use ConfigTransformer202205316\Symfony\Component\Cache\Exception\InvalidArgumentException;
use ConfigTransformer202205316\Symfony\Component\Cache\LockRegistry;
use ConfigTransformer202205316\Symfony\Contracts\Cache\CacheInterface;
use ConfigTransformer202205316\Symfony\Contracts\Cache\CacheTrait;
use ConfigTransformer202205316\Symfony\Contracts\Cache\ItemInterface;
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
     * @var callable
     */
    private $callbackWrapper;
    private array $computing = [];
    /**
     * Wraps the callback passed to ->get() in a callable.
     *
     * @return callable the previous callback wrapper
     */
    public function setCallbackWrapper(?callable $callbackWrapper) : callable
    {
        if (!isset($this->callbackWrapper)) {
            $this->callbackWrapper = \Closure::fromCallable([\ConfigTransformer202205316\Symfony\Component\Cache\LockRegistry::class, 'compute']);
            if (\in_array(\PHP_SAPI, ['cli', 'phpdbg'], \true)) {
                $this->setCallbackWrapper(null);
            }
        }
        if (null !== $callbackWrapper && !$callbackWrapper instanceof \Closure) {
            $callbackWrapper = \Closure::fromCallable($callbackWrapper);
        }
        $previousWrapper = $this->callbackWrapper;
        $this->callbackWrapper = $callbackWrapper ?? static function (callable $callback, \ConfigTransformer202205316\Symfony\Contracts\Cache\ItemInterface $item, bool &$save, \ConfigTransformer202205316\Symfony\Contracts\Cache\CacheInterface $pool, \Closure $setMetadata, ?\ConfigTransformer202205316\Psr\Log\LoggerInterface $logger) {
            return $callback($item, $save);
        };
        return $previousWrapper;
    }
    private function doGet(\ConfigTransformer202205316\Symfony\Component\Cache\Adapter\AdapterInterface $pool, string $key, callable $callback, ?float $beta, array &$metadata = null)
    {
        if (0 > ($beta = $beta ?? 1.0)) {
            throw new \ConfigTransformer202205316\Symfony\Component\Cache\Exception\InvalidArgumentException(\sprintf('Argument "$beta" provided to "%s::get()" must be a positive number, %f given.', static::class, $beta));
        }
        static $setMetadata;
        $setMetadata ?? ($setMetadata = \Closure::bind(static function (\ConfigTransformer202205316\Symfony\Component\Cache\CacheItem $item, float $startTime, ?array &$metadata) {
            if ($item->expiry > ($endTime = \microtime(\true))) {
                $item->newMetadata[\ConfigTransformer202205316\Symfony\Component\Cache\CacheItem::METADATA_EXPIRY] = $metadata[\ConfigTransformer202205316\Symfony\Component\Cache\CacheItem::METADATA_EXPIRY] = $item->expiry;
                $item->newMetadata[\ConfigTransformer202205316\Symfony\Component\Cache\CacheItem::METADATA_CTIME] = $metadata[\ConfigTransformer202205316\Symfony\Component\Cache\CacheItem::METADATA_CTIME] = (int) \ceil(1000 * ($endTime - $startTime));
            } else {
                unset($metadata[\ConfigTransformer202205316\Symfony\Component\Cache\CacheItem::METADATA_EXPIRY], $metadata[\ConfigTransformer202205316\Symfony\Component\Cache\CacheItem::METADATA_CTIME]);
            }
        }, null, \ConfigTransformer202205316\Symfony\Component\Cache\CacheItem::class));
        $this->callbackWrapper ??= \Closure::fromCallable([\ConfigTransformer202205316\Symfony\Component\Cache\LockRegistry::class, 'compute']);
        return $this->contractsGet($pool, $key, function (\ConfigTransformer202205316\Symfony\Component\Cache\CacheItem $item, bool &$save) use($pool, $callback, $setMetadata, &$metadata, $key) {
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
                $value = ($this->callbackWrapper)($callback, $item, $save, $pool, function (\ConfigTransformer202205316\Symfony\Component\Cache\CacheItem $item) use($setMetadata, $startTime, &$metadata) {
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
