<?php

declare (strict_types=1);
namespace ConfigTransformer202106114\PhpParser\Builder;

use ConfigTransformer202106114\PhpParser;
use ConfigTransformer202106114\PhpParser\BuilderHelpers;
use ConfigTransformer202106114\PhpParser\Node\Const_;
use ConfigTransformer202106114\PhpParser\Node\Identifier;
use ConfigTransformer202106114\PhpParser\Node\Stmt;
class ClassConst implements \ConfigTransformer202106114\PhpParser\Builder
{
    protected $flags = 0;
    protected $attributes = [];
    protected $constants = [];
    /**
     * Creates a class constant builder
     *
     * @param string|Identifier                          $name  Name
     * @param Node\Expr|bool|null|int|float|string|array $value Value
     */
    public function __construct($name, $value)
    {
        $this->constants = [new \ConfigTransformer202106114\PhpParser\Node\Const_($name, \ConfigTransformer202106114\PhpParser\BuilderHelpers::normalizeValue($value))];
    }
    /**
     * Add another constant to const group
     *
     * @param string|Identifier                          $name  Name
     * @param Node\Expr|bool|null|int|float|string|array $value Value
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function addConst($name, $value)
    {
        $this->constants[] = new \ConfigTransformer202106114\PhpParser\Node\Const_($name, \ConfigTransformer202106114\PhpParser\BuilderHelpers::normalizeValue($value));
        return $this;
    }
    /**
     * Makes the constant public.
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function makePublic()
    {
        $this->flags = \ConfigTransformer202106114\PhpParser\BuilderHelpers::addModifier($this->flags, \ConfigTransformer202106114\PhpParser\Node\Stmt\Class_::MODIFIER_PUBLIC);
        return $this;
    }
    /**
     * Makes the constant protected.
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function makeProtected()
    {
        $this->flags = \ConfigTransformer202106114\PhpParser\BuilderHelpers::addModifier($this->flags, \ConfigTransformer202106114\PhpParser\Node\Stmt\Class_::MODIFIER_PROTECTED);
        return $this;
    }
    /**
     * Makes the constant private.
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function makePrivate()
    {
        $this->flags = \ConfigTransformer202106114\PhpParser\BuilderHelpers::addModifier($this->flags, \ConfigTransformer202106114\PhpParser\Node\Stmt\Class_::MODIFIER_PRIVATE);
        return $this;
    }
    /**
     * Sets doc comment for the constant.
     *
     * @param PhpParser\Comment\Doc|string $docComment Doc comment to set
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function setDocComment($docComment)
    {
        $this->attributes = ['comments' => [\ConfigTransformer202106114\PhpParser\BuilderHelpers::normalizeDocComment($docComment)]];
        return $this;
    }
    /**
     * Returns the built class node.
     *
     * @return Stmt\ClassConst The built constant node
     */
    public function getNode() : \ConfigTransformer202106114\PhpParser\Node
    {
        return new \ConfigTransformer202106114\PhpParser\Node\Stmt\ClassConst($this->constants, $this->flags, $this->attributes);
    }
}
