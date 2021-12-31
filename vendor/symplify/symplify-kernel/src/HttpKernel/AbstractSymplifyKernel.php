<?php

declare (strict_types=1);
namespace ConfigTransformer2021123110\Symplify\SymplifyKernel\HttpKernel;

use ConfigTransformer2021123110\Symfony\Component\DependencyInjection\Container;
use ConfigTransformer2021123110\Symfony\Component\DependencyInjection\ContainerInterface;
use ConfigTransformer2021123110\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
use ConfigTransformer2021123110\Symplify\SymplifyKernel\Config\Loader\ParameterMergingLoaderFactory;
use ConfigTransformer2021123110\Symplify\SymplifyKernel\ContainerBuilderFactory;
use ConfigTransformer2021123110\Symplify\SymplifyKernel\Contract\LightKernelInterface;
use ConfigTransformer2021123110\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
use ConfigTransformer2021123110\Symplify\SymplifyKernel\ValueObject\SymplifyKernelConfig;
/**
 * @api
 */
abstract class AbstractSymplifyKernel implements \ConfigTransformer2021123110\Symplify\SymplifyKernel\Contract\LightKernelInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\Container|null
     */
    private $container = null;
    /**
     * @param string[] $configFiles
     */
    public function create(array $extensions, array $compilerPasses, array $configFiles) : \ConfigTransformer2021123110\Symfony\Component\DependencyInjection\ContainerInterface
    {
        $containerBuilderFactory = new \ConfigTransformer2021123110\Symplify\SymplifyKernel\ContainerBuilderFactory(new \ConfigTransformer2021123110\Symplify\SymplifyKernel\Config\Loader\ParameterMergingLoaderFactory());
        $compilerPasses[] = new \ConfigTransformer2021123110\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass();
        $configFiles[] = \ConfigTransformer2021123110\Symplify\SymplifyKernel\ValueObject\SymplifyKernelConfig::FILE_PATH;
        $containerBuilder = $containerBuilderFactory->create($extensions, $compilerPasses, $configFiles);
        $containerBuilder->compile();
        $this->container = $containerBuilder;
        return $containerBuilder;
    }
    public function getContainer() : \ConfigTransformer2021123110\Psr\Container\ContainerInterface
    {
        if (!$this->container instanceof \ConfigTransformer2021123110\Symfony\Component\DependencyInjection\Container) {
            throw new \ConfigTransformer2021123110\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
        }
        return $this->container;
    }
}
