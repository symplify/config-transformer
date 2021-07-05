<?php

declare (strict_types=1);
namespace ConfigTransformer202107055\PhpParser\ErrorHandler;

use ConfigTransformer202107055\PhpParser\Error;
use ConfigTransformer202107055\PhpParser\ErrorHandler;
/**
 * Error handler that handles all errors by throwing them.
 *
 * This is the default strategy used by all components.
 */
class Throwing implements \ConfigTransformer202107055\PhpParser\ErrorHandler
{
    public function handleError(\ConfigTransformer202107055\PhpParser\Error $error)
    {
        throw $error;
    }
}
