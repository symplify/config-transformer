<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202201302\Symfony\Component\DependencyInjection\LazyProxy\Instantiator;

use ConfigTransformer202201302\Symfony\Component\DependencyInjection\ContainerInterface;
use ConfigTransformer202201302\Symfony\Component\DependencyInjection\Definition;
/**
 * {@inheritdoc}
 *
 * Noop proxy instantiator - produces the real service instead of a proxy instance.
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 */
class RealServiceInstantiator implements \ConfigTransformer202201302\Symfony\Component\DependencyInjection\LazyProxy\Instantiator\InstantiatorInterface
{
    /**
     * {@inheritdoc}
     * @return object
     */
    public function instantiateProxy(\ConfigTransformer202201302\Symfony\Component\DependencyInjection\ContainerInterface $container, \ConfigTransformer202201302\Symfony\Component\DependencyInjection\Definition $definition, string $id, callable $realInstantiator)
    {
        return $realInstantiator();
    }
}
