<?php

declare (strict_types=1);
namespace ConfigTransformer2021083010\PhpParser\Node\Expr;

use ConfigTransformer2021083010\PhpParser\Node\Expr;
class UnaryMinus extends \ConfigTransformer2021083010\PhpParser\Node\Expr
{
    /** @var Expr Expression */
    public $expr;
    /**
     * Constructs a unary minus node.
     *
     * @param Expr  $expr       Expression
     * @param array $attributes Additional attributes
     */
    public function __construct(\ConfigTransformer2021083010\PhpParser\Node\Expr $expr, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->expr = $expr;
    }
    public function getSubNodeNames() : array
    {
        return ['expr'];
    }
    public function getType() : string
    {
        return 'Expr_UnaryMinus';
    }
}
