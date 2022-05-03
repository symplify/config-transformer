<?php

namespace ConfigTransformer202205035\Psr\Log;

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
    public function setLogger(\ConfigTransformer202205035\Psr\Log\LoggerInterface $logger) : void
    {
        $this->logger = $logger;
    }
}
