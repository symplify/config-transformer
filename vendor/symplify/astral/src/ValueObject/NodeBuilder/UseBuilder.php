<?php

declare (strict_types=1);
namespace ConfigTransformer202203029\Symplify\Astral\ValueObject\NodeBuilder;

use ConfigTransformer202203029\PhpParser\Builder\Use_;
use ConfigTransformer202203029\PhpParser\Node\Stmt\Use_ as UseStmt;
/**
 * @api
 * Fixed duplicated naming in php-parser and prevents confusion
 */
final class UseBuilder extends \ConfigTransformer202203029\PhpParser\Builder\Use_
{
    public function __construct($name, int $type = \ConfigTransformer202203029\PhpParser\Node\Stmt\Use_::TYPE_NORMAL)
    {
        parent::__construct($name, $type);
    }
}
