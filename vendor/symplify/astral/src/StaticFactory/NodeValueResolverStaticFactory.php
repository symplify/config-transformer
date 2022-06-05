<?php

declare (strict_types=1);
namespace ConfigTransformer202206052\Symplify\Astral\StaticFactory;

use ConfigTransformer202206052\PhpParser\NodeFinder;
use ConfigTransformer202206052\Symplify\Astral\NodeFinder\SimpleNodeFinder;
use ConfigTransformer202206052\Symplify\Astral\NodeValue\NodeValueResolver;
use ConfigTransformer202206052\Symplify\PackageBuilder\Php\TypeChecker;
/**
 * @api
 */
final class NodeValueResolverStaticFactory
{
    public static function create() : \ConfigTransformer202206052\Symplify\Astral\NodeValue\NodeValueResolver
    {
        $simpleNameResolver = \ConfigTransformer202206052\Symplify\Astral\StaticFactory\SimpleNameResolverStaticFactory::create();
        $simpleNodeFinder = new \ConfigTransformer202206052\Symplify\Astral\NodeFinder\SimpleNodeFinder(new \ConfigTransformer202206052\PhpParser\NodeFinder());
        return new \ConfigTransformer202206052\Symplify\Astral\NodeValue\NodeValueResolver($simpleNameResolver, new \ConfigTransformer202206052\Symplify\PackageBuilder\Php\TypeChecker(), $simpleNodeFinder);
    }
}
