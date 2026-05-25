<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformerPrefix202605\Symfony\Component\VarExporter\Internal;

/**
 * @author Nicolas Grekas <p@tchwork.com>
 *
 * @internal
 */
class NamedClosure
{
    /**
     * @readonly
     * @var mixed[]
     */
    public $callable;
    /**
     * @readonly
     * @var \ReflectionMethod|null
     */
    public $method;
    public function __construct(array $callable, ?\ReflectionMethod $method = null)
    {
        $this->callable = $callable;
        $this->method = $method;
    }
}
