<?php

declare (strict_types=1);
namespace ConfigTransformer202204166\Symplify\Astral\StaticFactory;

use ConfigTransformer202204166\PhpParser\NodeFinder;
use ConfigTransformer202204166\Symplify\Astral\NodeFinder\SimpleNodeFinder;
use ConfigTransformer202204166\Symplify\Astral\NodeValue\NodeValueResolver;
use ConfigTransformer202204166\Symplify\PackageBuilder\Php\TypeChecker;
/**
 * @api
 */
final class NodeValueResolverStaticFactory
{
    public static function create() : \ConfigTransformer202204166\Symplify\Astral\NodeValue\NodeValueResolver
    {
        $simpleNameResolver = \ConfigTransformer202204166\Symplify\Astral\StaticFactory\SimpleNameResolverStaticFactory::create();
        $simpleNodeFinder = new \ConfigTransformer202204166\Symplify\Astral\NodeFinder\SimpleNodeFinder(new \ConfigTransformer202204166\PhpParser\NodeFinder());
        return new \ConfigTransformer202204166\Symplify\Astral\NodeValue\NodeValueResolver($simpleNameResolver, new \ConfigTransformer202204166\Symplify\PackageBuilder\Php\TypeChecker(), $simpleNodeFinder);
    }
}
