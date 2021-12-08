<?php

declare (strict_types=1);
namespace ConfigTransformer202112086\Symplify\Astral\ValueObject\NodeBuilder;

use ConfigTransformer202112086\PhpParser\Builder\Use_;
use ConfigTransformer202112086\PhpParser\Node\Stmt\Use_ as UseStmt;
/**
 * @api
 * Fixed duplicated naming in php-parser and prevents confusion
 */
final class UseBuilder extends \ConfigTransformer202112086\PhpParser\Builder\Use_
{
    public function __construct($name, int $type = \ConfigTransformer202112086\PhpParser\Node\Stmt\Use_::TYPE_NORMAL)
    {
        parent::__construct($name, $type);
    }
}
