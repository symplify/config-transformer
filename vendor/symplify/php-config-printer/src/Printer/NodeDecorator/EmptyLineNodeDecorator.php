<?php

declare (strict_types=1);
namespace ConfigTransformer2022052210\Symplify\PhpConfigPrinter\Printer\NodeDecorator;

use ConfigTransformer2022052210\PhpParser\Node;
use ConfigTransformer2022052210\PhpParser\Node\Expr\Assign;
use ConfigTransformer2022052210\PhpParser\Node\Expr\Closure;
use ConfigTransformer2022052210\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer2022052210\PhpParser\Node\Stmt;
use ConfigTransformer2022052210\PhpParser\Node\Stmt\Expression;
use ConfigTransformer2022052210\PhpParser\Node\Stmt\Nop;
use ConfigTransformer2022052210\PhpParser\NodeFinder;
use ConfigTransformer2022052210\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
final class EmptyLineNodeDecorator
{
    /**
     * @var \PhpParser\NodeFinder
     */
    private $nodeFinder;
    public function __construct(\ConfigTransformer2022052210\PhpParser\NodeFinder $nodeFinder)
    {
        $this->nodeFinder = $nodeFinder;
    }
    /**
     * @param Node[] $stmts
     */
    public function decorate(array $stmts) : void
    {
        $closure = $this->nodeFinder->findFirstInstanceOf($stmts, \ConfigTransformer2022052210\PhpParser\Node\Expr\Closure::class);
        if (!$closure instanceof \ConfigTransformer2022052210\PhpParser\Node\Expr\Closure) {
            throw new \ConfigTransformer2022052210\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
        }
        $newStmts = [];
        foreach ($closure->stmts as $key => $closureStmt) {
            if ($this->shouldAddEmptyLineBeforeStatement($key, $closureStmt)) {
                $newStmts[] = new \ConfigTransformer2022052210\PhpParser\Node\Stmt\Nop();
            }
            $newStmts[] = $closureStmt;
        }
        $closure->stmts = $newStmts;
    }
    private function shouldAddEmptyLineBeforeStatement(int $key, \ConfigTransformer2022052210\PhpParser\Node\Stmt $stmt) : bool
    {
        // do not add space before first item
        if ($key === 0) {
            return \false;
        }
        if (!$stmt instanceof \ConfigTransformer2022052210\PhpParser\Node\Stmt\Expression) {
            return \false;
        }
        $expr = $stmt->expr;
        if ($expr instanceof \ConfigTransformer2022052210\PhpParser\Node\Expr\Assign) {
            return \true;
        }
        return $expr instanceof \ConfigTransformer2022052210\PhpParser\Node\Expr\MethodCall;
    }
}
