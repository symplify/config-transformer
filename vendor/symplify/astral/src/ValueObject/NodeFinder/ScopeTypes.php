<?php

declare (strict_types=1);
namespace ConfigTransformer2021080510\Symplify\Astral\ValueObject\NodeFinder;

use ConfigTransformer2021080510\PhpParser\Node;
use ConfigTransformer2021080510\PhpParser\Node\Expr\Closure;
use ConfigTransformer2021080510\PhpParser\Node\Stmt\ClassMethod;
use ConfigTransformer2021080510\PhpParser\Node\Stmt\For_;
use ConfigTransformer2021080510\PhpParser\Node\Stmt\Foreach_;
use ConfigTransformer2021080510\PhpParser\Node\Stmt\Function_;
use ConfigTransformer2021080510\PhpParser\Node\Stmt\If_;
use ConfigTransformer2021080510\PhpParser\Node\Stmt\While_;
final class ScopeTypes
{
    /**
     * @var array<class-string<Node>>
     */
    public const STMT_TYPES = [\ConfigTransformer2021080510\PhpParser\Node\Stmt\If_::class, \ConfigTransformer2021080510\PhpParser\Node\Stmt\Foreach_::class, \ConfigTransformer2021080510\PhpParser\Node\Stmt\For_::class, \ConfigTransformer2021080510\PhpParser\Node\Stmt\While_::class, \ConfigTransformer2021080510\PhpParser\Node\Stmt\ClassMethod::class, \ConfigTransformer2021080510\PhpParser\Node\Stmt\Function_::class, \ConfigTransformer2021080510\PhpParser\Node\Expr\Closure::class];
}
