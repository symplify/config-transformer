<?php

declare (strict_types=1);
namespace ConfigTransformer202111253\PhpParser\Builder;

use ConfigTransformer202111253\PhpParser;
use ConfigTransformer202111253\PhpParser\BuilderHelpers;
use ConfigTransformer202111253\PhpParser\Node;
use ConfigTransformer202111253\PhpParser\Node\Stmt;
class Function_ extends \ConfigTransformer202111253\PhpParser\Builder\FunctionLike
{
    protected $name;
    protected $stmts = [];
    /** @var Node\AttributeGroup[] */
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
        $this->stmts[] = \ConfigTransformer202111253\PhpParser\BuilderHelpers::normalizeStmt($stmt);
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
        $this->attributeGroups[] = \ConfigTransformer202111253\PhpParser\BuilderHelpers::normalizeAttribute($attribute);
        return $this;
    }
    /**
     * Returns the built function node.
     *
     * @return Stmt\Function_ The built function node
     */
    public function getNode() : \ConfigTransformer202111253\PhpParser\Node
    {
        return new \ConfigTransformer202111253\PhpParser\Node\Stmt\Function_($this->name, ['byRef' => $this->returnByRef, 'params' => $this->params, 'returnType' => $this->returnType, 'stmts' => $this->stmts, 'attrGroups' => $this->attributeGroups], $this->attributes);
    }
}
