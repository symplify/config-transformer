<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformerPrefix202301\Symfony\Component\Cache\Exception;

use ConfigTransformerPrefix202301\Psr\Cache\CacheException as Psr6CacheInterface;
use ConfigTransformerPrefix202301\Psr\SimpleCache\CacheException as SimpleCacheInterface;
if (\interface_exists(SimpleCacheInterface::class)) {
    class CacheException extends \Exception implements Psr6CacheInterface, SimpleCacheInterface
    {
    }
} else {
    class CacheException extends \Exception implements Psr6CacheInterface
    {
    }
}
