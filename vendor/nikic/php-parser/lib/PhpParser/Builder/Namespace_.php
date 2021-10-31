<?php

declare (strict_types=1);
namespace ConfigTransformer202110312\PhpParser\Builder;

use ConfigTransformer202110312\PhpParser;
use ConfigTransformer202110312\PhpParser\BuilderHelpers;
use ConfigTransformer202110312\PhpParser\Node;
use ConfigTransformer202110312\PhpParser\Node\Stmt;
class Namespace_ extends \ConfigTransformer202110312\PhpParser\Builder\Declaration
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
        $this->name = null !== $name ? \ConfigTransformer202110312\PhpParser\BuilderHelpers::normalizeName($name) : null;
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
        $this->stmts[] = \ConfigTransformer202110312\PhpParser\BuilderHelpers::normalizeStmt($stmt);
        return $this;
    }
    /**
     * Returns the built node.
     *
     * @return Stmt\Namespace_ The built node
     */
    public function getNode() : \ConfigTransformer202110312\PhpParser\Node
    {
        return new \ConfigTransformer202110312\PhpParser\Node\Stmt\Namespace_($this->name, $this->stmts, $this->attributes);
    }
}
