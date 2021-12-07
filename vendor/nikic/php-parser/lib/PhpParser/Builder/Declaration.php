<?php

declare (strict_types=1);
namespace ConfigTransformer2021120710\PhpParser\Builder;

use ConfigTransformer2021120710\PhpParser;
use ConfigTransformer2021120710\PhpParser\BuilderHelpers;
abstract class Declaration implements \ConfigTransformer2021120710\PhpParser\Builder
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
    public function addStmts($stmts)
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
        $this->attributes['comments'] = [\ConfigTransformer2021120710\PhpParser\BuilderHelpers::normalizeDocComment($docComment)];
        return $this;
    }
}
