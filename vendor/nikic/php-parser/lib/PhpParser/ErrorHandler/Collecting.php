<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202501\PhpParser\ErrorHandler;

use ConfigTransformerPrefix202501\PhpParser\Error;
use ConfigTransformerPrefix202501\PhpParser\ErrorHandler;
/**
 * Error handler that collects all errors into an array.
 *
 * This allows graceful handling of errors.
 */
class Collecting implements ErrorHandler
{
    /** @var Error[] Collected errors */
    private $errors = [];
    public function handleError(Error $error) : void
    {
        $this->errors[] = $error;
    }
    /**
     * Get collected errors.
     *
     * @return Error[]
     */
    public function getErrors() : array
    {
        return $this->errors;
    }
    /**
     * Check whether there are any errors.
     */
    public function hasErrors() : bool
    {
        return !empty($this->errors);
    }
    /**
     * Reset/clear collected errors.
     */
    public function clearErrors() : void
    {
        $this->errors = [];
    }
}
