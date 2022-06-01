<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202206010\Symfony\Component\DependencyInjection\ParameterBag;

use ConfigTransformer202206010\Symfony\Component\DependencyInjection\Container;
/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class ContainerBag extends \ConfigTransformer202206010\Symfony\Component\DependencyInjection\ParameterBag\FrozenParameterBag implements \ConfigTransformer202206010\Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface
{
    private $container;
    public function __construct(\ConfigTransformer202206010\Symfony\Component\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    /**
     * {@inheritdoc}
     */
    public function all() : array
    {
        return $this->container->getParameterBag()->all();
    }
    /**
     * {@inheritdoc}
     * @return mixed[]|bool|string|int|float|\UnitEnum|null
     */
    public function get(string $name)
    {
        return $this->container->getParameter($name);
    }
    /**
     * {@inheritdoc}
     */
    public function has(string $name) : bool
    {
        return $this->container->hasParameter($name);
    }
}
