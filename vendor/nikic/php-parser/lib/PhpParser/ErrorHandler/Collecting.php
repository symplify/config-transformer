<?php

declare (strict_types=1);
namespace ConfigTransformer202109182\PhpParser\ErrorHandler;

use ConfigTransformer202109182\PhpParser\Error;
use ConfigTransformer202109182\PhpParser\ErrorHandler;
/**
 * Error handler that collects all errors into an array.
 *
 * This allows graceful handling of errors.
 */
class Collecting implements \ConfigTransformer202109182\PhpParser\ErrorHandler
{
    /** @var Error[] Collected errors */
    private $errors = [];
    /**
     * @param \PhpParser\Error $error
     */
    public function handleError($error)
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
     *
     * @return bool
     */
    public function hasErrors() : bool
    {
        return !empty($this->errors);
    }
    /**
     * Reset/clear collected errors.
     */
    public function clearErrors()
    {
        $this->errors = [];
    }
}
