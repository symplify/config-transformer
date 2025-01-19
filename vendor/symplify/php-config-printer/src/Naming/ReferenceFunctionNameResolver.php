<?php

declare (strict_types=1);
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
    public static function resolve() : string
    {
        if (\function_exists(FunctionName::REF)) {
            return FunctionName::REF;
        }
        // fallback to service
        return FunctionName::SERVICE;
    }
}
