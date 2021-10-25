<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202110251\Symfony\Component\HttpFoundation\File\Exception;

class UnexpectedTypeException extends \ConfigTransformer202110251\Symfony\Component\HttpFoundation\File\Exception\FileException
{
    public function __construct($value, string $expectedType)
    {
        parent::__construct(\sprintf('Expected argument of type %s, %s given', $expectedType, \get_debug_type($value)));
    }
}
