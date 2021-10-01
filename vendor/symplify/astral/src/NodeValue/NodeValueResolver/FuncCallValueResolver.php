<?php

declare (strict_types=1);
namespace ConfigTransformer2021100110\Symplify\Astral\NodeValue\NodeValueResolver;

use ConfigTransformer2021100110\PhpParser\ConstExprEvaluator;
use ConfigTransformer2021100110\PhpParser\Node\Expr;
use ConfigTransformer2021100110\PhpParser\Node\Expr\FuncCall;
use ConfigTransformer2021100110\PhpParser\Node\Name;
use ConfigTransformer2021100110\Symplify\Astral\Contract\NodeValueResolver\NodeValueResolverInterface;
use ConfigTransformer2021100110\Symplify\Astral\Exception\ShouldNotHappenException;
use ConfigTransformer2021100110\Symplify\Astral\Naming\SimpleNameResolver;
/**
 * @see \Symplify\Astral\Tests\NodeValue\NodeValueResolverTest
 *
 * @implements NodeValueResolverInterface<FuncCall>
 */
final class FuncCallValueResolver implements \ConfigTransformer2021100110\Symplify\Astral\Contract\NodeValueResolver\NodeValueResolverInterface
{
    /**
     * @var \Symplify\Astral\Naming\SimpleNameResolver
     */
    private $simpleNameResolver;
    /**
     * @var \PhpParser\ConstExprEvaluator
     */
    private $constExprEvaluator;
    public function __construct(\ConfigTransformer2021100110\Symplify\Astral\Naming\SimpleNameResolver $simpleNameResolver, \ConfigTransformer2021100110\PhpParser\ConstExprEvaluator $constExprEvaluator)
    {
        $this->simpleNameResolver = $simpleNameResolver;
        $this->constExprEvaluator = $constExprEvaluator;
    }
    public function getType() : string
    {
        return \ConfigTransformer2021100110\PhpParser\Node\Expr\FuncCall::class;
    }
    /**
     * @param \PhpParser\Node\Expr $expr
     * @return mixed
     * @param string $currentFilePath
     */
    public function resolve($expr, $currentFilePath)
    {
        if ($this->simpleNameResolver->isName($expr, 'getcwd')) {
            return \dirname($currentFilePath);
        }
        $args = $expr->args;
        $arguments = [];
        foreach ($args as $arg) {
            $arguments[] = $this->constExprEvaluator->evaluateDirectly($arg->value);
        }
        if ($expr->name instanceof \ConfigTransformer2021100110\PhpParser\Node\Name) {
            $functionName = (string) $expr->name;
            if (\function_exists($functionName) && \is_callable($functionName)) {
                return \call_user_func_array($functionName, $arguments);
            }
            throw new \ConfigTransformer2021100110\Symplify\Astral\Exception\ShouldNotHappenException();
        }
        return null;
    }
}
