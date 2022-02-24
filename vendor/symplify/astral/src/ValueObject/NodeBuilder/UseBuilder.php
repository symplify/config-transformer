<?php

declare (strict_types=1);
namespace ConfigTransformer202202248\Symplify\Astral\ValueObject\NodeBuilder;

use ConfigTransformer202202248\PhpParser\Builder\Use_;
use ConfigTransformer202202248\PhpParser\Node\Stmt\Use_ as UseStmt;
/**
 * @api
 * Fixed duplicated naming in php-parser and prevents confusion
 */
final class UseBuilder extends \ConfigTransformer202202248\PhpParser\Builder\Use_
{
    public function __construct($name, int $type = \ConfigTransformer202202248\PhpParser\Node\Stmt\Use_::TYPE_NORMAL)
    {
        parent::__construct($name, $type);
    }
}
