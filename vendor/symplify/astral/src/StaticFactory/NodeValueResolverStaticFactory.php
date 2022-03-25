<?php

declare (strict_types=1);
namespace ConfigTransformer202203257\Symplify\Astral\StaticFactory;

use ConfigTransformer202203257\PhpParser\NodeFinder;
use ConfigTransformer202203257\Symplify\Astral\NodeFinder\SimpleNodeFinder;
use ConfigTransformer202203257\Symplify\Astral\NodeValue\NodeValueResolver;
use ConfigTransformer202203257\Symplify\PackageBuilder\Php\TypeChecker;
/**
 * @api
 */
final class NodeValueResolverStaticFactory
{
    public static function create() : \ConfigTransformer202203257\Symplify\Astral\NodeValue\NodeValueResolver
    {
        $simpleNameResolver = \ConfigTransformer202203257\Symplify\Astral\StaticFactory\SimpleNameResolverStaticFactory::create();
        $simpleNodeFinder = new \ConfigTransformer202203257\Symplify\Astral\NodeFinder\SimpleNodeFinder(new \ConfigTransformer202203257\PhpParser\NodeFinder());
        return new \ConfigTransformer202203257\Symplify\Astral\NodeValue\NodeValueResolver($simpleNameResolver, new \ConfigTransformer202203257\Symplify\PackageBuilder\Php\TypeChecker(), $simpleNodeFinder);
    }
}
