<?php

declare (strict_types=1);
namespace ConfigTransformer202201249\Symplify\SymplifyKernel\HttpKernel;

use ConfigTransformer202201249\Symfony\Component\DependencyInjection\Container;
use ConfigTransformer202201249\Symfony\Component\DependencyInjection\ContainerInterface;
use ConfigTransformer202201249\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
use ConfigTransformer202201249\Symplify\SymplifyKernel\Config\Loader\ParameterMergingLoaderFactory;
use ConfigTransformer202201249\Symplify\SymplifyKernel\ContainerBuilderFactory;
use ConfigTransformer202201249\Symplify\SymplifyKernel\Contract\LightKernelInterface;
use ConfigTransformer202201249\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
use ConfigTransformer202201249\Symplify\SymplifyKernel\ValueObject\SymplifyKernelConfig;
/**
 * @api
 */
abstract class AbstractSymplifyKernel implements \ConfigTransformer202201249\Symplify\SymplifyKernel\Contract\LightKernelInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\Container|null
     */
    private $container = null;
    /**
     * @param string[] $configFiles
     */
    public function create(array $extensions, array $compilerPasses, array $configFiles) : \ConfigTransformer202201249\Symfony\Component\DependencyInjection\ContainerInterface
    {
        $containerBuilderFactory = new \ConfigTransformer202201249\Symplify\SymplifyKernel\ContainerBuilderFactory(new \ConfigTransformer202201249\Symplify\SymplifyKernel\Config\Loader\ParameterMergingLoaderFactory());
        $compilerPasses[] = new \ConfigTransformer202201249\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass();
        $configFiles[] = \ConfigTransformer202201249\Symplify\SymplifyKernel\ValueObject\SymplifyKernelConfig::FILE_PATH;
        $containerBuilder = $containerBuilderFactory->create($extensions, $compilerPasses, $configFiles);
        $containerBuilder->compile();
        $this->container = $containerBuilder;
        return $containerBuilder;
    }
    public function getContainer() : \ConfigTransformer202201249\Psr\Container\ContainerInterface
    {
        if (!$this->container instanceof \ConfigTransformer202201249\Symfony\Component\DependencyInjection\Container) {
            throw new \ConfigTransformer202201249\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
        }
        return $this->container;
    }
}
