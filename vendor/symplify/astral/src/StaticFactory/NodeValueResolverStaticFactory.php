<?php

declare (strict_types=1);
namespace ConfigTransformer202112080\Symplify\Astral\StaticFactory;

use ConfigTransformer202112080\PhpParser\NodeFinder;
use ConfigTransformer202112080\Symplify\Astral\NodeFinder\SimpleNodeFinder;
use ConfigTransformer202112080\Symplify\Astral\NodeValue\NodeValueResolver;
use ConfigTransformer202112080\Symplify\PackageBuilder\Php\TypeChecker;
/**
 * @api
 */
final class NodeValueResolverStaticFactory
{
    public static function create() : \ConfigTransformer202112080\Symplify\Astral\NodeValue\NodeValueResolver
    {
        $simpleNameResolver = \ConfigTransformer202112080\Symplify\Astral\StaticFactory\SimpleNameResolverStaticFactory::create();
        $simpleNodeFinder = new \ConfigTransformer202112080\Symplify\Astral\NodeFinder\SimpleNodeFinder(new \ConfigTransformer202112080\Symplify\PackageBuilder\Php\TypeChecker(), new \ConfigTransformer202112080\PhpParser\NodeFinder());
        return new \ConfigTransformer202112080\Symplify\Astral\NodeValue\NodeValueResolver($simpleNameResolver, new \ConfigTransformer202112080\Symplify\PackageBuilder\Php\TypeChecker(), $simpleNodeFinder);
    }
}
