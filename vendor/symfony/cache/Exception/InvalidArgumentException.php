<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202107116\Symfony\Component\Cache\Exception;

use ConfigTransformer202107116\Psr\Cache\InvalidArgumentException as Psr6CacheInterface;
use ConfigTransformer202107116\Psr\SimpleCache\InvalidArgumentException as SimpleCacheInterface;
if (\interface_exists(\ConfigTransformer202107116\Psr\SimpleCache\InvalidArgumentException::class)) {
    class InvalidArgumentException extends \InvalidArgumentException implements \ConfigTransformer202107116\Psr\Cache\InvalidArgumentException, \ConfigTransformer202107116\Psr\SimpleCache\InvalidArgumentException
    {
    }
} else {
    class InvalidArgumentException extends \InvalidArgumentException implements \ConfigTransformer202107116\Psr\Cache\InvalidArgumentException
    {
    }
}
