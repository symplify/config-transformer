<?php

declare (strict_types=1);
namespace ConfigTransformer202106249\Symplify\PhpConfigPrinter\ValueObject;

final class FunctionName
{
    /**
     * @var string
     */
    public const INLINE_SERVICE = 'ConfigTransformer202106249\\Symfony\\Component\\DependencyInjection\\Loader\\Configurator\\inline_service';
    /**
     * @var string
     */
    public const SERVICE = 'ConfigTransformer202106249\\Symfony\\Component\\DependencyInjection\\Loader\\Configurator\\service';
    /**
     * @var string
     */
    public const REF = 'ConfigTransformer202106249\\Symfony\\Component\\DependencyInjection\\Loader\\Configurator\\ref';
    /**
     * @var string
     */
    public const EXPR = 'ConfigTransformer202106249\\Symfony\\Component\\DependencyInjection\\Loader\\Configurator\\expr';
}
