<?php

declare (strict_types=1);
namespace ConfigTransformer2021083010\Symplify\ConfigTransformer;

use ConfigTransformer2021083010\Nette\Utils\Strings;
use ConfigTransformer2021083010\Symfony\Component\Config\FileLocator;
use ConfigTransformer2021083010\Symfony\Component\Config\Loader\DelegatingLoader;
use ConfigTransformer2021083010\Symfony\Component\Config\Loader\Loader;
use ConfigTransformer2021083010\Symfony\Component\Config\Loader\LoaderResolver;
use ConfigTransformer2021083010\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer2021083010\Symfony\Component\DependencyInjection\Loader\GlobFileLoader;
use ConfigTransformer2021083010\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use ConfigTransformer2021083010\Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use ConfigTransformer2021083010\Symplify\ConfigTransformer\DependencyInjection\ExtensionFaker;
use ConfigTransformer2021083010\Symplify\ConfigTransformer\DependencyInjection\Loader\CheckerTolerantYamlFileLoader;
use ConfigTransformer2021083010\Symplify\ConfigTransformer\DependencyInjection\LoaderFactory\IdAwareXmlFileLoaderFactory;
use ConfigTransformer2021083010\Symplify\ConfigTransformer\ValueObject\Configuration;
use ConfigTransformer2021083010\Symplify\ConfigTransformer\ValueObject\ContainerBuilderAndFileContent;
use ConfigTransformer2021083010\Symplify\ConfigTransformer\ValueObject\Format;
use ConfigTransformer2021083010\Symplify\PackageBuilder\Exception\NotImplementedYetException;
use ConfigTransformer2021083010\Symplify\SmartFileSystem\SmartFileInfo;
use ConfigTransformer2021083010\Symplify\SmartFileSystem\SmartFileSystem;
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
    public function __construct(\ConfigTransformer2021083010\Symplify\ConfigTransformer\DependencyInjection\LoaderFactory\IdAwareXmlFileLoaderFactory $idAwareXmlFileLoaderFactory, \ConfigTransformer2021083010\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \ConfigTransformer2021083010\Symplify\ConfigTransformer\DependencyInjection\ExtensionFaker $extensionFaker)
    {
        $this->idAwareXmlFileLoaderFactory = $idAwareXmlFileLoaderFactory;
        $this->smartFileSystem = $smartFileSystem;
        $this->extensionFaker = $extensionFaker;
    }
    public function createAndLoadContainerBuilderFromFileInfo(\ConfigTransformer2021083010\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, \ConfigTransformer2021083010\Symplify\ConfigTransformer\ValueObject\Configuration $configuration) : \ConfigTransformer2021083010\Symplify\ConfigTransformer\ValueObject\ContainerBuilderAndFileContent
    {
        $containerBuilder = new \ConfigTransformer2021083010\Symfony\Component\DependencyInjection\ContainerBuilder();
        $delegatingLoader = $this->createLoaderBySuffix($containerBuilder, $configuration, $smartFileInfo->getSuffix());
        $fileRealPath = $smartFileInfo->getRealPath();
        // correct old syntax of tags so we can parse it
        $content = $smartFileInfo->getContents();
        if (\in_array($smartFileInfo->getSuffix(), [\ConfigTransformer2021083010\Symplify\ConfigTransformer\ValueObject\Format::YML, \ConfigTransformer2021083010\Symplify\ConfigTransformer\ValueObject\Format::YAML], \true)) {
            $content = \ConfigTransformer2021083010\Nette\Utils\Strings::replace($content, self::PHP_CONST_REGEX, '!php/const ');
            if ($content !== $smartFileInfo->getContents()) {
                $fileRealPath = \sys_get_temp_dir() . '/_migrify_config_tranformer_clean_yaml/' . $smartFileInfo->getFilename();
                $this->smartFileSystem->dumpFile($fileRealPath, $content);
            }
            $this->extensionFaker->fakeInContainerBuilder($containerBuilder, $content);
        }
        $delegatingLoader->load($fileRealPath);
        return new \ConfigTransformer2021083010\Symplify\ConfigTransformer\ValueObject\ContainerBuilderAndFileContent($containerBuilder, $content);
    }
    private function createLoaderBySuffix(\ConfigTransformer2021083010\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, \ConfigTransformer2021083010\Symplify\ConfigTransformer\ValueObject\Configuration $configuration, string $suffix) : \ConfigTransformer2021083010\Symfony\Component\Config\Loader\DelegatingLoader
    {
        if ($suffix === \ConfigTransformer2021083010\Symplify\ConfigTransformer\ValueObject\Format::XML) {
            $idAwareXmlFileLoader = $this->idAwareXmlFileLoaderFactory->createFromContainerBuilder($containerBuilder);
            return $this->wrapToDelegatingLoader($idAwareXmlFileLoader, $containerBuilder);
        }
        if (\in_array($suffix, [\ConfigTransformer2021083010\Symplify\ConfigTransformer\ValueObject\Format::YML, \ConfigTransformer2021083010\Symplify\ConfigTransformer\ValueObject\Format::YAML], \true)) {
            $yamlFileLoader = new \ConfigTransformer2021083010\Symfony\Component\DependencyInjection\Loader\YamlFileLoader($containerBuilder, new \ConfigTransformer2021083010\Symfony\Component\Config\FileLocator());
            return $this->wrapToDelegatingLoader($yamlFileLoader, $containerBuilder);
        }
        if ($suffix === \ConfigTransformer2021083010\Symplify\ConfigTransformer\ValueObject\Format::PHP) {
            $phpFileLoader = new \ConfigTransformer2021083010\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \ConfigTransformer2021083010\Symfony\Component\Config\FileLocator());
            return $this->wrapToDelegatingLoader($phpFileLoader, $containerBuilder);
        }
        throw new \ConfigTransformer2021083010\Symplify\PackageBuilder\Exception\NotImplementedYetException($suffix);
    }
    private function wrapToDelegatingLoader(\ConfigTransformer2021083010\Symfony\Component\Config\Loader\Loader $loader, \ConfigTransformer2021083010\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : \ConfigTransformer2021083010\Symfony\Component\Config\Loader\DelegatingLoader
    {
        $globFileLoader = new \ConfigTransformer2021083010\Symfony\Component\DependencyInjection\Loader\GlobFileLoader($containerBuilder, new \ConfigTransformer2021083010\Symfony\Component\Config\FileLocator());
        $phpFileLoader = new \ConfigTransformer2021083010\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \ConfigTransformer2021083010\Symfony\Component\Config\FileLocator());
        $checkerTolerantYamlFileLoader = new \ConfigTransformer2021083010\Symplify\ConfigTransformer\DependencyInjection\Loader\CheckerTolerantYamlFileLoader($containerBuilder, new \ConfigTransformer2021083010\Symfony\Component\Config\FileLocator());
        return new \ConfigTransformer2021083010\Symfony\Component\Config\Loader\DelegatingLoader(new \ConfigTransformer2021083010\Symfony\Component\Config\Loader\LoaderResolver([$globFileLoader, $phpFileLoader, $checkerTolerantYamlFileLoader, $loader]));
    }
}
