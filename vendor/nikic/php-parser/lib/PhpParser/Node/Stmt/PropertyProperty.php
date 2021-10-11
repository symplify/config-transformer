<?php

declare (strict_types=1);
namespace ConfigTransformer202110110\PhpParser\Node\Stmt;

use ConfigTransformer202110110\PhpParser\Node;
class PropertyProperty extends \ConfigTransformer202110110\PhpParser\Node\Stmt
{
    /** @var Node\VarLikeIdentifier Name */
    public $name;
    /** @var null|Node\Expr Default */
    public $default;
    /**
     * Constructs a class property node.
     *
     * @param string|Node\VarLikeIdentifier $name       Name
     * @param null|Node\Expr                $default    Default value
     * @param array                         $attributes Additional attributes
     */
    public function __construct($name, \ConfigTransformer202110110\PhpParser\Node\Expr $default = null, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->name = \is_string($name) ? new \ConfigTransformer202110110\PhpParser\Node\VarLikeIdentifier($name) : $name;
        $this->default = $default;
    }
    public function getSubNodeNames() : array
    {
        return ['name', 'default'];
    }
    public function getType() : string
    {
        return 'Stmt_PropertyProperty';
    }
}
