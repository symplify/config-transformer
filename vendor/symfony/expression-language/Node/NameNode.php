<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202107054\Symfony\Component\ExpressionLanguage\Node;

use ConfigTransformer202107054\Symfony\Component\ExpressionLanguage\Compiler;
/**
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @internal
 */
class NameNode extends \ConfigTransformer202107054\Symfony\Component\ExpressionLanguage\Node\Node
{
    public function __construct(string $name)
    {
        parent::__construct([], ['name' => $name]);
    }
    public function compile(\ConfigTransformer202107054\Symfony\Component\ExpressionLanguage\Compiler $compiler)
    {
        $compiler->raw('$' . $this->attributes['name']);
    }
    public function evaluate(array $functions, array $values)
    {
        return $values[$this->attributes['name']];
    }
    public function toArray()
    {
        return [$this->attributes['name']];
    }
}
