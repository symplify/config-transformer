<?php

declare (strict_types=1);
namespace ConfigTransformer202111133\Symplify\PhpConfigPrinter\Printer\NodeDecorator;

use ConfigTransformer202111133\PhpParser\Node;
use ConfigTransformer202111133\PhpParser\Node\Expr\Assign;
use ConfigTransformer202111133\PhpParser\Node\Expr\Closure;
use ConfigTransformer202111133\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202111133\PhpParser\Node\Stmt;
use ConfigTransformer202111133\PhpParser\Node\Stmt\Expression;
use ConfigTransformer202111133\PhpParser\Node\Stmt\Nop;
use ConfigTransformer202111133\PhpParser\NodeFinder;
use ConfigTransformer202111133\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
final class EmptyLineNodeDecorator
{
    /**
     * @var \PhpParser\NodeFinder
     */
    private $nodeFinder;
    public function __construct(\ConfigTransformer202111133\PhpParser\NodeFinder $nodeFinder)
    {
        $this->nodeFinder = $nodeFinder;
    }
    /**
     * @param Node[] $stmts
     */
    public function decorate(array $stmts) : void
    {
        $closure = $this->nodeFinder->findFirstInstanceOf($stmts, \ConfigTransformer202111133\PhpParser\Node\Expr\Closure::class);
        if (!$closure instanceof \ConfigTransformer202111133\PhpParser\Node\Expr\Closure) {
            throw new \ConfigTransformer202111133\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
        }
        $newStmts = [];
        foreach ($closure->stmts as $key => $closureStmt) {
            if ($this->shouldAddEmptyLineBeforeStatement($key, $closureStmt)) {
                $newStmts[] = new \ConfigTransformer202111133\PhpParser\Node\Stmt\Nop();
            }
            $newStmts[] = $closureStmt;
        }
        $closure->stmts = $newStmts;
    }
    private function shouldAddEmptyLineBeforeStatement(int $key, \ConfigTransformer202111133\PhpParser\Node\Stmt $stmt) : bool
    {
        // do not add space before first item
        if ($key === 0) {
            return \false;
        }
        if (!$stmt instanceof \ConfigTransformer202111133\PhpParser\Node\Stmt\Expression) {
            return \false;
        }
        $expr = $stmt->expr;
        if ($expr instanceof \ConfigTransformer202111133\PhpParser\Node\Expr\Assign) {
            return \true;
        }
        return $expr instanceof \ConfigTransformer202111133\PhpParser\Node\Expr\MethodCall;
    }
}
