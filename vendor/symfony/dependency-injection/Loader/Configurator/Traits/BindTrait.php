<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer2022030310\Symfony\Component\DependencyInjection\Loader\Configurator\Traits;

use ConfigTransformer2022030310\Symfony\Component\DependencyInjection\Argument\BoundArgument;
use ConfigTransformer2022030310\Symfony\Component\DependencyInjection\Loader\Configurator\DefaultsConfigurator;
use ConfigTransformer2022030310\Symfony\Component\DependencyInjection\Loader\Configurator\InstanceofConfigurator;
trait BindTrait
{
    /**
     * Sets bindings.
     *
     * Bindings map $named or FQCN arguments to values that should be
     * injected in the matching parameters (of the constructor, of methods
     * called and of controller actions).
     *
     * @param string $nameOrFqcn A parameter name with its "$" prefix, or an FQCN
     * @param mixed  $valueOrRef The value or reference to bind
     *
     * @return $this
     */
    public final function bind(string $nameOrFqcn, $valueOrRef)
    {
        $valueOrRef = static::processValue($valueOrRef, \true);
        $bindings = $this->definition->getBindings();
        $type = $this instanceof \ConfigTransformer2022030310\Symfony\Component\DependencyInjection\Loader\Configurator\DefaultsConfigurator ? \ConfigTransformer2022030310\Symfony\Component\DependencyInjection\Argument\BoundArgument::DEFAULTS_BINDING : ($this instanceof \ConfigTransformer2022030310\Symfony\Component\DependencyInjection\Loader\Configurator\InstanceofConfigurator ? \ConfigTransformer2022030310\Symfony\Component\DependencyInjection\Argument\BoundArgument::INSTANCEOF_BINDING : \ConfigTransformer2022030310\Symfony\Component\DependencyInjection\Argument\BoundArgument::SERVICE_BINDING);
        $bindings[$nameOrFqcn] = new \ConfigTransformer2022030310\Symfony\Component\DependencyInjection\Argument\BoundArgument($valueOrRef, \true, $type, $this->path ?? null);
        $this->definition->setBindings($bindings);
        return $this;
    }
}
