<?php

declare (strict_types=1);
namespace ConfigTransformer202111242\Symplify\SymplifyKernel\HttpKernel;

use ConfigTransformer202111242\Symfony\Component\DependencyInjection\Container;
use ConfigTransformer202111242\Symfony\Component\DependencyInjection\ContainerInterface;
use ConfigTransformer202111242\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
use ConfigTransformer202111242\Symplify\SymplifyKernel\Config\Loader\ParameterMergingLoaderFactory;
use ConfigTransformer202111242\Symplify\SymplifyKernel\ContainerBuilderFactory;
use ConfigTransformer202111242\Symplify\SymplifyKernel\Contract\LightKernelInterface;
use ConfigTransformer202111242\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
use ConfigTransformer202111242\Symplify\SymplifyKernel\ValueObject\SymplifyKernelConfig;
/**
 * @api
 */
abstract class AbstractSymplifyKernel implements \ConfigTransformer202111242\Symplify\SymplifyKernel\Contract\LightKernelInterface
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
    public function create($extensions, $compilerPasses, $configFiles) : \ConfigTransformer202111242\Symfony\Component\DependencyInjection\ContainerInterface
    {
        $containerBuilderFactory = new \ConfigTransformer202111242\Symplify\SymplifyKernel\ContainerBuilderFactory(new \ConfigTransformer202111242\Symplify\SymplifyKernel\Config\Loader\ParameterMergingLoaderFactory());
        $compilerPasses[] = new \ConfigTransformer202111242\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass();
        $configFiles[] = \ConfigTransformer202111242\Symplify\SymplifyKernel\ValueObject\SymplifyKernelConfig::FILE_PATH;
        $containerBuilder = $containerBuilderFactory->create($extensions, $compilerPasses, $configFiles);
        $containerBuilder->compile();
        $this->container = $containerBuilder;
        return $containerBuilder;
    }
    public function getContainer() : \ConfigTransformer202111242\Psr\Container\ContainerInterface
    {
        if (!$this->container instanceof \ConfigTransformer202111242\Symfony\Component\DependencyInjection\Container) {
            throw new \ConfigTransformer202111242\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
        }
        return $this->container;
    }
}
