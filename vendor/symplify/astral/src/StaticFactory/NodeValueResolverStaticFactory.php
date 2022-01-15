<?php

declare (strict_types=1);
namespace ConfigTransformer202201153\Symplify\Astral\StaticFactory;

use ConfigTransformer202201153\PhpParser\NodeFinder;
use ConfigTransformer202201153\Symplify\Astral\NodeFinder\SimpleNodeFinder;
use ConfigTransformer202201153\Symplify\Astral\NodeValue\NodeValueResolver;
use ConfigTransformer202201153\Symplify\PackageBuilder\Php\TypeChecker;
/**
 * @api
 */
final class NodeValueResolverStaticFactory
{
    public static function create() : \ConfigTransformer202201153\Symplify\Astral\NodeValue\NodeValueResolver
    {
        $simpleNameResolver = \ConfigTransformer202201153\Symplify\Astral\StaticFactory\SimpleNameResolverStaticFactory::create();
        $simpleNodeFinder = new \ConfigTransformer202201153\Symplify\Astral\NodeFinder\SimpleNodeFinder(new \ConfigTransformer202201153\Symplify\PackageBuilder\Php\TypeChecker(), new \ConfigTransformer202201153\PhpParser\NodeFinder());
        return new \ConfigTransformer202201153\Symplify\Astral\NodeValue\NodeValueResolver($simpleNameResolver, new \ConfigTransformer202201153\Symplify\PackageBuilder\Php\TypeChecker(), $simpleNodeFinder);
    }
}
