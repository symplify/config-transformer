<?php

declare (strict_types=1);
namespace ConfigTransformer202206075\Symplify\ConfigTransformer\DependencyInjection;

use ConfigTransformer202206075\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202206075\Symfony\Component\Yaml\Yaml;
use ConfigTransformer202206075\Symplify\ConfigTransformer\ValueObject\DependencyInjection\Extension\AliasConfigurableExtension;
use ConfigTransformer202206075\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
/**
 * This fakes basic extensions, so loading of config is possible without loading real extensions and booting your whole
 * project
 */
final class ExtensionFaker
{
    public function fakeInContainerBuilder(ContainerBuilder $containerBuilder, string $yamlContent) : void
    {
        $yaml = Yaml::parse($yamlContent, Yaml::PARSE_CUSTOM_TAGS);
        // empty file
        if ($yaml === null) {
            return;
        }
        $rootKeys = \array_keys($yaml);
        /** @var string[] $extensionKeys */
        $extensionKeys = \array_diff($rootKeys, YamlKey::provideRootKeys());
        if ($extensionKeys === []) {
            return;
        }
        foreach ($extensionKeys as $extensionKey) {
            $aliasConfigurableExtension = new AliasConfigurableExtension($extensionKey);
            $containerBuilder->registerExtension($aliasConfigurableExtension);
        }
    }
}
