<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202507\PhpParser\Node\Expr;

use ConfigTransformerPrefix202507\PhpParser\Node\Expr;
class Exit_ extends Expr
{
    /* For use in "kind" attribute */
    public const KIND_EXIT = 1;
    public const KIND_DIE = 2;
    /** @var null|Expr Expression */
    public $expr;
    /**
     * Constructs an exit() node.
     *
     * @param null|Expr $expr Expression
     * @param array<string, mixed> $attributes Additional attributes
     */
    public function __construct(?Expr $expr = null, array $attributes = [])
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
        return 'Expr_Exit';
    }
}
