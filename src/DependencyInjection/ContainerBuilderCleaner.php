<?php

declare (strict_types=1);
namespace ConfigTransformer202201259\Symplify\ConfigTransformer\DependencyInjection;

use ConfigTransformer202201259\Nette\Utils\Strings;
use ConfigTransformer202201259\Psr\Container\ContainerInterface as PsrContainerInterface;
use ConfigTransformer202201259\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202201259\Symfony\Component\DependencyInjection\ContainerInterface;
use ConfigTransformer202201259\Symfony\Component\DependencyInjection\Definition;
use ConfigTransformer202201259\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
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
    public function __construct(\ConfigTransformer202201259\Symplify\PackageBuilder\Reflection\PrivatesAccessor $privatesAccessor)
    {
        $this->privatesAccessor = $privatesAccessor;
    }
    public function cleanContainerBuilder(\ConfigTransformer202201259\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $this->removeSymfonyInternalServices($containerBuilder);
        $this->removeTemporaryAnonymousIds($containerBuilder);
        foreach ($containerBuilder->getDefinitions() as $definition) {
            $this->resolvePolyfillForNameTag($definition);
        }
    }
    private function removeSymfonyInternalServices(\ConfigTransformer202201259\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->removeDefinition('service_container');
        $containerBuilder->removeAlias(\ConfigTransformer202201259\Psr\Container\ContainerInterface::class);
        $containerBuilder->removeAlias(\ConfigTransformer202201259\Symfony\Component\DependencyInjection\ContainerInterface::class);
    }
    private function removeTemporaryAnonymousIds(\ConfigTransformer202201259\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
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
        return (bool) \ConfigTransformer202201259\Nette\Utils\Strings::match($name, self::ANONYMOUS_CLASS_REGEX);
    }
    private function resolvePolyfillForNameTag(\ConfigTransformer202201259\Symfony\Component\DependencyInjection\Definition $definition) : void
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
    /**
     * @param array<string, mixed> $tagValues
     */
    private function shouldSkipNameTagInlining(array $tagValues) : bool
    {
        return $tagValues === [];
    }
}
