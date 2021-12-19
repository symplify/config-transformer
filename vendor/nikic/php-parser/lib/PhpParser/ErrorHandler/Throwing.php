<?php

declare (strict_types=1);
namespace ConfigTransformer202112194\PhpParser\ErrorHandler;

use ConfigTransformer202112194\PhpParser\Error;
use ConfigTransformer202112194\PhpParser\ErrorHandler;
/**
 * Error handler that handles all errors by throwing them.
 *
 * This is the default strategy used by all components.
 */
class Throwing implements \ConfigTransformer202112194\PhpParser\ErrorHandler
{
    public function handleError(\ConfigTransformer202112194\PhpParser\Error $error)
    {
        throw $error;
    }
}
