<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\Printer\NodeDecorator;

use ConfigTransformerPrefix202401\PhpParser\Node;
use ConfigTransformerPrefix202401\PhpParser\Node\Expr\Assign;
use ConfigTransformerPrefix202401\PhpParser\Node\Expr\Closure;
use ConfigTransformerPrefix202401\PhpParser\Node\Expr\MethodCall;
use ConfigTransformerPrefix202401\PhpParser\Node\Stmt;
use ConfigTransformerPrefix202401\PhpParser\Node\Stmt\Expression;
use ConfigTransformerPrefix202401\PhpParser\Node\Stmt\Nop;
use Symplify\PhpConfigPrinter\Exception\ShouldNotHappenException;
use Symplify\PhpConfigPrinter\NodeFinder\TypeAwareNodeFinder;
final class EmptyLineNodeDecorator
{
    /**
     * @readonly
     * @var \Symplify\PhpConfigPrinter\NodeFinder\TypeAwareNodeFinder
     */
    private $typeAwareNodeFinder;
    public function __construct(TypeAwareNodeFinder $typeAwareNodeFinder)
    {
        $this->typeAwareNodeFinder = $typeAwareNodeFinder;
    }
    /**
     * @param Node[] $stmts
     */
    public function decorate(array $stmts) : void
    {
        $closure = $this->typeAwareNodeFinder->findFirstInstanceOf($stmts, Closure::class);
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
