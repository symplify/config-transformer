<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202111019\Symfony\Component\Cache\Exception;

use ConfigTransformer202111019\Psr\Cache\CacheException as Psr6CacheInterface;
use ConfigTransformer202111019\Psr\SimpleCache\CacheException as SimpleCacheInterface;
if (\interface_exists(\ConfigTransformer202111019\Psr\SimpleCache\CacheException::class)) {
    class LogicException extends \LogicException implements \ConfigTransformer202111019\Psr\Cache\CacheException, \ConfigTransformer202111019\Psr\SimpleCache\CacheException
    {
    }
} else {
    class LogicException extends \LogicException implements \ConfigTransformer202111019\Psr\Cache\CacheException
    {
    }
}
