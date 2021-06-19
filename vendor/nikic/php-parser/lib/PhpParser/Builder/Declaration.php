<?php

declare (strict_types=1);
namespace ConfigTransformer202106199\PhpParser\Builder;

use ConfigTransformer202106199\PhpParser;
use ConfigTransformer202106199\PhpParser\BuilderHelpers;
abstract class Declaration implements \ConfigTransformer202106199\PhpParser\Builder
{
    protected $attributes = [];
    public abstract function addStmt($stmt);
    /**
     * Adds multiple statements.
     *
     * @param array $stmts The statements to add
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function addStmts(array $stmts)
    {
        foreach ($stmts as $stmt) {
            $this->addStmt($stmt);
        }
        return $this;
    }
    /**
     * Sets doc comment for the declaration.
     *
     * @param PhpParser\Comment\Doc|string $docComment Doc comment to set
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function setDocComment($docComment)
    {
        $this->attributes['comments'] = [\ConfigTransformer202106199\PhpParser\BuilderHelpers::normalizeDocComment($docComment)];
        return $this;
    }
}
