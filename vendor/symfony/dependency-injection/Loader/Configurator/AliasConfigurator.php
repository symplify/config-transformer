<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202111133\Symfony\Component\DependencyInjection\Loader\Configurator;

use ConfigTransformer202111133\Symfony\Component\DependencyInjection\Alias;
/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class AliasConfigurator extends \ConfigTransformer202111133\Symfony\Component\DependencyInjection\Loader\Configurator\AbstractServiceConfigurator
{
    use Traits\DeprecateTrait;
    use Traits\PublicTrait;
    public const FACTORY = 'alias';
    public function __construct(\ConfigTransformer202111133\Symfony\Component\DependencyInjection\Loader\Configurator\ServicesConfigurator $parent, \ConfigTransformer202111133\Symfony\Component\DependencyInjection\Alias $alias)
    {
        $this->parent = $parent;
        $this->definition = $alias;
    }
}
