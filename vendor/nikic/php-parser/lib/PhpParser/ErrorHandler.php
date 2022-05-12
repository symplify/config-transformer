<?php

declare (strict_types=1);
namespace ConfigTransformer202205121\PhpParser;

interface ErrorHandler
{
    /**
     * Handle an error generated during lexing, parsing or some other operation.
     *
     * @param Error $error The error that needs to be handled
     */
    public function handleError(\ConfigTransformer202205121\PhpParser\Error $error);
}
