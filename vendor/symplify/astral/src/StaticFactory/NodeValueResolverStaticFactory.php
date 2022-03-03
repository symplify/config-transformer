<?php

declare (strict_types=1);
namespace ConfigTransformer202203039\Symplify\Astral\StaticFactory;

use ConfigTransformer202203039\PhpParser\NodeFinder;
use ConfigTransformer202203039\Symplify\Astral\NodeFinder\SimpleNodeFinder;
use ConfigTransformer202203039\Symplify\Astral\NodeValue\NodeValueResolver;
use ConfigTransformer202203039\Symplify\PackageBuilder\Php\TypeChecker;
/**
 * @api
 */
final class NodeValueResolverStaticFactory
{
    public static function create() : \ConfigTransformer202203039\Symplify\Astral\NodeValue\NodeValueResolver
    {
        $simpleNameResolver = \ConfigTransformer202203039\Symplify\Astral\StaticFactory\SimpleNameResolverStaticFactory::create();
        $simpleNodeFinder = new \ConfigTransformer202203039\Symplify\Astral\NodeFinder\SimpleNodeFinder(new \ConfigTransformer202203039\PhpParser\NodeFinder());
        return new \ConfigTransformer202203039\Symplify\Astral\NodeValue\NodeValueResolver($simpleNameResolver, new \ConfigTransformer202203039\Symplify\PackageBuilder\Php\TypeChecker(), $simpleNodeFinder);
    }
}
