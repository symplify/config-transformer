<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformerPrefix202507\Symfony\Contracts\Cache;

use ConfigTransformerPrefix202507\Psr\Cache\InvalidArgumentException;
/**
 * Enables namespace-based invalidation by prefixing keys with backend-native namespace separators.
 *
 * Note that calling `withSubNamespace()` MUST NOT mutate the pool, but return a new instance instead.
 *
 * When tags are used, they MUST ignore sub-namespaces.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
interface NamespacedPoolInterface
{
    /**
     * @throws InvalidArgumentException If the namespace contains characters found in ItemInterface's RESERVED_CHARACTERS
     * @return static
     */
    public function withSubNamespace(string $namespace);
}
