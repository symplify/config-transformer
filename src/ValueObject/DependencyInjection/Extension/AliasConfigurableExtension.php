<?php

declare (strict_types=1);
namespace ConfigTransformer202205300\Symplify\ConfigTransformer\ValueObject\DependencyInjection\Extension;

use ConfigTransformer202205300\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202205300\Symfony\Component\DependencyInjection\Extension\Extension;
final class AliasConfigurableExtension extends \ConfigTransformer202205300\Symfony\Component\DependencyInjection\Extension\Extension
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
    public function load(array $configs, \ConfigTransformer202205300\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
    }
}
