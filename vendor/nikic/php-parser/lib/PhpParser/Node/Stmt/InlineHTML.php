<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202501\PhpParser\Node\Stmt;

use ConfigTransformerPrefix202501\PhpParser\Node\Stmt;
class InlineHTML extends Stmt
{
    /** @var string String */
    public $value;
    /**
     * Constructs an inline HTML node.
     *
     * @param string $value String
     * @param array<string, mixed> $attributes Additional attributes
     */
    public function __construct(string $value, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->value = $value;
    }
    public function getSubNodeNames() : array
    {
        return ['value'];
    }
    public function getType() : string
    {
        return 'Stmt_InlineHTML';
    }
}
