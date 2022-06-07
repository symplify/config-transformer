<?php

declare (strict_types=1);
namespace ConfigTransformer202206072\Symplify\SymplifyKernel\HttpKernel;

use ConfigTransformer202206072\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use ConfigTransformer202206072\Symfony\Component\DependencyInjection\Container;
use ConfigTransformer202206072\Symfony\Component\DependencyInjection\ContainerInterface;
use ConfigTransformer202206072\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use ConfigTransformer202206072\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
use ConfigTransformer202206072\Symplify\SymplifyKernel\Config\Loader\ParameterMergingLoaderFactory;
use ConfigTransformer202206072\Symplify\SymplifyKernel\ContainerBuilderFactory;
use ConfigTransformer202206072\Symplify\SymplifyKernel\Contract\LightKernelInterface;
use ConfigTransformer202206072\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
use ConfigTransformer202206072\Symplify\SymplifyKernel\ValueObject\SymplifyKernelConfig;
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
    public function getContainer() : \ConfigTransformer202206072\Psr\Container\ContainerInterface
    {
        if (!$this->container instanceof Container) {
            throw new ShouldNotHappenException();
        }
        return $this->container;
    }
}
