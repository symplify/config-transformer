<?php

declare (strict_types=1);
namespace ConfigTransformer202108306\PhpParser\Builder;

use ConfigTransformer202108306\PhpParser;
use ConfigTransformer202108306\PhpParser\BuilderHelpers;
use ConfigTransformer202108306\PhpParser\Node;
use ConfigTransformer202108306\PhpParser\Node\Stmt;
class Namespace_ extends \ConfigTransformer202108306\PhpParser\Builder\Declaration
{
    private $name;
    private $stmts = [];
    /**
     * Creates a namespace builder.
     *
     * @param Node\Name|string|null $name Name of the namespace
     */
    public function __construct($name)
    {
        $this->name = null !== $name ? \ConfigTransformer202108306\PhpParser\BuilderHelpers::normalizeName($name) : null;
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
        $this->stmts[] = \ConfigTransformer202108306\PhpParser\BuilderHelpers::normalizeStmt($stmt);
        return $this;
    }
    /**
     * Returns the built node.
     *
     * @return Stmt\Namespace_ The built node
     */
    public function getNode() : \ConfigTransformer202108306\PhpParser\Node
    {
        return new \ConfigTransformer202108306\PhpParser\Node\Stmt\Namespace_($this->name, $this->stmts, $this->attributes);
    }
}
