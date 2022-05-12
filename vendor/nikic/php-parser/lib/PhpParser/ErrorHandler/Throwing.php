<?php

declare (strict_types=1);
namespace ConfigTransformer202205129\PhpParser\ErrorHandler;

use ConfigTransformer202205129\PhpParser\Error;
use ConfigTransformer202205129\PhpParser\ErrorHandler;
/**
 * Error handler that handles all errors by throwing them.
 *
 * This is the default strategy used by all components.
 */
class Throwing implements \ConfigTransformer202205129\PhpParser\ErrorHandler
{
    public function handleError(\ConfigTransformer202205129\PhpParser\Error $error)
    {
        throw $error;
    }
}
