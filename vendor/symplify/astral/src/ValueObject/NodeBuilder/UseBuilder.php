<?php

declare (strict_types=1);
namespace ConfigTransformer202205038\Symplify\Astral\ValueObject\NodeBuilder;

use ConfigTransformer202205038\PhpParser\Builder\Use_;
use ConfigTransformer202205038\PhpParser\Node\Name;
use ConfigTransformer202205038\PhpParser\Node\Stmt\Use_ as UseStmt;
/**
 * @api
 * Fixed duplicated naming in php-parser and prevents confusion
 */
final class UseBuilder extends \ConfigTransformer202205038\PhpParser\Builder\Use_
{
    /**
     * @param \PhpParser\Node\Name|string $name
     */
    public function __construct($name, int $type = \ConfigTransformer202205038\PhpParser\Node\Stmt\Use_::TYPE_NORMAL)
    {
        parent::__construct($name, $type);
    }
}
