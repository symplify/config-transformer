<?php

declare (strict_types=1);
namespace ConfigTransformer202107135\Symplify\PhpConfigPrinter\ValueObject;

final class FunctionName
{
    /**
     * @var string
     */
    public const INLINE_SERVICE = 'ConfigTransformer202107135\\Symfony\\Component\\DependencyInjection\\Loader\\Configurator\\inline_service';
    /**
     * @var string
     */
    public const SERVICE = 'ConfigTransformer202107135\\Symfony\\Component\\DependencyInjection\\Loader\\Configurator\\service';
    /**
     * @var string
     */
    public const REF = 'ConfigTransformer202107135\\Symfony\\Component\\DependencyInjection\\Loader\\Configurator\\ref';
    /**
     * @var string
     */
    public const EXPR = 'ConfigTransformer202107135\\Symfony\\Component\\DependencyInjection\\Loader\\Configurator\\expr';
    /**
     * @var string
     */
    public const TAGGED_ITERATOR = 'ConfigTransformer202107135\\Symfony\\Component\\DependencyInjection\\Loader\\Configurator\\tagged_iterator';
    /**
     * @var string
     */
    public const TAGGED_LOCATOR = 'ConfigTransformer202107135\\Symfony\\Component\\DependencyInjection\\Loader\\Configurator\\tagged_locator';
}
