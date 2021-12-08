<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer2021120810\Symfony\Component\DependencyInjection\Compiler;

use ConfigTransformer2021120810\Symfony\Component\DependencyInjection\Argument\ServiceClosureArgument;
use ConfigTransformer2021120810\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer2021120810\Symfony\Component\DependencyInjection\ContainerInterface;
use ConfigTransformer2021120810\Symfony\Component\DependencyInjection\Definition;
use ConfigTransformer2021120810\Symfony\Component\DependencyInjection\Reference;
/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class RegisterReverseContainerPass implements \ConfigTransformer2021120810\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    /**
     * @var bool
     */
    private $beforeRemoving;
    public function __construct(bool $beforeRemoving)
    {
        $this->beforeRemoving = $beforeRemoving;
    }
    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function process($container)
    {
        if (!$container->hasDefinition('reverse_container')) {
            return;
        }
        $refType = $this->beforeRemoving ? \ConfigTransformer2021120810\Symfony\Component\DependencyInjection\ContainerInterface::IGNORE_ON_UNINITIALIZED_REFERENCE : \ConfigTransformer2021120810\Symfony\Component\DependencyInjection\ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE;
        $services = [];
        foreach ($container->findTaggedServiceIds('container.reversible') as $id => $tags) {
            $services[$id] = new \ConfigTransformer2021120810\Symfony\Component\DependencyInjection\Reference($id, $refType);
        }
        if ($this->beforeRemoving) {
            // prevent inlining of the reverse container
            $services['reverse_container'] = new \ConfigTransformer2021120810\Symfony\Component\DependencyInjection\Reference('reverse_container', $refType);
        }
        $locator = $container->getDefinition('reverse_container')->getArgument(1);
        if ($locator instanceof \ConfigTransformer2021120810\Symfony\Component\DependencyInjection\Reference) {
            $locator = $container->getDefinition((string) $locator);
        }
        if ($locator instanceof \ConfigTransformer2021120810\Symfony\Component\DependencyInjection\Definition) {
            foreach ($services as $id => $ref) {
                $services[$id] = new \ConfigTransformer2021120810\Symfony\Component\DependencyInjection\Argument\ServiceClosureArgument($ref);
            }
            $locator->replaceArgument(0, $services);
        } else {
            $locator->setValues($services);
        }
    }
}
