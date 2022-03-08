<?php

declare (strict_types=1);
namespace ConfigTransformer202203085\Symplify\ConfigTransformer\ValueObject\DependencyInjection\Extension;

use ConfigTransformer202203085\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202203085\Symfony\Component\DependencyInjection\Extension\Extension;
final class AliasConfigurableExtension extends \ConfigTransformer202203085\Symfony\Component\DependencyInjection\Extension\Extension
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
    public function load(array $configs, \ConfigTransformer202203085\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
    }
}
