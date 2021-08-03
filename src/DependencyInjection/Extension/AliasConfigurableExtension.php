<?php

declare (strict_types=1);
namespace ConfigTransformer202108039\Symplify\ConfigTransformer\DependencyInjection\Extension;

use ConfigTransformer202108039\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202108039\Symfony\Component\DependencyInjection\Extension\Extension;
final class AliasConfigurableExtension extends \ConfigTransformer202108039\Symfony\Component\DependencyInjection\Extension\Extension
{
    /**
     * @var string
     */
    private $alias;
    public function __construct(string $alias)
    {
        $this->alias = $alias;
    }
    public function getAlias() : string
    {
        return $this->alias;
    }
    /**
     * @param string[] $configs
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder
     */
    public function load($configs, $containerBuilder) : void
    {
    }
}
