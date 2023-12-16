<?php

declare(strict_types=1);

namespace Symplify\ConfigTransformer;

use Nette\Utils\FileSystem;
use Nette\Utils\Strings;
use Symfony\Component\Config\Exception\LoaderLoadException;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\DelegatingLoader;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\DirectoryLoader;
use Symfony\Component\DependencyInjection\Loader\GlobFileLoader;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\Finder\SplFileInfo;
use Symplify\ConfigTransformer\DependencyInjection\ExtensionFaker;
use Symplify\ConfigTransformer\DependencyInjection\Loader\MissingAutodiscoveryDirectoryTolerantYamlFileLoader;
use Symplify\ConfigTransformer\DependencyInjection\Loader\SkippingPhpFileLoader;
use Symplify\ConfigTransformer\Enum\Format;
use Symplify\ConfigTransformer\Exception\NotImplementedYetException;
use Symplify\ConfigTransformer\ValueObject\ContainerBuilderAndFileContent;

final class ConfigLoader
{
    /**
     * @see https://regex101.com/r/4Uanps/4
     * @var string
     */
    private const PHP_CONST_REGEX = '#!php/const:?\s*([a-zA-Z0-9_\\\\]+(::\w+)?)+(:\s*(.*))?#';

    /**
     * @see https://regex101.com/r/spi4ir/1
     * @var string
     */
    private const UNQUOTED_PARAMETER_REGEX = '#^(\s*\w+:\s+)(\%(.*?)%)(.*?)?$#m';

    public function __construct(
        private readonly ExtensionFaker $extensionFaker
    ) {
    }

    public function createAndLoadContainerBuilderFromFileInfo(
        SplFileInfo $fileInfo,
    ): ContainerBuilderAndFileContent {
        $containerBuilder = new ContainerBuilder();

        $delegatingLoader = $this->createLoaderBySuffix($containerBuilder, $fileInfo->getExtension());
        $fileRealPath = $fileInfo->getRealPath();

        // correct old syntax of tags so we can parse it
        $content = $fileInfo->getContents();

        // fake quoting of parameter, as it was removed in Symfony 3.1: https://symfony.com/blog/new-in-symfony-3-1-yaml-deprecations
        $content = Strings::replace(
            $content,
            self::UNQUOTED_PARAMETER_REGEX,
            static fn (array $match): string => $match[1] . '"' . $match[2] . ($match[4] ?? '') . '"'
        );

        if (in_array($fileInfo->getExtension(), [Format::YML, Format::YAML], true)) {
            $content = Strings::replace(
                $content,
                self::PHP_CONST_REGEX,
                static fn (array $match): string => '"%const(' . str_replace(
                    '\\',
                    '\\\\',
                    (string) $match[1]
                ) . ')%"' . ($match[3] ?? '')
            );
            if ($content !== $fileInfo->getContents()) {
                $fileRealPath = sys_get_temp_dir() . '/__symplify_config_tranformer_clean_yaml/' . $fileInfo->getFilename();
                FileSystem::write($fileRealPath, $content);
            }

            $this->extensionFaker->fakeInContainerBuilder($containerBuilder, $content);
        }

        try {
            $delegatingLoader->load($fileRealPath);
        } catch (LoaderLoadException) {
            // ignore exception for maybe import of non-existing files
            // usefull in gradual upgrade of configs
        }

        return new ContainerBuilderAndFileContent($containerBuilder, $content);
    }

    private function createLoaderBySuffix(ContainerBuilder $containerBuilder, string $suffix): DelegatingLoader
    {
        if (in_array($suffix, [Format::YML, Format::YAML], true)) {
            $missingAutodiscoveryDirectoryTolerantYamlFileLoader = new MissingAutodiscoveryDirectoryTolerantYamlFileLoader(
                $containerBuilder,
                new FileLocator()
            );
            return $this->wrapToDelegatingLoader(
                $missingAutodiscoveryDirectoryTolerantYamlFileLoader,
                $containerBuilder
            );
        }

        if ($suffix === Format::PHP) {
            $phpFileLoader = new PhpFileLoader($containerBuilder, new FileLocator());
            return $this->wrapToDelegatingLoader($phpFileLoader, $containerBuilder);
        }

        throw new NotImplementedYetException($suffix);
    }

    private function wrapToDelegatingLoader(Loader $loader, ContainerBuilder $containerBuilder): DelegatingLoader
    {
        // we need to fake extension before the file gets parsed, as
        $extensionFaker = new ExtensionFaker();
        $extensionFaker->fakeGenericExtensionsInContainerBuilder($containerBuilder);

        $globFileLoader = new GlobFileLoader($containerBuilder, new FileLocator());
        $skippingPhpFileLoader = new SkippingPhpFileLoader($containerBuilder, new FileLocator());

        $directoryLoader = new DirectoryLoader($containerBuilder, new FileLocator());

        return new DelegatingLoader(new LoaderResolver([
            $directoryLoader,
            $globFileLoader,
            $skippingPhpFileLoader,
            $loader,
        ]));
    }
}
