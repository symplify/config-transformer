<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202108232\Symfony\Component\HttpKernel\DependencyInjection;

use ConfigTransformer202108232\Psr\Log\LoggerInterface;
use ConfigTransformer202108232\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use ConfigTransformer202108232\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202108232\Symfony\Component\HttpKernel\Log\Logger;
/**
 * Registers the default logger if necessary.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class LoggerPass implements \ConfigTransformer202108232\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    /**
     * {@inheritdoc}
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function process($container)
    {
        $container->setAlias(\ConfigTransformer202108232\Psr\Log\LoggerInterface::class, 'logger')->setPublic(\false);
        if ($container->has('logger')) {
            return;
        }
        $container->register('logger', \ConfigTransformer202108232\Symfony\Component\HttpKernel\Log\Logger::class)->setPublic(\false);
    }
}
