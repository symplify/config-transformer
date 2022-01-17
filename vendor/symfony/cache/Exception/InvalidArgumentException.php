<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202201177\Symfony\Component\Cache\Exception;

use ConfigTransformer202201177\Psr\Cache\InvalidArgumentException as Psr6CacheInterface;
use ConfigTransformer202201177\Psr\SimpleCache\InvalidArgumentException as SimpleCacheInterface;
if (\interface_exists(\ConfigTransformer202201177\Psr\SimpleCache\InvalidArgumentException::class)) {
    class InvalidArgumentException extends \InvalidArgumentException implements \ConfigTransformer202201177\Psr\Cache\InvalidArgumentException, \ConfigTransformer202201177\Psr\SimpleCache\InvalidArgumentException
    {
    }
} else {
    class InvalidArgumentException extends \InvalidArgumentException implements \ConfigTransformer202201177\Psr\Cache\InvalidArgumentException
    {
    }
}
