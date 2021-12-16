<?php

declare (strict_types=1);
namespace ConfigTransformer202112160\PhpParser\Builder;

use ConfigTransformer202112160\PhpParser;
use ConfigTransformer202112160\PhpParser\BuilderHelpers;
abstract class Declaration implements \ConfigTransformer202112160\PhpParser\Builder
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
        $this->attributes['comments'] = [\ConfigTransformer202112160\PhpParser\BuilderHelpers::normalizeDocComment($docComment)];
        return $this;
    }
}
