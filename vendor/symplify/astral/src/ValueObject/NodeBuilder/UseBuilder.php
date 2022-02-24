<?php

declare (strict_types=1);
namespace ConfigTransformer2022022410\Symplify\Astral\ValueObject\NodeBuilder;

use ConfigTransformer2022022410\PhpParser\Builder\Use_;
use ConfigTransformer2022022410\PhpParser\Node\Stmt\Use_ as UseStmt;
/**
 * @api
 * Fixed duplicated naming in php-parser and prevents confusion
 */
final class UseBuilder extends \ConfigTransformer2022022410\PhpParser\Builder\Use_
{
    public function __construct($name, int $type = \ConfigTransformer2022022410\PhpParser\Node\Stmt\Use_::TYPE_NORMAL)
    {
        parent::__construct($name, $type);
    }
}
