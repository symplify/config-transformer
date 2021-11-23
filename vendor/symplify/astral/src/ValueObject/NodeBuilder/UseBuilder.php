<?php

declare (strict_types=1);
namespace ConfigTransformer202111232\Symplify\Astral\ValueObject\NodeBuilder;

use ConfigTransformer202111232\PhpParser\Builder\Use_;
use ConfigTransformer202111232\PhpParser\Node\Stmt\Use_ as UseStmt;
/**
 * @api
 * Fixed duplicated naming in php-parser and prevents confusion
 */
final class UseBuilder extends \ConfigTransformer202111232\PhpParser\Builder\Use_
{
    public function __construct($name, int $type = \ConfigTransformer202111232\PhpParser\Node\Stmt\Use_::TYPE_NORMAL)
    {
        parent::__construct($name, $type);
    }
}
