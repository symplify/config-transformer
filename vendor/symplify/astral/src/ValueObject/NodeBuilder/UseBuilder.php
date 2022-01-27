<?php

declare (strict_types=1);
namespace ConfigTransformer202201274\Symplify\Astral\ValueObject\NodeBuilder;

use ConfigTransformer202201274\PhpParser\Builder\Use_;
use ConfigTransformer202201274\PhpParser\Node\Stmt\Use_ as UseStmt;
/**
 * @api
 * Fixed duplicated naming in php-parser and prevents confusion
 */
final class UseBuilder extends \ConfigTransformer202201274\PhpParser\Builder\Use_
{
    public function __construct($name, int $type = \ConfigTransformer202201274\PhpParser\Node\Stmt\Use_::TYPE_NORMAL)
    {
        parent::__construct($name, $type);
    }
}
