<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202112088\Symfony\Component\Console\CommandLoader;

use ConfigTransformer202112088\Psr\Container\ContainerInterface;
use ConfigTransformer202112088\Symfony\Component\Console\Command\Command;
use ConfigTransformer202112088\Symfony\Component\Console\Exception\CommandNotFoundException;
/**
 * Loads commands from a PSR-11 container.
 *
 * @author Robin Chalas <robin.chalas@gmail.com>
 */
class ContainerCommandLoader implements \ConfigTransformer202112088\Symfony\Component\Console\CommandLoader\CommandLoaderInterface
{
    /**
     * @var \Psr\Container\ContainerInterface
     */
    private $container;
    /**
     * @var mixed[]
     */
    private $commandMap;
    /**
     * @param array $commandMap An array with command names as keys and service ids as values
     */
    public function __construct(\ConfigTransformer202112088\Psr\Container\ContainerInterface $container, array $commandMap)
    {
        $this->container = $container;
        $this->commandMap = $commandMap;
    }
    /**
     * {@inheritdoc}
     * @param string $name
     */
    public function get($name) : \ConfigTransformer202112088\Symfony\Component\Console\Command\Command
    {
        if (!$this->has($name)) {
            throw new \ConfigTransformer202112088\Symfony\Component\Console\Exception\CommandNotFoundException(\sprintf('Command "%s" does not exist.', $name));
        }
        return $this->container->get($this->commandMap[$name]);
    }
    /**
     * {@inheritdoc}
     * @param string $name
     */
    public function has($name) : bool
    {
        return isset($this->commandMap[$name]) && $this->container->has($this->commandMap[$name]);
    }
    /**
     * {@inheritdoc}
     */
    public function getNames() : array
    {
        return \array_keys($this->commandMap);
    }
}
