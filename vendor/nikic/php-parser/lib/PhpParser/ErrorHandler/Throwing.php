<?php

declare (strict_types=1);
namespace ConfigTransformer202110022\PhpParser\ErrorHandler;

use ConfigTransformer202110022\PhpParser\Error;
use ConfigTransformer202110022\PhpParser\ErrorHandler;
/**
 * Error handler that handles all errors by throwing them.
 *
 * This is the default strategy used by all components.
 */
class Throwing implements \ConfigTransformer202110022\PhpParser\ErrorHandler
{
    /**
     * @param \PhpParser\Error $error
     */
    public function handleError($error)
    {
        throw $error;
    }
}
