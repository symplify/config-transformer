<?php

declare (strict_types=1);
namespace ConfigTransformer202203157\PhpParser\ErrorHandler;

use ConfigTransformer202203157\PhpParser\Error;
use ConfigTransformer202203157\PhpParser\ErrorHandler;
/**
 * Error handler that handles all errors by throwing them.
 *
 * This is the default strategy used by all components.
 */
class Throwing implements \ConfigTransformer202203157\PhpParser\ErrorHandler
{
    public function handleError(\ConfigTransformer202203157\PhpParser\Error $error)
    {
        throw $error;
    }
}
