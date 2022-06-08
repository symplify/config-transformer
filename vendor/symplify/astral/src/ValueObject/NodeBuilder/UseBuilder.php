<?php

declare (strict_types=1);
namespace ConfigTransformer20220608\Symplify\Astral\ValueObject\NodeBuilder;

use ConfigTransformer20220608\PhpParser\Builder\Use_;
use ConfigTransformer20220608\PhpParser\Node\Name;
use ConfigTransformer20220608\PhpParser\Node\Stmt\Use_ as UseStmt;
/**
 * @api
 * Fixed duplicated naming in php-parser and prevents confusion
 */
final class UseBuilder extends Use_
{
    /**
     * @param \PhpParser\Node\Name|string $name
     */
    public function __construct($name, int $type = UseStmt::TYPE_NORMAL)
    {
        parent::__construct($name, $type);
    }
}
