<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202301\Symplify\SymplifyKernel\HttpKernel;

use ConfigTransformerPrefix202301\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use ConfigTransformerPrefix202301\Symfony\Component\DependencyInjection\Container;
use ConfigTransformerPrefix202301\Symfony\Component\DependencyInjection\ContainerInterface;
use ConfigTransformerPrefix202301\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use ConfigTransformerPrefix202301\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
use ConfigTransformerPrefix202301\Symplify\SymplifyKernel\Config\Loader\ParameterMergingLoaderFactory;
use ConfigTransformerPrefix202301\Symplify\SymplifyKernel\ContainerBuilderFactory;
use ConfigTransformerPrefix202301\Symplify\SymplifyKernel\Contract\LightKernelInterface;
use ConfigTransformerPrefix202301\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
use ConfigTransformerPrefix202301\Symplify\SymplifyKernel\ValueObject\SymplifyKernelConfig;
/**
 * @api
 */
abstract class AbstractSymplifyKernel implements LightKernelInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\Container|null
     */
    private $container = null;
    /**
     * @param string[] $configFiles
     * @param CompilerPassInterface[] $compilerPasses
     * @param ExtensionInterface[] $extensions
     */
    public function create(array $configFiles, array $compilerPasses = [], array $extensions = []) : ContainerInterface
    {
        $containerBuilderFactory = new ContainerBuilderFactory(new ParameterMergingLoaderFactory());
        $compilerPasses[] = new AutowireArrayParameterCompilerPass();
        $configFiles[] = SymplifyKernelConfig::FILE_PATH;
        $containerBuilder = $containerBuilderFactory->create($configFiles, $compilerPasses, $extensions);
        $containerBuilder->compile();
        $this->container = $containerBuilder;
        return $containerBuilder;
    }
    public function getContainer() : \ConfigTransformerPrefix202301\Psr\Container\ContainerInterface
    {
        if (!$this->container instanceof Container) {
            throw new ShouldNotHappenException();
        }
        return $this->container;
    }
}
