<?php

declare (strict_types=1);
namespace Symplify\ConfigTransformer\DependencyInjection\Loader;

use ConfigTransformer202208\Symfony\Component\Config\FileLocatorInterface;
use ConfigTransformer202208\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202208\Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symplify\ConfigTransformer\DependencyInjection\ExtensionFaker;
use Symplify\PhpConfigPrinter\Yaml\CheckerServiceParametersShifter;
/**
 * @see https://github.com/symplify/config-transformer/commit/0244abf3953eb0c5578d203b75749545f705c2a3
 */
final class CheckerTolerantYamlFileLoader extends YamlFileLoader
{
    /**
     * @var \Symplify\PhpConfigPrinter\Yaml\CheckerServiceParametersShifter
     */
    private $checkerServiceParametersShifter;
    public function __construct(ContainerBuilder $containerBuilder, FileLocatorInterface $fileLocator)
    {
        $this->checkerServiceParametersShifter = new CheckerServiceParametersShifter();
        // we need to fake extension before the file gets parsed, as
        $extensionFaker = new ExtensionFaker();
        $extensionFaker->fakeGenericExtensionsInContainerBuilder($containerBuilder);
        parent::__construct($containerBuilder, $fileLocator);
    }
    /**
     * @return mixed[]
     */
    protected function loadFile(string $file) : ?array
    {
        /** @var mixed[]|null $configuration */
        $configuration = parent::loadFile($file);
        if ($configuration === null) {
            return [];
        }
        return $this->checkerServiceParametersShifter->process($configuration);
    }
}
