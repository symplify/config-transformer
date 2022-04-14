<?php

declare (strict_types=1);
namespace ConfigTransformer202204145\Symplify\SymplifyKernel;

use ConfigTransformer202204145\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use ConfigTransformer202204145\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202204145\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use ConfigTransformer202204145\Symplify\SymplifyKernel\Contract\Config\LoaderFactoryInterface;
use ConfigTransformer202204145\Symplify\SymplifyKernel\DependencyInjection\LoadExtensionConfigsCompilerPass;
use ConfigTransformer202204145\Webmozart\Assert\Assert;
/**
 * @see \Symplify\SymplifyKernel\Tests\ContainerBuilderFactory\ContainerBuilderFactoryTest
 */
final class ContainerBuilderFactory
{
    /**
     * @var \Symplify\SymplifyKernel\Contract\Config\LoaderFactoryInterface
     */
    private $loaderFactory;
    public function __construct(\ConfigTransformer202204145\Symplify\SymplifyKernel\Contract\Config\LoaderFactoryInterface $loaderFactory)
    {
        $this->loaderFactory = $loaderFactory;
    }
    /**
     * @param string[] $configFiles
     * @param CompilerPassInterface[] $compilerPasses
     * @param ExtensionInterface[] $extensions
     */
    public function create(array $configFiles, array $compilerPasses, array $extensions) : \ConfigTransformer202204145\Symfony\Component\DependencyInjection\ContainerBuilder
    {
        \ConfigTransformer202204145\Webmozart\Assert\Assert::allIsAOf($extensions, \ConfigTransformer202204145\Symfony\Component\DependencyInjection\Extension\ExtensionInterface::class);
        \ConfigTransformer202204145\Webmozart\Assert\Assert::allIsAOf($compilerPasses, \ConfigTransformer202204145\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface::class);
        \ConfigTransformer202204145\Webmozart\Assert\Assert::allString($configFiles);
        \ConfigTransformer202204145\Webmozart\Assert\Assert::allFile($configFiles);
        $containerBuilder = new \ConfigTransformer202204145\Symfony\Component\DependencyInjection\ContainerBuilder();
        $this->registerExtensions($containerBuilder, $extensions);
        $this->registerConfigFiles($containerBuilder, $configFiles);
        $this->registerCompilerPasses($containerBuilder, $compilerPasses);
        // this calls load() method in every extensions
        // ensure these extensions are implicitly loaded
        $compilerPassConfig = $containerBuilder->getCompilerPassConfig();
        $compilerPassConfig->setMergePass(new \ConfigTransformer202204145\Symplify\SymplifyKernel\DependencyInjection\LoadExtensionConfigsCompilerPass());
        return $containerBuilder;
    }
    /**
     * @param ExtensionInterface[] $extensions
     */
    private function registerExtensions(\ConfigTransformer202204145\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, array $extensions) : void
    {
        foreach ($extensions as $extension) {
            $containerBuilder->registerExtension($extension);
        }
    }
    /**
     * @param CompilerPassInterface[] $compilerPasses
     */
    private function registerCompilerPasses(\ConfigTransformer202204145\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, array $compilerPasses) : void
    {
        foreach ($compilerPasses as $compilerPass) {
            $containerBuilder->addCompilerPass($compilerPass);
        }
    }
    /**
     * @param string[] $configFiles
     */
    private function registerConfigFiles(\ConfigTransformer202204145\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, array $configFiles) : void
    {
        $delegatingLoader = $this->loaderFactory->create($containerBuilder, \getcwd());
        foreach ($configFiles as $configFile) {
            $delegatingLoader->load($configFile);
        }
    }
}
