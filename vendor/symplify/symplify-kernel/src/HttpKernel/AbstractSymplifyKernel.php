<?php

declare (strict_types=1);
namespace ConfigTransformer2022052210\Symplify\SymplifyKernel\HttpKernel;

use ConfigTransformer2022052210\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use ConfigTransformer2022052210\Symfony\Component\DependencyInjection\Container;
use ConfigTransformer2022052210\Symfony\Component\DependencyInjection\ContainerInterface;
use ConfigTransformer2022052210\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use ConfigTransformer2022052210\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
use ConfigTransformer2022052210\Symplify\SymplifyKernel\Config\Loader\ParameterMergingLoaderFactory;
use ConfigTransformer2022052210\Symplify\SymplifyKernel\ContainerBuilderFactory;
use ConfigTransformer2022052210\Symplify\SymplifyKernel\Contract\LightKernelInterface;
use ConfigTransformer2022052210\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
use ConfigTransformer2022052210\Symplify\SymplifyKernel\ValueObject\SymplifyKernelConfig;
/**
 * @api
 */
abstract class AbstractSymplifyKernel implements \ConfigTransformer2022052210\Symplify\SymplifyKernel\Contract\LightKernelInterface
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
    public function create(array $configFiles, array $compilerPasses = [], array $extensions = []) : \ConfigTransformer2022052210\Symfony\Component\DependencyInjection\ContainerInterface
    {
        $containerBuilderFactory = new \ConfigTransformer2022052210\Symplify\SymplifyKernel\ContainerBuilderFactory(new \ConfigTransformer2022052210\Symplify\SymplifyKernel\Config\Loader\ParameterMergingLoaderFactory());
        $compilerPasses[] = new \ConfigTransformer2022052210\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass();
        $configFiles[] = \ConfigTransformer2022052210\Symplify\SymplifyKernel\ValueObject\SymplifyKernelConfig::FILE_PATH;
        $containerBuilder = $containerBuilderFactory->create($configFiles, $compilerPasses, $extensions);
        $containerBuilder->compile();
        $this->container = $containerBuilder;
        return $containerBuilder;
    }
    public function getContainer() : \ConfigTransformer2022052210\Psr\Container\ContainerInterface
    {
        if (!$this->container instanceof \ConfigTransformer2022052210\Symfony\Component\DependencyInjection\Container) {
            throw new \ConfigTransformer2022052210\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
        }
        return $this->container;
    }
}
