<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202106110\Symfony\Component\HttpKernel\DependencyInjection;

use ConfigTransformer202106110\Symfony\Component\DependencyInjection\Argument\IteratorArgument;
use ConfigTransformer202106110\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use ConfigTransformer202106110\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202106110\Symfony\Component\DependencyInjection\Reference;
/**
 * Register all services that have the "kernel.locale_aware" tag into the listener.
 *
 * @author Pierre Bobiet <pierrebobiet@gmail.com>
 */
class RegisterLocaleAwareServicesPass implements \ConfigTransformer202106110\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    private $listenerServiceId;
    private $localeAwareTag;
    public function __construct(string $listenerServiceId = 'locale_aware_listener', string $localeAwareTag = 'kernel.locale_aware')
    {
        if (0 < \func_num_args()) {
            trigger_deprecation('symfony/http-kernel', '5.3', 'Configuring "%s" is deprecated.', __CLASS__);
        }
        $this->listenerServiceId = $listenerServiceId;
        $this->localeAwareTag = $localeAwareTag;
    }
    public function process(\ConfigTransformer202106110\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        if (!$container->hasDefinition($this->listenerServiceId)) {
            return;
        }
        $services = [];
        foreach ($container->findTaggedServiceIds($this->localeAwareTag) as $id => $tags) {
            $services[] = new \ConfigTransformer202106110\Symfony\Component\DependencyInjection\Reference($id);
        }
        if (!$services) {
            $container->removeDefinition($this->listenerServiceId);
            return;
        }
        $container->getDefinition($this->listenerServiceId)->setArgument(0, new \ConfigTransformer202106110\Symfony\Component\DependencyInjection\Argument\IteratorArgument($services));
    }
}