<?php

declare (strict_types=1);
namespace ConfigTransformer202110101\Symplify\ConfigTransformer\ValueObject\DependencyInjection\Extension;

use ConfigTransformer202110101\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202110101\Symfony\Component\DependencyInjection\Extension\Extension;
final class AliasConfigurableExtension extends \ConfigTransformer202110101\Symfony\Component\DependencyInjection\Extension\Extension
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
