<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer20220608\Symfony\Component\Cache\Exception;

use ConfigTransformer20220608\Psr\Cache\InvalidArgumentException as Psr6CacheInterface;
use ConfigTransformer20220608\Psr\SimpleCache\InvalidArgumentException as SimpleCacheInterface;
if (\interface_exists(SimpleCacheInterface::class)) {
    class InvalidArgumentException extends \InvalidArgumentException implements Psr6CacheInterface, SimpleCacheInterface
    {
    }
} else {
    class InvalidArgumentException extends \InvalidArgumentException implements Psr6CacheInterface
    {
    }
}
