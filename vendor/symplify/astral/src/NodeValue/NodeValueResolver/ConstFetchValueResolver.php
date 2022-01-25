<?php

declare (strict_types=1);
namespace ConfigTransformer2022012510\Symplify\Astral\NodeValue\NodeValueResolver;

use ConfigTransformer2022012510\PhpParser\Node\Expr;
use ConfigTransformer2022012510\PhpParser\Node\Expr\ConstFetch;
use ConfigTransformer2022012510\Symplify\Astral\Contract\NodeValueResolver\NodeValueResolverInterface;
use ConfigTransformer2022012510\Symplify\Astral\Naming\SimpleNameResolver;
/**
 * @see \Symplify\Astral\Tests\NodeValue\NodeValueResolverTest
 *
 * @implements NodeValueResolverInterface<ConstFetch>
 */
final class ConstFetchValueResolver implements \ConfigTransformer2022012510\Symplify\Astral\Contract\NodeValueResolver\NodeValueResolverInterface
{
    /**
     * @var \Symplify\Astral\Naming\SimpleNameResolver
     */
    private $simpleNameResolver;
    public function __construct(\ConfigTransformer2022012510\Symplify\Astral\Naming\SimpleNameResolver $simpleNameResolver)
    {
        $this->simpleNameResolver = $simpleNameResolver;
    }
    public function getType() : string
    {
        return \ConfigTransformer2022012510\PhpParser\Node\Expr\ConstFetch::class;
    }
    /**
     * @param ConstFetch $expr
     * @return null|mixed
     */
    public function resolve(\ConfigTransformer2022012510\PhpParser\Node\Expr $expr, string $currentFilePath)
    {
        $constFetchName = $this->simpleNameResolver->getName($expr);
        if ($constFetchName === null) {
            return null;
        }
        return \constant($constFetchName);
    }
}
