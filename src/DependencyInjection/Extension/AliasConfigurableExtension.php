<?php

declare (strict_types=1);
namespace ConfigTransformer202106118\Symplify\ConfigTransformer\DependencyInjection\Extension;

use ConfigTransformer202106118\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202106118\Symfony\Component\DependencyInjection\Extension\Extension;
final class AliasConfigurableExtension extends \ConfigTransformer202106118\Symfony\Component\DependencyInjection\Extension\Extension
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
     */
    public function load(array $configs, \ConfigTransformer202106118\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
    }
}
