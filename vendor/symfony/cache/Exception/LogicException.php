<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer2021061210\Symfony\Component\Cache\Exception;

use ConfigTransformer2021061210\Psr\Cache\CacheException as Psr6CacheInterface;
use ConfigTransformer2021061210\Psr\SimpleCache\CacheException as SimpleCacheInterface;
if (\interface_exists(\ConfigTransformer2021061210\Psr\SimpleCache\CacheException::class)) {
    class LogicException extends \LogicException implements \ConfigTransformer2021061210\Psr\Cache\CacheException, \ConfigTransformer2021061210\Psr\SimpleCache\CacheException
    {
    }
} else {
    class LogicException extends \LogicException implements \ConfigTransformer2021061210\Psr\Cache\CacheException
    {
    }
}
