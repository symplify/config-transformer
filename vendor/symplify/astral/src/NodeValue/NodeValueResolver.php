<?php

declare (strict_types=1);
namespace ConfigTransformer202208\Symplify\Astral\NodeValue;

use ConfigTransformer202208\PhpParser\ConstExprEvaluationException;
use ConfigTransformer202208\PhpParser\ConstExprEvaluator;
use ConfigTransformer202208\PhpParser\Node\Expr;
use ConfigTransformer202208\PhpParser\Node\Expr\Cast;
use ConfigTransformer202208\PhpParser\Node\Expr\Instanceof_;
use ConfigTransformer202208\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202208\PhpParser\Node\Expr\PropertyFetch;
use ConfigTransformer202208\PhpParser\Node\Expr\Variable;
use ConfigTransformer202208\Symplify\Astral\Contract\NodeValueResolver\NodeValueResolverInterface;
use ConfigTransformer202208\Symplify\Astral\Exception\ShouldNotHappenException;
use ConfigTransformer202208\Symplify\Astral\Naming\SimpleNameResolver;
use ConfigTransformer202208\Symplify\Astral\NodeValue\NodeValueResolver\ClassConstFetchValueResolver;
use ConfigTransformer202208\Symplify\Astral\NodeValue\NodeValueResolver\ConstFetchValueResolver;
use ConfigTransformer202208\Symplify\Astral\NodeValue\NodeValueResolver\FuncCallValueResolver;
use ConfigTransformer202208\Symplify\Astral\NodeValue\NodeValueResolver\MagicConstValueResolver;
use ConfigTransformer202208\Symplify\PackageBuilder\Php\TypeChecker;
/**
 * @see \Symplify\Astral\Tests\NodeValue\NodeValueResolverTest
 */
final class NodeValueResolver
{
    /**
     * @var \PhpParser\ConstExprEvaluator
     */
    private $constExprEvaluator;
    /**
     * @var string|null
     */
    private $currentFilePath;
    /**
     * @var NodeValueResolverInterface[]
     */
    private $nodeValueResolvers = [];
    /**
     * @var \Symplify\PackageBuilder\Php\TypeChecker
     */
    private $typeChecker;
    public function __construct(SimpleNameResolver $simpleNameResolver, TypeChecker $typeChecker)
    {
        $this->typeChecker = $typeChecker;
        $this->constExprEvaluator = new ConstExprEvaluator(function (Expr $expr) {
            return $this->resolveByNode($expr);
        });
        $this->nodeValueResolvers[] = new ClassConstFetchValueResolver($simpleNameResolver);
        $this->nodeValueResolvers[] = new ConstFetchValueResolver($simpleNameResolver);
        $this->nodeValueResolvers[] = new MagicConstValueResolver();
        $this->nodeValueResolvers[] = new FuncCallValueResolver($simpleNameResolver, $this->constExprEvaluator);
    }
    /**
     * @return mixed
     */
    public function resolve(Expr $expr, string $filePath)
    {
        $this->currentFilePath = $filePath;
        try {
            return $this->constExprEvaluator->evaluateDirectly($expr);
        } catch (ConstExprEvaluationException $exception) {
            return null;
        }
    }
    /**
     * @return mixed
     */
    private function resolveByNode(Expr $expr)
    {
        if ($this->currentFilePath === null) {
            throw new ShouldNotHappenException();
        }
        foreach ($this->nodeValueResolvers as $nodeValueResolver) {
            if (\is_a($expr, $nodeValueResolver->getType(), \true)) {
                return $nodeValueResolver->resolve($expr, $this->currentFilePath);
            }
        }
        // these values cannot be resolved in reliable way
        if ($this->typeChecker->isInstanceOf($expr, [Variable::class, Cast::class, MethodCall::class, PropertyFetch::class, Instanceof_::class])) {
            throw new ConstExprEvaluationException();
        }
        return null;
    }
}
