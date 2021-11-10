<?php

declare (strict_types=1);
namespace ConfigTransformer2021111010\Symplify\SymplifyKernel\HttpKernel;

use ConfigTransformer2021111010\Symfony\Component\DependencyInjection\Container;
use ConfigTransformer2021111010\Symfony\Component\DependencyInjection\ContainerInterface;
use ConfigTransformer2021111010\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
use ConfigTransformer2021111010\Symplify\SymplifyKernel\Config\Loader\ParameterMergingLoaderFactory;
use ConfigTransformer2021111010\Symplify\SymplifyKernel\ContainerBuilderFactory;
use ConfigTransformer2021111010\Symplify\SymplifyKernel\Contract\LightKernelInterface;
use ConfigTransformer2021111010\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
use ConfigTransformer2021111010\Symplify\SymplifyKernel\ValueObject\SymplifyKernelConfig;
/**
 * @api
 */
abstract class AbstractSymplifyKernel implements \ConfigTransformer2021111010\Symplify\SymplifyKernel\Contract\LightKernelInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\Container|null
     */
    private $container = null;
    /**
     * @param string[] $configFiles
     * @param mixed[] $extensions
     * @param mixed[] $compilerPasses
     */
    public function create($extensions, $compilerPasses, $configFiles) : \ConfigTransformer2021111010\Symfony\Component\DependencyInjection\ContainerInterface
    {
        $containerBuilderFactory = new \ConfigTransformer2021111010\Symplify\SymplifyKernel\ContainerBuilderFactory(new \ConfigTransformer2021111010\Symplify\SymplifyKernel\Config\Loader\ParameterMergingLoaderFactory());
        $compilerPasses[] = new \ConfigTransformer2021111010\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass();
        $configFiles[] = \ConfigTransformer2021111010\Symplify\SymplifyKernel\ValueObject\SymplifyKernelConfig::FILE_PATH;
        $containerBuilder = $containerBuilderFactory->create($extensions, $compilerPasses, $configFiles);
        $containerBuilder->compile();
        $this->container = $containerBuilder;
        return $containerBuilder;
    }
    public function getContainer() : \ConfigTransformer2021111010\Psr\Container\ContainerInterface
    {
        if (!$this->container instanceof \ConfigTransformer2021111010\Symfony\Component\DependencyInjection\Container) {
            throw new \ConfigTransformer2021111010\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
        }
        return $this->container;
    }
}
