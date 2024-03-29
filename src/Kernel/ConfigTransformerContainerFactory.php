<?php

declare(strict_types=1);

namespace Symplify\ConfigTransformer\Kernel;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\DelegatingLoader;
use Symfony\Component\Config\Loader\GlobFileLoader;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symplify\ConfigTransformer\DependencyInjection\Compiler\LoadExtensionConfigsCompilerPass;
use Symplify\ConfigTransformer\DependencyInjection\Loader\ParameterMergingPhpFileLoader;
use Symplify\PhpConfigPrinter\ValueObject\PhpConfigPrinterConfig;

/**
 * @api used in tests and bin
 */
final class ConfigTransformerContainerFactory
{
    public function create(): ContainerInterface
    {
        $containerBuilder = new ContainerBuilder();

        $delegatingLoader = $this->createDelegatingLoader($containerBuilder, getcwd());
        $delegatingLoader->load(__DIR__ . '/../../config/config.php');
        $delegatingLoader->load(PhpConfigPrinterConfig::FILE_PATH);

        $compilerPassConfig = $containerBuilder->getCompilerPassConfig();
        $compilerPassConfig->setMergePass(new LoadExtensionConfigsCompilerPass());

        $containerBuilder->compile();

        return $containerBuilder;
    }

    private function createDelegatingLoader(ContainerBuilder $containerBuilder, string $currentWorkingDirectory): DelegatingLoader
    {
        $fileLocator = new FileLocator([$currentWorkingDirectory]);

        $loaders = [
            new GlobFileLoader($fileLocator),
            new ParameterMergingPhpFileLoader($containerBuilder, $fileLocator),
        ];

        $loaderResolver = new LoaderResolver($loaders);

        return new DelegatingLoader($loaderResolver);
    }
}
