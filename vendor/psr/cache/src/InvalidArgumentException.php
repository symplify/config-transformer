<?php

namespace ConfigTransformer202202218\Psr\Cache;

/**
 * Exception interface for invalid cache arguments.
 *
 * Any time an invalid argument is passed into a method it must throw an
 * exception class which implements Psr\Cache\InvalidArgumentException.
 */
interface InvalidArgumentException extends \ConfigTransformer202202218\Psr\Cache\CacheException
{
}
