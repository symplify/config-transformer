<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformerPrefix202605\Symfony\Component\Cache\DependencyInjection;

use ConfigTransformerPrefix202605\Symfony\Component\Cache\PruneableInterface;
use ConfigTransformerPrefix202605\Symfony\Component\DependencyInjection\Argument\IteratorArgument;
use ConfigTransformerPrefix202605\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use ConfigTransformerPrefix202605\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformerPrefix202605\Symfony\Component\DependencyInjection\Reference;
/**
 * @author Rob Frawley 2nd <rmf@src.run>
 */
class CachePoolPrunerPass implements CompilerPassInterface
{
    /**
     * @return void
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('console.command.cache_pool_prune')) {
            return;
        }
        $services = [];
        foreach ($container->findTaggedServiceIds('cache.pool') as $id => $tags) {
            if ($tags[0]['pruneable'] ?? (($nullsafeVariable1 = $container->getReflectionClass($container->getDefinition($id)->getClass(), \false)) ? $nullsafeVariable1->implementsInterface(PruneableInterface::class) : null) ?? \false) {
                $services[$tags[0]['name'] ?? $id] = new Reference($id);
            }
        }
        $container->getDefinition('console.command.cache_pool_prune')->replaceArgument(0, new IteratorArgument($services));
    }
}
