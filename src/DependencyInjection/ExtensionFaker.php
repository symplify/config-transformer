<?php

declare (strict_types=1);
namespace ConfigTransformer202205134\Symplify\ConfigTransformer\DependencyInjection;

use ConfigTransformer202205134\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202205134\Symfony\Component\Yaml\Yaml;
use ConfigTransformer202205134\Symplify\ConfigTransformer\ValueObject\DependencyInjection\Extension\AliasConfigurableExtension;
use ConfigTransformer202205134\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
/**
 * This fakes basic extensions, so loading of config is possible without loading real extensions and booting your whole
 * project
 */
final class ExtensionFaker
{
    public function fakeInContainerBuilder(\ConfigTransformer202205134\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $yamlContent) : void
    {
        $yaml = \ConfigTransformer202205134\Symfony\Component\Yaml\Yaml::parse($yamlContent, \ConfigTransformer202205134\Symfony\Component\Yaml\Yaml::PARSE_CUSTOM_TAGS);
        // empty file
        if ($yaml === null) {
            return;
        }
        $rootKeys = \array_keys($yaml);
        /** @var string[] $extensionKeys */
        $extensionKeys = \array_diff($rootKeys, \ConfigTransformer202205134\Symplify\PhpConfigPrinter\ValueObject\YamlKey::provideRootKeys());
        if ($extensionKeys === []) {
            return;
        }
        foreach ($extensionKeys as $extensionKey) {
            $aliasConfigurableExtension = new \ConfigTransformer202205134\Symplify\ConfigTransformer\ValueObject\DependencyInjection\Extension\AliasConfigurableExtension($extensionKey);
            $containerBuilder->registerExtension($aliasConfigurableExtension);
        }
    }
}
