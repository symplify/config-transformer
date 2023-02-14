<?php

declare (strict_types=1);
namespace Symplify\ConfigTransformer\ValueObject\DependencyInjection\Extension;

use ConfigTransformerPrefix202302\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformerPrefix202302\Symfony\Component\DependencyInjection\Extension\Extension;
final class AliasAndNamespaceConfigurableExtension extends Extension
{
    /**
     * @var string
     */
    private $alias;
    /**
     * @var string
     */
    private $namespace;
    public function __construct(string $alias, string $namespace)
    {
        $this->alias = $alias;
        $this->namespace = $namespace;
    }
    public function getAlias() : string
    {
        return $this->alias;
    }
    public function getNamespace() : string
    {
        return $this->namespace;
    }
    /**
     * @param string[] $configs
     */
    public function load(array $configs, ContainerBuilder $containerBuilder) : void
    {
    }
}
