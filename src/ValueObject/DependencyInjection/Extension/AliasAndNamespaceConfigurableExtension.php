<?php

declare (strict_types=1);
namespace ConfigTransformer202201205\Symplify\ConfigTransformer\ValueObject\DependencyInjection\Extension;

use ConfigTransformer202201205\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202201205\Symfony\Component\DependencyInjection\Extension\Extension;
final class AliasAndNamespaceConfigurableExtension extends \ConfigTransformer202201205\Symfony\Component\DependencyInjection\Extension\Extension
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
    public function load(array $configs, \ConfigTransformer202201205\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
    }
}
