<?php

declare (strict_types=1);
namespace ConfigTransformer2022031610\Symplify\SymplifyKernel;

use ConfigTransformer2022031610\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use ConfigTransformer2022031610\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer2022031610\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use ConfigTransformer2022031610\Symplify\SymplifyKernel\Contract\Config\LoaderFactoryInterface;
use ConfigTransformer2022031610\Symplify\SymplifyKernel\DependencyInjection\LoadExtensionConfigsCompilerPass;
use ConfigTransformer2022031610\Webmozart\Assert\Assert;
/**
 * @see \Symplify\SymplifyKernel\Tests\ContainerBuilderFactory\ContainerBuilderFactoryTest
 */
final class ContainerBuilderFactory
{
    /**
     * @var \Symplify\SymplifyKernel\Contract\Config\LoaderFactoryInterface
     */
    private $loaderFactory;
    public function __construct(\ConfigTransformer2022031610\Symplify\SymplifyKernel\Contract\Config\LoaderFactoryInterface $loaderFactory)
    {
        $this->loaderFactory = $loaderFactory;
    }
    /**
     * @param string[] $configFiles
     * @param CompilerPassInterface[] $compilerPasses
     * @param ExtensionInterface[] $extensions
     */
    public function create(array $configFiles, array $compilerPasses, array $extensions) : \ConfigTransformer2022031610\Symfony\Component\DependencyInjection\ContainerBuilder
    {
        \ConfigTransformer2022031610\Webmozart\Assert\Assert::allIsAOf($extensions, \ConfigTransformer2022031610\Symfony\Component\DependencyInjection\Extension\ExtensionInterface::class);
        \ConfigTransformer2022031610\Webmozart\Assert\Assert::allIsAOf($compilerPasses, \ConfigTransformer2022031610\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface::class);
        \ConfigTransformer2022031610\Webmozart\Assert\Assert::allString($configFiles);
        \ConfigTransformer2022031610\Webmozart\Assert\Assert::allFile($configFiles);
        $containerBuilder = new \ConfigTransformer2022031610\Symfony\Component\DependencyInjection\ContainerBuilder();
        $this->registerExtensions($containerBuilder, $extensions);
        $this->registerConfigFiles($containerBuilder, $configFiles);
        $this->registerCompilerPasses($containerBuilder, $compilerPasses);
        // this calls load() method in every extensions
        // ensure these extensions are implicitly loaded
        $compilerPassConfig = $containerBuilder->getCompilerPassConfig();
        $compilerPassConfig->setMergePass(new \ConfigTransformer2022031610\Symplify\SymplifyKernel\DependencyInjection\LoadExtensionConfigsCompilerPass());
        return $containerBuilder;
    }
    /**
     * @param ExtensionInterface[] $extensions
     */
    private function registerExtensions(\ConfigTransformer2022031610\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, array $extensions) : void
    {
        foreach ($extensions as $extension) {
            $containerBuilder->registerExtension($extension);
        }
    }
    /**
     * @param CompilerPassInterface[] $compilerPasses
     */
    private function registerCompilerPasses(\ConfigTransformer2022031610\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, array $compilerPasses) : void
    {
        foreach ($compilerPasses as $compilerPass) {
            $containerBuilder->addCompilerPass($compilerPass);
        }
    }
    /**
     * @param string[] $configFiles
     */
    private function registerConfigFiles(\ConfigTransformer2022031610\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, array $configFiles) : void
    {
        $delegatingLoader = $this->loaderFactory->create($containerBuilder, \getcwd());
        foreach ($configFiles as $configFile) {
            $delegatingLoader->load($configFile);
        }
    }
}
