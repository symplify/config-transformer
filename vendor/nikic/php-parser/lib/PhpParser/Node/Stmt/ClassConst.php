<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202507\PhpParser\Node\Stmt;

use ConfigTransformerPrefix202507\PhpParser\Modifiers;
use ConfigTransformerPrefix202507\PhpParser\Node;
class ClassConst extends Node\Stmt
{
    /** @var int Modifiers */
    public $flags;
    /** @var Node\Const_[] Constant declarations */
    public $consts;
    /** @var Node\AttributeGroup[] PHP attribute groups */
    public $attrGroups;
    /** @var Node\Identifier|Node\Name|Node\ComplexType|null Type declaration */
    public $type;
    /**
     * Constructs a class const list node.
     *
     * @param Node\Const_[] $consts Constant declarations
     * @param int $flags Modifiers
     * @param array<string, mixed> $attributes Additional attributes
     * @param list<Node\AttributeGroup> $attrGroups PHP attribute groups
     * @param null|Node\Identifier|Node\Name|Node\ComplexType $type Type declaration
     */
    public function __construct(array $consts, int $flags = 0, array $attributes = [], array $attrGroups = [], ?Node $type = null)
    {
        $this->attributes = $attributes;
        $this->flags = $flags;
        $this->consts = $consts;
        $this->attrGroups = $attrGroups;
        $this->type = $type;
    }
    public function getSubNodeNames() : array
    {
        return ['attrGroups', 'flags', 'type', 'consts'];
    }
    /**
     * Whether constant is explicitly or implicitly public.
     */
    public function isPublic() : bool
    {
        return ($this->flags & Modifiers::PUBLIC) !== 0 || ($this->flags & Modifiers::VISIBILITY_MASK) === 0;
    }
    /**
     * Whether constant is protected.
     */
    public function isProtected() : bool
    {
        return (bool) ($this->flags & Modifiers::PROTECTED);
    }
    /**
     * Whether constant is private.
     */
    public function isPrivate() : bool
    {
        return (bool) ($this->flags & Modifiers::PRIVATE);
    }
    /**
     * Whether constant is final.
     */
    public function isFinal() : bool
    {
        return (bool) ($this->flags & Modifiers::FINAL);
    }
    public function getType() : string
    {
        return 'Stmt_ClassConst';
    }
}
