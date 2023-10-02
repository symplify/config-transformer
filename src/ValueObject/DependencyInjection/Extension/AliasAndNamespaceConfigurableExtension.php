<?php

declare (strict_types=1);
namespace Symplify\ConfigTransformer\ValueObject\DependencyInjection\Extension;

use ConfigTransformerPrefix202310\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformerPrefix202310\Symfony\Component\DependencyInjection\Extension\Extension;
final class AliasAndNamespaceConfigurableExtension extends Extension
{
    /**
     * @readonly
     * @var string
     */
    private $alias;
    /**
     * @readonly
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
