<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\DependencyInjection;

use Migrify\ConfigTransformer\DependencyInjection\Extension\AliasConfigurableExtension;
use Migrify\PhpConfigPrinter\ValueObject\YamlKey;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Yaml;

final class ExtensionFaker
{
    /**
     * @var YamlKey
     */
    private $yamlKey;

    public function __construct(YamlKey $yamlKey)
    {
        $this->yamlKey = $yamlKey;
    }

    public function fakeInContainerBuilder(ContainerBuilder $containerBuilder, string $yamlContent): void
    {
        $yaml = Yaml::parse($yamlContent, Yaml::PARSE_CUSTOM_TAGS);
        // empty file
        if ($yaml === null) {
            return;
        }

        $rootKeys = array_keys($yaml);

        /** @var string[] $extensionKeys */
        $extensionKeys = array_diff($rootKeys, $this->yamlKey->provideRootKeys());
        if ($extensionKeys === []) {
            return;
        }

        foreach ($extensionKeys as $extensionKey) {
            $aliasConfigurableExtension = new AliasConfigurableExtension($extensionKey);
            $containerBuilder->registerExtension($aliasConfigurableExtension);
        }
    }
}
