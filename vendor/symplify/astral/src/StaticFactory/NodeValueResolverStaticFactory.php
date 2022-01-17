<?php

declare (strict_types=1);
namespace ConfigTransformer202201173\Symplify\Astral\StaticFactory;

use ConfigTransformer202201173\PhpParser\NodeFinder;
use ConfigTransformer202201173\Symplify\Astral\NodeFinder\SimpleNodeFinder;
use ConfigTransformer202201173\Symplify\Astral\NodeValue\NodeValueResolver;
use ConfigTransformer202201173\Symplify\PackageBuilder\Php\TypeChecker;
/**
 * @api
 */
final class NodeValueResolverStaticFactory
{
    public static function create() : \ConfigTransformer202201173\Symplify\Astral\NodeValue\NodeValueResolver
    {
        $simpleNameResolver = \ConfigTransformer202201173\Symplify\Astral\StaticFactory\SimpleNameResolverStaticFactory::create();
        $simpleNodeFinder = new \ConfigTransformer202201173\Symplify\Astral\NodeFinder\SimpleNodeFinder(new \ConfigTransformer202201173\Symplify\PackageBuilder\Php\TypeChecker(), new \ConfigTransformer202201173\PhpParser\NodeFinder());
        return new \ConfigTransformer202201173\Symplify\Astral\NodeValue\NodeValueResolver($simpleNameResolver, new \ConfigTransformer202201173\Symplify\PackageBuilder\Php\TypeChecker(), $simpleNodeFinder);
    }
}
