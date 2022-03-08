<?php

declare (strict_types=1);
namespace ConfigTransformer202203085\Symplify\Astral\NodeValue\NodeValueResolver;

use ConfigTransformer202203085\PhpParser\Node\Expr;
use ConfigTransformer202203085\PhpParser\Node\Expr\ConstFetch;
use ConfigTransformer202203085\Symplify\Astral\Contract\NodeValueResolver\NodeValueResolverInterface;
use ConfigTransformer202203085\Symplify\Astral\Naming\SimpleNameResolver;
/**
 * @see \Symplify\Astral\Tests\NodeValue\NodeValueResolverTest
 *
 * @implements NodeValueResolverInterface<ConstFetch>
 */
final class ConstFetchValueResolver implements \ConfigTransformer202203085\Symplify\Astral\Contract\NodeValueResolver\NodeValueResolverInterface
{
    /**
     * @var \Symplify\Astral\Naming\SimpleNameResolver
     */
    private $simpleNameResolver;
    public function __construct(\ConfigTransformer202203085\Symplify\Astral\Naming\SimpleNameResolver $simpleNameResolver)
    {
        $this->simpleNameResolver = $simpleNameResolver;
    }
    public function getType() : string
    {
        return \ConfigTransformer202203085\PhpParser\Node\Expr\ConstFetch::class;
    }
    /**
     * @param ConstFetch $expr
     * @return mixed
     */
    public function resolve(\ConfigTransformer202203085\PhpParser\Node\Expr $expr, string $currentFilePath)
    {
        $constFetchName = $this->simpleNameResolver->getName($expr);
        if ($constFetchName === null) {
            return null;
        }
        return \constant($constFetchName);
    }
}
