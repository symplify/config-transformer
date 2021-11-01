<?php

declare (strict_types=1);
namespace ConfigTransformer202111011\Symplify\SymplifyKernel\HttpKernel;

use ConfigTransformer202111011\Symfony\Component\DependencyInjection\Container;
use ConfigTransformer202111011\Symfony\Component\DependencyInjection\ContainerInterface;
use ConfigTransformer202111011\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
use ConfigTransformer202111011\Symplify\SymfonyContainerBuilder\ContainerBuilderFactory;
use ConfigTransformer202111011\Symplify\SymplifyKernel\Contract\LightKernelInterface;
use ConfigTransformer202111011\Symplify\SymplifyKernel\DependencyInjection\Extension\SymplifyKernelExtension;
use ConfigTransformer202111011\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
/**
 * @api
 */
abstract class AbstractSymplifyKernel implements \ConfigTransformer202111011\Symplify\SymplifyKernel\Contract\LightKernelInterface
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
    public function create($extensions, $compilerPasses, $configFiles) : \ConfigTransformer202111011\Symfony\Component\DependencyInjection\ContainerInterface
    {
        $containerBuilderFactory = new \ConfigTransformer202111011\Symplify\SymfonyContainerBuilder\ContainerBuilderFactory();
        $extensions[] = new \ConfigTransformer202111011\Symplify\SymplifyKernel\DependencyInjection\Extension\SymplifyKernelExtension();
        $compilerPasses[] = new \ConfigTransformer202111011\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass();
        $containerBuilder = $containerBuilderFactory->create($extensions, $compilerPasses, $configFiles);
        $containerBuilder->compile();
        $this->container = $containerBuilder;
        return $containerBuilder;
    }
    public function getContainer() : \ConfigTransformer202111011\Psr\Container\ContainerInterface
    {
        if (!$this->container instanceof \ConfigTransformer202111011\Symfony\Component\DependencyInjection\Container) {
            throw new \ConfigTransformer202111011\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
        }
        return $this->container;
    }
}
