<?php

declare (strict_types=1);
namespace ConfigTransformer202108235\PhpParser\ErrorHandler;

use ConfigTransformer202108235\PhpParser\Error;
use ConfigTransformer202108235\PhpParser\ErrorHandler;
/**
 * Error handler that handles all errors by throwing them.
 *
 * This is the default strategy used by all components.
 */
class Throwing implements \ConfigTransformer202108235\PhpParser\ErrorHandler
{
    /**
     * @param \PhpParser\Error $error
     */
    public function handleError($error)
    {
        throw $error;
    }
}
