<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202501\PhpParser\Node\Stmt;

use ConfigTransformerPrefix202501\PhpParser\Node;
class For_ extends Node\Stmt
{
    /** @var Node\Expr[] Init expressions */
    public $init;
    /** @var Node\Expr[] Loop conditions */
    public $cond;
    /** @var Node\Expr[] Loop expressions */
    public $loop;
    /** @var Node\Stmt[] Statements */
    public $stmts;
    /**
     * Constructs a for loop node.
     *
     * @param array{
     *     init?: Node\Expr[],
     *     cond?: Node\Expr[],
     *     loop?: Node\Expr[],
     *     stmts?: Node\Stmt[],
     * } $subNodes Array of the following optional subnodes:
     *             'init'  => array(): Init expressions
     *             'cond'  => array(): Loop conditions
     *             'loop'  => array(): Loop expressions
     *             'stmts' => array(): Statements
     * @param array<string, mixed> $attributes Additional attributes
     */
    public function __construct(array $subNodes = [], array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->init = $subNodes['init'] ?? [];
        $this->cond = $subNodes['cond'] ?? [];
        $this->loop = $subNodes['loop'] ?? [];
        $this->stmts = $subNodes['stmts'] ?? [];
    }
    public function getSubNodeNames() : array
    {
        return ['init', 'cond', 'loop', 'stmts'];
    }
    public function getType() : string
    {
        return 'Stmt_For';
    }
}
