<?php

declare (strict_types=1);
namespace ConfigTransformer202204144\Symplify\Astral\ValueObject\NodeBuilder;

use ConfigTransformer202204144\PhpParser\Builder\Use_;
use ConfigTransformer202204144\PhpParser\Node\Name;
use ConfigTransformer202204144\PhpParser\Node\Stmt\Use_ as UseStmt;
/**
 * @api
 * Fixed duplicated naming in php-parser and prevents confusion
 */
final class UseBuilder extends \ConfigTransformer202204144\PhpParser\Builder\Use_
{
    /**
     * @param \PhpParser\Node\Name|string $name
     */
    public function __construct($name, int $type = \ConfigTransformer202204144\PhpParser\Node\Stmt\Use_::TYPE_NORMAL)
    {
        parent::__construct($name, $type);
    }
}
