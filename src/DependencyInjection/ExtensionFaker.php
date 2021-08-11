<?php

declare (strict_types=1);
namespace ConfigTransformer202108114\Symplify\ConfigTransformer\DependencyInjection;

use ConfigTransformer202108114\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202108114\Symfony\Component\Yaml\Yaml;
use ConfigTransformer202108114\Symplify\ConfigTransformer\DependencyInjection\Extension\AliasConfigurableExtension;
use ConfigTransformer202108114\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
/**
 * This fakes basic extensions, so loading of config is possible without loading real extensions and booting your whole
 * project
 */
final class ExtensionFaker
{
    /**
     * @var \Symplify\PhpConfigPrinter\ValueObject\YamlKey
     */
    private $yamlKey;
    public function __construct(\ConfigTransformer202108114\Symplify\PhpConfigPrinter\ValueObject\YamlKey $yamlKey)
    {
        $this->yamlKey = $yamlKey;
    }
    public function fakeInContainerBuilder(\ConfigTransformer202108114\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $yamlContent) : void
    {
        $yaml = \ConfigTransformer202108114\Symfony\Component\Yaml\Yaml::parse($yamlContent, \ConfigTransformer202108114\Symfony\Component\Yaml\Yaml::PARSE_CUSTOM_TAGS);
        // empty file
        if ($yaml === null) {
            return;
        }
        $rootKeys = \array_keys($yaml);
        /** @var string[] $extensionKeys */
        $extensionKeys = \array_diff($rootKeys, $this->yamlKey->provideRootKeys());
        if ($extensionKeys === []) {
            return;
        }
        foreach ($extensionKeys as $extensionKey) {
            $aliasConfigurableExtension = new \ConfigTransformer202108114\Symplify\ConfigTransformer\DependencyInjection\Extension\AliasConfigurableExtension($extensionKey);
            $containerBuilder->registerExtension($aliasConfigurableExtension);
        }
    }
}
