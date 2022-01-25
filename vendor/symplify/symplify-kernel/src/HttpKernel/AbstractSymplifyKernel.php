<?php

declare (strict_types=1);
namespace ConfigTransformer202201257\Symplify\SymplifyKernel\HttpKernel;

use ConfigTransformer202201257\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use ConfigTransformer202201257\Symfony\Component\DependencyInjection\Container;
use ConfigTransformer202201257\Symfony\Component\DependencyInjection\ContainerInterface;
use ConfigTransformer202201257\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use ConfigTransformer202201257\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
use ConfigTransformer202201257\Symplify\SymplifyKernel\Config\Loader\ParameterMergingLoaderFactory;
use ConfigTransformer202201257\Symplify\SymplifyKernel\ContainerBuilderFactory;
use ConfigTransformer202201257\Symplify\SymplifyKernel\Contract\LightKernelInterface;
use ConfigTransformer202201257\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
use ConfigTransformer202201257\Symplify\SymplifyKernel\ValueObject\SymplifyKernelConfig;
/**
 * @api
 */
abstract class AbstractSymplifyKernel implements \ConfigTransformer202201257\Symplify\SymplifyKernel\Contract\LightKernelInterface
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
    public function create(array $configFiles, array $compilerPasses, array $extensions) : \ConfigTransformer202201257\Symfony\Component\DependencyInjection\ContainerInterface
    {
        $containerBuilderFactory = new \ConfigTransformer202201257\Symplify\SymplifyKernel\ContainerBuilderFactory(new \ConfigTransformer202201257\Symplify\SymplifyKernel\Config\Loader\ParameterMergingLoaderFactory());
        $compilerPasses[] = new \ConfigTransformer202201257\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass();
        $configFiles[] = \ConfigTransformer202201257\Symplify\SymplifyKernel\ValueObject\SymplifyKernelConfig::FILE_PATH;
        $containerBuilder = $containerBuilderFactory->create($configFiles, $compilerPasses, $extensions);
        $containerBuilder->compile();
        $this->container = $containerBuilder;
        return $containerBuilder;
    }
    public function getContainer() : \ConfigTransformer202201257\Psr\Container\ContainerInterface
    {
        if (!$this->container instanceof \ConfigTransformer202201257\Symfony\Component\DependencyInjection\Container) {
            throw new \ConfigTransformer202201257\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
        }
        return $this->container;
    }
}
