<?php

declare (strict_types=1);
namespace ConfigTransformer202208\Symplify\Astral\NodeValue\NodeValueResolver;

use ConfigTransformer202208\PhpParser\Node\Expr;
use ConfigTransformer202208\PhpParser\Node\Expr\ConstFetch;
use ConfigTransformer202208\PhpParser\Node\Name;
use ConfigTransformer202208\Symplify\Astral\Contract\NodeValueResolver\NodeValueResolverInterface;
/**
 * @see \Symplify\Astral\Tests\NodeValue\NodeValueResolverTest
 *
 * @implements NodeValueResolverInterface<ConstFetch>
 */
final class ConstFetchValueResolver implements NodeValueResolverInterface
{
    public function getType() : string
    {
        return ConstFetch::class;
    }
    /**
     * @param ConstFetch $expr
     * @return mixed
     */
    public function resolve(Expr $expr, string $currentFilePath)
    {
        if (!$expr->name instanceof Name) {
            return null;
        }
        $constFetchName = $expr->name->toString();
        return \constant($constFetchName);
    }
}
