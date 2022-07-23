<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\ValueObject;

/**
 * @api
 */
final class FunctionName
{
    /**
     * @var string
     */
    public const INLINE_SERVICE = 'ConfigTransformer202207\\Symfony\\Component\\DependencyInjection\\Loader\\Configurator\\inline_service';
    /**
     * @var string
     */
    public const SERVICE = 'ConfigTransformer202207\\Symfony\\Component\\DependencyInjection\\Loader\\Configurator\\service';
    /**
     * @var string
     */
    public const EXPR = 'ConfigTransformer202207\\Symfony\\Component\\DependencyInjection\\Loader\\Configurator\\expr';
    /**
     * @var string
     */
    public const TAGGED_ITERATOR = 'ConfigTransformer202207\\Symfony\\Component\\DependencyInjection\\Loader\\Configurator\\tagged_iterator';
    /**
     * @var string
     */
    public const TAGGED_LOCATOR = 'ConfigTransformer202207\\Symfony\\Component\\DependencyInjection\\Loader\\Configurator\\tagged_locator';
}
