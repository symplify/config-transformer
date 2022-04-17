<?php

declare (strict_types=1);
namespace ConfigTransformer202204175\Symplify\Astral\NodeValue\NodeValueResolver;

use ConfigTransformer202204175\PhpParser\Node\Expr;
use ConfigTransformer202204175\PhpParser\Node\Expr\ConstFetch;
use ConfigTransformer202204175\Symplify\Astral\Contract\NodeValueResolver\NodeValueResolverInterface;
use ConfigTransformer202204175\Symplify\Astral\Naming\SimpleNameResolver;
/**
 * @see \Symplify\Astral\Tests\NodeValue\NodeValueResolverTest
 *
 * @implements NodeValueResolverInterface<ConstFetch>
 */
final class ConstFetchValueResolver implements \ConfigTransformer202204175\Symplify\Astral\Contract\NodeValueResolver\NodeValueResolverInterface
{
    /**
     * @var \Symplify\Astral\Naming\SimpleNameResolver
     */
    private $simpleNameResolver;
    public function __construct(\ConfigTransformer202204175\Symplify\Astral\Naming\SimpleNameResolver $simpleNameResolver)
    {
        $this->simpleNameResolver = $simpleNameResolver;
    }
    public function getType() : string
    {
        return \ConfigTransformer202204175\PhpParser\Node\Expr\ConstFetch::class;
    }
    /**
     * @param ConstFetch $expr
     * @return mixed
     */
    public function resolve(\ConfigTransformer202204175\PhpParser\Node\Expr $expr, string $currentFilePath)
    {
        $constFetchName = $this->simpleNameResolver->getName($expr);
        if ($constFetchName === null) {
            return null;
        }
        return \constant($constFetchName);
    }
}
