<?php

declare (strict_types=1);
namespace ConfigTransformer202109220\Symplify\Astral\ValueObject\NodeBuilder;

use ConfigTransformer202109220\PhpParser\Builder\Use_;
use ConfigTransformer202109220\PhpParser\Node\Stmt\Use_ as UseStmt;
/**
 * Fixed duplicated naming in php-parser and prevents confusion
 */
final class UseBuilder extends \ConfigTransformer202109220\PhpParser\Builder\Use_
{
    public function __construct($name, int $type = \ConfigTransformer202109220\PhpParser\Node\Stmt\Use_::TYPE_NORMAL)
    {
        parent::__construct($name, $type);
    }
}
