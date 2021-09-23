<?php

declare (strict_types=1);
namespace ConfigTransformer202109231\PhpParser\ErrorHandler;

use ConfigTransformer202109231\PhpParser\Error;
use ConfigTransformer202109231\PhpParser\ErrorHandler;
/**
 * Error handler that handles all errors by throwing them.
 *
 * This is the default strategy used by all components.
 */
class Throwing implements \ConfigTransformer202109231\PhpParser\ErrorHandler
{
    /**
     * @param \PhpParser\Error $error
     */
    public function handleError($error)
    {
        throw $error;
    }
}
