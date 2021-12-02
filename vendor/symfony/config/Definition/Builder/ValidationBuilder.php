<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer2021120210\Symfony\Component\Config\Definition\Builder;

/**
 * This class builds validation conditions.
 *
 * @author Christophe Coevoet <stof@notk.org>
 */
class ValidationBuilder
{
    protected $node;
    public $rules = [];
    public function __construct(\ConfigTransformer2021120210\Symfony\Component\Config\Definition\Builder\NodeDefinition $node)
    {
        $this->node = $node;
    }
    /**
     * Registers a closure to run as normalization or an expression builder to build it if null is provided.
     *
     * @return $this|\Symfony\Component\Config\Definition\Builder\ExprBuilder
     * @param \Closure|null $closure
     */
    public function rule($closure = null)
    {
        if (null !== $closure) {
            $this->rules[] = $closure;
            return $this;
        }
        return $this->rules[] = new \ConfigTransformer2021120210\Symfony\Component\Config\Definition\Builder\ExprBuilder($this->node);
    }
}
