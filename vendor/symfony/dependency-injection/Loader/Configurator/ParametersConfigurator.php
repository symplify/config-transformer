<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202112087\Symfony\Component\DependencyInjection\Loader\Configurator;

use ConfigTransformer202112087\Symfony\Component\DependencyInjection\ContainerBuilder;
/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class ParametersConfigurator extends \ConfigTransformer202112087\Symfony\Component\DependencyInjection\Loader\Configurator\AbstractConfigurator
{
    public const FACTORY = 'parameters';
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerBuilder
     */
    private $container;
    public function __construct(\ConfigTransformer202112087\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        $this->container = $container;
    }
    /**
     * @return $this
     * @param mixed $value
     * @param string $name
     */
    public final function set($name, $value)
    {
        $this->container->setParameter($name, static::processValue($value, \true));
        return $this;
    }
    /**
     * @return $this
     * @param mixed $value
     */
    public final function __invoke(string $name, $value)
    {
        return $this->set($name, $value);
    }
}
