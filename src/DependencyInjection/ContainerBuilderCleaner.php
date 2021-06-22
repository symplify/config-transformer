<?php

declare (strict_types=1);
namespace ConfigTransformer2021062210\Symplify\ConfigTransformer\DependencyInjection;

use ConfigTransformer2021062210\Nette\Utils\Strings;
use ConfigTransformer2021062210\Psr\Container\ContainerInterface as PsrContainerInterface;
use ConfigTransformer2021062210\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer2021062210\Symfony\Component\DependencyInjection\ContainerInterface;
use ConfigTransformer2021062210\Symfony\Component\DependencyInjection\Definition;
use ConfigTransformer2021062210\Symplify\ConfigTransformer\Configuration\Configuration;
use ConfigTransformer2021062210\Symplify\ConfigTransformer\ValueObject\SymfonyVersionFeature;
use ConfigTransformer2021062210\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
final class ContainerBuilderCleaner
{
    /**
     * @see https://regex101.com/r/0qo8RA/1
     * @var string
     */
    private const ANONYMOUS_CLASS_REGEX = '#^[\\d]+\\_[\\w]{64}$#';
    /**
     * @var \Symplify\PackageBuilder\Reflection\PrivatesAccessor
     */
    private $privatesAccessor;
    /**
     * @var \Symplify\ConfigTransformer\Configuration\Configuration
     */
    private $configuration;
    public function __construct(\ConfigTransformer2021062210\Symplify\PackageBuilder\Reflection\PrivatesAccessor $privatesAccessor, \ConfigTransformer2021062210\Symplify\ConfigTransformer\Configuration\Configuration $configuration)
    {
        $this->privatesAccessor = $privatesAccessor;
        $this->configuration = $configuration;
    }
    public function cleanContainerBuilder(\ConfigTransformer2021062210\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $this->removeExplicitPrivate($containerBuilder);
        $this->removeSymfonyInternalServices($containerBuilder);
        $this->removeTemporaryAnonymousIds($containerBuilder);
        foreach ($containerBuilder->getDefinitions() as $definition) {
            $this->resolvePolyfillForNameTag($definition);
        }
    }
    private function removeSymfonyInternalServices(\ConfigTransformer2021062210\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->removeDefinition('service_container');
        $containerBuilder->removeAlias(\ConfigTransformer2021062210\Psr\Container\ContainerInterface::class);
        $containerBuilder->removeAlias(\ConfigTransformer2021062210\Symfony\Component\DependencyInjection\ContainerInterface::class);
    }
    private function removeExplicitPrivate(\ConfigTransformer2021062210\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        foreach ($containerBuilder->getDefinitions() as $definition) {
            // remove public: false, by default
            if ($definition->isPublic()) {
                continue;
            }
            $definition->setPrivate(\true);
        }
    }
    private function removeTemporaryAnonymousIds(\ConfigTransformer2021062210\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $definitions = $this->privatesAccessor->getPrivateProperty($containerBuilder, 'definitions');
        foreach ($definitions as $name => $definition) {
            if (!\is_string($name)) {
                continue;
            }
            if (!$this->isGeneratedKeyForAnonymousClass($name)) {
                continue;
            }
            unset($definitions[$name]);
            $definitions[] = $definition;
        }
        $this->privatesAccessor->setPrivateProperty($containerBuilder, 'definitions', $definitions);
    }
    private function isGeneratedKeyForAnonymousClass(string $name) : bool
    {
        return (bool) \ConfigTransformer2021062210\Nette\Utils\Strings::match($name, self::ANONYMOUS_CLASS_REGEX);
    }
    private function resolvePolyfillForNameTag(\ConfigTransformer2021062210\Symfony\Component\DependencyInjection\Definition $definition) : void
    {
        if ($definition->getTags() === []) {
            return;
        }
        $tags = $definition->getTags();
        foreach ($definition->getTags() as $name => $value) {
            /** @var mixed[] $tagValues */
            $tagValues = $value[0];
            if ($this->shouldSkipNameTagInlining($tagValues)) {
                continue;
            }
            unset($tags[$name]);
            $tagValues = [];
            foreach ($value as $singleValue) {
                $singleTag = \array_merge(['name' => $name], $singleValue);
                $tagValues[] = $singleTag;
            }
            $tags[] = $tagValues;
        }
        $definition->setTags($tags);
    }
    private function shouldSkipNameTagInlining(array $tagValues) : bool
    {
        if ($tagValues !== []) {
            return \false;
        }
        return $this->configuration->isAtLeastSymfonyVersion(\ConfigTransformer2021062210\Symplify\ConfigTransformer\ValueObject\SymfonyVersionFeature::TAGS_WITHOUT_NAME);
    }
}
