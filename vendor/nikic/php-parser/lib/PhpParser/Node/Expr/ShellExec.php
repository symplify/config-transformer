<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202501\PhpParser\Node\Expr;

use ConfigTransformerPrefix202501\PhpParser\Node\Expr;
use ConfigTransformerPrefix202501\PhpParser\Node\InterpolatedStringPart;
class ShellExec extends Expr
{
    /** @var (Expr|InterpolatedStringPart)[] Interpolated string array */
    public $parts;
    /**
     * Constructs a shell exec (backtick) node.
     *
     * @param (Expr|InterpolatedStringPart)[] $parts Interpolated string array
     * @param array<string, mixed> $attributes Additional attributes
     */
    public function __construct(array $parts, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->parts = $parts;
    }
    public function getSubNodeNames() : array
    {
        return ['parts'];
    }
    public function getType() : string
    {
        return 'Expr_ShellExec';
    }
}
