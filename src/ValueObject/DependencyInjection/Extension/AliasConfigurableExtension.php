<?php

declare (strict_types=1);
namespace Symplify\ConfigTransformer\ValueObject\DependencyInjection\Extension;

use ConfigTransformerPrefix202401\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformerPrefix202401\Symfony\Component\DependencyInjection\Extension\Extension;
final class AliasConfigurableExtension extends Extension
{
    /**
     * @readonly
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
    public function load(array $configs, ContainerBuilder $containerBuilder) : void
    {
    }
}
