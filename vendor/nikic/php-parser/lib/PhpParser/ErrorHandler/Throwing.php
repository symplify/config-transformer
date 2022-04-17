<?php

declare (strict_types=1);
namespace ConfigTransformer202204174\PhpParser\ErrorHandler;

use ConfigTransformer202204174\PhpParser\Error;
use ConfigTransformer202204174\PhpParser\ErrorHandler;
/**
 * Error handler that handles all errors by throwing them.
 *
 * This is the default strategy used by all components.
 */
class Throwing implements \ConfigTransformer202204174\PhpParser\ErrorHandler
{
    public function handleError(\ConfigTransformer202204174\PhpParser\Error $error)
    {
        throw $error;
    }
}
