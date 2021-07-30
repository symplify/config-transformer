<?php

declare (strict_types=1);
namespace ConfigTransformer202107300\PhpParser\ErrorHandler;

use ConfigTransformer202107300\PhpParser\Error;
use ConfigTransformer202107300\PhpParser\ErrorHandler;
/**
 * Error handler that handles all errors by throwing them.
 *
 * This is the default strategy used by all components.
 */
class Throwing implements \ConfigTransformer202107300\PhpParser\ErrorHandler
{
    /**
     * @param \PhpParser\Error $error
     */
    public function handleError($error)
    {
        throw $error;
    }
}
