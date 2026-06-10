<?php

declare(strict_types=1);

namespace Symplify\PhpConfigPrinter\Naming;

use Symplify\PhpConfigPrinter\ValueObject\FunctionName;

/**
 * This helped method loads existing functions to refer a service
 * ref() or service() based on the Symfony version of current project
 */
final class ReferenceFunctionNameResolver
{
    /**
     * @return FunctionName::REF|FunctionName::SERVICE
     */
    public static function resolve(): string
    {
        $symfonyFunctionsFile = getcwd() . '/vendor/symfony/symfony/src/Symfony/Component/DependencyInjection/Loader/Configurator/ContainerConfigurator.php';

        if (file_exists($symfonyFunctionsFile)) {
            // this file must be included manually, as composer will only load it once function called
            require_once $symfonyFunctionsFile;
        }

        if (function_exists(FunctionName::REF)) {
            return FunctionName::REF;
        }

        // fallback to service
        return FunctionName::SERVICE;
    }
}
