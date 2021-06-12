<?php

declare (strict_types=1);
namespace ConfigTransformer2021061210\Symplify\ConfigTransformer\DependencyInjection\Extension;

use ConfigTransformer2021061210\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer2021061210\Symfony\Component\DependencyInjection\Extension\Extension;
final class AliasConfigurableExtension extends \ConfigTransformer2021061210\Symfony\Component\DependencyInjection\Extension\Extension
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
    public function load(array $configs, \ConfigTransformer2021061210\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
    }
}
