<?php

declare (strict_types=1);
namespace ConfigTransformer20210606\PhpParser\ErrorHandler;

use ConfigTransformer20210606\PhpParser\Error;
use ConfigTransformer20210606\PhpParser\ErrorHandler;
/**
 * Error handler that handles all errors by throwing them.
 *
 * This is the default strategy used by all components.
 */
class Throwing implements \ConfigTransformer20210606\PhpParser\ErrorHandler
{
    public function handleError(\ConfigTransformer20210606\PhpParser\Error $error)
    {
        throw $error;
    }
}
