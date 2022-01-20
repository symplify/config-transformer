<?php

declare (strict_types=1);
namespace ConfigTransformer202201202\PhpParser\Node\Expr;

use ConfigTransformer202201202\PhpParser\Node\Expr;
class PreInc extends \ConfigTransformer202201202\PhpParser\Node\Expr
{
    /** @var Expr Variable */
    public $var;
    /**
     * Constructs a pre increment node.
     *
     * @param Expr  $var        Variable
     * @param array $attributes Additional attributes
     */
    public function __construct(\ConfigTransformer202201202\PhpParser\Node\Expr $var, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->var = $var;
    }
    public function getSubNodeNames() : array
    {
        return ['var'];
    }
    public function getType() : string
    {
        return 'Expr_PreInc';
    }
}
