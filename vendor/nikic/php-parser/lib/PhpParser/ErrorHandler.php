<?php

declare (strict_types=1);
namespace ConfigTransformer202106122\PhpParser;

interface ErrorHandler
{
    /**
     * Handle an error generated during lexing, parsing or some other operation.
     *
     * @param Error $error The error that needs to be handled
     */
    public function handleError(\ConfigTransformer202106122\PhpParser\Error $error);
}
