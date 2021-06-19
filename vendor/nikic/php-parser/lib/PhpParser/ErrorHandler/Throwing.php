<?php

declare (strict_types=1);
namespace ConfigTransformer2021061910\PhpParser\ErrorHandler;

use ConfigTransformer2021061910\PhpParser\Error;
use ConfigTransformer2021061910\PhpParser\ErrorHandler;
/**
 * Error handler that handles all errors by throwing them.
 *
 * This is the default strategy used by all components.
 */
class Throwing implements \ConfigTransformer2021061910\PhpParser\ErrorHandler
{
    public function handleError(\ConfigTransformer2021061910\PhpParser\Error $error)
    {
        throw $error;
    }
}
