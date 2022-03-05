<?php

namespace ConfigTransformer202203054\Psr\Log;

/**
 * Basic Implementation of LoggerAwareInterface.
 */
trait LoggerAwareTrait
{
    /**
     * The logger instance.
     *
     * @var LoggerInterface|null
     */
    protected $logger;
    /**
     * Sets a logger.
     *
     * @param LoggerInterface $logger
     */
    public function setLogger(\ConfigTransformer202203054\Psr\Log\LoggerInterface $logger) : void
    {
        $this->logger = $logger;
    }
}
