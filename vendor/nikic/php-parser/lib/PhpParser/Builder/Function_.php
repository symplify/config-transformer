<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202501\PhpParser\Builder;

use ConfigTransformerPrefix202501\PhpParser;
use ConfigTransformerPrefix202501\PhpParser\BuilderHelpers;
use ConfigTransformerPrefix202501\PhpParser\Node;
use ConfigTransformerPrefix202501\PhpParser\Node\Stmt;
class Function_ extends FunctionLike
{
    /**
     * @var string
     */
    protected $name;
    /** @var list<Stmt> */
    protected $stmts = [];
    /** @var list<Node\AttributeGroup> */
    protected $attributeGroups = [];
    /**
     * Creates a function builder.
     *
     * @param string $name Name of the function
     */
    public function __construct(string $name)
    {
        $this->name = $name;
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
        $this->stmts[] = BuilderHelpers::normalizeStmt($stmt);
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
        $this->attributeGroups[] = BuilderHelpers::normalizeAttribute($attribute);
        return $this;
    }
    /**
     * Returns the built function node.
     *
     * @return Stmt\Function_ The built function node
     */
    public function getNode() : Node
    {
        return new Stmt\Function_($this->name, ['byRef' => $this->returnByRef, 'params' => $this->params, 'returnType' => $this->returnType, 'stmts' => $this->stmts, 'attrGroups' => $this->attributeGroups], $this->attributes);
    }
}
