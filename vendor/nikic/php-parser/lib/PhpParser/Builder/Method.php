<?php

declare (strict_types=1);
namespace ConfigTransformer202202249\PhpParser\Builder;

use ConfigTransformer202202249\PhpParser;
use ConfigTransformer202202249\PhpParser\BuilderHelpers;
use ConfigTransformer202202249\PhpParser\Node;
use ConfigTransformer202202249\PhpParser\Node\Stmt;
class Method extends \ConfigTransformer202202249\PhpParser\Builder\FunctionLike
{
    protected $name;
    protected $flags = 0;
    /** @var array|null */
    protected $stmts = [];
    /** @var Node\AttributeGroup[] */
    protected $attributeGroups = [];
    /**
     * Creates a method builder.
     *
     * @param string $name Name of the method
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }
    /**
     * Makes the method public.
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function makePublic()
    {
        $this->flags = \ConfigTransformer202202249\PhpParser\BuilderHelpers::addModifier($this->flags, \ConfigTransformer202202249\PhpParser\Node\Stmt\Class_::MODIFIER_PUBLIC);
        return $this;
    }
    /**
     * Makes the method protected.
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function makeProtected()
    {
        $this->flags = \ConfigTransformer202202249\PhpParser\BuilderHelpers::addModifier($this->flags, \ConfigTransformer202202249\PhpParser\Node\Stmt\Class_::MODIFIER_PROTECTED);
        return $this;
    }
    /**
     * Makes the method private.
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function makePrivate()
    {
        $this->flags = \ConfigTransformer202202249\PhpParser\BuilderHelpers::addModifier($this->flags, \ConfigTransformer202202249\PhpParser\Node\Stmt\Class_::MODIFIER_PRIVATE);
        return $this;
    }
    /**
     * Makes the method static.
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function makeStatic()
    {
        $this->flags = \ConfigTransformer202202249\PhpParser\BuilderHelpers::addModifier($this->flags, \ConfigTransformer202202249\PhpParser\Node\Stmt\Class_::MODIFIER_STATIC);
        return $this;
    }
    /**
     * Makes the method abstract.
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function makeAbstract()
    {
        if (!empty($this->stmts)) {
            throw new \LogicException('Cannot make method with statements abstract');
        }
        $this->flags = \ConfigTransformer202202249\PhpParser\BuilderHelpers::addModifier($this->flags, \ConfigTransformer202202249\PhpParser\Node\Stmt\Class_::MODIFIER_ABSTRACT);
        $this->stmts = null;
        // abstract methods don't have statements
        return $this;
    }
    /**
     * Makes the method final.
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function makeFinal()
    {
        $this->flags = \ConfigTransformer202202249\PhpParser\BuilderHelpers::addModifier($this->flags, \ConfigTransformer202202249\PhpParser\Node\Stmt\Class_::MODIFIER_FINAL);
        return $this;
    }
    /**
     * Adds a statement.
     *
     * @param Node|PhpParser\Builder $stmt The statement to add
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function addStmt($stmt)
    {
        if (null === $this->stmts) {
            throw new \LogicException('Cannot add statements to an abstract method');
        }
        $this->stmts[] = \ConfigTransformer202202249\PhpParser\BuilderHelpers::normalizeStmt($stmt);
        return $this;
    }
    /**
     * Adds an attribute group.
     *
     * @param Node\Attribute|Node\AttributeGroup $attribute
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function addAttribute($attribute)
    {
        $this->attributeGroups[] = \ConfigTransformer202202249\PhpParser\BuilderHelpers::normalizeAttribute($attribute);
        return $this;
    }
    /**
     * Returns the built method node.
     *
     * @return Stmt\ClassMethod The built method node
     */
    public function getNode() : \ConfigTransformer202202249\PhpParser\Node
    {
        return new \ConfigTransformer202202249\PhpParser\Node\Stmt\ClassMethod($this->name, ['flags' => $this->flags, 'byRef' => $this->returnByRef, 'params' => $this->params, 'returnType' => $this->returnType, 'stmts' => $this->stmts, 'attrGroups' => $this->attributeGroups], $this->attributes);
    }
}
