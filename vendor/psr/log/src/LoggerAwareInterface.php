<?php

namespace ConfigTransformer202205150\Psr\Log;

/**
 * Describes a logger-aware instance.
 */
interface LoggerAwareInterface
{
    /**
     * Sets a logger instance on the object.
     *
     * @param LoggerInterface $logger
     *
     * @return void
     */
    public function setLogger(\ConfigTransformer202205150\Psr\Log\LoggerInterface $logger) : void;
}
