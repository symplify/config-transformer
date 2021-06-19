<?php

declare (strict_types=1);
namespace ConfigTransformer202106194\PhpParser\ErrorHandler;

use ConfigTransformer202106194\PhpParser\Error;
use ConfigTransformer202106194\PhpParser\ErrorHandler;
/**
 * Error handler that handles all errors by throwing them.
 *
 * This is the default strategy used by all components.
 */
class Throwing implements \ConfigTransformer202106194\PhpParser\ErrorHandler
{
    public function handleError(\ConfigTransformer202106194\PhpParser\Error $error)
    {
        throw $error;
    }
}
