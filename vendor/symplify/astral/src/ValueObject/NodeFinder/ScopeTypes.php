<?php

declare (strict_types=1);
namespace ConfigTransformer202106266\Symplify\Astral\ValueObject\NodeFinder;

use ConfigTransformer202106266\PhpParser\Node;
use ConfigTransformer202106266\PhpParser\Node\Expr\Closure;
use ConfigTransformer202106266\PhpParser\Node\Stmt\ClassMethod;
use ConfigTransformer202106266\PhpParser\Node\Stmt\For_;
use ConfigTransformer202106266\PhpParser\Node\Stmt\Foreach_;
use ConfigTransformer202106266\PhpParser\Node\Stmt\Function_;
use ConfigTransformer202106266\PhpParser\Node\Stmt\If_;
use ConfigTransformer202106266\PhpParser\Node\Stmt\While_;
final class ScopeTypes
{
    /**
     * @var array<class-string<Node>>
     */
    public const STMT_TYPES = [\ConfigTransformer202106266\PhpParser\Node\Stmt\If_::class, \ConfigTransformer202106266\PhpParser\Node\Stmt\Foreach_::class, \ConfigTransformer202106266\PhpParser\Node\Stmt\For_::class, \ConfigTransformer202106266\PhpParser\Node\Stmt\While_::class, \ConfigTransformer202106266\PhpParser\Node\Stmt\ClassMethod::class, \ConfigTransformer202106266\PhpParser\Node\Stmt\Function_::class, \ConfigTransformer202106266\PhpParser\Node\Expr\Closure::class];
}
