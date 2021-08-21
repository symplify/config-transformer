<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202108211\Symfony\Component\Cache\Exception;

use ConfigTransformer202108211\Psr\Cache\CacheException as Psr6CacheInterface;
use ConfigTransformer202108211\Psr\SimpleCache\CacheException as SimpleCacheInterface;
if (\interface_exists(\ConfigTransformer202108211\Psr\SimpleCache\CacheException::class)) {
    class CacheException extends \Exception implements \ConfigTransformer202108211\Psr\Cache\CacheException, \ConfigTransformer202108211\Psr\SimpleCache\CacheException
    {
    }
} else {
    class CacheException extends \Exception implements \ConfigTransformer202108211\Psr\Cache\CacheException
    {
    }
}
