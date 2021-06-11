<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Loader\Configurator;

use ConfigTransformer2021061110\Symfony\Component\Config\Loader\ParamConfigurator;
use ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Argument\AbstractArgument;
use ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Argument\IteratorArgument;
use ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Argument\ServiceLocatorArgument;
use ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Argument\TaggedIteratorArgument;
use ConfigTransformer2021061110\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Definition;
use ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use ConfigTransformer2021061110\Symfony\Component\ExpressionLanguage\Expression;
/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class ContainerConfigurator extends \ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Loader\Configurator\AbstractConfigurator
{
    public const FACTORY = 'container';
    private $container;
    private $loader;
    private $instanceof;
    private $path;
    private $file;
    private $anonymousCount = 0;
    private $env;
    public function __construct(\ConfigTransformer2021061110\Symfony\Component\DependencyInjection\ContainerBuilder $container, \ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Loader\PhpFileLoader $loader, array &$instanceof, string $path, string $file, string $env = null)
    {
        $this->container = $container;
        $this->loader = $loader;
        $this->instanceof =& $instanceof;
        $this->path = $path;
        $this->file = $file;
        $this->env = $env;
    }
    public final function extension(string $namespace, array $config)
    {
        if (!$this->container->hasExtension($namespace)) {
            $extensions = \array_filter(\array_map(function (\ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Extension\ExtensionInterface $ext) {
                return $ext->getAlias();
            }, $this->container->getExtensions()));
            throw new \ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException(\sprintf('There is no extension able to load the configuration for "%s" (in "%s"). Looked for namespace "%s", found "%s".', $namespace, $this->file, $namespace, $extensions ? \implode('", "', $extensions) : 'none'));
        }
        $this->container->loadFromExtension($namespace, static::processValue($config));
    }
    public final function import(string $resource, string $type = null, $ignoreErrors = \false)
    {
        $this->loader->setCurrentDir(\dirname($this->path));
        $this->loader->import($resource, $type, $ignoreErrors, $this->file);
    }
    public final function parameters() : \ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Loader\Configurator\ParametersConfigurator
    {
        return new \ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Loader\Configurator\ParametersConfigurator($this->container);
    }
    public final function services() : \ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Loader\Configurator\ServicesConfigurator
    {
        return new \ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Loader\Configurator\ServicesConfigurator($this->container, $this->loader, $this->instanceof, $this->path, $this->anonymousCount);
    }
    /**
     * Get the current environment to be able to write conditional configuration.
     */
    public final function env() : ?string
    {
        return $this->env;
    }
    /**
     * @return static
     */
    public final function withPath(string $path)
    {
        $clone = clone $this;
        $clone->path = $clone->file = $path;
        return $clone;
    }
}
/**
 * Creates a parameter.
 */
function param(string $name) : \ConfigTransformer2021061110\Symfony\Component\Config\Loader\ParamConfigurator
{
    return new \ConfigTransformer2021061110\Symfony\Component\Config\Loader\ParamConfigurator($name);
}
/**
 * Creates a service reference.
 *
 * @deprecated since Symfony 5.1, use service() instead.
 */
function ref(string $id) : \ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Loader\Configurator\ReferenceConfigurator
{
    trigger_deprecation('symfony/dependency-injection', '5.1', '"%s()" is deprecated, use "service()" instead.', __FUNCTION__);
    return new \ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Loader\Configurator\ReferenceConfigurator($id);
}
/**
 * Creates a reference to a service.
 */
function service(string $serviceId) : \ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Loader\Configurator\ReferenceConfigurator
{
    return new \ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Loader\Configurator\ReferenceConfigurator($serviceId);
}
/**
 * Creates an inline service.
 *
 * @deprecated since Symfony 5.1, use inline_service() instead.
 */
function inline(string $class = null) : \ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Loader\Configurator\InlineServiceConfigurator
{
    trigger_deprecation('symfony/dependency-injection', '5.1', '"%s()" is deprecated, use "inline_service()" instead.', __FUNCTION__);
    return new \ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Loader\Configurator\InlineServiceConfigurator(new \ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Definition($class));
}
/**
 * Creates an inline service.
 */
function inline_service(string $class = null) : \ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Loader\Configurator\InlineServiceConfigurator
{
    return new \ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Loader\Configurator\InlineServiceConfigurator(new \ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Definition($class));
}
/**
 * Creates a service locator.
 *
 * @param ReferenceConfigurator[] $values
 */
function service_locator(array $values) : \ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Argument\ServiceLocatorArgument
{
    return new \ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Argument\ServiceLocatorArgument(\ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Loader\Configurator\AbstractConfigurator::processValue($values, \true));
}
/**
 * Creates a lazy iterator.
 *
 * @param ReferenceConfigurator[] $values
 */
function iterator(array $values) : \ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Argument\IteratorArgument
{
    return new \ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Argument\IteratorArgument(\ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Loader\Configurator\AbstractConfigurator::processValue($values, \true));
}
/**
 * Creates a lazy iterator by tag name.
 */
function tagged_iterator(string $tag, string $indexAttribute = null, string $defaultIndexMethod = null, string $defaultPriorityMethod = null) : \ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Argument\TaggedIteratorArgument
{
    return new \ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Argument\TaggedIteratorArgument($tag, $indexAttribute, $defaultIndexMethod, \false, $defaultPriorityMethod);
}
/**
 * Creates a service locator by tag name.
 */
function tagged_locator(string $tag, string $indexAttribute = null, string $defaultIndexMethod = null) : \ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Argument\ServiceLocatorArgument
{
    return new \ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Argument\ServiceLocatorArgument(new \ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Argument\TaggedIteratorArgument($tag, $indexAttribute, $defaultIndexMethod, \true));
}
/**
 * Creates an expression.
 */
function expr(string $expression) : \ConfigTransformer2021061110\Symfony\Component\ExpressionLanguage\Expression
{
    return new \ConfigTransformer2021061110\Symfony\Component\ExpressionLanguage\Expression($expression);
}
/**
 * Creates an abstract argument.
 */
function abstract_arg(string $description) : \ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Argument\AbstractArgument
{
    return new \ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Argument\AbstractArgument($description);
}
/**
 * Creates an environment variable reference.
 */
function env(string $name) : \ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Loader\Configurator\EnvConfigurator
{
    return new \ConfigTransformer2021061110\Symfony\Component\DependencyInjection\Loader\Configurator\EnvConfigurator($name);
}
