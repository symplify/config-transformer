<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer20220612\Symfony\Component\Cache\Exception;

use ConfigTransformer20220612\Psr\Cache\CacheException as Psr6CacheInterface;
use ConfigTransformer20220612\Psr\SimpleCache\CacheException as SimpleCacheInterface;
if (\interface_exists(SimpleCacheInterface::class)) {
    class LogicException extends \LogicException implements Psr6CacheInterface, SimpleCacheInterface
    {
    }
} else {
    class LogicException extends \LogicException implements Psr6CacheInterface
    {
    }
}
