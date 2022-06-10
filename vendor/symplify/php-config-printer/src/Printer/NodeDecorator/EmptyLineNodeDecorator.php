<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\Printer\NodeDecorator;

use ConfigTransformer20220610\PhpParser\Node;
use ConfigTransformer20220610\PhpParser\Node\Expr\Assign;
use ConfigTransformer20220610\PhpParser\Node\Expr\Closure;
use ConfigTransformer20220610\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer20220610\PhpParser\Node\Stmt;
use ConfigTransformer20220610\PhpParser\Node\Stmt\Expression;
use ConfigTransformer20220610\PhpParser\Node\Stmt\Nop;
use ConfigTransformer20220610\PhpParser\NodeFinder;
use ConfigTransformer20220610\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
final class EmptyLineNodeDecorator
{
    /**
     * @var \PhpParser\NodeFinder
     */
    private $nodeFinder;
    public function __construct(NodeFinder $nodeFinder)
    {
        $this->nodeFinder = $nodeFinder;
    }
    /**
     * @param Node[] $stmts
     */
    public function decorate(array $stmts) : void
    {
        $closure = $this->nodeFinder->findFirstInstanceOf($stmts, Closure::class);
        if (!$closure instanceof Closure) {
            throw new ShouldNotHappenException();
        }
        $newStmts = [];
        foreach ($closure->stmts as $key => $closureStmt) {
            if ($this->shouldAddEmptyLineBeforeStatement($key, $closureStmt)) {
                $newStmts[] = new Nop();
            }
            $newStmts[] = $closureStmt;
        }
        $closure->stmts = $newStmts;
    }
    private function shouldAddEmptyLineBeforeStatement(int $key, Stmt $stmt) : bool
    {
        // do not add space before first item
        if ($key === 0) {
            return \false;
        }
        if (!$stmt instanceof Expression) {
            return \false;
        }
        $expr = $stmt->expr;
        if ($expr instanceof Assign) {
            return \true;
        }
        return $expr instanceof MethodCall;
    }
}
