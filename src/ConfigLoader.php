<?php

declare (strict_types=1);
namespace ConfigTransformer202108307\Symplify\ConfigTransformer;

use ConfigTransformer202108307\Nette\Utils\Strings;
use ConfigTransformer202108307\Symfony\Component\Config\FileLocator;
use ConfigTransformer202108307\Symfony\Component\Config\Loader\DelegatingLoader;
use ConfigTransformer202108307\Symfony\Component\Config\Loader\Loader;
use ConfigTransformer202108307\Symfony\Component\Config\Loader\LoaderResolver;
use ConfigTransformer202108307\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202108307\Symfony\Component\DependencyInjection\Loader\GlobFileLoader;
use ConfigTransformer202108307\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use ConfigTransformer202108307\Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use ConfigTransformer202108307\Symplify\ConfigTransformer\DependencyInjection\ExtensionFaker;
use ConfigTransformer202108307\Symplify\ConfigTransformer\DependencyInjection\Loader\CheckerTolerantYamlFileLoader;
use ConfigTransformer202108307\Symplify\ConfigTransformer\DependencyInjection\LoaderFactory\IdAwareXmlFileLoaderFactory;
use ConfigTransformer202108307\Symplify\ConfigTransformer\ValueObject\Configuration;
use ConfigTransformer202108307\Symplify\ConfigTransformer\ValueObject\ContainerBuilderAndFileContent;
use ConfigTransformer202108307\Symplify\ConfigTransformer\ValueObject\Format;
use ConfigTransformer202108307\Symplify\PackageBuilder\Exception\NotImplementedYetException;
use ConfigTransformer202108307\Symplify\SmartFileSystem\SmartFileInfo;
use ConfigTransformer202108307\Symplify\SmartFileSystem\SmartFileSystem;
final class ConfigLoader
{
    /**
     * @see https://regex101.com/r/Mnd9vH/1
     * @var string
     */
    private const PHP_CONST_REGEX = '#\\!php\\/const\\:( )?#';
    /**
     * @var \Symplify\ConfigTransformer\DependencyInjection\LoaderFactory\IdAwareXmlFileLoaderFactory
     */
    private $idAwareXmlFileLoaderFactory;
    /**
     * @var \Symplify\SmartFileSystem\SmartFileSystem
     */
    private $smartFileSystem;
    /**
     * @var \Symplify\ConfigTransformer\DependencyInjection\ExtensionFaker
     */
    private $extensionFaker;
    public function __construct(\ConfigTransformer202108307\Symplify\ConfigTransformer\DependencyInjection\LoaderFactory\IdAwareXmlFileLoaderFactory $idAwareXmlFileLoaderFactory, \ConfigTransformer202108307\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \ConfigTransformer202108307\Symplify\ConfigTransformer\DependencyInjection\ExtensionFaker $extensionFaker)
    {
        $this->idAwareXmlFileLoaderFactory = $idAwareXmlFileLoaderFactory;
        $this->smartFileSystem = $smartFileSystem;
        $this->extensionFaker = $extensionFaker;
    }
    public function createAndLoadContainerBuilderFromFileInfo(\ConfigTransformer202108307\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, \ConfigTransformer202108307\Symplify\ConfigTransformer\ValueObject\Configuration $configuration) : \ConfigTransformer202108307\Symplify\ConfigTransformer\ValueObject\ContainerBuilderAndFileContent
    {
        $containerBuilder = new \ConfigTransformer202108307\Symfony\Component\DependencyInjection\ContainerBuilder();
        $delegatingLoader = $this->createLoaderBySuffix($containerBuilder, $configuration, $smartFileInfo->getSuffix());
        $fileRealPath = $smartFileInfo->getRealPath();
        // correct old syntax of tags so we can parse it
        $content = $smartFileInfo->getContents();
        if (\in_array($smartFileInfo->getSuffix(), [\ConfigTransformer202108307\Symplify\ConfigTransformer\ValueObject\Format::YML, \ConfigTransformer202108307\Symplify\ConfigTransformer\ValueObject\Format::YAML], \true)) {
            $content = \ConfigTransformer202108307\Nette\Utils\Strings::replace($content, self::PHP_CONST_REGEX, '!php/const ');
            if ($content !== $smartFileInfo->getContents()) {
                $fileRealPath = \sys_get_temp_dir() . '/_migrify_config_tranformer_clean_yaml/' . $smartFileInfo->getFilename();
                $this->smartFileSystem->dumpFile($fileRealPath, $content);
            }
            $this->extensionFaker->fakeInContainerBuilder($containerBuilder, $content);
        }
        $delegatingLoader->load($fileRealPath);
        return new \ConfigTransformer202108307\Symplify\ConfigTransformer\ValueObject\ContainerBuilderAndFileContent($containerBuilder, $content);
    }
    private function createLoaderBySuffix(\ConfigTransformer202108307\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, \ConfigTransformer202108307\Symplify\ConfigTransformer\ValueObject\Configuration $configuration, string $suffix) : \ConfigTransformer202108307\Symfony\Component\Config\Loader\DelegatingLoader
    {
        if ($suffix === \ConfigTransformer202108307\Symplify\ConfigTransformer\ValueObject\Format::XML) {
            $idAwareXmlFileLoader = $this->idAwareXmlFileLoaderFactory->createFromContainerBuilder($containerBuilder);
            return $this->wrapToDelegatingLoader($idAwareXmlFileLoader, $containerBuilder);
        }
        if (\in_array($suffix, [\ConfigTransformer202108307\Symplify\ConfigTransformer\ValueObject\Format::YML, \ConfigTransformer202108307\Symplify\ConfigTransformer\ValueObject\Format::YAML], \true)) {
            $yamlFileLoader = new \ConfigTransformer202108307\Symfony\Component\DependencyInjection\Loader\YamlFileLoader($containerBuilder, new \ConfigTransformer202108307\Symfony\Component\Config\FileLocator());
            return $this->wrapToDelegatingLoader($yamlFileLoader, $containerBuilder);
        }
        if ($suffix === \ConfigTransformer202108307\Symplify\ConfigTransformer\ValueObject\Format::PHP) {
            $phpFileLoader = new \ConfigTransformer202108307\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \ConfigTransformer202108307\Symfony\Component\Config\FileLocator());
            return $this->wrapToDelegatingLoader($phpFileLoader, $containerBuilder);
        }
        throw new \ConfigTransformer202108307\Symplify\PackageBuilder\Exception\NotImplementedYetException($suffix);
    }
    private function wrapToDelegatingLoader(\ConfigTransformer202108307\Symfony\Component\Config\Loader\Loader $loader, \ConfigTransformer202108307\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : \ConfigTransformer202108307\Symfony\Component\Config\Loader\DelegatingLoader
    {
        $globFileLoader = new \ConfigTransformer202108307\Symfony\Component\DependencyInjection\Loader\GlobFileLoader($containerBuilder, new \ConfigTransformer202108307\Symfony\Component\Config\FileLocator());
        $phpFileLoader = new \ConfigTransformer202108307\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \ConfigTransformer202108307\Symfony\Component\Config\FileLocator());
        $checkerTolerantYamlFileLoader = new \ConfigTransformer202108307\Symplify\ConfigTransformer\DependencyInjection\Loader\CheckerTolerantYamlFileLoader($containerBuilder, new \ConfigTransformer202108307\Symfony\Component\Config\FileLocator());
        return new \ConfigTransformer202108307\Symfony\Component\Config\Loader\DelegatingLoader(new \ConfigTransformer202108307\Symfony\Component\Config\Loader\LoaderResolver([$globFileLoader, $phpFileLoader, $checkerTolerantYamlFileLoader, $loader]));
    }
}
