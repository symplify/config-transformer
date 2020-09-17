<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer;

use Migrify\ConfigTransformer\DependencyInjection\ExtensionFaker;
use Migrify\ConfigTransformer\DependencyInjection\Loader\CheckerTolerantYamlFileLoader;
use Migrify\ConfigTransformer\DependencyInjection\LoaderFactory\IdAwareXmlFileLoaderFactory;
use Migrify\ConfigTransformer\ValueObject\ContainerBuilderAndFileContent;
use Migrify\ConfigTransformer\ValueObject\Format;
use Migrify\MigrifyKernel\Exception\NotImplementedYetException;
use Nette\Utils\Strings;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\DelegatingLoader;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\GlobFileLoader;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symplify\SmartFileSystem\SmartFileInfo;
use Symplify\SmartFileSystem\SmartFileSystem;

final class ConfigLoader
{
    /**
     * @var IdAwareXmlFileLoaderFactory
     */
    private $idAwareXmlFileLoaderFactory;

    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;

    /**
     * @var ExtensionFaker
     */
    private $extensionFaker;

    public function __construct(
        IdAwareXmlFileLoaderFactory $idAwareXmlFileLoaderFactory,
        SmartFileSystem $smartFileSystem,
        ExtensionFaker $extensionFaker
    ) {
        $this->idAwareXmlFileLoaderFactory = $idAwareXmlFileLoaderFactory;
        $this->smartFileSystem = $smartFileSystem;
        $this->extensionFaker = $extensionFaker;
    }

    public function createAndLoadContainerBuilderFromFileInfo(
        SmartFileInfo $smartFileInfo
    ): ContainerBuilderAndFileContent {
        $containerBuilder = new ContainerBuilder();

        $loader = $this->createLoaderBySuffix($containerBuilder, $smartFileInfo->getSuffix());

        $fileRealPath = $smartFileInfo->getRealPath();

        // correct old syntax of tags so we can parse it
        $content = $smartFileInfo->getContents();

        if (in_array($smartFileInfo->getSuffix(), [Format::YML, Format::YAML], true)) {
            $content = Strings::replace($content, '#\!php\/const\:( )?#', '!php/const ');
            if ($content !== $smartFileInfo->getContents()) {
                $fileRealPath = sys_get_temp_dir() . '/_migrify_config_tranformer_clean_yaml/' . $smartFileInfo->getFilename();
                $this->smartFileSystem->dumpFile($fileRealPath, $content);
            }

            $this->extensionFaker->fakeInContainerBuilder($containerBuilder, $content);
        }

        $loader->load($fileRealPath);

        return new ContainerBuilderAndFileContent($containerBuilder, $content);
    }

    private function createLoaderBySuffix(ContainerBuilder $containerBuilder, string $suffix): Loader
    {
        if ($suffix === Format::XML) {
            $idAwareXmlFileLoader = $this->idAwareXmlFileLoaderFactory->createFromContainerBuilder($containerBuilder);
            return $this->wrapToDelegatingLoader($idAwareXmlFileLoader, $containerBuilder);
        }

        if (in_array($suffix, [Format::YML, Format::YAML], true)) {
            $yamlFileLoader = new YamlFileLoader($containerBuilder, new FileLocator());
            return $this->wrapToDelegatingLoader($yamlFileLoader, $containerBuilder);
        }

        if ($suffix === Format::PHP) {
            $phpFileLoader = new PhpFileLoader($containerBuilder, new FileLocator());
            return $this->wrapToDelegatingLoader($phpFileLoader, $containerBuilder);
        }

        throw new NotImplementedYetException($suffix);
    }

    private function wrapToDelegatingLoader(Loader $loader, ContainerBuilder $containerBuilder): DelegatingLoader
    {
        return new DelegatingLoader(new LoaderResolver([
            new GlobFileLoader($containerBuilder, new FileLocator()),
            new PhpFileLoader($containerBuilder, new FileLocator()),
            // for easier ECS migraiton
            new CheckerTolerantYamlFileLoader($containerBuilder, new FileLocator()),
            $loader,
        ]));
    }
}
