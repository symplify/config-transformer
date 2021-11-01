<?php

declare (strict_types=1);
namespace ConfigTransformer202111019\Symplify\ConfigTransformer\HttpKernel;

use ConfigTransformer202111019\Psr\Container\ContainerInterface;
use ConfigTransformer202111019\Symfony\Component\DependencyInjection\Container;
use ConfigTransformer202111019\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
use ConfigTransformer202111019\Symplify\ConfigTransformer\Exception\ShouldNotHappenException;
use ConfigTransformer202111019\Symplify\PhpConfigPrinter\DependencyInjection\Extension\PhpConfigPrinterExtension;
use ConfigTransformer202111019\Symplify\SymfonyContainerBuilder\ContainerBuilderFactory;
use ConfigTransformer202111019\Symplify\SymplifyKernel\Contract\LightKernelInterface;
use ConfigTransformer202111019\Symplify\SymplifyKernel\DependencyInjection\Extension\SymplifyKernelExtension;
final class ConfigTransformerKernel implements \ConfigTransformer202111019\Symplify\SymplifyKernel\Contract\LightKernelInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\Container|null
     */
    private $container = null;
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs($configFiles) : \ConfigTransformer202111019\Psr\Container\ContainerInterface
    {
        $containerBuilderFactory = new \ConfigTransformer202111019\Symplify\SymfonyContainerBuilder\ContainerBuilderFactory();
        $extensions = [new \ConfigTransformer202111019\Symplify\SymplifyKernel\DependencyInjection\Extension\SymplifyKernelExtension(), new \ConfigTransformer202111019\Symplify\PhpConfigPrinter\DependencyInjection\Extension\PhpConfigPrinterExtension()];
        $compilerPasses = [new \ConfigTransformer202111019\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass()];
        $configFiles[] = __DIR__ . '/../../config/config.php';
        $containerBuilder = $containerBuilderFactory->create($extensions, $compilerPasses, $configFiles);
        $containerBuilder->compile();
        $this->container = $containerBuilder;
        return $containerBuilder;
    }
    public function getContainer() : \ConfigTransformer202111019\Psr\Container\ContainerInterface
    {
        if (!$this->container instanceof \ConfigTransformer202111019\Symfony\Component\DependencyInjection\Container) {
            throw new \ConfigTransformer202111019\Symplify\ConfigTransformer\Exception\ShouldNotHappenException();
        }
        return $this->container;
    }
}
