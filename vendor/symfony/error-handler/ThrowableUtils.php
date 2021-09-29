<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202109298\Symfony\Component\ErrorHandler;

use ConfigTransformer202109298\Symfony\Component\ErrorHandler\Exception\SilencedErrorContext;
/**
 * @internal
 */
class ThrowableUtils
{
    /**
     * @param SilencedErrorContext|\Throwable
     */
    public static function getSeverity($throwable) : int
    {
        if ($throwable instanceof \ErrorException || $throwable instanceof \ConfigTransformer202109298\Symfony\Component\ErrorHandler\Exception\SilencedErrorContext) {
            return $throwable->getSeverity();
        }
        if ($throwable instanceof \ParseError) {
            return \E_PARSE;
        }
        if ($throwable instanceof \TypeError) {
            return \E_RECOVERABLE_ERROR;
        }
        return \E_ERROR;
    }
}
