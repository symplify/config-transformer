<?php

namespace ConfigTransformer2022051310\Psr\Log;

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
    public function setLogger(\ConfigTransformer2022051310\Psr\Log\LoggerInterface $logger) : void;
}
