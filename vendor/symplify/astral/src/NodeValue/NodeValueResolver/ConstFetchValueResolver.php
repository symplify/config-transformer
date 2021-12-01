<?php

declare (strict_types=1);
namespace ConfigTransformer202112016\Symplify\Astral\NodeValue\NodeValueResolver;

use ConfigTransformer202112016\PhpParser\Node\Expr;
use ConfigTransformer202112016\PhpParser\Node\Expr\ConstFetch;
use ConfigTransformer202112016\Symplify\Astral\Contract\NodeValueResolver\NodeValueResolverInterface;
use ConfigTransformer202112016\Symplify\Astral\Naming\SimpleNameResolver;
/**
 * @see \Symplify\Astral\Tests\NodeValue\NodeValueResolverTest
 *
 * @implements NodeValueResolverInterface<ConstFetch>
 */
final class ConstFetchValueResolver implements \ConfigTransformer202112016\Symplify\Astral\Contract\NodeValueResolver\NodeValueResolverInterface
{
    /**
     * @var \Symplify\Astral\Naming\SimpleNameResolver
     */
    private $simpleNameResolver;
    public function __construct(\ConfigTransformer202112016\Symplify\Astral\Naming\SimpleNameResolver $simpleNameResolver)
    {
        $this->simpleNameResolver = $simpleNameResolver;
    }
    public function getType() : string
    {
        return \ConfigTransformer202112016\PhpParser\Node\Expr\ConstFetch::class;
    }
    /**
     * @param \PhpParser\Node\Expr $expr
     * @return null|mixed
     * @param string $currentFilePath
     */
    public function resolve($expr, $currentFilePath)
    {
        $constFetchName = $this->simpleNameResolver->getName($expr);
        if ($constFetchName === null) {
            return null;
        }
        return \constant($constFetchName);
    }
}
