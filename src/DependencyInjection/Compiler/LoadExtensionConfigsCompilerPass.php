<?php

declare(strict_types=1);

namespace Symplify\ConfigTransformer\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\MergeExtensionConfigurationPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Mimics @see \Symfony\Component\DependencyInjection\MergeExtensionConfigurationPass without dependency on
 * symfony/http-kernel
 */
final class LoadExtensionConfigsCompilerPass extends MergeExtensionConfigurationPass
{
    public function process(ContainerBuilder $containerBuilder): void
    {
        $extensionNames = array_keys($containerBuilder->getExtensions());

        foreach ($extensionNames as $extensionName) {
            $containerBuilder->loadFromExtension($extensionName, []);
        }

        parent::process($containerBuilder);
    }
}
