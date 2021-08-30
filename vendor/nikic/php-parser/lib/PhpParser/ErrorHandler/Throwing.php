<?php

declare (strict_types=1);
namespace ConfigTransformer2021083010\PhpParser\ErrorHandler;

use ConfigTransformer2021083010\PhpParser\Error;
use ConfigTransformer2021083010\PhpParser\ErrorHandler;
/**
 * Error handler that handles all errors by throwing them.
 *
 * This is the default strategy used by all components.
 */
class Throwing implements \ConfigTransformer2021083010\PhpParser\ErrorHandler
{
    /**
     * @param \PhpParser\Error $error
     */
    public function handleError($error)
    {
        throw $error;
    }
}
