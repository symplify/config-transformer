<?php

namespace ConfigTransformer202203177\Psr\Log;

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
    public function setLogger(\ConfigTransformer202203177\Psr\Log\LoggerInterface $logger) : void;
}
