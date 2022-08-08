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
use ConfigTransformer202208\Symplify\Astral\NodeValue\NodeValueResolver\ClassConstFetchValueResolver;
use ConfigTransformer202208\Symplify\Astral\NodeValue\NodeValueResolver\ConstFetchValueResolver;
use ConfigTransformer202208\Symplify\Astral\NodeValue\NodeValueResolver\FuncCallValueResolver;
use ConfigTransformer202208\Symplify\Astral\NodeValue\NodeValueResolver\MagicConstValueResolver;
/**
 * @api
 * @see \Symplify\Astral\Tests\NodeValue\NodeValueResolverTest
 */
final class NodeValueResolver
{
    /**
     * @var array<class-string<Expr>>
     */
    private const UNRESOLVABLE_TYPES = [Variable::class, Cast::class, MethodCall::class, PropertyFetch::class, Instanceof_::class];
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
    public function __construct()
    {
        $this->constExprEvaluator = new ConstExprEvaluator(function (Expr $expr) {
            return $this->resolveByNode($expr);
        });
        $this->nodeValueResolvers[] = new ClassConstFetchValueResolver();
        $this->nodeValueResolvers[] = new ConstFetchValueResolver();
        $this->nodeValueResolvers[] = new MagicConstValueResolver();
        $this->nodeValueResolvers[] = new FuncCallValueResolver($this->constExprEvaluator);
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
        foreach (self::UNRESOLVABLE_TYPES as $unresolvableType) {
            if (\is_a($expr, $unresolvableType, \true)) {
                throw new ConstExprEvaluationException('The node "%s" value is not possible to resolve. Provide different one.');
            }
        }
        return null;
    }
}
