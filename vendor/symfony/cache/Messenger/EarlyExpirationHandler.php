<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformerPrefix202507\Symfony\Component\Cache\Messenger;

use ConfigTransformerPrefix202507\Symfony\Component\Cache\CacheItem;
use ConfigTransformerPrefix202507\Symfony\Component\DependencyInjection\ReverseContainer;
use ConfigTransformerPrefix202507\Symfony\Component\Messenger\Attribute\AsMessageHandler;
/**
 * Computes cached values sent to a message bus.
 */
class EarlyExpirationHandler
{
    /**
     * @var \Symfony\Component\DependencyInjection\ReverseContainer
     */
    private $reverseContainer;
    /**
     * @var mixed[]
     */
    private $processedNonces = [];
    public function __construct(ReverseContainer $reverseContainer)
    {
        $this->reverseContainer = $reverseContainer;
    }
    /**
     * @return void
     */
    public function __invoke(EarlyExpirationMessage $message)
    {
        $item = $message->getItem();
        $metadata = $item->getMetadata();
        $expiry = $metadata[CacheItem::METADATA_EXPIRY] ?? 0;
        $ctime = $metadata[CacheItem::METADATA_CTIME] ?? 0;
        if ($expiry && $ctime) {
            // skip duplicate or expired messages
            $processingNonce = [$expiry, $ctime];
            $pool = $message->getPool();
            $key = $item->getKey();
            if (($this->processedNonces[$pool][$key] ?? null) === $processingNonce) {
                return;
            }
            if (\microtime(\true) >= $expiry) {
                return;
            }
            $this->processedNonces[$pool] = [$key => $processingNonce] + ($this->processedNonces[$pool] ?? []);
            if (\count($this->processedNonces[$pool]) > 100) {
                \array_pop($this->processedNonces[$pool]);
            }
        }
        static $setMetadata;
        $setMetadata = $setMetadata ?? \Closure::bind(function (CacheItem $item, float $startTime) {
            if ($item->expiry > ($endTime = \microtime(\true))) {
                $item->newMetadata[CacheItem::METADATA_EXPIRY] = $item->expiry;
                $item->newMetadata[CacheItem::METADATA_CTIME] = (int) \ceil(1000 * ($endTime - $startTime));
            }
        }, null, CacheItem::class);
        $startTime = \microtime(\true);
        $pool = $message->findPool($this->reverseContainer);
        $callback = $message->findCallback($this->reverseContainer);
        $save = \true;
        $value = $callback($item, $save);
        $setMetadata($item, $startTime);
        $pool->save($item->set($value));
    }
}
