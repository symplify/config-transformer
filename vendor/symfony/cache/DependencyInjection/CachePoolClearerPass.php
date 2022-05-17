<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer2022051710\Symfony\Component\Cache\DependencyInjection;

use ConfigTransformer2022051710\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use ConfigTransformer2022051710\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer2022051710\Symfony\Component\DependencyInjection\Reference;
/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class CachePoolClearerPass implements \ConfigTransformer2022051710\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(\ConfigTransformer2022051710\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        $container->getParameterBag()->remove('cache.prefix.seed');
        foreach ($container->findTaggedServiceIds('cache.pool.clearer') as $id => $attr) {
            $clearer = $container->getDefinition($id);
            $pools = [];
            foreach ($clearer->getArgument(0) as $name => $ref) {
                if ($container->hasDefinition($ref)) {
                    $pools[$name] = new \ConfigTransformer2022051710\Symfony\Component\DependencyInjection\Reference($ref);
                }
            }
            $clearer->replaceArgument(0, $pools);
        }
    }
}
