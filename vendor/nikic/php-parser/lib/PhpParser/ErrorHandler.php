<?php

declare (strict_types=1);
namespace ConfigTransformer20210606\PhpParser;

interface ErrorHandler
{
    /**
     * Handle an error generated during lexing, parsing or some other operation.
     *
     * @param Error $error The error that needs to be handled
     */
    public function handleError(\ConfigTransformer20210606\PhpParser\Error $error);
}
